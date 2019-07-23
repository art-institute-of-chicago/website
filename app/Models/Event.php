<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasBlocks;
use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\HasSlug;
use App\Models\Behaviors\HasMediasEloquent;
use App\Models\Behaviors\HasRecurrentDates;
use App\Models\Behaviors\HasApiRelations;
use Carbon\Carbon;

// TODO: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Arr;

use PDO;

class Event extends AbstractModel
{
    use HasSlug, HasRevisions, HasApiRelations, HasMedias, HasMediasEloquent, HasBlocks, HasRecurrentDates, Transformable;

    protected $presenterAdmin = 'App\Presenters\Admin\EventPresenter';
    protected $presenter = 'App\Presenters\Admin\EventPresenter';

    protected $appends = ['all_dates', 'all_dates_cms'];

    protected $dispatchesEvents = [
        'saved' => \App\Events\UpdateEvent::class,
        'deleted' => \App\Events\UpdateEvent::class,
    ];

    protected $fillable = [
        'title',
        'title_display',
        'published',
        'event_type',
        'alt_types',
        'audience',
        'alt_audiences',
        'short_description',
        'list_description',
        'description',
        'hero_caption',
        'forced_date',
        'start_time',
        'end_time',
        'door_time',
        'is_private',
        'is_sales_button_hidden',
        'is_after_hours',
        'is_ticketed',
        'is_sold_out',
        'is_free',
        'is_rsvp',
        'is_member_exclusive',
        'is_registration_required',
        'is_admission_required',
        'survey_link',
        'email_series',
        'rsvp_link',
        'location',
        'content',
        'layout_type',
        'buy_button_text',
        'buy_button_caption',
        'migrated_node_id',
        'migrated_at',
        'meta_title',
        'meta_description',
        'search_tags',
        'add_to_event_email_series',
        'join_url',
        'survey_url',
        'is_presented_by_affiliate',
        'affiliate_group_id',
        'entrance',
        'publish_start_date',
        'publish_end_date',
    ];

    protected $casts = [
        'alt_types' => 'array',
        'alt_audiences' => 'array',
        'is_presented_by_affiliate' => 'boolean',
        // TODO: Confirm that this is safe to do?
        // 'is_private' => 'boolean',
        // 'is_sales_button_hidden' => 'boolean',
        // 'is_ticketed' => 'boolean',
        // 'is_free' => 'boolean',
        // 'is_rsvp' => 'boolean',
        // 'is_member_exclusive' => 'boolean',
        // 'is_registration_required' => 'boolean',
        // 'is_sold_out' => 'boolean',
    ];

    // Dropdown does not accept null keys; use big numbers
    const NULL_OPTION = 42;
    const NULL_OPTION_AFFILIATE_GROUP = 1024;

    const CLASSES_AND_WORKSHOPS = 1;
    const LIVE_ARTS = 2;
    const SCREENINGS = 3;
    const SPECIAL_EVENT = 4;
    const TALKS = 5;
    const TOUR = 6;
    const COMMUNITIES = 7;

    public static $eventTypes = [
        self::CLASSES_AND_WORKSHOPS => 'Classes and Workshops',
        self::LIVE_ARTS => 'Live Arts',
        self::SCREENINGS => 'Screenings',
        self::SPECIAL_EVENT => 'Special Event',
        self::TALKS => 'Talks',
        self::TOUR => 'Tour',
        self::COMMUNITIES => 'Programs in Communities',
    ];

    const FAMILIES = 1;
    const MEMBERS = 2;
    const ADULTS = 3;
    const TEENS = 4;
    const RESEARCHERS_SCHOLARS = 5;
    const TEACHERS = 6;
    const EVENING_ASSOCIATES = 7;
    const SUSTAINING_FELLOWS = 8;

    public static $eventAudiences = [
        self::FAMILIES => 'Families',
        self::MEMBERS => 'Members',
        self::ADULTS => 'Adults',
        self::TEENS => 'Teens',
        self::RESEARCHERS_SCHOLARS => 'Researchers/Scholars',
        self::TEACHERS => 'Teachers',
        self::EVENING_ASSOCIATES => 'Evening Associates',
        self::SUSTAINING_FELLOWS => 'Sustaining Fellows',
    ];

    const BASIC_LAYOUT = 0;
    const LARGE_LAYOUT = 1;

    public static $eventLayouts = [
        self::BASIC_LAYOUT => 'Basic',
        self::LARGE_LAYOUT => 'Large Feature',
    ];

    const MICHIGAN_AVE = 1;
    const MODERN_WING = 2;
    const COLUMBUS_DRIVE = 3;
    const NORTH_GARDEN = 4;
    const PRITZKER_GARDEN = 5;
    const SOUTH_GARDEN = 6;
    const OFF_SITE = 7;
    const WEST_BOX = 8;

    public static $eventEntrances = [
        self::MICHIGAN_AVE => 'Michigan Avenue',
        self::MODERN_WING => 'Modern Wing',
        self::COLUMBUS_DRIVE => 'Columbus Drive',
        self::NORTH_GARDEN => 'North Garden',
        self::PRITZKER_GARDEN => 'Pritzker Garden',
        self::SOUTH_GARDEN => 'South Garden',
        self::OFF_SITE => 'Off Site',
        self::WEST_BOX => 'West Box',
    ];

    public $slugAttributes = [
        'title',
    ];

    // those fields get auto set to null if not submited
    public $nullable = [];

    // those fields get auto set to false if not submited
    public $checkboxes = [
        'published',
        'is_private',
        'is_sales_button_hidden',
        'is_after_hours',
        'is_ticketed',
        'is_free',
        'is_rsvp',
        'is_member_exclusive',
        'is_admission_required',
        'is_sold_out',
        'is_registration_required'
    ];

    public $dates = [
        'date',
        'date_end',
        'migrated_at',
        'publish_start_date',
        'publish_end_date',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 16 / 9,
                ],
            ],
        ],
    ];

    public function emailSeries()
    {
        return $this
            ->belongsToMany('App\Models\EmailSeries', 'event_email_series')
            ->using('App\Models\EventEmailSeries')
            ->withPivot(
                'send_affiliate_member',
                'affiliate_member_copy',
                'send_member',
                'member_copy',
                'send_sustaining_fellow',
                'sustaining_fellow_copy',
                'send_non_member',
                'non_member_copy'
            );
    }

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getIdSlugAttribute()
    {
        return join([$this->id, $this->getSlug()], '/');
    }

    public function getUrlWithoutSlugAttribute()
    {
        return join([route('events'), '/', $this->id, '/']);
    }

    public function getTimeStartAttribute()
    {
        if ($this->date) {
            return $this->date->format('g:ia');
        }

    }

    public function getTimeEndAttribute()
    {
        if ($this->date_end) {
            return $this->date_end->format('g:ia');
        }

    }

    public function getTypeAttribute()
    {
        return 'event';
    }

    public function getAllDatesCmsAttribute()
    {
        $dates_string = '';
        foreach ($this->all_dates as $date) {

            $dates_string .= $date['date']->format('F j, Y g:i') . ' - ' . $date['date_end']->format('F j, Y g:i') . "\n";
        }

        return $dates_string;
    }

    public function getDateStartAttribute()
    {
        return $this->all_dates->first()['date'];
    }

    public function getDateEndAttribute()
    {
        return $this->all_dates->last()['date_end'];
    }

    public function getAltTypesAttribute($value)
    {
        return $this->getMultiSelectFromJsonColumn($value);
    }

    public function getAltAudiencesAttribute($value)
    {
        return $this->getMultiSelectFromJsonColumn($value);
    }

    public function setAltTypesAttribute($value)
    {
        $this->attributes['alt_types'] = $this->getJsonColumnFromMultiSelect($value);
    }

    public function setAltAudiencesAttribute($value)
    {
        $this->attributes['alt_audiences'] = $this->getJsonColumnFromMultiSelect($value);
    }

    public function getBuyTicketsLinkAttribute($value)
    {
        if ($this->rsvp_link) {
            return $this->rsvp_link;
        }
        $ticketedEvent = $this->apiModels('ticketedEvent', 'TicketedEvent')->first();
        if ($ticketedEvent) {
            $date = $this->nextOcurrence->date ?? $this->lastOcurrence->date ?? null;
            return "https://sales.artic.edu/Events/Event/" . $ticketedEvent->id . ($date ? "?date=" . $date->format('n/j/Y') : '');
        }
        return $value;
    }

    // This emulates an Eloquent collection from a JSON column
    // TODO: Move this somewhere more appropriate - presenter?
    private function getMultiSelectFromJsonColumn($value)
    {
        return collect(json_decode($value))->map(function($item) { return ['id' => $item]; })->all();
    }

    // Without this, we get `null` values in array
    // TODO: Move this somewhere more appropriate - presenter?
    private function getJsonColumnFromMultiSelect($value)
    {
        return collect($value)->filter()->values();
    }

    public function sponsors()
    {
        return $this->belongsToMany(\App\Models\Sponsor::class)->withPivot('position')->orderBy('position');
    }

    public function ticketedEvent()
    {
        return $this->apiElements()->where('relation', 'ticketedEvent');
    }

    public function programs()
    {
        return $this->belongsToMany('App\Models\EventProgram');
    }

    public function affiliateGroup()
    {
        return $this->belongsTo('App\Models\EventProgram', 'affiliate_group_id');
    }

    public function getProgramUrlsAttribute()
    {
        return $this->programs->reduce(function($carry, $item) {
            return $carry .'https://' .config('app.url') .route('events', [], false) .'?program=' .$item->id ."\n";
        });
    }

    public function scopeLanding($query)
    {
        return $query->whereLanding(true);
    }

    public function scopeIds($query, $ids = [])
    {
        return $query->whereIn('id', $ids);
    }

    public function scopeNotPrivate($query)
    {
        return $query->whereIsPrivate(false);
    }

    public function scopeFuture($query)
    {
        return $query->whereHas('eventMetas', function ($query) {
            $query->where('date_end', '>=', Carbon::now());
        });
    }

    public function scopeBetweenDates($query, $startDate, $endDate = null)
    {
        $query->rightJoin('event_metas', function ($join) {
            $join->on('events.id', '=', 'event_metas.event_id');
        });
        $query->where('event_metas.date', '>=', $startDate);

        if ($endDate) {
            $query->where('event_metas.date_end', '<=', Carbon::parse($endDate)->endOfDay());
        }

        $query->orderBy('event_metas.date', 'ASC');

        return $query;
    }

    // NOTE: This works only while there are less than 10 possible type values
    // TODO: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
    public function scopeByType($query, $type)
    {
        $type = (int) $type; // for safety and comparison

        if (!array_key_exists($type, self::$eventTypes)) {
            return $query;
        }

        return $query->where('event_type', '=', $type)
            ->orWhereRaw($this->getWhereJsonContainsRaw('alt_types', $type));
    }

    // NOTE: This works only while there are less than 10 possible audience values
    // TODO: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
    public function scopeByAudience($query, $audience)
    {
        $audience = (int) $audience; // for safety and comparison

        if (!array_key_exists($audience, self::$eventAudiences)) {
            return $query;
        }

        return $query->where('audience', '=', $audience)
            ->orWhereRaw($this->getWhereJsonContainsRaw('alt_audiences', $audience));
    }

    public function scopeByProgram($query, $program = null)
    {
        if (empty($program)) {
            return $query;
        }

        return $query->whereHas('programs', function ($query) use ($program) {
            $query->where('event_program_id', $program);
        });
    }

    // Helper function to make `LIKE` on JSON column work correctly with both MySQL and PostgreSQL
    // TODO: Use `whereJsonContains` in Laravel 5.7 - https://github.com/laravel/framework/pull/24330
    private function getWhereJsonContainsRaw($field, $value)
    {
        if (DB::connection()->getPDO()->getAttribute(PDO::ATTR_DRIVER_NAME) === 'pgsql') {
            return $field . "::text LIKE '%" . escape_like($value) . "%'";
        }

        return $field . " LIKE '%" . escape_like($value) . "%'";
    }

    public function setEventTypeAttribute($value)
    {
        $this->attributes['event_type'] = $value > count(self::$eventTypes) ? null : $value; // 1-based
    }

    public function setAudienceAttribute($value)
    {
        $this->attributes['audience'] = $value > count(self::$eventAudiences) ? null : $value; // 1-based
    }

    public function setEntranceAttribute($value)
    {
        $this->attributes['entrance'] = $value > count(self::$eventEntrances) ? null : $value; // 1-based
    }

    public function setAffiliateGroupIdAttribute($value)
    {
        $this->attributes['affiliate_group_id'] = ($value == self::NULL_OPTION_AFFILIATE_GROUP) ? null : $value;
    }

    public function scopeDefault($query)
    {
        return $query->betweenDates(Carbon::today(), Carbon::today()->addDay(14));
    }

    public function scopeSixMonths($query)
    {
        return $query->betweenDates(Carbon::today(), Carbon::today()->addMonths(6));
    }

    public function scopeYear($query)
    {
        return $query->betweenDates(Carbon::today(), Carbon::today()->addYear());
    }

    public function scopeWeekend($query)
    {
        return $query->betweenDates(Carbon::today()->nextWeekendDay(), Carbon::today()->nextWeekendDay()->addDays(2));
    }

    public static function groupByDay($collection)
    {
        return $collection->groupBy(function ($item) {
            return $item->date->format('Y-m-d');
        });
    }

    public function events()
    {
        return $this->belongsToMany(\App\Models\Event::class, 'event_event', 'event_id', 'related_event_id')->withPivot('position')->orderBy('position');
    }

    public function getNextOcurrenceExclusiveAttribute()
    {
        return $this->eventMetas()->where('date', '>=', Carbon::now())->orderBy('date', 'ASC')->first();
    }

    public function getNextOcurrenceAttribute()
    {
        return $this->eventMetas()->where('date_end', '>=', Carbon::now())->orderBy('date', 'ASC')->first();
    }

    public function getLastOcurrenceAttribute()
    {
        return $this->eventMetas()->orderBy('date', 'DESC')->first();
    }

    public function getAudienceDisplay()
    {
        $display = '';

        if ($this->audience != null) {
            $display = self::$eventAudiences[$this->audience];
        }

        return $display;
    }

    protected function transformMappingInternal()
    {
        return [
            [
                "name" => "title",
                "doc" => "Title",
                "type" => "string",
                "value" => function () {return $this->title;},
            ],
            [
                "name" => "title_display",
                "doc" => "Display Title",
                "type" => "string",
                "value" => function () {return $this->title_display;},
            ],
            [
                "name" => "image_url",
                "doc" => "Image URL",
                "type" => "string",
                "value" => function () {return $this->present()->imageUrl();},
            ],
            [
                "name" => "hero_caption",
                "doc" => "Hero caption",
                "type" => "string",
                "value" => function () {return $this->hero_caption;},
            ],
            [
                "name" => "header_description",
                "doc" => "Header Description",
                "type" => "string",
                "value" => function () {return $this->description;},
            ],
            [
                "name" => "short_description",
                "doc" => "Short Description",
                "type" => "string",
                "value" => function () {return $this->short_description;},
            ],
            [
                "name" => "list_description",
                "doc" => "list_description",
                "type" => "string",
                "value" => function () {return $this->list_description;},
            ],
            [
                "name" => "description",
                "doc" => "All copy text",
                "type" => "string",
                "value" => function () {return $this->present()->copy();},
            ],
            [
                "name" => "location",
                "doc" => "Location",
                "type" => "string",
                "value" => function () {return $this->location;},
            ],
            [
                "name" => "event_type",
                "doc" => "Type",
                "type" => "number",
                "value" => function () {return $this->event_type;},
            ],
            [
                "name" => "alt_event_types",
                "doc" => "Alternate Type",
                "type" => "number",
                "value" => function () {return Arr::pluck($this->alt_types, 'id');},
            ],
            [
                "name" => "audience",
                "doc" => "Audience",
                "type" => "string",
                "value" => function () {return $this->audience;},
            ],
            [
                "name" => "alt_audiences",
                "doc" => "Alternate Audiences",
                "type" => "number",
                "value" => function () {return Arr::pluck($this->alt_audiences, 'id');},
            ],
            [
                "name" => "programs",
                "doc" => "Programs",
                "type" => "number",
                "value" => function () {return Arr::pluck($this->programs, 'pivot.event_program_id');},
            ],
            [
                "name" => "is_ticketed",
                "doc" => "Is ticketed",
                "type" => "boolean",
                "value" => function () {return $this->is_ticketed;},
            ],
            [
                "name" => "ticketed_event_id",
                "doc" => "Unique identifer of the event in our central ticketing system",
                "type" => "string",
                "value" => function () {
                    $ticketedEvent = $this->apiModels('ticketedEvent', 'TicketedEvent')->first();
                    return $ticketedEvent ? $ticketedEvent->id : null;
                },
            ],
            [
                "name" => "buy_tickets_link",
                "doc" => "buy_tickets_link",
                "type" => "string",
                "value" => function () {return $this->buy_tickets_link;},
            ],
            [
                "name" => "rsvp_link",
                "doc" => "RSVP Link",
                "type" => "string",
                // WEB-1198: Work-around for backlogged datahub deploy.
                "value" => function () {return $this->buy_tickets_link;},
            ],
            [
                "name" => "buy_button_text",
                "doc" => "buy_button_text",
                "type" => "string",
                "value" => function () {return $this->buy_button_text;},
            ],
            [
                "name" => "buy_button_caption",
                "doc" => "buy_button_caption",
                "type" => "string",
                "value" => function () {return $this->buy_button_caption;},
            ],
            [
                "name" => "is_registration_required",
                "doc" => "Is Registration required",
                "type" => "boolean",
                "value" => function () {return $this->is_registration_required;},
            ],
            [
                "name" => "is_member_exclusive",
                "doc" => "Is member exclusive",
                "type" => "boolean",
                "value" => function () {return $this->is_member_exclusive;},
            ],
            [
                "name" => "is_sold_out",
                "doc" => "is_sold_out",
                "type" => "boolean",
                // WEB-414: Do not use `$this->present()->isSoldOut` here
                "value" => function () {return $this->is_sold_out;},
            ],
            [
                "name" => "is_free",
                "doc" => "Is Free",
                "type" => "boolean",
                "value" => function () {return $this->is_free;},
            ],
            [
                "name" => "is_rsvp",
                "doc" => "Is RSVP",
                "type" => "boolean",
                "value" => function () {return $this->is_rsvp;},
            ],
            [
                "name" => "is_private",
                "doc" => "Is Private",
                "type" => "boolean",
                "value" => function () {return $this->is_private;},
            ],
            [
                "name" => "is_sales_button_hidden",
                "doc" => "Is Sales Button Hidden",
                "type" => "boolean",
                "value" => function () {return $this->is_sales_button_hidden;},
            ],
            [
                "name" => "start_time",
                "doc" => "Start Time",
                "type" => "string",
                "value" => function () {return $this->start_time;},
            ],
            [
                "name" => "end_time",
                "doc" => "End Time",
                "type" => "string",
                "value" => function () {return $this->end_time;},
            ],
            [
                "name" => "start_date",
                "doc" => "Date the event begins",
                "type" => "string",
                "value" => function () {return $this->date_start ? $this->date_start->toIso8601String() : null;},
            ],
            [
                "name" => "end_date",
                "doc" => "Date the event ends",
                "type" => "string",
                "value" => function () {return $this->date_end ? $this->date_end->toIso8601String() : null;},
            ],
            [
                "name" => "forced_date",
                "doc" => "forced_date",
                "type" => "string",
                "value" => function () {return $this->forced_date;},
            ],
            [
                "name" => "door_time",
                "doc" => "door_time",
                "type" => "string",
                "value" => function () {return $this->door_time ? \Carbon\CarbonInterval::create($this->door_time)->format('%H:%i') : null;},
            ],
            [
                "name" => "sponsor_id",
                "doc" => "Sponsor ID",
                "type" => "integer",
                "value" => function () {return $this->sponsors->first()->id ?? null;},
            ],
            [
                "name" => "content",
                "doc" => "Content",
                "type" => "string",
                "value" => function () {return $this->content;},
            ],
            [
                "name" => "layout_type",
                "doc" => "Layout Type",
                "type" => "number",
                "value" => function () {return $this->layout_type;},
            ],
            [
                "name" => "published",
                "doc" => "Published",
                "type" => "boolean",
                "value" => function () {return $this->published;},
            ],
            [
                "name" => 'publish_start_date',
                "doc" => "Publish Start Date",
                "type" => "datetime",
                "value" => function() { return $this->publish_start_date; }
            ],
            [
                "name" => 'publish_end_date',
                "doc" => "Publish End Date",
                "type" => "datetime",
                "value" => function() { return $this->publish_end_date; }
            ],
            [
                "name" => "slug",
                "doc" => "slug",
                "type" => "string",
                "value" => function () {return $this->slug;},
            ],
            [
                "name" => "web_url",
                "doc" => "web_url",
                "type" => "string",
                "value" => function () {return url(route('events.show', $this));},
            ],
            [
                "name" => "search_tags",
                "doc" => "search_tags",
                "type" => "string",
                "value" => function () {return $this->search_tags;},
            ],
            [
                "name" => "is_admission_required",
                "doc" => "Is admission required",
                "type" => "boolean",
                "value" => function () {return $this->is_admission_required;},
            ],
            [
                "name" => "is_after_hours",
                "doc" => "Is after hours",
                "type" => "boolean",
                "value" => function () {return $this->is_after_hours;},
            ],
            [
                "name" => "entrance",
                "doc" => "Which entrance to use for this event",
                "type" => "string",
                "value" => function () {return self::$eventEntrances[$this->entrance] ?? null;},
            ],
            [
                "name" => "affiliate_group_display",
                "doc" => "Identifier of affiliate group (event program) associated with this event",
                "type" => "boolean",
                "value" => function () {
                    if ($this->is_presented_by_affiliate && $this->affiliateGroup) {
                        return str_replace(
                            '%%AffiliateGroup%%',
                            $this->affiliateGroup->name,
                            '<p>This event is presented by the %%AffiliateGroup%%.</p>'
                        );
                    }
                },
            ],
            [
                "name" => "affiliate_group_id",
                "doc" => "Identifier of affiliate group (event program) associated with this event",
                "type" => "boolean",
                "value" => function () {return $this->affiliateGroup->id ?? null;},
            ],
            [
                "name" => "join_url",
                "doc" => "URL to the membership signup page",
                "type" => "string",
                "value" => function () {return $this->join_url;},
            ],
            [
                "name" => "survey_url",
                "doc" => "URL to the survey associated with this event",
                "type" => "string",
                "value" => function () {return $this->survey_url;},
            ],
            [
                "name" => "email_series",
                "doc" => "email_series",
                "type" => "string",
                "value" => function () {
                    $affiliateGroupTitle = $this->affiliateGroup->name ?? null;
                    $emailSeriesPivots = $this->emailSeries->pluck('pivot');

                    return $emailSeriesPivots->each(function($item) use ($affiliateGroupTitle) {
                        foreach ([
                            'affiliate_member_copy',
                            'member_copy',
                            'sustaining_fellow_copy',
                            'non_member_copy',
                        ] as $field) {
                            if (isset($item->$field)) {
                                if (isset($affiliateGroupTitle)) {
                                    $item->$field = str_replace(
                                        '%%AffiliateGroup%%',
                                        $affiliateGroupTitle,
                                        $item->$field
                                    );
                                } else {
                                    $paragraphs = preg_split( '/(?<=<\/p>)\s*(?=<p)/', $item->$field, -1, PREG_SPLIT_DELIM_CAPTURE);
                                    $paragraphs = array_filter($paragraphs, function($paragraph) {
                                        return strpos($paragraph, '%%AffiliateGroup%%') === false;
                                    });
                                    $item->$field = count($paragraphs) > 0 ? implode('', $paragraphs) : null;
                                }
                            }
                        }
                    });
                },
            ],
        ];
    }

    /**
     * Validate an id. Useful for validating routes or query string params.
     *
     * By default, only numeric ids greater than zero are accepted. Override this
     * method in child classes to implement different validation rules (e.g. UUID).
     *
     * @param mixed $id
     * @return boolean
     */
    public static function validateId( $id )
    {
        // By default, only allow numeric ids greater than 0
        return is_numeric($id) && intval($id) > 0;
    }

}
