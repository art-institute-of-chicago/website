<?php

namespace App\Repositories;

use BadMethodCallException;
use A17\Twill\Repositories\ModuleRepository as BaseModuleRepository;
use A17\Twill\Repositories\Behaviors\HandleRelatedBrowsers;

use App\Repositories\Behaviors\HandleApiBrowsers;

abstract class ModuleRepository extends BaseModuleRepository
{
    use HandleRelatedBrowsers, HandleApiBrowsers;

    /**
     * Remove trailing newlines from WYSIWYG fields
     */
    public function prepareFieldsBeforeSave($object, $fields)
    {

        // Fields
        foreach ($fields as $key => $field) {
            $fields[$key] = rightTrim($field, '<p><br></p>');
        }

        // Block content (for `HasBlocks` only)
        if (isset($fields['blocks'])) {
            foreach ($fields['blocks'] as $blockKey => $block) {
                foreach ($block['content'] as $contentKey => $content) {
                    $fields['blocks'][$blockKey]['content'][$contentKey] = rightTrim($content, '<p><br></p>');
                }
            }
        }

        return parent::prepareFieldsBeforeSave($object, $fields);
    }
}
