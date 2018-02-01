<{{ $tag or 'li' }} class="m-listing{{ (isset($variation)) ? ' '.$variation : '' }}">
    <a href="{{ $item->slug }}" class="m-listing__link">
        <span class="m-listing__img m-listing__img--tall m-listing__img--tall--no-bg">
            @component('components.molecules._m-image-stack')
                @slot('images', $item->images)
            @endcomponent
        </span>
        <span class="m-listing__meta">
            <em class="type f-tag">Selection</em>
            <br>
            <strong class="title f-list-3">{{ $item->title }}</strong>
        </span>
    </a>
</{{ $tag or 'li' }}>
