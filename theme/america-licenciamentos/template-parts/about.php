<?php
/**
 * 8. Quem faz (Sobre) · Figma 7085:3239 / variantes 7001:2271.
 * Textos, 3 números, 3 fotos (troca suave via [data-fade]) e citação no Personalizar.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="card-section about" id="sobre" aria-labelledby="about-title">
	<div class="card-section__inner">
		<div class="about__top">
			<div class="container">
				<div class="about__intro">
					<div class="about__intro-left">
						<div>
							<p class="eyebrow eyebrow--dark"><?php america_mod_e( 'about_eyebrow' ); ?></p>
							<h2 class="t-h2" id="about-title"><?php america_mod_e( 'about_title' ); ?></h2>
						</div>
						<div class="dot-pattern" aria-hidden="true"></div>
					</div>
					<div class="t-body stack-p">
						<p><?php america_mod_e( 'about_p1' ); ?></p>
						<p><?php america_mod_e( 'about_p2' ); ?></p>
					</div>
				</div>
				<ul class="stats">
					<?php for ( $america_n = 1; $america_n <= 3; $america_n++ ) : ?>
					<li class="stat"><strong class="t-h2"><?php america_mod_e( 'stat_' . $america_n . '_value' ); ?></strong><span class="stat__label"><?php america_mod_e( 'stat_' . $america_n . '_label' ); ?></span></li>
					<?php endfor; ?>
				</ul>
			</div>
		</div>
		<div class="about__media">
			<div class="about__slides" data-fade>
				<?php
				for ( $america_n = 1; $america_n <= 3; $america_n++ ) :
					$america_img = america_mod_image( 'about_photo_' . $america_n );
					?>
				<img<?php echo 1 === $america_n ? ' class="is-active"' : ''; ?> src="<?php echo esc_url( $america_img['url'] ); ?>" width="1376" height="636" alt="<?php echo esc_attr( $america_img['alt'] ); ?>" loading="lazy">
				<?php endfor; ?>
			</div>
		</div>
		<div class="about__bottom">
			<div class="container">
				<figure class="about__quote">
					<blockquote class="t-h2"><?php america_mod_e( 'about_quote' ); ?></blockquote>
					<figcaption class="about__author">
						<span class="t-h3"><?php america_mod_e( 'about_author' ); ?></span>
						<p class="t-body"><?php america_mod_e( 'about_role' ); ?></p>
					</figcaption>
				</figure>
				<div class="about__foot">
					<div class="dot-pattern" aria-hidden="true"></div>
					<a class="link-caret link-caret--light" href="<?php america_mod_url_e( 'about_link_url' ); ?>"><?php america_mod_e( 'about_link_text' ); ?><?php america_icon( 'caret-right-20' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
