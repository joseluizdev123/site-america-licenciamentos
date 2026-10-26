<?php
/**
 * Personalizar: textos globais e das seções da home.
 *
 * Todos os campos têm como padrão o texto exato do index.html,
 * então o site fica idêntico mesmo antes de qualquer edição.
 * Leitura no front: america_mod( 'chave' ) / america_mod_image( 'chave' ).
 * Theme mods gravados com o prefixo "amr_".
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

/**
 * Seções do painel "Página inicial (América)".
 *
 * @return array slug => [título, descrição]
 */
function america_customizer_sections() {
	return array(
		'identidade'  => array( __( 'Identidade e SEO', 'america' ), __( 'Logos do site e o título/descrição que aparecem no Google.', 'america' ) ),
		'contato'     => array( __( 'Contato e redes sociais', 'america' ), __( 'Usados no topo e no rodapé.', 'america' ) ),
		'topo'        => array( __( 'Topo do site', 'america' ), __( 'Os links do menu ficam em Aparência → Menus.', 'america' ) ),
		'hero'        => array( __( '1. Destaque principal', 'america' ), __( 'Existem dois modelos de destaque: “Cidade” (foto de São Paulo ao fundo) e “Sócio” (foto do sócio-diretor ao lado). Escolha em “Modelo do hero” qual aparece no site. Para apresentar um modelo sem mudar o site, use o endereço da página com ?hero=cidade ou ?hero=socio no final.', 'america' ) ),
		'trust'       => array( __( '2. Empresas que confiam', 'america' ), __( 'Os logos são cadastrados em Clientes (marque “Exibir na faixa Empresas que confiam”).', 'america' ) ),
		'decisao'     => array( __( '3. Decisão empresarial', 'america' ), '' ),
		'imovel'      => array( __( '4. Imóvel, atividade e operação', 'america' ), '' ),
		'solucoes'    => array( __( '5. Soluções (documentos)', 'america' ), __( 'As abas são cadastradas no menu Soluções.', 'america' ) ),
		'metodo'      => array( __( '6. Método América', 'america' ), '' ),
		'sobre'       => array( __( '7. Sobre a América', 'america' ), '' ),
		'cases'       => array( __( '8. Cases', 'america' ), __( 'Os logos são cadastrados em Clientes (marque “Exibir na grade de cases”). Os setores ficam em Clientes → Setores.', 'america' ) ),
		'depoimentos' => array( __( '9. Depoimentos', 'america' ), __( 'Os depoimentos são cadastrados no menu Depoimentos.', 'america' ) ),
		'contadores'  => array( __( '10. Para contadores', 'america' ), '' ),
		'conteudos'   => array( __( '11. Conteúdos (blog)', 'america' ), __( 'Mostra os últimos posts que têm imagem destacada.', 'america' ) ),
		'faq'         => array( __( '12. Perguntas frequentes', 'america' ), __( 'As perguntas são cadastradas no menu Perguntas frequentes.', 'america' ) ),
		'cta'         => array( __( 'Caixas “Solicitar diagnóstico”', 'america' ), __( 'As três caixas cinzas com botão que aparecem ao longo da página.', 'america' ) ),
		'rodape'      => array( __( 'Rodapé', 'america' ), __( 'Os links das colunas ficam em Aparência → Menus.', 'america' ) ),
	);
}

/**
 * Registro de todos os campos.
 * Tipos: text, textarea, url (aceita âncoras como #contato), image (ID de mídia), select (lista de opções).
 * Para "image", 'default' é o arquivo em assets/images/ e 'alt' o texto alternativo padrão.
 * Para "select", o 6º item é a lista valor => rótulo.
 *
 * @return array chave => [section, type, label, default, alt?, choices?]
 */
function america_customizer_fields() {
	static $fields = null;
	if ( null !== $fields ) {
		return $fields;
	}

	$raw = array(
		// Identidade e SEO.
		'logo_header'          => array( 'identidade', 'image', __( 'Logo do topo', 'america' ), 'logo-america.png', 'América Licenciamentos' ),
		'logo_footer'          => array( 'identidade', 'image', __( 'Logo do rodapé (versão branca)', 'america' ), 'logo-america-branco.svg', 'América Licenciamentos' ),
		'seo_title'            => array( 'identidade', 'text', __( 'Título da página inicial (aba do navegador e Google)', 'america' ), 'América Licenciamentos — Alvará, AVCB e habite-se em São Paulo' ),
		'seo_description'      => array( 'identidade', 'textarea', __( 'Descrição para o Google', 'america' ), 'Segurança regulatória para empresas e imóveis em São Paulo. Alvará de funcionamento, AVCB, habite-se e licenciamento empresarial desde 2000.' ),

		// Contato.
		'phone'                => array( 'contato', 'text', __( 'Telefone', 'america' ), '(11) 2099-2020' ),
		'email'                => array( 'contato', 'text', __( 'E-mail', 'america' ), 'contato@americalicenciamentos.com.br' ),
		'hours'                => array( 'contato', 'textarea', __( 'Horário de atendimento', 'america' ), 'Atendimento de segunda a sexta, das 9h às 18h. Exclusivo ao município de São Paulo, capital.' ),
		'address'              => array( 'contato', 'textarea', __( 'Endereço', 'america' ), 'Avenida Tiradentes, 998, 6º andar - Luz, São Paulo, SP, 01102-000' ),
		'instagram'            => array( 'contato', 'url', __( 'Instagram (link)', 'america' ), '#' ),
		'linkedin'             => array( 'contato', 'url', __( 'LinkedIn (link)', 'america' ), '#' ),
		'facebook'             => array( 'contato', 'url', __( 'Facebook (link)', 'america' ), '#' ),
		'legal'                => array( 'contato', 'text', __( 'Razão social e CNPJ (linha de copyright)', 'america' ), '© Copyright 2026 | AMRC Alvarás e Regularizações Ltda. - CNPJ 46.448.331/0001-90' ),

		// Topo.
		'header_cta_text'      => array( 'topo', 'text', __( 'Botão do topo: texto', 'america' ), 'Solicitar diagnóstico' ),
		'header_cta_url'       => array( 'topo', 'url', __( 'Botão do topo: link', 'america' ), '#diagnostico' ),

		// 1. Hero.
		'hero_mode'            => array( 'hero', 'select', __( 'Modelo do hero', 'america' ), 'alternar', '', america_hero_modes() ),

		// 1. Hero, modelo "Cidade".
		'hero_eyebrow'         => array( 'hero', 'text', __( 'Modelo Cidade: frase acima do título', 'america' ), 'Segurança Regulatória Empresarial em São Paulo' ),
		'hero_title'           => array( 'hero', 'textarea', __( 'Modelo Cidade: título', 'america' ), 'Alvará de funcionamento, AVCB e habite-se em São Paulo' ),
		'hero_desc'            => array( 'hero', 'textarea', __( 'Modelo Cidade: descrição', 'america' ), 'Segurança regulatória para empresas e imóveis. A América conecta imóvel, atividade e operação para orientar decisões que envolvem capital, patrimônio, continuidade e expansão. Da análise de viabilidade à condução técnica do licenciamento e da regularização.' ),
		'hero_image'           => array( 'hero', 'image', __( 'Modelo Cidade: imagem de fundo', 'america' ), 'hero-sao-paulo.jpg', '' ),
		'hero_cta1_text'       => array( 'hero', 'text', __( 'Modelo Cidade: botão 1 (texto)', 'america' ), 'Solicitar diagnóstico' ),
		'hero_cta1_url'        => array( 'hero', 'url', __( 'Modelo Cidade: botão 1 (link)', 'america' ), '#contato' ),
		'hero_cta2_text'       => array( 'hero', 'text', __( 'Modelo Cidade: botão 2 (texto)', 'america' ), 'Documentos que emitimos' ),
		'hero_cta2_url'        => array( 'hero', 'url', __( 'Modelo Cidade: botão 2 (link)', 'america' ), '#solucoes' ),

		// 1. Hero, modelo "Sócio".
		'hero_socio_eyebrow'      => array( 'hero', 'text', __( 'Modelo Sócio: frase acima do título', 'america' ), 'Segurança Regulatória Empresarial em São Paulo' ),
		'hero_socio_title'        => array( 'hero', 'textarea', __( 'Modelo Sócio: título', 'america' ), 'Alvará de funcionamento, AVCB e habite-se em São Paulo' ),
		'hero_socio_desc'         => array( 'hero', 'textarea', __( 'Modelo Sócio: descrição', 'america' ), 'Segurança regulatória para empresas e imóveis. A América conecta imóvel, atividade e operação para orientar decisões que envolvem capital, patrimônio, continuidade e expansão. Da análise de viabilidade à condução técnica do licenciamento e da regularização.' ),
		'hero_socio_cta1_text'    => array( 'hero', 'text', __( 'Modelo Sócio: botão 1 (texto)', 'america' ), 'Solicitar análise gratuita' ),
		'hero_socio_cta1_url'     => array( 'hero', 'url', __( 'Modelo Sócio: botão 1 (link)', 'america' ), '#contato' ),
		'hero_socio_cta2_text'    => array( 'hero', 'text', __( 'Modelo Sócio: botão 2 (texto)', 'america' ), 'Documentos que emitimos' ),
		'hero_socio_cta2_url'     => array( 'hero', 'url', __( 'Modelo Sócio: botão 2 (link)', 'america' ), '#solucoes' ),
		'hero_socio_photo'        => array( 'hero', 'image', __( 'Modelo Sócio: foto (497 × 605, fundo transparente)', 'america' ), 'hero-socio.webp', 'Ricardo Nascimento, sócio-diretor da América Licenciamentos' ),
		'hero_socio_card1_title'  => array( 'hero', 'text', __( 'Modelo Sócio: cartão de cima (destaque)', 'america' ), 'Protocolo validado' ),
		'hero_socio_card1_text'   => array( 'hero', 'text', __( 'Modelo Sócio: cartão de cima (texto menor)', 'america' ), 'Em 24/09/2026 às 10:40' ),
		'hero_socio_card2_title'  => array( 'hero', 'text', __( 'Modelo Sócio: cartão de baixo (destaque)', 'america' ), '+20 anos' ),
		'hero_socio_card2_text'   => array( 'hero', 'text', __( 'Modelo Sócio: cartão de baixo (texto menor)', 'america' ), 'de licenciamento' ),

		// 2. Empresas que confiam.
		'trust_title'          => array( 'trust', 'text', __( 'Título', 'america' ), 'Empresas que confiam em nós' ),

		// 3. Decisão empresarial.
		'decision_title'       => array( 'decisao', 'textarea', __( 'Título', 'america' ), 'A decisão regulatória faz parte da decisão empresarial' ),
		'decision_desc'        => array( 'decisao', 'textarea', __( 'Descrição', 'america' ), 'Uma pendência regulatória pode afetar decisões que envolvem capital, patrimônio e continuidade. Alguns exemplos do que pode estar em jogo:' ),
		'impact_1'             => array( 'decisao', 'textarea', __( 'Impacto 1 (ícone alerta)', 'america' ), 'Uma pendência pode impedir a habilitação exigida em uma negociação ou contratação.' ),
		'impact_2'             => array( 'decisao', 'textarea', __( 'Impacto 2 (ícone casa)', 'america' ), 'A regularidade pode pesar na negociação de um imóvel e nas adequações necessárias.' ),
		'impact_3'             => array( 'decisao', 'textarea', __( 'Impacto 3 (ícone obra)', 'america' ), 'Uma exigência não prevista pode atrasar uma expansão ou mudança de endereço.' ),
		'impact_4'             => array( 'decisao', 'textarea', __( 'Impacto 4 (ícone dinheiro)', 'america' ), 'O investimento exposto vai além de uma multa: obra, equipamentos, equipe e contratos.' ),

		// 4. Imóvel, atividade e operação.
		'property_eyebrow'     => array( 'imovel', 'text', __( 'Frase acima do título', 'america' ), 'Antes do investimento' ),
		'property_title'       => array( 'imovel', 'textarea', __( 'Título', 'america' ), 'O imóvel comporta a atividade e a operação que a empresa pretende construir?' ),
		'feature_1_title'      => array( 'imovel', 'text', __( 'Cartão 1: título', 'america' ), 'Imóvel' ),
		'feature_1_text'       => array( 'imovel', 'textarea', __( 'Cartão 1: texto', 'america' ), 'Define parte das condições de uso: localização, zoneamento, edificação, documentação e adequações possíveis.' ),
		'feature_1_image'      => array( 'imovel', 'image', __( 'Cartão 1: imagem (quadrada)', 'america' ), 'card-imovel.jpg', 'Prédio comercial espelhado com cartões: zoneamento verificado e viabilidade de solo aprovada' ),
		'feature_2_title'      => array( 'imovel', 'text', __( 'Cartão 2: título', 'america' ), 'Atividade' ),
		'feature_2_text'       => array( 'imovel', 'textarea', __( 'Cartão 2: texto', 'america' ), 'Indica o que se pretende realizar e quais exigências precisam ser examinadas para essa atividade.' ),
		'feature_2_image'      => array( 'imovel', 'image', __( 'Cartão 2: imagem (quadrada)', 'america' ), 'card-atividade.jpg', 'Empresário ao telefone com cartão: exigências mapeadas' ),
		'feature_3_title'      => array( 'imovel', 'text', __( 'Cartão 3: título', 'america' ), 'Operação' ),
		'feature_3_text'       => array( 'imovel', 'textarea', __( 'Cartão 3: texto', 'america' ), 'Revela como o negócio funciona de fato: estrutura, procedimentos, fluxos e mudanças previstas.' ),
		'feature_3_image'      => array( 'imovel', 'image', __( 'Cartão 3: imagem (quadrada)', 'america' ), 'card-operacao.jpg', 'Gestora com tablet e cartão: análise de risco validada' ),

		// 5. Soluções.
		'docs_eyebrow'         => array( 'solucoes', 'text', __( 'Frase acima do título', 'america' ), 'Soluções' ),
		'docs_title'           => array( 'solucoes', 'textarea', __( 'Título', 'america' ), 'Segurança regulatória para sua empresa' ),
		'docs_desc'            => array( 'solucoes', 'textarea', __( 'Descrição', 'america' ), 'Licenças e alvarás fazem parte das decisões de abrir, operar, reformar ou expandir uma empresa. A América orienta e conduz a emissão e a regularização de cada documento com escopo e responsáveis definidos.' ),

		// 6. Método América.
		'method_eyebrow'       => array( 'metodo', 'text', __( 'Frase acima do título', 'america' ), 'Método América' ),
		'method_title'         => array( 'metodo', 'textarea', __( 'Título', 'america' ), 'Da pergunta à evidência, em quatro etapas' ),
		'method_desc'          => array( 'metodo', 'textarea', __( 'Descrição', 'america' ), 'Uma estrutura para documentar cada caso e relacionar critério e execução, com responsáveis e registros em cada etapa.' ),
		'step_1_title'         => array( 'metodo', 'text', __( 'Etapa 1: título', 'america' ), 'Contexto' ),
		'step_1_text'          => array( 'metodo', 'textarea', __( 'Etapa 1: descrição', 'america' ), 'Identificar a decisão empresarial, o imóvel, a atividade, a operação e os recursos expostos.' ),
		'step_2_title'         => array( 'metodo', 'text', __( 'Etapa 2: título', 'america' ), 'Análise' ),
		'step_2_text'          => array( 'metodo', 'textarea', __( 'Etapa 2: descrição', 'america' ), 'Examinar a viabilidade e os condicionantes no escopo do diagnóstico, com fontes, premissas e limites.' ),
		'step_3_title'         => array( 'metodo', 'text', __( 'Etapa 3: título', 'america' ), 'Condução' ),
		'step_3_text'          => array( 'metodo', 'textarea', __( 'Etapa 3: descrição', 'america' ), 'Definir o trabalho contratado, os responsáveis, as etapas, os documentos e as dependências.' ),
		'step_4_title'         => array( 'metodo', 'text', __( 'Etapa 4: título', 'america' ), 'Evidência' ),
		'step_4_text'          => array( 'metodo', 'textarea', __( 'Etapa 4: descrição', 'america' ), 'Registrar andamento, situação alcançada e pendências, distinguindo protocolo, licença emitida e resultado documentado.' ),

		// 7. Sobre a América.
		'about_eyebrow'        => array( 'sobre', 'text', __( 'Frase acima do título', 'america' ), 'Sobre a América' ),
		'about_title'          => array( 'sobre', 'textarea', __( 'Título', 'america' ), 'Critério regulatório nas decisões sobre investimento e operação' ),
		'about_p1'             => array( 'sobre', 'textarea', __( 'Parágrafo 1', 'america' ), 'A América Licenciamentos nasceu em 2000. Atua na orientação e condução de demandas de licenciamento empresarial e regularização de imóveis, incluindo situações que exigem coordenação técnica e acompanhamento de diferentes órgãos.' ),
		'about_p2'             => array( 'sobre', 'textarea', __( 'Parágrafo 2', 'america' ), 'Nosso território é Segurança Regulatória Empresarial. Incorporamos critério regulatório às decisões sobre investimento, patrimônio, operação e expansão. Sustentamos esse papel com análise de viabilidade, definição de escopo e condução técnica. As decisões dos órgãos dependem da legislação e do caso.' ),
		'stat_1_value'         => array( 'sobre', 'text', __( 'Número 1: valor', 'america' ), '+20 anos' ),
		'stat_1_label'         => array( 'sobre', 'text', __( 'Número 1: legenda', 'america' ), 'de licenciamento' ),
		'stat_2_value'         => array( 'sobre', 'text', __( 'Número 2: valor', 'america' ), 'São Paulo' ),
		'stat_2_label'         => array( 'sobre', 'text', __( 'Número 2: legenda', 'america' ), 'atendimento exclusivo à capital' ),
		'stat_3_value'         => array( 'sobre', 'text', __( 'Número 3: valor', 'america' ), '4 etapas' ),
		'stat_3_label'         => array( 'sobre', 'text', __( 'Número 3: legenda', 'america' ), 'contexto, análise, condução e evidência' ),
		'about_photo_1'        => array( 'sobre', 'image', __( 'Foto 1 da equipe (1376 × 636)', 'america' ), 'equipe-01.jpg', 'Equipe da América analisando plantas em reunião' ),
		'about_photo_2'        => array( 'sobre', 'image', __( 'Foto 2 da equipe (1376 × 636)', 'america' ), 'equipe-02.jpg', 'Equipe da América em atendimento' ),
		'about_photo_3'        => array( 'sobre', 'image', __( 'Foto 3 da equipe (1376 × 636)', 'america' ), 'equipe-03.jpg', 'Equipe da América no escritório' ),
		'about_quote'          => array( 'sobre', 'textarea', __( 'Citação', 'america' ), '“ [...] Ricardo Nascimento ensina empresários a reconhecer a dimensão regulatória de decisões sobre imóveis, capital e operação. O atendimento é conduzido pela equipe América, com responsáveis definidos para cada demanda.”' ),
		'about_author'         => array( 'sobre', 'text', __( 'Autor da citação', 'america' ), 'Ricardo Nascimento' ),
		'about_role'           => array( 'sobre', 'text', __( 'Cargo do autor', 'america' ), 'Sócio-Diretor da América Licenciamentos' ),
		'about_link_text'      => array( 'sobre', 'text', __( 'Link: texto', 'america' ), 'Conhecer a América' ),
		'about_link_url'       => array( 'sobre', 'url', __( 'Link: endereço', 'america' ), '#sobre' ),

		// 8. Cases.
		'cases_title'          => array( 'cases', 'textarea', __( 'Título', 'america' ), 'Experiências de quem contou com a América' ),
		'cases_desc'           => array( 'cases', 'textarea', __( 'Descrição', 'america' ), 'Conheça o contexto dos trabalhos e a experiência relatada pelos clientes. Cada caso possui condições e exigências próprias.' ),
		'cases_btn_text'       => array( 'cases', 'text', __( 'Botão: texto', 'america' ), 'Ver cases' ),
		'cases_btn_url'        => array( 'cases', 'url', __( 'Botão: link', 'america' ), '#cases' ),

		// 9. Depoimentos.
		'testimonials_eyebrow' => array( 'depoimentos', 'text', __( 'Frase acima do título', 'america' ), 'Depoimentos' ),
		'testimonials_title'   => array( 'depoimentos', 'textarea', __( 'Título', 'america' ), 'O que os clientes relatam sobre o trabalho' ),

		// 10. Para contadores.
		'acc_eyebrow'          => array( 'contadores', 'text', __( 'Frase acima do título', 'america' ), 'Para contadores' ),
		'acc_title'            => array( 'contadores', 'textarea', __( 'Título', 'america' ), 'A decisão do seu cliente pede um olhar regulatório?' ),
		'acc_p1'               => array( 'contadores', 'textarea', __( 'Parágrafo 1', 'america' ), 'Antes de escolher um endereço, alterar a atividade ou expandir, seu escritório pode envolver a América para avaliar imóvel, atividade e operação.' ),
		'acc_p2'               => array( 'contadores', 'textarea', __( 'Parágrafo 2', 'america' ), 'Construímos a parceria com escopo, responsáveis e acompanhamento definidos. Um CNPJ ativo ou um protocolo não substitui a análise das exigências pertinentes ao caso.' ),
		'acc_p3'               => array( 'contadores', 'textarea', __( 'Parágrafo 3', 'america' ), 'O escritório pode estar em outra cidade, mas o imóvel ou a operação atendida deve estar no município de São Paulo.' ),
		'acc_image'            => array( 'contadores', 'image', __( 'Imagem (486 × 438)', 'america' ), 'contadores.jpg', 'Contadora parceira lendo relatório' ),
		'acc_step_1'           => array( 'contadores', 'text', __( 'Etapa 1', 'america' ), 'Cenário' ),
		'acc_step_2'           => array( 'contadores', 'text', __( 'Etapa 2', 'america' ), 'Enquadramento' ),
		'acc_step_3'           => array( 'contadores', 'text', __( 'Etapa 3', 'america' ), 'Acompanhamento' ),
		'acc_link_text'        => array( 'contadores', 'text', __( 'Link: texto', 'america' ), 'Conhecer a parceria' ),
		'acc_link_url'         => array( 'contadores', 'url', __( 'Link: endereço', 'america' ), '#contadores' ),

		// 11. Conteúdos.
		'blog_eyebrow'         => array( 'conteudos', 'text', __( 'Frase acima do título', 'america' ), 'Conteúdos' ),
		'blog_title'           => array( 'conteudos', 'textarea', __( 'Título', 'america' ), 'Critério regulatório para decidir antes de investir' ),
		'blog_link_text'       => array( 'conteudos', 'text', __( 'Link “ver todos”: texto', 'america' ), 'Ver conteúdos' ),
		'blog_link_url'        => array( 'conteudos', 'url', __( 'Link “ver todos”: endereço', 'america' ), '#conteudos' ),

		// 12. FAQ.
		'faq_title'            => array( 'faq', 'text', __( 'Título', 'america' ), 'Perguntas frequentes' ),
		'faq_box_p1'           => array( 'faq', 'textarea', __( 'Caixa lateral: parágrafo 1', 'america' ), 'As dúvidas que mais aparecem na primeira conversa.' ),
		'faq_box_p2'           => array( 'faq', 'textarea', __( 'Caixa lateral: parágrafo 2', 'america' ), 'O que é específico de cada serviço está nas páginas de soluções, com o órgão responsável e a norma aplicável.' ),
		'faq_btn_text'         => array( 'faq', 'text', __( 'Botão: texto', 'america' ), 'Ver soluções' ),
		'faq_btn_url'          => array( 'faq', 'url', __( 'Botão: link', 'america' ), '#solucoes' ),

		// Caixas de CTA.
		'cta_text_1'           => array( 'cta', 'textarea', __( 'Caixa 1 (após “Decisão empresarial”)', 'america' ), 'Por isso, a análise deve começar antes da compra, da locação ou da reforma. O zoneamento admite a atividade? A edificação e as licenças comportam a operação prevista? Quais adequações podem ser necessárias?' ),
		'cta_text_2'           => array( 'cta', 'textarea', __( 'Caixa 2 (após “Imóvel, atividade e operação”)', 'america' ), 'Um endereço atraente, um CNPJ ativo ou um protocolo isolado não encerram essa avaliação. Conte o cenário e a equipe avaliará o escopo do diagnóstico.' ),
		'cta_text_3'           => array( 'cta', 'textarea', __( 'Caixa 3 (após “Soluções”)', 'america' ), 'Não sabe se o seu caso é AVCB, CLCB ou projeto técnico? Responda algumas perguntas e descubra.' ),
		'cta_btn_text'         => array( 'cta', 'text', __( 'Texto do botão (as 3 caixas)', 'america' ), 'Solicitar diagnóstico' ),
		'cta_btn_url'          => array( 'cta', 'url', __( 'Link do botão (as 3 caixas)', 'america' ), '#contato' ),

		// Rodapé.
		'footer_about'         => array( 'rodape', 'textarea', __( 'Texto institucional', 'america' ), 'Segurança Regulatória Empresarial. Licenciamento de empresas e regularização de imóveis no município de São Paulo, capital. Desde 2000.' ),
		'footer_link_text'     => array( 'rodape', 'text', __( 'Link: texto', 'america' ), 'Conhecer a América' ),
		'footer_link_url'      => array( 'rodape', 'url', __( 'Link: endereço', 'america' ), '#sobre' ),
		'footer_col_1_title'   => array( 'rodape', 'text', __( 'Título da coluna 1', 'america' ), 'Licenciamento e operação' ),
		'footer_col_2_title'   => array( 'rodape', 'text', __( 'Título da coluna 2', 'america' ), 'Regularização do imóvel' ),
		'footer_col_3_title'   => array( 'rodape', 'text', __( 'Título da coluna 3', 'america' ), 'Institucional' ),
		'footer_contact_title' => array( 'rodape', 'text', __( 'Título da caixa de contato', 'america' ), 'Fale conosco' ),
	);

	$fields = array();
	foreach ( $raw as $key => $f ) {
		$fields[ $key ] = array(
			'section' => $f[0],
			'type'    => $f[1],
			'label'   => $f[2],
			'default' => $f[3],
			'alt'     => isset( $f[4] ) ? $f[4] : '',
			'choices' => isset( $f[5] ) ? $f[5] : array(),
		);
	}
	return $fields;
}

/**
 * Sanitização por tipo de campo.
 *
 * @param string $type Tipo.
 * @return string Callback.
 */
function america_customizer_sanitizer( $type ) {
	switch ( $type ) {
		case 'textarea':
			return 'sanitize_textarea_field';
		case 'url':
			return 'esc_url_raw';
		case 'image':
			return 'absint';
		case 'select':
			return 'america_sanitize_choice';
		default:
			return 'sanitize_text_field';
	}
}

/**
 * Sanitiza um campo "select": só aceita uma das opções cadastradas; senão volta ao padrão.
 *
 * @param string               $value   Valor enviado.
 * @param WP_Customize_Setting $setting Setting (id "amr_chave").
 * @return string
 */
function america_sanitize_choice( $value, $setting ) {
	$fields  = america_customizer_fields();
	$key     = preg_replace( '/^amr_/', '', $setting->id );
	$choices = isset( $fields[ $key ] ) ? $fields[ $key ]['choices'] : array();
	$value   = sanitize_key( $value );
	return array_key_exists( $value, $choices ) ? $value : $setting->default;
}

/**
 * Registra painel, seções, settings e controles.
 *
 * @param WP_Customize_Manager $wp_customize Manager.
 */
function america_customize_register( $wp_customize ) {
	$wp_customize->add_panel(
		'america_home',
		array(
			'title'       => __( 'Página inicial (América)', 'america' ),
			'description' => __( 'Textos e imagens da página inicial. Campo deixado em branco volta para o texto original do layout.', 'america' ),
			'priority'    => 25,
		)
	);

	$priority = 10;
	foreach ( america_customizer_sections() as $slug => $section ) {
		$wp_customize->add_section(
			'america_' . $slug,
			array(
				'title'       => $section[0],
				'description' => $section[1],
				'panel'       => 'america_home',
				'priority'    => $priority,
			)
		);
		$priority += 5;
	}

	foreach ( america_customizer_fields() as $key => $field ) {
		$id = 'amr_' . $key;

		$wp_customize->add_setting(
			$id,
			array(
				'default'           => 'image' === $field['type'] ? '' : $field['default'],
				'sanitize_callback' => america_customizer_sanitizer( $field['type'] ),
				'capability'        => 'edit_theme_options',
				'transport'         => 'refresh',
			)
		);

		if ( 'image' === $field['type'] ) {
			$wp_customize->add_control(
				new WP_Customize_Media_Control(
					$wp_customize,
					$id,
					array(
						'label'       => $field['label'],
						'description' => __( 'Sem imagem escolhida, usa a imagem original do layout. O texto alternativo vem da Biblioteca de mídia.', 'america' ),
						'section'     => 'america_' . $field['section'],
						'mime_type'   => 'image',
					)
				)
			);
			continue;
		}

		if ( 'select' === $field['type'] ) {
			$wp_customize->add_control(
				$id,
				array(
					'label'       => $field['label'],
					'description' => 'hero_mode' === $key ? __( 'Enquanto o cliente não escolhe, “Alternar” mostra os dois modelos em sequência. Escolhendo “Cidade” ou “Sócio”, só esse modelo aparece no site.', 'america' ) : '',
					'section'     => 'america_' . $field['section'],
					'type'        => 'radio',
					'choices'     => $field['choices'],
				)
			);
			continue;
		}

		$wp_customize->add_control(
			$id,
			array(
				'label'       => $field['label'],
				'description' => 'url' === $field['type'] ? __( 'Endereço completo (https://…) ou âncora da página, como #contato.', 'america' ) : '',
				'section'     => 'america_' . $field['section'],
				'type'        => 'textarea' === $field['type'] ? 'textarea' : 'text',
			)
		);
	}
}
add_action( 'customize_register', 'america_customize_register' );
