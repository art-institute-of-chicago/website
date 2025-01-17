@twillBlockTitle('Ranged Accordion')
@twillBlockIcon('text')

@formField('radios', [
    'name' => 'type',
    'label' => 'Type',
    'default' => true,

    'options' => [
        [
            'value' => 'start',
            'label' => 'Start',
        ],
        [
            'value' => 'end',
            'label' => 'End',
        ],
    ],
])

    @formConnectedFields ([
        'fieldName' => 'type',
        'fieldValues' => 'start',
        'renderForBlocks' => true,
    ])
        <x-twill::input
            name='title'
            label='Title'
        />
    @endcomponent
