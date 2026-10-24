<?php
/**
 * América Licenciamentos: configuração do tema, assets e includes.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

define( 'AMERICA_VERSION', '1.0.0' );

/* Fontes exatamente como no index.html estático. */
define( 'AMERICA_FONTS_URL', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;700&family=Stack+Sans+Headline:wght@300&display=swap' );

require_once get_template_directory() . '/inc/helpers.php';
require_once get_template_directory() . '/inc/content-defaults.php';
require_once get_template_directory() . '/inc/customizer.php';
require_once get_template_directory() . '/inc/cpt-solucao.php';
require_once get_template_directory() . '/inc/cpt-cliente.php';
require_once get_template_directory() . '/inc/cpt-depoimento.php';
require_once get_template_directory() . '/inc/cpt-faq.php';

if ( is_admin() ) {
	require_once get_template_directory() . '/inc/seeder.php';
}

/**
 * Suportes do tema e menus.
 */
function america_setup() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'style', 'script' ) );

	register_nav_menus(
		array(
			'principal' => __( 'Menu principal (topo)', 'america' ),
			'rodape-1'  => __( 'Rodapé: coluna 1 (Licenciamento e operação)', 'america' ),
			'rodape-2'  => __( 'Rodapé: coluna 2 (Regularização do imóvel)', 'america' ),
			'rodape-3'  => __( 'Rodapé: coluna 3 (Institucional)', 'america' ),
		)
	);
}
add_action( 'after_setup_theme', 'america_setup' );

/**
 * Versão de um asset pela data de modificação do arquivo (cache busting).
 *
 * @param string $relative Caminho relativo à raiz do tema.
 * @return string
 */
function america_asset_version( $relative ) {
	$path = get_theme_file_path( $relative );
	return file_exists( $path ) ? (string) filemtime( $path ) : AMERICA_VERSION;
}

/**
 * CSS, fontes e JS.
 */
function america_enqueue_assets() {
	// Versão null: evita ?ver= e preserva os dois parâmetros "family" da URL.
	wp_enqueue_style( 'america-fonts', AMERICA_FONTS_URL, array(), null ); // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion

	wp_enqueue_style(
		'america-style',
		get_theme_file_uri( 'assets/css/style.css' ),
		array( 'america-fonts' ),
		america_asset_version( 'assets/css/style.css' )
	);
	wp_add_inline_style( 'america-style', america_inline_css() );

	wp_enqueue_script(
		'america-main',
		get_theme_file_uri( 'assets/js/main.js' ),
		array(),
		america_asset_version( 'assets/js/main.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'america_enqueue_assets' );

/**
 * Regras complementares que não existem no CSS estático.
 * Nenhuma delas altera a home com o conteúdo padrão (10 e 20 logos).
 *
 * @return string
 */
function america_inline_css() {
	// Grade de logos com quantidade fora de 2 ou 4 linhas: a última linha recebe a classe --last.
	$css = '.logo-grid__cell--last{border-bottom:0}.logo-grid__cell--last::after{display:none}';

	// Páginas internas (index.php).
	$css .= '.entry{max-width:808px;margin-inline:auto}'
		. '.entry__meta{margin-top:16px}'
		. '.entry__img{margin-top:32px;border-radius:var(--r-lg);overflow:hidden}'
		. '.entry__content{margin-top:32px}'
		. '.entry__content a{color:var(--blue-600);text-decoration:underline}'
		. '.entry__content h2,.entry__content h3{font-family:var(--font-head);font-weight:300;margin-top:32px}'
		. '.entry__content ul{list-style:disc;padding-left:24px}.entry__content ol{list-style:decimal;padding-left:24px}'
		. '.archive-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(280px,1fr));gap:56px 24px;margin-top:56px}'
		. '.archive-grid .post{flex:none}'
		. '.entry__pagination{margin-top:56px;display:flex;gap:16px}';

	// Header fixo abaixo da barra de administração (usuário logado).
	if ( is_admin_bar_showing() ) {
		$css .= '.admin-bar .site-header{top:32px}'
			. '@media (max-width:782px){.admin-bar .site-header{top:46px}}'
			. '@media (max-width:600px){.admin-bar .site-header{top:0}}';
	}

	return $css;
}

/**
 * Preconnect das fontes, como no index.html.
 *
 * @param array  $urls     URLs.
 * @param string $relation Tipo de hint.
 * @return array
 */
function america_resource_hints( $urls, $relation ) {
	if ( 'preconnect' === $relation ) {
		$urls[] = array( 'href' => 'https://fonts.googleapis.com' );
		$urls[] = array(
			'href' => 'https://fonts.gstatic.com',
			'crossorigin',
		);
	}
	return $urls;
}
add_filter( 'wp_resource_hints', 'america_resource_hints', 10, 2 );

/**
 * A home não usa blocos: remove os CSS de blocos para manter a paridade com o HTML estático.
 */
function america_trim_front_assets() {
	if ( ! is_front_page() ) {
		return;
	}
	foreach ( array( 'wp-block-library', 'wp-block-library-theme', 'classic-theme-styles', 'global-styles' ) as $handle ) {
		wp_dequeue_style( $handle );
	}
}
add_action( 'wp_enqueue_scripts', 'america_trim_front_assets', 100 );
add_action( 'wp_footer', 'america_trim_front_assets', 5 );

/**
 * Título da página inicial (Personalizar → Identidade e SEO).
 *
 * @param string $title Título.
 * @return string
 */
function america_front_title( $title ) {
	if ( is_front_page() ) {
		return america_mod( 'seo_title' );
	}
	return $title;
}
add_filter( 'pre_get_document_title', 'america_front_title' );

/**
 * Meta description da home, quando não houver plugin de SEO ativo.
 */
function america_meta_description() {
	if ( ! is_front_page() || defined( 'WPSEO_VERSION' ) || defined( 'RANK_MATH_VERSION' ) || defined( 'AIOSEO_VERSION' ) || defined( 'SEOPRESS_VERSION' ) ) {
		return;
	}
	$description = america_mod( 'seo_description' );
	if ( $description ) {
		echo '<meta name="description" content="' . esc_attr( $description ) . '">' . "\n";
	}
}
add_action( 'wp_head', 'america_meta_description', 1 );
