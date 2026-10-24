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

  /* Documentos: abas em acordeão + troca da ilustração */
  var docList = document.querySelector('[data-docs]');
  var docArt = document.querySelector('[data-docs-art]');
  if (docList) {
    docList.addEventListener('click', function (e) {
      var head = e.target.closest('.doc__head');
      if (!head) return;
      var item = head.closest('.doc');
      if (item.classList.contains('is-active')) return;
      docList.querySelectorAll('.doc').forEach(function (d) {
        var on = d === item;
        d.classList.toggle('is-active', on);
        d.querySelector('.doc__head').setAttribute('aria-expanded', String(on));
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
    faq.addEventListener('click', function (e) {
      var q = e.target.closest('.faq-item__q');
      if (!q) return;
      var item = q.closest('.faq-item');
      var willOpen = !item.classList.contains('is-open');
      faq.querySelectorAll('.faq-item').forEach(function (i) {
        i.classList.remove('is-open');
        i.querySelector('.faq-item__q').setAttribute('aria-expanded', 'false');
      });
      if (willOpen) { item.classList.add('is-open'); q.setAttribute('aria-expanded', 'true'); }
    });
  }

  /* Quem faz: troca suave das fotos da equipe */
  document.querySelectorAll('[data-fade]').forEach(function (box) {
    var imgs = box.querySelectorAll('img');
    if (imgs.length < 2 || matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    var i = 0;
    setInterval(function () {
      imgs[i].classList.remove('is-active');
      i = (i + 1) % imgs.length;
      imgs[i].classList.add('is-active');
    }, 5000);
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
