<?php

namespace App\Http\Controllers;

use App\Repositories\Api\GalleryRepository;

class GalleryController extends FrontController
{
    protected $repository;

    public function __construct(GalleryRepository $repository)
    {
        $this->repository = $repository;
        parent::__construct();
    }

    public function show($idSlug)
    {
        $item     = $this->repository->getById((Integer) $idSlug);
        $artworks = $this->repository->getArtworks($item);

        $exploreFurtherCollection = $this->repository->exploreFurtherCollection($item, request()->only('exFurther-classification'));
        $exploreFurtherTags       = $this->repository->exploreFurtherTags($item);

        return view('site.tagDetail', [
            'item'     => $item,
            'artworks' => $artworks,
            'exploreFurther'     => $exploreFurtherCollection,
            'exploreFurtherTags' => $exploreFurtherTags,
        ]);
    }

}
