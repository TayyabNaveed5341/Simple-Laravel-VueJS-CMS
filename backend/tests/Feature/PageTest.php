<?php

namespace Tests\Feature;

use App\Models\Page;
use App\Services\PageService;
use Database\Factories\PageFactory;
use Database\Seeders\PageSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PageTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $seeder = PageSeeder::class;

    private function getRandomPage(){
        return Page::inRandomOrder()->first();
    }
    /**
     * Tests page creation
     *
     * @return void
     */
    public function test_page_creation()
    {
        $rPage = $this->getRandomPage();
        $parentId = (rand(0, 1) && $rPage)?$rPage->id:null;
        $name = $this->faker->company();
        $slug = Str::slug($name);
        $data = [
            'parent_id'=>$parentId,
            'title'=>$name,
            'slug'=>$slug,
            'content'=>$this->faker->realText(200)
        ];

        $response = $this->post('/api/pages', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('pages', $data);
    }

    public function test_page_get(){

        $fSlug = $this->getRandomPage()->full_slug_path;
        
        $res = $this->getJson('/api/pages/'.$fSlug);
        $res->assertStatus(200);
        $res->assertJsonStructure(['page']);
    }
    public function test_page_index(){

        $res = $this->getJson('/api/pages');
        $res->assertStatus(200);
        $res->assertJsonStructure(['data']);
    }
    public function test_page_update(){
        $page = $this->getRandomPage();
        $title = $this->faker->jobTitle().rand(1, 9);
        $slug = Str::slug($title, '-');
        $parentId = $this->getRandomPage()->id;
        $data = [
            'parent_id'=>$parentId==$page->id?null:$parentId,
            'title'=>$title,
            'slug'=>$slug,
            'content'=>$this->faker->realText(400),
        ];

        $res = $this->putJson("/api/pages/$page->full_slug_path", $data);
        $res->assertStatus(200);
        $res->assertJsonStructure(['message']);
        $this->assertDatabaseHas('pages', $data);
        $this->assertEquals((new PageService)->generateFullPath($page), $page->fresh()->full_slug_path);
    }
    public function test_page_delete(){
        $page = $this->getRandomPage();
        $res = $this->deleteJson("/api/pages/$page->full_slug_path");
        $res->assertStatus(200);
        $this->assertDatabaseMissing('pages', ['id'=>$page->id]);
        $this->assertDatabaseMissing('pages', ['parent_id'=>$page->id]);
    }
}
