<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Articleテーブルの設定
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('body');
            $table->bigInteger('user_id');
            //articlesテーブルのuser_idカラムは、usersテーブルのidカラムを参照することという制約になります。
            //ですので、user_idカラムは、usersテーブルに存在しないidを持つことができません。
            //つまり、「記事は存在するけれど、それを投稿したユーザーが存在しない」という状態を作れないようにしてあります。
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
