<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Gallery;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $urls = [];

        // ── Static Pages ──
        $staticPages = [
            ['url' => route('home'),       'priority' => '1.0', 'frequency' => 'daily'],
            ['url' => route('aboutUs'),      'priority' => '0.8', 'frequency' => 'monthly'],
            ['url' => route('service'),   'priority' => '0.9', 'frequency' => 'weekly'],
            ['url' => route('contact'),    'priority' => '0.7', 'frequency' => 'monthly'],
            ['url' => route('testimonial'),'priority' => '0.6', 'frequency' => 'monthly'],
            ['url' => route('gallery'),    'priority' => '0.6', 'frequency' => 'monthly'],
        ];

        foreach ($staticPages as $page) {
            $urls[] = [
                'loc'        => $page['url'],
                'lastmod'    => now()->toAtomString(),
                'changefreq' => $page['frequency'],
                'priority'   => $page['priority'],
            ];
        }

        return response()->view('frontend.sitemap', compact('urls'))
            ->header('Content-Type', 'text/xml');
    }

    public function robots()
    {
        $content  = "User-agent: *\n";
        $content .= "Allow: /\n";
        $content .= "Disallow: /admin\n";
        $content .= "Disallow: /dashboard\n";
        $content .= "\n";
        $content .= "Sitemap: " . route('sitemap');

        return response($content, 200)
            ->header('Content-Type', 'text/plain');
    }
}