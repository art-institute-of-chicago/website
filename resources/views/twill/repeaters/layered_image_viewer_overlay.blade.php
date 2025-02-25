@twillRepeaterTitle('Overlay')
@twillRepeaterTrigger('Add overlay')
@twillRepeaterComponent('a17-block-layered_image_viewer_overlay')
@twillRepeaterMax('10')


<x-twill::medias
    name='image'
    label='Overlay'
    :max='1'
/>

<x-twill::input
    name='label'
    label='Label'
    note='Displayed at bottom of overlay'
    :maxlength='82'
/>

<x-twill::checkbox
    name='starting_view'
    label='Show this overlay in starting view'
/>
