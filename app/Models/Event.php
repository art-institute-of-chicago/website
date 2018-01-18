<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

use App\Models\Behaviors\HasApiModel;

class Event extends Model
{
    use HasSlug, HasRevisions, HasMedias, HasBlocks, HasApiModel;

    protected $presenterAdmin = 'App\Presenters\Admin\EventPresenter';
    protected $apiModel = 'App\Models\Api\Event';

    protected $fillable = [
        'title',
        'datahub_id',

        'published',
        'landing',
        'content',
        'price',
        'admission',
        'location',
        'latitude',
        'longitude',
        'rsvp_link',
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = ['published'];

    public $dates = [];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
            'square' => [
                [
                    'name' => 'square',
                    'ratio' => 1,
                ],
            ],
        ],
    ];

    public function siteTags()
    {
        return $this->morphToMany(\App\Models\SiteTag::class, 'site_taggable', 'site_tagged');
    }

    public function events()
    {
        return $this->morphToMany(\App\Models\ApiRelation::class, 'api_relatable')->withPivot(['position', 'relation'])->orderBy('position')->where('relation', 'events');
    }

    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }
}
