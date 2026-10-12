<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Database\Seeder;

class BukuSeeder extends Seeder
{
    public function run(): void
    {
        $kategori = Kategori::pluck('id', 'kode_kategori');

        // [kode kategori, judul, penulis, penerbit, tahun, sinopsis]
        $data = [
            ['INF', 'Clean Code', 'Robert C. Martin', 'Prentice Hall', 2008, 'Panduan menulis kode yang bersih, mudah dibaca, dan mudah dirawat, lengkap dengan contoh refactoring.'],
            ['INF', 'Introduction to Algorithms', 'Thomas H. Cormen, Charles E. Leiserson, Ronald L. Rivest, Clifford Stein', 'MIT Press', 2022, 'Referensi lengkap algoritma dan struktur data beserta analisis kompleksitasnya.'],
            ['INF', 'The Pragmatic Programmer', 'David Thomas, Andrew Hunt', 'Addison-Wesley', 2019, 'Kumpulan praktik dan cara berpikir pengembang perangkat lunak profesional.'],
            ['INF', 'Operating System Concepts', 'Abraham Silberschatz, Peter B. Galvin, Greg Gagne', 'Wiley', 2018, 'Pembahasan konsep sistem operasi: proses, memori, penyimpanan, dan keamanan.'],
            ['INF', 'Computer Networking: A Top-Down Approach', 'James F. Kurose, Keith W. Ross', 'Pearson', 2021, 'Pengantar jaringan komputer dengan pendekatan top-down mulai dari lapisan aplikasi.'],
            ['INF', 'Cryptography and Network Security', 'William Stallings', 'Pearson', 2017, 'Prinsip dan praktik kriptografi serta keamanan jaringan, termasuk teori bilangan dan finite field.'],
            ['INF', 'Artificial Intelligence: A Modern Approach', 'Stuart Russell, Peter Norvig', 'Pearson', 2020, 'Buku acuan kecerdasan buatan: pencarian, constraint satisfaction, logika, dan pembelajaran mesin.'],
            ['INF', 'Laravel: Up & Running', 'Matt Stauffer', "O'Reilly Media", 2019, 'Panduan membangun aplikasi web dengan Laravel: routing, Eloquent, Blade, dan validasi.'],
            ['INF', 'Software Engineering', 'Ian Sommerville', 'Pearson', 2015, 'Dasar rekayasa perangkat lunak: proses pengembangan, kebutuhan, desain, dan pengujian.'],

            ['SIS', 'Database System Concepts', 'Abraham Silberschatz, Henry F. Korth, S. Sudarshan', 'McGraw-Hill', 2019, 'Konsep basis data relasional, SQL, desain skema, transaksi, dan optimasi kueri.'],
            ['SIS', 'Fundamentals of Database Systems', 'Ramez Elmasri, Shamkant B. Navathe', 'Pearson', 2016, 'Landasan sistem basis data: model ER, normalisasi, SQL, dan arsitektur DBMS.'],
            ['SIS', 'Systems Analysis and Design', 'Kenneth E. Kendall, Julie E. Kendall', 'Pearson', 2019, 'Metode analisis dan perancangan sistem informasi, dari kebutuhan pengguna hingga implementasi.'],
            ['SIS', 'Management Information Systems', 'Kenneth C. Laudon, Jane P. Laudon', 'Pearson', 2020, 'Peran sistem informasi dalam organisasi modern dan pengambilan keputusan bisnis.'],
            ['SIS', "Don't Make Me Think, Revisited", 'Steve Krug', 'New Riders', 2014, 'Prinsip usability dan desain web yang intuitif, dibahas ringkas dan praktis.'],

            ['MAT', 'Introduction to Linear Algebra', 'Gilbert Strang', 'Wellesley-Cambridge Press', 2016, 'Pengantar aljabar linier: vektor, matriks, ruang vektor, eigenvalue, dan aplikasinya.'],
            ['MAT', 'Probability & Statistics for Engineers & Scientists', 'Ronald E. Walpole, Raymond H. Myers, Sharon L. Myers, Keying Ye', 'Pearson', 2012, 'Probabilitas dan statistika untuk mahasiswa teknik dan sains, dengan banyak contoh soal.'],
            ['MAT', 'Discrete Mathematics and Its Applications', 'Kenneth H. Rosen', 'McGraw-Hill', 2018, 'Matematika diskrit: logika, himpunan, graf, kombinatorika, dan teori bilangan.'],

            ['MNJ', 'A Guide to the Project Management Body of Knowledge (PMBOK Guide)', 'Project Management Institute', 'PMI', 2021, 'Standar dan panduan manajemen proyek: prinsip, domain kinerja, dan praktik terbaik.'],
            ['MNJ', 'Principles of Marketing', 'Philip Kotler, Gary Armstrong', 'Pearson', 2020, 'Dasar-dasar pemasaran: segmentasi, penentuan target, bauran pemasaran, dan perilaku konsumen.'],

            ['KODE_ASLI', 'Pedoman Umum Ejaan Bahasa Indonesia (PUEBI)', 'Badan Pengembangan dan Pembinaan Bahasa', 'Kementerian Pendidikan dan Kebudayaan', 2016, 'Pedoman penulisan bahasa Indonesia: ejaan, tanda baca, dan penulisan unsur serapan.'],
        ];

        foreach ($data as [$kode, $judul, $penulis, $penerbit, $tahun, $sinopsis]) {
            // ISBN dan stok tetap dibuat Faker lewat BukuFactory
            Buku::factory()->create([
                'kategori_id'  => $kategori[$kode],
                'judul'        => $judul,
                'penulis'      => $penulis,
                'penerbit'     => $penerbit,
                'tahun_terbit' => $tahun,
                'sinopsis'     => $sinopsis,
            ]);
        }
    }
}