@extends('templates.default')

@section('content')
  <h3>Pencarian Untuk "{{ Request::input('query') }}"</h3>
  <div class="row">
    @if(!$users->count())
      <h4>Maaf Teman yang anda cari tidak ada</h4>
    @else
    <div class="col-lg-12">
      @foreach($users as $user)
        @include('user/partials/userblok')
      @endforeach
    </div>
  </div>
  @endif

@endsection
