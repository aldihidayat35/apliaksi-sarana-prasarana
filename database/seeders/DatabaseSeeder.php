<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Location;
use App\Models\Item;
use App\Models\ItemRegistration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Users
        $admin = User::updateOrCreate(
            ['email' => 'admin@brilsmart.sch.id'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $guru = User::updateOrCreate(
            ['email' => 'guru@brilsmart.sch.id'],
            [
                'name' => 'Budi Santoso',
                'password' => Hash::make('password'),
                'role' => 'guru',
                'is_active' => true,
            ]
        );

        $kepsek = User::updateOrCreate(
            ['email' => 'kepsek@brilsmart.sch.id'],
            [
                'name' => 'Hj. Siti Aminah, M.Pd.',
                'password' => Hash::make('password'),
                'role' => 'kepala_sekolah',
                'is_active' => true,
            ]
        );

        // Categories
        $categories = collect([
            ['name' => 'Meja', 'slug' => 'meja', 'description' => 'Meja belajar & meja kantor'],
            ['name' => 'Kursi', 'slug' => 'kursi', 'description' => 'Kursi belajar & kursi kantor'],
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Peralatan elektronik'],
            ['name' => 'Komputer', 'slug' => 'komputer', 'description' => 'PC, Laptop & perangkat komputer'],
            ['name' => 'Olahraga', 'slug' => 'olahraga', 'description' => 'Peralatan olahraga'],
            ['name' => 'Laboratorium', 'slug' => 'laboratorium', 'description' => 'Peralatan laboratorium'],
        ])->map(fn($c) => Category::updateOrCreate(['slug' => $c['slug']], $c));

        // Locations
        $locations = collect([
            ['name' => 'Ruang Guru', 'code' => 'RG-01', 'description' => 'Ruang guru lantai 1'],
            ['name' => 'Ruang Kelas 7A', 'code' => 'KLS-7A', 'description' => 'Kelas 7A lantai 1'],
            ['name' => 'Ruang Kelas 8A', 'code' => 'KLS-8A', 'description' => 'Kelas 8A lantai 2'],
            ['name' => 'Lab Komputer', 'code' => 'LAB-KOM', 'description' => 'Laboratorium komputer lantai 2'],
            ['name' => 'Lab IPA', 'code' => 'LAB-IPA', 'description' => 'Laboratorium IPA lantai 1'],
            ['name' => 'Gudang', 'code' => 'GDG-01', 'description' => 'Gudang penyimpanan utama'],
            ['name' => 'Lapangan', 'code' => 'LPG-01', 'description' => 'Lapangan olahraga'],
        ])->map(fn($l) => Location::updateOrCreate(['code' => $l['code']], $l));

        // Items
        $itemsData = [
            ['code' => 'MJ-001', 'name' => 'Meja Guru', 'category' => 'meja', 'location' => 'RG-01', 'condition' => 'baik', 'quantity' => 5, 'price' => 750000],
            ['code' => 'MJ-002', 'name' => 'Meja Siswa', 'category' => 'meja', 'location' => 'KLS-7A', 'condition' => 'baik', 'quantity' => 30, 'price' => 350000],
            ['code' => 'KR-001', 'name' => 'Kursi Guru', 'category' => 'kursi', 'location' => 'RG-01', 'condition' => 'baik', 'quantity' => 5, 'price' => 500000],
            ['code' => 'KR-002', 'name' => 'Kursi Siswa', 'category' => 'kursi', 'location' => 'KLS-7A', 'condition' => 'rusak_ringan', 'quantity' => 30, 'price' => 250000],
            ['code' => 'EL-001', 'name' => 'Proyektor Epson EB-X51', 'category' => 'elektronik', 'location' => 'RG-01', 'condition' => 'baik', 'quantity' => 3, 'price' => 7500000],
            ['code' => 'EL-002', 'name' => 'Speaker Aktif', 'category' => 'elektronik', 'location' => 'GDG-01', 'condition' => 'rusak_berat', 'quantity' => 2, 'price' => 1200000],
            ['code' => 'KP-001', 'name' => 'PC Desktop Lenovo', 'category' => 'komputer', 'location' => 'LAB-KOM', 'condition' => 'baik', 'quantity' => 20, 'price' => 8000000],
            ['code' => 'KP-002', 'name' => 'Laptop ASUS VivoBook', 'category' => 'komputer', 'location' => 'LAB-KOM', 'condition' => 'baik', 'quantity' => 5, 'price' => 9000000],
            ['code' => 'OR-001', 'name' => 'Bola Basket Molten', 'category' => 'olahraga', 'location' => 'LPG-01', 'condition' => 'baik', 'quantity' => 10, 'price' => 350000],
            ['code' => 'OR-002', 'name' => 'Net Badminton', 'category' => 'olahraga', 'location' => 'GDG-01', 'condition' => 'hilang', 'quantity' => 1, 'price' => 150000],
            ['code' => 'LB-001', 'name' => 'Mikroskop Binokuler', 'category' => 'laboratorium', 'location' => 'LAB-IPA', 'condition' => 'baik', 'quantity' => 10, 'price' => 3500000],
            ['code' => 'LB-002', 'name' => 'Tabung Erlenmeyer 500ml', 'category' => 'laboratorium', 'location' => 'LAB-IPA', 'condition' => 'rusak_ringan', 'quantity' => 15, 'price' => 85000],
        ];

        foreach ($itemsData as $itemData) {
            $cat = $categories->first(fn($c) => $c->slug === $itemData['category']);
            $loc = $locations->first(fn($l) => $l->code === $itemData['location']);

            $item = Item::updateOrCreate(
                ['code' => $itemData['code']],
                [
                    'name' => $itemData['name'],
                    'category_id' => $cat->id,
                    'location_id' => $loc->id,
                    'condition' => $itemData['condition'],
                    'quantity' => $itemData['quantity'],
                    'price' => $itemData['price'],
                    'acquisition_date' => now()->subMonths(rand(1, 24)),
                ]
            );

            // Auto-register each item
            ItemRegistration::updateOrCreate(
                ['item_id' => $item->id],
                [
                    'unique_id' => 'BRL-' . strtoupper(substr($cat->slug, 0, 3)) . '-' . str_pad($item->id, 5, '0', STR_PAD_LEFT),
                    'registered_by' => $admin->id,
                    'registered_at' => now()->subMonths(rand(1, 12)),
                ]
            );
        }

        // Seed app settings
        $this->call(AppSettingSeeder::class);
    }
}
