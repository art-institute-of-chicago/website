@extends('twill::layouts.form')

@section('contentFields')

    @formField('input', [
        'name' => 'id',
        'label' => 'Email Series ID',
        'disabled' => true
    ])

    @formField('input', [
        'name' => 'timing_message',
        'label' => 'Timing information',
        'note' => 'Will be appended in parentheses to the label'
    ])

    <hr>

    @formField('checkbox', [
        'name' => 'show_affiliate',
        'label' => 'Show "Include affiliate-specific copy" option'
    ])

    @formField('checkbox', [
        'name' => 'show_member',
        'label' => 'Show "Include member-specific copy" option'
    ])

    @formField('checkbox', [
        'name' => 'show_sustaining_fellow',
        'label' => 'Show "Include sustaining fellow-specific copy" option'
    ])

    @formField('checkbox', [
        'name' => 'show_nonmember',
        'label' => 'Show "Include nonmember-specific copy" option'
    ])

    <p>The phrase "(overrides default copy)" will be appended to each option in the event form.</p>

    <p>If only one option is shown, we will label the option "Override default copy" for simplicity.</p>

    <hr>

    @formField('wysiwyg', [
        'name' => 'alert_message',
        'label' => 'General alert message',
        'note' => 'Will be displayed before the copy selection options',
        'toolbarOptions' => [
            'bold', 'italic', 'link'
        ],
    ])

@stop
