<?php

namespace App\Presenters\Admin;

use App\Presenters\BasePresenter;

class EventProgramPresenter extends BasePresenter
{
    protected function isAffiliateGroup()
    {
        return $this->entity->is_affiliate_group ? 'Yes' : 'No';
    }
}
