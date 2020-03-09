<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

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

    public function store(Request $request, $channel, Thread $thread)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $reply = $thread->addReply([
            'body'    => $request->body,
            'user_id' => auth()->id(),
        ]);

        if (\request()->expectsJson()) {
            return response()->json($reply->load('owner'));
        }

        return back()->with('flash', 'You reply has been left');
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

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
