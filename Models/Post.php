<?php

namespace Cms\Modules\Forum\Models;

use Illuminate\Support\Facades\Request;
use League\CommonMark\CommonMarkConverter;

class Post extends BaseModel
{
    protected $table = 'posts';
    protected $fillable = ['thread_id', 'author_id', 'body'];
    protected $appends = ['post_url'];
    protected $with = ['author'];
    protected $touches = ['thread'];

    public function thread()
    {
        return $this->belongsTo(__NAMESPACE__.'\Thread');
    }

    public function author()
    {
        $model = config('auth.model');

        return $this->belongsTo($model);
    }

    public function getBodyAttribute($value)
    {
        $value = replaceMentions($value);

        return escape(with(new CommonMarkConverter())->convertToHtml($value));
    }

    public function getPostUrlAttribute()
    {
        $threadName = 'unknown';
        if ($this->thread !== null) {
            $threadName = $this->thread->slug;
        }

        return sprintf('%s?page=%d#post-%s',
            route('forum.thread.show', [
                'forum_thread_id' => $this->thread_id,
                'forum_thread_name' => $threadName,
            ]),
            Request::input('page', 1),
            $this->id
        );
    }

    public function transform()
    {
        $return = [
            'id' => $this->id,
            'thread_id' => $this->thread_id,
            'body' => $this->body,
            'original_body' => $this->getOriginal('body'),
            'created' => date_array($this->created_at),
            'updated' => date_array($this->updated_at),

            'links' => [
                'self' => (string) $this->post_url,
                'edit' => route('forum.post.edit', $this->id),
            ],

            'author' => [],
            'category' => [],
            'latestPost' => [],
        ];

        if ($this->author !== null) {
            $return['author'] = $this->author->transform();
        }

        if ($this->category !== null) {
            $return['category'] = $this->category->transform(function ($model) {
                return $model->transform();
            });
        }

        if ($this->latestPost !== null) {
            $lastPost = $this->latestPost;
            $return['latestPost'] = (array) $lastPost->transform();
            $return['links']['last_post'] = (string) sprintf(
                '%s?page=%d#post-%s',
                $this->makeLink(true),
                $this->lastPage,
                $lastPost->id
            );
        }

        return $return;
    }
}
