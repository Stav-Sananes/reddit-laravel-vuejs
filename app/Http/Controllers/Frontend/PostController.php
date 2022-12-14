<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostShowResource;
use App\Models\Community;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class PostController extends Controller
{
    public function show($community_slug, $slug)
    {
        $community = Community::where('slug', $community_slug)->first();
        $post_community =  Post::with(
            ['comments', 'postVotes' => function ($query) {
                $query->where('user_id', auth()->id());
            }]

        )->where('slug', $slug)->first();
        $post = new PostShowResource($post_community );
        $posts = PostResource::collection($community->posts()->orderBy('votes', 'desc')->take(6)->get());

        $update = Auth::check() ? Auth::user()->can('update',$post_community) : false;
        $delete = Auth::check() ? Auth::user()->can('delete',$post_community) : false;
        return Inertia::render('Frontend/Posts/Show', compact('community', 'post','update','delete'));
    }
}
