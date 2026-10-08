/* HIMDES landing page - JavaScript ringan tanpa library */
(function () {
    'use strict';

    var $ = function (s, c) { return (c || document).querySelector(s); };
    var $$ = function (s, c) { return Array.prototype.slice.call((c || document).querySelectorAll(s)); };

    var root = document.documentElement;

    /* ---- Header: transparan di atas hero, solid saat di-scroll ---- */
    var header = $('#header');
    if (header) {
        var onScroll = function () { header.classList.toggle('is-solid', window.scrollY > 24); };
        onScroll();
        window.addEventListener('scroll', onScroll, { passive: true });
    }

    /* ---- Menu mobile ---- */
    var toggle = $('#navToggle');
    var nav = $('#nav');
    var setMenu = function (open) {
        root.classList.toggle('nav-open', open);
        if (toggle) {
            toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            toggle.setAttribute('aria-label', open ? 'Tutup menu' : 'Buka menu');
        }
    };
    if (toggle && nav) {
        toggle.addEventListener('click', function () { setMenu(toggle.getAttribute('aria-expanded') !== 'true'); });
        nav.addEventListener('click', function (e) { if (e.target.closest('a')) setMenu(false); });
        window.addEventListener('resize', function () { if (window.innerWidth > 900) setMenu(false); });
    }

    /* ---- Dropdown "Lainnya" (desktop) ---- */
    $$('[data-dropdown]').forEach(function (dd) {
        var btn = $('.dropdown-btn', dd);
        var close = function () { dd.classList.remove('open'); btn.setAttribute('aria-expanded', 'false'); };
        btn.addEventListener('click', function () {
            var open = !dd.classList.contains('open');
            dd.classList.toggle('open', open);
            btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        if (window.matchMedia('(hover: hover)').matches) {
            dd.addEventListener('mouseenter', function () { if (window.innerWidth > 900) { dd.classList.add('open'); btn.setAttribute('aria-expanded', 'true'); } });
            dd.addEventListener('mouseleave', close);
        }
        document.addEventListener('click', function (e) { if (!dd.contains(e.target)) close(); });
        document.addEventListener('keydown', function (e) { if (e.key === 'Escape') { close(); setMenu(false); } });
    });

    /* ---- Carousel hero ---- */
    $$('[data-carousel]').forEach(function (box) {
        var slides = $$('.slide', box), dots = $$('.dot', box);
        if (slides.length < 2) return;
        var i = 0, timer = null, paused = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        var pauseBtn = $('[data-pause]', box);
        var go = function (n) {
            i = (n + slides.length) % slides.length;
            slides.forEach(function (s, k) { s.classList.toggle('is-active', k === i); });
            dots.forEach(function (d, k) { d.classList.toggle('is-active', k === i); });
        };
        var stop = function () { clearInterval(timer); timer = null; };
        var play = function () { stop(); if (!paused) timer = setInterval(function () { go(i + 1); }, 6500); };
        var setPaused = function (p) {
            paused = p;
            if (pauseBtn) pauseBtn.setAttribute('aria-pressed', p ? 'true' : 'false');
            play();
        };
        if (pauseBtn) {
            pauseBtn.setAttribute('aria-pressed', paused ? 'true' : 'false');
            pauseBtn.addEventListener('click', function () { setPaused(!paused); });
        }
        box.addEventListener('click', function (e) {
            var d = e.target.closest('[data-dir]'), g = e.target.closest('[data-go]');
            if (d) go(i + parseInt(d.getAttribute('data-dir'), 10));
            if (g) go(parseInt(g.getAttribute('data-go'), 10));
            if (d || g) play();
        });
        box.addEventListener('mouseenter', stop);
        box.addEventListener('mouseleave', play);
        box.addEventListener('focusin', stop);
        box.addEventListener('focusout', play);
        var x0 = null;
        box.addEventListener('touchstart', function (e) { x0 = e.touches[0].clientX; }, { passive: true });
        box.addEventListener('touchend', function (e) {
            if (x0 === null) return;
            var dx = e.changedTouches[0].clientX - x0;
            if (Math.abs(dx) > 50) { go(i + (dx < 0 ? 1 : -1)); play(); }
            x0 = null;
        });
        document.addEventListener('visibilitychange', function () { document.hidden ? stop() : play(); });
        play();
    });

    /* ---- Lightbox galeri ---- */
    var lb = $('#lightbox');
    if (lb && lb.showModal) {
        var links = $$('[data-lightbox]'), cur = 0;
        var img = $('img', lb), cap = $('figcaption', lb);
        var show = function (n) {
            cur = (n + links.length) % links.length;
            img.src = links[cur].getAttribute('href');
            img.alt = links[cur].getAttribute('data-caption') || '';
            cap.textContent = img.alt;
        };
        links.forEach(function (a, k) {
            a.addEventListener('click', function (e) {
                e.preventDefault();
                show(k);
                lb.showModal();
            });
        });
        lb.addEventListener('click', function (e) {
            var act = e.target.closest('[data-lb]');
            if (act) {
                var v = act.getAttribute('data-lb');
                if (v === 'close') lb.close(); else show(cur + (v === 'next' ? 1 : -1));
            } else if (e.target === lb) { lb.close(); }
        });
        lb.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowRight') show(cur + 1);
            if (e.key === 'ArrowLeft') show(cur - 1);
        });
    }

    /* ---- Pencarian panduan maba ---- */
    var gs = $('#guideSearch');
    if (gs) {
        var items = $$('.qa'), cats = $$('.guide-cat'), gEmpty = $('#guideEmpty');
        gs.addEventListener('input', function () {
            var t = gs.value.trim().toLowerCase(), n = 0;
            items.forEach(function (q) {
                var ok = !t || q.getAttribute('data-text').indexOf(t) !== -1;
                q.hidden = !ok;
                if (ok) n++;
                if (t && ok) q.open = true;
            });
            cats.forEach(function (c) { c.hidden = !$$('.qa:not([hidden])', c).length; });
            if (gEmpty) gEmpty.hidden = n !== 0;
        });
    }

    /* ---- Animasi muncul saat di-scroll ---- */
    var reveals = $$('.reveal');
    if ('IntersectionObserver' in window && reveals.length) {
        var io = new IntersectionObserver(function (entries) {
            entries.forEach(function (en) {
                if (en.isIntersecting) {
                    en.target.classList.add('in');
                    io.unobserve(en.target);
                }
            });
        }, { threshold: 0.12, rootMargin: '0px 0px -40px 0px' });
        reveals.forEach(function (el) { io.observe(el); });
    } else {
        reveals.forEach(function (el) { el.classList.add('in'); });
    }

    /* ---- Filter chip (galeri & peluang) ---- */
    $$('[data-filter-group]').forEach(function (group) {
        var target = $('[data-filter-target="' + group.getAttribute('data-filter-group') + '"]');
        if (!target) return;
        group.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-filter]');
            if (!btn) return;
            $$('.chip', group).forEach(function (c) { c.classList.toggle('is-active', c === btn); });
            var f = btn.getAttribute('data-filter');
            $$('[data-group]', target).forEach(function (item) {
                var show = f === '*' || item.getAttribute('data-group') === f;
                item.hidden = !show;
                if (show) item.classList.add('in');
            });
        });
    });

    /* ---- Tab panduan ---- */
    $$('[data-tabs]').forEach(function (tabs) {
        var name = tabs.getAttribute('data-tabs');
        tabs.addEventListener('click', function (e) {
            var btn = e.target.closest('[data-tab]');
            if (!btn) return;
            var id = btn.getAttribute('data-tab');
            $$('.tab', tabs).forEach(function (t) {
                var on = t === btn;
                t.classList.toggle('is-active', on);
                t.setAttribute('aria-selected', on ? 'true' : 'false');
            });
            $$('[data-tabs-panel="' + name + '"]').forEach(function (p) {
                var on = p.getAttribute('data-panel') === id;
                p.classList.toggle('is-active', on);
                if (on) $$('.reveal', p).forEach(function (r) { r.classList.add('in'); });
            });
        });
    });

    /* ---- Pencarian direktori anggota ---- */
    var grid = $('#directoryGrid');
    if (grid) {
        var q = $('#dirSearch'), kampus = $('#dirKampus'), angkatan = $('#dirAngkatan'), empty = $('#directoryEmpty');
        var cards = $$('.member', grid);
        var apply = function () {
            var term = (q.value || '').trim().toLowerCase();
            var shown = 0;
            cards.forEach(function (c) {
                var ok = (!term || c.getAttribute('data-search').indexOf(term) !== -1) &&
                         (!kampus.value || c.getAttribute('data-kampus') === kampus.value) &&
                         (!angkatan.value || c.getAttribute('data-angkatan') === angkatan.value);
                c.hidden = !ok;
                if (ok) { shown++; c.classList.add('in'); }
            });
            if (empty) empty.hidden = shown !== 0;
        };
        [q, kampus, angkatan].forEach(function (el) {
            el.addEventListener('input', apply);
            el.addEventListener('change', apply);
        });
    }

    /* ---- Formulir pendaftaran -> pesan WhatsApp ---- */
    var form = $('#joinForm');
    if (form) {
        var errorBox = $('#joinError');
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            var data = {};
            var valid = true;
            ['nama', 'hp', 'kampus', 'jurusan', 'angkatan', 'asal'].forEach(function (name) {
                var field = form.elements[name];
                var value = (field.value || '').trim();
                data[name] = value;
                var bad = !value;
                if (name === 'hp' && value && value.replace(/\D/g, '').length < 9) bad = true;
                field.classList.toggle('is-invalid', bad);
                if (bad) valid = false;
            });
            errorBox.hidden = valid;
            if (!valid) return;

            var text =
                'Halo Admin ' + form.getAttribute('data-org') + ', saya ingin mendaftar sebagai anggota.\n\n' +
                'Nama: ' + data.nama + '\n' +
                'No. WhatsApp: ' + data.hp + '\n' +
                'Kampus: ' + data.kampus + '\n' +
                'Jurusan: ' + data.jurusan + '\n' +
                'Angkatan: ' + data.angkatan + '\n' +
                'Asal daerah: ' + data.asal + '\n\n' +
                'Mohon informasi langkah selanjutnya. Terima kasih.';

            var url = 'https://wa.me/' + form.getAttribute('data-wa') + '?text=' + encodeURIComponent(text);
            window.open(url, '_blank', 'noopener');
        });
    }
})();
