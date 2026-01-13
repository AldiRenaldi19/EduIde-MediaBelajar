<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Course;
use App\Models\Module;
use App\Models\Category;
use Illuminate\Http\UploadedFile;

class AdminModuleUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_module_thumbnail()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $category = Category::create(['name' => 'UploadCat', 'slug' => 'upload-cat']);

        $course = Course::create([
            'author_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Course Upload',
            'slug' => 'course-upload',
            'description' => 'Desc',
            'price' => 0,
            'level' => 'beginner',
            'is_published' => false,
        ]);

        $module = $course->modules()->create([
            'title' => 'Thumb Module',
            'slug' => 'thumb-module',
            'order' => 1,
        ]);

        // Mock CloudinaryClient
        $mock = \Mockery::mock(\App\Services\CloudinaryClient::class);
        $mock->shouldReceive('upload')->once()->andReturn([
            'secure_url' => 'https://res.cloudinary.com/demo/image/upload/v1/thumb.jpg'
        ]);
        $this->app->instance(\App\Services\CloudinaryClient::class, $mock);

        $file = UploadedFile::fake()->image('thumb.jpg')->size(500);

        $response = $this->actingAs($admin)->post(route('admin.modules.thumbnail.update', $module->id), [
            'thumbnail' => $file,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('modules', [
            'id' => $module->id,
            'thumbnail' => 'https://res.cloudinary.com/demo/image/upload/v1/thumb.jpg',
        ]);
    }

    public function test_admin_can_upload_module_content_file()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $category = Category::create(['name' => 'UploadCat2', 'slug' => 'upload-cat-2']);

        $course = Course::create([
            'author_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Course Content',
            'slug' => 'course-content',
            'description' => 'Desc',
            'price' => 0,
            'level' => 'beginner',
            'is_published' => false,
        ]);

        $module = $course->modules()->create([
            'title' => 'Video Module',
            'slug' => 'video-module',
            'order' => 1,
        ]);

        $mock = \Mockery::mock(\App\Services\CloudinaryClient::class);
        $mock->shouldReceive('upload')->once()->andReturn([
            'secure_url' => 'https://res.cloudinary.com/demo/video/upload/v1/video.mp4'
        ]);
        $this->app->instance(\App\Services\CloudinaryClient::class, $mock);

        $file = UploadedFile::fake()->create('video.mp4', 2048, 'video/mp4');

        $response = $this->actingAs($admin)->post(route('admin.modules.content.update', $module->id), [
            'content_option' => 'file',
            'file' => $file,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('modules', [
            'id' => $module->id,
            'content_url' => 'https://res.cloudinary.com/demo/video/upload/v1/video.mp4',
            'content_type' => 'video',
            'attachment_mime' => 'video/mp4',
        ]);
    }
}
