@extends('templates.default')

@section('content')
  <div class="row">
    <div class="col-lg-6">
      <form role="form" action="{{ route('status.post') }}" method="post">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
          <textarea name="status" placeholder="Apa Kabar {{ Auth::user()->getFirstNameOrUsername() }} ?"
          rows="2" class="form-control"></textarea>
          @if($errors->has('status'))
            <span class="help-block">{{ $errors->first('status') }}</span>
          @endif
        </div>
        <button type="submit" class="btn btn-primary">Kirim</button>
        <input type="hidden" name="_token" value="{{ Session::token() }}">
      </form>
      <hr>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-5">
      @if(!$statuses->count())
        <p>
          Maaf Tidak ada Status terbaru !
        </p>
        @else
          @foreach($statuses as $status)
            <div class="media">
              <a href="{{ route('profile.index',
                ['username' => $status->user->username]) }}" class="pull-left">
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
            </div>

            </div>
          @endforeach

          {!! $statuses->render() !!}

      @endif
    </div>
  </div>
@endsection
