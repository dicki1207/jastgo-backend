<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Barang;
use App\Models\Jastiper;
use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        $jastipers = Jastiper::all();
        $kategoris = Kategori::all();

        if ($jastipers->isEmpty()) {
            $this->command->warn("Seeder Barang: tidak ada jastiper untuk diisi.");
            return;
        }

        // Ambil semua file dummy dari storage/app/public/barang/ (jika ada)
        $dummyPath = storage_path('app/public/barangs');
        $dummyFiles = File::isDirectory($dummyPath) ? File::files($dummyPath) : [];

        foreach ($jastipers as $jastiper) {
            $jumlahBarang = rand(3, 5); // 3-5 barang per jastiper

            for ($i = 0; $i < $jumlahBarang; $i++) {
                // Pilih kategori random atau null
                $kategori = $kategoris->isNotEmpty() && rand(0,1) ? $kategoris->random() : null;

                $fileName = null;
                if (!empty($dummyFiles)) {
                    // Pilih foto dummy random
                    $fotoFile = $dummyFiles[array_rand($dummyFiles)];
                    $fileName = 'barangs/' . basename($fotoFile);
                }

                Barang::create([
                    'jastiper_id'     => $jastiper->id,
                    'kategori_id'     => $kategori?->id,
                    'admin_id'        => null,
                    'nama_barang'     => 'Barang ' . Str::random(5),
                    'deskripsi'       => 'Deskripsi contoh ' . Str::random(5),
                    'harga'           => rand(10000, 500000),
                    'stok'            => rand(1, 50),
                    'is_available'    => ['yes','no'][rand(0,1)],
                    'foto_barang'     => $fileName, // Bisa null jika tidak ada gambar
                    // 'status_validasi' => 'pending',
                    'tanggal_input'   => now()->subDays(rand(0, 10)),
                ]);
            }
        }
    }
}
