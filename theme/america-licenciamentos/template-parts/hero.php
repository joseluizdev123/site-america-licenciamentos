<?php
/**
 * 2. Hero · Figma 7065:3613.
 * A imagem padrão vem do CSS; uma imagem escolhida no Personalizar sobrescreve via estilo inline.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_hero_style = '';
$america_hero_img   = america_attachment( get_theme_mod( 'amr_hero_image' ) );
if ( $america_hero_img ) {
	$america_hero_style = 'background-image:linear-gradient(180deg, var(--hero-top) 34.876%, rgba(252,252,253,0) 100%), url("' . esc_url_raw( $america_hero_img['url'] ) . '")';
}
?>
<section class="hero" id="diagnostico">
	<div class="hero__bg"<?php echo $america_hero_style ? ' style="' . esc_attr( $america_hero_style ) . '"' : ''; ?>>
		<div class="hero__content">
			<div class="hero__text">
				<div class="hero__eyebrow">
					<?php america_icon( 'map-pin' ); ?>
					<p class="eyebrow"><?php america_mod_e( 'hero_eyebrow' ); ?></p>
				</div>
				<h1 class="t-display"><?php america_mod_e( 'hero_title' ); ?></h1>
				<p class="t-body muted hero__desc"><?php america_mod_e( 'hero_desc' ); ?></p>
			</div>
			<div class="hero__actions">
				<a class="btn btn--primary" href="<?php america_mod_url_e( 'hero_cta1_url' ); ?>"><?php america_icon( 'arrow-circle-right', 'icon--20' ); ?><?php america_mod_e( 'hero_cta1_text' ); ?></a>
				<a class="btn btn--glass" href="<?php america_mod_url_e( 'hero_cta2_url' ); ?>"><?php america_icon( 'file-text', 'icon--20' ); ?><?php america_mod_e( 'hero_cta2_text' ); ?></a>
			</div>
		</div>
	</div>
</section>
