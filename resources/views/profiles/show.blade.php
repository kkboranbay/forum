@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="raw">
            <div class="col-md-8 offset-md-2">
                <div class="card card-header">

                    <h3>
                        {{ $userProfile->name }}
                    </h3>

                    @can('update', $userProfile)
                        <form method="POST" action="{{ route('avatar', $userProfile) }}" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="avatar" accept="image/*">

                            <button type="submit" class="btn btn-primary">Add avatar</button>
                        </form>
                    @endcan

                    <img src="{{ $userProfile->avatar() }}" width="50" height="50">

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