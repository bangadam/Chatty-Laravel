@extends('templates.default')

@section('content')
  <div class="row">
    <div class="col-lg-5">
      @include('user.partials.userblok')
      <hr>

<!--Status-->
          @if(!$statuses->count())
            <p>
            {{ $user->getFirstNameOrUsername() }} Belum memilki status !
            </p>
            @else
              @foreach($statuses as $status)
                <div class="media">
                  <a href="{{ route('profile.index', ['username' => $status->user->username]) }}" class="pull-left">
                  <img class="media-object" src="{{ $status->user->getGravatarUrl() }}"
                   alt="{{ $status->user->getNameOrUsername() }}" />
                  </a>

                  <div class="media-body">
                    <h4 class="media-heading">
                      <a href="{{ route('profile.index', ['username' => $status->user->username]) }}">
                      {{ $status->user->getNameOrUsername() }}
                      </a>
                    </h4>
                    <p>
                      {{ $status->body }}
                    </p>
                    <ul class="list-inline">
                      <li>{{ $status->created_at->diffForHumans() }}</li>
                      @if($status->user->id !== Auth::user()->id)
                        <li><a href="{{ route('status.like', ['statusId' => $status->id]) }}">like</a></li>
                      @endif
                        <li>{{ $status->likes->count() }} {{ str_plural('like', $status->likes->count()) }}</li>
                    </ul>

                  <!-- Komen-->
                  @foreach($status->replies as $reply)
                    <div class="media">
                      <a href="{{ route('profile.index', ['username' => $reply->user->username]) }}" class="pull-left">
                        <img src="{{ $reply->user->getGravatarUrl() }}" class="media-object" alt="{{ $reply->user->getNameOrUsername() }}" />
                      </a>

                        <div class="media-body">
                          <h4 class="media-heading"><a href="{{ route('profile.index', ['username' => $reply->user->username]) }}">{{ $reply->user->getNameOrUsername() }}</a></h4>
                          <p>
                            {{ $reply->body }}
                          </p>
                          <ul class="list-inline">
                            <li>{{ $reply->created_at->diffForHumans() }}</li>
                            @if($reply->user->id !== Auth::user()->id)
                              <li><a href="{{ route('status.like', ['statusId' => $reply->id]) }}">like</a></li>
                            @endif
                            <li>{{ $reply->likes->count() }} {{ str_plural('like', $reply->likes->count()) }}</li>
                          </ul>
                        </div>
                      </div><!-- Komen-->
                  @endforeach

                  @if($AuthUserIsFriend || Auth::user()->id === $status->user->id)
                    <form role="form" action="{{ route('status.reply', ['statusId' => $status->id]) }}" method="post">
                      <div class="form-group{{ $errors->has("reply-{$status->id}") ? ' has-error': '' }}">
                        <textarea name="reply-{{ $status->id }}" class="form-control" rows="1" placeholder="Tulis Komentar"></textarea>
                      </div>

                          @if($errors->has("reply-{$status->id}"))
                            <span class="help-block">{{ $errors->first("reply-{$status->id}") }}</span>
                          @endif

                      <input type="submit" value="Kirim" class="btn btn-primary">
                      <input type="hidden" name="_token" value="{{ Session::token() }}">
                    </form>
                  @endif

                </div>
              </div>
              @endforeach
          @endif
        <!--Akhir Status-->
      </div>
    <div class="col-lg-4 col-lg-offset-3">
      @if(Auth::user()->hasFriendsRequestPending($user))
          <p>
            Tunggu {{ $user->getNameOrUsername() }} Untuk Menerima permintaan
            pertemanan anda.
          </p>
      @elseif(Auth::user()->hasFriendsRequestRecevied($user))
        <a href="{{ route('friend.accept', ['username' => $user->username]) }}" class="btn btn-primary">Terima Permintaan pertemanan</a>
      @elseif(Auth::user()->isFriendsWith($user))
        <p>
          Kamu dan {{ $user->getNameOrUsername() }} sudah berteman.
        </p>

        <form role="form" action="{{ route('friend.delete', ['username' => $user->username]) }}" method="post">
          <input type="submit" name="name" class="btn btn-primary" value="Hapus Pertemanan">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
        </form>

      @elseif(Auth::user()->id !== $user->id)
        <a href="{{ route('friend.add', ['username' => $user->username]) }}" class="btn btn-primary">Tambahkan Teman</a>
      @endif
      <h4>Teman {{ $user->getFirstNameOrUsername() }} :</h4>

      @if(!$user->friends()->count())
        <p>
          {{ $user->getFirstNameOrUsername() }} Tidak Memiliki Teman.
        </p>
      @else
        @foreach($user->friends() as $user)
          @include('user/partials/userblok')
        @endforeach
      @endif
    </div>
  </div>
@endsection
