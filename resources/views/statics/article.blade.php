@extends('layouts.app')

@section('content')

<article class="o-article{{ ($article->articleType === 'editorial') ? ' o-article--editorial' : '' }}">

  @component('components.molecules._m-article-header')
    @slot('editorial', ($article->articleType === 'editorial'))
    @slot('headerType', ($article->headerType ?? null))
    @slot('variation', ($article->headerVariation ?? null))
    @slot('variation', 'mike')
    @slot('title', $article->title)
    @slot('date', $article->date)
    @slot('type', $article->type)
    @slot('intro', $article->intro)
    @slot('img', $article->headerImage)
  @endcomponent

  <div class="o-article__primary-actions">
    @component('components.molecules._m-article-actions')
        @slot('editorial', ($article->articleType === 'editorial'))
    @endcomponent

    @if ($article->nav)
        {{-- dupe 😢 - shows xlarge+ --}}
        @component('components.molecules._m-link-list')
            @slot('variation', 'u-show@xlarge+')
            @slot('links', $article->nav);
        @endcomponent
    @endif
  </div>

  {{-- dupe 😢 - hides xlarge+ --}}
  <div class="o-article__meta">
    @if ($article->nav)
        @component('components.molecules._m-link-list')
            @slot('links', $article->nav);
        @endcomponent
    @endif
  </div>

  <div class="o-article__secondary-actions">
    @if ($article->articleType === 'exhibition')
        @component('components.molecules._m-ticket-actions----exhibition')
        @endcomponent
    @endif

    @if ($article->articleType === 'event')
        @component('components.molecules._m-ticket-actions----event')
            @slot('ticketPrices', $article->ticketPrices);
            @slot('ticketLink', $article->ticketLink);
        @endcomponent
    @endif

    @if ($article->featuredRelated)
      {{-- dupe 😢 - shows medium+ --}}
      @component('components.blocks._inline-aside')
          @slot('variation', 'u-show@medium+')
          @slot('type', $article->featuredRelated['type'])
          @slot('items', $article->featuredRelated['items'])
          @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
      @endcomponent
    @endif
  </div>

  @if ($article->intro and $article->headerType !== 'hero')
  <div class="o-article__intro">
    @component('components.blocks._text')
        @slot('font', 'f-deck')
        {{ $article->intro }}
    @endcomponent
  </div>
  @endif

  @if ($article->featuredRelated)
  {{-- dupe 😢 - hidden medium+ --}}
  <div class="o-article__related">
    @component('components.blocks._inline-aside')
        @slot('type', $article->featuredRelated['type'])
        @slot('items', $article->featuredRelated['items'])
        @slot('itemsMolecule', '_m-listing----'.$article->featuredRelated['type'])
    @endcomponent
  </div>
  @endif

  <div class="o-article__body o-blocks" data-behavior="articleBodyInViewport">
    @component('components.blocks._blocks')
        @slot('editorial', ($article->articleType === 'editorial'))
        @slot('blocks', $article->blocks ?? null)
    @endcomponent

    @component('components.molecules._m-article-actions')
        @slot('variation','m-article-actions--keyline-top')
        @slot('editorial', ($article->articleType === 'editorial'))
    @endcomponent
  </div>

  @component('components.atoms._btn')
      @slot('variation', 'btn--icon arrow-link--up o-article__top-link')
      @slot('font', '')
      @slot('icon', 'icon--arrow')
      @slot('behavior', 'topLink')
      @slot('tag', 'a')
      @slot('href', '#a17')
  @endcomponent

</article>

@if ($article->relatedEventsByDay)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('text' => 'See all events', 'href' => '#')))
        Related Events
    @endcomponent

    @component('components.organisms._o-row-listing')
        @foreach ($article->relatedEventsByDay as $date)
            @component('components.molecules._m-date-listing')
                @slot('date', $date)
            @endcomponent
        @endforeach
    @endcomponent

    @component('components.molecules._m-links-bar')
        @slot('variation', 'm-links-bar--buttons')
        @slot('linksPrimary', array(array('text' => 'Load more', 'href' => '#', 'variation' => 'btn--secondary')))
    @endcomponent
@endif

@if ($article->relatedExhibitions)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('text' => 'See all exhibitions', 'href' => '#')))
        Related Exhibitions
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('cols_xxlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedExhibitions as $exhibition)
            @component('components.molecules._m-listing----exhibition')
                @slot('exhibition', $exhibition)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($article->relatedEvents)
    @component('components.molecules._m-title-bar')
        @slot('links', array(array('text' => 'See all events', 'href' => '#')))
        Related Events
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('cols_xxlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedEvents as $event)
            @component('components.molecules._m-listing----event')
                @slot('event', $event)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@if ($article->relatedArticles)
    @component('components.molecules._m-title-bar')
        Further Reading
    @endcomponent

    @component('components.organisms._o-grid-listing')
        @slot('variation', 'o-grid-listing--single-row o-grid-listing--scroll@xsmall o-grid-listing--scroll@small o-grid-listing--hide-extra@medium o-grid-listing--gridlines-cols')
        @slot('cols_medium','3')
        @slot('cols_large','4')
        @slot('cols_xlarge','4')
        @slot('cols_xxlarge','4')
        @slot('behavior','dragScroll')
        @foreach ($article->relatedArticles as $editorial)
            @component('components.molecules._m-listing----article')
                @slot('article', $editorial)
            @endcomponent
        @endforeach
    @endcomponent
@endif

@endsection
