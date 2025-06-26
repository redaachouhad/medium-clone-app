<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class ClapController extends Controller
{
    public function clap(Post $post){
       
        $hasClapped = $post->claps()
        ->where('user_id', auth()->user()->id)
        ->where('post_id', $post->id)
        ->exists();

        if($hasClapped) {
            // User has already clapped, so we remove the clap
            $post->claps()
            ->where('user_id', auth()->user()->id)
            ->where('post_id', $post->id)
            ->delete();
        }else{
            // User has not clapped yet, so we add a clap
            $post->claps()->create([
                'user_id' => auth()->user()->id,
                'post_id' => $post->id,
            ]);
        }
        
        return response()->json([
            'count' => $post->claps()->count(),
        ]);
    }
}
