<?php

namespace App\Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class PagesController extends Controller
{
    public function __construct(
        protected ContactService $contactService
    ) {}

    public function about()
    {
        $page = Page::where('slug', 'about')->first();

        // SEO Meta Tags
        $seoMeta = [
            'title' => 'About Us - PT Lestari Jaya Bangsa | Food & Herbal Products Since 1992',
            'description' => 'PT Lestari Jaya Bangsa delivers premium herbal and processed food products, combining health and taste in every creation. Established in 1992.',
            'keywords' => 'about us, company profile, herbal products, food products, established 1992',
            'og_title' => 'About Us - PT Lestari Jaya Bangsa',
            'og_description' => 'Premium herbal and processed food products since 1992',
            'og_type' => 'website',
            'og_image' => asset('images/logo.png'),
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.pages.about', compact('page'));
    }

    public function contact()
    {
        // SEO Meta Tags
        $seoMeta = [
            'title' => 'Contact Us - PT Lestari Jaya Bangsa',
            'description' => 'Get in touch with PT Lestari Jaya Bangsa. Address: Jl. Raya Buntu - Sampang, Utara Pasar, Kali Minyak, Bangsa, Kec. Kebasen, Kabupaten Banyumas, Jawa Tengah 53282',
            'keywords' => 'contact us, address, phone, email, PT Lestari Jaya Bangsa',
            'og_title' => 'Contact Us - PT Lestari Jaya Bangsa',
            'og_description' => 'Get in touch with us',
            'og_type' => 'website',
            'og_image' => asset('images/logo.png'),
            'json_ld' => [
                '@context' => 'https://schema.org',
                '@type' => 'LocalBusiness',
                'name' => 'PT Lestari Jaya Bangsa',
                'address' => [
                    '@type' => 'PostalAddress',
                    'streetAddress' => 'Jl. Raya Buntu - Sampang, Utara Pasar, Kali Minyak, Bangsa',
                    'addressLocality' => 'Kec. Kebasen',
                    'addressRegion' => 'Jawa Tengah',
                    'postalCode' => '53282',
                    'addressCountry' => 'ID',
                ],
                'telephone' => '(+62) 821-9698-146',
                'openingHours' => 'Mo-Fr 07:00-16:00',
            ],
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.pages.contact');
    }

    public function storeContact(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            $this->contactService->create(
                $request->only(['name', 'email', 'phone', 'subject', 'message']),
                $request->ip(),
                $request->userAgent()
            );

            return back()->with('success', 'Thank you for your message. We will get back to you soon!');
        } catch (\Exception $e) {
            return back()->withErrors(['message' => $e->getMessage()]);
        }
    }

    public function privacyPolicy()
    {
        $seoMeta = [
            'title' => 'Kebijakan Privasi - PT Lestari Jaya Bangsa',
            'description' => 'Kebijakan privasi PT Lestari Jaya Bangsa menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.',
            'keywords' => 'kebijakan privasi, privacy policy, data pribadi, PT Lestari Jaya Bangsa',
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.pages.privacy-policy');
    }

    public function termsConditions()
    {
        $seoMeta = [
            'title' => 'Syarat & Ketentuan - PT Lestari Jaya Bangsa',
            'description' => 'Syarat dan ketentuan penggunaan layanan PT Lestari Jaya Bangsa. Harap baca dengan seksama sebelum menggunakan layanan kami.',
            'keywords' => 'syarat ketentuan, terms conditions, peraturan, PT Lestari Jaya Bangsa',
        ];

        View::share('seoMeta', $seoMeta);

        return view('frontend.pages.terms-conditions');
    }
}