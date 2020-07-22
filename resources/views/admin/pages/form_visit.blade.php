@section('contentFields')
    @formField('medias', [
        'name' => 'visit_hero',
        'label' => 'Hero image',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('files', [
        'name' => 'video',
        'label' => 'Hero video',
        'note' => 'Add an MP4 file'
    ])

    @formField('medias', [
        'name' => 'visit_mobile',
        'label' => 'Hero image, mobile',
        'note' => 'Minimum image width 2000px'
    ])
@stop

@section('fieldsets')
    <a17-fieldset title="Hours" id="hours">
        @formField('input', [
            'name' => 'visit_hour_intro',
            'label' => 'Intro text',
            'type' => 'textarea',
            'translated' => true
        ])

        @formField('medias', [
            'name' => 'visit_featured_hour',
            'label' => 'Image',
            'max' => '1',
            'note' => 'Minimum image width 2000px'
        ])
        @formField('input', [
            'name' => 'visit_hour_header',
            'field_name' => 'visit_hour_header',
            'label' => 'Header',
            'required' => true,
            'translated' => true,
        ])
        @formField('wysiwyg', [
            'name' => 'visit_hour_subheader',
            'field_name' => 'visit_hour_subheader',
            'label' => 'Description',
            'required' => true,
            'translated' => true,
        ])
        @formField('repeater', ['type' => 'featured_hours'])
    </a17-fieldset>

    <a17-fieldset title="Call to Action" id="call-to-action">
        @formField('input', [
            'name' => 'visit_cta_module_header',
            'label' => 'Header',
            'translated' => true,
        ])

        @formField('wysiwyg', [
            'name' => 'visit_cta_module_body',
            'label' => 'Body',
            'toolbarOptions' => [
                'italic'
            ],
            'translated' => true,
        ])

        @formField('input', [
            'name' => 'visit_cta_module_button_text',
            'label' => 'Button text',
            'translated' => true,
        ])

        @formField('input', [
            'name' => 'visit_cta_module_action_url',
            'label' => 'Button URL',
            'note' => 'e.g. https://sales.artic.edu/admissions',
        ])
    </a17-fieldset>

    <a17-fieldset title="What to Expect" id="expect">
        @formField('input', [
            'name' => 'visit_what_to_expect_more_text',
            'field_name' => 'visit_what_to_expect_more_text',
            'label' => 'More link text',
            'translated' => true
        ])
        @formField('input', [
            'name' => 'visit_what_to_expect_more_link',
            'field_name' => 'visit_what_to_expect_more_link',
            'label' => 'More link'
        ])
        @formField('repeater', ['type' => 'whatToExpects'])
    </a17-fieldset>

    <a17-fieldset title="Capacity" id="capacity">
        @formField('input', [
            'name' => 'visit_capacity_alt',
            'field_name' => 'visit_capacity_alt',
            'label' => 'Graph alt text',
            'translated' => true,
            'note' => 'For screenreaders',
        ])
        @formField('input', [
            'name' => 'visit_capacity_heading',
            'field_name' => 'visit_capacity_heading',
            'label' => 'Capacity heading',
            'translated' => true,
        ])
        @formField('wysiwyg', [
            'name' => 'visit_capacity_text',
            'field_name' => 'visit_capacity_text',
            'label' => 'Capacity text',
            'toolbarOptions' => [
                'italic', 'link'
            ],
            'translated' => true,
        ])
        <hr>
        <p>Up to two buttons can be defined. We will only display a button if both its label and URL are filled out.</p>
        @formField('input', [
            'name' => 'visit_capacity_btn_text_1',
            'field_name' => 'visit_capacity_btn_text_1',
            'label' => 'Button #1 label',
            'translated' => true,
        ])
        @formField('input', [
            'name' => 'visit_capacity_btn_url_1',
            'field_name' => 'visit_capacity_btn_url_1',
            'label' => 'Button #1 URL',
        ])
        @formField('input', [
            'name' => 'visit_capacity_btn_text_2',
            'field_name' => 'visit_capacity_btn_text_2',
            'label' => 'Button #2 label',
            'translated' => true,
        ])
        @formField('input', [
            'name' => 'visit_capacity_btn_url_2',
            'field_name' => 'visit_capacity_btn_url_2',
            'label' => 'Button #2 URL',
        ])
    </a17-fieldset>

    <a17-fieldset title="Admissions" id="admissions">
        @formField('wysiwyg', [
            'name' => 'visit_admission_description',
            'field_name' => 'visit_admission_description',
            'label' => 'Admission table description',
            'translated' => true,
        ])
        @formField('input', [
            'name' => 'visit_buy_tickets_label',
            'field_name' => 'visit_buy_tickets_label',
            'label' => 'Buy tickets label',
            'translated' => true
        ])
        @formField('input', [
            'name' => 'visit_buy_tickets_link',
            'field_name' => 'visit_buy_tickets_link',
            'label' => 'Buy tickets link'
        ])
        @formField('input', [
            'name' => 'visit_become_member_label',
            'field_name' => 'visit_become_member_label',
            'label' => 'Become a member label',
            'translated' => true
        ])
        @formField('input', [
            'name' => 'visit_become_member_link',
            'field_name' => 'visit_become_member_link',
            'label' => 'Become a member link'
        ])
    </a17-fieldset>

    <a17-fieldset title="FAQs" id="faq">
        @formField('input', [
            'name' => 'visit_faq_accessibility_link',
            'label' => 'Accessibility information link'
        ])
        @formField('input', [
            'name' => 'visit_faq_more_link',
            'label' => "More FAQs and guidelines link"
        ])

        @formField('repeater', ['type' => 'faqs'])
    </a17-fieldset>

    <a17-fieldset title="Accessibility" id="accessibility">
        @formField('medias', [
            'name' => 'visit_accessibility',
            'label' => 'Image',
        ])

        @formField('input', [
            'name' => 'visit_accessibility_text',
            'label' => 'Accessibility text',
            'type' => 'textarea',
            'translated' => true
        ])

        @formField('input', [
            'name' => 'visit_accessibility_link_text',
            'label' => 'Link text',
            'translated' => true
        ])

        @formField('input', [
            'name' => 'visit_accessibility_link_url',
            'label' => 'Link URL',
            'note' => 'Accepts HTML tags',
        ])
    </a17-fieldset>

    <a17-fieldset title="Directions" id="directions">

        @formField('medias', [
            'name' => 'visit_map',
            'label' => 'Museum map',
        ])

        @formField('input', [
            'name' => 'visit_transportation_link',
            'field_name' => 'visit_transportation_link',
            'label' => 'Public transportation link',
            'required' => true
        ])

        @formField('input', [
            'name' => 'visit_parking_link',
            'field_name' => 'visit_parking_link',
            'label' => 'Directions & Parking',
            'required' => true
        ])

        @formField('input', [
            'name' => 'visit_parking_accessibility_link',
            'field_name' => 'visit_parking_accessibility_link',
            'label' => 'Visitors with Mobility Needs',
        ])

        @formField('repeater', ['type' => 'locations', 'max' => 2])
    </a17-fieldset>

    <a17-fieldset title="Ways to Explore" id="explore">
        @formField('repeater', ['type' => 'families'])
    </a17-fieldset>

@stop
