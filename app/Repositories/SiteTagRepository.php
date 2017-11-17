<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\ModuleRepository;

use App\Models\SiteTag;

class SiteTagRepository extends ModuleRepository
{
    use HandleSlugs;

    public function __construct(SiteTag $model)
    {
        $this->model = $model;
    }

    public function afterSave($object, $fields)
    {
        $object->segments()->sync($fields['selected_segments'] ?? []);
        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);
        $fields = $this->getFormFieldsForMultiSelect($fields, 'segments', 'id', 'selected_segments');

        return $fields;
    }

}
