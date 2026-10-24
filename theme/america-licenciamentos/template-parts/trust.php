<?php
/**
 * 3. Empresas que confiam · Figma 7065:3636.
 * Clientes com "Exibir na faixa" marcado. Linhas calculadas pela quantidade (10 → logo-grid--rows-2).
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_clientes = america_get_clientes( 'faixa' );
$america_count    = count( $america_clientes );

if ( ! $america_count ) {
	return;
}
?>
<section class="trust" aria-labelledby="trust-title">
	<div class="container">
		<h2 class="trust__title" id="trust-title"><?php america_mod_e( 'trust_title' ); ?></h2>
		<ul class="<?php echo esc_attr( america_logo_grid_class( $america_count ) ); ?>">
			<?php foreach ( $america_clientes as $america_i => $america_c ) : ?>
			<li class="<?php echo esc_attr( america_logo_cell_class( $america_i, $america_count ) ); ?>"><img src="<?php echo esc_url( $america_c['logo'] ); ?>"<?php echo america_img_dims( $america_c['w'], $america_c['h'] ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado na função. ?> alt="<?php echo esc_attr( $america_c['name'] ); ?>" loading="lazy"></li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
