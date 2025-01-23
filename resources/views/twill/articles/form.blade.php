@extends('twill::layouts.form', [
    'additionalFieldsets' => [
        ['fieldset' => 'sponsors', 'label' => 'Sponsors'],
        ['fieldset' => 'attributes', 'label' => 'Attributes'],
        ['fieldset' => 'related', 'label' => 'Further Reading'],
        ['fieldset' => 'side_related', 'label' => 'Sidebar Related']
    ]
])

@section('contentFields')
    @formField('input', [
        'name' => 'title_display',
        'label' => 'Title formatting (optional)',
        'note' => 'Use <i> tag to add italics. e.g. <i>Nighthawks</i>'
    ])

    @formField('date_picker', [
        'name' => 'date',
        'label' => 'Display date',
        'optional' => false,
        'note' => 'Required',
    ])

    @formField('select', [
        'name' => 'layout_type',
        'label' => 'Article layout',
        'options' => $articleLayoutsList,
        'default' => '0'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Hero image',
        'name' => 'hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Mobile hero image',
        'name' => 'mobile_hero',
        'note' => 'Minimum image width 3000px'
    ])

    @formField('wysiwyg', [
        'type' => 'textarea',
        'name' => 'hero_caption',
        'label' => 'Hero image caption',
        'note' => 'Usually used for copyright',
        'maxlength' => 255,
        'toolbarOptions' => [
            'italic', 'link',
        ],
    ])

    @formField('multi_select', [
        'name' => 'categories',
        'label' => 'Categories',
        'options' => $categoriesList,
        'placeholder' => 'Select some categories',
    ])

    @formField('input', [
        'name' => 'subtype',
        'label' => 'Article Label'
    ])

    @formField('wysiwyg', [
        'name' => 'heading',
        'label' => 'Header',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used on the article detail page.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @formField('wysiwyg', [
        'name' => 'list_description',
        'label' => 'List Description',
        'maxlength' => 255,
        'note' => 'Max 255 characters. Will be used on the article landing and listing pages, and social media.',
        'toolbarOptions' => [
            'italic'
        ],
    ])

    @include('twill.partials.authors')

    @formField('medias', [
        'with_multiple' => false,
        'no_crop' => false,
        'label' => 'Author thumbnail',
        'name' => 'author',
        'note' => 'Minimum image width 600px'
    ])

    @formField('checkbox', [
        'name' => 'is_unlisted',
        'label' => "Don't show this article in listings",
    ])

    @formField('checkbox', [
        'name' => 'is_in_magazine',
        'label' => 'Assume this article is featured in a magazine issue',
    ])

    @formField('wysiwyg', [
        'name' => 'citations',
        'label' => 'Citation',
        'maxlength' => 255,
        'note' => 'Max 255 characters',
        'toolbarOptions' => [
            'italic', 'link',
        ],
    ])

    @formField('block_editor', [
        'blocks' => BlockHelpers::getBlocksForEditor([
            'paragraph', 'image', 'hr', 'artwork', 'split_block', 'gallery_new', 'link', 'video', 'quote', 'tour_stop', 'accordion', 'media_embed', 'list', 'grid', 'image_slider', 'button', 'audio_player', '360_embed', 'mirador_embed', '3d_embed', 'feature_2x', 'membership_banner', 'layered_image_viewer', '3d_tour', 'feature_4x', 'citation', 'citation', 'mirador_modal'
        ])
    ])

@stop

@section('fieldsets')
    <a17-fieldset id="sponsors" title="Sponsors">
        @formField('browser', [
            'routePrefix' => 'exhibitionsEvents',
            'moduleName' => 'sponsors',
            'name' => 'sponsors',
            'label' => 'Sponsors',
            'note' => 'Display content blocks from this sponsor',
            'max' => 1
        ])
    </a17-fieldset>

    <a17-fieldset id="related" title="Further Reading">
        <p>Use "Custom related items" to relate up to 4 articles to show on the article page. See special note on articles below.</p>

        @formField('browser', [
            'routePrefix' => 'collection.articlesPublications',
            'moduleName' => 'articles',
            'name' => 'further_reading_items',
            'endpoints' => [
                [
                    'label' => 'Article',
                    'value' => '/collection/articlesPublications/articles/browser'
                ],
                [
                    'label' => 'Highlight',
                    'value' => moduleRoute('highlights', 'collection', 'browser')
                ],
                [
                    'label' => 'Interactive feature',
                    'value' => moduleRoute('experiences', 'collection.interactiveFeatures', 'browser')
                ]
            ],
            'max' => 4,
            'label' => 'Custom related items',
        ])

        <p>We use Category data to determine which articles to relate. We automatically append any article related in this way to the "Related Content" section in reverse chronological order. The following articles would be shown on this article's page automatically:</p>

        @php
            $category_ids = $item->categories->pluck('id')->all();
            $relatedArticles = \App\Models\Article::byCategories($category_ids)->published()->notUnlisted()->orderBy('date', 'desc')->take(5)->get();
        @endphp
        <ol style="margin: 1em 0; padding-left: 40px">
            @foreach($relatedArticles as $article)
                @if($article->id != $item->id)
                    <li style="list-style-type: decimal; margin-bottom: 0.5em">
                        <a href="{!! route('articles.show', $article) !!}">{{ $article->title }}</a>
                    </li>
                @endif
            @endforeach
        </ol>

        <p style="margin-top: 1em">If this logic is satisfactory, there's no need to add exhibitions to the "Custom related items" field. However, if you'd like to control the order of exhibitions relative to other related content, feel free to add them using the field above.</p>
    </a17-fieldset>

    @component('twill.partials.featured-related', ['form_fields' => $form_fields, 'autoRelated' => $autoRelated, 'item' => $item])
        @slot('routePrefix', 'collection.articlesPublications')
        @slot('moduleName', 'articles')
    @endcomponent

    @include('twill.partials.related')

    @include('twill.partials.meta')

@endsection
