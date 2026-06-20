<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ViolationController extends Controller
{
    /**
     * NYC Open Data App Token
     */
    private $appToken = 'eDwLmhxUWcRNHFyxmVcjaRs7a';

    /**
     * Main check method
     */
    public function check(Request $request)
    {
        // Log the incoming request for debugging
        Log::info('Violation check started', ['address' => $request->query('address')]);

        $address = trim($request->query('address'));

        if (empty($address)) {
            return response()->json(['error' => 'Please enter an address.'], 400);
        }

        $parsed = $this->parseAddress($address);

        if (!$parsed) {
            Log::warning('Address parse failed', ['address' => $address]);
            return response()->json(['error' => 'Could not parse address. Please use format: 123 Main St, Brooklyn, NY'], 400);
        }

        Log::info('Address parsed', ['house' => $parsed['house'], 'street' => $parsed['street']]);

        // Run both checks
        $dotOpenTickets = $this->checkDOT311Tickets($parsed['house'], $parsed['street'], $address);
        $dobComplaints = $this->checkDOBComplaints($parsed['house'], $parsed['street']);

        Log::info('API checks complete', ['dot' => $dotOpenTickets, 'dob' => $dobComplaints]);

        // Calculate Risk Score
        $riskScore = 0;
        $riskDetails = [];

        if ($dotOpenTickets > 0) {
            $riskScore += 60;
            $riskDetails[] = "{$dotOpenTickets} active DOT sidewalk ticket(s) found";
        }

        if ($dobComplaints > 0) {
            $riskScore += 40;
            $riskDetails[] = "{$dobComplaints} active DOB sidewalk complaint(s)";
        }

        // Determine status
        if ($riskScore >= 50) {
            $status = 'danger';
            $statusText = 'High Risk';
            $statusIcon = 'bi-exclamation-triangle-fill';
            $statusColor = 'red';
        } elseif ($riskScore >= 20) {
            $status = 'warning';
            $statusText = 'At Risk';
            $statusIcon = 'bi-exclamation-circle-fill';
            $statusColor = 'amber';
        } else {
            $status = 'success';
            $statusText = 'All Clear';
            $statusIcon = 'bi-check-circle-fill';
            $statusColor = 'green';
        }

        return response()->json([
            'address'         => $address,
            'dot_tickets'     => $dotOpenTickets,
            'dob_complaints'  => $dobComplaints,
            'risk_score'      => $riskScore,
            'risk_details'    => $riskDetails,
            'status'          => $status,
            'status_text'     => $statusText,
            'status_icon'     => $statusIcon,
            'status_color'    => $statusColor,
        ]);
    }

    /**
     * CHECK 1: DOT Sidewalk 311 Tickets (OPEN ONLY)
     */
    private function checkDOT311Tickets($houseNumber, $streetName, $fullAddress)
    {
        try {
            // Extract street part for matching
            $addressParts = explode(',', $fullAddress);
            $streetPart = trim($addressParts[0]);

            // Build query: DOT agency + Sidewalk Condition + NOT Closed
            $url = "https://data.cityofnewyork.us/resource/erm2-nwe9.json?" . http_build_query([
                '$$app_token'    => $this->appToken,
                'agency'         => 'DOT',
                'complaint_type' => 'Sidewalk Condition',
                'incident_address'=> strtoupper($streetPart),
                'status'         => 'Open',
                '$limit'         => 10,
                '$order'         => 'created_date DESC',
            ]);

            Log::info('DOT 311 API call', ['url' => $url]);

            $response = Http::timeout(10)->get($url);
            
            Log::info('DOT 311 response status', ['status' => $response->status()]);
            
            $data = $response->json();

            $openCount = is_array($data) ? count($data) : 0;

            // If no "Open" found, also check "In Progress"
            if ($openCount === 0) {
                $url2 = "https://data.cityofnewyork.us/resource/erm2-nwe9.json?" . http_build_query([
                    '$$app_token'    => $this->appToken,
                    'agency'         => 'DOT',
                    'complaint_type' => 'Sidewalk Condition',
                    'incident_address'=> strtoupper($streetPart),
                    'status'         => 'In Progress',
                    '$limit'         => 10,
                ]);
                
                $response2 = Http::timeout(10)->get($url2);
                $data2 = $response2->json();
                $openCount += is_array($data2) ? count($data2) : 0;
            }

            return $openCount;

        } catch (\Exception $e) {
            Log::error('DOT 311 check failed: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * CHECK 2: DOB Sidewalk Complaints (ACTIVE ONLY)
     */
    private function checkDOBComplaints($houseNumber, $streetName)
    {
        try {
            // REMOVED: 'complaint_category' => '37' 
            // Now it checks for ANY active DOB complaint at this address
            $url = "https://data.cityofnewyork.us/resource/eabe-havv.json?" . http_build_query([
                '$$app_token'       => $this->appToken,
                'house_number'       => $houseNumber,
                'house_street'       => strtoupper($streetName),
                'status'             => 'ACTIVE',
                '$limit'             => 5,
            ]);

            $response = Http::timeout(10)->get($url);
            $data = $response->json();

            // Filter to only count sidewalk-related categories (37 and 45)
            if (is_array($data)) {
                $count = 0;
                foreach ($data as $complaint) {
                    if (in_array($complaint['complaint_category'], ['37', '45'])) {
                        $count++;
                    }
                }
                return $count;
            }

            return 0;

        } catch (\Exception $e) {
            Log::error('DOB check failed: ' . $e->getMessage());
            return 0;
        }
    }

    /**
     * FIXED: Parse address into house number and street name
     * Now handles: "241-19 148 ROAD", "123 Main St", "123 Main St, Brooklyn, NY"
     */
    private function parseAddress($address)
    {
        $address = preg_replace('/\s+/', ' ', trim($address));

        // Pattern 1: Full address with borough "241-19 148 ROAD, QUEENS"
        if (preg_match('/^([\d]+[-\d]*)\s+(.+?)(?:,\s*|\s+(?:BROOKLYN|MANHATTAN|QUEENS|BRONX|STATEN\s*ISLAND|NY|NEW\s*YORK))(.*)$/i', $address, $matches)) {
            return [
                'house'  => $matches[1],
                'street' => trim($matches[2] . ' ' . trim($matches[3])),
            ];
        }

        // Pattern 2: Just "241-19 148 ROAD" (no borough) - NEW!
        if (preg_match('/^([\d]+[-\d]*)\s+(.+)$/i', $address, $matches)) {
            $house = $matches[1];
            $street = trim($matches[2]);
            
            // Remove borough if it's at the end (without comma)
            $street = preg_replace('/\s+(BROOKLYN|MANHATTAN|QUEENS|BRONX|STATEN\s*ISLAND|NY|NEW\s*YORK)$/i', '', $street);
            
            return [
                'house'  => $house,
                'street' => $street,
            ];
        }

        // Pattern 3: Fallback for simple addresses "123 MAIN ST"
        $parts = explode(' ', $address, 2);
        if (count($parts) === 2) {
            // Check if first part starts with a number (handles 241-19 format)
            if (preg_match('/^[\d]+/', $parts[0])) {
                $street = trim($parts[1]);
                $street = preg_replace('/\s+(BROOKLYN|MANHATTAN|QUEENS|BRONX|STATEN\s*ISLAND|NY|NEW\s*YORK)$/i', '', $street);
                
                return [
                    'house'  => $parts[0],
                    'street' => $street,
                ];
            }
        }

        return null;
    }


    
    /**
     * Store the lead and send email notification
     */
        /**
     * Store the lead and send email notification
     */
    public function storeLead(Request $request)
    {
        $validated = $request->validate([
            'address'            => 'required|string|max:255',
            'first_name'         => 'required|string|max:100',
            'phone'              => 'required|string|max:20',
            'email'              => 'required|email|max:255',
            'status'             => 'required|string|in:danger,warning,success',
            'risk_score'         => 'required|integer',
            'dot_tickets_count'  => 'required|integer',
            'dob_complaints_count'=> 'required|integer',
            'risk_details'       => 'nullable|string',
            'api_raw_data'       => 'nullable|string',
        ]);

        // Decode JSON strings back to arrays
        $riskDetails = json_decode($validated['risk_details'], true) ?? [];
        $apiRawData = json_decode($validated['api_raw_data'], true) ?? [];

        // Save to the new leads table
        $lead = Lead::create([
            'address'             => $validated['address'],
            'first_name'          => $validated['first_name'],
            'phone'               => $validated['phone'],
            'email'               => $validated['email'],
            'status'              => $validated['status'],
            'risk_score'          => $validated['risk_score'],
            'dot_tickets_count'   => $validated['dot_tickets_count'],
            'dob_complaints_count'=> $validated['dob_complaints_count'],
            'risk_details'        => $riskDetails,
            'api_raw_data'        => $apiRawData,
        ]);

        // Send Email Notification
        $this->sendLeadNotification($lead); 

        // Return JSON response for AJAX
        return response()->json([
            'success' => true,
            'message' => 'Lead saved successfully',
            'lead_id' => $lead->id,
        ]);
    }
    /**
     * Send formatted email to site owner
     */
    private function sendLeadNotification($lead)
    {
        // !!! CHANGE THIS TO YOUR EMAIL !!!
        $toEmail = 'your-email@example.com'; 

        // Determine Priority Emoji & Text
        if ($lead->status === 'danger') {
            $priority = '🚨 HIGH PRIORITY (Active Issues)';
        } elseif ($lead->status === 'warning') {
            $priority = '⚠️ MEDIUM PRIORITY (At Risk)';
        } else {
            $priority = '✅ LOW PRIORITY (All Clear)';
        }

        // Format the issues found
        $issuesText = "None found.";
        if ($lead->risk_details) {
            $issuesText = "- " . implode("\n- ", $lead->risk_details);
        }

        // Build plain text email (looks great on all devices)
        $body = "NEW SIDEWALK VIOLATION LEAD\n";
        $body .= "==================================================\n\n";
        $body .= "PRIORITY: {$priority}\n";
        $body .= "RISK SCORE: {$lead->risk_score}/100\n\n";
        
        $body .= "PROPERTY DETAILS:\n";
        $body .= "Address: {$lead->address}\n";
        $body .= "Open DOT Tickets: {$lead->dot_tickets_count}\n";
        $body .= "Active DOB Complaints: {$lead->dob_complaints_count}\n";
        $body .= "Issues:\n{$issuesText}\n\n";

        $body .= "CUSTOMER CONTACT INFO:\n";
        $body .= "Name: {$lead->first_name}\n";
        $body .= "Phone: {$lead->phone}\n";
        $body .= "Email: {$lead->email}\n\n";
        
        $body .= "==================================================\n";
        $body .= "Log in to your admin panel to mark this lead as contacted.";

        Mail::raw($body, function ($message) use ($toEmail, $lead) {
            $subject = ($lead->status === 'danger' ? '🚨 HOT LEAD' : '📋 New Lead') . ': ' . $lead->address;
            
            $message->to($toEmail)
                    ->subject($subject);
        });
    }



}