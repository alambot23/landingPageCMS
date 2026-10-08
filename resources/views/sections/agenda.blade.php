<section class="section" id="agenda">
    <div class="container">
        @include('partials.head', ['eyebrow' => 'Kalender Kegiatan', 'title' => 'Agenda mendatang', 'text' => 'Simpan jadwal langsung ke Google Calendar agar tidak ketinggalan.', 'href' => route('agenda'), 'label' => 'Semua agenda'])

        @if ($agenda->isEmpty())
            <p class="empty">Belum ada agenda mendatang.</p>
        @else
            @include('blocks.agenda', ['agenda' => $agenda])
        @endif
    </div>
</section>
