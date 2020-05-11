@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crate a New Thread</div>

                    <div class="card-body">
                        <form method="POST" action="/threads">
                            @csrf
                            <div class="form-group">
                                <label for="channel_id">Choose Channel:</label>
                                <select class="form-control" name="channel_id" id="channel_id" required>
                                    <option value="">
                                        Choose one...
                                    </option>
                                    @foreach($channels as $channel)
                                        <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>
                                            {{ $channel->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="title">Title:</label>
                                <input type="text" name="title" required id="title" placeholder="Title" class="form-control" value="{{ old('title') }}">
                            </div>

                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea name="body" required id="body" cols="30" rows="8" class="form-control">{{ old('body') }}</textarea>
                            </div>

                            <div class="form-group">
                                <input type="hidden" name="recaptcha" id="recaptcha">
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Publish</button>
                            </div>

                            @if(count($errors))
                                <ul class="alert alert-danger">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </form>

                        <script src="https://www.google.com/recaptcha/api.js?render={{ config('services.recaptcha.site') }}"></script>
                        <script>
                            grecaptcha.ready(function() {
                                grecaptcha.execute('{{ config('services.recaptcha.site') }}', {action: 'homepage'})
                                    .then(function(token) {
                                        if (token) {
                                            document.getElementById('recaptcha').value = token
                                        }
                                    });
                            });
                        </script>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
