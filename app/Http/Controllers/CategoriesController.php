<?php

namespace App\Http\Controllers;

use App\Http\Requests\Request;
use App\Models\Topic;
use App\Models\Category;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, Topic $topic)
    {
        // 读取分类 ID 关联的话题，并按每 20 条分页
        $topics = $topic->withOrder($request->get('order'))
                        ->where('category_id', $category->getAttributeValue('id'))
                        ->with('user', 'category')
                        ->paginate(20);

        // 传参变量话题和分类到模版中
        return view('topics.index', compact('topics', 'category'));
    }
}
