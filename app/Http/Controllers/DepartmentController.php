<?php

namespace App\Http\Controllers;

use App\Repositories\Api\DepartmentRepository;
use App\Libraries\ExploreFurther\BaseService as ExploreDepartments;

class DepartmentController extends FrontController
{
    const ARTWORKS_PER_PAGE = 24;

    protected $repository;

    public function __construct(DepartmentRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($id, $slug = null)
    {
        $item = $this->repository->getById($id);

        // Redirect to the canonical page if it wasn't requested
        $canonicalPath = route('departments.show', ['id' => $item->id, 'slug' => $item->titleSlug ], false);
        if ('/' .request()->path() != $canonicalPath) {
            return redirect($canonicalPath, 301);
        }

        $this->seo->setTitle($item->meta_title ?: $item->title);
        $this->seo->setDescription($item->meta_description ?: 'Department');
        $this->seo->setImage($item->imageFront('hero'));

        $artworks = $this->repository->getRelatedArtworks($item);

        // $exploreFurther = new ExploreDepartments($item, $artworks->getMetadata('aggregations'));

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            // 'exploreFurtherTags'    => $exploreFurther->tags(),
            // 'exploreFurther'        => $exploreFurther->collection(request()->all()),
            // 'exploreFurtherCollectionUrl' => $exploreFurther->collectionUrl(request()->all()),
            'canonicalUrl' => route('departments.show', ['id' => $item->id, 'slug' => $item->titleSlug]),
        ]);
    }

}
