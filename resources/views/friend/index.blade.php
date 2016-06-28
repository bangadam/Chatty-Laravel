@extends('templates.default')

@section('content')
  <div class="row">
    <h4>Teman Anda :</h4>
    <div class="col-lg-6">
      @if(!$friends->count())
        <h4>Anda Tidak Memiliki Teman</h4>
      @else
        @foreach($friends as $user)
          @include('user/partials/userblok')
        @endforeach
      @endif
    </div>

    <h4>Permintaan Pertemanan :</h4>
    <div class="col-lg-6">
      @if(!$request->count())
        <p>
          Kamu Tidak Memiliki Permintaan Pertemanan.
        </p>
        @else
          @foreach($request as $user)
            @include('user.partials.userblok')
          @endforeach
      @endif
    </div>
  </div>
@endsection
