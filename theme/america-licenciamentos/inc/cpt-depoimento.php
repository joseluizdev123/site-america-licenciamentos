<?php
/**
 * CPT amr_depoimento.
 *
 * Campos: nome (título), citação (conteúdo), cargo/empresa, logo (destacada), ordem.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra o CPT.
 */
function america_register_cpt_depoimento() {
	register_post_type(
		'amr_depoimento',
		array(
			'labels'              => array(
				'name'                  => __( 'Depoimentos', 'america' ),
				'singular_name'         => __( 'Depoimento', 'america' ),
				'menu_name'             => __( 'Depoimentos', 'america' ),
				'all_items'             => __( 'Todos os depoimentos', 'america' ),
				'add_new'               => __( 'Adicionar novo', 'america' ),
				'add_new_item'          => __( 'Adicionar novo depoimento', 'america' ),
				'edit_item'             => __( 'Editar depoimento', 'america' ),
				'new_item'              => __( 'Novo depoimento', 'america' ),
				'view_item'             => __( 'Ver depoimento', 'america' ),
				'search_items'          => __( 'Buscar depoimentos', 'america' ),
				'not_found'             => __( 'Nenhum depoimento encontrado.', 'america' ),
				'not_found_in_trash'    => __( 'Nenhum depoimento na lixeira.', 'america' ),
				'featured_image'        => __( 'Logo da empresa', 'america' ),
				'set_featured_image'    => __( 'Definir logo da empresa', 'america' ),
				'remove_featured_image' => __( 'Remover logo', 'america' ),
				'use_featured_image'    => __( 'Usar como logo', 'america' ),
				'item_published'        => __( 'Depoimento publicado.', 'america' ),
				'item_updated'          => __( 'Depoimento atualizado.', 'america' ),
			),
			'description'         => __( 'Carrossel de depoimentos da página inicial.', 'america' ),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => false,
			'menu_position'       => 23,
			'menu_icon'           => 'dashicons-format-quote',
			'supports'            => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		)
	);
}
add_action( 'init', 'america_register_cpt_depoimento' );

/**
 * Campos do meta box.
 *
 * @return array
 */
function america_depoimento_fields() {
	return array(
		'_amr_cargo' => array(
			'label' => __( 'Cargo e empresa', 'america' ),
			'type'  => 'text',
			'help'  => __( 'Ex.: “Sócia Diretora, Mirpo Auto Peças”.', 'america' ),
		),
	);
}

/**
 * Adiciona o meta box.
 */
function america_depoimento_add_meta_box() {
	add_meta_box(
		'america_depoimento_detalhes',
		__( 'Quem é a pessoa', 'america' ),
		function ( $post ) {
			america_meta_box_render( $post, 'depoimento', america_depoimento_fields() );
		},
		'amr_depoimento',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_amr_depoimento', 'america_depoimento_add_meta_box' );

/**
 * Salva o meta box.
 *
 * @param int $post_id ID.
 */
function america_depoimento_save( $post_id ) {
	america_meta_box_save( $post_id, 'depoimento', america_depoimento_fields() );
}
add_action( 'save_post_amr_depoimento', 'america_depoimento_save' );
