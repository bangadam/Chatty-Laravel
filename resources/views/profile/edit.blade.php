@extends('templates.default')

@section('content')
    <h3>Edit Profile</h3>
  <div class="row">
    <div class="col-lg-6">
      <form class="form-vertical" role="form" action="{{ route('profile.edit') }}" method="post">
        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
          <label for="first_name" class="control-label">First Name</label>
          <input type="text" class="form-control" name="first_name" value="{{ Request::old('first_name') ?: Auth::user()->first_name }}">
        </div>
    </div>
        @if($errors->has('first_name'))
          <span class="help-block">{{ $errors->first('first_name') }}</span>
        @endif

        <div class="col-lg-6">
          <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
            <label for="last_name" class="control-label">Last Name</label>
            <input type="text" class="form-control" name="last_name" value="{{ Request::old('last_name') ?: Auth::user()->last_name }}">
          </div>
          @if($errors->has('last_name'))
            <span class="help-block">{{ $errors->first('last_name') }}</span>
          @endif
        </div>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
            <label for="location" class="control-label">Location</label>
            <input type="text" class="form-control" name="location" value="{{ Request::old('location') ?: Auth::user()->location }}">
          </div>
          @if($errors->has('location'))
            <span class="help-block">{{ $errors->first('location') }}</span>
          @endif
        </div>
        </div>


        <div class="form-group">
          <button type="submit" class="btn btn-primary">Update</button>
        </div>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
      </form>
@endsection
