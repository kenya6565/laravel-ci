<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model
{
    protected $fillable = [
        'title',
        'body',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo('App\User');
    }

    public function likes(): BelongsToMany
    //belongsToManyメソッドを用いて、ArticleモデルとUserモデルを、likesテーブルを通じた多対多の関係で結び付けています。
    {
        return $this->belongsToMany('App\User', 'likes')->withTimestamps();
    }

    //Userと記述されていることで、引数$userの型はUserクラスのインスタンスであることが宣言されています。
    // さらにUserの手前に?があることで、引数としてnullが渡されることを許容しています
    //: boolとあるのは、このメソッドの戻り値が論理型(trueかfalse)であることを宣言しています。
    public function isLikedBy(?User $user): bool
    {
        // $userがnullでなければ、下記を行う
        return $user
        //このlikeは動的プロパティlikesを使用しています
        //likesリレーションメソッドは、isLikedByメソッドと同じくArticleモデルに存在します。
        // /countメソッドは、コレクションの要素数を数えて、数値を返します。
        // /この記事をいいねしたユーザーの中に、引数として渡された$userがいれば、1かそれより大きい数値が返る
        //この記事をいいねしたユーザーの中に、引数として渡された$userがいなければ、0が返る
        //(bool)とあるのは、型キャストと呼ばれるPHPの機能です。
        //変数の前に記述し、その変数を括弧内に指定した型に変換します。
        //(bool)と記述することで変数を論理値、つまりtrueかfalseに変換します。
            ? (bool)$this->likes->where('id', $user->id)->count()
            : false;
    }

    public function getCountLikesAttribute(): int
    {
        return $this->likes->count();
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany('App\Tag')->withTimestamps();
    }
}
