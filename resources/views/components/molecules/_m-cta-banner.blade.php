@php
    $tag = $tag ?? 'aside';

    $href = $href ?? '#';
    $image = $image ?? null;
    $header = $header ?? null;
    $body = $body ?? null;
    $button_text = $button_text ?? null;
@endphp
<{{ $tag }} class="m-cta-banner{{ isset($image) ? ' m-cta-banner--with-image' : '' }}{{ (isset($variation)) ? ' '.$variation : '' }}"{!! isset($image) ? ' data-behavior="bannerParallax"' : '' !!}>
    <a href="{{ $href }}" class="m-cta-banner__link"{!! (isset($gtmAttributes)) ? ' '.$gtmAttributes.'' : '' !!}>
        @if (isset($image))
            <div class="m-cta-banner__img" data-parallax-img>
                @component('components.atoms._img')
                    @slot('image', $image)
                    @slot('settings', array(
                        'fit' => 'crop',
                        'ratio' => '25:4',
                        'srcset' => array(300,600,1000,1500,2000),
                        'sizes' => aic_imageSizes(array(
                              'xsmall' => '58',
                              'small' => '58',
                              'medium' => '58',
                              'large' => '58',
                              'xlarge' => '58',
                        )),
                    ))
                @endcomponent
            </div>
        @endif
        <div class="m-cta-banner__txt">
            <div class="m-cta-banner__title f-module-title-2">{!! SmartyPants::defaultTransform($header) !!}</div>
            <div class="m-cta-banner__msg f-list-2">{!! SmartyPants::defaultTransform($body) !!}</div>
            <div class="m-cta-banner__action"><span class="btn f-buttons{{ isset($image) ? ' btn--contrast' : '' }}">{!! SmartyPants::defaultTransform($button_text) !!}</span></div>
        </div>
    </a>
</{{ $tag }}>
