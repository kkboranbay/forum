@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="raw">
            <div class="col-md-8 offset-md-2">
                <div class="card card-header">
                    <h3>
                        {{ $userProfile->name }}
                    </h3>
                </div>

                @foreach ($activities as $date => $activity)
                    <h3 class="modal-header">{{ $date }}</h3>

                    @foreach ($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include ("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach
                @endforeach

            </div>
        </div>
    </div>
@endsection