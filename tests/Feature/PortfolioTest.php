<?php

namespace Tests\Feature;

use App\Models\Certificate;
use App\Models\ContactMessage;
use App\Models\Education;
use App\Models\Experience;
use App\Models\Profile;
use App\Models\Project;
use App\Models\PublicComment;
use App\Models\Skill;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class PortfolioTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_populates_all_eight_tables_and_renders_home_page(): void
    {
        $this->seed(DatabaseSeeder::class);

        $this->assertEquals(1, Profile::count());
        $this->assertGreaterThanOrEqual(1, Education::count());
        $this->assertGreaterThanOrEqual(1, Experience::count());
        $this->assertGreaterThanOrEqual(4, Project::count());
        $this->assertGreaterThanOrEqual(6, Certificate::count());
        $this->assertEquals(12, Skill::count());
        $this->assertGreaterThanOrEqual(2, ContactMessage::count());
        $this->assertEquals(6, PublicComment::count());

        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('BagasDev.');
        $response->assertSee('Bagas Puji Ferian');
        $response->assertSee('UNIVERSITAS BSI');
        $response->assertSee('PT Astagina Praptama Aksaya');
        $response->assertSee('A little music.');
        $response->assertSee('HRIS Attendance System V2');
        $response->assertSee('Database Siswa');
        $response->assertSee('Hubungi saya');
        $response->assertSee('Komentar');
    }

    public function test_project_detail_page_renders_correctly(): void
    {
        $this->seed(DatabaseSeeder::class);

        $response = $this->get('/project/hris-attendance-system-v2');
        $response->assertStatus(200);
        $response->assertSee('HRIS Attendance System V2');
        $response->assertSee('Technologies Used');
        $response->assertSee('Laravel');

        $response2 = $this->get('/project/database-siswa');
        $response2->assertStatus(200);
        $response2->assertSee('Database Siswa');
    }

    public function test_contact_form_stores_message(): void
    {
        $response = $this->postJson('/contact', [
            'name' => 'Recruiter Test',
            'email' => 'recruiter@company.id',
            'message' => 'Halo Bagas, mari jadwal interview.',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Recruiter Test',
            'email' => 'recruiter@company.id',
        ]);
    }

    public function test_guestbook_comment_stores_with_base64_avatar(): void
    {
        $svgContent = '<svg xmlns="http://www.w3.org/2000/svg" width="40" height="40"><rect width="40" height="40" fill="blue"/></svg>';
        $file = UploadedFile::fake()->createWithContent('avatar.svg', $svgContent);

        $response = $this->postJson('/comment', [
            'name' => 'Pengunjung Baru',
            'comment' => 'Portofolio 3D sangat keren!',
            'avatar' => $file,
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $saved = PublicComment::where('name', 'Pengunjung Baru')->first();
        $this->assertNotNull($saved);
        $this->assertStringStartsWith('data:', (string) $saved->avatar_base64);
    }

    public function test_admin_cms_login_and_soft_deletes_restore_force_delete(): void
    {
        $this->seed(DatabaseSeeder::class);

        $loginResp = $this->post('/admin/login', [
            'email' => 'admin@bagas.dev',
            'password' => 'password123',
        ]);
        $loginResp->assertRedirect(route('admin.dashboard'));

        $dashResp = $this->get('/admin');
        $dashResp->assertStatus(200);
        $dashResp->assertSee('Tabler CMS');

        $project = Project::first();
        $this->delete(route('admin.projects.destroy', $project->id))
            ->assertRedirect();

        $this->assertSoftDeleted('projects', ['id' => $project->id]);
        $this->assertEquals(1, Project::onlyTrashed()->count());

        // Restore
        $this->post(route('admin.projects.restore', $project->id))
            ->assertRedirect();
        $this->assertEquals(0, Project::onlyTrashed()->count());

        // Soft delete again & force delete
        $project->delete();
        $this->delete(route('admin.projects.force-delete', $project->id))
            ->assertRedirect();
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
