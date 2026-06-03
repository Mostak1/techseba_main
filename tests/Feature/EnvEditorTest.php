<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Admin;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EnvEditorTest extends TestCase
{
    use DatabaseTransactions;

    protected $envBackupPath;
    protected $originalEnvContent;

    protected function setUp(): void
    {
        parent::setUp();

        $this->envBackupPath = base_path('.env.backup_test');
        if (File::exists(base_path('.env'))) {
            $this->originalEnvContent = File::get(base_path('.env'));
            File::put($this->envBackupPath, $this->originalEnvContent);
        }
    }

    protected function tearDown(): void
    {
        if (File::exists($this->envBackupPath)) {
            File::put(base_path('.env'), File::get($this->envBackupPath));
            File::delete($this->envBackupPath);
        }
        parent::tearDown();
    }

    public function test_admin_can_access_general_settings_with_env_content()
    {
        $admin = Admin::where('status', 'enable')->first();
        if (!$admin) {
            $admin = Admin::factory()->create(['status' => 'enable']);
        }

        $response = $this->actingAs($admin, 'admin')->get(route('admin.general-setting'));

        $response->assertStatus(200);
        $response->assertViewHas('env_content');
        $response->assertSee('Environment Mail/DB (.env)');
    }

    public function test_admin_can_update_env_content()
    {
        $admin = Admin::where('status', 'enable')->first();
        if (!$admin) {
            $admin = Admin::factory()->create(['status' => 'enable']);
        }

        $newEnvContent = $this->originalEnvContent . "\n# TEST_COMMENT_FROM_TEST_SUITE=true\n";

        $response = $this->actingAs($admin, 'admin')
            ->put(route('admin.update-env-setting'), [
                'env_content' => $newEnvContent
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('message', trans('translate.Updated successfully'));

        // Assert that file is updated
        $updatedContent = File::get(base_path('.env'));
        $this->assertStringContainsString('# TEST_COMMENT_FROM_TEST_SUITE=true', $updatedContent);
    }
}
