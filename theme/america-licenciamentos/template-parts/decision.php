<?php
/**
 * 4. Decisão empresarial · Figma 7053:588.
 * 4 impactos (Personalizar); ícones e cores fixos do layout.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_impacts = array(
	1 => array( 'alert', 'icon-alerta.png' ),
	2 => array( 'house', 'icon-casa.png' ),
	3 => array( 'build', 'icon-obra.png' ),
	4 => array( 'money', 'icon-dinheiro.png' ),
);
?>
<section class="section section--white decision" aria-labelledby="decision-title">
	<div class="container">
		<div class="section-head decision__head">
			<h2 class="t-h2" id="decision-title"><?php america_mod_e( 'decision_title' ); ?></h2>
			<p class="t-body muted decision__desc"><?php america_mod_e( 'decision_desc' ); ?></p>
		</div>
		<ul class="impact">
			<?php foreach ( $america_impacts as $america_n => $america_impact ) : ?>
			<li class="impact__item">
				<span class="impact__icon impact__icon--<?php echo esc_attr( $america_impact[0] ); ?>"><img src="<?php echo esc_url( america_image_url( $america_impact[1] ) ); ?>" width="48" height="48" alt=""></span>
				<p class="t-h3"><?php america_mod_e( 'impact_' . $america_n ); ?></p>
			</li>
			<?php endforeach; ?>
		</ul>
		<?php
		get_template_part(
			'template-parts/cta-box',
			null,
			array(
				'text_key' => 'cta_text_1',
				'art'      => 'ilustra-cta.svg',
				'class'    => 't-body muted cta-box__text',
			)
		);
		?>
	</div>
</section>
