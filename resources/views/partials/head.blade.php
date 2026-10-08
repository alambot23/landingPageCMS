<header class="section-head section-head-row reveal">
    <div>
        <p class="eyebrow">{{ $eyebrow }}</p>
        <h2>{{ $title }}</h2>
        @isset($text)<p class="sub">{{ $text }}</p>@endisset
    </div>
    @isset($href)
        <a href="{{ $href }}" class="link-arrow">{{ $label ?? 'Lihat semua' }} <svg class="ic"><use href="#i-arrow"/></svg></a>
    @endisset
</header>
