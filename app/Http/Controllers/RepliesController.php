<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReplyRequest;
use Illuminate\Support\Facades\Auth;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

	public function store(ReplyRequest $request, Reply $reply)
	{
		$reply->content = $request->get('content');
        $reply->user_id = Auth::id();
        $reply->topic_id = $request->topic_id;
        $result = $reply->save();
        if (!$result) {
            session()->flash('danger', '内容为空或者含有非法字符！');
            return redirect()->back()->withInput();
        }

        return redirect()->to($reply->topic->link())->with('success', '评论创建成功！');
	}

	public function destroy(Reply $reply)
	{
		$this->authorize('destroy', $reply);
		$reply->delete();

		return redirect()->to($reply->topic->link())->with('message', '评论删除成功！');
	}
}
