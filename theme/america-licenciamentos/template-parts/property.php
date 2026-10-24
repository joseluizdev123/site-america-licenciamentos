<?php
/**
 * 5. Imóvel, atividade e operação · Figma 7053:521.
 * 3 cartões (título, texto, imagem) no Personalizar.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;
?>
<section class="section section--white property" aria-labelledby="property-title">
	<div class="container">
		<div class="section-head__title">
			<p class="eyebrow"><?php america_mod_e( 'property_eyebrow' ); ?></p>
			<h2 class="t-h2 features__title" id="property-title" style="text-align:center"><?php america_mod_e( 'property_title' ); ?></h2>
		</div>
		<div class="features">
			<?php
			for ( $america_n = 1; $america_n <= 3; $america_n++ ) :
				$america_img = america_mod_image( 'feature_' . $america_n . '_image' );
				?>
			<article class="feature">
				<div class="feature__img"><img src="<?php echo esc_url( $america_img['url'] ); ?>" width="384" height="384" alt="<?php echo esc_attr( $america_img['alt'] ); ?>" loading="lazy"></div>
				<div class="feature__body">
					<h3 class="t-h3"><?php america_mod_e( 'feature_' . $america_n . '_title' ); ?></h3>
					<p class="t-body muted"><?php america_mod_e( 'feature_' . $america_n . '_text' ); ?></p>
				</div>
			</article>
			<?php endfor; ?>
		</div>
		<?php
		get_template_part(
			'template-parts/cta-box',
			null,
			array(
				'text_key' => 'cta_text_2',
				'art'      => 'ilustra-cta.svg',
				'class'    => 't-body cta-box__text',
			)
		);
		?>
	</div>
</section>
