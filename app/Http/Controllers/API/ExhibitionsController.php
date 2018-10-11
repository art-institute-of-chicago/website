<?php

namespace App\Http\Controllers\API;

use Aic\Hub\Foundation\AbstractController as BaseController;

class ExhibitionsController extends BaseController
{
    protected $model = \App\Models\Exhibition::class;
    protected $transformer = \App\Http\Transformers\ExhibitionTransformer::class;

    public function validateId($id)
    {
        return true;
    }
}
