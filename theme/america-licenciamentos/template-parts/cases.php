<?php
/**
 * 9. Cases · Figma 7053:616.
 * Setores (taxonomia amr_setor) + clientes com "Exibir na grade" (20 → logo-grid--rows-4).
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_setores  = america_get_setores();
$america_clientes = america_get_clientes( 'grade' );
$america_count    = count( $america_clientes );
$america_cols     = count( $america_setores );
?>
<section class="section cases" id="cases" aria-labelledby="cases-title">
	<div class="cases__glow" aria-hidden="true"></div>
	<div class="container">
		<div class="section-head">
			<div class="section-head__title">
				<img class="cases__logo" src="<?php echo esc_url( america_image_url( 'icon-america.svg' ) ); ?>" width="98" height="93" alt="">
				<h2 class="t-h2" id="cases-title"><?php america_mod_e( 'cases_title' ); ?></h2>
			</div>
			<p class="t-body muted cases__desc"><?php america_mod_e( 'cases_desc' ); ?></p>
		</div>
		<?php if ( $america_cols ) : ?>
		<ul class="sectors" aria-label="<?php esc_attr_e( 'Setores', 'america' ); ?>"<?php echo 5 !== $america_cols ? ' style="' . esc_attr( 'grid-template-columns:repeat(' . $america_cols . ', 1fr)' ) . '"' : ''; ?>>
			<?php foreach ( $america_setores as $america_setor ) : ?><li><?php echo esc_html( $america_setor ); ?></li><?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<?php if ( $america_count ) : ?>
		<ul class="<?php echo esc_attr( america_logo_grid_class( $america_count ) ); ?>">
			<?php foreach ( $america_clientes as $america_i => $america_c ) : ?>
			<li class="<?php echo esc_attr( america_logo_cell_class( $america_i, $america_count ) ); ?>"><img src="<?php echo esc_url( $america_c['logo'] ); ?>"<?php echo america_img_dims( $america_c['w'], $america_c['h'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado na função. ?> alt="<?php echo esc_attr( $america_c['name'] ); ?>" loading="lazy"></li>
			<?php endforeach; ?>
		</ul>
		<?php endif; ?>
		<div class="cases__cta"><a class="btn btn--primary btn--plain" href="<?php america_mod_url_e( 'cases_btn_url' ); ?>"><?php america_mod_e( 'cases_btn_text' ); ?></a></div>
	</div>
</section>
