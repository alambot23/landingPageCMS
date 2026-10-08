<div class="agenda-list">
    @foreach ($agenda as $a)
        <article class="agenda-item card reveal {{ ($lewat ?? false) ? 'is-past' : '' }}">
            <div class="date-block" aria-hidden="true">
                <span class="d">{{ $a->mulai->translatedFormat('d') }}</span>
                <span class="m">{{ $a->mulai->translatedFormat('M') }}</span>
            </div>
            <div class="agenda-info">
                <h3>{{ $a->judul }}</h3>
                @if ($a->deskripsi)<p>{{ $a->deskripsi }}</p>@endif
                <ul class="meta">
                    <li><svg class="ic"><use href="#i-calendar"/></svg>{{ $a->mulai->translatedFormat('l, d F Y') }}</li>
                    <li><svg class="ic"><use href="#i-clock"/></svg>{{ $a->mulai->format('H:i') }} WIB</li>
                    @if ($a->lokasi)<li><svg class="ic"><use href="#i-pin"/></svg>{{ $a->lokasi }}</li>@endif
                </ul>
            </div>
            @unless ($lewat ?? false)
                <a class="btn btn-outline btn-sm" href="{{ $a->google_calendar_url }}" target="_blank" rel="noopener">
                    <svg class="ic"><use href="#i-calendar"/></svg> Tambah ke Google Calendar
                </a>
            @endunless
        </article>
    @endforeach
</div>
