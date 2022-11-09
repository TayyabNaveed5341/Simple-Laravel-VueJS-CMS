<?php

namespace Tests\Feature;

use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Tests\TestCase;

class PageTest extends TestCase
{
    use WithFaker;

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
}
