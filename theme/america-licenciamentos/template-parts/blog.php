<?php
/**
 * 12. Blog ("Conteúdos") · Figma 7053:924.
 * Últimos posts com imagem destacada. O main.js repete os cards até 7 posições.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_posts = america_get_blog_posts();
?>
<section class="section section--surface blog" id="conteudos" aria-labelledby="blog-title" data-slider="blog">
	<div class="container">
		<div class="blog__head">
			<div>
				<p class="eyebrow"><?php america_mod_e( 'blog_eyebrow' ); ?></p>
				<h2 class="t-h2" id="blog-title"><?php america_mod_e( 'blog_title' ); ?></h2>
			</div>
			<a class="link-caret" href="<?php america_mod_url_e( 'blog_link_url' ); ?>"><?php america_mod_e( 'blog_link_text' ); ?><?php america_icon( 'caret-right' ); ?></a>
		</div>
		<div class="blog__viewport">
			<div class="blog__track" data-track>
				<?php foreach ( $america_posts as $america_p ) : ?>
				<article class="post">
					<div class="post__top">
						<?php if ( $america_p['image'] ) : ?>
						<div class="post__img"><img src="<?php echo esc_url( $america_p['image'] ); ?>" width="389" height="219" alt="<?php echo esc_attr( $america_p['image_alt'] ); ?>" loading="lazy"></div>
						<?php endif; ?>
						<p class="post__meta"><?php if ( $america_p['cat'] ) : ?><span class="post__cat"><?php echo esc_html( $america_p['cat'] ); ?></span><span>•</span><?php endif; ?><time datetime="<?php echo esc_attr( $america_p['date'] ); ?>"><?php echo esc_html( $america_p['date_label'] ); ?></time></p>
						<div class="post__content">
							<h3 class="t-h3"><?php echo esc_html( $america_p['title'] ); ?></h3>
							<p class="t-body muted"><?php echo esc_html( $america_p['excerpt'] ); ?></p>
						</div>
					</div>
					<a class="link-caret" href="<?php echo esc_url( america_url( $america_p['url'] ) ); ?>"><?php esc_html_e( 'Ler conteúdo', 'america' ); ?><?php america_icon( 'caret-right' ); ?></a>
				</article>
				<?php endforeach; ?>
			</div>
		</div>
		<div class="slider-nav">
			<div class="slider-nav__arrows">
				<button class="icon-btn" type="button" data-prev aria-label="<?php esc_attr_e( 'Conteúdos anteriores', 'america' ); ?>"><?php america_icon( 'caret-left' ); ?></button>
				<button class="icon-btn" type="button" data-next aria-label="<?php esc_attr_e( 'Próximos conteúdos', 'america' ); ?>"><?php america_icon( 'caret-right' ); ?></button>
			</div>
			<div class="dots" data-dots></div>
		</div>
	</div>
</section>
