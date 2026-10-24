<?php
/**
 * CPT amr_solucao: soluções / documentos (abas da seção "Segurança regulatória").
 *
 * Campos: título, resumo (excerpt), texto e URL do link, ícone, imagem da aba (destacada),
 * ordem (menu_order) e um ajuste fino de espaçamento.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

/**
 * Registra o CPT.
 */
function america_register_cpt_solucao() {
	register_post_type(
		'amr_solucao',
		array(
			'labels'              => array(
				'name'                  => __( 'Soluções', 'america' ),
				'singular_name'         => __( 'Solução', 'america' ),
				'menu_name'             => __( 'Soluções', 'america' ),
				'all_items'             => __( 'Todas as soluções', 'america' ),
				'add_new'               => __( 'Adicionar nova', 'america' ),
				'add_new_item'          => __( 'Adicionar nova solução', 'america' ),
				'edit_item'             => __( 'Editar solução', 'america' ),
				'new_item'              => __( 'Nova solução', 'america' ),
				'view_item'             => __( 'Ver solução', 'america' ),
				'search_items'          => __( 'Buscar soluções', 'america' ),
				'not_found'             => __( 'Nenhuma solução encontrada.', 'america' ),
				'not_found_in_trash'    => __( 'Nenhuma solução na lixeira.', 'america' ),
				'featured_image'        => __( 'Imagem da aba', 'america' ),
				'set_featured_image'    => __( 'Definir imagem da aba', 'america' ),
				'remove_featured_image' => __( 'Remover imagem da aba', 'america' ),
				'use_featured_image'    => __( 'Usar como imagem da aba', 'america' ),
				'item_published'        => __( 'Solução publicada.', 'america' ),
				'item_updated'          => __( 'Solução atualizada.', 'america' ),
			),
			'description'         => __( 'Abas da seção de documentos da página inicial.', 'america' ),
			'public'              => false,
			'publicly_queryable'  => false,
			'exclude_from_search' => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_rest'        => false,
			'menu_position'       => 21,
			'menu_icon'           => 'dashicons-media-document',
			'supports'            => array( 'title', 'excerpt', 'thumbnail', 'page-attributes' ),
			'has_archive'         => false,
			'rewrite'             => false,
			'query_var'           => false,
		)
	);
}
add_action( 'init', 'america_register_cpt_solucao' );

/**
 * Campos do meta box.
 *
 * @return array
 */
function america_solucao_fields() {
	return array(
		'_amr_link_text' => array(
			'label' => __( 'Texto do link', 'america' ),
			'type'  => 'text',
			'help'  => __( 'Ex.: “Ver alvará de funcionamento”. Em branco: “Ver” + nome da solução.', 'america' ),
		),
		'_amr_link_url'  => array(
			'label' => __( 'Endereço do link', 'america' ),
			'type'  => 'url',
			'help'  => __( 'Página com mais detalhes sobre o documento. Em branco: o link não leva a lugar nenhum (#).', 'america' ),
		),
		'_amr_icon'      => array(
			'label'   => __( 'Ícone', 'america' ),
			'type'    => 'select',
			'options' => america_doc_icons(),
			'default' => 'file',
			'help'    => __( 'Pequeno ícone ao lado do nome da aba.', 'america' ),
		),
		'_amr_tight'     => array(
			'label'          => __( 'Ajuste de layout', 'america' ),
			'type'           => 'checkbox',
			'checkbox_label' => __( 'Aproximar o ícone do título (12px em vez de 16px)', 'america' ),
			'help'           => __( 'Ajuste fino do layout original; normalmente pode ficar desmarcado.', 'america' ),
		),
	);
}

/**
 * Adiciona o meta box.
 */
function america_solucao_add_meta_box() {
	add_meta_box(
		'america_solucao_detalhes',
		__( 'Detalhes da aba', 'america' ),
		function ( $post ) {
			america_meta_box_render( $post, 'solucao', america_solucao_fields() );
		},
		'amr_solucao',
		'normal',
		'high'
	);
}
add_action( 'add_meta_boxes_amr_solucao', 'america_solucao_add_meta_box' );

/**
 * Salva o meta box.
 *
 * @param int $post_id ID.
 */
function america_solucao_save( $post_id ) {
	america_meta_box_save( $post_id, 'solucao', america_solucao_fields() );
}
add_action( 'save_post_amr_solucao', 'america_solucao_save' );
