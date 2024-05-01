<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Sushi\Sushi;

class Post extends Model
{
    use Sushi;

    public function getRows()
    {
        $posts = Http::get('https://dummyjson.com/posts')->json();
        $posts = Arr::map($posts['posts'], function ($item) {
            return Arr::only(
                $item,
                [
                    'id',
                    'title',
                    'body',
                    'userId',
                    'tags',
                    'reactions',
                ]
            );
        });
        return $posts;
    }
}
