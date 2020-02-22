@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="level">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                            {{ $thread->title }}
                            </span>

                            <form action="{{ $thread->path() }}" method="POST">
                                @csrf
                                {{ method_field('DELETE') }}

                                <button type="submit" class="btn btn-link">Delete Thread</button>
                            </form>
                        </div>
                    </div>

                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>

                @foreach($replies as $reply)
                    @include('threads.reply')
                @endforeach

                <div style="padding-top: 20px;">
                    {{ $replies->links() }}
                </div>

                @if (auth()->user())
                    <form method="POST" action="{{ $thread->path() . '/replies' }}" style="padding-top: 20px;">
                        @csrf
                        <div class="form-group">
                            <textarea name="body" rows="5" id="body" class="form-control" placeholder="Having something to say"></textarea>
                        </div>

                        <button class="btn btn-primary" type="submit">Post</button>
                    </form>
                @else
                    <p style="padding-top: 20px;" class="text-center">Please <a href="{{ route('login') }}">sign in</a> to participate in this discussion.</p>
                @endif
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }}
                        by {{ $thread->creator->name }}, and currently has {{ $thread->replies_count }}
                        {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
