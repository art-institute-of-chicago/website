<?php

namespace App\Models\Api;

use Aic\Hub\Foundation\Library\Api\Models\BaseApiModel;
use Aic\Hub\Foundation\Library\Api\Models\Behaviors\HasMediasApi;
use App\Helpers\ImageHelpers;

class ShopItem extends BaseApiModel
{
    use HasMediasApi;

    protected array $endpoints = [
        'collection' => '/api/v1/products',
        'resource' => '/api/v1/products/{id}',
        'search' => '/api/v1/products/search'
    ];

    protected $presenter = 'App\Presenters\Admin\ShopItemPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ShopItemPresenter';

    public $mediasParams = [
        'hero' => [
            'default' => [
            ]
        ],
    ];

    public function imageFront($role = 'hero', $crop = 'default')
    {
        if (!empty($this->image_url)) {
            return ImageHelpers::aic_convertFromImageProxy($this->image_url, $this->mediasParams[$role][$crop]);
        }
    }

    public function getSlugAttribute(): string
    {
        return $this->link;
    }
}
