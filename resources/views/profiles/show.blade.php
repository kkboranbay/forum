@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="raw">
            <div class="col-md-8 offset-md-2">
                <div class="card card-header">
                    <avatar-form :user="{{ $userProfile }}"></avatar-form>
                </div>

                @forelse ($activities as $date => $activity)
                    <h3 class="modal-header">{{ $date }}</h3>

                    @foreach ($activity as $record)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include ("profiles.activities.{$record->type}", ['activity' => $record])
                        @endif
                    @endforeach

                    @empty
                        <p class="modal-header">There is no activity yet</p>
                @endforelse

            </div>
        </div>
    </div>
@endsection