<?php

namespace App\Repositories\Api;

use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\Api\Event;

class EventRepository extends ModuleRepository
{
    public function __construct(Event $model)
    {
        $this->model = $model;
    }

}
