<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SiteInfo;
use App\Models\PublicBannerSlide;

class SiteInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Site Info Seeder
        SiteInfo::create([
            'name' => 'Balai Pendidikan dan Pelatihan Transportasi Darat Mempawah',
            'short_name' => 'BP2TD Mempawah',
            'description' => '-',
            'keyword' => 'sample, test, keyword aplikasi',
            'copyright' => '2023&copy;BP2TD Mempawah - All rights reserved',
            'login_bg' => 'login-bg-123456.jpg',
            'login_logo' => 'login-logo-123456.png',
            'frontend_logo' => 'frontend-logo-123456.png',
            'backend_logo' => 'backend-logo-123456.png',
            'backend_logo_icon' => 'backend-logo-icon-123456.png',
            'user_updated' => NULL,
        ]);

        // Public Banner Slide Info
        $dataBannerSlide = [
            [
                'file_name' => 'sample-slide-01.jpg',
                'user_add' => 1,
            ], [
                'file_name' => 'sample-slide-02.jpg',
                'user_add' => 1,
            ], [
                'file_name' => 'sample-slide-03.jpg',
                'user_add' => 1,
            ], [
                'file_name' => 'sample-slide-04.jpg',
                'user_add' => 1,
            ]
        ];

        PublicBannerSlide::insert($dataBannerSlide);
    }
}
