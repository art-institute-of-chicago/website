@extends('layouts.app')

@section('content')

<article class="o-article" data-behavior="addHistory" data-add-url="{!! route('artworks.addRecentlyViewed', $item) !!}" itemscope itemtype="http://schema.org/CreativeWork">

  @component('site.shared._schemaItemProps')
    @slot('itemprops',$item->present()->buildSchemaItemProps() ?? null)
  @endcomponent

  {{-- Gallery-type _m-article-header never renders title --}}
  <h1 class="sr-only">{{ $item->title }}</h1>

  @component('components.molecules._m-article-header')
    {{-- @slot('editorial', false) --}}
    @slot('headerType', $item->headerType)
    {{-- @slot('variation', ($item->headerVariation ?? null)) --}}
    @slot('title', $item->title)
    @slot('date',  $item->date)
    @slot('type',  $item->type)
    @slot('intro', $item->heading)
    @slot('img',   $item->imageFront('hero'))
    @slot('galleryImages', $item->galleryImages)
    @slot('isZoomable', $item->is_zoomable)
    @slot('isPublicDomain', $item->is_public_domain)
    @slot('maxZoomWindowSize', $item->max_zoom_window_size)
    @slot('prevNextObject', $prevNextObject ?? null)
  @endcomponent

  <div class="o-article__primary-actions o-article__primary-actions--inline-header u-show@large+" aria-label="Additional information">
    @if ($item->is_on_view)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.atoms._title')
            @slot('variation', 'u-show@large+')
            @slot('tag','h2')
            @slot('font', 'f-module-title-1')
            @slot('ariaHidden', "true")
            On View
        @endcomponent
    @endif

    <ul class="list list--inline f-secondary">
      @if ($item->department_id)
      <li><a href="{!! route('departments.show', [$item->department_id]) !!}" data-gtm-event="{{ $item->department_title }}" data-gtm-event-action="{{$item->title}}" data-gtm-event-category="collection-nav">{{ $item->department_title }}</a></li>
      @endif
      @if ($item->gallery_id)
      <li><a href="{!! route('galleries.show', [$item->gallery_id]) !!}" data-gtm-event="{{ $item->gallery_title }}"  data-gtm-event-action="{{$item->title}}" data-gtm-event-category="collection-nav">{{ $item->gallery_title }}</a></li>
      @endif
    </ul>
  </div>

  <div class="o-article__secondary-actions o-article__secondary-actions--inline-header u-show@medium+">

    @if ($item->featuredRelated)
      {{-- dupe 😢 - shows medium+ --}}
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@medium+')
          @slot('type', $item->featuredRelated['type'])
          @slot('items', $item->featuredRelated['items'])
          @slot('titleFont', "f-list-1")
          @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
          @slot('imageSettings', array(
              'fit' => 'crop',
              'ratio' => '16:9',
              'srcset' => array(200,400,600),
              'sizes' => aic_imageSizes(array(
                    'xsmall' => '0',
                    'small' => '23',
                    'medium' => '18',
                    'large' => '13',
                    'xlarge' => '13',
              )),
          ))
          @slot('gtmAttributes', 'data-gtm-event="related-article" data-gtm-event-category="collection-nav"')
      @endcomponent
    @endif
  </div>

  <div class="o-article__inline-header">
    @if ($item->title)
      @component('components.atoms._title')
          @slot('tag','span')
          @slot('font', 'f-headline-editorial')
          @slot('variation', 'o-article__inline-header-title')
          @slot('ariaHidden', 'true')
          {{ $item->title }}
      @endcomponent
    @endif

    @if ($item->date_display)
      <h2 class="sr-only">Date:</h2>
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-display')
          {{ $item->date_display }}
      @endcomponent
    @endif

    @if ($item->artist_display)
      <h2 class="sr-only">Artist:</h2>
      @component('components.atoms._title')
          @slot('tag','p')
          @slot('font', 'f-secondary')
          @slot('variation', 'o-article__inline-header-display')
          {{ $item->artist_display }}
      @endcomponent
    @endif
  </div>

  {{-- TODO: Integrate related elements. Should be loaded indirectly from related entities --}}
  @if ($item->featuredRelated)
  {{-- dupe 😢 - hidden medium+ --}}
  <div class="o-article__related">
    @component('components.blocks._inline-aside')
        @slot('type', $item->featuredRelated['type'])
        @slot('items', $item->featuredRelated['items'])
        @slot('titleFont', "f-list-1")
        @slot('itemsMolecule', '_m-listing----'.$item->featuredRelated['type'])
        @slot('imageSettings', array(
            'fit' => 'crop',
            'ratio' => '16:9',
            'srcset' => array(200,400,600),
            'sizes' => aic_imageSizes(array(
                  'xsmall' => '58',
                  'small' => '23',
                  'medium' => '18',
                  'large' => '0',
                  'xlarge' => '0',
            )),
        ))
        @slot('gtmAttributes', 'data-gtm-event="related-article" data-gtm-event-category="collection-nav"')
    @endcomponent
  </div>
  @endif

  <div class="o-article__body{{ (empty($item->description) or $item->description === '') ? ' o-article__body--no-description' : '' }} o-blocks">

    <h2 class="sr-only">About this artwork</h2>

    @component('components.blocks._blocks')
        @slot('blocks', $item->present()->blocks ?? null)
    @endcomponent

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('articleType', $item->type)
    @endcomponent
  </div>

</article>

@if (($exploreFurther && !$exploreFurther->isEmpty()) || ($exploreFurtherAllTags))
<div id="exploreFurther">
    @component('components.molecules._m-title-bar')
        Explore Further
    @endcomponent

    @component('site.shared._explore-further-menu')
        @slot('tags', $exploreFurtherTags)
        @slot('ariaLabel', 'h-explore-further')
        @slot('ariaControls', 'explore-further-pinboard')
    @endcomponent

    @if ($exploreFurther && !$exploreFurther->isEmpty() && !$exploreFurtherAllTags)
        @component('components.organisms._o-pinboard')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('maintainOrder','false')
            @slot('id','explore-further-pinboard')
            @slot('title', 'Artworks related to tag')
            @foreach ($exploreFurther as $item)
                @component('components.molecules._m-listing----'.$item->type)
                    @slot('variation', 'o-pinboard__item')
                    @slot('item', $item)
                    @slot('imageSettings', array(
                        'fit' => ($item->type !== 'selection' and $item->type !== 'artwork') ? 'crop' : null,
                        'ratio' => ($item->type !== 'selection' and $item->type !== 'artwork') ? '16:9' : null,
                        'srcset' => array(200,400,600),
                        'sizes' => aic_gridListingImageSizes(array(
                              'xsmall' => '1',
                              'small' => '2',
                              'medium' => '3',
                              'large' => '4',
                              'xlarge' => '4',
                        )),
                    ))
                @endcomponent
            @endforeach
        @endcomponent
    @endif

    @if ($exploreFurtherAllTags)
        @component('components.molecules._m-multi-col-list')
            @slot('cols_small','2')
            @slot('cols_medium','3')
            @slot('cols_large','4')
            @slot('cols_xlarge','4')
            @slot('title', 'All tags on this artwork')
            @slot('items', $exploreFurtherAllTags)
        @endcomponent
    @endif

    @if ($exploreFurtherCollectionUrl)
        @component('components.molecules._m-links-bar')
            @slot('variation', 'm-links-bar--buttons')
            @slot('linksPrimary', [
                [
                    'label' => 'See more results',
                    'href' => $exploreFurtherCollectionUrl,
                    'variation' => 'btn--tertiary'
                ]
            ])
        @endcomponent
    @endif
</div>

@endif

<div class="o-injected-container" data-behavior="injectContent" data-injectContent-url="{!! route('artworks.recentlyViewed') !!}" data-user-artwork-history></div>

@endsection
