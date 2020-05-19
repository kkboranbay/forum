@extends('layouts.app')

@section('content')
    <div class="container">
        <thread-search :trending="{{ json_encode($trending) }}"></thread-search>
    </div>
@endsection
