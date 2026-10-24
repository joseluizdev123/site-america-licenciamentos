<?php
/**
 * Fechamento do <main> + rodapé (seção 14 · Figma 7053:1035).
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

$america_logo    = america_mod_image( 'logo_footer' );
$america_phone   = america_mod( 'phone' );
$america_email   = america_mod( 'email' );
$america_columns = array(
	'rodape-1' => america_mod( 'footer_col_1_title' ),
	'rodape-2' => america_mod( 'footer_col_2_title' ),
	'rodape-3' => america_mod( 'footer_col_3_title' ),
);
$america_social  = array(
	'instagram' => 'Instagram',
	'linkedin'  => 'LinkedIn',
	'facebook'  => 'Facebook',
);
?>
</main>

<footer class="card-section site-footer" id="contato">
	<div class="card-section__inner">
		<div class="container">
			<div class="footer__top">
				<a class="footer__logo" href="<?php echo esc_url( america_url( '#topo' ) ); ?>"><img src="<?php echo esc_url( $america_logo['url'] ); ?>" width="241" height="80" alt="<?php echo esc_attr( $america_logo['alt'] ? $america_logo['alt'] : 'América Licenciamentos' ); ?>"></a>
				<div class="footer__about">
					<p><?php america_mod_e( 'footer_about' ); ?></p>
					<a class="link-caret link-caret--light" href="<?php america_mod_url_e( 'footer_link_url' ); ?>"><?php america_mod_e( 'footer_link_text' ); ?><?php america_icon( 'caret-right-20' ); ?></a>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="footer__nav">
				<?php foreach ( $america_columns as $america_location => $america_title ) : ?>
				<nav class="footer__col" aria-label="<?php echo esc_attr( $america_title ); ?>">
					<p class="footer__title"><?php echo esc_html( $america_title ); ?></p>
					<ul>
						<?php america_menu( $america_location, true ); ?>
					</ul>
				</nav>
				<?php endforeach; ?>
				<address class="footer__contact" style="font-style:normal">
					<p class="footer__title" style="color:var(--white);font-size:16px;line-height:24px"><?php america_mod_e( 'footer_contact_title' ); ?></p>
					<div>
						<a class="big" href="<?php echo esc_url( america_tel_href( $america_phone ) ); ?>"><?php echo esc_html( $america_phone ); ?></a>
						<a class="big" href="<?php echo esc_url( 'mailto:' . $america_email ); ?>"><?php echo esc_html( $america_email ); ?></a>
						<p><?php america_mod_e( 'hours' ); ?></p>
						<p><?php america_mod_e( 'address' ); ?></p>
					</div>
				</address>
			</div>
			<div class="footer__bottom">
				<div class="footer__bar">
					<a class="footer__totop" href="<?php echo esc_url( america_url( '#topo' ) ); ?>"><span class="icon-btn icon-btn--dark"><?php america_icon( 'arrow-line-up' ); ?></span><?php esc_html_e( 'Voltar ao topo', 'america' ); ?></a>
					<div class="footer__social">
						<span><?php esc_html_e( 'Social', 'america' ); ?></span>
						<ul>
							<?php
							foreach ( $america_social as $america_key => $america_label ) :
								$america_href     = america_mod( $america_key );
								$america_external = 0 === strpos( $america_href, 'http' );
								?>
							<li><a class="icon-btn icon-btn--dark" href="<?php echo esc_url( $america_href ); ?>" aria-label="<?php echo esc_attr( $america_label ); ?>"<?php echo $america_external ? ' target="_blank" rel="noopener"' : ''; ?>><?php america_icon( $america_key ); ?></a></li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
				<div class="footer__pattern"><div class="dot-pattern" aria-hidden="true"></div></div>
				<div class="footer__legal">
					<p><?php america_mod_e( 'legal' ); ?></p>
					<p class="footer__credit"><?php esc_html_e( 'Criado por', 'america' ); ?> <svg aria-label="Artemis" role="img"><use href="#i-artemis"/></svg></p>
				</div>
			</div>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
