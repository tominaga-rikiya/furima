@section('css')
<link rel="stylesheet" href="{{ asset('css/components/header.css') }}">
@endsection

<header class="header">
  <div class="header__inner">
    <img src="{{ asset('img/logo.svg') }}" alt="Logo">
    <nav>
      <ul class="header-nav">
       
        <li class="header-nav__item">
          <form action="{{ route('item.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="商品名で検索" value="{{ request('search') }}">
            <button type="submit">検索</button>
          </form>
        </li>

        @auth
          <li class="header-nav__item">
            <a class="header-nav__link" href="{{ route('profile.profile') }}">マイページ</a>
          </li>
          <li class="header-nav__item">
            <a class="header-nav__link" href="#">出品</a>
          </li>
          
          <li class="header-nav__item">
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
              @csrf
              <button type="submit" class="logout-button">ログアウト</button>
            </form>
          </li>
        @else
          <li class="header-nav__item">
            <a class="header-nav__link" href="{{ route('login') }}">ログイン</a>
          </li>
        @endauth
      </ul>
    </nav>
     </div>
</header>
