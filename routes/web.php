<?php

Route::name('home')->get('/', 'HomeController@index');

if (!app()->environment('production')) {
  Route::get('/autocomplete/{slug?}', 'StaticsController@autocomplete');
  Route::get('/collections/search/{slug?}', 'StaticsController@collectionsAutocomplete');
  Route::get('/exhibitions_load_more', 'StaticsController@exhibitions_load_more');
  Route::get('/statics/{slug?}', 'StaticsController@index');
}

// Collection routes
Route::name('collection')->get('/collection', 'CollectionController@index');
Route::name('collection.search')->get('/collection/search', 'CollectionController@search');

// Newsletter subscription
Route::name('subscribe')->post('/subscribe', 'SubscribeController@store');

// Visit routes
Route::name('visit')->get('/visit', 'VisitController@index');


// Search routes
Route::name('search')->get('/search', 'SearchController@index');

// Events routes
Route::name('events')->get('/events', 'EventController@index');
Route::name('events.show')->get('/events/{id}', 'EventController@show');

// Articles routes
Route::name('articles')->get('/articles', 'ArticleController@index');
Route::name('articles.show')->get('/articles/{slug}', 'ArticleController@show');

// Exhibition routes
Route::name('exhibitions')->get('/exhibitions', 'ExhibitionController@index');
Route::name('exhibitions.upcoming')->get('/exhibitions/upcoming', 'ExhibitionController@upcoming');
Route::name('exhibitions.show')->get('/exhibitions/{id}', 'ExhibitionController@show');
Route::name('exhibitions.loadMoreRelatedEvents')->get('/exhibitions/{id}/relatedEvents', 'ExhibitionController@loadMoreRelatedEvents');

// Artwork routes
Route::name('artworks.show')->get('/artworks/{id}', 'ArtworkController@show');

// Exhibition history routes
Route::resource('exhibitionHistory', 'ExhibitionHistoryController', ['only' => ['index', 'show']]);

// Gallery / tag page
Route::name('galleries.show')->get('/galleries/{id}', 'GalleryController@show');

// Selections
Route::name('selections.show')->get('/selections/{id}', 'SelectionsController@show');
