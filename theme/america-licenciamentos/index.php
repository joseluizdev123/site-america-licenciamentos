<?php
/**
 * Template genérico: posts, páginas, arquivos, busca e 404.
 * A página inicial usa front-page.php.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

get_header();
?>
<section class="section section--white">
	<div class="container">
	<?php if ( have_posts() && is_singular() ) : ?>
		<?php
		while ( have_posts() ) :
			the_post();
			$america_cats = 'post' === get_post_type() ? get_the_category() : array();
			?>
		<article <?php post_class( 'entry' ); ?>>
			<h1 class="t-h2"><?php echo esc_html( get_the_title() ); ?></h1>
			<?php if ( 'post' === get_post_type() ) : ?>
			<p class="post__meta entry__meta">
				<?php if ( $america_cats ) : ?>
				<span class="post__cat"><?php echo esc_html( $america_cats[0]->name ); ?></span><span>•</span>
				<?php endif; ?>
				<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( america_date_label( get_the_date( 'Y-m-d' ) ) ); ?></time>
			</p>
			<?php endif; ?>
			<?php if ( has_post_thumbnail() ) : ?>
			<div class="entry__img"><?php the_post_thumbnail( 'large' ); ?></div>
			<?php endif; ?>
			<div class="t-body stack-p entry__content">
				<?php the_content(); ?>
			</div>
			<?php wp_link_pages(); ?>
		</article>
		<?php endwhile; ?>

	<?php elseif ( have_posts() ) : ?>
		<h1 class="t-h2">
			<?php
			if ( is_home() ) {
				esc_html_e( 'Conteúdos', 'america' );
			} elseif ( is_search() ) {
				/* translators: %s: termo buscado. */
				printf( esc_html__( 'Resultados para “%s”', 'america' ), esc_html( get_search_query() ) );
			} else {
				echo esc_html( wp_strip_all_tags( get_the_archive_title() ) );
			}
			?>
		</h1>
		<div class="archive-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				$america_cats = get_the_category();
				?>
			<article class="post">
				<div class="post__top">
					<?php if ( has_post_thumbnail() ) : ?>
					<div class="post__img"><?php the_post_thumbnail( 'medium_large' ); ?></div>
					<?php endif; ?>
					<?php if ( 'post' === get_post_type() ) : ?>
					<p class="post__meta">
						<?php if ( $america_cats ) : ?>
						<span class="post__cat"><?php echo esc_html( $america_cats[0]->name ); ?></span><span>•</span>
						<?php endif; ?>
						<time datetime="<?php echo esc_attr( get_the_date( 'Y-m-d' ) ); ?>"><?php echo esc_html( america_date_label( get_the_date( 'Y-m-d' ) ) ); ?></time>
					</p>
					<?php endif; ?>
					<div class="post__content">
						<h2 class="t-h3"><?php echo esc_html( get_the_title() ); ?></h2>
						<p class="t-body muted"><?php echo esc_html( wp_strip_all_tags( get_the_excerpt() ) ); ?></p>
					</div>
				</div>
				<a class="link-caret" href="<?php the_permalink(); ?>"><?php esc_html_e( 'Ler conteúdo', 'america' ); ?><?php america_icon( 'caret-right' ); ?></a>
			</article>
			<?php endwhile; ?>
		</div>
		<div class="entry__pagination">
			<?php
			echo wp_kses_post(
				(string) paginate_links(
					array(
						'prev_text' => __( '← Anteriores', 'america' ),
						'next_text' => __( 'Próximos →', 'america' ),
					)
				)
			);
			?>
		</div>

	<?php else : ?>
		<div class="entry">
			<h1 class="t-h2"><?php esc_html_e( 'Página não encontrada', 'america' ); ?></h1>
			<div class="t-body stack-p entry__content">
				<p><?php esc_html_e( 'O endereço pode ter mudado ou não existe mais.', 'america' ); ?></p>
				<p><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Voltar para a página inicial', 'america' ); ?></a></p>
			</div>
		</div>
	<?php endif; ?>
	</div>
</section>
<?php
get_footer();
