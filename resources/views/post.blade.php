@extends('layouts.default')

@section('content')
<div class="container">

    <div class="row">

      <!-- Post Content Column -->
      <div class="col-lg-8">

        <!-- Title -->
        <h1 class="mt-4">{{ $post->title }}</h1>

        <!-- Author -->
        <p class="lead">by <a href="#">{{ $post->author }}</a></p>

        <hr>

        <!-- Date/Time -->
        <p>Posted on {{ date('F j, Y', strtotime($post->created_at)) }}</p>

        <hr>

        <!-- Post Content -->
        <p class="lead">{{ $post->content }}</p>
        <hr>

        <!-- Comments Form -->
        <comment-form></comment-form>
        <comments></comments>

      </div>

      <!-- Sidebar Widgets Column -->
      <div class="col-md-4">

        <!-- Side Widget -->
        <div class="card my-4">
          <h5 class="card-header">Related Posts</h5>
          <div class="card-body">
            <ul>
              @for ($i = 0; $i < count($list); $i++)
                <li><a href="{{ url('/posts/'.$list[$i]->post_id) }}">{{ $list[$i]->title }}</a></li>
              @endfor
            </ul>
          </div>
        </div>

      </div>

    </div>
    <!-- /.row -->
  </div>
@endsection
