<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReplyRequest;
use App\Reply;
use App\Thread;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('index');
    }

    public function index($channel, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    public function store(CreateReplyRequest $request, $channel, Thread $thread)
    {
        return $thread->addReply([
            'body'    => $request->body,
            'user_id' => auth()->id(),
        ])->load('owner');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        \request()->validate([
            'body' => 'required|spamfree'
        ]);

        $reply->update(\request(['body']));
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();

        if (\request()->expectsJson()) {
            return response()->json([
                'status' => 'Deleted'
            ]);
        }

        return back()->with('flash', 'Deleted');
    }

}
