<?php

namespace App\Repositories;

use A17\CmsToolkit\Repositories\Behaviors\HandleBlocks;
use App\Repositories\Behaviors\HandleApiRelations;
use App\Repositories\Behaviors\HandleApiBlocks;
// use A17\CmsToolkit\Repositories\Behaviors\HandleTranslations;
use A17\CmsToolkit\Repositories\Behaviors\HandleSlugs;
use A17\CmsToolkit\Repositories\Behaviors\HandleMedias;
use A17\CmsToolkit\Repositories\Behaviors\HandleFiles;
use A17\CmsToolkit\Repositories\Behaviors\HandleRevisions;
use A17\CmsToolkit\Repositories\ModuleRepository;
use App\Models\GenericPage;
use App\Repositories\Api\BaseApiRepository;
use DB;

class GenericPageRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions, HandleApiBlocks, HandleApiRelations {
        HandleApiBlocks::getBlockBrowsers insteadof HandleBlocks;
    }

    public function __construct(GenericPage $model)
    {
        $this->model = $model;
    }

    public function setNewOrder($ids)
    {
        if (is_array(array_first($ids))) {
            DB::transaction(function () use ($ids) {
                Page::saveTreeFromIds($ids);
            }, 3);
        } else {
            parent::setNewOrder($ids);
        }
    }

    public function hydrate($object, $fields)
    {
        $this->hydrateOrderedBelongsTomany($object, $fields, 'articles', 'position', 'Article');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'events', 'position', 'Event');
        $this->hydrateOrderedBelongsTomany($object, $fields, 'exhibitions', 'position', 'Exhibition');
        return parent::hydrate($object, $fields);
    }

    public function afterSave($object, $fields)
    {

        $this->updateBrowserApiRelated($object, $fields, ['exhibitions']);
        $this->updateBrowser($object, $fields, 'events');
        $this->updateBrowser($object, $fields, 'articles');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['exhibitions'] = $this->getFormFieldsForBrowserApi($object, 'exhibitions', 'App\Models\Api\Exhibition', 'exhibitions_events');
        $fields['browsers']['articles'] = $this->getFormFieldsForBrowser($object, 'articles', 'collection.articles_publications');
        $fields['browsers']['events'] = $this->getFormFieldsForBrowser($object, 'events', 'exhibitions_events');

        return $fields;
    }
}
