<?php

namespace App\Providers;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Libraries\Api\Consumers\GuzzleApiConsumer;

use App\Libraries\LakeviewImageService;
use App\Libraries\EmbedConverterService;

use Illuminate\Support\ServiceProvider;

use App\Models\Hour;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerMorphMap();
        $this->registerApiClient();
        $this->registerLakeviewImageService();
        $this->registerEmbedConverterService();
        $this->composeTemplatesViews();

        \Illuminate\Pagination\AbstractPaginator::defaultView("site.pagination.aic");
        \Illuminate\Pagination\AbstractPaginator::defaultSimpleView("site.pagination.simple-aic");
    }

    public function registerMorphMap()
    {
        Relation::morphMap([
            'events' => 'App\Models\Event',
            'articles' => 'App\Models\Article',
            'selections' => 'App\Models\Selection',
            'artists' => 'App\Models\Artist',
            'homeFeatures' => 'App\Models\HomeFeature'
        ]);
    }

    public function registerApiClient()
    {
        $this->app->singleton('ApiClient', function($app)
        {
            return new GuzzleApiConsumer([
                'base_uri'   => config('api.base_uri'),
                'exceptions' => false
            ]);
        });
    }

    public function registerEmbedConverterService()
    {
        $this->app->singleton('embedconverterservice', function($app)
        {
            return new EmbedConverterService();
        });
    }

    public function registerLakeviewImageService()
    {
        $this->app->singleton('lakeviewimageservice', function($app)
        {
            return new LakeviewImageService();
        });
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    private function composeTemplatesViews()
    {
      view()->composer('*', function ($view) {
        // $hours_today = Hour::getOpeningToday();
        $hours_general = Hour::getOpeningWithClosure();

        $view->with([
            '_hours' => [
                'general' => $hours_general
            ,   'opening_today' => ''
            ]
            ,
            '_pages' => [
                'visit' => route('visit')
            ,   'hours' => route('visit').'#hours'
            ,   'directions' => route('visit').'#directions'

            ,   'buy' => '/buy'
            ,   'become-a-member' => '/become-a-member'
            ,   'shop' => 'http://www.artinstituteshop.org'

            ,   'collection' => route('collection')
            ,   'exhibitions' => route('exhibitions')

            ,   'about-us' => '/about-us'
            ,   'about-us-inside-the-museum' => '/about-us/inside-the-museum'
            ,   'about-us-mission-history' => '/about-us/mission-and-history'
            ,   'about-us-leadership' => '/about-us/leadership'
            ,   'about-us-financials' => '/about-us/financial-reporting'
            ,   'about-us-departments' => '/about-us/departments'

            ,   'support-us' => '/support-us'
            ,   'support-us-membership' => '/support-us/membership'
            ,   'support-us-ways-to-give' => '/support-us/ways-to-give'
            ,   'support-us-affiliate-groups' => '/support-us/affiliate-groups'
            ,   'support-us-ways-to-give-corporate-sponsorship' => '/support-us/ways-to-give/corporate-sponsorship'
            ,   'support-us-art-interest-groups' => '/support-us/art-interest-groups'

            ,   'learn' => '/learn-with-us'
            ,   'learn-families' => '/learn/families'
            ,   'learn-teens' => '/learn/teens'
            ,   'learn-adults' => '/learn/adults'
            ,   'learn-educators' => '/learn/educators'


            ,   'follow-facebook' => 'https://www.facebook.com/artic'
            ,   'follow-twitter' => 'https://twitter.com/artinstitutechi'
            ,   'follow-instagram' => 'https://www.instagram.com/artinstitutechi/'
            ,   'follow-pinterest' => 'https://www.pinterest.com/artinstitutechi/'

            ,   'legal-articles' => route('articles')
            ,   'legal-employment' => '/employment'
            ,   'legal-venue-rental' => '/venue-rental'
            ,   'legal-contact' => '/contact'
            ,   'legal-press' => route('about.press')
            ,   'legal-terms' => '/terms'
            ,   'legal-image-licensing' => '/image-licensing'
            ],
            'mobileNav' => [
                [
                    'name' => 'Visit',
                    'slug' => route('visit')
                ],
                [
                    'name' => 'Exhibition &amp; Events',
                    'children' => [
                        [
                            'name' => 'Exhibitions',
                            'slug' => route('exhibitions')
                        ],
                        [
                            'name' => 'Events',
                            'slug' => route('events')
                        ]
                    ],
                ],
                [
                    'name' => 'The Collection',
                    'slug' => route('collection'),
                    'children' => [
                        [
                            'name' => 'Artworks',
                            'slug' => route('collection')
                        ],
                        [
                            'name' => 'Writings',
                            'slug' => route('articles_publications')
                        ],
                        [
                            'name' => 'Resources',
                            'slug' => route('collection.research_resources')
                        ]
                    ],
                ],
                [
                    'name' => 'Buy Tickets',
                    'slug' => '#',
                ],
                [
                    'name' => 'Become A Member',
                    'slug' => '#',
                ],
                [
                    'name' => 'Shop',
                    'slug' => '#',
                ],
                [
                    'name' => 'About Us',
                    'slug' => route('genericPages.show', 'about'),
                ],
                [
                    'name' => 'Learn With Us',
                    'slug' => 'learn-with-us',
                ],
                [
                    'name' => 'Support Us',
                    'slug' => 'support-us',
                ]
            ]

        ]);
      });
    }
}
