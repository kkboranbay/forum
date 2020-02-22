<br>
<div class="card-header">
    <div class="level">
        <h6 class="flex">
            <a href="#">{{ $reply->owner->name }}</a> said
            {{ $reply->created_at->diffForHumans() }}...
        </h6>

        <div>
            <form method="POST" action="/replies/{{$reply->id}}/favorites">
                @csrf

                <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                    {{ $reply->favorites()->count() }}
                    {{ \Illuminate\Support\Str::plural('Favorite', $reply->favorites()->count()) }}
                </button>
            </form>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>
