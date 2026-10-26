<?php
/**
 * Importador de conteúdo inicial: Aparência → Importar conteúdo inicial.
 *
 * Um clique cria o conteúdo do layout aprovado: imagens na Biblioteca de mídia,
 * 9 soluções, 30 clientes (10 da faixa + 20 da grade) com setores, 1 depoimento,
 * 9 perguntas frequentes, 3 posts com categorias, menus e a página inicial estática.
 *
 * Idempotente: cada item recebe a meta _amr_seed_key (anexos: _amr_seed_file) e é
 * pulado se já existir; ao final grava a opção "america_seeded" e o botão some.
 * Nada existente é apagado ou sobrescrito.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

/**
 * Página no menu Aparência.
 */
function america_seeder_menu() {
	add_theme_page(
		__( 'Importar conteúdo inicial', 'america' ),
		__( 'Importar conteúdo inicial', 'america' ),
		'manage_options',
		'america-importar',
		'america_seeder_page'
	);
}
add_action( 'admin_menu', 'america_seeder_menu' );

/**
 * Tela do importador.
 */
function america_seeder_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$seeded = get_option( 'america_seeded' );
	$report = get_transient( 'america_seed_report_' . get_current_user_id() );
	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- só exibe a mensagem de retorno.
	$status = isset( $_GET['america_seed'] ) ? sanitize_key( wp_unslash( $_GET['america_seed'] ) ) : '';
	?>
	<div class="wrap">
		<h1><?php esc_html_e( 'Importar conteúdo inicial', 'america' ); ?></h1>

		<?php if ( 'ok' === $status ) : ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Pronto! O conteúdo inicial foi importado.', 'america' ); ?></p></div>
		<?php elseif ( 'hero_ok' === $status ) : ?>
			<div class="notice notice-success"><p><?php esc_html_e( 'Pronto! As fotos do destaque principal foram para a Biblioteca de mídia.', 'america' ); ?></p></div>
		<?php elseif ( 'parcial' === $status ) : ?>
			<div class="notice notice-warning"><p><?php esc_html_e( 'A importação terminou com avisos (veja abaixo). Clique no botão de novo para tentar completar: o que já foi criado não é duplicado.', 'america' ); ?></p></div>
		<?php elseif ( 'ja' === $status ) : ?>
			<div class="notice notice-info"><p><?php esc_html_e( 'O conteúdo inicial já tinha sido importado. Nada foi alterado.', 'america' ); ?></p></div>
		<?php elseif ( 'ocupado' === $status ) : ?>
			<div class="notice notice-warning"><p><?php esc_html_e( 'Uma importação já está em andamento. Aguarde alguns minutos e recarregue esta página.', 'america' ); ?></p></div>
		<?php endif; ?>

		<?php if ( is_array( $report ) ) : ?>
			<h2><?php esc_html_e( 'Resumo da última importação', 'america' ); ?></h2>
			<table class="widefat striped" style="max-width:640px">
				<thead><tr><th><?php esc_html_e( 'Conteúdo', 'america' ); ?></th><th><?php esc_html_e( 'Criados', 'america' ); ?></th><th><?php esc_html_e( 'Já existiam', 'america' ); ?></th></tr></thead>
				<tbody>
				<?php foreach ( $report['counts'] as $label => $c ) : ?>
					<tr><td><?php echo esc_html( $label ); ?></td><td><?php echo esc_html( (string) $c['new'] ); ?></td><td><?php echo esc_html( (string) $c['old'] ); ?></td></tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php if ( ! empty( $report['errors'] ) ) : ?>
				<h3><?php esc_html_e( 'Avisos', 'america' ); ?></h3>
				<ul style="list-style:disc;padding-left:20px">
					<?php foreach ( $report['errors'] as $error ) : ?>
						<li><?php echo esc_html( $error ); ?></li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		<?php endif; ?>

		<?php if ( $seeded ) : ?>
			<p>
				<?php
				printf(
					/* translators: %s: data e hora da importação. */
					esc_html__( 'O conteúdo inicial já foi importado em %s.', 'america' ),
					esc_html( wp_date( 'd/m/Y H:i', isset( $seeded['time'] ) ? (int) $seeded['time'] : time() ) )
				);
				?>
			</p>
			<p><?php esc_html_e( 'Para alterar textos e imagens, use Aparência → Personalizar → Página inicial (América) e os menus Soluções, Clientes, Depoimentos, Perguntas frequentes e Posts.', 'america' ); ?></p>
			<?php if ( america_seed_hero_images_missing() ) : ?>
				<h2><?php esc_html_e( 'Imagens novas do destaque principal', 'america' ); ?></h2>
				<p><?php esc_html_e( 'O tema ganhou um segundo modelo de destaque (“Sócio”). Este botão só leva as fotos dos dois modelos para a Biblioteca de mídia; nada mais é alterado.', 'america' ); ?></p>
				<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
					<input type="hidden" name="action" value="america_seed_hero">
					<?php wp_nonce_field( 'america_seed_hero', 'america_seed_hero_nonce' ); ?>
					<?php submit_button( __( 'Importar imagens do destaque', 'america' ), 'secondary', 'submit', false ); ?>
				</form>
			<?php endif; ?>
		<?php else : ?>
			<p><?php esc_html_e( 'Este botão cria de uma vez o conteúdo do layout aprovado, para você só editar depois:', 'america' ); ?></p>
			<ul style="list-style:disc;padding-left:20px">
				<li><?php esc_html_e( 'imagens e logos na Biblioteca de mídia (incluindo as fotos dos dois modelos do destaque principal);', 'america' ); ?></li>
				<li><?php esc_html_e( '9 soluções (abas de documentos);', 'america' ); ?></li>
				<li><?php esc_html_e( '30 clientes (10 na faixa do topo e 20 na grade de cases) e 5 setores;', 'america' ); ?></li>
				<li><?php esc_html_e( '1 depoimento e 9 perguntas frequentes;', 'america' ); ?></li>
				<li><?php esc_html_e( '3 posts de Conteúdos com imagem e categoria;', 'america' ); ?></li>
				<li><?php esc_html_e( 'os menus do topo e do rodapé;', 'america' ); ?></li>
				<li><?php esc_html_e( 'a página “Início”, definida como página inicial do site.', 'america' ); ?></li>
			</ul>
			<p><?php esc_html_e( 'Nada que já existe é apagado. Pode levar até um minuto.', 'america' ); ?></p>
			<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
				<input type="hidden" name="action" value="america_seed">
				<?php wp_nonce_field( 'america_seed', 'america_seed_nonce' ); ?>
				<?php submit_button( __( 'Importar conteúdo inicial', 'america' ), 'primary large', 'submit', false ); ?>
			</form>
		<?php endif; ?>
	</div>
	<?php
}

/**
 * Processa o clique no botão.
 */
function america_seeder_handle() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Você não tem permissão para fazer isso.', 'america' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'america_seed', 'america_seed_nonce' );

	$redirect = admin_url( 'themes.php?page=america-importar' );

	if ( get_option( 'america_seeded' ) ) {
		wp_safe_redirect( add_query_arg( 'america_seed', 'ja', $redirect ) );
		exit;
	}
	if ( get_transient( 'america_seed_lock' ) ) {
		wp_safe_redirect( add_query_arg( 'america_seed', 'ocupado', $redirect ) );
		exit;
	}

	set_transient( 'america_seed_lock', 1, 5 * MINUTE_IN_SECONDS );
	$report = america_seed_run();
	delete_transient( 'america_seed_lock' );

	set_transient( 'america_seed_report_' . get_current_user_id(), $report, HOUR_IN_SECONDS );

	if ( empty( $report['errors'] ) ) {
		update_option(
			'america_seeded',
			array(
				'time'    => time(),
				'version' => AMERICA_VERSION,
			),
			false
		);
		wp_safe_redirect( add_query_arg( 'america_seed', 'ok', $redirect ) );
	} else {
		wp_safe_redirect( add_query_arg( 'america_seed', 'parcial', $redirect ) );
	}
	exit;
}
add_action( 'admin_post_america_seed', 'america_seeder_handle' );

/**
 * Importa só as imagens do hero em sites que já tinham feito a importação
 * antes do modelo "Sócio" existir (o botão principal some depois da primeira importação).
 */
function america_seeder_handle_hero() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Você não tem permissão para fazer isso.', 'america' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'america_seed_hero', 'america_seed_hero_nonce' );

	$redirect = admin_url( 'themes.php?page=america-importar' );

	if ( get_transient( 'america_seed_lock' ) ) {
		wp_safe_redirect( add_query_arg( 'america_seed', 'ocupado', $redirect ) );
		exit;
	}

	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	set_transient( 'america_seed_lock', 1, 5 * MINUTE_IN_SECONDS );
	$report = array(
		'counts' => array(),
		'errors' => array(),
	);
	america_seed_hero_images( $report );
	delete_transient( 'america_seed_lock' );

	set_transient( 'america_seed_report_' . get_current_user_id(), $report, HOUR_IN_SECONDS );
	wp_safe_redirect( add_query_arg( 'america_seed', empty( $report['errors'] ) ? 'hero_ok' : 'parcial', $redirect ) );
	exit;
}
add_action( 'admin_post_america_seed_hero', 'america_seeder_handle_hero' );

/**
 * Executa a importação completa.
 *
 * @return array{counts:array,errors:array}
 */
function america_seed_run() {
	require_once ABSPATH . 'wp-admin/includes/file.php';
	require_once ABSPATH . 'wp-admin/includes/media.php';
	require_once ABSPATH . 'wp-admin/includes/image.php';

	if ( function_exists( 'wp_raise_memory_limit' ) ) {
		wp_raise_memory_limit( 'admin' );
	}
	if ( function_exists( 'set_time_limit' ) ) {
		@set_time_limit( 300 ); // phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
	}

	$r = array(
		'counts' => array(),
		'errors' => array(),
	);

	america_seed_hero_images( $r );
	america_seed_setores( $r );
	america_seed_solucoes( $r );
	america_seed_clientes( $r );
	america_seed_depoimentos( $r );
	america_seed_faqs( $r );
	america_seed_posts( $r );
	america_seed_menus( $r );
	america_seed_front_page( $r );

	return $r;
}

/* =========================================================
   Utilitários
   ========================================================= */

/**
 * Soma no relatório.
 *
 * @param array  $r     Relatório.
 * @param string $label Tipo de conteúdo.
 * @param bool   $new   Criado agora (true) ou já existia (false).
 */
function america_seed_count( array &$r, $label, $new ) {
	if ( ! isset( $r['counts'][ $label ] ) ) {
		$r['counts'][ $label ] = array(
			'new' => 0,
			'old' => 0,
		);
	}
	$r['counts'][ $label ][ $new ? 'new' : 'old' ]++;
}

/**
 * Procura um item já importado.
 *
 * @param string $post_type Tipo.
 * @param string $key       Chave de importação.
 * @return int ID ou 0.
 */
function america_seed_find( $post_type, $key ) {
	$ids = get_posts(
		array(
			'post_type'        => $post_type,
			'post_status'      => 'attachment' === $post_type ? 'inherit' : 'any',
			'meta_key'         => 'attachment' === $post_type ? '_amr_seed_file' : '_amr_seed_key', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
			'meta_value'       => $key, // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_value
			'posts_per_page'   => 1,
			'fields'           => 'ids',
			'no_found_rows'    => true,
			'suppress_filters' => true,
		)
	);
	return $ids ? (int) $ids[0] : 0;
}

/**
 * Importa uma imagem de assets/images/ para a Biblioteca de mídia
 * (via cópia temporária + media_handle_sideload, preservando o arquivo do tema).
 *
 * @param array  $r     Relatório.
 * @param string $file  Caminho relativo a assets/images/.
 * @param string $alt   Texto alternativo.
 * @param string $name  Nome do arquivo na mídia (evita colisão entre pastas).
 * @param string $title Título do anexo.
 * @return int ID do anexo ou 0.
 */
function america_seed_image( array &$r, $file, $alt, $name = '', $title = '' ) {
	$label    = __( 'Imagens na Biblioteca de mídia', 'america' );
	$existing = america_seed_find( 'attachment', $file );
	if ( $existing ) {
		america_seed_count( $r, $label, false );
		return $existing;
	}

	$source = get_theme_file_path( 'assets/images/' . $file );
	if ( ! is_readable( $source ) ) {
		/* translators: %s: arquivo. */
		$r['errors'][] = sprintf( __( 'Imagem não encontrada no tema: %s', 'america' ), $file );
		return 0;
	}

	$name = $name ? $name : basename( $source );
	$tmp  = wp_tempnam( $name );
	if ( ! $tmp || ! copy( $source, $tmp ) ) {
		/* translators: %s: arquivo. */
		$r['errors'][] = sprintf( __( 'Não foi possível copiar a imagem: %s', 'america' ), $file );
		if ( $tmp && file_exists( $tmp ) ) {
			wp_delete_file( $tmp );
		}
		return 0;
	}

	$id = media_handle_sideload(
		array(
			'name'     => $name,
			'tmp_name' => $tmp,
		),
		0,
		null,
		array( 'post_title' => $title ? $title : ( $alt ? $alt : pathinfo( $name, PATHINFO_FILENAME ) ) )
	);

	if ( is_wp_error( $id ) ) {
		if ( file_exists( $tmp ) ) {
			wp_delete_file( $tmp );
		}
		/* translators: 1: arquivo, 2: mensagem de erro. */
		$r['errors'][] = sprintf( __( 'Falha ao importar %1$s: %2$s', 'america' ), $file, $id->get_error_message() );
		return 0;
	}

	update_post_meta( $id, '_wp_attachment_image_alt', $alt );
	update_post_meta( $id, '_amr_seed_file', $file );
	america_seed_count( $r, $label, true );
	return (int) $id;
}

/**
 * Cria um post (qualquer tipo) se ainda não existir.
 *
 * @param array  $r        Relatório.
 * @param string $label    Tipo de conteúdo (relatório).
 * @param string $seed_key Chave de importação.
 * @param array  $postarr  Args de wp_insert_post().
 * @param array  $meta     Metas.
 * @param array  $image    [file, alt, name?, title?] para a imagem destacada.
 * @return int ID ou 0.
 */
function america_seed_post( array &$r, $label, $seed_key, array $postarr, array $meta = array(), array $image = array() ) {
	$existing = america_seed_find( $postarr['post_type'], $seed_key );
	if ( $existing ) {
		america_seed_count( $r, $label, false );
		return $existing;
	}

	$postarr = array_merge(
		array(
			'post_status' => 'publish',
			'post_author' => get_current_user_id(),
		),
		$postarr
	);

	$id = wp_insert_post( wp_slash( $postarr ), true );
	if ( is_wp_error( $id ) ) {
		/* translators: 1: título, 2: mensagem de erro. */
		$r['errors'][] = sprintf( __( 'Falha ao criar “%1$s”: %2$s', 'america' ), $postarr['post_title'], $id->get_error_message() );
		return 0;
	}

	update_post_meta( $id, '_amr_seed_key', $seed_key );
	foreach ( $meta as $key => $value ) {
		update_post_meta( $id, $key, $value );
	}

	if ( $image ) {
		$attachment = america_seed_image(
			$r,
			$image['file'],
			$image['alt'],
			isset( $image['name'] ) ? $image['name'] : '',
			isset( $image['title'] ) ? $image['title'] : ''
		);
		if ( $attachment ) {
			set_post_thumbnail( $id, $attachment );
		}
	}

	america_seed_count( $r, $label, true );
	return (int) $id;
}

/**
 * Garante um termo e devolve o ID.
 *
 * @param array  $r        Relatório.
 * @param string $label    Rótulo do relatório.
 * @param string $name     Nome.
 * @param string $taxonomy Taxonomia.
 * @return int
 */
function america_seed_term( array &$r, $label, $name, $taxonomy ) {
	$found = term_exists( $name, $taxonomy );
	if ( $found ) {
		america_seed_count( $r, $label, false );
		return (int) ( is_array( $found ) ? $found['term_id'] : $found );
	}
	$created = wp_insert_term( $name, $taxonomy );
	if ( is_wp_error( $created ) ) {
		/* translators: 1: nome, 2: erro. */
		$r['errors'][] = sprintf( __( 'Falha ao criar o termo “%1$s”: %2$s', 'america' ), $name, $created->get_error_message() );
		return 0;
	}
	america_seed_count( $r, $label, true );
	return (int) $created['term_id'];
}

/* =========================================================
   Conteúdos
   ========================================================= */

/**
 * Imagens dos dois modelos do hero (Cidade e Sócio) na Biblioteca de mídia.
 * Só importa: o Personalizar continua usando as imagens do tema até alguém escolher outra.
 *
 * @param array $r Relatório.
 */
function america_seed_hero_images( array &$r ) {
	foreach ( america_default_hero_images() as $d ) {
		america_seed_image( $r, $d['file'], $d['alt'], '', $d['title'] );
	}
}

/**
 * Alguma imagem do hero ainda não está na Biblioteca de mídia?
 *
 * @return bool
 */
function america_seed_hero_images_missing() {
	foreach ( america_default_hero_images() as $d ) {
		if ( ! america_seed_find( 'attachment', $d['file'] ) ) {
			return true;
		}
	}
	return false;
}

/**
 * Setores com ordem.
 *
 * @param array $r Relatório.
 */
function america_seed_setores( array &$r ) {
	foreach ( america_default_setores() as $i => $name ) {
		$term_id = america_seed_term( $r, __( 'Setores', 'america' ), $name, 'amr_setor' );
		if ( $term_id && '' === (string) get_term_meta( $term_id, 'amr_ordem', true ) ) {
			update_term_meta( $term_id, 'amr_ordem', $i + 1 );
		}
	}
}

/**
 * 9 soluções.
 *
 * @param array $r Relatório.
 */
function america_seed_solucoes( array &$r ) {
	foreach ( america_default_solucoes() as $i => $d ) {
		america_seed_post(
			$r,
			__( 'Soluções', 'america' ),
			'solucao-' . $d['slug'],
			array(
				'post_type'    => 'amr_solucao',
				'post_title'   => $d['title'],
				'post_name'    => $d['slug'],
				'post_excerpt' => $d['text'],
				'menu_order'   => $i + 1,
			),
			array(
				'_amr_link_text' => $d['link_text'],
				'_amr_link_url'  => $d['link_url'],
				'_amr_icon'      => $d['icon'],
				'_amr_tight'     => $d['tight'] ? '1' : '0',
			),
			array(
				'file'  => $d['image'],
				'alt'   => $d['image_alt'],
				'title' => $d['title'],
			)
		);
	}
}

/**
 * 10 clientes da faixa + 20 da grade, com setores.
 *
 * @param array $r Relatório.
 */
function america_seed_clientes( array &$r ) {
	$slots = array(
		'faixa' => array( 'prefix' => 'faixa-', 'file_prefix' => 'cliente-' ),
		'grade' => array( 'prefix' => 'case-', 'file_prefix' => 'case-' ),
	);

	foreach ( $slots as $slot => $cfg ) {
		foreach ( america_default_clientes( $slot ) as $i => $d ) {
			$id = america_seed_post(
				$r,
				__( 'Clientes', 'america' ),
				'cliente-' . $cfg['prefix'] . $d['slug'],
				array(
					'post_type'  => 'amr_cliente',
					'post_title' => $d['name'],
					'post_name'  => $cfg['prefix'] . $d['slug'],
					'menu_order' => $i + 1,
				),
				array(
					'_amr_faixa'  => 'faixa' === $slot ? '1' : '0',
					'_amr_grade'  => 'grade' === $slot ? '1' : '0',
					'_amr_logo_w' => (string) $d['w'],
					'_amr_logo_h' => (string) $d['h'],
				),
				array(
					'file'  => $d['file'],
					'alt'   => $d['name'],
					'name'  => $cfg['file_prefix'] . basename( $d['file'] ),
					'title' => sprintf( 'Logo %s', $d['name'] ),
				)
			);

			if ( $id && $d['setor'] && ! has_term( '', 'amr_setor', $id ) ) {
				$term = term_exists( $d['setor'], 'amr_setor' );
				if ( $term ) {
					wp_set_object_terms( $id, array( (int) ( is_array( $term ) ? $term['term_id'] : $term ) ), 'amr_setor' );
				}
			}
		}
	}
}

/**
 * Depoimento (Sandra de Freitas / Mirpo).
 *
 * @param array $r Relatório.
 */
function america_seed_depoimentos( array &$r ) {
	foreach ( america_default_depoimentos() as $i => $d ) {
		america_seed_post(
			$r,
			__( 'Depoimentos', 'america' ),
			'depoimento-' . $d['slug'],
			array(
				'post_type'    => 'amr_depoimento',
				'post_title'   => $d['name'],
				'post_name'    => $d['slug'],
				'post_content' => $d['quote'],
				'menu_order'   => $i + 1,
			),
			array( '_amr_cargo' => $d['role'] ),
			array(
				'file'  => $d['logo'],
				'alt'   => $d['logo_alt'],
				'title' => sprintf( 'Logo %s', $d['logo_alt'] ),
			)
		);
	}
}

/**
 * 9 perguntas frequentes com as respostas completas.
 *
 * @param array $r Relatório.
 */
function america_seed_faqs( array &$r ) {
	foreach ( america_default_faqs() as $i => $d ) {
		america_seed_post(
			$r,
			__( 'Perguntas frequentes', 'america' ),
			'faq-' . ( $i + 1 ),
			array(
				'post_type'    => 'amr_faq',
				'post_title'   => $d['question'],
				'post_content' => implode( "\n\n", $d['answer'] ),
				'menu_order'   => $i + 1,
			),
			array( '_amr_gap_largo' => $d['wide'] ? '1' : '0' )
		);
	}
}

/**
 * 3 posts com imagem destacada e categoria.
 * Horários decrescentes mantêm a ordem do layout (o mais recente primeiro).
 *
 * @param array $r Relatório.
 */
function america_seed_posts( array &$r ) {
	$total = count( america_default_posts() );

	foreach ( america_default_posts() as $i => $d ) {
		$cat_id = america_seed_term( $r, __( 'Categorias', 'america' ), $d['cat'], 'category' );

		$date = sprintf( '%s 12:%02d:00', $d['date'], $total - $i );
		if ( strtotime( get_gmt_from_date( $date ) . ' UTC' ) > time() ) {
			// Evita que o post fique "agendado" se o relógio do servidor estiver antes da data do layout.
			$date = gmdate( 'Y-m-d H:i:s', current_time( 'timestamp' ) - ( $i * MINUTE_IN_SECONDS ) ); // phpcs:ignore WordPress.DateTime.CurrentTimeTimestamp.Requested
		}

		america_seed_post(
			$r,
			__( 'Posts (Conteúdos)', 'america' ),
			'post-' . $d['slug'],
			array(
				'post_type'     => 'post',
				'post_title'    => $d['title'],
				'post_name'     => $d['slug'],
				'post_excerpt'  => $d['excerpt'],
				'post_content'  => $d['excerpt'],
				'post_date'     => $date,
				'post_category' => $cat_id ? array( $cat_id ) : array(),
			),
			array(),
			array(
				'file'  => $d['image'],
				'alt'   => $d['image_alt'],
				'title' => $d['title'],
			)
		);
	}
}

/**
 * Menus do topo e do rodapé, atribuídos aos locais do tema.
 * Locais que já têm um menu definido não são alterados.
 *
 * @param array $r Relatório.
 */
function america_seed_menus( array &$r ) {
	$label     = __( 'Menus', 'america' );
	$locations = get_theme_mod( 'nav_menu_locations', array() );
	$locations = is_array( $locations ) ? $locations : array();

	foreach ( america_default_menus() as $location => $menu ) {
		$existing = wp_get_nav_menu_object( $menu['name'] );
		if ( $existing ) {
			$menu_id = (int) $existing->term_id;
			america_seed_count( $r, $label, false );
		} else {
			$menu_id = wp_create_nav_menu( $menu['name'] );
			if ( is_wp_error( $menu_id ) ) {
				/* translators: 1: menu, 2: erro. */
				$r['errors'][] = sprintf( __( 'Falha ao criar o menu “%1$s”: %2$s', 'america' ), $menu['name'], $menu_id->get_error_message() );
				continue;
			}
			foreach ( $menu['items'] as $pos => $item ) {
				wp_update_nav_menu_item(
					$menu_id,
					0,
					array(
						'menu-item-title'    => $item[0],
						'menu-item-url'      => america_default_menu_item_url( $item ),
						'menu-item-type'     => 'custom',
						'menu-item-status'   => 'publish',
						'menu-item-position' => $pos + 1,
					)
				);
			}
			america_seed_count( $r, $label, true );
		}

		if ( empty( $locations[ $location ] ) ) {
			$locations[ $location ] = $menu_id;
		}
	}

	set_theme_mod( 'nav_menu_locations', $locations );
}

/**
 * Página "Início" como página inicial estática (renderizada pelo front-page.php).
 *
 * @param array $r Relatório.
 */
function america_seed_front_page( array &$r ) {
	$page_id = america_seed_post(
		$r,
		__( 'Páginas', 'america' ),
		'page-inicio',
		array(
			'post_type'    => 'page',
			'post_title'   => 'Início',
			'post_name'    => 'inicio',
			'post_content' => '',
		)
	);

	if ( $page_id ) {
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', $page_id );
	}
}
