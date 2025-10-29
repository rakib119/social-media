<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GenarelInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('genarel_infos')->delete();
        $data = [
            ['field_name' => 'logo',  'value' => "http://127.0.0.1:8000/assets/images/info/logo.png" ],
            ['field_name' => 'logo_white',  'value' => "http://127.0.0.1:8000/assets/images/info/logo_white.png" ],
            ['field_name' => 'favicon',  'value' => "http://127.0.0.1:8000/assets/images/info/favicon.png" ],
            ['field_name' => 'about-background',  'value' => "http://127.0.0.1:8000/assets/images/info/about-background.jpg" ],
            ['field_name' => 'service-background',  'value' => "http://127.0.0.1:8000/assets/images/info/service-background.jpg" ],
            ['field_name' => 'blog-background',  'value' => "http://127.0.0.1:8000/assets/images/info/blog-background.jpg" ],
            ['field_name' => 'web_title',  'value' => "Ascentaverse" ],
            ['field_name' => 'notice',  'value' => "Coming soon! Our website is under construction and will be live shortly. We apologize for any inconvenience. Stay tuned for updates! " ],
            ['field_name' => 'company_description',  'value' => "We work with a passion of taking challenges and creating new ones in advertising sector." ],
            ['field_name' => 'footer_heading_1',  'value' => "Newsletter" ],
            ['field_name' => 'footer_heading_description',  'value' => "Subscribe our newsletter to get our latest update & news" ],
            ['field_name' => 'social_link1',  'value' => "https://www.facebook.com/ascentaverse" ],
            ['field_name' => 'social_link2',  'value' => "https://x.com/ascentaverse" ],
            ['field_name' => 'social_link3',  'value' => "https://www.instagram.com/AscentaVerse/" ],
            ['field_name' => 'social_link4',  'value' => "https://www.youtube.com/@ascentaverse" ],
            ['field_name' => 'footer_heading_2',  'value' => "Official info:" ],
            ['field_name' => 'address',  'value' => "2020 Islampur, Jamalpur,<br>Mymensingh, Bangladesh" ],
            ['field_name' => 'phone',  'value' => "+8809613245856" ],
            ['field_name' => 'email',  'value' => "info@ascentaverse.com" ],
            ['field_name' => 'timing',  'value' => " <strong>Open Hours:</strong> Sun - Wed : 9 am - 9 pm, <br>Thursday : 9 am - 6 pm, <br> Fri - Sat : CLOSED" ],
            ['field_name' => 'footer_heading_3',  'value' => "Links" ],
            ['field_name' => 'link1',  'value' => "About**www.ascentaverse.com/about" ],
            ['field_name' => 'link2',  'value' => "Terms&Conditions**www.ascentaverse.com/about" ],
            ['field_name' => 'link3',  'value' => "Certificate**www.ascentaverse.com/about" ],
            ['field_name' => 'link4',  'value' => "Test 1**www.ascentaverse.com/about" ],
            ['field_name' => 'link5',  'value' => "Test 2**www.ascentaverse.com/about" ],
            ['field_name' => 'link6',  'value' => "Test 3**www.ascentaverse.com/about" ],
            ['field_name' => 'link7',  'value' => "Test 4**www.ascentaverse.com/about" ],
        ];
        DB::table('genarel_infos')->insert($data);
    }
}
