<?php

namespace App\Models\Api;

use A17\Twill\Models\Behaviors\HasPresenter;
use App\Libraries\Api\Models\BaseApiModel;
use Illuminate\Support\Carbon;

class Exhibition extends BaseApiModel
{
    use HasPresenter;

    protected $endpoints = [
        'collection' => '/api/v1/exhibitions',
        'resource' => '/api/v1/exhibitions/{id}',
        'search' => '/api/v1/exhibitions/search',
    ];

    protected $appends = ['date'];

    protected $augmented = true;
    protected $augmentedModelClass = 'App\Models\Exhibition';

    protected $presenter = 'App\Presenters\Admin\ExhibitionPresenter';
    protected $presenterAdmin = 'App\Presenters\Admin\ExhibitionPresenter';

    // Generates the id-slug type of URL
    public function getRouteKeyName()
    {
        return 'id_slug';
    }

    public function getTypeAttribute()
    {
        return 'exhibition';
    }

    public function getisClosedAttribute()
    {
        return $this->status == 'Closed';
    }

    public function getIdSlugAttribute()
    {
        return join(array_filter([$this->id, $this->getSlug()]), '/');
    }

    public function getAicDateStartAttribute()
    {
        if (!empty($this->aic_start_at)) {
            return new Carbon($this->aic_start_at);
        }

    }

    public function getDateStartAttribute()
    {
        if (!empty($this->aic_start_at)) {
            return new Carbon($this->aic_start_at);
        }

    }

    public function getDateEndAttribute()
    {
        if (!empty($this->aic_end_at)) {
            return new Carbon($this->aic_end_at);
        }

    }

    public function getClosingSoonAttribute()
    {
        if (!empty($this->dateEnd)) {
            return Carbon::now()->between($this->dateEnd->endOfDay()->subWeeks(2), $this->dateEnd->endOfDay());
        }

    }

    public function getNowOpenAttribute()
    {
        if (!empty($this->dateStart) && !empty($this->dateEnd)) {
            return Carbon::now()->between($this->dateStart->startOfDay(), $this->dateStart->startOfDay()->addWeeks(2));
        }

    }

    public function getOngoingAttribute()
    {
        if (!empty($this->dateStart) && !empty($this->dateEnd)) {
            return Carbon::now()->between($this->dateStart->startOfDay(), $this->dateEnd->endOfDay());
        }

    }

    public function scopeOrderBy($query, $field, $direction = 'asc')
    {
        $params = [
            "sort" => [
                "{$field}.keyword" => $direction
            ]
        ];

        return $query->rawQuery($params);
    }

    public function scopeOrderByDate($query, $direction = 'asc')
    {
        $params = [
            "sort" => [
                'aic_start_at' => $direction
            ]
        ];

        return $query->rawQuery($params);
    }

    // EXAMPLE SCOPE:
    // Search for all exhibitions for the next 2 weeks, not closed
    public function scopeCurrent($query)
    {
        $params = [
            'bool' => [
                'must' => [
                    0 => [
                        'range' => [
                            'aic_end_at' => [
                                'gte' => 'now',
                            ],
                        ],
                    ],
                    1 => [
                        'range' => [
                            'aic_start_at' => [
                                'lte' => 'now',
                            ],
                        ],
                    ],
                ],
                'must_not' => [
                    'term' => [
                        'status' => 'Closed',
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }

    public function scopeUpcoming($query)
    {
        $params = [
            'bool' => [
                'must' => [
                    0 => [
                        'range' => [
                            'aic_start_at' => [
                                'gte' => 'now',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        return $query->rawSearch($params);
    }

    public function scopeHistory($query, $year = null)
    {
        if ($year == null) {
            $params = [
                'bool' => [
                    'must' => [
                        0 => [
                            'range' => [
                                'aic_end_at' => [
                                    'lte' => 'now',
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        } else {
            $start = $year . '-01-01';
            $end = $year . '-12-31';
            $params = [
                'bool' => [
                    'must' => [
                        0 => [
                            'range' => [
                                'aic_start_at' => [
                                    'lte' => $end,
                                ],
                            ],
                        ],
                        1 => [
                            'range' => [
                                'aic_start_at' => [
                                    'gte' => $start,
                                ],
                            ],
                        ],
                        2 => [
                            'term' => [
                                'status' => 'Closed',
                            ],
                        ],
                    ],
                ],
            ];
        }

        return $query->orderByDate('asc')->rawSearch($params);
    }

    // Solve this using casts. Because it returns an object it can't be used on the CMS
    // A value option could be added when showing
    // public function getStartAtAttribute($value) {
    //     return $this->asDateTime($value)->format("Y-m-d h:m:s T");
    // }

    // public function getEndAtAttribute($value) {
    //     return $this->asDateTime($value)->format("Y-m-d h:m:s T");
    // }

    public function artworks()
    {
        return $this->hasMany(\App\Models\Api\Artwork::class, 'artwork_ids');
    }

    public function artists()
    {
        return $this->hasMany(\App\Models\Api\Artist::class, 'artist_ids');
    }
}
