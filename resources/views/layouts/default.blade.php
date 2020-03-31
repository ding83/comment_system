<!DOCTYPE html>
<html>
<head>
  <title>Post Section</title>
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
  <div id="app">
    @yield('content')
    <footer class="py-5 bg-dark">
    <div class="container">
      <p class="m-0 text-center text-white">Copyright &copy; My Blog 2020</p>
    </div>

  </footer>
  </div>
  <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
</body>
</html>