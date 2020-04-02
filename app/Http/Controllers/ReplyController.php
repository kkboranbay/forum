<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReplyRequest;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\User;

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
        $reply = $thread->addReply([
            'body'    => $request->body,
            'user_id' => auth()->id(),
        ])->load('owner');

        preg_match_all('/\@([^\s]+)/', $request->body, $matches);

        $names = $matches[1];

        foreach ($names as $name) {
            $user = User::whereName($name)->first();

            if ($user) {
                $user->notify(new YouWereMentioned($reply));
            }
        }

        return response()->json($reply);
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            \request()->validate([
                'body' => 'required|spamfree'
            ]);

            $reply->update(\request(['body']));

        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }

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
