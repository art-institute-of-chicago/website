@formField('input', [
    'name' => 'name',
    'label' => 'Entrance',
    'required' => true
])

@component('cms-toolkit::partials.form.utils._collapsed_fields', ['label' => 'Edit location'])
    @formField('input', [
        'name' => 'street',
        'label' => 'Street',
    ])
    @formField('input', [
        'name' => 'address',
        'label' => 'Address',
    ])

    @formField('input', [
        'name' => 'city',
        'label' => 'City',
    ])
    @formField('input', [
        'name' => 'state',
        'label' => 'State',
    ])
    @formField('input', [
        'name' => 'zip',
        'label' => 'ZIP code',
    ])
@endcomponent
