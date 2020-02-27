<reply inline-template>
    <div id="reply-{{$reply->id}}" class="card-body mt-3">
        <div class="level">
            <h6 class="flex">
                <a href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a> said
                {{ $reply->created_at->diffForHumans() }}...
            </h6>

            <div>
                <form method="POST" action="/replies/{{$reply->id}}/favorites">
                    @csrf

                    <button type="submit" class="btn btn-primary" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }}
                        {{ \Illuminate\Support\Str::plural('Favorite', $reply->favorites_count) }}
                    </button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body" v-if="editing">
                <textarea></textarea>
            </div>

            <div class="card-body" v-else>
                {{ $reply->body }}
            </div>
        </div>


        @can('update', $reply)
            <div class="card-footer level">

                <button class="btn-dark mr-2" @click="editing = true">Edit</button>

                <form method="POST" action="/replies/{{ $reply->id }}">
                    @csrf
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn-danger">Delete</button>
                </form>
            </div>
        @endcan

    </div>
</reply>


