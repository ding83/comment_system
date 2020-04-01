@extends('layouts.default')

@section('content')
<div class="container">
    <div class="row">
      <div style="margin: 100px auto 100px auto; min-width: 800px;">
        <h3>List of Articles</h3>
        <table class="table table-striped">
          <thead>
            <tr>
              <th>Title</th>
              <th>Author</th>
              <th>Date Published</th>
            </tr>
          </thead>
          <tbody>
          @if ($list)
            @foreach($list as $item)
              <tr>
                <td><a href="{{ url('/posts/'.$item->post_id) }}">{{ $item->title }}</a></td>
                <td>{{ $item->author }}</td>
                <td>{{ date('F j, Y', strtotime($item->created_at) ) }}</td>
              </tr>
            @endforeach
          @endif
          </tbody>
        </table>
      </div>
    </div>
</div>
@endsection
