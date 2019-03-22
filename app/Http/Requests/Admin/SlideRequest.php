<?php

namespace App\Http\Requests\Admin;

use A17\Twill\Http\Requests\Admin\Request;

class SlideRequest extends Request
{
    public function rulesForCreate()
    {
        return [
            'module_type' => 'required',
        ];
    }

    public function rulesForUpdate()
    {
        return [];
    }
}
