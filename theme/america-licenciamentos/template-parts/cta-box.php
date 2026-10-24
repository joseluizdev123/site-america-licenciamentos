<?php
/**
 * Caixa cinza com ilustração e botão "Solicitar diagnóstico" (usada em 3 seções).
 *
 * Args: text_key (campo do Personalizar), art (arquivo da ilustração),
 * class (classes do parágrafo), style (estilo inline do parágrafo).
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_cta = wp_parse_args(
	isset( $args ) && is_array( $args ) ? $args : array(),
	array(
		'text_key' => 'cta_text_1',
		'art'      => 'ilustra-cta.svg',
		'class'    => 't-body cta-box__text',
		'style'    => '',
	)
);
?>
<div class="cta-box">
	<img class="cta-box__art" src="<?php echo esc_url( america_image_url( $america_cta['art'] ) ); ?>" alt="" aria-hidden="true">
	<p class="<?php echo esc_attr( $america_cta['class'] ); ?>"<?php echo $america_cta['style'] ? ' style="' . esc_attr( $america_cta['style'] ) . '"' : ''; ?>><?php america_mod_e( $america_cta['text_key'] ); ?></p>
	<a class="btn btn--primary" href="<?php america_mod_url_e( 'cta_btn_url' ); ?>"><?php america_icon( 'arrow-circle-right', 'icon--20' ); ?><?php america_mod_e( 'cta_btn_text' ); ?></a>
</div>
