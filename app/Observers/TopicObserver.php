<?php

namespace App\Observers;

use App\Handlers\SlugTranslateHandler;
use App\Models\Topic;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function creating(Topic $topic)
    {
        //
    }

    public function updating(Topic $topic)
    {
        //
    }

    public function saving(Topic $topic)
    {
        // XSS 过滤
        $topic->setAttribute('body', clean($topic->getAttribute('body'), 'user_topic_body'));
        //$topic->body = clean($topic->body, 'user_topic_body');

        // 生成话题摘录
        $topic->setAttribute('excerpt', make_excerpt($topic->getAttributeValue('body')));

        // 如果 slug 字段无内容，即使用翻译器对 title 进行翻译
        if (! $topic->getAttributeValue('slug')) {
            $topic->setAttribute('slug', app(SlugTranslateHandler::class)->translate($topic->getAttributeValue('title')));
        }
    }
}
