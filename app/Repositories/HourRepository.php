<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\Hour;

class HourRepository extends ModuleRepository
{

    public function __construct(Hour $model)
    {
        $this->model = $model;
    }

}
