<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasSlug;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasFiles;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasPosition;
use App\Models\Behaviors\HasBlocks;
use App\Models\Behaviors\HasMediasEloquent;

class Mirador extends AbsractModel
{
    use HasSlug, HasMedias, HasMediasEloquent, HasRevisions, HasPosition, HasFiles, HasBlocks, Transformable;

    protected $presenter = 'App\Presenters\Admin\MiradorPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\MiradorPresenter';

    protected $fillable = [
        'published',
        'title',
        'position',
        'title',
        'date',
        'heading',
        'title_display',
        'list_description',
    ];

    protected $dates = [
        'date',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = [
        'published'
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];
}
