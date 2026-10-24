<?php
/**
 * 11. Para contadores · Figma 7053:869.
 * Título, 3 parágrafos, imagem, 3 etapas e link no Personalizar.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_img   = america_mod_image( 'acc_image' );
$america_arrow = '<svg width="49" height="87" viewBox="0 0 49 87"><path d="M24.5 0H24V86.5H25V0H24.5ZM24.1464 86.8536C24.3417 87.0488 24.6583 87.0488 24.8536 86.8536L28.0355 83.6716C28.2308 83.4763 28.2308 83.1597 28.0355 82.9645C27.8403 82.7692 27.5237 82.7692 27.3284 82.9645L24.5 85.7929L21.6716 82.9645C21.4763 82.7692 21.1597 82.7692 20.9645 82.9645C20.7692 83.1597 20.7692 83.4763 20.9645 83.6716L24.1464 86.8536Z" fill="#fff" fill-opacity=".15"/></svg>';
?>
<section class="card-section accountants" id="contadores" aria-labelledby="acc-title">
	<div class="card-section__inner">
		<div class="accountants__text">
			<div>
				<p class="eyebrow eyebrow--dark"><?php america_mod_e( 'acc_eyebrow' ); ?></p>
				<h2 class="t-h2" id="acc-title"><?php america_mod_e( 'acc_title' ); ?></h2>
			</div>
			<div class="t-body stack-p">
				<p><?php america_mod_e( 'acc_p1' ); ?></p>
				<p><?php america_mod_e( 'acc_p2' ); ?></p>
				<p><?php america_mod_e( 'acc_p3' ); ?></p>
			</div>
			<a class="link-caret link-caret--light" href="<?php america_mod_url_e( 'acc_link_url' ); ?>"><?php america_mod_e( 'acc_link_text' ); ?><?php america_icon( 'caret-right-20' ); ?></a>
		</div>
		<div class="accountants__img"><img src="<?php echo esc_url( $america_img['url'] ); ?>" width="486" height="438" alt="<?php echo esc_attr( $america_img['alt'] ); ?>" loading="lazy"></div>
		<ol class="accountants__steps">
			<?php for ( $america_n = 1; $america_n <= 3; $america_n++ ) : ?>
				<?php if ( $america_n > 1 ) : ?>
			<li class="accountants__arrow" aria-hidden="true"><?php echo $america_arrow; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG estático definido acima. ?></li>
				<?php endif; ?>
			<li><span class="eyebrow eyebrow--dark"><?php echo esc_html( sprintf( 'Etapa %d', $america_n ) ); ?></span><span class="t-h3"><?php america_mod_e( 'acc_step_' . $america_n ); ?></span></li>
			<?php endfor; ?>
		</ol>
	</div>
</section>
