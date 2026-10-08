@if ($prestasi->isEmpty())
    <p class="empty">Prestasi belum tersedia.</p>
@else
    <ol class="timeline">
        @foreach ($prestasi as $item)
            <li class="timeline-item reveal">
                <span class="year">{{ $item->tahun }}</span>
                <div class="card">
                    @if ($item->gambar_url)
                        <img class="card-cover" src="{{ $item->gambar_url }}" alt="" width="640" height="360" loading="lazy">
                    @endif
                    <div class="timeline-meta">
                        <svg class="ic"><use href="#i-award"/></svg>
                        @if ($item->peringkat)<strong>{{ $item->peringkat }}</strong>@endif
                        @if ($item->tingkat)<span class="tag">Tingkat {{ $item->tingkat }}</span>@endif
                    </div>
                    <h3>{{ $item->judul }}</h3>
                    @if ($item->deskripsi)<p>{{ $item->deskripsi }}</p>@endif
                </div>
            </li>
        @endforeach
    </ol>
@endif
