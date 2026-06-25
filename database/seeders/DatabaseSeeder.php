<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::findOrFail(2);

        // Seed default categories
        $categories = [
            'Makanan', 'Transportasi', 'Tagihan', 'Hiburan',
            'Gaji', 'Bonus', 'Lainnya',
        ];

        $categoryModels = [];
        foreach ($categories as $namaKategori) {
            $categoryModels[$namaKategori] = $user->categories()->firstOrCreate([
                'nama_kategori' => $namaKategori,
            ]);
        }

        // Seed budgets (Anggaran) for June (6) and July (7) 2026
        $user->anggarans()->updateOrCreate(
            ['bulan' => 6, 'tahun' => 2026],
            ['nominal_anggaran' => 5000000]
        );

        $user->anggarans()->updateOrCreate(
            ['bulan' => 7, 'tahun' => 2026],
            ['nominal_anggaran' => 4500000]
        );

        // Seed transactions
        $transactionsData = [
            [
                'category' => 'Gaji',
                'tipe' => 'pemasukan',
                'nominal' => 6000000,
                'tanggal' => '2026-06-01',
            ],
            [
                'category' => 'Bonus',
                'tipe' => 'pemasukan',
                'nominal' => 1000000,
                'tanggal' => '2026-06-15',
            ],
            [
                'category' => 'Makanan',
                'tipe' => 'pengeluaran',
                'nominal' => 350000,
                'tanggal' => '2026-06-02',
            ],
            [
                'category' => 'Makanan',
                'tipe' => 'pengeluaran',
                'nominal' => 150000,
                'tanggal' => '2026-06-05',
            ],
            [
                'category' => 'Transportasi',
                'tipe' => 'pengeluaran',
                'nominal' => 100000,
                'tanggal' => '2026-06-03',
            ],
            [
                'category' => 'Tagihan',
                'tipe' => 'pengeluaran',
                'nominal' => 500000,
                'tanggal' => '2026-06-10',
            ],
            [
                'category' => 'Hiburan',
                'tipe' => 'pengeluaran',
                'nominal' => 80000,
                'tanggal' => '2026-06-12',
            ],
            [
                'category' => 'Lainnya',
                'tipe' => 'pengeluaran',
                'nominal' => 50000,
                'tanggal' => '2026-06-20',
            ],
        ];

        // Clear existing transactions first to avoid duplicate seeds if run multiple times
        $user->transactions()->delete();

        foreach ($transactionsData as $data) {
            $category = $categoryModels[$data['category']];
            $user->transactions()->create([
                'category_id' => $category->id,
                'tipe' => $data['tipe'],
                'nominal' => $data['nominal'],
                'tanggal' => $data['tanggal'],
            ]);
        }
    }
}
