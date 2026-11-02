@php
    $position = $helper->getSetting('position', 'bottom-right');
    $draggable = (bool) $helper->getSetting('draggable', true);
    $showOnMobile = (bool) $helper->getSetting('show_on_mobile', true);
    $autoOpen = (bool) $helper->getSetting('auto_open', false);
    $autoOpenDelay = (int) $helper->getSetting('auto_open_delay', 5);
    $shopButtonText = $helper->getSetting('shop_button_text', trans('plugins/instagram-feed::instagram-feed.shop_button_text_default'));
    $shopButtonUrl = $helper->getSetting('shop_button_url') ?: $helper->defaultShopButtonUrl();
    $profileUrl = $helper->profileUrl();
    $followButtonText = $helper->getSetting('follow_button_text');
    $widgetSize = $helper->getSetting('widget_size', 'compact');
    $clickToLoad = (bool) $helper->getSetting('click_to_load', false);
    $mobileBottomOffset = max(0, min(300, (int) $helper->getSetting('mobile_bottom_offset', 20)));
@endphp

<div
    id="instagram-feed-widget"
    class="if-widget if-position-{{ $position }} if-size-{{ $widgetSize }} @if(! $showOnMobile) if-hide-mobile @endif"
    data-draggable="{{ $draggable ? '1' : '0' }}"
    data-auto-open="{{ $autoOpen ? '1' : '0' }}"
    data-auto-open-delay="{{ $autoOpenDelay }}"
    data-stack-position="{{ $position }}"
    style="--if-mobile-bottom: {{ $mobileBottomOffset }}px"
>
    <button type="button" class="if-toggle" aria-expanded="false" aria-controls="if-panel">
        <span class="if-toggle-icon">
            <x-core::icon name="ti ti-brand-instagram" :wrapper="false" />
        </span>
    </button>

    <div class="if-panel" id="if-panel">
        <button type="button" class="if-close" aria-label="{{ trans('plugins/instagram-feed::instagram-feed.close') }}">
            <x-core::icon name="ti ti-x" :wrapper="false" />
        </button>

        <div class="if-track" style="--if-slides: {{ $posts->count() }}">
            @foreach ($posts as $post)
                <div class="if-slide">
                    @if ($clickToLoad)
                        <button
                            type="button"
                            class="if-facade"
                            @if ($post->cover_image) style="background-image: url('{{ RvMedia::getImageUrl($post->cover_image) }}')" @endif
                            aria-label="{{ trans('plugins/instagram-feed::instagram-feed.tap_to_play') }}"
                        >
                            <span class="if-facade-play">
                                <x-core::icon name="ti ti-player-play-filled" :wrapper="false" />
                            </span>
                            <span class="if-facade-label">{{ trans('plugins/instagram-feed::instagram-feed.tap_to_play') }}</span>
                        </button>
                    @endif
                    <iframe
                        class="if-embed"
                        data-src="{{ $post->embedUrl() }}"
                        title="{{ $post->title ?: 'Instagram post or reel' }}"
                        allow="encrypted-media; picture-in-picture"
                        allowfullscreen
                        scrolling="no"
                    ></iframe>
                </div>
            @endforeach
        </div>

        @if ($posts->count() > 1)
            <button type="button" class="if-nav if-nav-prev" aria-label="Previous">
                <x-core::icon name="ti ti-chevron-left" :wrapper="false" />
            </button>
            <button type="button" class="if-nav if-nav-next" aria-label="Next">
                <x-core::icon name="ti ti-chevron-right" :wrapper="false" />
            </button>

            <div class="if-dots">
                @foreach ($posts as $index => $post)
                    <button
                        type="button"
                        class="if-dot @if ($index === 0) is-active @endif"
                        data-index="{{ $index }}"
                        data-shop-url="{{ $post->product_url ?: $shopButtonUrl }}"
                    ></button>
                @endforeach
            </div>
        @endif

        <div class="if-overlay-bottom">
            @if ($profileUrl)
                <a
                    href="{{ $profileUrl }}"
                    target="_blank"
                    rel="noopener nofollow"
                    class="if-follow-btn @if(! $followButtonText) if-follow-btn-icon @endif"
                    title="{{ $followButtonText ?: trans('plugins/instagram-feed::instagram-feed.follow_button_text') }}"
                >
                    <x-core::icon name="ti ti-brand-instagram" :wrapper="false" />
                    @if ($followButtonText)
                        <span>{{ $followButtonText }}</span>
                    @endif
                </a>
            @endif
            <a
                href="{{ $posts->first()->product_url ?: $shopButtonUrl }}"
                class="if-shop-btn"
                data-default-url="{{ $shopButtonUrl }}"
            >
                <x-core::icon name="ti ti-shopping-bag" :wrapper="false" />
                {{ $shopButtonText }}
            </a>
        </div>
    </div>
</div>
