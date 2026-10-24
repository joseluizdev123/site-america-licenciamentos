<?php
/**
 * CPT amr_cliente + taxonomia amr_setor.
 *
 * Campos: nome (título), logo (destacada), largura/altura de exibição, setor,
 * exibir na faixa "Empresas que confiam", exibir na grade de cases, ordem (menu_order).
 *
 * Observação: o layout usa arquivos de logo e tamanhos diferentes na faixa e na grade,
 * por isso cada área tem sua própria marcação (um cliente pode estar nas duas).
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra CPT e taxonomia.
 */
function america_register_cpt_cliente() {
	register_post_type(
		'amr_cliente',
		array(
			'labels'              => array(
				'name'                  => __( 'Clientes', 'america' ),
				'singular_name'         => __( 'Cliente', 'america' ),
				'menu_name'             => __( 'Clientes', 'america' ),
				'all_items'             => __( 'Todos os clientes', 'america' ),
				'add_new'               => __( 'Adicionar novo', 'america' ),
				'add_new_item'          => __( 'Adicionar novo cliente', 'america' ),
				'edit_item'             => __( 'Editar cliente', 'america' ),
				'new_item'              => __( 'Novo cliente', 'america' ),
				'view_item'             => __( 'Ver cliente', 'america' ),
				'search_items'          => __( 'Buscar clientes', 'america' ),
				'not_found'             => __( 'Nenhum cliente encontrado.', 'america' ),
				'not_found_in_trash'    => __( 'Nenhum cliente na lixeira.', 'america' ),
				'featured_image'        => __( 'Logo do cliente', 'america' ),
				'set_featured_image'    => __( 'Definir logo', 'america' ),
				'remove_featured_image' => __( 'Remover logo', 'america' ),
				'use_featured_image'    => __( 'Usar como logo', 'america' ),
				'item_published'        => __( 'Cliente publicado.', 'america' ),
				'item_updated'          => __( 'Cliente atualizado.', 'america' ),
			),
			'description'         => __( 'Logos da faixa “Empresas que confiam” e da grade de cases.', 'america' ),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => false,
			'menu_position'       => 22,
			'menu_icon'           => 'dashicons-groups',
			'supports'            => array( 'title', 'thumbnail', 'page-attributes' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		)
	);

	register_taxonomy(
		'amr_setor',
		array( 'amr_cliente' ),
		array(
			'labels'            => array(
				'name'          => __( 'Setores', 'america' ),
				'singular_name' => __( 'Setor', 'america' ),
				'menu_name'     => __( 'Setores', 'america' ),
				'all_items'     => __( 'Todos os setores', 'america' ),
				'edit_item'     => __( 'Editar setor', 'america' ),
				'view_item'     => __( 'Ver setor', 'america' ),
				'update_item'   => __( 'Atualizar setor', 'america' ),
				'add_new_item'  => __( 'Adicionar novo setor', 'america' ),
				'new_item_name' => __( 'Nome do novo setor', 'america' ),
				'search_items'  => __( 'Buscar setores', 'america' ),
				'not_found'     => __( 'Nenhum setor encontrado.', 'america' ),
				'back_to_items' => __( '← Voltar para os setores', 'america' ),
			),
			'description'       => __( 'Setores exibidos na faixa acima da grade de cases.', 'america' ),
			'public'            => false,
			'show_ui'           => true,
			'show_in_menu'      => true,
			'show_in_nav_menus' => false,
			'show_in_rest'      => false,
			'show_admin_column' => true,
			'hierarchical'      => true, // Caixas de seleção no admin.
			'rewrite'           => false,
			'query_var'         => false,
		)
	);
}
add_action( 'init', 'america_register_cpt_cliente' );

/**
 * Campos do meta box.
 *
 * @return array
 */
function america_cliente_fields() {
	return array(
		'_amr_faixa'  => array(
			'label'          => __( 'Faixa do topo', 'america' ),
			'type'           => 'checkbox',
			'checkbox_label' => __( 'Exibir na faixa “Empresas que confiam em nós”', 'america' ),
		),
		'_amr_grade'  => array(
			'label'          => __( 'Grade de cases', 'america' ),
			'type'           => 'checkbox',
			'default'        => '1',
			'checkbox_label' => __( 'Exibir na grade “Experiências de quem contou com a América”', 'america' ),
		),
		'_amr_logo_w' => array(
			'label' => __( 'Largura de exibição', 'america' ),
			'type'  => 'number',
			'help'  => __( 'Em pixels. Em branco: usa o tamanho do arquivo (ou calcula pela altura).', 'america' ),
		),
		'_amr_logo_h' => array(
			'label' => __( 'Altura de exibição', 'america' ),
			'type'  => 'number',
			'help'  => __( 'Em pixels. Os logos do layout têm entre 24 e 56 px de altura.', 'america' ),
		),
	);
}

/**
 * Adiciona o meta box.
 */
function america_cliente_add_meta_box() {
	add_meta_box(
		'america_cliente_detalhes',
		__( 'Onde aparece e tamanho do logo', 'america' ),
		function ( $post ) {
			america_meta_box_render( $post, 'cliente', america_cliente_fields() );
		},
		'amr_cliente',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_amr_cliente', 'america_cliente_add_meta_box' );

/**
 * Salva o meta box.
 *
 * @param int $post_id ID.
 */
function america_cliente_save( $post_id ) {
	america_meta_box_save( $post_id, 'cliente', america_cliente_fields() );
}
add_action( 'save_post_amr_cliente', 'america_cliente_save' );

/**
 * Colunas "Logo" e "Onde aparece" na lista de clientes.
 *
 * @param array $columns Colunas.
 * @return array
 */
function america_cliente_columns( $columns ) {
	$new = array();
	foreach ( $columns as $key => $label ) {
		if ( 'title' === $key ) {
			$new['america_logo'] = __( 'Logo', 'america' );
		}
		$new[ $key ] = $label;
		if ( 'title' === $key ) {
			$new['america_onde'] = __( 'Onde aparece', 'america' );
		}
	}
	return $new;
}
add_filter( 'manage_amr_cliente_posts_columns', 'america_cliente_columns' );

/**
 * Conteúdo das colunas.
 *
 * @param string $column  Coluna.
 * @param int    $post_id ID.
 */
function america_cliente_column_content( $column, $post_id ) {
	if ( 'america_logo' === $column ) {
		$img = america_attachment( get_post_thumbnail_id( $post_id ) );
		if ( $img ) {
			echo '<img src="' . esc_url( $img['url'] ) . '" alt="" style="max-width:96px;max-height:40px;width:auto;height:auto">';
		} else {
			echo '<span aria-hidden="true">—</span>';
		}
	}
	if ( 'america_onde' === $column ) {
		$where = array();
		if ( '1' === get_post_meta( $post_id, '_amr_faixa', true ) ) {
			$where[] = __( 'Faixa do topo', 'america' );
		}
		if ( '1' === get_post_meta( $post_id, '_amr_grade', true ) ) {
			$where[] = __( 'Grade de cases', 'america' );
		}
		echo esc_html( $where ? implode( ', ', $where ) : __( 'Não aparece', 'america' ) );
	}
}
add_action( 'manage_amr_cliente_posts_custom_column', 'america_cliente_column_content', 10, 2 );

/* ---------- Setor: campo "Ordem" ---------- */

/**
 * Campo "Ordem" na tela de novo setor.
 */
function america_setor_add_fields() {
	wp_nonce_field( 'america_save_setor', 'america_nonce_setor' );
	?>
	<div class="form-field">
		<label for="america-setor-ordem"><?php esc_html_e( 'Ordem', 'america' ); ?></label>
		<input type="number" min="0" step="1" id="america-setor-ordem" name="amr_ordem" value="">
		<p><?php esc_html_e( 'Posição na faixa de setores (menor primeiro).', 'america' ); ?></p>
	</div>
	<?php
}
add_action( 'amr_setor_add_form_fields', 'america_setor_add_fields' );

/**
 * Campo "Ordem" na edição do setor.
 *
 * @param WP_Term $term Termo.
 */
function america_setor_edit_fields( $term ) {
	$value = get_term_meta( $term->term_id, 'amr_ordem', true );
	?>
	<tr class="form-field">
		<th scope="row"><label for="america-setor-ordem"><?php esc_html_e( 'Ordem', 'america' ); ?></label></th>
		<td>
			<?php wp_nonce_field( 'america_save_setor', 'america_nonce_setor' ); ?>
			<input type="number" min="0" step="1" id="america-setor-ordem" name="amr_ordem" value="<?php echo esc_attr( $value ); ?>">
			<p class="description"><?php esc_html_e( 'Posição na faixa de setores (menor primeiro).', 'america' ); ?></p>
		</td>
	</tr>
	<?php
}
add_action( 'amr_setor_edit_form_fields', 'america_setor_edit_fields' );

/**
 * Salva a ordem do setor.
 *
 * @param int $term_id ID.
 */
function america_setor_save( $term_id ) {
	if ( ! isset( $_POST['america_nonce_setor'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['america_nonce_setor'] ) ), 'america_save_setor' ) ) {
		return;
	}
	if ( ! current_user_can( 'edit_term', $term_id ) ) {
		return;
	}
	$raw = isset( $_POST['amr_ordem'] ) ? trim( sanitize_text_field( wp_unslash( $_POST['amr_ordem'] ) ) ) : '';
	if ( '' === $raw ) {
		delete_term_meta( $term_id, 'amr_ordem' );
	} else {
		update_term_meta( $term_id, 'amr_ordem', absint( $raw ) );
	}
}
add_action( 'created_amr_setor', 'america_setor_save' );
add_action( 'edited_amr_setor', 'america_setor_save' );
