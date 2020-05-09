@extends('layouts.app')

@section('header')
    {{--<link rel="stylesheet" href="{{ asset('css/vendor/tribute.css') }}">--}}
@endsection

@section('content')

    <thread-view :data-replies-count="{{ $thread->replies_count }}" :data-locked="{{ $thread->locked }}" inline-template>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="level">
                                    <img
                                            src="{{ $thread->creator->avatar_path }}"
                                            alt=""
                                            width="30"
                                            height="30"
                                            class="mr-2">

                                <span class="flex">
                                    <a href="{{ route('profile', $thread->creator->name) }}">{{ $thread->creator->name }}</a> posted:
                                {{ $thread->title }}
                                </span>

                                @can('update', $thread)
                                <form action="{{ $thread->path() }}" method="POST">
                                    @csrf
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-link">Delete Thread</button>
                                </form>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <replies @removed="repliesCount--" @added="repliesCount++"></replies>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            This thread was published {{ $thread->created_at->diffForHumans() }}
                            by {{ $thread->creator->name }}, and currently has <span v-text="repliesCount"></span>
                            {{ \Illuminate\Support\Str::plural('comment', $thread->replies_count) }}
                        </div>

                        <p>
                            <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}" v-if="signedIn"></subscribe-button>
                            <button class="btn" v-if="authorize('isAdmin') && ! locked" @click="locked=true">Lock</button>
                        </p>

                    </div>
                </div>

            </div>
        </div>
    </thread-view>
@endsection
