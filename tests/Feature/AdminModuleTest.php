<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Course;
use App\Models\Category;

class AdminModuleTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_module_for_course()
    {
        // create admin user
        $admin = User::factory()->create(['is_admin' => true]);

        // create a simple category needed for course
        $category = Category::create(['name' => 'Test Category', 'slug' => 'test-category']);

        // create a course
        $course = Course::create([
            'author_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Course for Modules',
            'slug' => 'course-for-modules',
            'description' => 'Desc',
            'price' => 0,
            'level' => 'beginner',
            'is_published' => false,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.courses.modules.store', $course->id), [
            'title' => 'Intro Module',
            'order' => 1,
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('modules', [
            'title' => 'Intro Module',
            'course_id' => $course->id,
        ]);
    }

    public function test_admin_can_attach_module_content_via_url()
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $category = Category::create(['name' => 'Test Category', 'slug' => 'test-category-2']);

        $course = Course::create([
            'author_id' => $admin->id,
            'category_id' => $category->id,
            'title' => 'Course for Content',
            'slug' => 'course-for-content',
            'description' => 'Desc',
            'price' => 0,
            'level' => 'beginner',
            'is_published' => false,
        ]);

        // create module first
        $module = $course->modules()->create([
            'title' => 'Link Module',
            'slug' => 'link-module',
            'order' => 1,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.modules.content.update', $module->id), [
            'content_option' => 'url',
            'url' => 'https://youtu.be/dQw4w9WgXcQ'
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('modules', [
            'id' => $module->id,
            'content_url' => 'https://youtu.be/dQw4w9WgXcQ',
            'content_type' => 'video',
        ]);
    }
}
