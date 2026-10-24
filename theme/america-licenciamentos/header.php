<?php
/**
 * Cabeçalho (seção 1 · Figma 7053:459) + abertura do <main>.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_logo  = america_mod_image( 'logo_header' );
$america_phone = america_mod( 'phone' );
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
