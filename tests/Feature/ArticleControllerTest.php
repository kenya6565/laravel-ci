<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ArticleControllerTest extends TestCase
{
     //==========ここから追加==========
     use RefreshDatabase;
    
     public function testIndex()
     {
         $response = $this->get(route('articles.index'));
 
         $response->assertStatus(200)
             ->assertViewIs('articles.index');
     }
     
     //未ログイン状態のケース
    public function testGuestCreate()
    {
        $response = $this->get(route('articles.create'));

        $response->assertRedirect(route('login'));
    }    
    //==========ここまで追加==========
    public function testAuthCreate()
    {
        //factory関数を使用することで、テストに必要なモデルのインスタンスを、ファクトリというものを利用して生成できます。
        // factory(User::class)->create()とすることで、ファクトリによって生成されたUserモデルがデータベースに保存されます。
        $user = factory(User::class)->create();

        //引数として渡したUserモデルにてログインした状態を作り出します。
        //の上で、get(route('articles.create'))を行うことで、ログイン済みの状態で記事投稿画面へアクセスしたことになり、そのレスポンスは変数$responseに代入されます
        $response = $this->actingAs($user)  
            ->get(route('articles.create'));

        $response->assertStatus(200)
            ->assertViewIs('articles.create');
    }
}
