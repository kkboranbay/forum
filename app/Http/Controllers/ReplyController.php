<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Thread;
use Illuminate\Http\Request;

class ReplyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request, $channel, Thread $thread)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $thread->addReply([
            'body'    => $request->body,
            'user_id' => auth()->id(),
        ]);

        return back()->with('flash', 'You reply has been left');
    }

    public function destroy(Reply $reply)
    {
        //test
        $this->authorize('update', $reply);

        $reply->delete();

        return back();
    }

}
