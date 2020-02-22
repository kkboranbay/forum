@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="raw">
            <div class="col-md-8 offset-md-2">
                <div class="card card-header">
                    <h3>
                        {{ $userProfile->name }}
                        <small>Since {{ $userProfile->created_at->diffForHumans() }}</small>
                    </h3>
                </div>

                @foreach($threads as $thread)
                    <div class="card mt-2 mb-2">
                        <div class="card-header">
                            <div class="level">
                                    <span class="flex">
                                        <a href="#">{{ $thread->creator->name }}</a> posted:
                                        {{ $thread->title }}
                                    </span>

                                <span>{{ $thread->created_at->diffForHumans() }}</span>
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                @endforeach

                {{ $threads->links() }}
            </div>
        </div>
    </div>
@endsection