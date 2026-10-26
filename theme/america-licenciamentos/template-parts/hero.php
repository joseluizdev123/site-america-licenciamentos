<?php
/**
 * 2. Heros · "Cidade" (Figma 7065:3613) e "Sócio" (Figma 7022:1370).
 *
 * Os dois modelos são sempre impressos, como no index.html: o modelo escolhido em
 * Personalizar → 1. Destaque principal → Modelo do hero vai para html[data-hero]
 * (header.php) e o CSS estático esconde o outro. Em "alternar", o main.js monta os pontinhos.
 * Só existe um <h1>: o do modelo Cidade; o título do Sócio é <p role="heading">.
 * Com o modelo fixo "Sócio" (o Cidade fica display:none), os papéis se invertem: o título do
 * Sócio vira o <h1>. A âncora #diagnostico do botão do topo fica sempre no .hero-slider, que está
 * sempre visível. O título do Cidade mantém a classe t-display, usada pelo animations.js.
 *
 * A imagem de fundo padrão do Cidade vem do CSS; uma imagem escolhida no Personalizar
 * sobrescreve via estilo inline.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_hero_style = '';
$america_hero_img   = america_attachment( get_theme_mod( 'amr_hero_image' ) );
if ( $america_hero_img ) {
	$america_hero_style = 'background-image:linear-gradient(180deg, var(--hero-top) 34.876%, rgba(252,252,253,0) 100%), url("' . esc_url_raw( $america_hero_img['url'] ) . '")';
}
$america_socio_photo = america_mod_image( 'hero_socio_photo' );
$america_socio_main  = ( 'socio' === america_hero_mode() );
?>
<div class="hero-slider" id="diagnostico" data-hero-slider>
<section class="hero hero--cidade is-current" data-hero-slide>
	<div class="hero__bg"<?php echo $america_hero_style ? ' style="' . esc_attr( $america_hero_style ) . '"' : ''; ?>>
		<div class="hero__content">
			<div class="hero__text">
				<div class="hero__eyebrow">
					<?php america_icon( 'map-pin' ); ?>
					<p class="eyebrow"><?php america_mod_e( 'hero_eyebrow' ); ?></p>
				</div>
				<?php if ( $america_socio_main ) : ?>
					<p class="t-display" role="heading" aria-level="1"><?php america_mod_e( 'hero_title' ); ?></p>
				<?php else : ?>
					<h1 class="t-display"><?php america_mod_e( 'hero_title' ); ?></h1>
				<?php endif; ?>
				<p class="t-body muted hero__desc"><?php america_mod_e( 'hero_desc' ); ?></p>
			</div>
			<div class="hero__actions">
				<a class="btn btn--primary" href="<?php america_mod_url_e( 'hero_cta1_url' ); ?>"><?php america_icon( 'arrow-circle-right', 'icon--20' ); ?><?php america_mod_e( 'hero_cta1_text' ); ?></a>
				<a class="btn btn--glass" href="<?php america_mod_url_e( 'hero_cta2_url' ); ?>"><?php america_icon( 'file-text', 'icon--20' ); ?><?php america_mod_e( 'hero_cta2_text' ); ?></a>
			</div>
		</div>
	</div>
</section>

<section class="hero hero--socio" aria-label="<?php esc_attr_e( 'Apresentação com o sócio-diretor', 'america' ); ?>" data-hero-slide>
	<div class="hero-socio__bg">
		<div class="hero-socio__content">
			<div class="hero-socio__text">
				<div class="hero-socio__eyebrow">
					<?php america_icon( 'map-pin' ); ?>
					<p class="eyebrow"><?php america_mod_e( 'hero_socio_eyebrow' ); ?></p>
				</div>
				<?php if ( $america_socio_main ) : ?>
					<h1 class="hero-socio__title"><?php america_mod_e( 'hero_socio_title' ); ?></h1>
				<?php else : ?>
					<p class="hero-socio__title" role="heading" aria-level="1"><?php america_mod_e( 'hero_socio_title' ); ?></p>
				<?php endif; ?>
				<p class="t-body muted"><?php america_mod_e( 'hero_socio_desc' ); ?></p>
			</div>
			<div class="hero-socio__actions">
				<a class="btn btn--primary" href="<?php america_mod_url_e( 'hero_socio_cta1_url' ); ?>"><?php america_icon( 'arrow-circle-right', 'icon--20' ); ?><?php america_mod_e( 'hero_socio_cta1_text' ); ?></a>
				<a class="btn btn--glass btn--line" href="<?php america_mod_url_e( 'hero_socio_cta2_url' ); ?>"><?php america_icon( 'file-text', 'icon--20' ); ?><?php america_mod_e( 'hero_socio_cta2_text' ); ?></a>
			</div>
		</div>
		<div class="hero-socio__media">
			<img class="hero-socio__mark hero-socio__mark--1" src="<?php echo esc_url( america_image_url( 'hero-var-marca-1.svg' ) ); ?>" width="523" height="407" alt="" aria-hidden="true">
			<img class="hero-socio__mark hero-socio__mark--2" src="<?php echo esc_url( america_image_url( 'hero-var-marca-2.svg' ) ); ?>" width="152" height="154" alt="" aria-hidden="true">
			<div class="activity hero-socio__card hero-socio__card--1">
				<span class="hero-socio__card-icon hero-socio__card-icon--gold"><img src="<?php echo esc_url( america_image_url( 'hero-var-icon-pasta.png' ) ); ?>" width="20" height="20" alt=""></span>
				<div><strong><?php america_mod_e( 'hero_socio_card1_title' ); ?></strong><span><?php america_mod_e( 'hero_socio_card1_text' ); ?></span></div>
			</div>
			<img class="hero-socio__photo" src="<?php echo esc_url( $america_socio_photo['url'] ); ?>" width="497" height="605" alt="<?php echo esc_attr( $america_socio_photo['alt'] ); ?>">
			<div class="activity hero-socio__card hero-socio__card--2">
				<span class="hero-socio__card-icon hero-socio__card-icon--cream"><img src="<?php echo esc_url( america_image_url( 'hero-var-icon-certificado.png' ) ); ?>" width="32" height="32" alt=""></span>
				<div><strong><?php america_mod_e( 'hero_socio_card2_title' ); ?></strong><span><?php america_mod_e( 'hero_socio_card2_text' ); ?></span></div>
			</div>
		</div>
	</div>
</section>
<div class="hero-slider__dots" role="group" aria-label="<?php esc_attr_e( 'Escolher apresentação', 'america' ); ?>" data-hero-dots></div>
</div>
