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
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\View\View;

class PortfolioController extends Controller
{
    /**
     * Render the main top-to-bottom interactive portfolio page.
     */
    public function index(): View
    {
        Carbon::setLocale('id');

        $profile = Profile::first() ?? new Profile([
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
            'github_url' => 'https://github.com/bagaspujiferian',
            'github_username' => '@bagaspujiferian',
            'instagram_url' => 'https://instagram.com/bagaspujiferian',
            'instagram_username' => '@bagaspujiferian',
            'tiktok_url' => 'https://tiktok.com/@bagas.dev',
            'tiktok_username' => '@bagas.dev',
            'linkedin_url' => 'https://linkedin.com/in/bagas-puji-ferian',
            'email' => 'bagaspujiferian@gmail.com',
        ]);

        $educations = Education::orderBy('sort_order')->orderBy('id')->get();
        $experiences = Experience::orderBy('sort_order')->orderBy('id')->get();
        $projects = Project::orderBy('sort_order')->orderBy('id')->get();
        $certificates = Certificate::certificates()->orderBy('sort_order')->orderBy('id')->get();
        $achievements = Certificate::achievements()->orderBy('sort_order')->orderBy('id')->get();
        $skills = Skill::orderBy('sort_order')->orderBy('id')->get();
        $comments = PublicComment::where('is_approved', true)
            ->orderByDesc('is_pinned')
            ->latest()
            ->get();

        $projectsCount = $profile->projects_count_override ?? $projects->count();
        $certificatesCount = $profile->certificates_count_override ?? $certificates->count();
        $awardsCount = $profile->awards_count_override ?? $achievements->count();

        return view('portfolio.index', compact(
            'profile',
            'educations',
            'experiences',
            'projects',
            'certificates',
            'achievements',
            'skills',
            'comments',
            'projectsCount',
            'certificatesCount',
            'awardsCount'
        ));
    }

    /**
     * Render the dedicated Project Detail View (/project/{slug}).
     */
    public function showProject(string $slug): View
    {
        Carbon::setLocale('id');

        $profile = Profile::first() ?? new Profile([
            'name' => 'Bagas Puji Ferian',
            'brand_name' => 'BagasDev.',
            'github_url' => 'https://github.com/bagaspujiferian',
            'instagram_url' => 'https://instagram.com/bagaspujiferian',
            'tiktok_url' => 'https://tiktok.com/@bagas.dev',
        ]);

        $project = Project::where('slug', $slug)->firstOrFail();
        $otherProjects = Project::where('id', '!=', $project->id)
            ->orderBy('sort_order')
            ->take(3)
            ->get();

        return view('portfolio.show', compact('profile', 'project', 'otherProjects'));
    }

    /**
     * Store a new Contact Message ("Hubungi saya" form).
     */
    public function storeContact(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'message' => ['required', 'string', 'max:3000'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Alamat email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'message.required' => 'Pesan wajib diisi.',
        ]);

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'is_read' => false,
            'ip_address' => $request->ip(),
        ]);

        $successText = 'Terima kasih! Pesan kamu sudah terkirim ke Bagas Puji Ferian.';

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successText,
            ]);
        }

        return redirect()->to(url()->previous().'#contact')->with('contact_success', $successText);
    }

    /**
     * Store a new Public Guestbook Comment ("Komentar" section) with Base64 avatar conversion.
     */
    public function storeComment(Request $request): JsonResponse|RedirectResponse
    {
        Carbon::setLocale('id');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:80'],
            'comment' => ['required', 'string', 'max:1000'],
            'avatar' => ['nullable', 'file', 'mimes:jpg,jpeg,png,webp,gif,svg', 'max:5120'], // max 5 MB
        ], [
            'name.required' => 'Nama kamu wajib diisi.',
            'comment.required' => 'Komentar tidak boleh kosong.',
            'avatar.mimes' => 'Format foto harus berupa JPG, PNG, WebP, GIF, atau SVG.',
            'avatar.max' => 'Ukuran file foto profil maksimal 5 MB.',
        ]);

        $avatarBase64 = null;

        if ($request->hasFile('avatar') && $request->file('avatar')->isValid()) {
            $avatarBase64 = $this->convertUploadedImageToBase64($request->file('avatar'));
        }

        $comment = PublicComment::create([
            'name' => $validated['name'],
            'comment' => $validated['comment'],
            'avatar_base64' => $avatarBase64,
            'is_approved' => true,
            'is_pinned' => false,
        ]);

        $totalComments = PublicComment::where('is_approved', true)->count();

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Komentar kamu berhasil ditambahkan!',
                'total_count' => $totalComments,
                'comment' => [
                    'id' => $comment->id,
                    'name' => $comment->name,
                    'comment' => $comment->comment,
                    'avatar_base64' => $comment->avatar_base64,
                    'relative_time' => $comment->relative_time,
                ],
            ]);
        }

        return redirect()->to(url()->previous().'#guestbook')->with('comment_success', 'Komentar kamu berhasil dipublikasikan!');
    }

    /**
     * Resize and convert an uploaded profile image into a Base64 Data URL for serverless MySQL storage.
     */
    private function convertUploadedImageToBase64(UploadedFile $file): ?string
    {
        $mime = $file->getMimeType() ?: 'image/jpeg';
        $rawContents = @file_get_contents($file->getRealPath());

        if ($rawContents === false) {
            return null;
        }

        // If GD extension is available and image is a raster image, resize to 160x160 WebP/JPEG to keep DB fast
        if (function_exists('imagecreatefromstring') && ! str_contains($mime, 'svg')) {
            $srcImg = @imagecreatefromstring($rawContents);
            if ($srcImg !== false) {
                $width = imagesx($srcImg);
                $height = imagesy($srcImg);
                $targetSize = 160;

                // Center crop square
                $minDim = min($width, $height);
                $srcX = (int) (($width - $minDim) / 2);
                $srcY = (int) (($height - $minDim) / 2);

                $dstImg = imagecreatetruecolor($targetSize, $targetSize);
                imagealphablending($dstImg, false);
                imagesavealpha($dstImg, true);

                imagecopyresampled(
                    $dstImg,
                    $srcImg,
                    0,
                    0,
                    $srcX,
                    $srcY,
                    $targetSize,
                    $targetSize,
                    $minDim,
                    $minDim
                );

                ob_start();
                if (function_exists('imagewebp')) {
                    imagewebp($dstImg, null, 82);
                    $outMime = 'image/webp';
                } else {
                    imagejpeg($dstImg, null, 85);
                    $outMime = 'image/jpeg';
                }
                $compressedBytes = ob_get_clean();

                imagedestroy($srcImg);
                imagedestroy($dstImg);

                if ($compressedBytes) {
                    return 'data:'.$outMime.';base64,'.base64_encode($compressedBytes);
                }
            }
        }

        return 'data:'.$mime.';base64,'.base64_encode($rawContents);
    }
}
