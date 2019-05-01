@formField('input', [
    'name' => 'youtube_url',
    'label' => 'Youtube URL'
])

@formField('multi_select', [
    'name' => 'video_play_settings',
    'label' => 'Video Player Setting',
    'min' => 1,
    'max' => 3,
    'options' => [
        [
            'value' => 'autoplay',
            'label' => 'Autoplay'
        ],
        [
            'value' => 'controls_dark',
            'label' => 'Controls Dark'
        ],
        [
            'value' => 'controls_light',
            'label' => 'Controls Light'
        ]
    ]
])

@formField('multi_select', [
    'name' => 'video_playback',
    'label' => 'playback',
    'options' => [
        [
            'value' => 'inset',
            'label' => 'Inset'
        ],
        [
            'value' => 'caption',
            'label' => 'Caption'
        ],
        [
            'value' => 'loop',
            'label' => 'Loop'
        ]
    ]
])