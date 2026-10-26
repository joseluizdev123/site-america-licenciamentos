<?php
/**
 * Cabeçalho (seção 1 · Figma 7053:459) + abertura do <main>.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_logo  = america_mod_image( 'logo_header' );
$america_phone = america_mod( 'phone' );
$america_home  = is_front_page();
$america_hero  = america_hero_mode();
?><!doctype html>
<html <?php language_attributes(); ?><?php echo $america_home ? ' data-hero="' . esc_attr( $america_hero ) . '"' : ''; ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<?php
if ( $america_home ) :
	// Os dois scripts precisam rodar antes do primeiro paint: ficam antes de wp_head() e de qualquer CSS.
	$america_hero_urls = array(
		'cidade' => esc_url_raw( america_mod_image( 'hero_image' )['url'] ),
		'socio'  => esc_url_raw( america_mod_image( 'hero_socio_photo' )['url'] ),
	);
	?>
	<script>
	/* Hero: "alternar" (provisório até o cliente escolher), "cidade" ou "socio". Padrão: Personalizar → 1. Destaque principal → Modelo do hero. ?hero=cidade|socio|variacao|alternar */
	(function (h, d, u) {
		var m = ((/[?&]hero=([a-z]+)/i.exec(location.search) || [])[1] || d).toLowerCase();
		if (m === 'variacao') m = 'socio';
		if (m !== 'cidade' && m !== 'socio' && m !== 'alternar') m = d;
		h.setAttribute('data-hero', m);
		try {
			/* Só alterna com movimento liberado; sem isso (ou sem JS) o "Sócio" sai do layout */
			if (m === 'alternar' && window.matchMedia && !matchMedia('(prefers-reduced-motion: reduce)').matches) h.classList.add('hero-rotate');
			/* Preload da imagem da hero que aparece primeiro (a outra não compete pela banda) */
			var l = document.createElement('link');
			l.rel = 'preload'; l.as = 'image'; l.setAttribute('fetchpriority', 'high');
			l.href = m === 'socio' ? u.socio : u.cidade;
			document.head.appendChild(l);
		} catch (e) {}
	})(document.documentElement, <?php echo wp_json_encode( $america_hero ); ?>, <?php echo wp_json_encode( $america_hero_urls ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- JSON de valores da lista fixa e URLs passadas por esc_url_raw(). ?>);
	</script>
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
			/* Hero só é escondido onde a entrada vai rodar (mesmos testes do "lite" do animations.js) */
			var c = navigator.connection;
			if (w.matchMedia('(min-width: 961px)').matches && (navigator.hardwareConcurrency || 8) > 4 && !(c && c.saveData)) {
				h.classList.add('hero-anim');
				/* Mesmo corte do animations.js: sem boot até 1400 ms da navegação, o hero aparece estático */
				var t0 = w.performance && performance.now ? performance.now() : 0;
				w.setTimeout(function () {
					if (!h.classList.contains('anim-ready')) h.classList.remove('hero-anim');
				}, Math.max(0, 1400 - t0));
			}
			w.setTimeout(function () {
				if (!h.classList.contains('anim-ready')) h.classList.remove('js-anim', 'hero-anim');
			}, 3000);
		} catch (e) { h.classList.remove('js-anim', 'hero-anim'); }
	})(document, window);
	</script>
<?php endif; ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<?php america_sprite(); ?>

<header class="site-header" id="topo">
	<div class="site-header__bar">
		<a class="site-header__logo" href="<?php echo esc_url( america_url( '#topo' ) ); ?>" aria-label="<?php esc_attr_e( 'América Licenciamentos — início', 'america' ); ?>">
			<img src="<?php echo esc_url( $america_logo['url'] ); ?>" width="145" height="48" alt="<?php echo esc_attr( $america_logo['alt'] ? $america_logo['alt'] : 'América Licenciamentos' ); ?>">
		</a>
		<nav class="nav" aria-label="<?php esc_attr_e( 'Principal', 'america' ); ?>">
			<?php america_menu( 'principal' ); ?>
		</nav>
		<div class="site-header__actions">
			<a class="phone-link" href="<?php echo esc_url( america_tel_href( $america_phone ) ); ?>"><?php america_icon( 'phone', 'icon--20' ); ?><?php echo esc_html( $america_phone ); ?></a>
			<a class="btn btn--outline" href="<?php america_mod_url_e( 'header_cta_url' ); ?>"><?php america_mod_e( 'header_cta_text' ); ?></a>
			<button class="icon-btn menu-toggle" type="button" aria-expanded="false" aria-label="<?php esc_attr_e( 'Abrir menu', 'america' ); ?>">
				<svg width="20" height="20" viewBox="0 0 20 20" aria-hidden="true"><path d="M3 5h14M3 10h14M3 15h14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
			</button>
		</div>
	</div>
</header>

<main>
