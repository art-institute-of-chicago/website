@twillRepeaterTitle('List Item')
@twillRepeaterTrigger('Add item')
@twillRepeaterComponent('a17-block-list_item')
@twillRepeaterMax('10')

<x-twill::medias
    name='image'
    label='Image'
    :max='1'
/>

<x-twill::input
    name='tag'
    label='Tag'
    :maxlength='20'
/>

<x-twill::input
    name='header'
    label='Header'
    :maxlength='60'
/>

<x-twill::wysiwyg
    name='description'
    label='Description'
    :rows='4'
    :toolbar-options="[ 'italic' ]"
/>

<x-twill::input
    name='external_link'
    label='Link'
/>
