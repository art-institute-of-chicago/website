<?php

namespace App\Repositories;

use A17\Twill\Repositories\Behaviors\HandleBlocks;
use A17\Twill\Repositories\Behaviors\HandleFiles;
use A17\Twill\Repositories\Behaviors\HandleMedias;
use A17\Twill\Repositories\Behaviors\HandleRevisions;
use A17\Twill\Repositories\Behaviors\HandleSlugs;
use App\Models\DigitalPublication;

class DigitalPublicationRepository extends ModuleRepository
{
    use HandleBlocks, HandleSlugs, HandleMedias, HandleFiles, HandleRevisions;

    public function __construct(DigitalPublication $model)
    {
        $this->model = $model;
    }

    public function getShowData($item, $slug = null, $previewPage = null)
    {
        return [
            'borderlessHeader' => !(empty($item->imageFront('banner'))),
            'subNav' => null,
            'nav' => null,
            'intro' => $item->short_description,
            'headerImage' => $item->imageFront('banner'),
            "title" => $item->title,
            "breadcrumb" => [],
            "blocks" => null,
            'nav' => [],
            'page' => $item,
        ];
    }

    public function afterSave($object, $fields)
    {
        $this->updateRelatedBrowser($object, $fields, 'welcome_note_section');

        parent::afterSave($object, $fields);
    }

    public function getFormFields($object)
    {
        $fields = parent::getFormFields($object);

        $fields['browsers']['welcome_note_section'] = $this->getFormFieldsForRelatedBrowser($object, 'welcome_note_section');

        return $fields;
    }

    public function getWelcomeNote($item)
    {
        $welcomeNotes = $item->getRelated('welcome_note_section');

        if (!config('aic.is_preview_mode')) {
            $welcomeNotes = $welcomeNotes->where('published', true);
        }

        return $welcomeNotes->first();
    }
}
