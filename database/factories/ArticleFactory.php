<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;
use App\User;

//記事のでもデータ
$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => $faker->text(50),
        'body' => $faker->text(500),

        //ファクトリでこのようなカラムを取り扱う時は、値として以下のように「参照先のモデルを生成するfactory関数」を返すクロージャ(無名関数)をセットするようにします。
        //これにより、Articleモデルをファクトリで生成した時に併せてUserモデルがファクトリで生成され、そのUserモデルのidがArticleモデルのuser_idカラムにセットされるようになります。
        'user_id' => function() {
            return factory(User::class);
        }
    ];
});
