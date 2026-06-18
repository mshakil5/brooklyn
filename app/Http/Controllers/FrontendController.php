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
use Illuminate\Http\Request;
    use Illuminate\Support\Str;

class FrontendController extends Controller
{

    public function index()
    {
        $categories = Category::with('products')->where('status', 1)->get();
        $company = CompanyDetails::select([
            'company_name',
            'fav_icon',
            'google_site_verification',
            'footer_content',
            'facebook',
            'twitter',
            'linkedin',
            'website',
            'phone1',
            'email1',
            'address1',
            'address2',
            'company_logo',
            'copyright',
            'google_map',
        ])->first();

        $slider = Slider::where('status', 1)->latest()->first();
        $services = Service::where('status', 1)
                ->orderBy('serial', 'asc')
                ->get(); 

        return view('frontend.index', compact('categories', 'company', 'slider','services'));
    }

    public function contact()
    {
        
        $company = CompanyDetails::select([
            'company_name',
            'fav_icon',
            'google_site_verification',
            'footer_content',
            'facebook',
            'twitter',
            'linkedin',
            'website',
            'phone1',
            'email1',
            'address1',
            'address2',
            'company_logo',
            'copyright',
            'google_map',
        ])->first();

        $num1 = rand(1, 10);
        $num2 = rand(1, 10);
        session(['captcha_result' => $num1 + $num2]);

        return view('frontend.contact', compact('company','num1', 'num2'));
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


}
