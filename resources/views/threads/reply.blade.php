<reply :attributes="{{ $reply }}" inline-template v-cloak>



    <div id="reply-{{$reply->id}}" class="card-body mt-3">
        <div class="level">
            <h6 class="flex">
                <a href="{{ route('profile', $reply->owner->name) }}">{{ $reply->owner->name }}</a> said
                {{ $reply->created_at->diffForHumans() }}...
            </h6>

            @if (\Illuminate\Support\Facades\Auth::check())
            <div>
                <favorite :reply="{{ $reply }}"></favorite>
            </div>
            @endif
        </div>

        <div class="card">
            <div class="card-body" v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>
                <button class="btn-success small" @click="update">Update</button>
                <button class="btn small" @click="editing=false">Cancel</button>
            </div>

            <div class="card-body" v-else v-text="body"></div>
        </div>


        {{--test--}}
        @can('update', $reply)
            <div class="card-footer level">
                <button class="btn-dark mr-2" @click="editing = true">Edit</button>
                <button class="btn-danger mr-2" @click="destroy">Delete</button>
            </div>
        @endcan

    </div>
</reply>


