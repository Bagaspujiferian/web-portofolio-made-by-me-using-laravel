<?php

namespace Database\Seeders;

use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\PublicComment;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin Users
        User::updateOrCreate(
            ['email' => 'admin@bagas.dev'],
            [
                'name' => 'Bagas Puji Ferian',
                'password' => Hash::make('password123'),
            ]
        );

        User::updateOrCreate(
            ['email' => 'bagaspujiferian@gmail.com'],
            [
                'name' => 'Bagas Puji Ferian',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Profile (Single Master Record)
        Profile::updateOrCreate(
            ['id' => 1],
            [
                'name' => 'Bagas Puji Ferian',
                'brand_name' => 'BagasDev.',
                'role_badge' => 'FULLSTACK',
                'institution_name' => 'UNIVERSITAS BSI',
                'institution_logo_url' => '/images/icons/ubsi-logo.svg',
                'card_header' => 'DEVELOPER',
                'card_side_label' => 'SOFTWARE ENGINEER',
                'card_footer_left' => 'PORTFOLIO',
                'card_footer_right' => "Don't repeat yourself",
                'typewriter_texts' => [
                    'Laravel & PHP Enthusiast',
                    'Web Development',
                    'IT Infrastructure & IoT',
                ],
                'hero_bio' => 'Berawal dari rasa penasaran, sekarang jadi passion. Aku suka bereksperimen dengan kode, mengeksplorasi teknologi baru, dan mengubah ide menjadi sesuatu yang nyata. Dari arsitektur backend yang tangguh sampai antarmuka web interaktif, aku selalu berusaha bikin sesuatu yang bukan cuma keren dilihat, tapi juga nyaman digunakan.',
                'about_bio' => 'Saya adalah <strong>Backend & IT Infrastructure Developer</strong> yang berfokus pada pengembangan teknologi yang fungsional sekaligus menarik. Saya senang memadukan kode, desain, dan sistem berbasis PHP 8, Laravel, serta IoT untuk menghadirkan pengalaman digital yang intuitif, responsif, dan berdampak.',
                'id_card_photo_url' => '/images/bagas-portrait.svg',
                'spiderman_photo_url' => '/images/bagas-portrait.svg',
                'spotify_playlist_url' => 'https://open.spotify.com/playlist/37i9dQZF1DX5trt9i14X7j',
                'spotify_embed_url' => 'https://open.spotify.com/embed/playlist/37i9dQZF1DX5trt9i14X7j?utm_source=generator&theme=0',
                'background_audio_url' => null,
                'github_url' => 'https://github.com/bagaspujiferian',
                'github_username' => '@bagaspujiferian',
                'instagram_url' => 'https://instagram.com/bagaspujiferian',
                'instagram_username' => '@bagaspujiferian',
                'tiktok_url' => 'https://tiktok.com/@bagas.dev',
                'tiktok_username' => '@bagas.dev',
                'linkedin_url' => 'https://linkedin.com/in/bagas-puji-ferian',
                'email' => 'bagaspujiferian@gmail.com',
            ]
        );

        // 3. Educations
        $educations = [
            [
                'institution' => 'Universitas Bina Sarana Informatika',
                'degree_label' => 'Teknologi Informasi / Sistem Informasi',
                'period' => '2022 - 2026',
                'logo_url' => '/images/icons/ubsi-logo.svg',
                'sort_order' => 1,
            ],
            [
                'institution' => 'SMK Teknik Komputer & Jaringan',
                'degree_label' => 'Teknik Komputer, Jaringan & Infrastruktur IT',
                'period' => '2019 - 2022',
                'logo_url' => '/images/icons/ubsi-logo.svg',
                'sort_order' => 2,
            ],
        ];

        foreach ($educations as $edu) {
            Education::updateOrCreate(
                ['institution' => $edu['institution']],
                $edu
            );
        }

        // 4. Experiences (SoftDeletes enabled)
        $experiences = [
            [
                'company' => 'PT Astagina Praptama Aksaya',
                'role' => 'IT Operational & Software Engineering',
                'period' => '2024 - Sekarang',
                'description' => 'Mengelola operasional infrastruktur IT perusahaan, mengembangkan sistem internal berbasis Laravel & MySQL (HRIS Attendance System V2), integrasi perangkat absensi IoT, serta administrasi jaringan dan server virtualisasi.',
                'logo_url' => '/images/icons/astagina-logo.svg',
                'sort_order' => 1,
            ],
            [
                'company' => 'BagasDev Studio (Freelance)',
                'role' => 'Full-Stack Web & IoT Developer',
                'period' => '2022 - Sekarang',
                'description' => 'Membangun aplikasi web full-stack menggunakan PHP 8, Laravel, MySQL, Tailwind CSS, serta merancang prototipe sistem IoT berbasis NodeMCU ESP8266 dan homelab server Proxmox/Armbian.',
                'logo_url' => '/images/icons/tabler.svg',
                'sort_order' => 2,
            ],
        ];

        foreach ($experiences as $exp) {
            Experience::withTrashed()->updateOrCreate(
                ['company' => $exp['company'], 'role' => $exp['role']],
                array_merge($exp, ['deleted_at' => null])
            );
        }

        // 5. Projects (SoftDeletes enabled)
        $standardBadges = [
            ['name' => 'PHP', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg'],
            ['name' => 'Laravel', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg'],
            ['name' => 'MySQL', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg'],
            ['name' => 'HTML', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg'],
            ['name' => 'CSS', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg'],
            ['name' => 'JavaScript', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg'],
            ['name' => 'VScode', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vscode/vscode-original.svg'],
            ['name' => 'XAMPP', 'icon' => '/images/icons/xampp.svg'],
        ];

        $projects = [
            [
                'title' => 'HRIS Attendance System V2',
                'slug' => 'hris-attendance-system-v2',
                'thumbnail_url' => '/images/projects/hris-v2.svg',
                'short_description' => 'Sistem Informasi Manajemen SDM & Presensi Karyawan berbasis Laravel 13, MySQL, dan Tabler UI dengan fitur Geofencing GPS, QR Dynamic, serta integrasi mesin RFID IoT real-time.',
                'full_description' => "HRIS Attendance System V2 adalah platform manajemen sumber daya manusia (Human Resource Information System) dan presensi terpadu yang dirancang khusus untuk kebutuhan operasional korporat di PT Astagina Praptama Aksaya.\n\nAplikasi ini memadukan arsitektur backend modern berbasis PHP 8.3 dan Laravel 13 dengan antarmuka dashboard eksekutif Tabler UI. Dilengkapi dengan validasi presensi berlapis menggunakan titik koordinat Geofencing GPS, pemindaian QR Code dinamis, serta sinkronisasi langsung dengan perangkat keras pembaca kartu RFID berbasis mikrokontroler.\n\nSelain pencatatan kehadiran real-time, sistem ini mengotomatisasi manajemen shift kerja, pengajuan cuti/lembur berjenjang, rekapitulasi keterlambatan, hingga pembuatan laporan analitik KPI dan penggajian secara akurat.",
                'tech_stack' => $standardBadges,
                'features' => [
                    'Validasi Presensi Multi-Mode: GPS Geofencing, Dynamic QR Code & RFID Card Tap',
                    'Dashboard Analitik Real-Time dengan Grafik Kehadiran & Rekapitulasi Shift Otomatis',
                    'Manajemen Cuti, Izin, Lembur, serta Ekspor Laporan Excel/PDF Terintegrasi',
                    'Role-Based Access Control (Super Admin, HRD, Manager, dan Employee Portal)',
                ],
                'demo_url' => 'https://github.com/bagaspujiferian',
                'repo_url' => 'https://github.com/bagaspujiferian',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'title' => 'Database Siswa',
                'slug' => 'database-siswa',
                'thumbnail_url' => '/images/projects/database-siswa.svg',
                'short_description' => 'Aplikasi web manajemen data induk siswa dan akademik sekolah yang dilengkapi fitur CRUD komprehensif, pencarian instan, filter kelas/jurusan, serta cetak laporan otomatis.',
                'full_description' => "Database Siswa adalah aplikasi sistem informasi akademik berbasis web yang dikembangkan untuk memodernisasi pengelolaan data induk pelajar secara terpusat, cepat, dan terstruktur.\n\nDibangun menggunakan PHP 8, Laravel, dan database relasional MySQL, proyek ini menyediakan antarmuka yang bersih dan responsif bagi staf tata usaha maupun guru dalam mengelola biodata siswa, rombongan belajar, jurusan, serta riwayat akademik.\n\nDilengkapi dengan fitur validasi input ketat, pencarian multi-parameter secara real-time, pengelolaan foto profil siswa, serta fitur ekspor dan cetak laporan rekapitulasi data siswa yang siap pakai.",
                'tech_stack' => $standardBadges,
                'features' => [
                    'Manajemen Data Induk Siswa (NISN, Biodata Lengkap, Kelas, dan Jurusan)',
                    'Pencarian & Penyaringan Data Instan dengan Pagination Responsif',
                    'Autentikasi Admin Berlapis & Riwayat Perubahan Data (Soft Deletes)',
                    'Ekspor Rekapitulasi Data Siswa ke Format Cetak & Spreadsheet',
                ],
                'demo_url' => 'https://github.com/bagaspujiferian',
                'repo_url' => 'https://github.com/bagaspujiferian',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'title' => 'NodeMCU ESP8266 RFID IoT Scanner & Proxmox Homelab',
                'slug' => 'nodemcu-esp8266-rfid-iot-proxmox',
                'thumbnail_url' => '/images/projects/iot-proxmox.svg',
                'short_description' => 'Integrasi perangkat keras IoT RFID Scanner berbasis NodeMCU ESP8266 dengan REST API Laravel yang di-hosting mandiri di atas server virtualisasi Linux Proxmox VE & Armbian.',
                'full_description' => "Proyek rekayasa perangkat keras dan infrastruktur server ini menggabungkan dunia Embedded Systems (IoT) dengan arsitektur Cloud/Homelab mandiri.\n\nPada sisi perangkat tepi (edge device), mikrokontroler NodeMCU ESP8266 dihubungkan dengan modul pembaca frekuensi radio MFRC522 (13.56 MHz), layar OLED I2C, dan indikator buzzer untuk membaca UID kartu akses secara instan. Setiap pemindaian dikirimkan melalui protokol HTTP REST API menuju server backend Laravel.\n\nSeluruh layanan backend, database MySQL, MQTT broker, dan reverse proxy dijalankan di dalam lingkungan container Linux (LXC) pada server homelab berbasis Proxmox VE dan Armbian Linux dengan efisiensi sumber daya tinggi dan uptime maksimal.",
                'tech_stack' => [
                    ['name' => 'PHP', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg'],
                    ['name' => 'Laravel', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg'],
                    ['name' => 'MySQL', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg'],
                    ['name' => 'NodeMCU ESP8266', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/arduino/arduino-original.svg'],
                    ['name' => 'Linux Proxmox/Armbian', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/linux/linux-original.svg'],
                    ['name' => 'JavaScript', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg'],
                    ['name' => 'VScode', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vscode/vscode-original.svg'],
                    ['name' => 'Git', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/git/git-original.svg'],
                ],
                'features' => [
                    'Firmware C++ ESP8266 dengan Koneksi Wi-Fi Auto-Reconnect & Indikator OLED',
                    'Endpoint Webhook REST API Laravel Berkecepatan Tinggi (<50ms Response Time)',
                    'Orkestrasi Container LXC di Proxmox VE & Armbian Linux Server',
                    'Monitoring Kesehatan Node Server, Suhu Perangkat & Log Akses Real-Time',
                ],
                'demo_url' => 'https://github.com/bagaspujiferian',
                'repo_url' => 'https://github.com/bagaspujiferian',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'title' => 'E-Commerce & Smart POS Cloud Platform',
                'slug' => 'ecommerce-smart-pos-platform',
                'thumbnail_url' => '/images/projects/ecommerce-pos.svg',
                'short_description' => 'Platform E-Commerce & kasir pintar (Point of Sales) terintegrasi dengan manajemen stok multi-gudang, keranjang belanja interaktif, dan laporan keuangan otomatis.',
                'full_description' => "E-Commerce & Smart POS Cloud Platform adalah solusi perdagangan digital end-to-end yang menghubungkan katalog toko online pelanggan dengan sistem kasir (Point of Sales) dan inventaris gudang secara real-time.\n\nDibangun menggunakan Laravel, MySQL, Tailwind CSS, dan Alpine.js, sistem ini mencegah selisih stok barang menggunakan transaksi database atomik (ACID), mendukung pembuatan invoice otomatis, manajemen diskon bertingkat, serta penyajian laporan laba-rugi harian maupun bulanan secara visual.",
                'tech_stack' => $standardBadges,
                'features' => [
                    'Sinkronisasi Stok Produk Otomatis antara Katalog Web & Kasir POS',
                    'Keranjang Belanja Interaktif & Checkout Cepat Berbasis Alpine.js',
                    'pencatatan Mutasi Stok Gudang (Stock Ledger) & Peringatan Stok Menipis',
                    'Dashboard Analitik Penjualan Harian, Mingguan, dan Bulanan',
                ],
                'demo_url' => 'https://github.com/bagaspujiferian',
                'repo_url' => 'https://github.com/bagaspujiferian',
                'is_featured' => true,
                'sort_order' => 4,
            ],
        ];

        foreach ($projects as $proj) {
            Project::withTrashed()->updateOrCreate(
                ['slug' => $proj['slug']],
                array_merge($proj, ['deleted_at' => null])
            );
        }

        // 6. Certificates & Achievements
        $certificates = [
            [
                'title' => 'Laravel Full-Stack Web Developer & REST API Architecture',
                'issuer' => 'Dicoding Indonesia / Baparekraf Digital Talent',
                'issue_date' => '2025',
                'image_url' => '/images/certificates/cert-laravel.svg',
                'credential_url' => 'https://www.dicoding.com',
                'type' => 'certificate',
                'sort_order' => 1,
            ],
            [
                'title' => 'Backend Engineering & Relational Database Architecture (MySQL)',
                'issuer' => 'Alibaba Cloud & Codepolitan',
                'issue_date' => '2024',
                'image_url' => '/images/certificates/cert-backend.svg',
                'credential_url' => 'https://www.codepolitan.com',
                'type' => 'certificate',
                'sort_order' => 2,
            ],
            [
                'title' => 'Cisco Networking, Linux Server & Proxmox Virtualization',
                'issuer' => 'Cisco Networking Academy',
                'issue_date' => '2024',
                'image_url' => '/images/certificates/cert-iot.svg',
                'credential_url' => 'https://www.netacad.com',
                'type' => 'certificate',
                'sort_order' => 3,
            ],
            [
                'title' => 'IoT Embedded Systems with NodeMCU ESP8266 & Microcontroller',
                'issuer' => 'Digitalent Scholarship Kominfo RI',
                'issue_date' => '2023',
                'image_url' => '/images/certificates/cert-iot.svg',
                'credential_url' => 'https://digitalent.kominfo.go.id',
                'type' => 'certificate',
                'sort_order' => 4,
            ],
            // Achievements / Awards
            [
                'title' => 'Best Capstone Engineering Project — Sistem Absensi IoT & HRIS Terintegrasi',
                'issuer' => 'Universitas Bina Sarana Informatika',
                'issue_date' => '2025',
                'image_url' => '/images/certificates/award-honor.svg',
                'credential_url' => '#',
                'type' => 'achievement',
                'sort_order' => 1,
            ],
            [
                'title' => 'Outstanding IT Operational & Internal System Automation Award',
                'issuer' => 'PT Astagina Praptama Aksaya',
                'issue_date' => '2025',
                'image_url' => '/images/certificates/award-honor.svg',
                'credential_url' => '#',
                'type' => 'achievement',
                'sort_order' => 2,
            ],
            [
                'title' => 'Finalis Inovasi Pengembangan Aplikasi Web & Sistem Informasi Nasional',
                'issuer' => 'Kompetisi Mahasiswa Teknologi Informasi',
                'issue_date' => '2024',
                'image_url' => '/images/certificates/award-honor.svg',
                'credential_url' => '#',
                'type' => 'achievement',
                'sort_order' => 3,
            ],
        ];

        foreach ($certificates as $cert) {
            Certificate::withTrashed()->updateOrCreate(
                ['title' => $cert['title'], 'type' => $cert['type']],
                array_merge($cert, ['deleted_at' => null])
            );
        }

        // 7. Tech Stack Skills (All 12 required items with colored Devicon / custom SVGs)
        $skills = [
            ['name' => 'PHP 8', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/php/php-original.svg', 'category' => 'Backend', 'level' => 'Advanced', 'sort_order' => 1],
            ['name' => 'Laravel 13', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/laravel/laravel-original.svg', 'category' => 'Backend', 'level' => 'Advanced', 'sort_order' => 2],
            ['name' => 'MySQL', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/mysql/mysql-original.svg', 'category' => 'Database', 'level' => 'Advanced', 'sort_order' => 3],
            ['name' => 'HTML5', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/html5/html5-original.svg', 'category' => 'Frontend', 'level' => 'Advanced', 'sort_order' => 4],
            ['name' => 'CSS3', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/css3/css3-original.svg', 'category' => 'Frontend', 'level' => 'Advanced', 'sort_order' => 5],
            ['name' => 'JavaScript', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/javascript/javascript-original.svg', 'category' => 'Frontend', 'level' => 'Intermediate', 'sort_order' => 6],
            ['name' => 'Tabler UI', 'icon_url' => '/images/icons/tabler.svg', 'category' => 'Frontend', 'level' => 'Advanced', 'sort_order' => 7],
            ['name' => 'NodeMCU ESP8266', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/arduino/arduino-original.svg', 'category' => 'IoT & Infra', 'level' => 'Advanced', 'sort_order' => 8],
            ['name' => 'Linux Proxmox/Armbian', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/linux/linux-original.svg', 'category' => 'IoT & Infra', 'level' => 'Advanced', 'sort_order' => 9],
            ['name' => 'Git', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/git/git-original.svg', 'category' => 'Tools', 'level' => 'Advanced', 'sort_order' => 10],
            ['name' => 'VSCode', 'icon_url' => 'https://cdn.jsdelivr.net/gh/devicons/devicon@latest/icons/vscode/vscode-original.svg', 'category' => 'Tools', 'level' => 'Advanced', 'sort_order' => 11],
            ['name' => 'XAMPP', 'icon_url' => '/images/icons/xampp.svg', 'category' => 'Tools', 'level' => 'Advanced', 'sort_order' => 12],
        ];

        foreach ($skills as $skill) {
            Skill::updateOrCreate(
                ['name' => $skill['name']],
                $skill
            );
        }

        // 8. Public Guestbook Comments (6 initial Indonesian comments matching the screenshots)
        $initialComments = [
            [
                'name' => 'Rizky Pratama',
                'comment' => 'Keren banget bang portofolionya! Efek 3D lanyard ID card sama spotlight Spider-Man nya halus parah 🔥',
                'avatar_base64' => self::makeSvgAvatarDataUri('RP', '#2563eb'),
                'is_approved' => true,
                'is_pinned' => true,
                'created_at' => now()->subMinutes(42),
                'updated_at' => now()->subMinutes(42),
            ],
            [
                'name' => 'Nadia Putri Maharani',
                'comment' => 'UI liquid glass navbar sama metallic card border-nya berkelas banget. Sukses terus karirnya di bidang Backend & IT Infra bang Bagas!',
                'avatar_base64' => self::makeSvgAvatarDataUri('NP', '#7c3aed'),
                'is_approved' => true,
                'is_pinned' => false,
                'created_at' => now()->subHours(2),
                'updated_at' => now()->subHours(2),
            ],
            [
                'name' => 'Dimas Arya Saputra',
                'comment' => 'Mantap bang Bagas, projek HRIS Attendance V2 sama integrasi RFID NodeMCU ESP8266 di Proxmox-nya rapi banget arsitekturnya.',
                'avatar_base64' => self::makeSvgAvatarDataUri('DA', '#0891b2'),
                'is_approved' => true,
                'is_pinned' => false,
                'created_at' => now()->subHours(6),
                'updated_at' => now()->subHours(6),
            ],
            [
                'name' => 'Fajar Nugroho (UBSI)',
                'comment' => 'Inspiratif banget buat sesama mahasiswa Universitas BSI! Jarang ada portofolio berbasis Laravel yang se-interaktif ini.',
                'avatar_base64' => self::makeSvgAvatarDataUri('FN', '#059669'),
                'is_approved' => true,
                'is_pinned' => false,
                'created_at' => now()->subDay(),
                'updated_at' => now()->subDay(),
            ],
            [
                'name' => 'Aulia Rahman',
                'comment' => 'Suka banget sama detail musik pengiring sama playlist Spotify-nya, berasa hidup banget waktu scroll dari atas sampai bawah.',
                'avatar_base64' => self::makeSvgAvatarDataUri('AR', '#d97706'),
                'is_approved' => true,
                'is_pinned' => false,
                'created_at' => now()->subDays(3),
                'updated_at' => now()->subDays(3),
            ],
            [
                'name' => 'Hendra Wijaya',
                'comment' => 'Kombinasi PHP 8, Laravel, sama sentuhan UI dark nebula-nya mantap jiwa. Auto bookmark buat referensi!',
                'avatar_base64' => self::makeSvgAvatarDataUri('HW', '#e11d48'),
                'is_approved' => true,
                'is_pinned' => false,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(5),
            ],
        ];

        foreach ($initialComments as $commentData) {
            $existing = PublicComment::withTrashed()->where('name', $commentData['name'])->first();
            if (! $existing) {
                $comment = new PublicComment($commentData);
                $comment->created_at = $commentData['created_at'];
                $comment->updated_at = $commentData['updated_at'];
                $comment->save();
            }
        }

        // 9. Sample Contact Messages for Admin CMS Inbox
        if (ContactMessage::withTrashed()->count() === 0) {
            ContactMessage::create([
                'name' => 'Budi Santoso — HR Tech Lead',
                'email' => 'budi.santoso@techcorp.id',
                'message' => 'Halo Bagas, kami sangat tertarik dengan proyek HRIS Attendance System V2 dan keahlian infrastruktur Proxmox/Laravel Anda. Apakah terbuka untuk diskusi kolaborasi proyek?',
                'is_read' => false,
                'ip_address' => '127.0.0.1',
            ]);

            ContactMessage::create([
                'name' => 'Sinta Dewi — Project Manager',
                'email' => 'sinta@digitalagency.co.id',
                'message' => 'Selamat malam Mas Bagas, portofolionya sangat impresif! Kami ingin menanyakan ketersediaan untuk pengembangan sistem web internal berbasis Laravel.',
                'is_read' => true,
                'ip_address' => '127.0.0.1',
            ]);
        }
    }

    /**
     * Generate a lightweight SVG Base64 Data URI avatar for seeded comments.
     */
    private static function makeSvgAvatarDataUri(string $initials, string $bgColor): string
    {
        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80">'
            .'<rect width="80" height="80" rx="40" fill="'.$bgColor.'"/>'
            .'<text x="50%" y="54%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="sans-serif" font-weight="700" font-size="28">'.$initials.'</text>'
            .'</svg>';

        return 'data:image/svg+xml;base64,'.base64_encode($svg);
    }
}
