<?php

namespace App\Models;

use A17\CmsToolkit\Models\Behaviors\HasBlocks;
use A17\CmsToolkit\Models\Behaviors\HasMedias;
use A17\CmsToolkit\Models\Behaviors\HasRevisions;
use A17\CmsToolkit\Models\Behaviors\HasSlug;
use A17\CmsToolkit\Models\Model;

use App\Models\Behaviors\HasApiModel;

class Exhibition extends Model
{
    use HasRevisions, HasSlug, HasMedias, HasBlocks, HasApiModel;

    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';
    protected $apiModel = 'App\Models\Api\Exhibition';

    protected $fillable = [
        'published',
        'content',
        'header_copy',
        'title',
        'datahub_id',
    ];

    public $slugAttributes = [
        'title',
    ];

    public $checkboxes = ['published'];

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
        return $this->belongsToMany(\App\Models\Event::class, 'event_exhibition', 'event_id', 'exhibition_id')->withPivot('position')->orderBy('position');
    }

    public function shopItems()
    {
        return $this->morphToMany(\App\Models\ShopItem::class, 'shop_itemizable', 'shop_itemized');
    }

    public function sponsors()
    {
        return $this->belongsToMany(\App\Models\Sponsor::class)->withPivot('position')->orderBy('position');
    }

    public function getTitleInBucketAttribute()
    {
        return $this->title;
    }
}
