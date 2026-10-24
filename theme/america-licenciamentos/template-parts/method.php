<?php
/**
 * 7. Método América · Figma 7116:1172.
 * 4 etapas (título + descrição) no Personalizar; ilustrações fixas do layout.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--white method" aria-labelledby="method-title">
	<div class="container">
		<div class="section-head">
			<div class="section-head__title">
				<p class="eyebrow"><?php america_mod_e( 'method_eyebrow' ); ?></p>
				<h2 class="t-h2" id="method-title"><?php america_mod_e( 'method_title' ); ?></h2>
			</div>
			<p class="t-body muted method__desc"><?php america_mod_e( 'method_desc' ); ?></p>
		</div>
		<ol class="steps">
			<?php for ( $america_n = 1; $america_n <= 4; $america_n++ ) : ?>
			<li class="step">
				<img class="step__art" src="<?php echo esc_url( america_image_url( 'ilustra-etapa-' . $america_n . '.svg' ) ); ?>" alt="" aria-hidden="true">
				<div class="step__body">
					<div class="step__top"><h3 class="t-h3"><?php america_mod_e( 'step_' . $america_n . '_title' ); ?></h3><span class="eyebrow"><?php echo esc_html( sprintf( 'Etapa %d', $america_n ) ); ?></span></div>
					<p class="t-body muted"><?php america_mod_e( 'step_' . $america_n . '_text' ); ?></p>
				</div>
			</li>
			<?php endfor; ?>
		</ol>
	</div>
</section>
