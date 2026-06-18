<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Laptop;

class LaptopSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Laptop::create([
            'nama_laptop' => 'Asus Vivobook 14',
            'merk' => 'Asus',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 5,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Lenovo IdeaPad Slim 3',
            'merk' => 'Lenovo',
            'processor' => 'Intel Core i5-12450H',
            'ram' => '8 GB',
            'stok' => 4,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Acer Aspire 5',
            'merk' => 'Acer',
            'processor' => 'Intel Core i5-1235U',
            'ram' => '8 GB',
            'stok' => 6,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'MSI Katana GF66',
            'merk' => 'MSI',
            'processor' => 'Intel Core i7-11800H',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Rusak Ringan'
        ]);

        Laptop::create([
            'nama_laptop' => 'HP Victus 15',
            'merk' => 'HP',
            'processor' => 'Intel Core i5-13420H',
            'ram' => '16 GB',
            'stok' => 3,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Dell Inspiron 15',
            'merk' => 'Dell',
            'processor' => 'Intel Core i5-1235U',
            'ram' => '8 GB',
            'stok' => 4,
            'kondisi' => 'Baik'
]);

        Laptop::create([
            'nama_laptop' => 'Dell Latitude 5420',
            'merk' => 'Dell',
            'processor' => 'Intel Core i7-1185G7',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Baik'
]);

        Laptop::create([
            'nama_laptop' => 'HP ProBook 450 G8',
            'merk' => 'HP',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 3,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Lenovo ThinkPad E15',
            'merk' => 'Lenovo',
            'processor' => 'Intel Core i7-1165G7',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Rusak Ringan'
        ]);

        Laptop::create([
            'nama_laptop' => 'Acer Swift 3',
            'merk' => 'Acer',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 4,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'MSI Modern 14',
            'merk' => 'MSI',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 3,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Asus ROG Zephyrus G14',
            'merk' => 'Asus',
            'processor' => 'AMD Ryzen 9 4900HS',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Rusak Ringan'
        ]);

        Laptop::create([
            'nama_laptop' => 'HP Envy x360 13',
            'merk' => 'HP',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 3,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Lenovo Yoga Slim 7',
            'merk' => 'Lenovo',
            'processor' => 'Intel Core i7-1165G7',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Acer Predator Helios 300',
            'merk' => 'Acer',
            'processor' => 'Intel Core i7-11800H',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Rusak Ringan'
        ]);

        Laptop::create([
            'nama_laptop' => 'MSI GF63 Thin',
            'merk' => 'MSI',
            'processor' => 'Intel Core i5-9300H',
            'ram' => '8 GB',
            'stok' => 4,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Dell XPS 13',
            'merk' => 'Dell',
            'processor' => 'Intel Core i7-1165G7',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'HP Omen 15',
            'merk' => 'HP',
            'processor' => 'Intel Core i7-11800H',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Rusak Ringan'
        ]);

        Laptop::create([
            'nama_laptop' => 'Lenovo Legion 5',
            'merk' => 'Lenovo',
            'processor' => 'AMD Ryzen 7 5800H',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Asus TUF Gaming A15',
            'merk' => 'Asus',
            'processor' => 'AMD Ryzen 7 4800H',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'MSI Stealth 15M',
            'merk' => 'MSI',
            'processor' => 'Intel Core i7-11375H',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Rusak Ringan'
        ]);

        Laptop::create([
            'nama_laptop' => 'Acer Nitro 5',
            'merk' => 'Acer',
            'processor' => 'Intel Core i5-9300H',
            'ram' => '8 GB',
            'stok' => 4,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Dell G5 15',
            'merk' => 'Dell',
            'processor' => 'Intel Core i7-10750H',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'HP Spectre x360 14',
            'merk' => 'HP',
            'processor' => 'Intel Core i7-1165G7',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Rusak Ringan'
        ]);

        Laptop::create([
            'nama_laptop' => 'Lenovo ThinkBook 14s',
            'merk' => 'Lenovo',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 3,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Asus ZenBook 14',
            'merk' => 'Asus',
            'processor' => 'Intel Core i7-1165G7',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'MSI GF65 Thin',
            'merk' => 'MSI',
            'processor' => 'Intel Core i7-10750H',
            'ram' => '16 GB',
            'stok' => 2,
            'kondisi' => 'Rusak Ringan'
        ]);

        Laptop::create([
            'nama_laptop' => 'Acer Swift 5',
            'merk' => 'Acer',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 3,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Dell Inspiron 14',
            'merk' => 'Dell',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 4,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'HP Pavilion 15',
            'merk' => 'HP',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 3,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Lenovo IdeaPad Flex 5',
            'merk' => 'Lenovo',
            'processor' => 'AMD Ryzen 5 4500U',
            'ram' => '8 GB',
            'stok' => 4,
            'kondisi' => 'Baik'
        ]);

        Laptop::create([
            'nama_laptop' => 'Asus VivoBook Flip 14',
            'merk' => 'Asus',
            'processor' => 'Intel Core i5-1135G7',
            'ram' => '8 GB',
            'stok' => 3,
            'kondisi' => 'Baik'
        ]);
    }
}