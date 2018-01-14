<{{ $tag or 'header' }} class="m-article-header m-article-header--hero{{ (isset($variation)) ? ' '.$variation : '' }}">
  <div class="m-article-header__img">
      @if (isset($img))
        @component('components.atoms._img')
            @slot('src', $img['src'])
            @slot('width', $img['width'])
            @slot('height', $img['height'])
        @endcomponent
      @endif
  </div>
  <div class="m-article-header__text">
      @if (isset($articleType))
        @component('components.atoms._title')
            @slot('tag','p')
            @slot('font', 'f-tag-2')
            {{ ucfirst($articleType) }}
        @endcomponent
      @endif
      @if (isset($title))
        @component('components.atoms._title')
            @slot('tag','h1')
            @slot('font', 'f-display-3')
            {{ $title }}
        @endcomponent
      @endif
      @if (isset($img) and isset($img['credit']))
        @if ($img['creditUrl'])
            <a href="{{ $img['creditUrl'] }}" class="m-article-header__info-trigger">
                <svg class="icon--info-i" aria-label="Image credit"><use xlink:href="#icon--info-i" /></svg>
            </a>
        @else
            <button class="m-article-header__info-trigger" id="image-credit-trigger" aria-selected="false" aria-controls="image-credit" aria-expanded="false" data-behavior="imageInfo">
              <svg class="icon--info-i" aria-label="Image credit"><use xlink:href="#icon--info-i" /></svg>
            </button>
            <div class="m-article-header__info" id="image-credit" aria-labelledby="image-info-trigger" aria-hidden="true" role="Tooltip">
              <p class="f-caption">{{ $img['credit'] }}</p>
            </div>
        @endif
      @endif
  </div>
</{{ $tag or 'header' }}>
