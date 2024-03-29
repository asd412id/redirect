<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="{{ asset('/imgs/favicon.png') }}" type="image/x-icon" />

  <title>{{ @$title??'Short Link' }} - Macca.id</title>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

  <!-- Styles -->
  <style>
    html,
    body {
      background-color: #fff;
      color: #636b6f;
      font-family: 'Nunito', sans-serif;
      font-weight: 200;
      height: 100vh;
      margin: 0;
    }

    .full-height {
      height: 100vh;
    }

    .flex-center {
      align-items: center;
      display: flex;
      justify-content: center;
    }

    .position-ref {
      position: relative;
    }

    .top-right {
      position: absolute;
      right: 10px;
      top: 18px;
    }

    .content {
      text-align: center;
    }

    .title {
      font-size: 84px;
    }

    .links>a {
      color: #636b6f;
      padding: 0 25px;
      font-size: 13px;
      font-weight: 600;
      letter-spacing: .1rem;
      text-decoration: none;
      text-transform: uppercase;
    }

    .m-b-md {
      margin-bottom: 30px;
    }
  </style>
</head>

<body>
  <div class="flex-center position-ref full-height">
    <div class="content">
      <div class="title m-b-md">
        @if (!isset($data))
        {{ $title }} :'-(
        @else
        {{ $data->name }}
        @endif
      </div>
      @if (isset($data))
      <h1>saat ini belum tersedia</h1>
      @endif
      <p class="text-center pt-3 pb-1"><em>Copyright &copy;2021 by <a href="https://www.facebook.com/aezdar"
            target="_blank">asd412id</a></em></p>
    </div>
  </div>
</body>

</html>