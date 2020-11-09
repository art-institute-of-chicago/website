<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Application Namespace
    |--------------------------------------------------------------------------
    |
    | This value is the namespace of your application.
    |
     */
    'namespace' => 'App',

    /*
    |--------------------------------------------------------------------------
    | Application Admin URL
    |--------------------------------------------------------------------------
    |
    | This value is the URL of your admin application.
    |
     */
    'admin_app_url' => env('ADMIN_APP_URL', 'admin.' . env('APP_URL')),
    'admin_app_path' => env('ADMIN_APP_PATH', ''),

    /*
    |--------------------------------------------------------------------------
    | Application Admin Title Suffix
    |--------------------------------------------------------------------------
    |
    | This value is added to the title tag of your Admin application.
    |
     */
    'admin_app_title_suffix' => env('ADMIN_APP_TITLE_SUFFIX', 'Admin'),

    /*
    |--------------------------------------------------------------------------
    | Admin subdomain routing support
    |--------------------------------------------------------------------------
    |
    | Enabling this allows adding top level keys to Twill's navigation and
    | dashboard modules configuration, mapping to a subdomain.
    | This is a very simple way to implement multi-tenant CMS/sites in Twill.
    | A navigation array looking like the following would expose your CMS on
    | the 'admin.subdomain1.app-url.test' and 'admin.subdomain2.app-url.test'
    | urls, with its corresponding links.
    | [
    |   'subdomain1' => [
    |     'module1' => [...],
    |     ...
    |   ],
    |   'subdomain2' => [
    |     'module2' => [...]
    |     ...
    |   ]
    | ]
    |
    | App name can be set per subdomain using the 'twill.app_names'
    | configuration array. For our example above:
    | [
    |   'app_names' => [
    |     'subdomain1' => 'App 1 name',
    |     'subdomain2' => 'App 2 name',
    |   ],
    | ]
    |
    | Subdomain configuration nesting also applies to the dashboard
    | 'modules' key.
    |
    | You can provide a custom 'block_single_layout' per subdomain by
    | creating a Blade file under resources/views/subdomain/layouts/blocks.
    |
     */
    'support_subdomain_admin_routing' => false,
    'admin_app_subdomain' => 'admin',
    'active_subdomain' => null,

    /*
    |--------------------------------------------------------------------------
    | Application Admin Route and domain pattern
    |--------------------------------------------------------------------------
    |
    | This value add some patterns for the domain and routes of the admin.
    |
     */
    'admin_route_patterns' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Prevent the routing system to duplicate prefix and module on route names
    |--------------------------------------------------------------------------
    |
     */
    'allow_duplicates_on_route_names' => true,

    /*
    |--------------------------------------------------------------------------
    | Twill middleware group configuration
    |--------------------------------------------------------------------------
    |
    | Right now this only allows you to redefine the default login redirect path.
    |
     */
    'admin_middleware_group' => 'web',

    /*
    |--------------------------------------------------------------------------
    | Twill default tables naming configuration
    |--------------------------------------------------------------------------
    |
    | TODO: In Twill 3.0, all tables will be prefixed by `twill_`.
    |
     */
    'users_table' => 'users',
    'password_resets_table' => 'password_resets',
    'users_oauth_table' => 'twill_users_oauth',
    'blocks_table' => 'blocks',
    'features_table' => 'features',
    'settings_table' => 'settings',
    'medias_table' => 'medias',
    'mediables_table' => 'mediables',
    'files_table' => 'files',
    'fileables_table' => 'fileables',
    'related_table' => 'related',

    /*
    |--------------------------------------------------------------------------
    | Twill migrations configuration
    |--------------------------------------------------------------------------
    |
    | Since Laravel 5.8, migrations generated by Laravel use big integers
    | on the `id` column. Twill migrations helpers can be configured to
    | use regular integers for backwards compatiblity.
    |
     */
    'migrations_use_big_integers' => true,

    /*
    |
    | Since Twill 2.0, migrations are not published anymore but loaded
    | automatically in Twill's service provider. Set to false to prevent
    | this from happening if you need to customize Twill's tables.
    |
     */
    'load_default_migrations' => true,

    /*
    |--------------------------------------------------------------------------
    | Twill Auth related configuration
    |--------------------------------------------------------------------------
    |
     */
    'auth_login_redirect_path' => '/',
    'templates_on_frontend_domain' => true,
    'google_maps_api_key' => env('GOOGLE_MAPS_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Twill FE Application configuration
    |--------------------------------------------------------------------------
    |
     */
    'js_namespace' => 'TWILL',
    'dev_mode' => false,
    'dev_mode_url' => env('TWILL_DEV_MODE_URL', 'http://localhost:8080'),
    'public_directory' => env('TWILL_ASSETS_DIR', 'assets/admin'),
    'manifest_file' => 'twill-manifest.json',
    'vendor_path' => 'vendor/area17/twill',
    'custom_components_resource_path' => 'assets/js/components',
    'build_timeout' => 300,

    'internal_icons' => [
        'content-editor.svg',
        'close_modal.svg',
        'edit_large.svg',
        'google-sign-in.svg',
    ],

    /*
    |--------------------------------------------------------------------------
    | Twill app locale
    |--------------------------------------------------------------------------
    |
     */
    'locale' => 'en',
    'fallback_locale' => 'en',

    'available_user_locales' => [
        'en',
        'fr',
        'pl',
        'de',
        'nl',
        'pt',
        'zh-Hans',
        'ru',
    ],

    /*
    |--------------------------------------------------------------------------
    | Non-standard configurations
    |--------------------------------------------------------------------------
    |
     */
    'bind_exception_handler' => false,

    'buckets' => [
        'homepage' => [
            'name' => 'Home',
            'buckets' => [
                'home_main_features' => [
                    'name' => 'Home main feature',
                    'bucketables' => [
                        [
                            'module' => 'homeFeatures',
                            'name' => 'Home Features',
                        ],
                    ],
                    'max_items' => 5,
                ],
                'home_art_and_ideas' => [
                    'name' => 'The Collection',
                    'bucketables' => [
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                        [
                            'module' => 'selections',
                            'name' => 'Highlights',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 6,
                ],
            ],
        ],

        'art_and_ideas' => [
            'name' => 'The Collection',
            'buckets' => [
                'art_and_ideas_main_features' => [
                    'name' => 'The Collection featured articles',
                    'bucketables' => [
                        [
                            'module' => 'articles',
                            'name' => 'Articles',
                            'scopes' => ['published' => true],
                        ],
                    ],
                    'max_items' => 2,
                ],
            ],
        ],
    ],

    'imgix_source_host' => env('IMGIX_SOURCE_HOST', 'artic-web.imgix.net')
];
