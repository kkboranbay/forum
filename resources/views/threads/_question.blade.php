{{--Editing the question--}}
<div class="card" v-if="editing">
    <div class="card-header">
        <div class="level">
            <input type="text" class="form-control" value="{{ $thread->title }}">
        </div>
    </div>

    <div class="card-body">
        <textarea class="form-control" rows="10">{{ $thread->body }}</textarea>
    </div>

    <div class="card-footer">
        <div class="level">
            <button class="level-item btn btn-dark btn-sm" @click="editing=true" v-show="! editing">Edit</button>
            <button class="level-item btn btn-success btn-sm" @click="">Update</button>
            <button class="level-item btn btn-dark btn-sm" @click="editing=false">Cancel</button>

            @can('update', $thread)
                <form action="{{ $thread->path() }}" method="POST" class="ml-a">
                    @csrf
                    {{ method_field('DELETE') }}

                    <button type="submit" class="btn btn-link">Delete Thread</button>
                </form>
            @endcan
        </div>
    </div>
</div>


{{--Viewing the question--}}
<div class="card" v-else>
    <div class="card-header">
        <div class="level">
            <img
                    src="{{ $thread->creator->avatar_path }}"
                    alt=""
                    width="30"
                    height="30"
                    class="mr-2">

            <span class="flex">
                <a href="{{ route('profile', $thread->creator->name) }}">
                    {{ $thread->creator->name }}
                </a> posted:{{ $thread->title }}
            </span>

        </div>
    </div>

    <div class="card-body">
        {{ $thread->body }}
    </div>

    <div class="card-footer">
        <button class="btn btn-dark btn-sm" @click="editing=true">Edit</button>
    </div>

</div>