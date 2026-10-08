/* Panel admin HIMDES: laci menu, tab, pratinjau gambar, konfirmasi hapus. */
(function () {
    'use strict';
    var $ = function (s, c) { return (c || document).querySelector(s); };
    var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };
    var root = document.documentElement;

    /* Laci menu (tablet & ponsel) */
    document.addEventListener('click', function (e) {
        var a = e.target.closest('[data-adm]');
        if (a) root.classList.toggle('adm-drawer', a.getAttribute('data-adm') === 'open');
        else if (e.target.closest('.adm-nav a')) root.classList.remove('adm-drawer');
    });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape') root.classList.remove('adm-drawer'); });

    /* Konfirmasi hapus */
    document.addEventListener('submit', function (e) {
        var msg = e.target.getAttribute && e.target.getAttribute('data-confirm');
        if (msg && !window.confirm(msg)) e.preventDefault();
    });

    /* Tab (Beranda & Profil), tersimpan di hash URL */
    var tabs = $('.adm-tabs');
    if (tabs) {
        var buttons = $$('[data-tab]', tabs), field = $('#tabField');
        var show = function (name) {
            if (!buttons.some(function (b) { return b.getAttribute('data-tab') === name; })) name = 'carousel';
            buttons.forEach(function (b) {
                var on = b.getAttribute('data-tab') === name;
                b.classList.toggle('is-active', on);
                b.setAttribute('aria-selected', on ? 'true' : 'false');
            });
            $$('[data-panel]').forEach(function (p) {
                p.hidden = (' ' + p.getAttribute('data-panel') + ' ').indexOf(' ' + name + ' ') === -1;
            });
            if (field) field.value = name;
        };
        tabs.addEventListener('click', function (e) {
            var b = e.target.closest('[data-tab]');
            if (!b) return;
            show(b.getAttribute('data-tab'));
            history.replaceState(null, '', '#' + b.getAttribute('data-tab'));
        });
        show(location.hash.replace('#', '') || 'carousel');
    }

    /* Pratinjau gambar sebelum diunggah */
    $$('input[type=file][data-preview]').forEach(function (inp) {
        inp.addEventListener('change', function () {
            var box = inp.nextElementSibling;
            if (!box || !box.classList.contains('prev-grid')) return;
            box.innerHTML = '';
            Array.prototype.slice.call(inp.files).slice(0, 12).forEach(function (f) {
                var img = document.createElement('img');
                img.alt = '';
                img.src = URL.createObjectURL(f);
                box.appendChild(img);
            });
            box.hidden = !inp.files.length;
        });
    });

    /* Pesan sukses hilang sendiri */
    var ok = $('.alert-ok');
    if (ok) setTimeout(function () { ok.style.transition = 'opacity .5s'; ok.style.opacity = '0'; setTimeout(function () { ok.remove(); }, 600); }, 4500);
})();
