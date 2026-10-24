<?php
/**
 * 6. Documentos (abas) · Figma 7065:3684 / variantes 7001:768.
 * Itens do CPT amr_solucao; data-doc liga cada aba à sua imagem (assets/js/main.js).
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_docs = america_get_solucoes();
?>
<section class="section section--surface docs" id="solucoes" aria-labelledby="docs-title">
	<div class="container">
		<div class="docs__grid">
			<div>
				<div class="docs__intro">
					<div class="section-head__title" style="align-items:flex-start">
						<p class="eyebrow"><?php america_mod_e( 'docs_eyebrow' ); ?></p>
						<h2 class="t-h2" id="docs-title"><?php america_mod_e( 'docs_title' ); ?></h2>
					</div>
					<p class="t-body muted"><?php america_mod_e( 'docs_desc' ); ?></p>
				</div>
				<ul class="docs__list" data-docs>
					<?php
					foreach ( $america_docs as $america_i => $america_doc ) :
						$america_classes = array( 'doc' );
						if ( $america_doc['tight'] ) {
							$america_classes[] = 'doc--tight';
						}
						if ( 0 === $america_i ) {
							$america_classes[] = 'is-active';
						}
						?>
					<li class="<?php echo esc_attr( implode( ' ', $america_classes ) ); ?>" data-doc="<?php echo esc_attr( $america_doc['slug'] ); ?>">
						<button class="doc__head t-h3" type="button" aria-expanded="<?php echo 0 === $america_i ? 'true' : 'false'; ?>"><span class="doc__icon"><?php america_icon( 'doc-' . $america_doc['icon'] ); ?></span><?php echo esc_html( $america_doc['title'] ); ?></button>
						<div class="doc__body"><div>
							<p class="t-body muted"><?php echo esc_html( $america_doc['text'] ); ?></p>
							<a class="link-caret link-caret--blue" href="<?php echo esc_url( america_url( $america_doc['link_url'] ) ); ?>"><?php echo esc_html( $america_doc['link_text'] ); ?><?php america_icon( 'caret-right-20' ); ?></a>
						</div></div>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="docs__art" data-docs-art>
				<?php
				foreach ( $america_docs as $america_i => $america_doc ) :
					if ( ! $america_doc['image'] ) {
						continue;
					}
					?>
				<img<?php echo 0 === $america_i ? ' class="is-active"' : ''; ?> data-doc="<?php echo esc_attr( $america_doc['slug'] ); ?>" src="<?php echo esc_url( $america_doc['image'] ); ?>" width="580" height="602" alt="<?php echo esc_attr( $america_doc['image_alt'] ); ?>"<?php echo 0 === $america_i ? '' : ' loading="lazy"'; ?>>
				<?php endforeach; ?>
			</div>
		</div>
		<?php
		get_template_part(
			'template-parts/cta-box',
			null,
			array(
				'text_key' => 'cta_text_3',
				'art'      => 'ilustra-cta-docs.svg',
				'class'    => 't-body cta-box__text',
				'style'    => 'max-width:499px',
			)
		);
		?>
	</div>
</section>
