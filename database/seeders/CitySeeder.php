<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
    public function run(): void
    {
        $cities = [
            // JAWA BARAT
            'Bandung',
            'Cimahi',
            'Cirebon',
            'Depok',
            'Sukabumi',
            'Tasikmalaya',
            'Karawang',
            'Purwakarta',
            'Subang',
            'Sumedang',
            'Indramayu',
            'Majalengka',
            'Kuningan',

            // DKI JAKARTA
            'Jakarta Pusat',
            'Jakarta Utara',
            'Jakarta Selatan',
            'Jakarta Timur',
            'Jakarta Barat',

            // BANTEN
            'Tangerang',
            'Tangerang Selatan',
            'Serang',
            'Cilegon',
            'Pandeglang',
            'Lebak',

            // JAWA TENGAH
            'Semarang',
            'Surakarta',
            'Magelang',
            'Salatiga',
            'Pekalongan',
            'Tegal',
            'Purwokerto',
            'Cilacap',
            'Kudus',
            'Jepara',

            // DI YOGYAKARTA
            'Yogyakarta',
            'Sleman',
            'Bantul',
            'Kulon Progo',
            'Gunungkidul',

            // JAWA TIMUR
            'Surabaya',
            'Malang',
            'Batu',
            'Kediri',
            'Blitar',
            'Madiun',
            'Pasuruan',
            'Probolinggo',
            'Mojokerto',
            'Jember',
            'Banyuwangi',

            // SUMATERA
            'Medan',
            'Binjai',
            'Padang',
            'Bukittinggi',
            'Pekanbaru',
            'Palembang',
            'Lampung',
            'Bandar Lampung',
            'Jambi',
            'Bengkulu',
            'Batam',
            'Tanjung Pinang',

            // KALIMANTAN
            'Pontianak',
            'Singkawang',
            'Palangkaraya',
            'Banjarmasin',
            'Banjarbaru',
            'Samarinda',
            'Balikpapan',
            'Tarakan',

            // SULAWESI
            'Makassar',
            'Parepare',
            'Palopo',
            'Manado',
            'Bitung',
            'Gorontalo',
            'Palu',
            'Kendari',

            // BALI & NUSA TENGGARA
            'Denpasar',
            'Badung',
            'Gianyar',
            'Mataram',
            'Bima',
            'Kupang',

            // MALUKU & PAPUA
            'Ambon',
            'Ternate',
            'Tidore',
            'Jayapura',
            'Sorong',
            'Manokwari',
        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name'       => $city,
                'slug'       => Str::slug($city),
                'photo'      => 'default-city.jpg',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
