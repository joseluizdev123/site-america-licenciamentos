<?php
/**
 * CPT amr_faq: perguntas frequentes.
 *
 * Campos: pergunta (título), resposta (conteúdo), ordem (menu_order)
 * e um ajuste fino de espaçamento da seta.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra o CPT.
 */
function america_register_cpt_faq() {
	register_post_type(
		'amr_faq',
		array(
			'labels'              => array(
				'name'               => __( 'Perguntas frequentes', 'america' ),
				'singular_name'      => __( 'Pergunta frequente', 'america' ),
				'menu_name'          => __( 'Perguntas frequentes', 'america' ),
				'all_items'          => __( 'Todas as perguntas', 'america' ),
				'add_new'            => __( 'Adicionar nova', 'america' ),
				'add_new_item'       => __( 'Adicionar nova pergunta', 'america' ),
				'edit_item'          => __( 'Editar pergunta', 'america' ),
				'new_item'           => __( 'Nova pergunta', 'america' ),
				'view_item'          => __( 'Ver pergunta', 'america' ),
				'search_items'       => __( 'Buscar perguntas', 'america' ),
				'not_found'          => __( 'Nenhuma pergunta encontrada.', 'america' ),
				'not_found_in_trash' => __( 'Nenhuma pergunta na lixeira.', 'america' ),
				'item_published'     => __( 'Pergunta publicada.', 'america' ),
				'item_updated'       => __( 'Pergunta atualizada.', 'america' ),
			),
			'description'         => __( 'Perguntas e respostas da página inicial.', 'america' ),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => false,
			'menu_position'       => 24,
			'menu_icon'           => 'dashicons-editor-help',
			'supports'            => array( 'title', 'editor', 'page-attributes' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		)
	);
}
add_action( 'init', 'america_register_cpt_faq' );

/**
 * Campos do meta box.
 *
 * @return array
 */
function america_faq_fields() {
	return array(
		'_amr_gap_largo' => array(
			'label'          => __( 'Ajuste de layout', 'america' ),
			'type'           => 'checkbox',
			'checkbox_label' => __( 'Afastar a seta do texto da pergunta (32px)', 'america' ),
			'help'           => __( 'Ajuste fino do layout original para perguntas longas; normalmente pode ficar desmarcado.', 'america' ),
		),
	);
}

/**
 * Adiciona o meta box.
 */
function america_faq_add_meta_box() {
	add_meta_box(
		'america_faq_detalhes',
		__( 'Ajustes', 'america' ),
		function ( $post ) {
			america_meta_box_render( $post, 'faq', america_faq_fields() );
		},
		'amr_faq',
		'normal',
		'default'
	);
}
add_action( 'add_meta_boxes_amr_faq', 'america_faq_add_meta_box' );

/**
 * Salva o meta box.
 *
 * @param int $post_id ID.
 */
function america_faq_save( $post_id ) {
	america_meta_box_save( $post_id, 'faq', america_faq_fields() );
}
add_action( 'save_post_amr_faq', 'america_faq_save' );
