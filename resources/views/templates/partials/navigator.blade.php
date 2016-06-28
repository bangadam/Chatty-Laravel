<nav class="navbar navbar-default">
  <div class="container-fluid atas">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="{{ route('home') }}">Chatty Laravel</a>
    </div>
    <div class="collapse navbar-collapse">
      @if(Auth::check())
      <ul class="nav navbar-nav">
          <li><a href="{{ route('home') }}">TimeLine</a></li>
          <li><a href="{{ route('friend.index') }}">Friends</a></li>

          <form class="navbar-form navbar-left" role="search" action="{{ route('search.results') }}">
            <div class="form-group">
              <input type="text" name="query" class="form-control" placeholder="Cari Teman">
              <button type="submit" class="btn btn-primary">Search</button>
            </div>
          </form>
      </ul>
      @endif
      <ul class="nav navbar-nav navbar-right">
        @if(Auth::check())
          <li><a href="{{ route('profile.index', ['username'
            => Auth::user()->username]) }}">{{ Auth::user()->getFirstNameOrUsername() }}</a></li>
          <li><a href="{{ route('profile.edit') }}">Profile</a></li>
          <li><a href="{{ route('auth.signout') }}">Keluar</a></li>
        @else
          <li><a href="{{ route('auth.signup') }}">Daftar</a></li>
          <li><a href="{{ route('auth.signin') }}">Masuk</a></li>
        @endif
      </ul>
    </div>

  </div><!-- /.container-fluid -->
</nav>
