<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Helpers\Seo;
use A17\Twill\Http\Controllers\Front\Controller as BaseController;
use View;

class FrontController extends BaseController
{

    public function __construct()
    {

        parent::__construct();

        $this->seo = new Seo;
        $this->seo->title = config('twill.seo.site_title');
        $this->seo->description = config('twill.seo.site_desc');
        $this->seo->image = config('twill.seo.image');
        $this->seo->width = config('twill.seo.width');
        $this->seo->height = config('twill.seo.height');

        View::share('seo', $this->seo);

        $this->loadSearchTerms();
        $this->loadBaseSeo();
    }

    protected function loadSearchTerms()
    {
        $terms = \App\Models\SearchTerm::ordered()->limit(10)->get();
        View::share('searchTerms', $terms);
    }

    protected function loadBaseSeo()
    {
        View::share('globalSuffix', 'The Art Institute of Chicago');
    }

    protected function getCanonicalRedirect($route, $item, $params = null)
    {
        $slug = is_string($params) ? $params : null;

        $params = is_array($params) ? $params : [
            'id' => $item->id,
            'slug' => $slug ?? $item->getSlug(),
        ];

        $canonicalPath = route($route, $params, false);

        if ('/' . request()->path() !== $canonicalPath) {
            return redirect($canonicalPath, 301);
        }
    }
}
