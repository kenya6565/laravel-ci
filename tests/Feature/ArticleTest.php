<?php

namespace Tests\Feature;

use App\Article;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    public function testIsLikedByNull()
    {
        // factory(Article::class)->create()とすることで、ファクトリによって生成されたArticleモデルがデータベースに保存されます。
        //また、createメソッドは保存したモデルのインスタンスを返すので、これが変数$articleに代入されます.なので$articleはArticleのメソッドが使える
        $article = factory(Article::class)->create();
        
        $result = $article->isLikedBy(null);

        //assertFalseメソッドは、引数がfalseかどうかをテストします。
        $this->assertFalse($result);
    }
    //いいねをしているケース
    public function testIsLikedByTheUser()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        // /、$article->likes()とすることで、多対多のリレーション(BelongsToManyクラスのインスタンス)が返ります。
        //この多対多のリレーションでは、attachメソッドが使用できます。
        //$article->likes()->attach($user)とすることで、likesテーブルのuser_idには、$userのidの値likesテーブルのarticle_idには、$articleのidの値を持った、likesテーブルのレコードが新規登録されます。
        $article->likes()->attach($user);

        //$userは、この$articleをいいねしたユーザーであるので、$resultにはtrueが代入されるはずです
        $result = $article->isLikedBy($user);

        $this->assertTrue($result);
    }

    //いいねをしていないケース
    public function testIsLikedByAnother()
    {
        $article = factory(Article::class)->create();
        $user = factory(User::class)->create();
        $another = factory(User::class)->create();
        $article->likes()->attach($another);

        $result = $article->isLikedBy($user);

        $this->assertFalse($result);
    }
}
