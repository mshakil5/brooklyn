<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AboutPage;
use App\Models\AboutStat;
use App\Models\AboutHighlight;
use App\Models\AboutMilestone;
use App\Models\AboutValue;
use App\Models\AboutCert;

class AboutPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Main About Page Content (Single Record)
        AboutPage::updateOrCreate(
            ['id' => 1], // Ensures it only creates one row
            [
                'hero_tag'         => 'Our Story',
                'hero_title'       => '25+ Years Building<br><span class="text-blue">NYC\'s Sidewalks</span>',
                'hero_description' => 'Since 1998, NYC Sidewalk Pros has been the trusted name in sidewalk and concrete services across all five boroughs. What started as a small Brooklyn operation has grown into the city\'s most respected sidewalk contractor.',
                
                'story_tag'        => 'Our Journey',
                'story_title'      => 'From Brooklyn Roots to <span class="text-blue">All Five Boroughs</span>',
                'story_content'    => '<p>NYC Sidewalk Pros was founded in 1998 by a third-generation concrete worker who saw a need for reliable, honest sidewalk services in Brooklyn. What began as a one-man operation with a pickup truck and a dream has grown into New York City\'s most trusted sidewalk and concrete contractor.</p>
                                     <p>In those early days, we focused on small residential repairs in neighborhoods like Flatbush, Crown Heights, and Bay Ridge. Word spread quickly about our quality workmanship and fair pricing. Property managers and building owners started calling, and before long, we were working across Brooklyn and into Manhattan.</p>
                                     <p>Today, we serve all five boroughs — Manhattan, Brooklyn, Queens, The Bronx, and Staten Island. Our team has grown to over 50 skilled workers, and we\'ve completed more than 5,000 projects ranging from simple sidewalk repairs to complex commercial installations.</p>
                                     <p>Despite our growth, we\'ve never lost sight of what made us successful: treating every property like it\'s our own, showing up on time, doing quality work, and standing behind everything we do. That\'s the NYC Sidewalk Pros promise.</p>',
                
                'badge_rating'     => 'A+',
                'badge_label'      => 'BBB Accredited',
                'story_image'      => 'about/story-placeholder.jpg', // Replace with actual image path if needed
            ]
        );

        // 2. Seed Stats (Clear old data first to prevent duplicates on re-run)
        AboutStat::truncate();
        $stats = [
            ['icon' => 'bi bi-building', 'number' => '5,000+', 'label' => 'Projects Done', 'sort_order' => 1],
            ['icon' => 'bi bi-calendar-check', 'number' => '25+', 'label' => 'Years Experience', 'sort_order' => 2],
            ['icon' => 'bi bi-geo-alt', 'number' => '5', 'label' => 'NYC Boroughs', 'sort_order' => 3],
            ['icon' => 'bi bi-emoji-smile', 'number' => '98%', 'label' => 'Satisfaction Rate', 'sort_order' => 4],
        ];
        foreach ($stats as $stat) {
            AboutStat::create($stat);
        }

        // 3. Seed Highlights
        AboutHighlight::truncate();
        $highlights = [
            ['text' => 'Family-owned & operated since 1998', 'sort_order' => 1],
            ['text' => '50+ skilled concrete professionals', 'sort_order' => 2],
            ['text' => '5,000+ successful projects completed', 'sort_order' => 3],
        ];
        foreach ($highlights as $highlight) {
            AboutHighlight::create($highlight);
        }

        // 4. Seed Milestones
        AboutMilestone::truncate();
        $milestones = [
            ['year' => '1998', 'title' => 'Founded in Brooklyn', 'description' => 'Started as a family-owned concrete business in Brooklyn, serving local residential properties with honest, quality workmanship.', 'sort_order' => 1],
            ['year' => '2002', 'title' => 'NYC DOT Certified', 'description' => 'Officially certified as an NYC Department of Transportation approved contractor, enabling us to handle sidewalk violations.', 'sort_order' => 2],
            ['year' => '2008', 'title' => 'Expanded to All 5 Boroughs', 'description' => 'Grew our service area to cover Manhattan, Brooklyn, Queens, The Bronx, and Staten Island with dedicated crews in each borough.', 'sort_order' => 3],
            ['year' => '2015', 'title' => '1,000th Project Completed', 'description' => 'Reached a major milestone of completing our 1,000th sidewalk project, establishing us as a leading NYC concrete contractor.', 'sort_order' => 4],
            ['year' => '2020', 'title' => '24/7 Emergency Service Launched', 'description' => 'Introduced round-the-clock emergency sidewalk services to help property owners deal with urgent violations and safety hazards.', 'sort_order' => 5],
            ['year' => '2024', 'title' => '5,000+ Projects & 98% Satisfaction', 'description' => 'Surpassed 5,000 completed projects with an outstanding 98% customer satisfaction rate — a testament to our commitment to excellence.', 'sort_order' => 6],
        ];
        foreach ($milestones as $milestone) {
            AboutMilestone::create($milestone);
        }

        // 5. Seed Core Values
        AboutValue::truncate();
        $values = [
            ['icon' => 'bi bi-hand-thumbs-up-fill', 'title' => 'Integrity', 'description' => 'We provide honest assessments and transparent pricing with no hidden fees. What we quote is what you pay — guaranteed.', 'sort_order' => 1],
            ['icon' => 'bi bi-gem', 'title' => 'Quality', 'description' => 'We use premium materials and proven techniques to ensure every project is built to last and meets NYC DOT standards.', 'sort_order' => 2],
            ['icon' => 'bi bi-clock-history', 'title' => 'Reliability', 'description' => 'We show up on time and complete projects as promised. When we say we\'ll be there, we\'re there — no excuses.', 'sort_order' => 3],
            ['icon' => 'bi bi-people-fill', 'title' => 'Community', 'description' => 'As a NYC company, we\'re invested in maintaining safe sidewalks in our communities — the neighborhoods we call home.', 'sort_order' => 4],
        ];
        foreach ($values as $value) {
            AboutValue::create($value);
        }

        // 6. Seed Certifications
        AboutCert::truncate();
        $certs = [
            [
                'icon' => 'bi bi-patch-check-fill', 
                'title' => 'NYC Licensed Contractor', 
                'license_label' => 'License #', 
                'license_number' => 'CON-98-4421', 
                'license_class' => '', 
                'description' => 'Licensed by the New York City Department of Buildings to perform concrete and masonry work throughout all five boroughs.', 
                'status_text' => 'Active & In Good Standing',
                'sort_order' => 1
            ],
            [
                'icon' => 'bi bi-shield-check', 
                'title' => 'DOT Certified', 
                'license_label' => 'Status', 
                'license_number' => 'Approved Contractor', 
                'license_class' => 'approved', // Extracted from your HTML span class
                'description' => 'Certified by the NYC Department of Transportation to handle sidewalk violations and perform DOT-compliant concrete work.', 
                'status_text' => 'Authorized to File Permits',
                'sort_order' => 2
            ],
            [
                'icon' => 'bi bi-shield-lock-fill', 
                'title' => 'Fully Insured', 
                'license_label' => 'Coverage', 
                'license_number' => '$2,000,000', 
                'license_class' => '', 
                'description' => 'Carries $2 million in liability coverage including general liability, workers\' compensation, and property damage protection.', 
                'status_text' => 'Certificate Available on Request',
                'sort_order' => 3
            ],
        ];
        foreach ($certs as $cert) {
            AboutCert::create($cert);
        }
    }
}