/* América Licenciamentos — interações da home */
(function () {
  'use strict';

  /* Menu mobile */
  var header = document.querySelector('.site-header');
  var toggle = document.querySelector('.menu-toggle');
  if (header && toggle) {
    toggle.addEventListener('click', function () {
      var open = header.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'Fechar menu' : 'Abrir menu');
    });
    header.querySelectorAll('.nav a').forEach(function (a) {
      a.addEventListener('click', function () { header.classList.remove('is-open'); toggle.setAttribute('aria-expanded', 'false'); });
    });
  }

  /* Heros alternando ("Cidade" e "Sócio") — provisório até o cliente escolher.
     Só roda com html.hero-rotate (posto no <head>: modo "alternar" e sem "reduzir movimento"). */
  var mqReduce = matchMedia('(prefers-reduced-motion: reduce)');
  var heroSlider = document.querySelector('[data-hero-slider]');
  if (heroSlider && document.documentElement.classList.contains('hero-rotate') && !mqReduce.matches) {
    var hSlides = heroSlider.querySelectorAll('[data-hero-slide]');
    var hDotsWrap = heroSlider.querySelector('[data-hero-dots]');
    var hCur = 0, hTimer = null, hStopped = false, hHover = false, hVisible = true;
    var HERO_MS = 7000;
    var hDots = [];
    hSlides.forEach(function (s, i) {
      var b = document.createElement('button');
      b.type = 'button';
      b.setAttribute('data-hero-dot', '');
      b.setAttribute('aria-label', 'Mostrar apresentação ' + (i + 1));
      b.addEventListener('click', function () { hShow(i); hStop(true); });
      hDotsWrap.appendChild(b);
      hDots.push(b);
    });
    // Pausar/retomar (WCAG 2.2.2): aria-pressed="true" = pausado
    var hToggle = document.createElement('button');
    hToggle.type = 'button';
    hToggle.className = 'hero-slider__toggle';
    hToggle.innerHTML = '<svg class="i-pause" viewBox="0 0 10 10" aria-hidden="true"><path d="M2 1h2v8H2zM6 1h2v8H6z" fill="currentColor"/></svg>' +
      '<svg class="i-play" viewBox="0 0 10 10" aria-hidden="true"><path d="M2 1l7 4-7 4z" fill="currentColor"/></svg>';
    hDotsWrap.appendChild(hToggle);
    var hShow = function (i) {
      hCur = i;
      hSlides.forEach(function (s, j) {
        var on = j === i;
        s.classList.toggle('is-current', on);
        if (on) { s.removeAttribute('aria-hidden'); s.inert = false; } else { s.setAttribute('aria-hidden', 'true'); s.inert = true; }
        if (on && s.classList.contains('hero--socio')) {
          s.classList.remove('is-entering'); void s.offsetWidth; s.classList.add('is-entering');
        }
      });
      hDots.forEach(function (d, j) { d.setAttribute('aria-current', String(j === i)); });
    };
    var hSchedule = function () {
      clearTimeout(hTimer);
      if (hStopped || hHover || !hVisible || document.hidden || mqReduce.matches) return;
      hTimer = setTimeout(function () { hShow((hCur + 1) % hSlides.length); hSchedule(); }, HERO_MS);
    };
    var hStop = function (on) {
      hStopped = on;
      hToggle.setAttribute('aria-pressed', String(on));
      hToggle.setAttribute('aria-label', on ? 'Retomar troca automática' : 'Pausar troca automática');
      hSchedule();
    };
    hToggle.addEventListener('click', function () { hStop(!hStopped); });
    heroSlider.addEventListener('mouseenter', function () { hHover = true; hSchedule(); });
    heroSlider.addEventListener('mouseleave', function () { hHover = false; hSchedule(); });
    heroSlider.addEventListener('focusin', function () { hHover = true; hSchedule(); });
    heroSlider.addEventListener('focusout', function () { hHover = false; hSchedule(); });
    document.addEventListener('visibilitychange', hSchedule);
    // "Reduzir movimento" ligado no meio da sessão: para de trocar (fica no slide atual)
    var hOnReduce = function (e) { if (e.matches) hStop(true); };
    if (mqReduce.addEventListener) mqReduce.addEventListener('change', hOnReduce);
    else if (mqReduce.addListener) mqReduce.addListener(hOnReduce);
    if ('IntersectionObserver' in window) {
      new IntersectionObserver(function (en) { hVisible = en[0].isIntersecting; hSchedule(); }).observe(heroSlider);
    }
    heroSlider.classList.add('is-slider');
    hShow(0);
    hStop(false);
  }

  /* Documentos: abas em acordeão + troca da ilustração */
  // Corpo recolhido de acordeão não recebe foco (os links "Ver …" eram paradas de Tab invisíveis)
  function setInert(el, on) { if (el) el.inert = on; }

  var docList = document.querySelector('[data-docs]');
  var docArt = document.querySelector('[data-docs-art]');
  if (docList) {
    docList.querySelectorAll('.doc').forEach(function (d) { setInert(d.querySelector('.doc__body'), !d.classList.contains('is-active')); });
    docList.addEventListener('click', function (e) {
      var head = e.target.closest('.doc__head');
      if (!head) return;
      var item = head.closest('.doc');
      if (item.classList.contains('is-active')) return;
      docList.querySelectorAll('.doc').forEach(function (d) {
        var on = d === item;
        d.classList.toggle('is-active', on);
        d.querySelector('.doc__head').setAttribute('aria-expanded', String(on));
        setInert(d.querySelector('.doc__body'), !on);
      });
      if (docArt) {
        docArt.querySelectorAll('img').forEach(function (img) {
          img.classList.toggle('is-active', img.dataset.doc === item.dataset.doc);
        });
      }
    });
  }

  /* FAQ: acordeão (um aberto por vez) */
  var faq = document.querySelector('[data-faq]');
  if (faq) {
    faq.querySelectorAll('.faq-item').forEach(function (i) { setInert(i.querySelector('.faq-item__a'), !i.classList.contains('is-open')); });
    faq.addEventListener('click', function (e) {
      var q = e.target.closest('.faq-item__q');
      if (!q) return;
      var item = q.closest('.faq-item');
      var willOpen = !item.classList.contains('is-open');
      faq.querySelectorAll('.faq-item').forEach(function (i) {
        i.classList.remove('is-open');
        i.querySelector('.faq-item__q').setAttribute('aria-expanded', 'false');
        setInert(i.querySelector('.faq-item__a'), true);
      });
      if (willOpen) { item.classList.add('is-open'); q.setAttribute('aria-expanded', 'true'); setInert(item.querySelector('.faq-item__a'), false); }
    });
  }

  /* Quem faz: troca suave das fotos da equipe */
  // Só troca com a seção na tela e a aba visível (nada de trabalho fora da vista)
  document.querySelectorAll('[data-fade]').forEach(function (box) {
    var imgs = box.querySelectorAll('img');
    if (imgs.length < 2 || mqReduce.matches) return;
    var i = 0, timer = null, inView = !('IntersectionObserver' in window);
    var tick = function () {
      if (mqReduce.matches) return;
      imgs[i].classList.remove('is-active');
      i = (i + 1) % imgs.length;
      imgs[i].classList.add('is-active');
    };
    var sync = function () {
      var run = inView && !document.hidden;
      if (run && !timer) timer = setInterval(tick, 5000);
      else if (!run && timer) { clearInterval(timer); timer = null; }
    };
    if (!inView) new IntersectionObserver(function (en) { inView = en[0].isIntersecting; sync(); }).observe(box);
    document.addEventListener('visibilitychange', sync);
    sync();
  });

  /* Sliders (depoimentos = fade; blog = trilho horizontal) */
  function buildDots(wrap, count, go) {
    wrap.innerHTML = '';
    var dots = [];
    for (var k = 0; k < count; k++) {
      var b = document.createElement('button');
      b.type = 'button';
      b.setAttribute('aria-label', 'Ir para ' + (k + 1));
      b.addEventListener('click', go.bind(null, k));
      wrap.appendChild(b);
      dots.push(b);
    }
    return dots;
  }

  // O Figma mostra 5 posições; enquanto não houver conteúdo real suficiente,
  // os itens existentes são repetidos para preencher o carrossel.
  function fill(track, selector, min) {
    var items = track.querySelectorAll(selector);
    var n = items.length, k = 0;
    while (track.querySelectorAll(selector).length < min && n) {
      var c = items[k % n].cloneNode(true);
      c.classList.remove('is-active');
      c.setAttribute('aria-hidden', 'true');
      track.appendChild(c);
      k++;
    }
  }

  var t = document.querySelector('[data-slider="testimonials"]');
  if (t) {
    var tTrack = t.querySelector('[data-track]');
    fill(tTrack, '.testimonial', 5);
    var slides = tTrack.querySelectorAll('.testimonial');
    var cur = 0, dotsT;
    var goT = function (i) {
      cur = (i + slides.length) % slides.length;
      slides.forEach(function (s, j) { s.classList.toggle('is-active', j === cur); });
      dotsT.forEach(function (d, j) { d.setAttribute('aria-current', String(j === cur)); });
    };
    dotsT = buildDots(t.querySelector('[data-dots]'), slides.length, goT);
    t.querySelector('[data-prev]').addEventListener('click', function () { goT(cur - 1); });
    t.querySelector('[data-next]').addEventListener('click', function () { goT(cur + 1); });
    goT(0);
  }

  var b = document.querySelector('[data-slider="blog"]');
  if (b) {
    var bTrack = b.querySelector('[data-track]');
    fill(bTrack, '.post', 7);
    var posts = bTrack.querySelectorAll('.post');
    var pos = 0, dotsB = [];
    var visible = function () {
      var w = bTrack.parentElement.clientWidth, pw = posts[0].getBoundingClientRect().width;
      return Math.max(1, Math.round((w + 24) / (pw + 24)));
    };
    var pages = function () { return Math.max(1, posts.length - visible() + 1); };
    var goB = function (i) {
      var p = pages();
      pos = (i + p) % p;
      var step = posts[0].getBoundingClientRect().width + 24;
      bTrack.style.transform = 'translateX(' + (-pos * step) + 'px)';
      dotsB.forEach(function (d, j) { d.setAttribute('aria-current', String(j === pos)); });
    };
    var rebuild = function () { dotsB = buildDots(b.querySelector('[data-dots]'), pages(), goB); goB(Math.min(pos, pages() - 1)); };
    b.querySelector('[data-prev]').addEventListener('click', function () { goB(pos - 1); });
    b.querySelector('[data-next]').addEventListener('click', function () { goB(pos + 1); });
    rebuild();
    var rt;
    window.addEventListener('resize', function () { clearTimeout(rt); rt = setTimeout(rebuild, 150); });
  }
})();
