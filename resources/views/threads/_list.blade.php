@forelse($threads as $thread)
    <div class="card mb-3">
        <div class="card-header">
            <div class="level">
                <div class="flex">
                    <h4>
                        <a href="{{ $thread->path() }}">
                            @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                            @else
                                {{ $thread->title }}
                            @endif
                        </a>
                    </h4>

                    <span>
                        Posted By: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a>
                    </span>
                </div>

                <a href="{{ $thread->path() }}">
                    {{ $thread->replies_count }} {{ \Illuminate\Support\Str::plural('reply', $thread->replies_count) }}
                </a>
            </div>
        </div>

        <div class="card-body">
            <div class="body">{!! $thread->body  !!}</div>
            <hr>
        </div>

        <div class="card-footer">
            {{ $thread->visits }} Visits
        </div>
    </div>
@empty
    <p>There is no relevant results at this time</p>
@endforelse