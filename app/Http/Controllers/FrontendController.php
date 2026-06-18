<?php

    namespace App\Http\Controllers;

    use App\Models\Category;
    use App\Models\CompanyDetails;
    use App\Models\Contact;
    use App\Models\Service;
    use App\Models\Slider;

    use App\Models\AboutPage;
    use App\Models\AboutStat;
    use App\Models\AboutHighlight;
    use App\Models\AboutMilestone;
    use App\Models\AboutValue;
    use App\Models\AboutCert;
    use App\Models\Gallery;
    use App\Models\Estimate;
    use Illuminate\Http\Request;
    use Illuminate\Support\Str;
    use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{

    public function index()
    {
        $slider = Slider::where('status', 1)->latest()->first();
        $services = Service::where('status', 1)
                ->orderBy('serial', 'asc')
                ->get(); 

        return view('frontend.index', compact('slider','services'));
    }

    public function contact()
    {
        $company = CompanyDetails::select([
            'company_name', 'fav_icon', 'google_site_verification', 'footer_content',
            'facebook', 'twitter', 'linkedin', 'website', 'phone1', 'email1',
            'address1', 'address2', 'company_logo', 'copyright', 'google_map',
        ])->first();

        // Fetch 6 services for the Concrete Maintenance panel
        $services = \App\Models\Service::where('status', 1)
            ->orderBy('serial', 'asc')
            ->take(6)
            ->pluck('title');

        // Fetch stats for the panel (matching the seeded data labels)
        $stats = \App\Models\AboutStat::whereIn('label', ['Projects Done', 'Years Experience', 'Satisfaction Rate'])
            ->pluck('number', 'label');

        return view('frontend.contact', compact('company', 'services', 'stats'));
    }

        public function contactStore(Request $request)
    {
        // 1. Honeypot check
        if (!empty($request->website_url)) {
            return back()->with('success', 'Inquiry submitted successfully!');
        }

        // 2. Time-based check
        if ($request->filled('form_loaded_at')) {
            $diff = time() - (int) $request->form_loaded_at;
            if ($diff < 5) {
                return back()->with('error', 'Submission too fast. Please try again.')->withInput();
            }
        }

        // 3. Math CAPTCHA check
        $request->validate([
            'captcha_answer' => 'required|numeric',
        ]);

        if ($request->captcha_answer != session('captcha_result')) {
            return back()->withErrors(['captcha_answer' => 'The math answer is incorrect.'])->withInput();
        }
        session()->forget('captcha_result');

        // 4. Standard Validation
        $request->validate([
            'full_name' => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'phone'     => 'nullable|string|max:50',
            'country'   => 'nullable|string|max:100',
            'message'   => 'nullable|string|max:5000',
            'file'      => 'nullable|mimes:pdf,jpg,jpeg,png,doc,docx|max:10240'
        ]);

        // ===== ANTI-SPAM CHECK 4: Spam keyword filter =====
        $spamKeywords = [
            'рассылк', 'обратитесь', 'seo', 'viagra', 'casino', 'lottery',
            'crypto', 'bitcoin', 'бесплатно', 'заработок', 'продвижени',
            'контактные формы', 'аудитори', 'хороший вариант', 'дешево',
            'telegram', '@', 'http://', 'https://', 'www.',
            'porn', 'dating', 'click here', 'free money', 'качественн'
        ];

        $checkFields = [
            $request->full_name, 
            $request->message, 
            $request->country
        ];

        foreach ($checkFields as $field) {
            if ($field) {
                $fieldLower = mb_strtolower($field);
                foreach ($spamKeywords as $keyword) {
                    if (str_contains($fieldLower, mb_strtolower($keyword))) {
                        // Log the spam attempt
                        \Log::warning('Spam blocked (keyword filter)', [
                            'keyword' => $keyword,
                            'field' => $field,
                            'ip' => $request->ip(),
                            'data' => $request->except(['file', 'g-recaptcha-response', 'website_url', 'form_loaded_at'])
                        ]);
                        // Pretend success so spammer doesn't know
                        return back()->with('success', 'Inquiry submitted successfully!');
                    }
                }
            }
        }

        // ===== ANTI-SPAM CHECK 5: Check for URLs in message =====
        if ($request->message) {
            $urlPattern = '/(http|https|ftp|www\.)/i';
            if (preg_match($urlPattern, $request->message)) {
                \Log::warning('Spam blocked (URL in message)', [
                    'ip' => $request->ip(),
                    'message' => $request->message
                ]);
                return back()->with('success', 'Inquiry submitted successfully!');
            }
        }

        // ===== File Upload =====
        $filePath = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $fileName = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                        .'.'.$file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/contact');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $fileName);

            $filePath = 'uploads/contact/'.$fileName;
        }

        // ===== Store Contact =====
        Contact::create([
            'full_name' => $request->full_name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'country'   => $request->country,
            'message'   => $request->message,
            'file'      => $filePath,
            'status'    => 0
        ]);

        return back()->with('success', 'Inquiry submitted successfully!');
    }

    public function aboutUs()
    {
        $aboutPage   = AboutPage::first();
        
        // Fetch only active items, ordered by sort_order
        $stats       = AboutStat::where('status', 1)->orderBy('sort_order')->get();
        $highlights  = AboutHighlight::where('status', 1)->orderBy('sort_order')->get();
        $milestones  = AboutMilestone::where('status', 1)->orderBy('sort_order')->get();
        $values      = AboutValue::where('status', 1)->orderBy('sort_order')->get();
        $certs       = AboutCert::where('status', 1)->orderBy('sort_order')->get();

        return view('frontend.about', compact(
            'aboutPage', 'stats', 'highlights', 'milestones', 'values', 'certs'
        ));
    }


    public function service()
    {
        $services = Service::where('status', 1)
                    ->orderBy('serial', 'asc')
                    ->get();
        return view('frontend.service', compact('services'));
    }


    public function testimonial()
    {
        $companyDetails = CompanyDetails::first();
        return view('frontend.testimonial', compact('companyDetails'));
    }

    public function gallery()
    {
        $galleries = Gallery::where('status', 1)->get();

        return view('frontend.gallery', compact('galleries'));
    }



    public function storeEstimate(Request $request)
    {
        \Log::info('Estimate request received', [
            'ip' => $request->ip(),
            'input' => $request->except(['_token']),
        ]);

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:50',
            'last_name'  => 'required|string|max:50',
            'phone'      => 'required|string|max:20',
            'email'      => 'nullable|email|max:255',
            'address'    => 'nullable|string|max:500',
            'borough'    => 'nullable|string|in:Manhattan,Brooklyn,Queens,Bronx,Staten Island',
            'service'    => 'required|string|max:255',
            'message'    => 'nullable|string|max:2000',
        ], [
            'first_name.required' => 'First name is required.',
            'last_name.required'  => 'Last name is required.',
            'phone.required'      => 'Phone number is required.',
            'address.required'    => 'Property address is required.',
            'borough.required'    => 'Please select a borough.',
            'service.required'    => 'Please select a service.',
            'email.email'         => 'Please enter a valid email address.',
        ]);

        if ($validator->fails()) {
            \Log::warning('Estimate validation failed', [
                'errors' => $validator->errors()->messages(),
                'input' => $request->except(['_token']),
                'ip' => $request->ip(),
            ]);
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Store Data
        $estimate = Estimate::create([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'address'    => $request->address,
            'borough'    => $request->borough,
            'service'    => $request->service,
            'message'    => $request->message,
            'ip_address' => $request->ip(),
        ]);

        \Log::info('Estimate request stored', [
            'estimate_id' => $estimate->id,
            'ip' => $request->ip(),
        ]);

        \Log::info('Estimate response returned', [
            'estimate_id' => $estimate->id,
            'ip' => $request->ip(),
        ]);

        return response()->json([
            'success' => 'Thank you! Your estimate request has been submitted successfully. We will contact you within 24 hours.'
        ]);
    }



}
