<?php
/**
 * 10. Depoimentos · Figma 7053:841.
 * Itens do CPT amr_depoimento. O main.js repete os itens até 5 posições (como no Figma).
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_items = america_get_depoimentos();

if ( empty( $america_items ) ) {
	return;
}
?>
<section class="section section--surface testimonials" aria-labelledby="testimonials-title" data-slider="testimonials">
	<div class="container testimonials__grid">
		<div class="testimonials__head">
			<div>
				<p class="eyebrow"><?php america_mod_e( 'testimonials_eyebrow' ); ?></p>
				<h2 class="t-h2" id="testimonials-title"><?php america_mod_e( 'testimonials_title' ); ?></h2>
			</div>
			<div class="slider-nav">
				<div class="slider-nav__arrows">
					<button class="icon-btn" type="button" data-prev aria-label="<?php esc_attr_e( 'Depoimento anterior', 'america' ); ?>"><?php america_icon( 'caret-left' ); ?></button>
					<button class="icon-btn" type="button" data-next aria-label="<?php esc_attr_e( 'Próximo depoimento', 'america' ); ?>"><?php america_icon( 'caret-right' ); ?></button>
				</div>
				<div class="dots" data-dots></div>
			</div>
		</div>
		<div class="testimonials__track" data-track>
			<?php foreach ( $america_items as $america_i => $america_t ) : ?>
			<figure class="testimonial<?php echo 0 === $america_i ? ' is-active' : ''; ?>">
				<blockquote class="t-quote"><?php echo esc_html( $america_t['quote'] ); ?></blockquote>
				<figcaption class="testimonial__author">
					<?php if ( $america_t['logo'] ) : ?>
					<img class="testimonial__logo" src="<?php echo esc_url( $america_t['logo'] ); ?>" width="56" height="56" alt="<?php echo esc_attr( $america_t['logo_alt'] ); ?>">
					<?php endif; ?>
					<div><p class="t-h3 testimonial__name"><?php echo esc_html( $america_t['name'] ); ?></p><p class="t-body muted"><?php echo esc_html( $america_t['role'] ); ?></p></div>
				</figcaption>
			</figure>
			<?php endforeach; ?>
		</div>
	</div>
</section>
