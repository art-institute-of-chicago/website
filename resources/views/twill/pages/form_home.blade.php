@section('contentFields')
    <x-twill::input
        name='home_intro'
        label='Intro text'
        type='textarea'
    />

    <x-twill::browser
        name='mainHomeFeatures'
        label='Main feature'
        note='Queue up to 3 home features for the large hero area'
        route-prefix='homepage'
        module-name='homeFeatures'
        :max='3'
    />

    <x-twill::browser
        name='secondaryHomeFeatures'
        label='Secondary features'
        note='Queue up to 5 home features for the two smaller hero areas'
        route-prefix='homepage'
        module-name='homeFeatures'
        :max='5'
    />
@stop

@section('fieldsets')
    <a17-fieldset title="Plan your visit" id="plan-your-visit">
        <x-twill::input
            name='home_visit_button_text'
            label='Label for "Visit" button'
            note='Defaults to "Visit"'
        />

        <x-twill::input
            name='home_visit_button_url'
            label='Link for "Visit" button'
            note='Defaults to "/visit"'
        />

        <hr/>

        <x-twill::input
            name='home_plan_your_visit_link_1_text'
            label='First "Plan your visit" link text'
        />

        <x-twill::input
            name='home_plan_your_visit_link_1_url'
            label='First "Plan your visit" link URL'
        />

        <x-twill::input
            name='home_plan_your_visit_link_2_text'
            label='Second "Plan your visit" link text'
        />

        <x-twill::input
            name='home_plan_your_visit_link_2_url'
            label='Second "Plan your visit" link URL'
        />

        <x-twill::input
            name='home_plan_your_visit_link_3_text'
            label='Third "Plan your visit" link text'
        />

        <x-twill::input
            name='home_plan_your_visit_link_3_url'
            label='Third "Plan your visit" link URL'
        />
    </a17-fieldset>

    <a17-fieldset title="Video carousel" id="video-carousel">

        <x-twill::input
            name='home_video_title'
            label='Title'
        />

        <x-twill::wysiwyg
            name='home_video_description'
            label='Description'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::browser
            name='homeVideos'
            label='Video carousel'
            route-prefix='collection.articlesPublications'
            module-name='videos'
            :max='10'
        />
    </a17-fieldset>

    <a17-fieldset title="Call to Action Module" id="call-to-action">

        <x-twill::medias
            label='Image'
            name='home_cta_module_image'
        />

        <x-twill::input
            name='home_cta_module_header'
            label='Header'
        />

        <x-twill::wysiwyg
            name='home_cta_module_body'
            label='Body'
            :toolbar-options="[ 'italic' ]"
        />

        <x-twill::input
            name='home_cta_module_button_text'
            label='Button text'
        />

        <x-twill::radios
            name='variation'
            label='Variation'
            default='{{ \App\Models\Lightbox::VARIATION_DEFAULT }}'
            :inline='false'
            :options="[
                [
                    'value' => '{{ \App\Models\Lightbox::VARIATION_DEFAULT }}',
                    'label' => 'Default (button)'
                ],
                [
                    'value' => '{{ \App\Models\Lightbox::VARIATION_NEWSLETTER }}',
                    'label' => 'Newsletter (button + email input)'
                ],
                [
                    'value' => '{{ \App\Models\Lightbox::VARIATION_EMAIL }}',
                    'label' => 'Email capture (button + email input)'
                ]{{ config('aic.show_button_and_date_select_lightbox_variation') ? ', [ \'value\' => ' . \App\Models\Lightbox::VARIATION_TICKETING . ', '\label\' => \'Ticketing (button + date select) (WIP)\' ]' }}
            ]"
        />

        <p>If you choose any variation except "Newsletter", you must fill out the "Metadata" fields below. The "Newsletter" variation works like the newsletter signup in our footer.</p>

        <hr>

        <x-twill::input
            name='home_cta_module_action_url'
            label='Action URL'
            note='e.g. https://join.artic.edu/secure/holiday-annual-fund'
        />

        <x-twill::input
            name='home_cta_module_form_tlc_source'
            label='Form TLC Source'
            note='e.g. AIC17137L01'
        />

        <x-twill::input
            name='home_cta_module_form_token'
            label='Form Token'
            note='e.g. pa5U17siEjW4suerjWEB5LP7sFJYgAwLZYMS6kNTEag'
        />

        <x-twill::input
            name='home_cta_module_form_id'
            label='Form ID'
            note='e.g. webform_client_form_5111'
        />
    </a17-fieldset>

    <a17-fieldset title="Highlights" id="highlights">
        <x-twill::browser
            name='homeHighlights'
            label='Highlights'
            route-prefix='collection'
            module-name='highlights'
            :max='10'
        />
    </a17-fieldset>

    <a17-fieldset title="Artists" id="artists">
        @formField('repeater', [ 'type' => 'artists' ])
    </a17-fieldset>

    <a17-fieldset title="From the Collection" id="from-the-collection">
        <x-twill::browser
            name='homeArtworks'
            label='Artworks'
            route-prefix='collection'
            module-name='artworks'
            :max='20'
        />
    </a17-fieldset>

    <a17-fieldset title="From the Shop" id="from-the-shop">
        <x-twill::browser
            name='homeShopItems'
            label='Featured shop items'
            note='Select up to 5 shop items you want to feature on the homepage'
            route-prefix='general'
            module-name='shopItems'
            :max='5'
        />
    </a17-fieldset>

    <a17-fieldset title="Exhibitions and Event" id="exhibitions-and-events">
        <x-twill::browser
            name='homeExhibitions'
            label='Featured exhibitions'
            route-prefix='exhibitionsEvents'
            module-name='exhibitions'
            :max='2'
        />

        <x-twill::browser
            name='homeEvents'
            label='Featured events'
            note='Select up to 10 events you want to feature on the homepage'
            route-prefix='exhibitionsEvents'
            module-name='events'
            :max='10'
        />
    </a17-fieldset>
@stop
