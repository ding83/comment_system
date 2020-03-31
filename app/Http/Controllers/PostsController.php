<?php

namespace App\Http\Controllers;

use App\Post;
use Exception;

class PostsController extends Controller
{
  public function getBlogIndex($id=null)
  {
    try {

      if ($id) {
        $list = Post::whereNotIn('post_id', [$id])->limit(5)->get();
        $post = Post::findOrFail($id);

        return view('post', ['post' => $post, 'list' => $list]);
      }

      $list = Post::get();
      return view('list', ['list' => $list]);

    } catch (Exception $e) {}

    return view('error', ['message' => 'There was an error in comment section.']);
  }
}