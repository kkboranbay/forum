@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @include('threads._list')

                {{ $threads->render() }}
            </div>

            @if(count($trending))
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Trending threads
                        </div>

                        <div class="card-body">
                            @foreach($trending as $thread)
                                <li class="list-group-item">
                                    <a href="{{ $thread->path }}">
                                        {{ $thread->title }}
                                    </a>
                                </li>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
