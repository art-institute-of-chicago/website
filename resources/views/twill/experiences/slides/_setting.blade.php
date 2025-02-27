@unless($item->module_type === 'attract' || $item->module_type === 'end')
<x-twill::select
    name='module_type'
    label='Module Type'
    placeholder='Select a type'
    :required='true'
    :options="[
        [
            'value' => 'split',
            'label' => 'Split'
        ],
        [
            'value' => 'interstitial',
            'label' => 'Interstitial'
        ],
        [
            'value' => 'tooltip',
            'label' => 'Tooltip'
        ],
        [
            'value' => 'fullwidthmedia',
            'label' => 'Full-Width Media'
        ],
        [
            'value' => 'compare',
            'label' => 'Compare'
        ],
        [
            'value' => '3dtour',
            'label' => '3D Tour'
        ]
    ]"
/>
@endunless

<x-twill::formConnectedFields
    field-name='module_type'
    field-values="split"
    :keep-alive='true'
>
    <x-twill::multi-select
        name='split_attributes'
        label='Attributes'
        unpack='true'
        :options="[
            [
                'value' => 'inset',
                'label' => 'Inset'
            ],
            [
                'value' => 'primary_modal',
                'label' => 'Primary Modal'
            ],
            [
                'value' => 'headline',
                'label' => 'Headline'
            ],
            [
                'value' => 'secondary_image',
                'label' => 'Secondary Image'
            ],
            [
                'value' => 'secondary_modal',
                'label' => 'Secondary Modal'
            ]
        ]"
    />
</x-twill::formConnectedFields>
