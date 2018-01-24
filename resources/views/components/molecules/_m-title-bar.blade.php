<div class="m-title-bar {{ $variation ?? '' }}"{!! isset($id) ? ' id="'.$id.'"' : '' !!}>
  <h2 class="title {{ $titleFont ?? 'f-module-title-2' }}">{{ $slot }}</h2>
  @if (isset($links) and $links)
  <ul class="m-title-bar__links">
    @foreach ($links as $link)
    <li><a href="{{ $link['href'] }}" class="f-buttons">{{ $link['label'] }}<svg aria-hidden="true" class="icon--arrow"><use xlink:href="#icon--arrow" /></svg></a></li>
    @endforeach
  </ul>
  @endif
</div>
