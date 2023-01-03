<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostVote;
use Illuminate\Http\Request;

class PostVoteController extends Controller
{
    public function upVote(Post $post)
    {
        $voted = PostVote::where('post_id', $post->id)->where('user_id', auth()->id())->first();
        if (!is_null($voted)) {
            if ($voted->vote === -1) {
                $voted->update(['vote' => 1]);
                $post->increment('votes', 2);
                return redirect()->back();
            } elseif ($voted->vote === 1) {
                return redirect()->back();
            }
        } else {
            PostVote::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'vote' => 1,
            ]);
            $post->increment('votes', 1);
            return redirect()->back();
        }
    }
    public function downVote(Post $post)
    {
        $downVoted = PostVote::where('post_id', $post->id)->where('user_id', auth()->id())->first();
        if (!is_null($downVoted)) {
            if ($downVoted->vote === 1) {
                $downVoted->update(['vote' => -1]);
                $post->decrement('votes', 2);
                return redirect()->back();
            } elseif ($downVoted->vote === 1) {
                return redirect()->back();
            }
        }
        else {
            PostVote::create([
                'post_id' => $post->id,
                'user_id' => auth()->id(),
                'vote' => -1
            ]);
            $post->decrement('votes', 1);
            return redirect()->back();
        }
    }
}
