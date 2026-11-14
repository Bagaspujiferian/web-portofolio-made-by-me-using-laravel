<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\PublicComment;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * Check if the current session is authenticated as Admin.
     */
    private function isAuthenticated(Request $request): bool
    {
        return (bool) $request->session()->get('admin_authenticated', false);
    }

    /**
     * Show Admin Login page (Tabler UI).
     */
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($this->isAuthenticated($request)) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.login');
    }

    /**
     * Authenticate Admin user via database User record or ADMIN_PASSWORD fallback.
     */
    public function login(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['nullable', 'string'],
            'password' => ['required', 'string'],
        ]);

        $email = trim((string) $request->input('email', 'admin@bagas.dev'));
        $password = (string) $request->input('password');
        $fallbackPassword = (string) env('ADMIN_PASSWORD', 'password123');

        $user = User::where('email', $email)->first() ?? User::first();

        $isValid = false;
        if ($user && Hash::check($password, $user->password)) {
            $isValid = true;
        } elseif ($password === $fallbackPassword) {
            $isValid = true;
        }

        if ($isValid) {
            $request->session()->put('admin_authenticated', true);
            $request->session()->put('admin_email', $user->email ?? $email);
            $request->session()->put('admin_name', $user->name ?? 'Bagas Puji Ferian');

            return redirect()->route('admin.dashboard')->with('admin_success', 'Selamat datang kembali di Dashboard CMS BagasDev!');
        }

        return back()->withErrors([
            'password' => 'Email atau kata sandi Admin salah. Gunakan password default: password123',
        ])->withInput();
    }

    /**
     * Logout from Admin CMS.
     */
    public function logout(Request $request): RedirectResponse
    {
        $request->session()->forget(['admin_authenticated', 'admin_email', 'admin_name']);

        return redirect()->route('admin.login')->with('admin_success', 'Anda telah keluar dari sesi Admin.');
    }

    /**
     * Render the complete Tabler UI Admin Dashboard with CRUD & Trash/Restore tabs.
     */
    public function dashboard(Request $request): View|RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $profile = Profile::first() ?? new Profile(['name' => 'Bagas Puji Ferian', 'brand_name' => 'BagasDev.']);

        $educations = Education::orderBy('sort_order')->orderBy('id')->get();
        $experiences = Experience::orderBy('sort_order')->orderBy('id')->get();
        $trashedExperiences = Experience::onlyTrashed()->latest('deleted_at')->get();

        $projects = Project::orderBy('sort_order')->orderBy('id')->get();
        $trashedProjects = Project::onlyTrashed()->latest('deleted_at')->get();

        $certificates = Certificate::orderBy('type')->orderBy('sort_order')->orderBy('id')->get();
        $trashedCertificates = Certificate::onlyTrashed()->latest('deleted_at')->get();

        $skills = Skill::orderBy('sort_order')->orderBy('id')->get();

        $messages = ContactMessage::latest()->get();
        $trashedMessages = ContactMessage::onlyTrashed()->latest('deleted_at')->get();

        $comments = PublicComment::latest()->get();
        $trashedComments = PublicComment::onlyTrashed()->latest('deleted_at')->get();

        $totalTrashCount = $trashedExperiences->count()
            + $trashedProjects->count()
            + $trashedCertificates->count()
            + $trashedMessages->count()
            + $trashedComments->count();

        return view('admin.dashboard', compact(
            'profile',
            'educations',
            'experiences',
            'trashedExperiences',
            'projects',
            'trashedProjects',
            'certificates',
            'trashedCertificates',
            'skills',
            'messages',
            'trashedMessages',
            'comments',
            'trashedComments',
            'totalTrashCount'
        ));
    }

    /**
     * Update Master Profile & Lanyard ID Card Settings.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'brand_name' => ['required', 'string', 'max:60'],
            'role_badge' => ['required', 'string', 'max:60'],
            'institution_name' => ['required', 'string', 'max:100'],
            'card_header' => ['required', 'string', 'max:60'],
            'card_side_label' => ['required', 'string', 'max:60'],
            'card_footer_left' => ['required', 'string', 'max:60'],
            'card_footer_right' => ['required', 'string', 'max:120'],
            'typewriter_raw' => ['nullable', 'string'],
            'hero_bio' => ['required', 'string'],
            'about_bio' => ['required', 'string'],
            'id_card_photo_url' => ['nullable', 'string', 'max:255'],
            'spiderman_photo_url' => ['nullable', 'string', 'max:255'],
            'spotify_playlist_url' => ['nullable', 'string', 'max:255'],
            'spotify_embed_url' => ['nullable', 'string', 'max:255'],
            'github_url' => ['nullable', 'string', 'max:255'],
            'github_username' => ['nullable', 'string', 'max:80'],
            'instagram_url' => ['nullable', 'string', 'max:255'],
            'instagram_username' => ['nullable', 'string', 'max:80'],
            'tiktok_url' => ['nullable', 'string', 'max:255'],
            'tiktok_username' => ['nullable', 'string', 'max:80'],
            'email' => ['nullable', 'email', 'max:150'],
        ]);

        $typewriterTexts = array_values(array_filter(array_map(
            'trim',
            explode(',', (string) ($validated['typewriter_raw'] ?? 'Laravel & PHP Enthusiast, Web Development, IT Infrastructure & IoT'))
        )));

        unset($validated['typewriter_raw']);
        $validated['typewriter_texts'] = $typewriterTexts;

        $profile = Profile::first();
        if ($profile) {
            $profile->update($validated);
        } else {
            Profile::create($validated);
        }

        return redirect()->route('admin.dashboard', ['tab' => 'profile'])->with('admin_success', 'Profil & Kartu ID berhasil diperbarui!');
    }

    // =========================================================================
    // EDUCATIONS CRUD
    // =========================================================================

    public function storeEducation(Request $request): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'institution' => ['required', 'string', 'max:150'],
            'degree_label' => ['required', 'string', 'max:150'],
            'period' => ['required', 'string', 'max:60'],
            'logo_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['logo_url'] = $validated['logo_url'] ?: '/images/icons/ubsi-logo.svg';
        $validated['sort_order'] = $validated['sort_order'] ?? 1;

        Education::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'career'])->with('admin_success', 'Data pendidikan berhasil ditambahkan.');
    }

    public function destroyEducation(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Education::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'career'])->with('admin_success', 'Data pendidikan berhasil dihapus.');
    }

    // =========================================================================
    // EXPERIENCES CRUD + SOFT DELETES (TRASH / RESTORE / FORCE DELETE)
    // =========================================================================

    public function storeExperience(Request $request): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'company' => ['required', 'string', 'max:150'],
            'role' => ['required', 'string', 'max:150'],
            'period' => ['nullable', 'string', 'max:60'],
            'description' => ['nullable', 'string'],
            'logo_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['logo_url'] = $validated['logo_url'] ?: '/images/icons/astagina-logo.svg';
        $validated['sort_order'] = $validated['sort_order'] ?? 1;

        Experience::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'career'])->with('admin_success', 'Pengalaman kerja berhasil ditambahkan.');
    }

    public function destroyExperience(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Experience::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'career'])->with('admin_success', 'Pengalaman kerja dipindahkan ke Trash (Soft Delete).');
    }

    public function restoreExperience(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Experience::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Pengalaman kerja berhasil dipulihkan (Restored)!');
    }

    public function forceDeleteExperience(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Experience::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Pengalaman kerja dihapus permanen.');
    }

    // =========================================================================
    // PROJECTS CRUD + SOFT DELETES (TRASH / RESTORE / FORCE DELETE)
    // =========================================================================

    public function storeProject(Request $request): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'slug' => ['nullable', 'string', 'max:160'],
            'thumbnail_url' => ['nullable', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'full_description' => ['required', 'string'],
            'tech_stack_raw' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'string', 'max:255'],
            'repo_url' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $slug = ! empty($validated['slug']) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        if (Project::withTrashed()->where('slug', $slug)->exists()) {
            $slug .= '-'. rand(10, 99);
        }

        $techNames = array_filter(array_map('trim', explode(',', (string) ($validated['tech_stack_raw'] ?? 'PHP, Laravel, MySQL, HTML, CSS, JavaScript, VScode, XAMPP'))));
        $techStack = [];
        foreach ($techNames as $tName) {
            $techStack[] = [
                'name' => $tName,
                'icon' => Project::resolveDeviconUrl($tName),
            ];
        }

        Project::create([
            'title' => $validated['title'],
            'slug' => $slug,
            'thumbnail_url' => $validated['thumbnail_url'] ?: '/images/projects/hris-v2.svg',
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'],
            'tech_stack' => $techStack,
            'demo_url' => $validated['demo_url'],
            'repo_url' => $validated['repo_url'],
            'is_featured' => true,
            'sort_order' => $validated['sort_order'] ?? 1,
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'projects'])->with('admin_success', 'Proyek baru berhasil ditambahkan!');
    }

    public function updateProject(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $project = Project::findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'thumbnail_url' => ['nullable', 'string', 'max:255'],
            'short_description' => ['required', 'string'],
            'full_description' => ['required', 'string'],
            'tech_stack_raw' => ['nullable', 'string'],
            'demo_url' => ['nullable', 'string', 'max:255'],
            'repo_url' => ['nullable', 'string', 'max:255'],
        ]);

        $techNames = array_filter(array_map('trim', explode(',', (string) ($validated['tech_stack_raw'] ?? 'PHP, Laravel, MySQL'))));
        $techStack = [];
        foreach ($techNames as $tName) {
            $techStack[] = [
                'name' => $tName,
                'icon' => Project::resolveDeviconUrl($tName),
            ];
        }

        $project->update([
            'title' => $validated['title'],
            'thumbnail_url' => $validated['thumbnail_url'] ?: $project->thumbnail_url,
            'short_description' => $validated['short_description'],
            'full_description' => $validated['full_description'],
            'tech_stack' => $techStack,
            'demo_url' => $validated['demo_url'],
            'repo_url' => $validated['repo_url'],
        ]);

        return redirect()->route('admin.dashboard', ['tab' => 'projects'])->with('admin_success', 'Proyek berhasil diperbarui!');
    }

    public function destroyProject(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Project::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'projects'])->with('admin_success', 'Proyek dipindahkan ke Trash (Soft Delete).');
    }

    public function restoreProject(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Project::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Proyek berhasil dipulihkan dari Trash!');
    }

    public function forceDeleteProject(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Project::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Proyek dihapus secara permanen.');
    }

    // =========================================================================
    // CERTIFICATES & ACHIEVEMENTS CRUD + SOFT DELETES
    // =========================================================================

    public function storeCertificate(Request $request): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'issuer' => ['required', 'string', 'max:150'],
            'issue_date' => ['nullable', 'string', 'max:50'],
            'image_url' => ['nullable', 'string', 'max:255'],
            'credential_url' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:certificate,achievement'],
        ]);

        $defaultImg = $validated['type'] === 'achievement'
            ? '/images/certificates/award-honor.svg'
            : '/images/certificates/cert-laravel.svg';

        $validated['image_url'] = $validated['image_url'] ?: $defaultImg;
        $validated['issue_date'] = $validated['issue_date'] ?: date('Y');

        Certificate::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'certificates'])->with('admin_success', 'Sertifikat / Penghargaan berhasil ditambahkan!');
    }

    public function destroyCertificate(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Certificate::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'certificates'])->with('admin_success', 'Item dipindahkan ke Trash (Soft Delete).');
    }

    public function restoreCertificate(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Certificate::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Sertifikat / Penghargaan berhasil dipulihkan!');
    }

    public function forceDeleteCertificate(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Certificate::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Sertifikat / Penghargaan dihapus permanen.');
    }

    // =========================================================================
    // TECH STACK SKILLS CRUD
    // =========================================================================

    public function storeSkill(Request $request): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'icon_url' => ['nullable', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:60'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $validated['icon_url'] = $validated['icon_url'] ?: Project::resolveDeviconUrl($validated['name']);
        $validated['category'] = $validated['category'] ?: 'Tech Stack';
        $validated['sort_order'] = $validated['sort_order'] ?? 10;

        Skill::create($validated);

        return redirect()->route('admin.dashboard', ['tab' => 'skills'])->with('admin_success', 'Skill teknologi berhasil ditambahkan!');
    }

    public function destroySkill(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        Skill::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'skills'])->with('admin_success', 'Skill teknologi berhasil dihapus.');
    }

    // =========================================================================
    // CONTACT MESSAGES INBOX + SOFT DELETES
    // =========================================================================

    public function toggleMessageRead(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $msg = ContactMessage::findOrFail($id);
        $msg->update(['is_read' => ! $msg->is_read]);

        return redirect()->route('admin.dashboard', ['tab' => 'messages'])->with('admin_success', 'Status pesan berhasil diperbarui.');
    }

    public function destroyMessage(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        ContactMessage::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'messages'])->with('admin_success', 'Pesan kontak dipindahkan ke Trash.');
    }

    public function restoreMessage(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        ContactMessage::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Pesan kontak berhasil dipulihkan!');
    }

    public function forceDeleteMessage(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        ContactMessage::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Pesan kontak dihapus permanen.');
    }

    // =========================================================================
    // PUBLIC COMMENTS MODERATION + SOFT DELETES
    // =========================================================================

    public function toggleCommentApproval(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        $comment = PublicComment::findOrFail($id);
        $comment->update(['is_approved' => ! $comment->is_approved]);

        return redirect()->route('admin.dashboard', ['tab' => 'comments'])->with('admin_success', 'Status visibilitas komentar diperbarui.');
    }

    public function destroyComment(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        PublicComment::findOrFail($id)->delete();

        return redirect()->route('admin.dashboard', ['tab' => 'comments'])->with('admin_success', 'Komentar dipindahkan ke Trash (Soft Delete).');
    }

    public function restoreComment(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        PublicComment::onlyTrashed()->findOrFail($id)->restore();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Komentar pengunjung berhasil dipulihkan!');
    }

    public function forceDeleteComment(Request $request, int $id): RedirectResponse
    {
        if (! $this->isAuthenticated($request)) {
            return redirect()->route('admin.login');
        }

        PublicComment::onlyTrashed()->findOrFail($id)->forceDelete();

        return redirect()->route('admin.dashboard', ['tab' => 'trash'])->with('admin_success', 'Komentar pengunjung dihapus permanen.');
    }
}
