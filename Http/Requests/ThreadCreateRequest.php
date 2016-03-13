<?php

namespace Cms\Modules\Forum\Http\Requests;

use Cms\Http\Requests\Request;

class ThreadCreateRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $prefix = config('cms.forum.config.table-prefix', 'forum_');

        return [
            'name' => 'required|unique:'.$prefix.'threads,name',
            'body' => 'required',
        ];
    }
}
