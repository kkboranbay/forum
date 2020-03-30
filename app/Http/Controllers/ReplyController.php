<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
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
        try {

            $this->validateReply();

            $reply = $thread->addReply([
                'body'    => $request->body,
                'user_id' => auth()->id(),
            ]);

        } catch (\Exception $e) {
            return response(
                'Sorry, your reply could not be saved at this time.', 422
            );
        }

        return response()->json($reply->load('owner'));
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        try {
            $this->validateReply();

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

    protected function validateReply()
    {
        $this->validate(\request(), [
            'body' => 'required'
        ]);

        resolve(Spam::class)->detect(\request('body'));
    }

}
