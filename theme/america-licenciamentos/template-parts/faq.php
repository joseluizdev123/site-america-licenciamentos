<?php
/**
 * 13. FAQ · Figma 7053:975 (respostas: 7101:638).
 * Itens do CPT amr_faq; a primeira pergunta começa aberta.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_faqs = america_get_faqs();
?>
<section class="section section--white faq" aria-labelledby="faq-title">
	<div class="container faq__grid">
		<div class="faq__aside">
			<h2 class="t-h2" id="faq-title"><?php america_mod_e( 'faq_title' ); ?></h2>
			<div class="faq__box">
				<img class="faq__art" src="<?php echo esc_url( america_image_url( 'ilustra-faq.svg' ) ); ?>" alt="" aria-hidden="true">
				<div class="t-body">
					<p><?php america_mod_e( 'faq_box_p1' ); ?></p>
					<p><?php america_mod_e( 'faq_box_p2' ); ?></p>
				</div>
				<a class="btn btn--primary" href="<?php america_mod_url_e( 'faq_btn_url' ); ?>"><?php america_icon( 'arrow-circle-right', 'icon--20' ); ?><?php america_mod_e( 'faq_btn_text' ); ?></a>
			</div>
		</div>
		<div class="faq__list" data-faq>
			<?php foreach ( $america_faqs as $america_i => $america_faq ) : ?>
			<div class="faq-item<?php echo 0 === $america_i ? ' is-open' : ''; ?>">
				<button class="faq-item__q t-h3" type="button" aria-expanded="<?php echo 0 === $america_i ? 'true' : 'false'; ?>"<?php echo $america_faq['wide'] ? ' style="gap:32px"' : ''; ?>><span><?php echo esc_html( $america_faq['question'] ); ?></span><?php america_icon( 'caret-down' ); ?></button>
				<div class="faq-item__a"><div><div class="t-body muted stack-p">
					<?php echo wp_kses_post( $america_faq['answer'] ); ?>
				</div></div></div>
			</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
