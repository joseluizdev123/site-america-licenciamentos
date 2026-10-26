# Animações da home: especificação final

**Projeto:** América Licenciamentos, home estática (`index.html`), que depois vira tema WordPress
**Referência pedida:** curadoria de animação do Awwwards (awwwards.com/websites/animation)
**Versão:** 1.0 · 24/10/2026
**Base:** plano "Institucional contido" (o vencedor, com 24 pontos), mais os enxertos recomendados pelos jurados. Os cortes estão listados na seção 16.

> **Para quem é este documento:** a equipe do cliente (para aprovar) e o desenvolvedor que vai implementar. Ele não precisa de perguntas extras: está tudo definido, inclusive seletores, valores, tempos, arquivos e critérios de aceite.
> **Regra de ouro:** quando todas as animações terminam, a página fica **idêntica ao Figma**, pixel a pixel, igual à validação de hoje.

---

## 1. Conceito

**"Carimbo de cartório."** O movimento confirma que algo está assentado e para. Cada animação acontece **uma única vez**. Ela é baseada em tempo, nunca amarrada à rolagem, e termina exatamente no estado do Figma.

Usamos só seis tipos de movimento, cada um com um propósito:

| # | Movimento | Onde | O que comunica |
|---|---|---|---|
| a | Fade-up curto (8 a 24 px) | Blocos, cards, listas | Ordem de leitura |
| b | Revelação de títulos linha a linha, com máscara | h1, h2 selecionados, citação do sócio | Autoridade ("sobe para o lugar") |
| c | Assentamento de foto (scale 1,06 → 1) dentro da moldura fixa | Fotos dos cards, Documentos, equipe, contadores | Peso, sem deslocamento |
| d | Contagem | Apenas "+20 anos" | Evidência |
| e | Desenho técnico das ilustrações isométricas: traço primeiro, preenchimento depois | CTA, Método, FAQ | Precisão (é a "planta" sendo desenhada) |
| f | Linhas finas que se abrem (wipe) | Padrões de pontos, réguas das estatísticas, setas dos contadores | Método, registro |

**O que fica parado, de propósito:** o header (primeiro sinal de confiança, presente em todos os prints), a foto do hero (é o elemento de LCP e o fundo do botão de vidro), o card do footer (destino de todos os CTAs) e qualquer card que não seja link (não damos *hover* a algo que não se clica).

**Fora do conceito:** pré-loader, smooth scroll, parallax, pinning, marquee, efeitos de cursor, blur, *bounce*/*overshoot* e mudanças no header (lista completa na seção 16).

---

## 2. Restrições inegociáveis e como esta spec cumpre cada uma

| Restrição | Mecanismo |
|---|---|
| 1. Estado final = Figma | Usamos a Web Animations API sempre com `fill: 'backwards'`, nunca `forwards` ou `both`. Quando a animação termina, o efeito é descartado e quem manda volta a ser a folha de estilo validada. Animamos só `opacity`, `translate`, `scale` e `clip-path`, e `stroke-dashoffset`/`fill-opacity` em cópias SVG temporárias. Toda alteração de DOM é revertida (seção 7.8). |
| 2. Sem JS / falha segura | Nada fica escondido em CSS puro. Os estados iniciais só existem sob `html.js-anim`, uma classe posta por script inline no `<head>` antes do primeiro paint, e só em elementos marcados pelo próprio JS. O hero só é pré-escondido com `html.hero-anim` (desktop não-lite), que o gate tira aos 1400 ms da navegação se o motor não subir; há watchdog de 3 s, failsafe CSS de 1,5 s e `try/catch` (seção 6). |
| 3. `prefers-reduced-motion: reduce` | O gate não liga nada: o conteúdo aparece imediatamente, sem fades. Também cobre a troca da preferência no meio da sessão (seção 10). |
| 4. Performance | Nenhuma biblioteca. IntersectionObserver, nenhum listener de scroll, um único listener de `resize` passivo. Sem `will-change` e CLS 0. JS próprio de ≈ 10–12 KB não minificado (≈ 4 KB gzip). |
| 5. 1440 → 375 px; toque | Distâncias × 0,75 em ≤ 720 px. Só `translateY` nas revelações, então nunca há scroll horizontal. Hover só em `(hover:hover) and (pointer:fine)`, e nada depende de hover (seção 11). |
| 6. Interações existentes intactas | O `main.js` não é alterado. Nunca animamos `transform` (só as propriedades individuais `translate`/`scale`, que se compõem com os transforms existentes) e nunca tocamos nas propriedades que pertencem ao `main.js`/CSS atual (lista na seção 7.10). |

---

## 3. Biblioteca: nenhuma

| Item | Decisão |
|---|---|
| Biblioteca | **Nenhuma.** APIs nativas: Web Animations API (`element.animate`), IntersectionObserver, propriedades individuais de transform (`translate`, `scale`), CSS `@keyframes` |
| Versão / vendor | Não se aplica. A pasta `assets/js/vendor/` **não é criada**. Não há dependência de CDN em tempo de execução. |
| Navegadores com animação | Chrome/Edge 104+, Safari 14.1+, Firefox 78+. O gate detecta os recursos; qualquer outro navegador recebe a página estática, completa e idêntica. |
| Sintaxe JS | ES2017. **Não usar** `?.`, `??` nem `replaceChildren()`, que não existem em todo o piso acima. |
| GSAP 3.13 (ScrollTrigger, SplitText) | Avaliado e **rejeitado**. Ele escreve estilos inline que exigem `clearProps` em todo lugar: um `translate(0,0)` ou `opacity:1` esquecido mantém camadas compostas e altera o antialiasing do texto no Windows (DPR 1,25), que é justamente o ruído do pixel diff. O SplitText reescreve o DOM dos títulos, que têm folgas de 0,2–1,1 px. Seriam também ~50–70 KB a manter sincronizados no tema WP. Se no futuro alguém quiser rolagem com *scrub*, a versão aprovada é `gsap@3.13.0`, vendorizada de `https://cdn.jsdelivr.net/npm/gsap@3.13.0/dist/` em `assets/js/vendor/gsap-3.13.0/`, o que exigiria uma nova versão desta spec. |

---

## 4. Arquivos e pontos de inserção

| Arquivo | Ação |
|---|---|
| `index.html` | 4 inserções (abaixo). Nenhuma outra mudança de markup. |
| `assets/css/style.css` | **Não muda** (continua byte-idêntico ao validado). |
| `assets/css/motion.css` | **Novo.** Conteúdo completo na seção 12. |
| `assets/js/main.js` | **Não muda.** |
| `assets/js/anim.js` | **Novo.** Especificado nas seções 7 a 9. |
| `theme/**` | **Não tocar.** O porte para o tema está na seção 15. |

### 4.1 `<head>`: gate inline, preload e CSS

O gate entra **logo após** `<meta name="viewport">` e **antes** de qualquer `<link>`. Um script inline colocado depois de um stylesheet esperaria o download dele; antes, ele roda imediatamente e a classe já está no `<html>` no primeiro paint.

```html
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script>
  /* Gate de animação: precisa rodar antes do primeiro paint. Não mover. Ver ANIMACOES.md §6 */
  (function (d, w) {
    var h = d.documentElement;
    try {
      if (/[?&]static\b/.test(w.location.search)) return;
      if (!w.matchMedia || !w.matchMedia('(prefers-reduced-motion: no-preference)').matches) return;
      h.classList.add('motion-ok');
      if (!('IntersectionObserver' in w) || !h.animate ||
          !(w.CSS && CSS.supports && CSS.supports('translate', '0 1px'))) return;
      h.classList.add('js-anim');
      w.setTimeout(function () {
        if (!h.classList.contains('anim-ready')) h.classList.remove('js-anim');
      }, 3000);
    } catch (e) { h.classList.remove('js-anim'); }
  })(document, window);
  </script>
  <title>…</title>
  <meta name="description" content="…">
  <!-- preload do hero: injetado pelo script de modo do hero (1º <script> do <head>):
       hero-sao-paulo.jpg em "alternar"/"cidade", hero-socio.webp em "socio" — nunca os dois -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?…" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/motion.css">
</head>
```

As duas classes têm papéis diferentes:

- **`html.motion-ok`** é **persistente** e nunca é removida. Ela liga as microinterações.
- **`html.js-anim`** é **temporária**. Ela liga os estados iniciais das revelações e é removida na limpeza final.

> Isso corrige um bug do plano original: as microinterações ficavam sob `js-anim` e paravam de funcionar depois da limpeza.

### 4.2 Fim do `<body>`

```html
<script src="assets/js/main.js" defer></script>
<script src="assets/js/anim.js" defer></script>   <!-- SEMPRE depois do main.js -->
```

Como os dois são `defer`, a ordem é preservada. Quando o `anim.js` roda, o `main.js` já clonou os depoimentos (5) e os posts (7) e já criou os *dots*.

---

## 5. Tokens globais

### 5.1 Curvas (CSS em `:root` e espelhadas no JS)

| Token | Valor | Uso |
|---|---|---|
| `--a-ease` (*settle*) | `cubic-bezier(.22,1,.36,1)` | Fade-ups, linhas, escala de fotos, microinterações |
| `--a-ease-draw` (*draw*) | `cubic-bezier(.65,0,.35,1)` | Traço das ilustrações, wipes de linhas, estatísticas, setas |
| `--a-ease-fade` (*fade*) | `cubic-bezier(.33,1,.68,1)` | Fades só de opacidade; o contador usa o equivalente easeOutCubic |
| `--a-ease-close` (*close*) | `cubic-bezier(.4,0,.2,1)` | Fechamento de acordeão |

Proibido: *back*, *elastic*, *bounce*, qualquer *overshoot*.

### 5.2 Durações (ms)

| Categoria | Duração |
|---|---|
| Micro (hover, press, menu) | 120–450 |
| Fade-up pequeno (eyebrow, logo, item) | 500–600 |
| Fade-up de bloco (parágrafo, caixa, botão) | 700 |
| Fade-up de card | 800 |
| Linha mascarada | 950 (citação: 1000) |
| Wipe (padrão de pontos, estatística, seta) | 600–1000 |
| Desenho de ilustração | 1300 + escalonamento dos traços (Método: 900, em cadeia) |
| Escala de foto | 1400 (equipe: 1600) |
| Contador | 1400 |
| Abertura de capítulo (cards escuros) | 900 |

### 5.3 Distâncias de `translate` (eixo Y)

| Uso | ≥ 721 px | ≤ 720 px (× 0,75) |
|---|---|---|
| Cards | 24 px | 18 px |
| Títulos em bloco, trilho de depoimentos, posts | 20 px | 15 px |
| Parágrafos, botões, caixas | 16 px | 12 px |
| Eyebrows, itens pequenos | 12 px | 9 px |
| Logos | 8 px | 6 px |

### 5.4 Escalonamento (*stagger*)

| Grupo | Passo |
|---|---|
| Linhas de título | 90 ms |
| Cards (features, steps) | 110 ms |
| Itens (impactos, parágrafos) | 90–100 ms |
| Itens de lista longa (docs × 9, FAQ × 9) | 50 ms |
| Logos | diagonal `(linha + coluna) × 40 ms` (Trust) / `× 35 ms` (Cases) |
| Rodapé | 70 ms |

- **Teto por grupo: 450 ms no total.** O passo efetivo é `min(passo, 450 / (n − 1))`.
- **Regra de lote:** atrasos relativos só valem entre alvos que entram **no mesmo callback** do IntersectionObserver. Um alvo que entra sozinho começa imediatamente. No celular, numa coluna, nada espera à toa.
- **Logos em diagonal:** no lote, a posição é `(linha + coluna) − mínimo do lote`. A coluna é calculada com o número de colunas vivo: 5 no desktop, 2 em ≤ 720.

### 5.5 Gatilhos

| Gatilho | Configuração |
|---|---|
| **IN** (observador principal) | `IntersectionObserver`, `rootMargin: '0px 0px -12% 0px'`, `threshold: 0`. Dispara quando o topo do alvo cruza 88% da altura da tela. Depois o alvo é `unobserve`. **Todo alvo marcado é observado** (≈140 alvos, custo desprezível): um salto instantâneo de rolagem (arrastar a barra, `scrollTo`, autoscroll, fragmento de texto) nunca deixa item sem gatilho. Listas escalonadas (LOTE/diagonal) formam **trechos** de meia tela: quando qualquer item de um trecho dispara, os colegas pendentes entram no mesmo lote (o escalonamento vem do lote). Alvos `wipe-y` (as estatísticas) começam com `clip-path` de altura 0, e o IO usa a caixa recortada; por isso o observado é o **pai** (`ul.stats`), que dispara o grupo. |
| **Foco** | `focusin` (captura) no documento: se o alvo do foco está dentro de um registro ainda pendente, ele **assenta na hora** (sem animação). Rede de segurança CSS: `html.js-anim [data-anim]:focus-within { opacity:1 !important; clip-path:none !important }`. Nenhum controle focado fica invisível (WCAG 2.4.7). |
| **IN-F** (observador do footer) | Igual, com `rootMargin: '0px'`. |
| **Pré-carga** | `rootMargin: '800px 0px'`, só para buscar os SVGs das ilustrações antes da hora. |
| **Dependente** | Não é observado: começa X ms após o início de outro alvo (indicado nas tabelas). |
| **Início mínimo** | Nenhuma revelação abaixo da dobra começa antes de **T0 + 500 ms**, para não competir com a abertura do hero. |

---

## 6. Gating e segurança: sem JS, falhas e casos de borda

Camadas, na ordem em que agem:

1. **Gate inline** (§4.1). Sem `?static`, com `no-preference` → `motion-ok`. Com IntersectionObserver, WAAPI e `translate` suportados → também `js-anim` e um watchdog de 3 s, que remove `js-anim` se `anim-ready` não aparecer. Só em aparelho **não-lite** (`min-width: 961px`, `hardwareConcurrency > 4`, sem `saveData`, os mesmos testes do lite do `animations.js`) → também `hero-anim`, com um timer **medido do início da navegação** (`1400 − performance.now()`) que tira `hero-anim` se `anim-ready` ainda não existir. No celular/lite o hero nunca é escondido (aparece no primeiro paint, sem entrada).
2. **Estados iniciais em CSS** (§12), todos dentro de `@media (prefers-reduced-motion: no-preference)` e sob `html.js-anim`:
   - **Hero** (acima da dobra, escondido desde o primeiro paint, só sob `html.js-anim.hero-anim`). Lista fixa: `.hero__eyebrow`, `.hero .t-display`, `.hero__desc`, `.hero__actions .btn`, com `opacity: 0` enquanto não têm `.is-in`.
   - **Todo o resto** só é escondido se o JS tiver posto `data-anim` no elemento. Sem JS, nenhum elemento tem `data-anim` e nada se esconde.
3. **Failsafe do hero:** o principal é o timer de 1400 ms do gate (item 1). Rede extra em CSS: se `anim-ready` não existir em 1,5 s (contados da resolução de estilo), `@keyframes a-failsafe` força `opacity: 1` nos 4 alvos do hero.
4. **Boot do `anim.js`** (§7.3), numa única tarefa síncrona, sem frame renderizado no meio:
   - marca **somente** os alvos que estão inteiramente **abaixo** da dobra e visíveis (`getClientRects().length > 0`);
   - o que já está na tela ou acima dela no boot (reload no meio da página, `#âncora`, bfcache, telas altas) **fica estático e nunca é escondido**;
   - tudo em `try/catch`; em caso de erro, remove `js-anim`;
   - `anim-ready` é adicionado **por último**.
5. **Boot tardio:**
   - se o `anim.js` subir com `performance.now() > 1000`, o hero não espera a fonte (T0 = agora);
   - se `> 1400`, ou se `hero-anim` não existe (lite, ou o timer do gate já venceu), o hero é finalizado estático (`.is-in` sem animação). O corte do motor e o timer do gate usam o mesmo relógio (`performance.now()`), então nunca há flash;
   - se `js-anim` já foi removido pelo watchdog, o `anim.js` não religa as revelações (só as microinterações).
6. **Recuperação (catch-up):** a cada callback dos observadores, lemos (só leitura) o retângulo dos alvos pendentes. Os que têm `bottom < 0`, ou seja, foram pulados por âncora ou rolagem rápida, são **assentados na hora, sem animação**. Os que estão na faixa IN (`bottom > 0` e `top < 0,88 × altura`) **entram no lote e animam**, mesmo que o observador deles não tenha visto a interseção. Conteúdo acima do leitor nunca fica escondido.
7. **Sentinela de fim de página:** quando `.footer__legal` intersecta (IN-F), todos os alvos pendentes da página são resolvidos. Os que estão na tela animam; os demais são assentados na hora. Não se insere elemento novo no DOM.
8. **Impressão:** `beforeprint` executa `finishAll()`, e `@media print` força a visibilidade de tudo (§12).
9. **Erros depois do boot** (restrição 2: nenhum erro deixa conteúdo escondido):
   - `anim()` nunca lança: se `el.animate` falhar, o callback roda na hora (estado final);
   - `splitLines` em `try/catch`: qualquer falha na medição (fontes, `Range`, layout) desfaz a divisão e cai no fallback em bloco;
   - por registro: `startRecord`, `fire`, `onIn`, o `go` do desenho, `drawSvg` (o `<img>` original volta), o contador e o `go` do hero têm `try/catch`. Um erro num registro só **assenta aquele registro** (`release`: desfaz a divisão, tira `data-anim`/`.is-in`); os demais seguem animando;
   - último recurso (`hardStop`): erro num callback de animação, ou `error`/`unhandledrejection` cujo arquivo/pilha é `animations.js`, roda `finishAll()`, desfaz tudo e remove `js-anim`/`anim-ready`;
   - os erros vão para `console.error('[animations]', …)` e o `?anim-audit` acusa "sem erros em tempo de execução".
10. **Elementos com `display:none` no breakpoint** (`.cta-box__art` ≤ 960, `.sectors` ≤ 720, `.about__foot .dot-pattern` ≤ 960) nunca são marcados e nenhuma animação depende deles.

---

## 7. Motor de animação (`assets/js/anim.js`)

### 7.1 Tipos de efeito (valor de `data-anim`, posto pelo JS)

| `data-anim` | Estado inicial (CSS, só sob `js-anim`) | Animação (WAAPI, `fill:'backwards'`) |
|---|---|---|
| `up` | `opacity: 0` | `{opacity:0, translate:'0 Dpx'} → {opacity:1, translate:'0 0'}` |
| `fade` | `opacity: 0` | `{opacity:0} → {opacity:1}` |
| `lines` | `opacity: 0` (no título) | Divide em linhas (§7.5); cada `.ln__in`: `translate '0 105%' → '0 0'`. Fallback: `up` 20 px / 800 ms |
| `wipe-x` | `clip-path: inset(0 100% 0 0)` | `→ inset(0 0% 0 0)` (esquerda → direita) |
| `wipe-y` | `clip-path: inset(0 0 100% 0)` | `→ inset(0 0 0% 0)` (cima → baixo) |
| `draw` | `opacity: 0` (no `<img>`) | Troca por SVG inline, desenha e devolve o `<img>` (§7.6). Fallback: `wipe-x`/`wipe-y` |
| `chapter` | `clip-path: inset(0 1.5% 0 1.5% round 24px)` | `→ inset(0 0% 0 0% round 24px)` |
| *(sem marca)* `scale` | Nenhum (o pai já está escondido) | `{scale: S} → {scale: 1}` |
| *(sem marca)* `count` | Nenhum | Contagem por `requestAnimationFrame` (§7.7) |

### 7.2 Ciclo de vida de um alvo

```
registrado → marcado (data-anim) → pendente (Set pending) → disparado (.is-in + animate) → assentado
```

**Assentar** significa remover `data-anim` e `.is-in` juntos, de modo que nenhuma regra case mais, e tirar o alvo de `pending`. Os alvos do hero não têm `data-anim`: mantêm `.is-in` até a limpeza final, que remove `.is-in` e `js-anim` na mesma tarefa.

### 7.3 Ordem de boot

1. Sem `html.motion-ok` → `return` (página 100% estática).
2. Registrar as microinterações (§9) e o listener `matchMedia('(prefers-reduced-motion: reduce)')` (§10).
3. Sem `html.js-anim` → `return`.
4. `try {`
   1. `now = performance.now()`.
      - `lite = matchMedia('(max-width: 960px)').matches || (navigator.hardwareConcurrency || 8) <= 4 || !!(navigator.connection && navigator.connection.saveData)`;
      - `small = matchMedia('(max-width: 720px)').matches`.
   2. Montar a lista de alvos a partir das tabelas da seção 8. Recomenda-se transcrevê-las para um array declarativo `SPEC` no topo do arquivo.
   3. **Fase de leitura:** `getBoundingClientRect()` e `getClientRects().length` de todos os candidatos.
   4. **Fase de escrita:** pôr `data-anim` só nos que estão abaixo da dobra (`rect.top >= innerHeight`) e visíveis.
   5. Hero:
      - se `now > 1400` ou `bottom` do hero `<= 0` (lido **na fase de leitura** e passado à timeline; nada de layout depois das escritas), finalizar estático;
      - caso contrário, agendar a timeline em T0 (§8.2).
   6. Criar os observadores IN, IN-F e de pré-carga e observar os alvos marcados.
   7. Adicionar `resize` (passivo) e `beforeprint`.
   8. `?anim-audit`: tirar o snapshot (§14).
   9. `document.documentElement.classList.add('anim-ready')`, por último.

   `} catch (e) { html.classList.remove('js-anim', 'anim-ready'); }`

### 7.4 Núcleo: `play()` e `settle()`

```js
var EASE = 'cubic-bezier(.22,1,.36,1)', EASE_DRAW = 'cubic-bezier(.65,0,.35,1)', EASE_FADE = 'cubic-bezier(.33,1,.68,1)';
var pending = new Set(), running = new Set();

function play(el, frames, o) {
  el.classList.add('is-in');                 // tira o pré-estado do CSS na MESMA tarefa
  var a = el.animate(frames, {
    duration: o.dur, delay: o.delay || 0, easing: o.ease || EASE,
    fill: 'backwards'                         // NUNCA 'forwards' ou 'both'
  });
  a.id = 'a-' + (o.kind || 'reveal');         // prefixo usado pela auditoria
  running.add(a);
  var done = function () { running.delete(a); (o.after || settle)(el); };
  a.finished.then(done, done);
  return a;
}

function settle(el) {
  if (el.hasAttribute('data-anim')) { el.removeAttribute('data-anim'); el.classList.remove('is-in'); }
  pending.delete(el);
  maybeCleanup();
}

var UP     = function (d) { return [{ opacity: 0, translate: '0 ' + d + 'px' }, { opacity: 1, translate: '0 0' }]; };
var FADE   = [{ opacity: 0 }, { opacity: 1 }];
var WIPE_X = [{ clipPath: 'inset(0 100% 0 0)' }, { clipPath: 'inset(0 0% 0 0)' }];
var WIPE_Y = [{ clipPath: 'inset(0 0 100% 0)' }, { clipPath: 'inset(0 0 0% 0)' }];
var CHAPTER = [{ clipPath: 'inset(0 1.5% 0 1.5% round 24px)' }, { clipPath: 'inset(0 0% 0 0% round 24px)' }];
var SCALE  = function (s) { return [{ scale: s }, { scale: 1 }]; };
```

Regras:

- **Nunca** escrever `el.style.*` para animar.
- Quando uma foto escala dentro de uma moldura arredondada, a moldura recebe a classe `.a-clip` (`isolation: isolate`, que evita o Safari perder o raio) **só enquanto anima**. Use contagem de referência, porque a mesma moldura pode receber `.a-clip` da revelação e de uma microinteração.
- Fotos com `loading="lazy"`: antes de animar, espere `img.complete` ou o evento `load`, com teto de 300 ms (**nunca `img.decode()`**: decodifica no tamanho intrínseco com filtro *nearest neighbour*, e esse bitmap era reaproveitado no raster final, que deixava de bater com o estático — 80 px de diferença nos cards do Imóvel; no DPR 1 nem aquece o cache do raster). Para logos, a mesma espera, com teto de 400 ms. Enquanto espera, o alvo continua no estado inicial.

### 7.5 Revelação por linhas (divisor medido)

**Lista permitida**, onde todos têm ≥ 10 px de folga ou são uma única linha:

`.hero .t-display`, `#decision-title`, `#property-title`, `#docs-title`, `#method-title`, `#about-title`, `.about__quote > blockquote`, `#cases-title`, `#blog-title`, `#faq-title`.

**Excluídos** (sempre bloco `up`): `#testimonials-title` (folga 0,2 px), `#acc-title` (4,1 px), `.trust__title`, todos os parágrafos, `.decision__desc` (1,1 px), textos de CTA e o parágrafo do footer.

Algoritmo:

1. **Pré-condições:**
   - o elemento tem **um único** filho e ele é um Text;
   - `document.fonts.check(peso + ' ' + tamanho + ' "Stack Sans Headline"')` é `true` (com o peso e o tamanho calculados);
   - se alguma falhar, usar o fallback `up` 20 px / 800 ms.
2. **Medir (só leitura):** para o **1º caractere de cada palavra** (e o que vem depois de hífen ou barra, onde a linha também pode quebrar), criar um `Range(i, i+1)` e ler `getClientRects()[0].top` (~5× menos medições que caractere a caractere). Abre-se uma nova linha quando `top > topo da linha atual + lineHeight / 2`. Assim as quebras saem do layout real, inclusive a do hífen de "habite-se". O espaço da quebra fica no fim da linha anterior.
3. **Guardar:** o nó Text original, o atributo `style` original (string exata, ou `null`) e `rect` (largura/altura).
4. **Travar:** `el.style.width = rect.width + 'px'`.
5. **Construir:** `el.textContent = ''` e depois, para cada linha, `<span class="ln"><span class="ln__in">…texto contínuo da linha…</span></span>`. **Não** adicionar `aria-*`: o texto continua íntegro dentro dos spans.
6. **Autoverificação:**
   - a nova largura e altura devem diferir **≤ 0,5 px** do original;
   - cada `.ln__in` deve ter altura `≤ 1,5 × lineHeight` (nenhuma linha quebrou);
   - se falhar, **reverter imediatamente** (passo 8) e usar o fallback.
7. **Animar:**
   - na mesma tarefa, adicionar `.is-in` ao título e animar cada `.ln__in` com `[{translate:'0 105%'},{translate:'0 0'}]`;
   - duração 950 ms (citação 1000), *settle*;
   - `delay = base + i × min(90, 450/(n−1))`, `fill:'backwards'`;
   - a máscara é `.ln { clip-path: inset(-.35em -.5em 0 -.5em) }`, que funciona em todos os navegadores, não altera o layout e deixa espaço para acentos.
8. **Reverter**, no `finished` da última linha, no resize, no print ou no reduce:
   - `el.textContent = ''; el.appendChild(textoOriginal)` (o **mesmo** nó);
   - restaurar o `style` original (`setAttribute`, ou `removeAttribute` se era `null`). Exemplo: `#property-title` tem `style="text-align:center"`, que deve voltar idêntico;
   - depois, `settle(el)`.
9. **Resize:** se `innerWidth` mudar enquanto houver divisão ativa, chamar `finish()` nas animações dessas linhas, o que dispara o passo 8.

Custo: um layout forçado por título, no momento do disparo, com o título invisível. Nunca dentro de um handler de rolagem.

### 7.6 Desenho das ilustrações isométricas

Alvos: `img.cta-box__art` × 3 (`ilustra-cta.svg` × 2, `ilustra-cta-docs.svg`), `img.step__art` × 4 (`ilustra-etapa-1..4.svg`) e `img.faq__art` (`ilustra-faq.svg`).

**Desktop (não-lite):**

1. **Pré-carga:** o observador de pré-carga chama `getSvg(img.currentSrc || img.src)`, que é cacheado por URL. O arquivo usado duas vezes é buscado uma vez só. Nunca usar caminhos fixos no código, para funcionar no WordPress.
2. **No disparo:** se o texto do SVG não estiver pronto em 300 ms, usar o fallback (wipe).
3. **Montar:**
   - `DOMParser('image/svg+xml')`; aceitar só se a raiz for `<svg>` e não houver `parsererror`;
   - **sanitizar**: remover `script`, `foreignObject`, `style` e todo atributo `on*` (inclusive na raiz). `href`/`xlink:href` só são mantidos se começarem por `#`;
   - **namespacing por instância**: todo `id` ganha o sufixo `-a{n}`, e toda ocorrência de `url(#…)` em atributos (`fill`, `clip-path`, `mask`, `filter`, `stroke`) e todo `href="#…"` são reescritos. Isso evita que as duas cópias de `ilustra-cta.svg` (`pattern0_7132_2210`…) resolvam os padrões uma da outra; a `etapa-2` mantém seu próprio `clipPath`;
   - `document.importNode`; copiar `img.className` para o atributo `class` do SVG (mesma posição e tamanho via CSS); `aria-hidden="true"` e `focusable="false"`.
4. **Trocar:** `img.replaceWith(svg)`. Guardar a referência ao `<img>` original.
5. **Ordem dos traços:**
   - `.cta-box__art`: **ordem do documento**, de trás para frente. As faces brancas vêm primeiro e os padrões pontilhados depois: as linhas de construção aparecem e depois se fecham. A arte é cortada no topo, então começar pelo topo não ajuda;
   - `.step__art` e `.faq__art`: **ordenar pelo topo do `getBBox()`**. Só os ~134 px superiores da etapa aparecem no card, e o "?" é cortado embaixo, então a parte visível desenha primeiro.
6. **Animar cada `path`**, depois de `setAttribute('pathLength','1')` e com `f = parseFloat(path.getAttribute('fill-opacity') || '1')`, que é 1 nas faces brancas e 0,1 nos padrões:

   ```js
   path.animate([
     { strokeDasharray: '1 2', strokeDashoffset: 1.02, fillOpacity: 0 },
     { strokeDasharray: '1 2', fillOpacity: 0, offset: .7 },
     { strokeDasharray: '1 2', strokeDashoffset: 0, fillOpacity: f }
   ], { duration: DUR, delay: base + i * passo, easing: EASE_DRAW, fill: 'backwards' });
   ```

   `passo = min(passoMax, orçamento / (n − 1))`. Os valores por seção estão na seção 8. Todas as animações entram em `running`.
7. **Devolver:** quando todas terminarem:
   - `await img.decode().catch(noop)`;
   - `img.removeAttribute('data-anim'); img.classList.remove('is-in'); svg.replaceWith(img)`;
   - `pending.delete(img)`.

   O **`<img>` original volta**, então o raster final é o validado, mesmo que traços inline de 0,33 px rasterizem diferente.

**Fallback e modo lite** (≤ 960 px, `hardwareConcurrency ≤ 4`, `saveData`, `fetch` falho ou `file://`): o `<img>` fica intocado e recebe um wipe de `clip-path`. Na mesma tarefa, `data-anim` muda para `wipe-x`/`wipe-y` e `play()` é chamado.

- `.cta-box__art`: `wipe-x`, 1000 ms (nem existe em ≤ 960).
- `.step__art` e `.faq__art`: `wipe-y`, 1100 ms, de cima para baixo.

### 7.7 Contador ("+20 anos")

- **Alvo:** apenas `.stats > .stat:first-child > strong`, e só se o texto casar com `^(\D*)(\d+)(.*)$` e o elemento tiver um único nó Text. "São Paulo" e "4 etapas" **não contam**.
- **No início do wipe da estatística**, na mesma tarefa:
  - trocar o nó Text por um nó temporário `"+0 anos"`;
  - `strong.setAttribute('aria-hidden','true')`;
  - inserir depois do `strong` um `<span class="sr-only">+20 anos</span>`, que é `position:absolute` e não ocupa espaço no flex.
- **A partir de +150 ms:** loop de `requestAnimationFrame` baseado em `performance.now()`:
  - `p = min(1, (agora − t0) / 1400)`, `e = 1 − (1 − p)³`;
  - texto = prefixo + `Math.round(e × 20)` + sufixo;
  - com a aba em segundo plano, termina na hora quando ela volta.
- **No fim** (ou em `finishAll`):
  - devolver o **mesmo** nó Text original;
  - remover `aria-hidden` e o `span.sr-only`.
- **Não** usar `tabular-nums`, que mudaria os glifos finais. O `strong` fica numa coluna de grade fixa, então não há CLS.

### 7.8 Limpeza final (garantia de estado final)

Quando `pending.size === 0`, não houver animações em `running`, divisões de linha, ilustrações inline nem contadores ativos, **numa única tarefa**:

- `html.classList.remove('js-anim', 'anim-ready')` e remoção de `.is-in` dos 4 alvos do hero;
- `disconnect()` nos três observadores; remoção dos listeners de `resize` e `beforeprint`;
- **ficam:** `html.motion-ok` e os listeners das microinterações, que não alteram nada em repouso.

Escritas temporárias permitidas, **todas revertidas**:

| Escrita | Onde | Reversão |
|---|---|---|
| Largura travada | Títulos divididos | Atributo `style` original restaurado (string exata) |
| Spans `.ln` / `.ln__in` | Títulos divididos | O nó Text original é reinserido |
| Texto do contador, `aria-hidden`, `span.sr-only` | `.stat:first-child` | O nó Text original é reinserido e os extras removidos |
| SVG inline | Ilustrações | O `<img>` original é reinserido |
| `data-anim`, `.is-in` | Alvos | `settle()` / limpeza final |
| `.a-clip`, `.a-enter` | Molduras / microinterações | Removidos ao terminar |

Se o usuário nunca chega ao fim da página, `js-anim` permanece e os alvos ainda não vistos continuam esperando. Isso é o comportamento desejado. Os já revelados estão assentados, ou seja, idênticos ao Figma.

### 7.9 Modo lite

| Recurso | Normal | Lite (≤ 960 px, CPU ≤ 4 núcleos ou saveData) |
|---|---|---|
| Ilustrações | Desenho de traço inline | Wipe de `clip-path` no `<img>` |
| Abertura de capítulo (cards escuros) | Sim | Não |
| Listas LOTE/diagonal | Duração fixa | O escalonamento fica só no atraso; as durações crescem para **todos terminarem no mesmo quadro** (as camadas são desmontadas uma vez, não uma por item) |
| Todo o resto | Igual | Igual |

### 7.10 Propriedades que NUNCA animamos (pertencem ao código existente)

- `.btn`: `transform` (tem `transition: transform .2s`). Usamos `translate`/`scale` individuais.
- `.link-caret .icon` e `.faq-item__q .icon`: `transform`.
- `.blog__track`: `transform` inline do `main.js` e sua transição `.45s`. **Nunca** é animado nem retemporizado.
- `.post`: nunca `scale`, porque o `main.js` mede a largura com `getBoundingClientRect()`. `.post__img img`: `transform` do hover.
- Imagens de `.docs__art img` e `.about__slides img`: `opacity`, que pertence às trocas.
- `.testimonial`: `opacity`/`visibility`, que pertencem ao slider.
- `.doc`: `padding-left`. `.doc__body` e `.faq-item__a`: só a temporização de `grid-template-rows` muda (§9).
- `li.accountants__arrow`: `transform: rotate(-90deg)` entre 721 e 1180 px. Animamos o `svg` interno.
- `li.logo-grid__cell`: nunca recebe `opacity`/`translate`, para não prender o `z-index` do marcador `::after`. Animamos só o `img`.
- Ancestrais do `.btn--glass` (`.hero__bg`, `.hero__content`, `.hero__text`, `.hero__actions`): nunca recebem `opacity`, `filter`, `clip-path` ou `will-change`, senão viram *backdrop root* e o vidro perde o blur.
- `header`, `body`, `main`: nunca recebem `transform`/`opacity`/`filter`, porque isso quebra o `position: sticky`.

---

## 8. Seção por seção

Legenda:

- **IN** = observador principal; **IN-F** = observador do footer; **LOTE** = itens que escalonam dentro do mesmo callback.
- **Dep.** = dependente (não observado; começa X ms após outro alvo).
- Atrasos "+X" relativos ao primeiro alvo da seção só valem se entrarem no mesmo callback (§5.4).
- Distâncias em px para ≥ 721 (× 0,75 em ≤ 720).
- Curvas: **S** = *settle*, **D** = *draw*, **F** = *fade*.

### 8.1 Header (`header.site-header`, sticky)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `header.site-header` inteiro (logo, `.nav a`, `.phone-link`, `.btn--outline`) | **Nenhum** | — | — | — | — | Estático desde o primeiro frame: sem intro, sem esconder na rolagem, sem sombra. As transições de cor atuais ficam. |
| `.site-header.is-open .nav` (≤ 1180) | `a-nav-in`: opacity 0→1, translate 0 −6px → 0 | Clique no `.menu-toggle` (`main.js` põe `.is-open`) | 220 | S | — | CSS puro sob `motion-ok`. O fechamento continua instantâneo (`display:none`). |
| `.site-header.is-open .nav a` × 7 | `a-nav-link`: opacity 0→1, translate 0 −4px → 0 | Junto com o painel | 260 | S | 25 (0…150 ms via `nth-child`) | `animation-fill-mode: backwards`. |

### 8.2 Hero (`section.hero#diagnostico`): timeline de carga

**T0** = `Promise.race([document.fonts.load('300 64px "Stack Sans Headline"'), espera(300 ms)])`, imediato se o boot for depois de 1000 ms. Com boot depois de 1400 ms → estático.

| Alvo | Efeito | Início | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.hero__bg` (foto + gradiente) | **Nenhum** | — | — | — | — | Elemento de LCP e fundo do vidro. Nunca escala, recorta ou esmaece. |
| `.hero__eyebrow` (pin + eyebrow, em bloco) | `up` 12 | T0 | 600 | S | — | Pré-estado via CSS fixo. |
| `.hero .t-display` (h1) | `lines` | T0 + 80 | 950 | S | 90 | 2 linhas em 1440, 4 em 375. Sem fonte em T0 → `up` 20 / 800. |
| `.hero__desc` | `up` 16 (bloco, nunca dividido) | T0 + 320 | 700 | S | — | Preserva as 3 linhas 734/734/517. |
| `.hero__actions .btn--primary` | `up` 16 (na própria `.btn`) | T0 + 440 | 700 | S | — | — |
| `.hero__actions .btn--glass` | `up` 16 (na própria `.btn`) | T0 + 520 | 700 | S | — | Opacidade no próprio botão é segura; nos ancestrais, não. |

Tudo assenta em ≈ T0 + 1220 ms.

**Orçamento de LCP:** no máximo +150 ms em relação ao `?static`. Se estourar, tirar `.hero .t-display` da lista de pré-estado **e** da timeline. O h1 fica estático desde o primeiro paint e o resto se mantém.

### 8.3 Empresas que confiam (`section.trust`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `h2.trust__title` | `up` 12 | IN | 600 | S | — | Rótulo de 16 px; sem divisão. Telas altas (e 375 px): a seção já aparece no boot e fica estática. |
| `.trust .logo-grid__cell img` × 10 (o **img**, nunca o `li`) | `up` 8 | IN, LOTE diagonal; +120 após o título se entrarem juntos | 500 | S | 40 × (linha + coluna), máx. 200 ms | Bordas e marcadores 11×11 estáticos: a grade existe antes e os logos "assentam" nela. `translate` se compõe com o `scale(.8)` de ≤ 720. Espera `load` (teto 400 ms). |

### 8.4 Decisão empresarial (`section.decision`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `#decision-title` | `lines` (1 linha) | IN | 950 | S | 90 | Largura travada em 894,9 px. |
| `.decision__desc` | `up` 16 (bloco) | IN, +120 | 700 | S | — | Folga de 1,1 px: nunca dividir. |
| `.impact > .impact__item` × 4 | `up` 20 (ícone, texto e régua juntos) | IN, LOTE | 700 | S | 90 | Ordem de leitura. Sem *pop* nos ícones. |
| `.decision .cta-box` | `up` 16 (caixa inteira) | IN | 700 | S | — | O botão anda com a caixa. |
| `.decision .cta-box__art` (`ilustra-cta.svg`, 10 traços) | `draw`, ordem do documento | Dep.: caixa + 200 | 1300 | D | min(70, 600/9) = 66 → total ≈ 1,9 s | Sufixo de id `-a1`. Lite: `wipe-x` 1000. ≤ 960: oculto, nunca marcado. |

### 8.5 Imóvel, atividade e operação (`section.property`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.property .section-head__title > .eyebrow` | `up` 12 | IN | 600 | S | — | — |
| `#property-title` (2 linhas, 729 / 581,8 de 760) | `lines` | IN, +80 | 950 | S | 90 | Restaurar o `style="text-align:center"` exato. |
| `.property .feature` × 3 | `up` 24 | IN, LOTE | 800 | S | 110 | Uma linha no desktop; um a um em ≤ 960. |
| `.feature__img > img` | `scale` 1,06 → 1 | Dep.: mesmo início do seu card | 1400 | S | (herda do card) | `.a-clip` na `.feature__img` durante a animação. Os cartões "atividade" embutidos no JPG escalam junto. Espera o `load` com teto de 300 ms (sem `decode()`). |
| `.property .cta-box` | `up` 16 | IN | 700 | S | — | — |
| `.property .cta-box__art` (2ª cópia de `ilustra-cta.svg`) | `draw`, ordem do documento | Dep.: caixa + 200 | 1300 | D | 66 | Sufixo de id `-a2`, próprio. |

### 8.6 Soluções (`section.docs#solucoes`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.docs__intro .eyebrow` | `up` 12 | IN | 600 | S | — | — |
| `#docs-title` (2 linhas, 513 / 147 de 525) | `lines` | IN, +80 | 950 | S | 90 | — |
| `.docs__intro > p.t-body` | `up` 16 | IN, +200 | 700 | S | — | — |
| `.docs__list > li.doc` × 9 | `up` 16 | IN, LOTE | 600 | S | 50 (teto 400) | **Nunca** `overflow`/`clip-path` no `li` ou na lista, porque cortaria a barra `::before` em `left:-24px`. Clicar durante a entrada é permitido. |
| `.docs__art[data-docs-art]` (container) | `fade` | IN | 600 | F | — | Em ≤ 960 fica acima da lista (`order:-1`) e dispara sozinho. |
| `.docs__art img.is-active` (a ativa no disparo) | `scale` 1,06 → 1 | Dep.: com o container | 1400 | S | — | **Nunca** opacidade nos imgs. `.a-clip` no container. |
| `.docs .cta-box` | `up` 16 | IN | 700 | S | — | O texto mantém o `style="max-width:499px"`. |
| `.docs .cta-box__art` (`ilustra-cta-docs.svg`, 332², 10 traços) | `draw`, ordem do documento | Dep.: caixa + 200 | 1300 | D | 66 | Cortado no topo (−116 px); ok. |

### 8.7 Método América (`section.method`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.method .section-head__title > .eyebrow` | `up` 12 | IN | 600 | S | — | — |
| `#method-title` (1 linha, 701 px) | `lines` | IN, +80 | 950 | S | 90 | — |
| `.method__desc` | `up` 16 (bloco) | IN, +200 | 700 | S | — | — |
| `.steps > li.step` × 4 | `up` 24 (card inteiro) | IN, LOTE | 800 | S | 110 | 4 colunas ≥ 1181, 2 colunas 721–1180, 1 coluna ≤ 720. |
| `.step__art` × 4 | `draw`, **ordenado pelo topo do bbox** | Dep., **em cadeia**: início do lote + 250 + i × 400 ms (i = posição do card no lote) | 900 por traço | D | min(50, 300/(n−1)): etapa-1 (14 traços) 23 ms; etapas 2/4 (6) 50 ms; etapa-3 (4) 50 ms | Cada desenho dura ≤ 1,2 s, então **a Etapa 1 termina (≈ 1449 ms) antes de a Etapa 4 começar (1450 ms)**: "quatro etapas, em ordem". Lite: `wipe-y` 1100 em 250 + i × 150. |

### 8.8 Sobre (`section.about#sobre`, card azul-marinho)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.about > .card-section__inner` | `chapter`: `inset(0 1.5% 0 1.5% round 24px)` → `inset(0 0% 0 0% round 24px)` | IN; **só ≥ 961 px e não-lite** | 900 | S | — | O capítulo "se abre", uma vez e por tempo, nunca por rolagem. O raio é igual ao atual (24 px). Sem `scale` no card. Se o DevTools mostrar > 8 ms de pintura por frame, desligar com `CONFIG.chapterOpen = false`. |
| `.about__intro-left .eyebrow--dark` | `up` 12 | IN | 600 | S | — | — |
| `#about-title` (2 linhas, 538 / 517 de 572) | `lines` | IN, +80 | 950 | S | 90 | — |
| `.about__intro-left .dot-pattern` | `wipe-x` | IN, +300 | 1000 | D | — | A opacidade .6 em repouso nunca é tocada. |
| `.about__intro .stack-p > p` × 2 | `up` 16 (blocos) | IN, LOTE | 700 | S | 100 | — |
| `.stats > li.stat` × 3 | `wipe-y` (a régua azul de 1 px "desce" com o conteúdo) | IN, LOTE | 800 | D | 120 | Livro-razão sendo pautado. Uma coluna em ≤ 960. Observado pelo pai `ul.stats` (o `clip-path` inicial zera a caixa do `li` para o IO). |
| `.stat:first-child > strong` ("+20 anos") | Contagem 0 → 20 | Dep.: texto vira "+0 anos" no início do wipe; conta a partir de +150 | 1400 | easeOutCubic | — | §7.7. Os outros dois `strong` ficam estáticos. |
| `.about__slides[data-fade]` (wrapper) | `fade` | IN | 700 | F | — | O `main.js` continua dono da troca a cada 5 s. |
| `.about__slides img.is-active` | `scale` 1,05 → 1 | Dep.: com o wrapper | 1600 | S | — | Só a foto visível escala (as outras estão com opacidade 0; promover três camadas de 1376 px não se pagava). `.a-clip` no wrapper. |
| `.about__quote > blockquote` (4 linhas em 1440) | `lines` | IN | 1000 | S | min(90, 450/(n−1)) | Ponto alto editorial. Nunca por palavra ou caractere. |
| `.about__author` (figcaption) | `up` 12 | Dep.: início da última linha + 200 (fallback em bloco: citação + 350) | 600 | S | — | A assinatura segue a fala. |
| `.about__foot .dot-pattern` | `wipe-x` | IN | 1000 | D | — | `display:none` em ≤ 960, então nunca é marcado. |
| `.about__foot .link-caret--light` | `fade` | IN, +200 | 600 | F | — | O transform do ícone (hover) não é tocado. |

### 8.9 Cases (`section.cases#cases`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.cases__glow` (o elemento, nunca o `::before`) | `fade` | IN | 1400 | S | — | Nunca `scale`/`filter`: o `::before` tem 2080×1124 com `blur(200px)`. A opacidade .3 dele fica intacta. Sem *drift* infinito. |
| `img.cases__logo` | `up` 12 | IN, +150 | 600 | S | — | Arte só de preenchimento: não é inline. |
| `#cases-title` (1 linha) | `lines` | IN, +250 | 950 | S | 90 | — |
| `.cases__desc` | `up` 16 (bloco) | IN, +400 | 700 | S | — | — |
| `ul.sectors` (barra inteira) | `up` 16 | IN | 700 | S | — | `display:none` em ≤ 720. |
| `.cases .logo-grid__cell img` × 20 | `up` 8 | IN, LOTE diagonal | 500 | S | 35 × (linha + coluna), máx. 245 ms | Mesmas regras de marcador e `scale(.8)` da seção Trust. |
| `.cases__cta > .btn` | `up` 16 (na própria `.btn`) | IN | 600 | S | — | — |

### 8.10 Depoimentos (`section.testimonials`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.testimonials__head .eyebrow` | `up` 12 | IN | 600 | S | — | — |
| `#testimonials-title` | `up` 20 (**bloco, sem divisão**) | IN, +80 | 800 | S | — | Folga de 0,2 px na linha 2. |
| `.testimonials__head .slider-nav` | `fade` | IN, +250 | 600 | F | — | Os *dots* já existem (o `main.js` roda antes). |
| `.testimonials__track[data-track]` (só o container) | `up` 20 | IN, +150 | 800 | S | — | **Nunca** marcar `.testimonial`: a opacidade e a visibilidade são do slider, e os clones já existem. |

### 8.11 Para contadores (`section.accountants#contadores`, card preto)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.accountants > .card-section__inner` | `chapter` (mesmos valores do Sobre) | IN; só ≥ 961 e não-lite | 900 | S | — | Mesmo recurso de capítulo do Sobre. |
| `.accountants__text .eyebrow--dark` | `up` 12 | IN | 600 | S | — | — |
| `#acc-title` | `up` 20 (**bloco, sem divisão**) | IN, +80 | 800 | S | — | Folga de 4,1 px: excluído do divisor. |
| `.accountants__text .stack-p > p` × 3 | `up` 16 | IN, LOTE | 700 | S | 90 | — |
| `.accountants__text > .link-caret--light` | `fade` | IN | 600 | F | — | — |
| `.accountants__img` (wrapper) | `fade` | IN | 700 | F | — | — |
| `.accountants__img > img` | `scale` 1,06 → 1 | Dep.: com o wrapper | 1400 | S | — | `.a-clip`; espera o `load` com teto de 300 ms (sem `decode()`). |
| `ol.accountants__steps`: sequência única (gatilho = o `ol`) | Etapa 1 = `li:nth-child(1)` `up` 12 em **0** · Seta 1 = `li:nth-child(2) > svg` `wipe-y` em **160** · Etapa 2 = `li:nth-child(3)` em **400** · Seta 2 = `li:nth-child(4) > svg` em **560** · Etapa 3 = `li:nth-child(5)` em **800** | IN | 600 (etapas) / 600 (setas) | S (etapas) / D (setas) | Fixo | Cenário → Enquadramento → Acompanhamento. As setas são contornos **preenchidos** (`fill-opacity .15`), então usamos clip e não *dash*. O clip no **svg** segue o `rotate(-90deg)` do `li` entre 721 e 1180, então o wipe vai da esquerda para a direita, na direção da seta. O transform do `li` nunca é tocado. |

### 8.12 Conteúdos (`section.blog#conteudos`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.blog__head .eyebrow` | `up` 12 | IN | 600 | S | — | — |
| `#blog-title` (1 linha) | `lines` | IN, +80 | 950 | S | 90 | — |
| `.blog__head > .link-caret` | `fade` | IN, +200 | 600 | F | — | — |
| `article.post` (os 7, inclusive clones) | `up` 20 nos posts **dentro** do retângulo do `.blog__viewport` (3 no desktop, 2 em ≤ 960, 1 em ≤ 720); os demais são assentados na hora | Gatilho = `.blog__viewport` (IN, sem efeito próprio) | 700 | S | 100 | Só `translate`: a largura medida pelo `main.js` não muda. **Nunca** `.blog__track` e **nunca** `.post__img img`, então sem escala de foto aqui. |
| `.blog .slider-nav` | `fade` | IN, +300 | 600 | F | — | — |

Acessibilidade do trilho (`main.js`, `goB`): só os posts da página visível ficam interativos; cópias e posts fora da janela recebem `inert` + `aria-hidden` (o Tab nunca cai em conteúdo escondido). Se algo rolar o `.blog__viewport` (`overflow:hidden`), um listener passivo de `scroll` volta `scrollLeft` a 0, mantendo `transform` e pontos em sincronia. Nada muda visualmente.

### 8.13 FAQ (`section.faq`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `#faq-title` (1 linha, 358 px) | `lines` | IN | 950 | S | 90 | — |
| `.faq__box` (texto + botão) | `up` 16 | IN, +120 | 700 | S | — | — |
| `.faq__art` (`ilustra-faq.svg`, "?" isométrico, 7 traços) | `draw`, **ordenado pelo topo do bbox** | Dep.: caixa + 250 | 1300 | D | min(70, 600/6) = 70 → total ≈ 1,7 s | Cortado embaixo pelo `overflow` da caixa; a parte visível desenha primeiro. Lite: `wipe-y` 1100. |
| `[data-faq] > .faq-item` × 9 | `up` 12 | IN, LOTE | 600 | S | 50 (teto 400) | O 1º item (aberto, resposta longa) nunca espera. O `rotate(180deg)` do ícone não é tocado. |

### 8.14 Footer (`footer.site-footer#contato`): observador IN-F (`rootMargin: 0`)

| Alvo | Efeito | Gatilho / atraso | Dur. | Curva | Stagger | Notas |
|---|---|---|---|---|---|---|
| `.site-footer .card-section__inner` | **Nenhum** | — | — | — | — | Destino de todos os "Solicitar diagnóstico": precisa estar sólido na chegada. Chegando por âncora, ele já está na tela e fica estático. |
| `.site-footer .footer__top` (logo + texto + link, em bloco) | `up` 16 | IN-F | 600 | S | — | Tempos curtos de propósito. |
| `.footer__nav > .footer__col` × 3 + `.footer__contact` | `up` 16 | IN-F, LOTE | 600 | S | 70 | Quebra em ≤ 1180; os itens chegam por lote. |
| `.footer__bar` | `fade` | IN-F | 500 | F | — | — |
| `.footer__pattern .dot-pattern` | `wipe-x` | IN-F | 900 | D | — | A opacidade .6 fica intacta. |
| `.footer__legal` | `fade` | IN-F, +100 | 500 | F | — | **Sentinela de fim de página** (§6.7). |

---

## 9. Microinterações

Todas ficam sob `html.motion-ok` (persistente) e dentro de `@media (prefers-reduced-motion: no-preference)`. Os efeitos de hover ficam também em `@media (hover:hover) and (pointer:fine)`. Nada é escondido atrás de hover.

| Elemento | Gatilho | Efeito | Dur. | Curva | Notas |
|---|---|---|---|---|---|
| `.btn .icon` (primário: seta) | `:hover` (pointer fino) e `:focus-visible` | `translate: 3px 0` | 200 | S | Usa a propriedade individual: o `transform .2s` do `.btn` não dispara. |
| `.btn--glass .icon` (arquivo) | Idem | `translate: 0 -2px` | 200 | S | — |
| `.btn` (todas) | `:active` (inclusive toque) | `scale: .98` | 120 | S | A lista de transição do `.btn` é redeclarada **somando** `scale .12s` (§12). O repouso não muda. |
| `.icon-btn` (setas dos sliders, menu, sociais) e `.footer__totop:active .icon-btn` | `:active` | `scale: .96` | 120 | S | Idem, somando à lista atual (`background-color`, `border-color`). |
| `.link-caret` | `:hover` (pointer fino) | Sublinhado de 1 px `currentColor` cresce da esquerda: `background-size 0 1px → calc(100% − 28px) 1px` | 350 | S | Feito com `background-image` (sem `position:relative`, sem pseudo-elemento). Em repouso o tamanho é 0, então não pinta nada. Exclui o ícone (20 px + gap 8 px). O nudge atual do ícone continua. |
| `:focus-visible` (global) | Foco por teclado | `a-focus-in`: `outline-offset 6px → 2px`, `outline-color transparent → azul` | 180 | S | Termina no contorno atual de 2 px. |
| Menu mobile | `.is-open` | Painel e links (§8.1) | 220 / 260 | S | — |
| Acordeão Documentos: altura | Clique (`main.js`) | `grid-template-rows`: abre **e fecha** em 420 ms (S) | 420 | S | Só a temporização muda. Um item fecha enquanto outro abre no mesmo clique: com durações/curvas diferentes a soma das alturas passava do final e voltava (o que está abaixo "quicava"). Iguais, a soma é monotônica. O corpo recolhido recebe `inert` (o link "Ver …" não é mais parada de Tab invisível). |
| Acordeão Documentos: conteúdo | Classe `.a-enter` no `.doc` recém-ativado | `.doc__body > div > *`: `a-content-in` (opacity 0→1, translate 0 8px → 0), atraso 120 ms (o link em 180 ms), `backwards` | 350 | S | O conteúdo sobe depois que a altura abre. |
| Acordeão Documentos: barra azul | Idem | `.doc__head::before`: `a-bar-in`, `scale 1 .3 → 1`, origem no topo | 420 | S | A barra "cresce" de cima. A opacidade atual (.2s) continua. |
| Acordeão Documentos: foto | `.a-enter` no `img.is-active` novo | `a-art-in`: `scale 1.03 → 1` | 600 | S | Soma-se à troca de opacidade de .4s, que continua do `main.js`/CSS. `.a-clip` no container durante a animação. |
| FAQ: altura | Clique (`main.js`) | Abre e fecha em 420 ms | 420 | S | O `rotate(180deg) .3s` do ícone não muda. Resposta recolhida com `inert`. |
| FAQ: resposta | `.a-enter` no `.faq-item` recém-aberto | `.faq-item__a .stack-p`: `a-content-in`, atraso 100 ms, `backwards` | 350 | S | — |
| Depoimentos: troca | `.a-enter` no `.testimonial.is-active` novo | `blockquote` em 0 ms e `.testimonial__author` em +60 ms: `a-slide-in` (translate 0 8px → 0) | 450 | S | **Só eixo Y**, para não haver overflow horizontal. A opacidade e a visibilidade (.4s) continuam únicas donas do fade. |
| Dots (depoimentos e blog) | `aria-current="true"` passa a valer | `a-dot-in`: `scale .4 → 1` | 360 | S | Em repouso, 6×6 idêntico. |
| Hovers existentes | — | **Mantidos sem alteração:** `.link-caret .icon` 3 px, cores de `.nav a` e `.footer__col a`, fundo de `.icon-btn`, ícone do `.doc__head`, zoom 1,03 do `.post:hover` | — | — | O trilho do blog **não** é retemporizado. |

**Como `.a-enter` é aplicada** (no `anim.js`; nunca no carregamento, só após clique do usuário):

```js
var timers = new WeakMap();
function enter(el, ms) {
  if (!el) return;
  clearTimeout(timers.get(el));
  el.classList.remove('a-enter'); void el.offsetWidth; el.classList.add('a-enter');   // reflow só no clique
  timers.set(el, setTimeout(function () { el.classList.remove('a-enter'); }, ms));
}
// Listeners registrados DEPOIS dos do main.js, no mesmo elemento ou em ancestral, então rodam depois dele.
// Documentos: em [data-docs]; se o .doc.is-active mudou → enter(doc, 700); enter(img.is-active, 650) + .a-clip no [data-docs-art] por 650 ms.
// FAQ: em [data-faq]; se há .faq-item.is-open e ele é novo → enter(item, 500).
// Depoimentos: em [data-slider="testimonials"]; se o alvo do clique é [data-prev], [data-next] ou [data-dots] button → enter(.testimonial.is-active, 560).
```

Como a classe só aparece depois de um clique, o documento que já começa ativo e o FAQ que já começa aberto **não animam no carregamento**.

---

## 10. Movimento reduzido

- **`prefers-reduced-motion: reduce` no carregamento:** o gate não adiciona `motion-ok` nem `js-anim`. Não há estado inicial, o `anim.js` retorna na primeira linha, o conteúdo aparece **imediatamente e sem fades**, e não há microinterações novas.
- **CSS:** `style.css` já tem `transition: none !important` e `scroll-behavior: auto !important` no bloco de redução. O `motion.css` acrescenta `*, *::before, *::after { animation: none !important; }`, que também desliga os `@keyframes` novos.
- **A troca de fotos da equipe** já se desliga sozinha (checagem no `main.js`, mantida). Ela também só roda com a seção na tela e a aba visível (`IntersectionObserver` + `visibilitychange`).
- **Heros alternando, foco:** mouse e foco pausam separadamente (`hOver`, `hFocus`); o `focusout` mantém a pausa se o foco foi para outro elemento do slider, e o timer nunca troca de slide enquanto o slide atual contém `document.activeElement`. Um slide focado nunca vira `inert`/`aria-hidden` (WCAG 2.4.3/2.4.7), mesmo com mouse saindo ou rolagem por roda.
- **Heros alternando:** só alternam com `html.hero-rotate`, posto no `<head>` quando o modo é "alternar" e não há redução de movimento. Sem essa classe (sem JS, `reduce`, modo "cidade") o slide "Sócio" fica `display:none` → altura exata da cidade. Se `reduce` for ligado no meio da sessão, a rotação para no slide atual.
- **Troca de preferência no meio da sessão** (listener `change` do `matchMedia`):
  - `finishAll()`, que chama `finish()` em toda animação de `running`, reverte divisões de linha, devolve os `<img>`, restaura contadores e assenta todos os pendentes;
  - depois remove `js-anim`, `anim-ready` e `motion-ok`.
- **`?static`** na URL produz o mesmo resultado (é o modo de captura de referência).

---

## 11. Mobile e toque

- Revelações só no eixo Y, nunca X: zero scroll horizontal a 375 px. Isso é critério de aceite (`scrollWidth === clientWidth`).
- Distâncias × 0,75 em ≤ 720 px (§5.3).
- A regra de lote evita atrasos artificiais em layouts de uma coluna: cada item começa quando chega.
- Modo lite em ≤ 960 px: ilustrações com wipe (sem SVG inline) e sem abertura de capítulo.
- Não marcados porque ficam ocultos no breakpoint: `.cta-box__art` (≤ 960), `.about__foot .dot-pattern` (≤ 960), `.sectors` (≤ 720).
- O `scale(.8)` dos logos em ≤ 720 e o `rotate(-90deg)` das setas entre 721 e 1180 continuam valendo: usamos propriedades individuais e o `svg` interno.
- Hover só com `(hover:hover) and (pointer:fine)`. No toque valem só o *press* (`:active`), as microinterações de acordeão e slider e o menu. Nenhum conteúdo depende de hover.
- Menu mobile (≤ 1180): só uma entrada suave; o fechamento continua instantâneo.

---

## 12. `assets/css/motion.css` (conteúdo completo)

```css
/* =========================================================
   América Licenciamentos: Motion (ver ANIMACOES.md)
   Carregar DEPOIS de style.css. Nada aqui altera o estado em repouso.
   ========================================================= */
:root {
  --a-ease: cubic-bezier(.22, 1, .36, 1);       /* settle */
  --a-ease-draw: cubic-bezier(.65, 0, .35, 1);  /* traço, wipe */
  --a-ease-fade: cubic-bezier(.33, 1, .68, 1);  /* opacidade */
  --a-ease-close: cubic-bezier(.4, 0, .2, 1);   /* fechar acordeão */
}

@media (prefers-reduced-motion: no-preference) {

  /* ---- 1. Estados iniciais: só existem com html.js-anim ---- */
  html.js-anim :is(.hero__eyebrow, .hero .t-display, .hero__desc, .hero__actions .btn):not(.is-in) { opacity: 0; }
  html.js-anim [data-anim]:not(.is-in):not([data-anim^="wipe"]):not([data-anim="chapter"]) { opacity: 0; }
  html.js-anim [data-anim="wipe-x"]:not(.is-in) { clip-path: inset(0 100% 0 0); }
  html.js-anim [data-anim="wipe-y"]:not(.is-in) { clip-path: inset(0 0 100% 0); }
  html.js-anim [data-anim="chapter"]:not(.is-in) { clip-path: inset(0 1.5% 0 1.5% round 24px); }

  /* Failsafe do hero: se o anim.js não subir em 1,5 s, o hero aparece */
  html.js-anim:not(.anim-ready) :is(.hero__eyebrow, .hero .t-display, .hero__desc, .hero__actions .btn) {
    animation: a-failsafe 1ms 1500ms forwards;
  }

  /* ---- 2. Utilitários temporários (só existem durante uma animação) ---- */
  .ln { display: block; clip-path: inset(-.35em -.5em 0 -.5em); }
  .ln__in { display: block; }
  .a-clip { isolation: isolate; }

  /* ---- 3. Microinterações (html.motion-ok é persistente) ---- */
  html.motion-ok .btn { transition: background-color .2s, transform .2s, box-shadow .2s, scale .12s var(--a-ease); }
  html.motion-ok .btn:active { scale: .98; }
  html.motion-ok .icon-btn { transition: background-color .2s, border-color .2s, scale .12s var(--a-ease); }
  html.motion-ok .icon-btn:active,
  html.motion-ok .footer__totop:active .icon-btn { scale: .96; }
  html.motion-ok .btn .icon { transition: translate .2s var(--a-ease); }
  html.motion-ok .btn:focus-visible .icon { translate: 3px 0; }
  html.motion-ok .btn--glass:focus-visible .icon { translate: 0 -2px; }
  html.motion-ok :focus-visible { animation: a-focus-in 180ms var(--a-ease); }

  /* Menu mobile (≤1180) */
  html.motion-ok .site-header.is-open .nav { animation: a-nav-in 220ms var(--a-ease); }
  html.motion-ok .site-header.is-open .nav a { animation: a-nav-link 260ms var(--a-ease) backwards; }
  html.motion-ok .site-header.is-open .nav a:nth-child(2) { animation-delay: 25ms; }
  html.motion-ok .site-header.is-open .nav a:nth-child(3) { animation-delay: 50ms; }
  html.motion-ok .site-header.is-open .nav a:nth-child(4) { animation-delay: 75ms; }
  html.motion-ok .site-header.is-open .nav a:nth-child(5) { animation-delay: 100ms; }
  html.motion-ok .site-header.is-open .nav a:nth-child(6) { animation-delay: 125ms; }
  html.motion-ok .site-header.is-open .nav a:nth-child(7) { animation-delay: 150ms; }

  /* Acordeões: só a temporização muda; abrir e fechar com a MESMA duração e curva */
  html.motion-ok .doc__body,
  html.motion-ok .faq-item__a { transition: grid-template-rows 420ms var(--a-ease); }

  /* Coreografia de entrada (.a-enter só é posta pelo JS após clique) */
  html.motion-ok .doc__head::before { transform-origin: 50% 0; }
  html.motion-ok .doc.a-enter .doc__head::before { animation: a-bar-in 420ms var(--a-ease); }
  html.motion-ok .doc.a-enter .doc__body > div > * { animation: a-content-in 350ms var(--a-ease) 120ms backwards; }
  html.motion-ok .doc.a-enter .doc__body > div > .link-caret { animation-delay: 180ms; }
  html.motion-ok .docs__art img.a-enter { animation: a-art-in 600ms var(--a-ease); }
  html.motion-ok .faq-item.a-enter .faq-item__a .stack-p { animation: a-content-in 350ms var(--a-ease) 100ms backwards; }
  html.motion-ok .testimonial.a-enter > blockquote { animation: a-slide-in 450ms var(--a-ease); }
  html.motion-ok .testimonial.a-enter > .testimonial__author { animation: a-slide-in 450ms var(--a-ease) 60ms backwards; }
  html.motion-ok .dots button[aria-current="true"] { animation: a-dot-in 360ms var(--a-ease); }

  /* Hover: só com ponteiro fino */
  @media (hover: hover) and (pointer: fine) {
    html.motion-ok .btn:hover .icon { translate: 3px 0; }
    html.motion-ok .btn--glass:hover .icon { translate: 0 -2px; }
    html.motion-ok .link-caret {
      background-image: linear-gradient(currentColor, currentColor);
      background-repeat: no-repeat;
      background-position: 0 100%;
      background-size: 0 1px;
      transition: background-size .35s var(--a-ease);
    }
    html.motion-ok .link-caret:hover { background-size: calc(100% - 28px) 1px; }
  }
}

/* Redução de movimento: soma-se ao bloco existente em style.css (transition:none) */
@media (prefers-reduced-motion: reduce) {
  *, *::before, *::after { animation: none !important; }
}

/* Impressão: tudo visível */
@media print {
  html.js-anim [data-anim],
  html.js-anim :is(.hero__eyebrow, .hero .t-display, .hero__desc, .hero__actions .btn) {
    opacity: 1 !important; clip-path: none !important;
  }
}

/* Keyframes: só "from"; o "to" é sempre o valor da folha de estilo (identidade) */
@keyframes a-failsafe   { to   { opacity: 1; } }
@keyframes a-focus-in   { from { outline-offset: 6px; outline-color: transparent; } }
@keyframes a-nav-in     { from { opacity: 0; translate: 0 -6px; } }
@keyframes a-nav-link   { from { opacity: 0; translate: 0 -4px; } }
@keyframes a-content-in { from { opacity: 0; translate: 0 8px; } }
@keyframes a-bar-in     { from { scale: 1 .3; } }
@keyframes a-art-in     { from { scale: 1.03; } }
@keyframes a-slide-in   { from { translate: 0 8px; } }
@keyframes a-dot-in     { from { scale: .4; } }
```

> Proibido neste arquivo: `will-change`, `filter`, `transform` (exceto `transform-origin`), regras de estado inicial fora de `html.js-anim` e qualquer valor de repouso diferente do `style.css`.

---

## 13. Checklist do estado final (critério de aceite)

Marque cada item em **1440 px** e em **375 px**.

**Pixels**

- [ ] `?static`: diff por seção igual ao baseline atual (1,8–4,4%, só antialiasing de texto).
- [ ] Movimento reduzido emulado: idêntico ao baseline, sem nenhum movimento ou fade, conteúdo visível na hora.
- [ ] JS desativado: idêntico ao baseline, todo o conteúdo visível.
- [ ] Execução "assentada" (protocolo §14): idêntica ao baseline.

**DOM depois de assentar**, com a página toda rolada (`?anim-audit` faz tudo isso e imprime `console.table`)

- [ ] `<html>` sem `js-anim` e sem `anim-ready` (`motion-ok` pode ficar: não tem efeito em repouso).
- [ ] Nenhum `[data-anim]`, `.is-in`, `.ln`, `.ln__in`, `.a-clip`, `.a-enter`.
- [ ] `document.getAnimations().filter(a => a.id && a.id.indexOf('a-') === 0).length === 0`.
- [ ] As 8 ilustrações (`.cta-box__art` × 3, `.step__art` × 4, `.faq__art` × 1) voltaram a ser `<img>`; nenhum `<svg>` com sufixo `-a{n}` no DOM.
- [ ] Atributos `style` idênticos ao snapshot do boot em todos os elementos, **exceto** `.blog__track` (o `translateX` do `main.js`). Em especial, `#property-title` volta exatamente com `text-align:center`.
- [ ] Cada título dividido tem de novo um único nó Text, com o texto original e nenhum `aria-*` adicionado.
- [ ] `.stat:first-child > strong` contém "+20 anos", sem `aria-hidden` e sem `span.sr-only` extra.
- [ ] Nenhum `will-change` computado diferente de `auto`. Nenhum `opacity`, `translate`, `scale` ou `clip-path` computado diferente do `style.css`.

**Comportamento**

- [ ] CLS = 0,00 (Lighthouse e `PerformanceObserver('layout-shift')`).
- [ ] LCP ≤ `?static` + 150 ms (mediana de 5 execuções, perfil "Mobile Slow 4G" e desktop).
- [ ] `document.documentElement.scrollWidth === clientWidth` durante e depois das animações (375, 768, 1440).
- [ ] Abas de Documentos, FAQ, slider de depoimentos (setas e dots), slider do blog (setas, dots e *rebuild* no resize), menu mobile e troca de fotos da equipe funcionam como antes.
- [ ] Microinterações **continuam funcionando depois da limpeza final** (teste: rolar até o fim, esperar 3 s e então abrir uma aba de Documentos e um FAQ).
- [ ] O documento ativo inicial e o FAQ aberto inicial **não** animam no carregamento.
- [ ] Âncoras partindo do topo (`#contato`, `#sobre`, `#solucoes`, `#cases`): conteúdo do destino visível na chegada e nada acima fica escondido (rolar para cima e conferir).
- [ ] Reload no meio da página e voltar pelo histórico (bfcache): nada que está na tela some.
- [ ] Visualização de impressão: tudo visível.
- [ ] Safari: cantos arredondados intactos durante a escala das fotos.
- [ ] Dispositivo de toque: nenhum conteúdo depende de hover e o *press* funciona.
- [ ] Rede lenta (fonte atrasada): o hero aparece em ≤ 300 ms após o boot, com fallback em bloco, sem flash e sem quebra diferente.
- [ ] `file://` ou `fetch` bloqueado: as ilustrações usam o wipe e terminam como `<img>`.

---

## 14. Protocolo de teste (pixel diff)

1. **Referência:** `http://127.0.0.1:8787/index.html?static`, captura por seção em 1440 e 375. Deve reproduzir o baseline atual.
2. **Movimento reduzido:** DevTools → Rendering → `prefers-reduced-motion: reduce`, capturar e comparar.
3. **JS desativado:** capturar e comparar.
4. **Assentado:**
   - carregar sem parâmetros;
   - rolar em passos de 300 px a cada 250 ms até o fim;
   - esperar 2,5 s;
   - `window.scrollTo({ top: 0, behavior: 'instant' })` e esperar 1 s;
   - rodar a auditoria (`?anim-audit`, ver abaixo) e só então capturar por seção e comparar.
5. **`?anim-audit`** (só em desenvolvimento, nunca ativado em produção):
   - no boot, guardar `Map(elemento → getAttribute('style'))` de todos os elementos;
   - quando `pending` esvaziar e não houver animações `a-*`, comparar e imprimir com `console.table` os desvios (excluindo `.blog__track`) e as asserções da seção 13. O slide de hero inativo (`.hero-slider > .hero:not(.is-current)`, opacidade 0 por desenho) fica fora da checagem de opacidade residual.

---

## 15. Porte para WordPress (para quem gerar o tema; nada em `theme/` é editado agora)

Não há mudança de markup nos *template-parts*: as classes são as mesmas e `data-anim` é posto em tempo de execução. Basta espelhar quatro itens:

1. **Gate inline:** em `add_action('wp_head', …, 1)`, prioridade 1, ou seja, **antes** dos estilos (que o WP imprime na prioridade 8). Imprimir o mesmo script da §4.1 via `wp_print_inline_script_tag()`.
2. **Preload do hero:** em `add_action('wp_head', …, 2)`, `<link rel="preload" as="image" href="URL" fetchpriority="high">`, onde **URL é a imagem de fundo do hero vinda do Customizer** (`theme_mod`), não um caminho fixo.
3. **CSS:** `wp_enqueue_style('america-motion', get_theme_file_uri('assets/css/motion.css'), [handle-do-style.css], VERSÃO)`.
4. **JS:** `wp_enqueue_script('america-anim', get_theme_file_uri('assets/js/anim.js'), [handle-do-main.js], VERSÃO, ['strategy' => 'defer', 'in_footer' => true])`. A dependência garante que o `anim.js` roda depois do `main.js`.

Os SVGs das ilustrações são lidos de `img.currentSrc || img.src`, então funcionam com qualquer URL de tema ou mídia. Se o conteúdo vier do Customizer e um título permitido deixar de ser um único nó Text, ou o texto da 1ª estatística não tiver número, o JS cai sozinho no fallback seguro (bloco / sem contagem).

---

## 16. Fora do escopo: o que foi descartado e por quê

| Ideia descartada | Origem | Motivo |
|---|---|---|
| Pré-loader, smooth scroll (Lenis), pinning, marquee, cursor customizado, blur, *bounce*/*overshoot* | Todos | Fora do tom institucional. O Lenis conflita com as âncoras, o `scroll-behavior: smooth` e o header sticky. |
| Header que se esconde na rolagem e sombra `.is-scrolled` | Plano "craft" | Estado que não existe no Figma. Esconderia o telefone e o "Solicitar diagnóstico" num site de geração de leads. |
| Parallax do hero, fundo movido para `::before` e escala do fundo | Plano "editorial" | Põe em risco o LCP e a paridade de pixels da imagem principal, e cria uma segunda fonte de verdade do gradiente no tema. |
| Timelines amarradas à rolagem que se completam sozinhas quando o leitor para (Método, Contadores, foto da equipe, cards escuros) | Plano "editorial" | Movimento enquanto o leitor está parado lendo texto regulatório, mais pintura por frame em superfícies grandes. Tudo virou sequência por tempo, disparada uma vez. |
| Botões magnéticos, brilho (*sheen*) e tilt com reflexo nas fotos | Plano "craft" | Tom de startup. Briga com a transição de `transform` do `.btn` e exige `will-change`/perspectiva. |
| "Holofote" na grade de logos (apaga os outros para .45) | Plano "craft" | Enfraquece a prova social de "Empresas que confiam" e Cases, e sugere clique onde não há. |
| Hover em elementos não clicáveis (zoom da foto do feature, ilustração flutuando, *pop* dos ícones de impacto, telefone "tocando") | Planos "editorial" e "craft" | Sugere clique onde não há. |
| Contagem de "4 etapas" | Plano vencedor | É um descritor do método, não uma evidência; contar 1→2→3→4 parece brinquedo. |
| Revelação de baixo para cima em todas as miniaturas do blog | Plano "editorial" | A repetição parece template. Além disso, o `img` pertence ao hover. |
| Retemporizar o trilho do blog (`.45s ease`) | Plano vencedor | Interação do `main.js`; não acrescenta nada. |
| Troca da foto de Documentos sem o "flash" azul (`z-index` e segurar a imagem anterior) | Plano "craft" | Muda o comportamento de imagens que pertencem ao `main.js`. **Candidato a uma fase 2, com aprovação.** |
| Depoimentos com direção (entrada ±16 px no eixo X) | Plano "craft" | Exigiria `overflow-x: clip` no trilho e muda uma interação existente. Ficou a subida de 8 px no eixo Y. |
| `position: relative` em `.doc`, `.faq-item`, `.feature__img` e `.link-caret` para linhas de hover | Plano "craft" | Muda os *containing blocks* em repouso. O sublinhado do `.link-caret` foi refeito com `background-size`, sem isso. |
| Dividir `#acc-title` e `#testimonials-title` em linhas | Plano vencedor | Folgas de 4,1 px e 0,2 px: risco de quebra diferente. Ficam em bloco. |
| Abertura de capítulo no card do footer | Plano "editorial" | O `#contato` é o destino de todos os CTAs e precisa estar sólido na chegada. |

---

## 17. Riscos residuais e mitigação

| Risco | Mitigação |
|---|---|
| Estilos ou camadas residuais alterando o antialiasing (Windows, DPR 1,25) | WAAPI só com `backwards`, sem `will-change`, reversão de toda escrita, auditoria `?anim-audit` e pixel diff assentado. |
| O divisor de linhas mudar uma quebra | Lista permitida, medição no layout real, largura travada, autoverificação ≤ 0,5 px com reversão, `fonts.check`, `finish` no resize, nó Text original devolvido. |
| Conteúdo preso escondido | Gate e watchdog de 3 s, failsafe CSS de 1,5 s, `try/catch`, alvos já na tela nunca marcados, recuperação de alvos acima da tela, sentinela do footer, `beforeprint`. |
| LCP piorar por esconder o texto do hero | Foto nunca escondida, preload com `fetchpriority=high`, espera de fonte de no máximo 300 ms, orçamento de +150 ms com plano B (h1 estático). |
| Traços inline rasterizarem diferente do `<img>` | O SVG inline só existe durante o desenho; o `<img>` original volta no fim. |
| Pintura de `clip-path` / `stroke-dashoffset` | Escopo pequeno e único: ≤ 14 traços por ilustração, ≤ 332 px, nunca em *scrub*, modo lite no celular e em CPU fraca, abertura de capítulo desligável (`CONFIG.chapterOpen`). |
| Safari perder o raio durante a escala | `.a-clip { isolation: isolate }` na moldura enquanto anima. |
| Clones dos sliders herdarem estado escondido | `anim.js` depois do `main.js`; só containers e `.post` são marcados; posts fora da área são assentados na hora. |

---

## 18. Correções pós-QA (out/2026)

| Problema | Correção |
|---|---|
| ≤ 960 px, modo "alternar": o "Sócio" (mais alto) definia a altura da célula e sobrava uma faixa branca sob o card da cidade; sem JS / `reduce` a faixa ficava para sempre | `html.hero-rotate` (posto no `<head>` só quando vai alternar). Sem ele o "Sócio" sai do layout (`display:none`) → altura exata da cidade. Alternando, o card da cidade estica até a célula (`.hero--cidade{display:flex}` + `.hero__bg{flex:1}`), como o do "Sócio". ≥ 961 px não muda (cidade 799 px). |
| Entrada do "Sócio" com `fill: both` terminando em `transform:none` anulava o `scale(.88)` dos cards no mobile | Keyframes só com `from`, usando `translate`/`scale` individuais, e `animation-fill-mode: backwards`. |
| Foco por teclado em conteúdo ainda invisível (faixa dos 12% inferiores) | `focusin` assenta o registro na hora + rede de segurança `:focus-within` no CSS. |
| Hero alternando: sem h1 quando o "Sócio" aparece; sem pausa; pontos de 6 px | `.hero-socio__title` com `role="heading" aria-level="1"` (sempre um único h1 exposto); botão pausar/retomar no pill dos pontos (`aria-pressed`); área de toque de 24 px (`::before`, espaçamento de 24 px entre centros) sem mudar o ponto de 6 px. |
| Acordeões "quicavam" (abre 420 / fecha 280 com curvas diferentes) | Mesma duração e curva nos dois sentidos (420 ms, S). |
| Custo do motor na rolagem (mobile) | `catchUp` só roda com lote não vazio e lê tudo antes de escrever; todos os alvos observados (sem custo mensurável no IO; o trecho só agrupa o lote); lite com término comum nas listas; `splitLines` mede só inícios de palavra; leitura do hero na fase de leitura; Sobre escala só a foto ativa; troca de fotos da equipe pausada fora da tela/aba oculta. |
| Preload do hero fixo na cidade competia com o LCP do modo "Sócio" | Preload injetado pelo script de modo do `<head>`, com a imagem do hero que aparece primeiro. |
| Cache de CSS/JS antigos em QA | `?v=` nos três assets locais do `index.html` (no tema: `filemtime()` como `ver`). |
| Rotação do hero continuava após ligar `reduce` | Listener `change` para a rotação no slide atual. |
