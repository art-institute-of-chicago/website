<x-twill::select
    name='modal_type'
    label='Modal Type'
    placeholder='Choose Modal Type'
    default='image'
    :options="[
        [
            'value' => 'image',
            'label' => 'Image'
        ],
        [
            'value' => 'video',
            'label' => 'Video'
        ],
        [
            'value' => 'image_sequence',
            'label' => 'Image Sequence'
        ],
        [
            'value' => '3d_model',
            'label' => '3D Model'
        ]
    ]"
/>

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'image',
        'renderForBlocks' => true,
        'keepAlive' => true
/>
    <x-twill::checkbox
        name='zoomable'
        label='Zoomable'
    />

    <x-twill::repeater
        type="modal_experience_image"
    />
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'video',
        'renderForBlocks' => true,
        'keepAlive' => true
])
    @include('twill.experiences.slides._video_form')
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => 'image_sequence',
        'renderForBlocks' => true,
        'keepAlive' => true
])
    <x-twill::files
        name='image_sequence_file'
        label='Image Sequence Zip'
        note='Upload a .zip file'
    />

    <x-twill::multi-select
        name='image_sequence_playback'
        label='playback'
        :options="[
            [
                'value' => 'reverse',
                'label' => 'Reverse'
            ],
            [
                'value' => 'infinite',
                'label' => 'Infinite'
            ]
        ]"
    />
@endcomponent

@component('twill::partials.form.utils._connected_fields', [
        'fieldName' => 'modal_type',
        'fieldValues' => '3d_model',
        'renderForBlocks' => true,
        'keepAlive' => true
])
    <br />
    <a17-block-aic_3d_model :name="fieldName('aic_split_3d_model')" :thumbnail="false" :caption="false" :browser="false" :cc0="false" />
@endcomponent

<x-twill::wysiwyg
    name='image_sequence_caption'
    label='Caption'
    :maxlength='500'
/>
