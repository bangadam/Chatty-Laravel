@extends('templates.default')

@section('content')
  <div class="row">
    <div class="col-md-6">
    <h3>Masuk</h3>
      <form class="form-vertical" role="form" action="{{ route('auth.signin') }}" method="post">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="email" class="control-label">Email Anda</label>
          <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="{{ Request::old('email') ?: '' }}">
        </div>
        @if($errors->has('email'))
          <span class="help-block">{{ $errors->first('email') }}</span>
        @endif

        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
          <label for="password" class="control-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="{{ Request::old('password') ?: '' }}">
        </div>
        @if($errors->has('password'))
          <span class="help-block">{{ $errors->first('password') }}</span>
        @endif

        <div class="form-group">
          <label for="remember">
            <input type="checkbox" name="remember"> Remember Me
          </label>
        </div>

        <div class="form-group">
          <button type="submit" class="btn btn-primary">Masuk</button>
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
      </form>
    </div>
  </div>
@endsection
