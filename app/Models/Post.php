<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
class Post extends Model
{
    use HasFactory;

    protected $fillable =  [
        'user_id',
        'community_id',
        'title',
        'slug', 'description', 'url','vote'
    ];
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function comments(){
        return $this->hasMany(Comment::class);
    }
    public function community(){
        return $this->belongsTo(Community::class);
    }
    public function postVotes(){
        return $this->hasMany(PostVote::class);
    }
}
