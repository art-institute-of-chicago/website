<?php

namespace App\Presenters\Admin;

use Carbon\Carbon;
use App\Presenters\BasePresenter;

class ArtistPresenter extends BasePresenter
{
    protected function augmented() {
        return $this->entity->getAugmentedModel() ? 'Yes' : 'No';
    }
}
