@twillRepeaterTitle('Offer')
@twillRepeaterTrigger('Add offer')
@twillRepeaterComponent('a17-block-offer')
@twillRepeaterMax('10')

@formField('medias', [
    'name' => 'image',
    'label' => 'Image',
    'max' => '1',
    'note' => 'Minimum image width 2000px'
])

<x-twill::input
    name='header'
    label='Header'
/>

<x-twill::input
    name='subheader'
    label='Subheader'
/>

<x-twill::input
    type='textarea'
    name='description'
    label='Description'
    :rows='4'
/>

<x-twill::input
    name='link_to_book'
    label='Link to Book'
/>
