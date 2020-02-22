@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="page-link">
            <h1>
                {{ $userProfile->name }}
                <small>Since {{ $userProfile->created_at->diffForHumans() }}</small>
            </h1>
        </div>

        <div class="card-body">
            @foreach($threads as $thread)
                <div class="card card-body">
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
@endsection