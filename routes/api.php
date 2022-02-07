<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ArticlesController;
use App\Http\Controllers\API\ArtistsController;
use App\Http\Controllers\API\ClosuresController;
use App\Http\Controllers\API\DigitalPublicationsController;
use App\Http\Controllers\API\DigitalPublicationSectionsController;
use App\Http\Controllers\API\EducatorResourcesController;
use App\Http\Controllers\API\EmailSeriesController;
use App\Http\Controllers\API\EventsController;
use App\Http\Controllers\API\EventOccurrencesController;
use App\Http\Controllers\API\EventProgramsController;
use App\Http\Controllers\API\ExhibitionsController;
use App\Http\Controllers\API\ExperiencesController;
use App\Http\Controllers\API\GenericPagesController;
use App\Http\Controllers\API\GeotargetController;
use App\Http\Controllers\API\HighlightsController;
use App\Http\Controllers\API\HoursController;
use App\Http\Controllers\API\InteractiveFeaturesController;
use App\Http\Controllers\API\LocationsController;
use App\Http\Controllers\API\PressReleasesController;
use App\Http\Controllers\API\PrintedPublicationsController;
use App\Http\Controllers\API\ResearchGuidesController;
use App\Http\Controllers\API\SponsorsController;
use App\Http\Controllers\API\StaticPagesController;
use App\Http\Controllers\API\TagsController;
use App\Http\Controllers\API\VideosController;
use App\Http\Controllers\SeamlessImagesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('/', function () {
    return redirect('/api/v1');
});

Route::group(['prefix' => 'v1'], function () {
    Route::get('geotarget', [GeotargetController::class, 'geotarget']);

    Route::get('/', function () {
        return 'API';
    });

    /**
     * Tags ------------------------------------------------------
     */
    Route::get('tags', [TagsController::class, 'index']);
    Route::get('tags/{id}', [TagsController::class, 'show']);

    /**
     * Locations ------------------------------------------------------
     */
    Route::get('locations', [LocationsController::class, 'index']);
    Route::get('locations/{id}', [LocationsController::class, 'show']);

    /**
     * Hours ------------------------------------------------------
     */
    Route::get('hours', [HoursController::class, 'index']);
    Route::get('hours/{id}', [HoursController::class, 'show']);

    /**
     * Hours ------------------------------------------------------
     */
    Route::get('closures', [ClosuresController::class, 'index']);
    Route::get('closures/deleted', [ClosuresController::class, 'deleted']);
    Route::get('closures/{id}', [ClosuresController::class, 'show']);

    /**
     * Exhibitions ------------------------------------------------------
     */
    Route::get('exhibitions', [ExhibitionsController::class, 'index']);
    Route::get('exhibitions/{id}', [ExhibitionsController::class, 'show']);

    /**
     * Events ------------------------------------------------------
     */
    Route::get('events', [EventsController::class, 'index']);
    Route::get('events/deleted', [EventsController::class, 'deleted']);
    Route::get('event-occurrences', [EventOccurrencesController::class, 'occurrences']);
    Route::get('events/{id}', [EventsController::class, 'show']);

    /**
     * Sponsors ------------------------------------------------------
     */
    Route::get('sponsors', [SponsorsController::class, 'index']);

    /**
     * Event-programs ------------------------------------------------------
     */
    Route::get('event-programs', [EventProgramsController::class, 'index']);

    /**
     * Articles ------------------------------------------------------
     */
    Route::get('articles', [ArticlesController::class, 'index']);
    Route::get('articles/deleted', [ArticlesController::class, 'deleted']);
    Route::get('articles/{id}', [ArticlesController::class, 'show']);

    /**
     * Highlights ------------------------------------------------------
     */
    Route::get('highlights', [HighlightsController::class, 'index']);
    Route::get('highlights/{id}', [HighlightsController::class, 'show']);

    /**
     * Artists ------------------------------------------------------
     */
    Route::get('artists', [ArtistsController::class, 'index']);
    Route::get('artists/{id}', [ArtistsController::class, 'show']);

    Route::get('staticpages', [StaticPagesController::class, 'index']);

    Route::get('staticpages/{id}', [StaticPagesController::class, 'show']);

    Route::get('emailseries', [EmailSeriesController::class, 'index']);

    Route::get('emailseries/{id}', [EmailSeriesController::class, 'show']);

    /**
     * Generic pages ------------------------------------------------------
     */
    Route::get('genericpages', [GenericPagesController::class, 'index']);
    Route::get('genericpages/deleted', [GenericPagesController::class, 'deleted']);
    Route::get('genericpages/{id}', [GenericPagesController::class, 'show']);

    /**
     * Press releases ------------------------------------------------------
     */
    Route::get('pressreleases', [PressReleasesController::class, 'index']);
    Route::get('pressreleases/deleted', [PressReleasesController::class, 'deleted']);
    Route::get('pressreleases/{id}', [PressReleasesController::class, 'show']);

    /**
     * Research guides ------------------------------------------------------
     */
    Route::get('researchguides', [ResearchGuidesController::class, 'index']);
    Route::get('researchguides/deleted', [ResearchGuidesController::class, 'deleted']);
    Route::get('researchguides/{id}', [ResearchGuidesController::class, 'show']);

    /**
     * Educator resources ------------------------------------------------------
     */
    Route::get('educatorresources', [EducatorResourcesController::class, 'index']);
    Route::get('educatorresources/deleted', [EducatorResourcesController::class, 'deleted']);
    Route::get('educatorresources/{id}', [EducatorResourcesController::class, 'show']);

    /**
     * Digital publications ------------------------------------------------------
     */
    Route::get('digitalpublications', [DigitalPublicationsController::class, 'index']);
    Route::get('digitalpublications/deleted', [DigitalPublicationsController::class, 'deleted']);
    Route::get('digitalpublications/{id}', [DigitalPublicationsController::class, 'show']);

    /**
     * Digital publication sections ------------------------------------------------------
     */
    Route::get('digitalpublicationsections', [DigitalPublicationSectionsController::class, 'index']);
    Route::get('digitalpublicationsections/deleted', [DigitalPublicationSectionsController::class, 'deleted']);
    Route::get('digitalpublicationsections/{id}', [DigitalPublicationSectionsController::class, 'show']);

    /**
     * Printed publications ------------------------------------------------------
     */
    Route::get('printedpublications', [PrintedPublicationsController::class, 'index']);
    Route::get('printedpublications/deleted', [PrintedPublicationsController::class, 'deleted']);
    Route::get('printedpublications/{id}', [PrintedPublicationsController::class, 'show']);

    /**
     * Videos --------------------------------------------------------------------
     */
    Route::get('videos', [VideosController::class, 'index']);
    Route::get('videos/deleted', [VideosController::class, 'deleted']);
    Route::get('videos/{id}', [VideosController::class, 'show']);

    /**
     * Interactive features --------------------------------------------------------------------
     */
    Route::get('interactive-features', [InteractiveFeaturesController::class, 'index']);
    Route::get('interactive-features/{id}', [InteractiveFeaturesController::class, 'show']);
    Route::get('experiences', [ExperiencesController::class, 'index']);
    Route::get('experiences/{id}', [ExperiencesController::class, 'show']);

    Route::options('seamless-images/{id}', [SeamlessImagesController::class, 'byFile']);
    Route::get('seamless-images/{id}', [SeamlessImagesController::class, 'byFile']);
});
