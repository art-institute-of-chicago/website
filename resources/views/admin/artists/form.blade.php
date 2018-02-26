@extends('cms-toolkit::layouts.form')

@section('contentFields')
    @formField('input', [
        'name' => 'datahub_id',
        'label' => 'Datahub ID',
        'disabled' => true
    ])
    @formField('input', [
        'name' => 'also_known_as',
        'label' => 'Also known as...',
    ])
    @formField('input', [
        'name' => 'intro_copy',
        'label' => 'Intro Copy',
        'type' => 'textarea'
    ])
@stop

@section('fieldsets')
    <a17-fieldset id="attributes" title="Related">

        @formField('browser', [
            'routePrefix' => 'whatson',
            'name' => 'articles',
            'moduleName' => 'articles',
            'max' => 4,
            'label' => 'Related Articles',
        ])

    </a17-fieldset>
@endsection
