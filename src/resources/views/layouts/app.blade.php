<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>会員登録画面</title>
  <link rel="stylesheet" href="{{ asset('css/common.css')}}">
  @yield('css')
</head>

<body>
    <header class="header">
      <div class="header__inner">
       <img src="{{ asset('img/logo.svg')}}" >
      </div>
    </header>

    <div class="content">
      @yield('content')
    </div>
  </div>
</body>

</html>