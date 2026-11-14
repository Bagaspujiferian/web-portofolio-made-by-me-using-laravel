<!doctype html>
<html lang="id" data-bs-theme="dark">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <title>Dashboard CMS — BagasDev. Interactive Portfolio</title>
    <!-- Tabler UI Core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/css/tabler.min.css" rel="stylesheet"/>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.8/dist/cdn.min.js"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body x-data="{
    activeTab: '{{ request('tab', 'projects') }}',
    deleteModal: { open: false, action: '', title: '', warning: '' },
    openDeleteModal(actionUrl, itemTitle, isPermanent = false) {
        this.deleteModal.action = actionUrl;
        this.deleteModal.title = itemTitle;
        this.deleteModal.warning = isPermanent
            ? 'Tindakan ini akan menghapus data secara PERMANEN (forceDelete) dari database MySQL dan tidak dapat dikembalikan.'
            : 'Data ini akan dipindahkan ke Trash (SoftDeletes) dan masih dapat dipulihkan (Restore) kapan saja.';
        this.deleteModal.open = true;
    }
}">
<div class="page">
    <!-- Top Header Navbar (Tabler UI) -->
    <header class="navbar navbar-expand-md d-print-none border-bottom border-secondary">
        <div class="container-xl">
            <h1 class="navbar-brand navbar-brand-autodark d-none-navbar-horizontal pe-0 pe-md-3 mb-0">
                <a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-white fw-bold">
                    <span class="text-azure">&gt;_</span> BagasDev. <span class="badge bg-blue-lt ms-2">Tabler CMS</span>
                </a>
            </h1>

            <div class="navbar-nav flex-row order-md-last gap-2 align-items-center">
                <a href="{{ route('portfolio.index') }}" target="_blank" class="btn btn-outline-info btn-sm">
                    🌐 Lihat Portofolio Publik ↗
                </a>
                <button type="button" @click="activeTab = 'trash'" class="btn btn-outline-warning btn-sm">
                    🗑️ Trash ({{ $totalTrashCount }})
                </button>
                <form action="{{ route('admin.logout') }}" method="POST" class="m-0">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <!-- Navigation Bar Tabs -->
    <div class="navbar-expand-md border-bottom border-secondary bg-surface-secondary">
        <div class="container-xl">
            <ul class="nav nav-tabs border-0 py-1 gap-1">
                <li class="nav-item">
                    <button type="button" @click="activeTab = 'projects'" :class="activeTab === 'projects' ? 'active bg-primary text-white' : ''" class="nav-link rounded-2 border-0">
                        &lt;/&gt; Projects ({{ $projects->count() }})
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" @click="activeTab = 'certificates'" :class="activeTab === 'certificates' ? 'active bg-primary text-white' : ''" class="nav-link rounded-2 border-0">
                        🎖️ Certificates &amp; Awards ({{ $certificates->count() }})
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" @click="activeTab = 'career'" :class="activeTab === 'career' ? 'active bg-primary text-white' : ''" class="nav-link rounded-2 border-0">
                        🎓 Education &amp; Experience
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" @click="activeTab = 'skills'" :class="activeTab === 'skills' ? 'active bg-primary text-white' : ''" class="nav-link rounded-2 border-0">
                        🔲 Tech Stack ({{ $skills->count() }})
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" @click="activeTab = 'messages'" :class="activeTab === 'messages' ? 'active bg-primary text-white' : ''" class="nav-link rounded-2 border-0">
                        ✉️ Contact Inbox ({{ $messages->count() }})
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" @click="activeTab = 'comments'" :class="activeTab === 'comments' ? 'active bg-primary text-white' : ''" class="nav-link rounded-2 border-0">
                        💬 Guestbook ({{ $comments->count() }})
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" @click="activeTab = 'profile'" :class="activeTab === 'profile' ? 'active bg-primary text-white' : ''" class="nav-link rounded-2 border-0">
                        🪪 Profil &amp; 3D ID Card
                    </button>
                </li>
                <li class="nav-item">
                    <button type="button" @click="activeTab = 'trash'" :class="activeTab === 'trash' ? 'active bg-warning text-dark fw-bold' : ''" class="nav-link rounded-2 border-0">
                        ♻️ Trash / Restore ({{ $totalTrashCount }})
                    </button>
                </li>
            </ul>
        </div>
    </div>

    <!-- Page Body -->
    <div class="page-wrapper">
        <div class="page-body">
            <div class="container-xl">

                @if(session('admin_success'))
                    <div class="alert alert-success alert-dismissible mb-4" role="alert">
                        <div>✅ {{ session('admin_success') }}</div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
                @endif

                @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger mb-4">
                        <ul class="mb-0">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- KPI Summary Row -->
                <div class="row row-deck row-cards mb-4">
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto"><span class="bg-primary text-white avatar">&lt;/&gt;</span></div>
                                    <div class="col">
                                        <div class="font-weight-medium">{{ $projects->count() }} Active Projects</div>
                                        <div class="text-secondary">{{ $trashedProjects->count() }} in Trash</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto"><span class="bg-amber text-white avatar">🏆</span></div>
                                    <div class="col">
                                        <div class="font-weight-medium">{{ $certificates->count() }} Certs &amp; Awards</div>
                                        <div class="text-secondary">{{ $trashedCertificates->count() }} in Trash</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto"><span class="bg-azure text-white avatar">✉️</span></div>
                                    <div class="col">
                                        <div class="font-weight-medium">{{ $messages->count() }} Pesan Masuk</div>
                                        <div class="text-secondary">{{ $messages->where('is_read', false)->count() }} belum dibaca</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                        <div class="card card-sm">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-auto"><span class="bg-green text-white avatar">💬</span></div>
                                    <div class="col">
                                        <div class="font-weight-medium">{{ $comments->count() }} Komentar Tamu</div>
                                        <div class="text-secondary">Base64 Serverless Ready</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- TAB 1: PROJECTS MANAGEMENT                              -->
                <!-- ======================================================= -->
                <div x-show="activeTab === 'projects'" x-cloak>
                    <div class="row row-cards">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header"><h3 class="card-title">+ Tambah Projek Baru</h3></div>
                                <div class="card-body">
                                    <form action="{{ route('admin.projects.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Judul Projek</label>
                                            <input type="text" name="title" class="form-control" placeholder="Contoh: HRIS Attendance System V2" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">URL Screenshot Banner</label>
                                            <input type="text" name="thumbnail_url" class="form-control" value="/images/projects/hris-v2.svg">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Ringkasan Singkat (3 Baris Kartu)</label>
                                            <textarea name="short_description" rows="2" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Deskripsi Lengkap (Halaman Detail)</label>
                                            <textarea name="full_description" rows="4" class="form-control" required></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tech Stack (Pisahkan dengan koma)</label>
                                            <input type="text" name="tech_stack_raw" class="form-control" value="PHP, Laravel, MySQL, HTML, CSS, JavaScript, VScode, XAMPP">
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Demo URL</label>
                                                <input type="text" name="demo_url" class="form-control" placeholder="https://...">
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label class="form-label">Repo URL</label>
                                                <input type="text" name="repo_url" class="form-control" placeholder="https://github.com/...">
                                            </div>
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Simpan Projek</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header"><h3 class="card-title">Daftar Projek Aktif</h3></div>
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table">
                                        <thead>
                                            <tr>
                                                <th>Preview</th>
                                                <th>Judul &amp; Slug</th>
                                                <th>Tech Badges</th>
                                                <th class="w-1">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($projects as $proj)
                                                <tr>
                                                    <td>
                                                        <img src="{{ $proj->thumbnail_url }}" alt="" class="rounded" style="width: 72px; height: 46px; object-fit: cover;">
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold text-white">{{ $proj->title }}</div>
                                                        <a href="{{ route('portfolio.project.show', $proj->slug) }}" target="_blank" class="text-azure small">/project/{{ $proj->slug }} ↗</a>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex flex-wrap gap-1">
                                                            @foreach($proj->normalized_tech_stack as $t)
                                                                <span class="badge bg-dark border border-secondary">{{ $t['name'] }}</span>
                                                            @endforeach
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                @click="openDeleteModal('{{ route('admin.projects.destroy', $proj->id) }}', '{{ addslashes($proj->title) }}', false)"
                                                                class="btn btn-outline-danger btn-sm">
                                                            Soft Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- TAB 2: CERTIFICATES & ACHIEVEMENTS                      -->
                <!-- ======================================================= -->
                <div x-show="activeTab === 'certificates'" x-cloak>
                    <div class="row row-cards">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header"><h3 class="card-title">+ Tambah Sertifikat / Penghargaan</h3></div>
                                <div class="card-body">
                                    <form action="{{ route('admin.certificates.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Kategori</label>
                                            <select name="type" class="form-select">
                                                <option value="certificate">🎖️ Certificate (Sertifikat)</option>
                                                <option value="achievement">🏆 Achievement (Penghargaan / Award)</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Judul Sertifikat / Award</label>
                                            <input type="text" name="title" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Penerbit / Institusi</label>
                                            <input type="text" name="issuer" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Tahun</label>
                                            <input type="text" name="issue_date" class="form-control" value="2025">
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">URL Gambar Preview</label>
                                            <input type="text" name="image_url" class="form-control" placeholder="/images/certificates/cert-laravel.svg">
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Simpan Item</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header"><h3 class="card-title">Daftar Sertifikat &amp; Penghargaan</h3></div>
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table">
                                        <thead>
                                            <tr>
                                                <th>Tipe</th>
                                                <th>Judul</th>
                                                <th>Penerbit</th>
                                                <th>Tahun</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($certificates as $cert)
                                                <tr>
                                                    <td>
                                                        @if($cert->type === 'achievement')
                                                            <span class="badge bg-amber-lt">🏆 Award</span>
                                                        @else
                                                            <span class="badge bg-azure-lt">🎖️ Certificate</span>
                                                        @endif
                                                    </td>
                                                    <td class="fw-bold">{{ $cert->title }}</td>
                                                    <td class="text-secondary">{{ $cert->issuer }}</td>
                                                    <td>{{ $cert->issue_date }}</td>
                                                    <td>
                                                        <button type="button"
                                                                @click="openDeleteModal('{{ route('admin.certificates.destroy', $cert->id) }}', '{{ addslashes($cert->title) }}', false)"
                                                                class="btn btn-outline-danger btn-sm">
                                                            Soft Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- TAB 3: EDUCATION & EXPERIENCE                           -->
                <!-- ======================================================= -->
                <div x-show="activeTab === 'career'" x-cloak>
                    <div class="row row-cards">
                        <!-- Education Column -->
                        <div class="col-lg-6">
                            <div class="card mb-3">
                                <div class="card-header"><h3 class="card-title">+ Tambah Education</h3></div>
                                <div class="card-body">
                                    <form action="{{ route('admin.educations.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-2">
                                            <label class="form-label">Nama Institusi / Kampus</label>
                                            <input type="text" name="institution" class="form-control" placeholder="Universitas Bina Sarana Informatika" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Program Studi / Jurusan</label>
                                            <input type="text" name="degree_label" class="form-control" placeholder="Teknologi Informasi" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Periode Tahun</label>
                                            <input type="text" name="period" class="form-control" placeholder="2022 - 2026" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Tambah Education</button>
                                    </form>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header"><h3 class="card-title">Daftar Education</h3></div>
                                <div class="list-group list-group-flush">
                                    @foreach($educations as $edu)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold">{{ $edu->institution }}</div>
                                                <div class="text-secondary small">{{ $edu->degree_label }} • <span class="text-azure">{{ $edu->period }}</span></div>
                                            </div>
                                            <form action="{{ route('admin.educations.destroy', $edu->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost-danger btn-sm">Hapus</button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Experience Column -->
                        <div class="col-lg-6">
                            <div class="card mb-3">
                                <div class="card-header"><h3 class="card-title">+ Tambah Experience (SoftDeletes)</h3></div>
                                <div class="card-body">
                                    <form action="{{ route('admin.experiences.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-2">
                                            <label class="form-label">Nama Perusahaan</label>
                                            <input type="text" name="company" class="form-control" placeholder="PT Astagina Praptama Aksaya" required>
                                        </div>
                                        <div class="mb-2">
                                            <label class="form-label">Posisi / Jabatan</label>
                                            <input type="text" name="role" class="form-control" placeholder="IT Operational & Software Engineering" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Periode</label>
                                            <input type="text" name="period" class="form-control" placeholder="2024 - Sekarang">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-sm">Tambah Experience</button>
                                    </form>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-header"><h3 class="card-title">Daftar Experience</h3></div>
                                <div class="list-group list-group-flush">
                                    @foreach($experiences as $exp)
                                        <div class="list-group-item d-flex justify-content-between align-items-center">
                                            <div>
                                                <div class="fw-bold">{{ $exp->company }}</div>
                                                <div class="text-secondary small">{{ $exp->role }} • <span class="text-azure">{{ $exp->period }}</span></div>
                                            </div>
                                            <button type="button"
                                                    @click="openDeleteModal('{{ route('admin.experiences.destroy', $exp->id) }}', '{{ addslashes($exp->company) }}', false)"
                                                    class="btn btn-outline-danger btn-sm">
                                                Soft Delete
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- TAB 4: TECH STACK SKILLS                                -->
                <!-- ======================================================= -->
                <div x-show="activeTab === 'skills'" x-cloak>
                    <div class="row row-cards">
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-header"><h3 class="card-title">+ Tambah Tech Stack</h3></div>
                                <div class="card-body">
                                    <form action="{{ route('admin.skills.store') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="form-label">Nama Teknologi</label>
                                            <input type="text" name="name" class="form-control" placeholder="Contoh: Docker" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Devicon SVG URL (Kosongkan untuk otomatis)</label>
                                            <input type="text" name="icon_url" class="form-control" placeholder="Otomatis menggunakan Devicon">
                                        </div>
                                        <button type="submit" class="btn btn-primary w-100">Simpan Tech Stack</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="card-header"><h3 class="card-title">Grid Tech Stack Aktif</h3></div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        @foreach($skills as $skill)
                                            <div class="col-6 col-md-4">
                                                <div class="p-2 border border-secondary rounded d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center gap-2">
                                                        <img src="{{ $skill->icon_url }}" alt="" style="width:24px;height:24px;">
                                                        <span class="fw-bold small">{{ $skill->name }}</span>
                                                    </div>
                                                    <form action="{{ route('admin.skills.destroy', $skill->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-ghost-danger btn-icon btn-sm">✕</button>
                                                    </form>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- TAB 5: CONTACT MESSAGES INBOX                           -->
                <!-- ======================================================= -->
                <div x-show="activeTab === 'messages'" x-cloak>
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Kotak Masuk Formulir "Hubungi Saya"</h3></div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Pengirim</th>
                                        <th>Pesan</th>
                                        <th>Waktu</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($messages as $msg)
                                        <tr>
                                            <td>
                                                @if($msg->is_read)
                                                    <span class="badge bg-secondary-lt">Dibaca</span>
                                                @else
                                                    <span class="badge bg-green">Baru</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="fw-bold">{{ $msg->name }}</div>
                                                <div class="text-azure small">{{ $msg->email }}</div>
                                            </td>
                                            <td class="text-secondary">{{ $msg->message }}</td>
                                            <td class="text-secondary small">{{ $msg->created_at?->diffForHumans() }}</td>
                                            <td class="d-flex gap-1">
                                                <form action="{{ route('admin.messages.toggle-read', $msg->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-info btn-sm">
                                                        {{ $msg->is_read ? 'Tandai Belum Baca' : 'Tandai Dibaca' }}
                                                    </button>
                                                </form>
                                                <button type="button"
                                                        @click="openDeleteModal('{{ route('admin.messages.destroy', $msg->id) }}', 'Pesan dari {{ addslashes($msg->name) }}', false)"
                                                        class="btn btn-outline-danger btn-sm">
                                                    Trash
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- TAB 6: PUBLIC GUESTBOOK COMMENTS                        -->
                <!-- ======================================================= -->
                <div x-show="activeTab === 'comments'" x-cloak>
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Moderasi Komentar Buku Tamu Publik</h3></div>
                        <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Avatar</th>
                                        <th>Nama</th>
                                        <th>Komentar</th>
                                        <th>Waktu Relatif</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($comments as $c)
                                        <tr>
                                            <td>
                                                @if($c->avatar_base64)
                                                    <img src="{{ $c->avatar_base64 }}" class="avatar avatar-sm rounded-circle" alt="">
                                                @else
                                                    <span class="avatar avatar-sm rounded-circle">{{ substr($c->name, 0, 2) }}</span>
                                                @endif
                                            </td>
                                            <td class="fw-bold">{{ $c->name }}</td>
                                            <td class="text-secondary">{{ $c->comment }}</td>
                                            <td class="text-azure small">{{ $c->relative_time }}</td>
                                            <td>
                                                @if($c->is_approved)
                                                    <span class="badge bg-success-lt">Tampil</span>
                                                @else
                                                    <span class="badge bg-warning-lt">Disembunyikan</span>
                                                @endif
                                            </td>
                                            <td class="d-flex gap-1">
                                                <form action="{{ route('admin.comments.toggle-approval', $c->id) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">
                                                        {{ $c->is_approved ? 'Sembunyikan' : 'Tampilkan' }}
                                                    </button>
                                                </form>
                                                <button type="button"
                                                        @click="openDeleteModal('{{ route('admin.comments.destroy', $c->id) }}', 'Komentar {{ addslashes($c->name) }}', false)"
                                                        class="btn btn-outline-danger btn-sm">
                                                    Trash
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- TAB 7: PROFILE & 3D ID CARD SETTINGS                    -->
                <!-- ======================================================= -->
                <div x-show="activeTab === 'profile'" x-cloak>
                    <div class="card">
                        <div class="card-header"><h3 class="card-title">Pengaturan Profil Utama, 3D Lanyard ID Card &amp; Sosial Media</h3></div>
                        <div class="card-body">
                            <form action="{{ route('admin.profile.update') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ $profile->name }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Brand Navbar</label>
                                        <input type="text" name="brand_name" value="{{ $profile->brand_name }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Badge Kiri Atas Kartu ID</label>
                                        <input type="text" name="role_badge" value="{{ $profile->role_badge }}" class="form-control" required>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">Nama Institusi Kartu ID</label>
                                        <input type="text" name="institution_name" value="{{ $profile->institution_name }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Header Besar Kartu ID</label>
                                        <input type="text" name="card_header" value="{{ $profile->card_header }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Teks Vertikal Kanan Kartu ID</label>
                                        <input type="text" name="card_side_label" value="{{ $profile->card_side_label }}" class="form-control" required>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Footer Kiri Kartu ID</label>
                                        <input type="text" name="card_footer_left" value="{{ $profile->card_footer_left }}" class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Footer Kanan Kartu ID</label>
                                        <input type="text" name="card_footer_right" value="{{ $profile->card_footer_right }}" class="form-control" required>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Teks Animasi Typewriter (Pisahkan dengan koma)</label>
                                        <input type="text" name="typewriter_raw" value="{{ implode(', ', $profile->typewriter_texts ?? []) }}" class="form-control">
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Paragraf Bio Hero</label>
                                        <textarea name="hero_bio" rows="3" class="form-control" required>{{ $profile->hero_bio }}</textarea>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Paragraf Bio About (HTML diperbolehkan)</label>
                                        <textarea name="about_bio" rows="3" class="form-control" required>{{ $profile->about_bio }}</textarea>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label">GitHub Username</label>
                                        <input type="text" name="github_username" value="{{ $profile->github_username }}" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">Instagram Username</label>
                                        <input type="text" name="instagram_username" value="{{ $profile->instagram_username }}" class="form-control">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label">TikTok Username</label>
                                        <input type="text" name="tiktok_username" value="{{ $profile->tiktok_username }}" class="form-control">
                                    </div>
                                </div>
                                <div class="mt-4">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan Profil</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- ======================================================= -->
                <!-- TAB 8: TRASH / RECYCLE BIN (onlyTrashed, restore, forceDelete) -->
                <!-- ======================================================= -->
                <div x-show="activeTab === 'trash'" x-cloak>
                    <div class="card border-warning">
                        <div class="card-header bg-warning-lt">
                            <h3 class="card-title text-warning">♻️ Recycle Bin / Trash (Eloquent SoftDeletes: onlyTrashed, restore, forceDelete)</h3>
                        </div>
                        <div class="card-body space-y-4">

                            <!-- Trashed Projects -->
                            <h4 class="text-white mb-2">1. Trashed Projects ({{ $trashedProjects->count() }})</h4>
                            @if($trashedProjects->isEmpty())
                                <p class="text-secondary small mb-4">Tidak ada projek di dalam Trash.</p>
                            @else
                                <div class="table-responsive mb-4">
                                    <table class="table table-vcenter">
                                        <tbody>
                                            @foreach($trashedProjects as $tp)
                                                <tr>
                                                    <td class="fw-bold">{{ $tp->title }}</td>
                                                    <td class="text-secondary small">Dihapus {{ $tp->deleted_at?->diffForHumans() }}</td>
                                                    <td class="w-1 whitespace-nowrap">
                                                        <form action="{{ route('admin.projects.restore', $tp->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">♻️ Restore</button>
                                                        </form>
                                                        <button type="button"
                                                                @click="openDeleteModal('{{ route('admin.projects.force-delete', $tp->id) }}', '{{ addslashes($tp->title) }}', true)"
                                                                class="btn btn-danger btn-sm ms-1">
                                                            🔥 Force Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <!-- Trashed Experiences -->
                            <h4 class="text-white mb-2">2. Trashed Experiences ({{ $trashedExperiences->count() }})</h4>
                            @if($trashedExperiences->isEmpty())
                                <p class="text-secondary small mb-4">Tidak ada pengalaman kerja di dalam Trash.</p>
                            @else
                                <div class="table-responsive mb-4">
                                    <table class="table table-vcenter">
                                        <tbody>
                                            @foreach($trashedExperiences as $te)
                                                <tr>
                                                    <td class="fw-bold">{{ $te->company }} — {{ $te->role }}</td>
                                                    <td class="text-secondary small">Dihapus {{ $te->deleted_at?->diffForHumans() }}</td>
                                                    <td class="w-1 whitespace-nowrap">
                                                        <form action="{{ route('admin.experiences.restore', $te->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">♻️ Restore</button>
                                                        </form>
                                                        <button type="button"
                                                                @click="openDeleteModal('{{ route('admin.experiences.force-delete', $te->id) }}', '{{ addslashes($te->company) }}', true)"
                                                                class="btn btn-danger btn-sm ms-1">
                                                            🔥 Force Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <!-- Trashed Certificates -->
                            <h4 class="text-white mb-2">3. Trashed Certificates &amp; Awards ({{ $trashedCertificates->count() }})</h4>
                            @if($trashedCertificates->isEmpty())
                                <p class="text-secondary small mb-4">Tidak ada sertifikat/award di dalam Trash.</p>
                            @else
                                <div class="table-responsive mb-4">
                                    <table class="table table-vcenter">
                                        <tbody>
                                            @foreach($trashedCertificates as $tc)
                                                <tr>
                                                    <td class="fw-bold">{{ $tc->title }}</td>
                                                    <td class="text-secondary small">Dihapus {{ $tc->deleted_at?->diffForHumans() }}</td>
                                                    <td class="w-1 whitespace-nowrap">
                                                        <form action="{{ route('admin.certificates.restore', $tc->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">♻️ Restore</button>
                                                        </form>
                                                        <button type="button"
                                                                @click="openDeleteModal('{{ route('admin.certificates.force-delete', $tc->id) }}', '{{ addslashes($tc->title) }}', true)"
                                                                class="btn btn-danger btn-sm ms-1">
                                                            🔥 Force Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <!-- Trashed Contact Messages -->
                            <h4 class="text-white mb-2">4. Trashed Contact Messages ({{ $trashedMessages->count() }})</h4>
                            @if($trashedMessages->isEmpty())
                                <p class="text-secondary small mb-4">Tidak ada pesan kontak di dalam Trash.</p>
                            @else
                                <div class="table-responsive mb-4">
                                    <table class="table table-vcenter">
                                        <tbody>
                                            @foreach($trashedMessages as $tm)
                                                <tr>
                                                    <td class="fw-bold">{{ $tm->name }} ({{ $tm->email }})</td>
                                                    <td class="text-secondary small">{{ $tm->message }}</td>
                                                    <td class="w-1 whitespace-nowrap">
                                                        <form action="{{ route('admin.messages.restore', $tm->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">♻️ Restore</button>
                                                        </form>
                                                        <button type="button"
                                                                @click="openDeleteModal('{{ route('admin.messages.force-delete', $tm->id) }}', 'Pesan {{ addslashes($tm->name) }}', true)"
                                                                class="btn btn-danger btn-sm ms-1">
                                                            🔥 Force Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                            <!-- Trashed Public Comments -->
                            <h4 class="text-white mb-2">5. Trashed Guestbook Comments ({{ $trashedComments->count() }})</h4>
                            @if($trashedComments->isEmpty())
                                <p class="text-secondary small">Tidak ada komentar pengunjung di dalam Trash.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-vcenter">
                                        <tbody>
                                            @foreach($trashedComments as $tcom)
                                                <tr>
                                                    <td class="fw-bold">{{ $tcom->name }}</td>
                                                    <td class="text-secondary small">{{ $tcom->comment }}</td>
                                                    <td class="w-1 whitespace-nowrap">
                                                        <form action="{{ route('admin.comments.restore', $tcom->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-success btn-sm">♻️ Restore</button>
                                                        </form>
                                                        <button type="button"
                                                                @click="openDeleteModal('{{ route('admin.comments.force-delete', $tcom->id) }}', 'Komentar {{ addslashes($tcom->name) }}', true)"
                                                                class="btn btn-danger btn-sm ms-1">
                                                            🔥 Force Delete
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- ======================================================================= -->
<!-- TABLER UI CONFIRMATION DELETE MODAL                                     -->
<!-- ======================================================================= -->
<div x-show="deleteModal.open"
     x-cloak
     class="modal modal-blur fade show d-block"
     style="background: rgba(0,0,0,0.72);"
     tabindex="-1"
     role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content border-danger">
            <div class="modal-status bg-danger"></div>
            <div class="modal-body text-center py-4">
                <div class="mb-2 text-danger fs-1">⚠️</div>
                <h3>Konfirmasi Penghapusan</h3>
                <div class="text-white fw-bold mb-2" x-text="deleteModal.title"></div>
                <div class="text-secondary small" x-text="deleteModal.warning"></div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col">
                            <button type="button" @click="deleteModal.open = false" class="btn w-100">
                                Batal
                            </button>
                        </div>
                        <div class="col">
                            <form :action="deleteModal.action" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100">
                                    Ya, Hapus
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@tabler/core@1.0.0-beta20/dist/js/tabler.min.js"></script>
</body>
</html>
