<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
            $url = "https://data.cityofnewyork.us/resource/eabe-havv.json?" . http_build_query([
                '$$app_token'       => $this->appToken,
                'house_number'       => $houseNumber,
                'house_street'       => strtoupper($streetName),
                'complaint_category' => '37',
                'status'             => 'ACTIVE',
                '$limit'             => 5,
            ]);

            Log::info('DOB API call', ['url' => $url]);

            $response = Http::timeout(10)->get($url);
            
            Log::info('DOB response status', ['status' => $response->status()]);
            
            $data = $response->json();

            return is_array($data) ? count($data) : 0;

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
}