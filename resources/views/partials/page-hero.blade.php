<section class="page-hero">
    <div class="container {{ ($narrow ?? false) ? 'narrow' : '' }}">
        <p class="eyebrow eyebrow-light">{{ $eyebrow }}</p>
        <h1>{{ $title }}</h1>
        @isset($text)<p class="lead">{{ $text }}</p>@endisset
        {{ $slot ?? '' }}
    </div>
</section>
