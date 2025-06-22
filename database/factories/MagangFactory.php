<?php

namespace Database\Factories;

use App\Models\Magang;
use App\Models\Perusahaan;
use Illuminate\Database\Eloquent\Factories\Factory;

class MagangFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\App\Models\Magang>
     */
    protected $model = Magang::class;  // Pastikan menunjuk ke model Magang

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // --- Kumpulan Data Realistis dalam Bahasa Indonesia ---

        // 1. Opsi untuk Bidang Pekerjaan (10 Pilihan)
        $bidangPekerjaan = [
            'Teknologi Informasi',
            'Pemasaran Digital',
            'Keuangan & Akuntansi',
            'Sumber Daya Manusia',
            'Desain Grafis',
            'Administrasi & Operasional',
            'Manufaktur & Produksi',
            'Logistik & Rantai Pasok',
            'Hubungan Masyarakat',
            'Analisis Bisnis'
        ];

        // 2. Opsi untuk Judul (Digabung dari Template + Posisi)
        $templateJudul = ['Staf Magang', 'Internship', 'Peserta Magang', 'Junior Associate', 'Intern'];
        $posisi = [
            'Web Developer (Backend)',
            'Web Developer (Frontend)',
            'Social Media Specialist',
            'Content Writer',
            'Akuntan',
            'Staff Rekrutmen',
            'UI/UX Designer',
            'Analis Data',
            'Quality Control',
            'Asisten Manajer Proyek'
        ];

        // 3. Template Deskripsi (10+ Kombinasi)
        $deskripsiTemplates = [
            "Kami mencari {$this->faker->randomElement($posisi)} yang bersemangat untuk bergabung dengan tim kami. Anda akan terlibat langsung dalam proyek-proyek penting, membantu pengembangan produk, dan berkolaborasi dengan tim lintas fungsi. Kualifikasi: Mahasiswa tingkat akhir, memiliki pemahaman dasar tentang pengembangan perangkat lunak, dan mampu bekerja dalam tim.",
            "Posisi magang ini menawarkan kesempatan untuk belajar tentang {$this->faker->randomElement($bidangPekerjaan)}. Tanggung jawab utama termasuk membantu tugas harian tim, melakukan riset pasar, dan menyiapkan laporan. Keuntungan: Uang saku bulanan, sertifikat magang, dan lingkungan kerja yang suportif.",
            "Bergabunglah sebagai {$this->faker->randomElement($templateJudul)} {$this->faker->randomElement($posisi)} di perusahaan kami. Anda akan mendapatkan pengalaman praktis di industri {$this->faker->randomElement($bidangPekerjaan)}, mengerjakan tugas-tugas yang menantang, dan dibimbing oleh para profesional. Syarat: Komunikatif, proaktif, dan memiliki keinginan belajar yang tinggi.",
            "Kesempatan magang di bidang {$this->faker->randomElement($bidangPekerjaan)}. Anda akan membantu dalam mengelola kampanye iklan digital dan menganalisis data performa. Kami mencari individu yang teliti, kreatif, dan menguasai alat-alat analisis media sosial.",
            "Posisi terbuka untuk {$this->faker->randomElement($posisi)} dengan fokus pada analisis dan pelaporan keuangan. Tanggung jawab meliputi rekonsiliasi bank, entri jurnal, dan membantu persiapan laporan bulanan. Mahasiswa Jurusan Akuntansi atau Keuangan diutamakan."
        ];

        // --- Akhir dari Kumpulan Data ---

        $mulai = $this->faker->dateTimeBetween('now', '+1 month');
        $selesai = $this->faker->dateTimeBetween($mulai, (clone $mulai)->modify('+3 months'));

        return [
            'perusahaan_id'   => Perusahaan::factory(),
            'judul'           => $this->faker->randomElement($templateJudul) . ' ' . $this->faker->randomElement($posisi),
            'deskripsi'       => $this->faker->randomElement($deskripsiTemplates), // Menggunakan template deskripsi baru
            'lokasi'          => $this->faker->city(),
            'bidang'          => $this->faker->randomElement($bidangPekerjaan),
            'tanggal_mulai'   => $mulai->format('Y-m-d'),
            'tanggal_selesai' => $selesai->format('Y-m-d'),
            // Gunakan kuota yang sudah kita set default-nya di migrasi
            'kuota'           => $this->faker->numberBetween(1, 5), // Kuota magang antara 1 s/d 5
            'status_aktif'    => $this->faker->boolean(80),
        ];
    }
}
