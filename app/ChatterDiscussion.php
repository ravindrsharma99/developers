<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatterDiscussion extends Model
{
    protected $table = 'chatter_discussion';

    protected $fillable = [
        'chatter_category_id', 'title', 'user_id', 'sticky', 'views', 'answered', 'slug', 'color'
    ];

    public function user(){
        return $this->belongsTo('App\WebUser', 'user_id');
    }

    public function category(){
        return $this->belongsTo('App\ChatterCategory', 'chatter_category_id');
    }

    public function getPosts(){
        $posts = \App\ChatterPost::where('chatter_discussion_id', $this->id)
        ->get();

        return $posts;
    }

    public function posts()
    {
        return $this->hasMany('App\ChatterPost', 'chatter_discussion_id');
    }

    public function getTitle(){
        return $this->title;
    }

    public function getLastPost(){
        $post = \App\ChatterPost::where('chatter_discussion_id', $this->id)
        ->orderBy('id', 'DESC')
        ->take(1)
        ->first();

        return $post;
    }

    public function postsCount()
    {
        return $this->posts()
        ->selectRaw('chatter_discussion_id, count(*)-1 as total')
        ->groupBy('chatter_discussion_id');
    }
}
