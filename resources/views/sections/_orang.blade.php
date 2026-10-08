<article class="person reveal {{ ($kecil ?? false) ? 'person-sm' : '' }}">
    @if ($p->foto_url)
        <img class="avatar" src="{{ $p->foto_url }}" alt="Foto {{ $p->nama }}" width="96" height="96" loading="lazy">
    @else
        <div class="avatar avatar-initial" aria-hidden="true">{{ $p->inisial }}</div>
    @endif
    <h3>{{ $p->nama }}</h3>
    <p class="role">{{ $p->jabatan }}</p>
    @if ($p->is_kepala)<span class="tag tag-gold">Kepala divisi</span>@endif
    @if ($p->kampus)
        <p class="muted small">{{ $p->kampus }}</p>
    @endif
    @if ($p->whatsapp || $p->instagram)
        <div class="person-links">
            @if ($p->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D+/', '', $p->whatsapp) }}" target="_blank" rel="noopener" aria-label="WhatsApp {{ $p->nama }}"><svg class="ic"><use href="#i-chat"/></svg></a>
            @endif
            @if ($p->instagram)
                <a href="https://instagram.com/{{ ltrim($p->instagram, '@') }}" target="_blank" rel="noopener" aria-label="Instagram {{ $p->nama }}"><svg class="ic"><use href="#i-instagram"/></svg></a>
            @endif
        </div>
    @endif
</article>
