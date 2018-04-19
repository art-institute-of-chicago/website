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
        $hours_today = Hour::getOpeningToday();

        $view->with([
            '_hours' => [
                'general' => 'Open daily 10:30&ndash;5:00, Thursdays until 8:00'
            ,   'opening_today' => $hours_today
            ],
            '_pages' => [
                'visit' => route('visit')
            ,   'hours' => route('visit').'#hours'
            ,   'directions' => route('visit').'#directions'

            ,   'buy' => '/buy'
            ,   'become-a-member' => '/become-a-member'
            ,   'shop' => 'http://www.artinstituteshop.org'

            ,   'collection' => '/collection'
            ,   'exhibitions' => route('exhibitions')

            ,   'about-us' => '/about-us'
            ,   'about-us-inside-the-museum' => '/about-us/inside-the-museum'
            ,   'about-us-mission-history' => '/about-us/mission-history'
            ,   'about-us-leadership' => '/about-us/leadership'
            ,   'about-us-financials' => '/about-us/financial-records'

            ,   'support-us-membership' => '/support-us/membership'
            ,   'support-us-ways-to-give' => '/support-us/ways-to-give'
            ,   'support-us-affiliate-groups' => '/support-us/affiliate-groups'
            ,   'support-us-corporate-sponsorship' => '/support-us/corporate-sponsorship'

            ,   'learn' => '/learn'
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
            ,   'legal-venue-rental' => '/rental'
            ,   'legal-contact' => '/contact'
            ,   'legal-terms' => '/terms'
            ,   'legal-image-licensing' => '/image-licensing'
            ],
            'mobileNav' => [
                [
                    'name' => 'Visit',
                    'children' => [
                        [
                            'name' => 'Plan Your Visit',
                        ],
                        [
                            'name' => 'Museum Spaces',
                        ],
                        [
                            'name' => 'Group Visits',
                            'children' => [
                                [
                                    'name' => 'Adults &amp; Universities',
                                    'slug' => '#',
                                ],
                                [
                                    'name' => 'Students',
                                    'children' => [
                                        [
                                            'name' => 'Tours',
                                            'slug' => '#'
                                        ],
                                        [
                                            'name' => 'Scheduling a Tour',
                                            'slug' => '#',
                                        ],
                                        [
                                            'name' => 'Preparing For a Museum Visit',
                                            'slug' => '#',
                                        ],
                                        [
                                            'name' => 'Bus Scholarship',
                                            'slug' => '#',
                                        ],
                                        [
                                            'name' => 'Students with Disabilities',
                                            'slug' => '#',
                                        ],
                                        [
                                            'name' => 'For Tour Companies',
                                            'slug' => '#',
                                        ],
                                    ]
                                ],
                                [
                                    'name' => 'Groups FAQs',
                                    'slug' => '#',
                                ],
                            ],
                        ],
                        [
                            'name' => 'Families',
                        ],
                        [
                            'name' => 'Accessibility &amp; FAQs',
                        ],
                        [
                            'name' => 'Maps &amp; Guides',
                        ],
                    ],
                ],
                [
                    'name' => 'Exhibition &amp; Events',
                    'slug' => '#',
                ],
                [
                    'name' => 'The Collection',
                    'children' => [
                        [
                            'name' => 'Lorem Ipsum',
                        ],
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
                    'slug' => '#',
                    'class' => 'g-nav-mobile__nav--muted',
                ],
                [
                    'name' => 'Learn With Us',
                    'slug' => '#',
                    'class' => 'g-nav-mobile__nav--muted',
                ],
                [
                    'name' => 'Support Us',
                    'slug' => '#',
                    'class' => 'g-nav-mobile__nav--muted',
                ],
            ]
        ]);
      });
    }
}
