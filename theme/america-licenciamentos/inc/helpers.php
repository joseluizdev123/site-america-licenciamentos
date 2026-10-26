<?php
/**
 * Funções auxiliares: ícones, leitura do Personalizar, getters com fallback,
 * menus e o mini-framework dos meta boxes.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

/** Colunas da grade de logos (igual ao CSS: repeat(5, 1fr)). */
define( 'AMERICA_LOGO_COLS', 5 );

/* =========================================================
   Assets e ícones
   ========================================================= */

/**
 * URL de uma imagem do tema (assets/images/...).
 *
 * @param string $file Caminho relativo a assets/images/.
 * @return string
 */
function america_image_url( $file ) {
	return get_theme_file_uri( 'assets/images/' . ltrim( (string) $file, '/' ) );
}

/**
 * Markup de um ícone do sprite.
 *
 * @param string $name  Nome sem o prefixo "i-" (ex.: "phone", "doc-factory").
 * @param string $extra Classes extras (ex.: "icon--20").
 * @return string
 */
function america_get_icon( $name, $extra = '' ) {
	$class = trim( 'icon ' . $extra );
	return '<svg class="' . esc_attr( $class ) . '" aria-hidden="true"><use href="#i-' . esc_attr( $name ) . '"/></svg>';
}

/**
 * Imprime um ícone do sprite: <svg class="icon" aria-hidden="true"><use href="#i-NAME"/></svg>.
 *
 * @param string $name  Nome do símbolo sem "i-".
 * @param string $extra Classes extras.
 */
function america_icon( $name, $extra = '' ) {
	echo america_get_icon( $name, $extra ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- escapado em america_get_icon().
}

/**
 * Imprime o sprite SVG inline (arquivo estático do próprio tema), logo após <body>.
 */
function america_sprite() {
	$path = get_theme_file_path( 'assets/icons/sprite.svg' );
	if ( ! is_readable( $path ) ) {
		return;
	}
	echo file_get_contents( $path ) . "\n"; // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents, WordPress.Security.EscapeOutput.OutputNotEscaped -- SVG estático versionado com o tema.
}

/* =========================================================
   Personalizar
   ========================================================= */

/**
 * Valor de um campo do Personalizar, com o texto do layout como fallback
 * (também quando o campo foi salvo em branco).
 *
 * @param string $key Chave sem o prefixo "amr_".
 * @return string
 */
function america_mod( $key ) {
	$fields  = america_customizer_fields();
	$default = isset( $fields[ $key ] ) ? $fields[ $key ]['default'] : '';
	$value   = get_theme_mod( 'amr_' . $key, $default );
	if ( ! is_scalar( $value ) || '' === trim( (string) $value ) ) {
		return $default;
	}
	return (string) $value;
}

/**
 * Imprime um campo de texto escapado.
 *
 * @param string $key Chave.
 */
function america_mod_e( $key ) {
	echo esc_html( america_mod( $key ) );
}

/**
 * Imprime um campo de link escapado (âncoras viram /#ancora fora da home).
 *
 * @param string $key Chave.
 */
function america_mod_url_e( $key ) {
	echo esc_url( america_url( america_mod( $key ) ) );
}

/**
 * Imagem do Personalizar: mídia escolhida ou a imagem original do tema.
 *
 * @param string $key Chave do campo "image".
 * @return array{url:string,alt:string}
 */
function america_mod_image( $key ) {
	$fields = america_customizer_fields();
	$field  = isset( $fields[ $key ] ) ? $fields[ $key ] : array( 'default' => '', 'alt' => '' );
	$custom = america_attachment( get_theme_mod( 'amr_' . $key ) );
	if ( $custom ) {
		return array(
			'url' => $custom['url'],
			'alt' => $custom['alt'],
		);
	}
	return array(
		'url' => $field['default'] ? america_image_url( $field['default'] ) : '',
		'alt' => $field['alt'],
	);
}

/**
 * Modelo do hero escolhido no Personalizar: alternar | cidade | socio.
 * O parâmetro ?hero= da URL é aplicado no navegador (script no <head>), para apresentações.
 *
 * @return string
 */
function america_hero_mode() {
	$mode = america_mod( 'hero_mode' );
	return array_key_exists( $mode, america_hero_modes() ) ? $mode : 'alternar';
}

/* =========================================================
   Links, telefone, datas, imagens
   ========================================================= */

/**
 * Âncoras (#sobre) funcionam na home; nas páginas internas apontam para /#sobre.
 *
 * @param string $url URL ou âncora.
 * @return string
 */
function america_url( $url ) {
	$url = (string) $url;
	if ( strlen( $url ) > 1 && '#' === $url[0] && ! is_front_page() ) {
		return home_url( '/' . $url );
	}
	return $url;
}

/**
 * O link aponta para o início da home? (usado para aria-current="page" no menu).
 *
 * @param string $url URL.
 * @return bool
 */
function america_is_home_anchor( $url ) {
	$url  = untrailingslashit( (string) $url );
	$home = untrailingslashit( home_url( '/' ) );
	return in_array( $url, array( '#topo', $home, $home . '/#topo' ), true );
}

/**
 * Link tel: a partir do telefone exibido: "(11) 2099-2020" → "tel:+551120992020".
 *
 * @param string $phone Telefone.
 * @return string
 */
function america_tel_href( $phone ) {
	$digits = preg_replace( '/\D+/', '', (string) $phone );
	if ( '' === $digits ) {
		return '';
	}
	if ( strlen( $digits ) <= 11 ) {
		$digits = '55' . $digits;
	}
	return 'tel:+' . $digits;
}

/**
 * "2026-09-20" → "20 de setembro de 2026" (independe do idioma do site).
 *
 * @param string $ymd Data Y-m-d.
 * @return string
 */
function america_date_label( $ymd ) {
	$months = array( 1 => 'janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro' );
	$parts  = array_map( 'intval', explode( '-', (string) $ymd ) );
	if ( 3 !== count( $parts ) || empty( $months[ $parts[1] ] ) ) {
		return (string) $ymd;
	}
	return sprintf( '%d de %s de %d', $parts[2], $months[ $parts[1] ], $parts[0] );
}

/**
 * Dados de um anexo de imagem (tamanho original).
 *
 * @param int $attachment_id ID.
 * @return array{url:string,w:int,h:int,alt:string}|null
 */
function america_attachment( $attachment_id ) {
	$attachment_id = absint( $attachment_id );
	if ( ! $attachment_id ) {
		return null;
	}
	$src = wp_get_attachment_image_src( $attachment_id, 'full' );
	if ( ! $src ) {
		return null;
	}
	return array(
		'url' => $src[0],
		'w'   => (int) $src[1],
		'h'   => (int) $src[2],
		'alt' => trim( (string) get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ),
	);
}

/**
 * Atributos width/height (vazio se não houver medida).
 *
 * @param int $w Largura.
 * @param int $h Altura.
 * @return string
 */
function america_img_dims( $w, $h ) {
	$w = absint( $w );
	$h = absint( $h );
	if ( ! $w || ! $h ) {
		return '';
	}
	return ' width="' . esc_attr( $w ) . '" height="' . esc_attr( $h ) . '"';
}

/* =========================================================
   Grade de logos: linhas calculadas pela quantidade
   ========================================================= */

/**
 * Número de linhas da grade.
 *
 * @param int $count Quantidade de logos.
 * @return int
 */
function america_logo_rows( $count ) {
	return max( 1, (int) ceil( absint( $count ) / AMERICA_LOGO_COLS ) );
}

/**
 * Classes da <ul>: "logo-grid logo-grid--rows-N".
 * O CSS estático já trata N = 2 (faixa) e N = 4 (cases).
 *
 * @param int $count Quantidade.
 * @return string
 */
function america_logo_grid_class( $count ) {
	return 'logo-grid logo-grid--rows-' . america_logo_rows( $count );
}

/**
 * Classe de cada <li>. Para quantidades fora de 2/4 linhas, as células da última
 * linha recebem "logo-grid__cell--last" (sem borda inferior e sem marcador),
 * regra adicionada em america_inline_css().
 *
 * @param int $index Índice (0).
 * @param int $count Quantidade.
 * @return string
 */
function america_logo_cell_class( $index, $count ) {
	$rows  = america_logo_rows( $count );
	$class = 'logo-grid__cell';
	if ( ! in_array( $rows, array( 2, 4 ), true ) && $index >= ( $rows - 1 ) * AMERICA_LOGO_COLS ) {
		$class .= ' logo-grid__cell--last';
	}
	return $class;
}

/* =========================================================
   Getters com fallback para o conteúdo estático
   ========================================================= */

/**
 * O CPT já tem algum item publicado? Enquanto não tiver, a home usa o conteúdo do layout.
 *
 * @param string $post_type Tipo.
 * @return bool
 */
function america_cpt_has_content( $post_type ) {
	$counts = wp_count_posts( $post_type );
	return isset( $counts->publish ) && (int) $counts->publish > 0;
}

/**
 * Itens publicados de um CPT, na ordem do campo "Ordem".
 *
 * @param string $post_type Tipo.
 * @param array  $extra     Args extras de WP_Query.
 * @return WP_Post[]
 */
function america_query_cpt( $post_type, $extra = array() ) {
	return get_posts(
		array_merge(
			array(
				'post_type'        => $post_type,
				'post_status'      => 'publish',
				'posts_per_page'   => -1,
				'orderby'          => array(
					'menu_order' => 'ASC',
					'ID'         => 'ASC',
				),
				'no_found_rows'    => true,
				'suppress_filters' => false,
			),
			$extra
		)
	);
}

/**
 * Soluções (abas de documentos).
 *
 * @return array
 */
function america_get_solucoes() {
	$items = array();

	if ( ! america_cpt_has_content( 'amr_solucao' ) ) {
		foreach ( america_default_solucoes() as $d ) {
			$d['image'] = america_image_url( $d['image'] );
			$items[]    = $d;
		}
		return $items;
	}

	$icons = america_doc_icons();
	foreach ( america_query_cpt( 'amr_solucao' ) as $p ) {
		$img       = america_attachment( get_post_thumbnail_id( $p ) );
		$icon      = (string) get_post_meta( $p->ID, '_amr_icon', true );
		$link_text = (string) get_post_meta( $p->ID, '_amr_link_text', true );
		$link_url  = (string) get_post_meta( $p->ID, '_amr_link_url', true );

		$items[] = array(
			'slug'      => $p->post_name ? $p->post_name : 'doc-' . $p->ID,
			'title'     => $p->post_title,
			'icon'      => isset( $icons[ $icon ] ) ? $icon : 'file',
			'tight'     => '1' === get_post_meta( $p->ID, '_amr_tight', true ),
			'text'      => $p->post_excerpt,
			'link_text' => '' !== $link_text ? $link_text : 'Ver ' . $p->post_title,
			'link_url'  => '' !== $link_url ? $link_url : '#',
			'image'     => $img ? $img['url'] : '',
			'image_alt' => $img ? $img['alt'] : '',
		);
	}
	return $items;
}

/**
 * Clientes de uma área da home.
 *
 * @param string $slot 'faixa' (Empresas que confiam) ou 'grade' (Cases).
 * @return array [name, logo, w, h]
 */
function america_get_clientes( $slot ) {
	$slot  = 'faixa' === $slot ? 'faixa' : 'grade';
	$items = array();

	if ( ! america_cpt_has_content( 'amr_cliente' ) ) {
		foreach ( america_default_clientes( $slot ) as $d ) {
			$items[] = array(
				'name' => $d['name'],
				'logo' => america_image_url( $d['file'] ),
				'w'    => $d['w'],
				'h'    => $d['h'],
			);
		}
		return $items;
	}

	$posts = america_query_cpt(
		'amr_cliente',
		array(
			'meta_key'   => '_amr_' . $slot, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value' => '1', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
		)
	);

	foreach ( $posts as $p ) {
		$img = america_attachment( get_post_thumbnail_id( $p ) );
		if ( ! $img ) {
			continue;
		}
		$w = absint( get_post_meta( $p->ID, '_amr_logo_w', true ) );
		$h = absint( get_post_meta( $p->ID, '_amr_logo_h', true ) );
		if ( $w && ! $h && $img['w'] ) {
			$h = (int) round( $img['h'] * $w / $img['w'] );
		} elseif ( $h && ! $w && $img['h'] ) {
			$w = (int) round( $img['w'] * $h / $img['h'] );
		} elseif ( ! $w && ! $h ) {
			$w = $img['w'];
			$h = $img['h'];
		}
		$items[] = array(
			'name' => $p->post_title,
			'logo' => $img['url'],
			'w'    => $w,
			'h'    => $h,
		);
	}
	return $items;
}

/**
 * Nomes dos setores (taxonomia amr_setor), pelo campo "Ordem" do setor.
 *
 * @return string[]
 */
function america_get_setores() {
	$terms = get_terms(
		array(
			'taxonomy'   => 'amr_setor',
			'hide_empty' => false,
		)
	);
	if ( is_wp_error( $terms ) || empty( $terms ) ) {
		return america_default_setores();
	}
	usort(
		$terms,
		function ( $a, $b ) {
			$oa = (int) get_term_meta( $a->term_id, 'amr_ordem', true );
			$ob = (int) get_term_meta( $b->term_id, 'amr_ordem', true );
			$oa = $oa ? $oa : 999;
			$ob = $ob ? $ob : 999;
			if ( $oa === $ob ) {
				return strcmp( $a->name, $b->name );
			}
			return $oa < $ob ? -1 : 1;
		}
	);
	return wp_list_pluck( $terms, 'name' );
}

/**
 * Depoimentos.
 *
 * @return array [quote, name, role, logo, logo_alt]
 */
function america_get_depoimentos() {
	$items = array();

	if ( ! america_cpt_has_content( 'amr_depoimento' ) ) {
		foreach ( america_default_depoimentos() as $d ) {
			$items[] = array(
				'quote'    => $d['quote'],
				'name'     => $d['name'],
				'role'     => $d['role'],
				'logo'     => america_image_url( $d['logo'] ),
				'logo_alt' => $d['logo_alt'],
			);
		}
		return $items;
	}

	foreach ( america_query_cpt( 'amr_depoimento' ) as $p ) {
		$img     = america_attachment( get_post_thumbnail_id( $p ) );
		$items[] = array(
			'quote'    => trim( preg_replace( '/\s+/', ' ', wp_strip_all_tags( $p->post_content ) ) ),
			'name'     => $p->post_title,
			'role'     => (string) get_post_meta( $p->ID, '_amr_cargo', true ),
			'logo'     => $img ? $img['url'] : '',
			'logo_alt' => $img ? $img['alt'] : '',
		);
	}
	return $items;
}

/**
 * Perguntas frequentes. 'answer' já vem em HTML de parágrafos (escapar com wp_kses_post).
 *
 * @return array [question, answer, wide]
 */
function america_get_faqs() {
	$items = array();

	if ( ! america_cpt_has_content( 'amr_faq' ) ) {
		foreach ( america_default_faqs() as $d ) {
			$items[] = array(
				'question' => $d['question'],
				'answer'   => wpautop( esc_html( implode( "\n\n", $d['answer'] ) ) ),
				'wide'     => $d['wide'],
			);
		}
		return $items;
	}

	foreach ( america_query_cpt( 'amr_faq' ) as $p ) {
		$items[] = array(
			'question' => $p->post_title,
			'answer'   => wpautop( $p->post_content ),
			'wide'     => '1' === get_post_meta( $p->ID, '_amr_gap_largo', true ),
		);
	}
	return $items;
}

/**
 * Posts do carrossel "Conteúdos": últimos posts com imagem destacada.
 *
 * @return array [title, excerpt, cat, date, date_label, image, image_alt, url]
 */
function america_get_blog_posts() {
	$posts = get_posts(
		array(
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => (int) apply_filters( 'america_blog_posts_count', 6 ),
			'ignore_sticky_posts' => true,
			'no_found_rows'       => true,
			'meta_query'          => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
				array(
					'key'     => '_thumbnail_id',
					'compare' => 'EXISTS',
				),
			),
		)
	);

	$items = array();

	if ( empty( $posts ) ) {
		foreach ( america_default_posts() as $d ) {
			$items[] = array(
				'title'      => $d['title'],
				'excerpt'    => $d['excerpt'],
				'cat'        => $d['cat'],
				'date'       => $d['date'],
				'date_label' => america_date_label( $d['date'] ),
				'image'      => america_image_url( $d['image'] ),
				'image_alt'  => $d['image_alt'],
				'url'        => '#conteudos',
			);
		}
		return $items;
	}

	foreach ( $posts as $p ) {
		$img     = america_attachment( get_post_thumbnail_id( $p ) );
		$cats    = get_the_category( $p->ID );
		$ymd     = get_the_date( 'Y-m-d', $p );
		$excerpt = has_excerpt( $p ) ? $p->post_excerpt : wp_trim_words( wp_strip_all_tags( strip_shortcodes( $p->post_content ) ), 22, '…' );

		$items[] = array(
			'title'      => $p->post_title,
			'excerpt'    => $excerpt,
			'cat'        => $cats ? $cats[0]->name : '',
			'date'       => $ymd,
			'date_label' => america_date_label( $ymd ),
			'image'      => $img ? $img['url'] : '',
			'image_alt'  => $img ? $img['alt'] : '',
			'url'        => get_permalink( $p ),
		);
	}
	return $items;
}

/* =========================================================
   Menus (markup idêntico ao estático: <a> soltos no topo, <li><a> no rodapé)
   ========================================================= */

if ( class_exists( 'Walker_Nav_Menu' ) && ! class_exists( 'America_Nav_Walker' ) ) {
	/**
	 * Walker plano, sem classes nem IDs extras.
	 */
	class America_Nav_Walker extends Walker_Nav_Menu {

		/**
		 * Envolver cada link em <li>?
		 *
		 * @var bool
		 */
		private $wrap_li;

		/**
		 * Construtor.
		 *
		 * @param bool $wrap_li Envolver em <li>.
		 */
		public function __construct( $wrap_li = false ) {
			$this->wrap_li = (bool) $wrap_li;
		}

		/**
		 * Sem submenus.
		 *
		 * @param string   $output Saída.
		 * @param int      $depth  Profundidade.
		 * @param stdClass $args   Args.
		 */
		public function start_lvl( &$output, $depth = 0, $args = null ) {}

		/**
		 * Sem submenus.
		 *
		 * @param string   $output Saída.
		 * @param int      $depth  Profundidade.
		 * @param stdClass $args   Args.
		 */
		public function end_lvl( &$output, $depth = 0, $args = null ) {}

		/**
		 * Abre o item.
		 *
		 * @param string   $output            Saída.
		 * @param WP_Post  $data_object       Item do menu.
		 * @param int      $depth             Profundidade.
		 * @param stdClass $args              Args.
		 * @param int      $current_object_id ID atual.
		 */
		public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
			$item    = $data_object;
			$current = ! $this->wrap_li && ( ! empty( $item->current ) || ( is_front_page() && america_is_home_anchor( $item->url ) ) );
			$target  = ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '" rel="noopener"' : '';

			$link = '<a href="' . esc_url( america_url( $item->url ) ) . '"' . ( $current ? ' aria-current="page"' : '' ) . $target . '>' . esc_html( $item->title ) . '</a>';

			$output .= ( $this->wrap_li ? '<li>' . $link : $link );
		}

		/**
		 * Fecha o item.
		 *
		 * @param string   $output      Saída.
		 * @param WP_Post  $data_object Item.
		 * @param int      $depth       Profundidade.
		 * @param stdClass $args        Args.
		 */
		public function end_el( &$output, $data_object, $depth = 0, $args = null ) {
			$output .= ( $this->wrap_li ? '</li>' : '' ) . "\n";
		}
	}
}

/**
 * URL padrão de um item de menu (o item "privacy" usa a página de privacidade do WP, se houver).
 *
 * @param array $item [rótulo, url, especial?].
 * @return string
 */
function america_default_menu_item_url( $item ) {
	if ( isset( $item[2] ) && 'privacy' === $item[2] ) {
		$privacy = get_privacy_policy_url();
		if ( $privacy ) {
			return $privacy;
		}
	}
	return $item[1];
}

/**
 * Imprime um menu: o cadastrado em Aparência → Menus ou, sem ele, os links do layout.
 *
 * @param string $location Local do menu.
 * @param bool   $wrap_li  true no rodapé (<li><a>), false no topo (<a>).
 */
function america_menu( $location, $wrap_li = false ) {
	if ( has_nav_menu( $location ) && class_exists( 'America_Nav_Walker' ) ) {
		wp_nav_menu(
			array(
				'theme_location' => $location,
				'container'      => false,
				'items_wrap'     => '%3$s',
				'depth'          => 1,
				'fallback_cb'    => false,
				'walker'         => new America_Nav_Walker( $wrap_li ),
			)
		);
		return;
	}

	$menus = america_default_menus();
	if ( empty( $menus[ $location ] ) ) {
		return;
	}
	foreach ( $menus[ $location ]['items'] as $item ) {
		$url     = america_default_menu_item_url( $item );
		$current = ! $wrap_li && is_front_page() && america_is_home_anchor( $url );
		$link    = '<a href="' . esc_url( america_url( $url ) ) . '"' . ( $current ? ' aria-current="page"' : '' ) . '>' . esc_html( $item[0] ) . '</a>';
		echo ( $wrap_li ? '<li>' . $link . '</li>' : $link ) . "\n"; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- partes escapadas acima.
	}
}

/* =========================================================
   Meta boxes nativos (nonce + sanitização por tipo)
   ========================================================= */

/**
 * Renderiza os campos de um meta box.
 * Campo: [label, type (text|url|number|select|checkbox), help?, options?, default?, checkbox_label?].
 *
 * @param WP_Post $post   Post.
 * @param string  $box    ID do box (usado no nonce).
 * @param array   $fields meta_key => campo.
 */
function america_meta_box_render( $post, $box, $fields ) {
	wp_nonce_field( 'america_save_' . $box, 'america_nonce_' . $box );
	$is_new = 'auto-draft' === $post->post_status;

	echo '<table class="form-table" role="presentation"><tbody>';
	foreach ( $fields as $key => $f ) {
		$value = (string) get_post_meta( $post->ID, $key, true );
		if ( $is_new && '' === $value && isset( $f['default'] ) ) {
			$value = (string) $f['default'];
		}
		$id = 'america' . str_replace( '_', '-', $key );

		echo '<tr><th scope="row">';
		if ( 'checkbox' === $f['type'] ) {
			echo esc_html( $f['label'] );
		} else {
			echo '<label for="' . esc_attr( $id ) . '">' . esc_html( $f['label'] ) . '</label>';
		}
		echo '</th><td>';

		switch ( $f['type'] ) {
			case 'select':
				echo '<select id="' . esc_attr( $id ) . '" name="' . esc_attr( $key ) . '">';
				foreach ( $f['options'] as $opt_value => $opt_label ) {
					echo '<option value="' . esc_attr( $opt_value ) . '"' . selected( $value, (string) $opt_value, false ) . '>' . esc_html( $opt_label ) . '</option>';
				}
				echo '</select>';
				break;

			case 'checkbox':
				echo '<label for="' . esc_attr( $id ) . '"><input type="checkbox" id="' . esc_attr( $id ) . '" name="' . esc_attr( $key ) . '" value="1"' . checked( '1', $value, false ) . '> ' . esc_html( isset( $f['checkbox_label'] ) ? $f['checkbox_label'] : $f['label'] ) . '</label>';
				break;

			case 'number':
				echo '<input type="number" min="0" step="1" class="small-text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '"> px';
				break;

			default: // text e url (url aceita âncoras como #contato).
				echo '<input type="text" class="regular-text" id="' . esc_attr( $id ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( $value ) . '">';
		}

		if ( ! empty( $f['help'] ) ) {
			echo '<p class="description">' . esc_html( $f['help'] ) . '</p>';
		}
		echo '</td></tr>';
	}
	echo '</tbody></table>';
}

/**
 * Salva os campos de um meta box, com verificação de nonce, autosave e permissão.
 *
 * @param int    $post_id ID.
 * @param string $box     ID do box.
 * @param array  $fields  meta_key => campo.
 */
function america_meta_box_save( $post_id, $box, $fields ) {
	$nonce_key = 'america_nonce_' . $box;
	if ( ! isset( $_POST[ $nonce_key ] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST[ $nonce_key ] ) ), 'america_save_' . $box ) ) {
		return;
	}
	if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) || wp_is_post_revision( $post_id ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( $fields as $key => $f ) {
		// phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitizado por tipo logo abaixo.
		$raw = isset( $_POST[ $key ] ) ? wp_unslash( $_POST[ $key ] ) : '';
		$raw = is_scalar( $raw ) ? trim( (string) $raw ) : '';

		switch ( $f['type'] ) {
			case 'checkbox':
				$value = '' === $raw ? '0' : '1';
				break;
			case 'url':
				$value = esc_url_raw( $raw );
				break;
			case 'number':
				$value = '' === $raw ? '' : (string) absint( $raw );
				break;
			case 'select':
				$value = array_key_exists( $raw, $f['options'] ) ? $raw : ( isset( $f['default'] ) ? (string) $f['default'] : '' );
				break;
			default:
				$value = sanitize_text_field( $raw );
		}

		if ( '' === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}

/* =========================================================
   Admin: ordem padrão, coluna "Ordem" e textos de ajuda
   ========================================================= */

/**
 * CPTs do tema.
 *
 * @return string[]
 */
function america_cpts() {
	return array( 'amr_solucao', 'amr_cliente', 'amr_depoimento', 'amr_faq' );
}

/**
 * Lista do admin ordenada como na home (campo "Ordem").
 *
 * @param WP_Query $query Query.
 */
function america_admin_default_order( $query ) {
	global $pagenow;
	if ( ! is_admin() || ! $query->is_main_query() || 'edit.php' !== $pagenow ) {
		return;
	}
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- apenas leitura da ordenação da lista.
	if ( isset( $_GET['orderby'] ) ) {
		return;
	}
	if ( in_array( $query->get( 'post_type' ), america_cpts(), true ) ) {
		$query->set(
			'orderby',
			array(
				'menu_order' => 'ASC',
				'ID'         => 'ASC',
			)
		);
	}
}
add_action( 'pre_get_posts', 'america_admin_default_order' );

/**
 * Coluna "Ordem" nas listas dos CPTs.
 */
function america_admin_order_columns() {
	foreach ( america_cpts() as $pt ) {
		add_filter(
			"manage_{$pt}_posts_columns",
			function ( $columns ) {
				$columns['america_ordem'] = __( 'Ordem', 'america' );
				return $columns;
			}
		);
		add_action(
			"manage_{$pt}_posts_custom_column",
			function ( $column, $post_id ) {
				if ( 'america_ordem' === $column ) {
					echo esc_html( (string) get_post_field( 'menu_order', $post_id ) );
				}
			},
			10,
			2
		);
	}
}
add_action( 'admin_init', 'america_admin_order_columns' );

/**
 * Texto de ajuda no topo da tela de edição.
 *
 * @param WP_Post $post Post.
 */
function america_admin_edit_help( $post ) {
	$help = array(
		'amr_solucao'    => __( 'Cada solução é uma aba da seção “Segurança regulatória para sua empresa”. O título vira o nome da aba, o Resumo é o texto que aparece com a aba aberta e a Imagem da aba aparece ao lado. A posição segue o campo “Ordem” (menor primeiro).', 'america' ),
		'amr_cliente'    => __( 'Envie o logo em “Logo do cliente” (PNG com fundo transparente). Marque onde ele aparece na página inicial. A posição segue o campo “Ordem”.', 'america' ),
		'amr_depoimento' => __( 'O título é o nome da pessoa. Escreva a citação na caixa de texto, com as aspas. O logo da empresa vai em “Logo da empresa”.', 'america' ),
		'amr_faq'        => __( 'O título é a pergunta e a caixa de texto é a resposta (separe parágrafos com uma linha em branco). A posição segue o campo “Ordem”.', 'america' ),
	);
	if ( isset( $help[ $post->post_type ] ) ) {
		echo '<p class="description" style="margin:12px 0 0">' . esc_html( $help[ $post->post_type ] ) . '</p>';
	}
}
add_action( 'edit_form_after_title', 'america_admin_edit_help' );

/**
 * Placeholder do título por CPT.
 *
 * @param string  $text Placeholder.
 * @param WP_Post $post Post.
 * @return string
 */
function america_admin_title_placeholder( $text, $post ) {
	$placeholders = array(
		'amr_solucao'    => __( 'Nome do documento (ex.: Alvará de funcionamento)', 'america' ),
		'amr_cliente'    => __( 'Nome do cliente', 'america' ),
		'amr_depoimento' => __( 'Nome da pessoa', 'america' ),
		'amr_faq'        => __( 'Pergunta', 'america' ),
	);
	return isset( $placeholders[ $post->post_type ] ) ? $placeholders[ $post->post_type ] : $text;
}
add_filter( 'enter_title_here', 'america_admin_title_placeholder', 10, 2 );
