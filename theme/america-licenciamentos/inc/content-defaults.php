<?php
/**
 * Conteúdo padrão, idêntico ao index.html estático.
 *
 * Usado em dois lugares:
 * - como fallback dos template-parts enquanto os CPTs estão vazios;
 * - como fonte do importador (Aparência → Importar conteúdo inicial).
 *
 * Caminhos de imagem são relativos a assets/images/ do tema.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

/**
 * Ícones disponíveis para as soluções (sufixo do símbolo #i-doc-*).
 *
 * @return array slug => rótulo no admin.
 */
function america_doc_icons() {
	return array(
		'factory'     => __( 'Fábrica', 'america' ),
		'storefront'  => __( 'Fachada de loja', 'america' ),
		'certificate' => __( 'Certificado', 'america' ),
		'firstaid'    => __( 'Cruz de saúde', 'america' ),
		'shield'      => __( 'Escudo', 'america' ),
		'leaf'        => __( 'Folha', 'america' ),
		'person'      => __( 'Pessoa', 'america' ),
		'bank'        => __( 'Prédio histórico', 'america' ),
		'file'        => __( 'Documento', 'america' ),
	);
}

/**
 * Soluções / documentos (aba "Segurança regulatória").
 *
 * @return array
 */
function america_default_solucoes() {
	return array(
		array(
			'slug'      => 'alvara',
			'title'     => 'Alvará de funcionamento',
			'icon'      => 'factory',
			'tight'     => true,
			'text'      => 'Quem emite é a prefeitura, e ele é o último da fila. Antes dele o município cobra a regularidade da edificação e, conforme a cidade, AVCB e licença sanitária.',
			'link_text' => 'Ver alvará de funcionamento',
			'link_url'  => '#',
			'image'     => 'doc-alvara.jpg',
			'image_alt' => 'Alvará de funcionamento emoldurado — processo enviado',
		),
		array(
			'slug'      => 'habite-se',
			'title'     => 'Habite-se',
			'icon'      => 'storefront',
			'tight'     => true,
			'text'      => 'Sem ele o cartório não averba a construção, o banco não financia e o alvará definitivo não sai. É a trava mais cara do imóvel comercial.',
			'link_text' => 'Ver habite-se',
			'link_url'  => '#',
			'image'     => 'doc-habite-se.jpg',
			'image_alt' => 'Capacete e plantas de obra — certificado liberado',
		),
		array(
			'slug'      => 'avcb',
			'title'     => 'AVCB e CLCB',
			'icon'      => 'certificate',
			'tight'     => true,
			'text'      => 'Auto de Vistoria e Certificado de Licença do Corpo de Bombeiros, sob o Decreto Estadual 69.118/2024, protocolados no Via Fácil Bombeiros. Em São Caetano do Sul, é item da lista oficial do alvará.',
			'link_text' => 'Ver AVCB e CLCB',
			'link_url'  => '#',
			'image'     => 'doc-avcb.jpg',
			'image_alt' => 'Bombeiro — vistoria aprovada',
		),
		array(
			'slug'      => 'sanitaria',
			'title'     => 'Licença sanitária',
			'icon'      => 'firstaid',
			'tight'     => false,
			'text'      => 'Vigilância sanitária municipal, COVISA na capital. Desde a Portaria SMS.G 266/2025, a validade varia conforme a atividade econômica, a maior parte entre 2 e 3 anos.',
			'link_text' => 'Ver licença sanitária',
			'link_url'  => '#',
			'image'     => 'doc-sanitaria.jpg',
			'image_alt' => 'Técnica em inspeção — inspeção sanitária',
		),
		array(
			'slug'      => 'seguranca',
			'title'     => 'Certificado de Segurança (antigo AVS)',
			'icon'      => 'shield',
			'tight'     => false,
			'text'      => 'Existe só na cidade de São Paulo, sob a Lei 16.642/2017 e o Decreto 57.776/2017, emitido pela CONTRU/SMUL. Nas cidades do ABC não existe com esse nome, mas há exigência equivalente.',
			'link_text' => 'Ver Certificado de Segurança',
			'link_url'  => '#',
			'image'     => 'doc-seguranca.jpg',
			'image_alt' => 'Técnico de obra — certificado de segurança',
		),
		array(
			'slug'      => 'ambiental',
			'title'     => 'Licença ambiental',
			'icon'      => 'leaf',
			'tight'     => false,
			'text'      => 'CETESB ou prefeitura, conforme o impacto da atividade e se o município é habilitado. São Caetano do Sul não é: lá é sempre CETESB. A Licença de Operação se renova com 120 dias de antecedência.',
			'link_text' => 'Ver licença ambiental',
			'link_url'  => '#',
			'image'     => 'doc-ambiental.jpg',
			'image_alt' => 'Fábrica — renovação de licença protocolada',
		),
		array(
			'slug'      => 'acessibilidade',
			'title'     => 'Acessibilidade',
			'icon'      => 'person',
			'tight'     => false,
			'text'      => 'Quase nunca é o pedido inicial: é a exigência que aparece dentro do alvará, do AVCB e do habite-se, sob a ABNT NBR 9050:2020.',
			'link_text' => 'Ver acessibilidade',
			'link_url'  => '#',
			'image'     => 'doc-acessibilidade.jpg',
			'image_alt' => 'Rampa de acesso — acessibilidade aprovada',
		),
		array(
			'slug'      => 'patrimonio',
			'title'     => 'Patrimônio histórico',
			'icon'      => 'bank',
			'tight'     => false,
			'text'      => 'Imóvel tombado ou em área envoltória muda o rito e passa por CONPRESP, CONDEPHAAT ou IPHAN antes de voltar para a prefeitura. O CONPRESP só existe na capital.',
			'link_text' => 'Ver patrimônio histórico',
			'link_url'  => '#',
			'image'     => 'doc-patrimonio.jpg',
			'image_alt' => 'Rua histórica — projeto aprovado',
		),
		array(
			'slug'      => 'averbacao',
			'title'     => 'Averbação em cartório',
			'icon'      => 'file',
			'tight'     => false,
			'text'      => 'Sem o habite-se ou o auto de regularização, o cartório não averba a construção (Lei 6.015/73, arts. 167 II e 246 §1º). É a etapa que fecha a regularização e devolve valor ao imóvel.',
			'link_text' => 'Ver averbação em cartório',
			'link_url'  => '#',
			'image'     => 'doc-averbacao.jpg',
			'image_alt' => 'Carimbo em documento — matrícula atualizada',
		),
	);
}

/**
 * Setores (taxonomia amr_setor), na ordem do layout.
 *
 * @return string[]
 */
function america_default_setores() {
	return array( 'Varejo', 'Alimentação', 'Saúde', 'Construção e incorporação', 'Indústria' );
}

/**
 * Clientes. Larguras/alturas de exibição exatamente como no index.html.
 * Setores atribuídos por inferência (o layout não informa o setor de cada logo).
 *
 * @param string $slot 'faixa' (Empresas que confiam) ou 'grade' (Cases).
 * @return array
 */
function america_default_clientes( $slot ) {
	if ( 'faixa' === $slot ) {
		return array(
			array( 'slug' => 'americanas', 'name' => 'Americanas', 'file' => 'clientes/americanas.png', 'w' => 122, 'h' => 24, 'setor' => 'Varejo' ),
			array( 'slug' => 'nissin', 'name' => 'Nissin', 'file' => 'clientes/nissin.png', 'w' => 97, 'h' => 47, 'setor' => 'Alimentação' ),
			array( 'slug' => 'leroy', 'name' => 'Leroy Merlin', 'file' => 'clientes/leroy.png', 'w' => 89, 'h' => 49, 'setor' => 'Varejo' ),
			array( 'slug' => 'western-union', 'name' => 'Western Union', 'file' => 'clientes/western-union.png', 'w' => 112, 'h' => 27, 'setor' => '' ),
			array( 'slug' => 'mantelli', 'name' => 'Clínica Mantelli', 'file' => 'clientes/mantelli.png', 'w' => 117, 'h' => 48, 'setor' => 'Saúde' ),
			array( 'slug' => 'carrefour', 'name' => 'Carrefour', 'file' => 'clientes/carrefour.png', 'w' => 141, 'h' => 24, 'setor' => 'Varejo' ),
			array( 'slug' => 'mitsubishi', 'name' => 'Mitsubishi Motors', 'file' => 'clientes/mitsubishi.png', 'w' => 127, 'h' => 36, 'setor' => 'Indústria' ),
			array( 'slug' => 'sicredi', 'name' => 'Sicredi', 'file' => 'clientes/sicredi.png', 'w' => 133, 'h' => 33, 'setor' => '' ),
			array( 'slug' => 'muzy', 'name' => 'Clínica Muzy', 'file' => 'clientes/muzy.png', 'w' => 103, 'h' => 48, 'setor' => 'Saúde' ),
			array( 'slug' => 'smartfit', 'name' => 'Smart Fit', 'file' => 'clientes/smartfit.png', 'w' => 109, 'h' => 40, 'setor' => '' ),
		);
	}

	return array(
		array( 'slug' => 'leroy', 'name' => 'Leroy Merlin', 'file' => 'cases/leroy.png', 'w' => 82, 'h' => 48, 'setor' => 'Varejo' ),
		array( 'slug' => 'nissin', 'name' => 'Nissin', 'file' => 'cases/nissin.png', 'w' => 93, 'h' => 48, 'setor' => 'Alimentação' ),
		array( 'slug' => 'aacd', 'name' => 'AACD', 'file' => 'cases/aacd.png', 'w' => 45, 'h' => 48, 'setor' => 'Saúde' ),
		array( 'slug' => 'tegra', 'name' => 'Tegra', 'file' => 'cases/tegra.png', 'w' => 116, 'h' => 28, 'setor' => 'Construção e incorporação' ),
		array( 'slug' => 'mitsubishi', 'name' => 'Mitsubishi Motors', 'file' => 'cases/mitsubishi.png', 'w' => 149, 'h' => 56, 'setor' => 'Indústria' ),
		array( 'slug' => 'assai', 'name' => 'Assaí Atacadista', 'file' => 'cases/assai.png', 'w' => 66, 'h' => 48, 'setor' => 'Varejo' ),
		array( 'slug' => 'burger-king', 'name' => 'Burger King', 'file' => 'cases/burger-king.png', 'w' => 46, 'h' => 48, 'setor' => 'Alimentação' ),
		array( 'slug' => 'afip', 'name' => 'AFIP', 'file' => 'cases/afip.png', 'w' => 100, 'h' => 30, 'setor' => 'Saúde' ),
		array( 'slug' => 'auxiliadora', 'name' => 'Auxiliadora Predial', 'file' => 'cases/auxiliadora.png', 'w' => 123, 'h' => 32, 'setor' => 'Construção e incorporação' ),
		array( 'slug' => 'velcro', 'name' => 'Velcro', 'file' => 'cases/velcro.png', 'w' => 128, 'h' => 32, 'setor' => 'Indústria' ),
		array( 'slug' => 'carrefour', 'name' => 'Carrefour', 'file' => 'cases/carrefour.png', 'w' => 141, 'h' => 24, 'setor' => 'Varejo' ),
		array( 'slug' => 'bonduelle', 'name' => 'Bonduelle', 'file' => 'cases/bonduelle.png', 'w' => 121, 'h' => 48, 'setor' => 'Alimentação' ),
		array( 'slug' => 'saude-bandeirantes', 'name' => 'Grupo Saúde Bandeirantes', 'file' => 'cases/saude-bandeirantes.png', 'w' => 176, 'h' => 32, 'setor' => 'Saúde' ),
		array( 'slug' => 'libercon', 'name' => 'Libercon Engenharia', 'file' => 'cases/libercon.png', 'w' => 143, 'h' => 32, 'setor' => 'Construção e incorporação' ),
		array( 'slug' => 'middleby', 'name' => 'Middleby', 'file' => 'cases/middleby.png', 'w' => 152, 'h' => 32, 'setor' => 'Indústria' ),
		array( 'slug' => 'americanas', 'name' => 'Americanas', 'file' => 'cases/americanas.png', 'w' => 122, 'h' => 24, 'setor' => 'Varejo' ),
		array( 'slug' => 'grand-cru', 'name' => 'Grand Cru', 'file' => 'cases/grand-cru.png', 'w' => 150, 'h' => 38, 'setor' => 'Varejo' ),
		array( 'slug' => 'lifesil', 'name' => 'LifeSil', 'file' => 'cases/lifesil.png', 'w' => 104, 'h' => 32, 'setor' => 'Indústria' ),
		array( 'slug' => 'by-engenharia', 'name' => 'By Engenharia', 'file' => 'cases/by-engenharia.png', 'w' => 88, 'h' => 40, 'setor' => 'Construção e incorporação' ),
		array( 'slug' => 'nofor', 'name' => 'Nofor', 'file' => 'cases/nofor.png', 'w' => 102, 'h' => 40, 'setor' => 'Indústria' ),
	);
}

/**
 * Depoimentos. As aspas fazem parte do texto, como no layout.
 *
 * @return array
 */
function america_default_depoimentos() {
	return array(
		array(
			'slug'     => 'sandra-de-freitas-mirpo',
			'name'     => 'Sandra de Freitas',
			'role'     => 'Sócia Diretora, Mirpo Auto Peças',
			'quote'    => '"A América Licenciamentos foi contratada pela Auto Peças Mirpo a fim de resolver uma antiga demanda, na qual desde o início dos trabalhos pudemos observar a seriedade, conhecimento do assunto e objetividade em poder solucionar o processo envolvido. O resultado foi muito satisfatório, o que atesta o profissionalismo e a competência da equipe, proporcionando tranquilidade e confiança no serviço prestado.”',
			'logo'     => 'depoimento-mirpo.png',
			'logo_alt' => 'Mirpo Auto Peças',
		),
	);
}

/**
 * Perguntas frequentes (respostas completas do index.html).
 * 'wide' = espaço de 32px entre o texto e a seta (ajuste do layout na pergunta 6).
 *
 * @return array
 */
function america_default_faqs() {
	return array(
		array(
			'question' => 'Como saber se posso abrir minha empresa em determinado endereço em São Paulo?',
			'answer'   => array(
				'Para saber se uma empresa pode funcionar em determinado endereço, é necessária uma análise de viabilidade que cruze o zoneamento do imóvel, a atividade pretendida, a situação da edificação e as exigências específicas da operação.',
				'Essa análise deve ocorrer antes da compra, da locação ou da reforma, porque o resultado pode influenciar a escolha do local e as adequações necessárias. Um endereço disponível ou um CNPJ ativo não confirmam, por si sós, que o imóvel comporta a operação; a decisão final cabe aos órgãos competentes.',
			),
			'wide'     => false,
		),
		array(
			'question' => 'Alvará de funcionamento e licença de funcionamento são a mesma coisa?',
			'answer'   => array(
				'Os termos costumam ser usados como sinônimos, mas o Decreto 49.969/2008 distingue duas licenças para estabelecimentos permanentes em São Paulo. O Auto de Licença de Funcionamento (ALF) é expedido pelas Subprefeituras.',
				'O Alvará de Funcionamento é expedido pela Secretaria Municipal de Urbanismo e Licenciamento (SMUL) para estabelecimentos com lotação igual ou superior a 250 pessoas destinados a atividades geradoras de público. O decreto fixa prazo máximo de 30 dias para a expedição, contado do pedido com toda a documentação e suspenso enquanto houver comunicado pendente.',
			),
			'wide'     => false,
		),
		array(
			'question' => 'AVCB ou CLCB: qual é a diferença e qual se aplica à minha empresa?',
			'answer'   => array(
				'A diferença está no procedimento: o Auto de Vistoria do Corpo de Bombeiros (AVCB) é emitido após vistoria técnica na edificação, e o Certificado de Licença do Corpo de Bombeiros (CLCB), após a apresentação de documentos comprobatórios.',
				'O enquadramento depende de critérios como área, altura, ocupação e riscos específicos, definidos nas Instruções Técnicas. Na regularização da atividade econômica, o estabelecimento de baixo risco, assim definido pelo Corpo de Bombeiros, fica dispensado de AVCB e CLCB, mas continua obrigado a manter as medidas de segurança contra incêndio (Decreto Estadual 69.118/2024).',
			),
			'wide'     => false,
		),
		array(
			'question' => 'Recebi um comunique-se da Prefeitura de São Paulo. Qual é o prazo para responder?',
			'answer'   => array(
				'Em regra, o prazo para atender um comunique-se da Prefeitura de São Paulo é de 30 dias, contados da publicação no Diário Oficial da Cidade. O comunique-se é o comunicado em que a Prefeitura solicita documentos, correções ou esclarecimentos.',
				'Nos processos de obra e edificação, o prazo pode ser prorrogado uma vez, por mais 30 dias, mediante pedido justificado; nos de licença de funcionamento, também uma vez, por igual período. Sem atendimento no prazo, as normas preveem o indeferimento do pedido (Lei 16.642/2017 e Decretos 57.776/2017 e 49.969/2008).',
			),
			'wide'     => false,
		),
		array(
			'question' => 'A América pode assumir um processo de licenciamento já protocolado por outra empresa?',
			'answer'   => array(
				'A América avalia, caso a caso, a possibilidade de assumir um processo de licenciamento já protocolado por outra empresa. A análise considera o andamento no órgão, as exigências publicadas e os documentos já apresentados, para identificar o que pode ser aproveitado e o que ainda precisa ser atendido. O protocolo, por si só, não comprova licença vigente. O escopo, as condições e os responsáveis pela condução são informados antes do início do trabalho.',
			),
			'wide'     => false,
		),
		array(
			'question' => 'Recebi notificação, multa, embargo de obra ou interdição do estabelecimento. O que fazer primeiro?',
			'answer'   => array(
				'Diante de notificação, multa, embargo de obra ou interdição do estabelecimento, o primeiro passo é identificar o órgão emissor, o tipo de ato, a exigência indicada e os prazos do documento, inclusive o de defesa ou recurso, quando houver.',
				'Com essas informações, a América avalia o caso e as etapas que podem fazer parte da atuação técnica. A liberação da obra ou do estabelecimento depende de decisão formal do órgão competente: o protocolo de um pedido não equivale ao desembargo nem ao encerramento da interdição.',
			),
			'wide'     => true,
		),
		array(
			'question' => 'Imóvel sem habite-se pode ser regularizado e receber licença de funcionamento?',
			'answer'   => array(
				'Em São Paulo, o imóvel sem habite-se pode ser regularizado quando a edificação se enquadra na legislação, e essa regularidade é, em regra, exigida para a licença de funcionamento.',
				'O habite-se corresponde ao Certificado de Conclusão, expedido para obra licenciada; a obra executada sem licença que atende à legislação pode receber o Certificado de Regularização (Lei 16.642/2017). Pela anistia da Lei 17.202/2019, edificações concluídas até 31/07/2014, mesmo com infrações à legislação edilícia, podem ter o pedido protocolado até 30/11/2026 (Decreto 65.481/2026), observados os critérios da lei.',
			),
			'wide'     => false,
		),
		array(
			'question' => 'Clínicas e consultórios precisam de licença sanitária, CMVS e CNES?',
			'answer'   => array(
				'Todo estabelecimento de saúde precisa de inscrição no Cadastro Nacional de Estabelecimentos de Saúde (CNES) antes dos licenciamentos. A licença sanitária, identificada pelo número do Cadastro Municipal de Vigilância em Saúde (CMVS), depende do risco das atividades.',
				'Pela Portaria 266/2025 da Secretaria Municipal da Saúde (SMS), o baixo risco é isento de licença; o médio risco é licenciado pelo Portal Integrador Estadual, sem inspeção prévia, salvo estabelecimentos de pessoa física, que seguem orientações da Coordenadoria de Vigilância em Saúde (COVISA); e o alto risco exige inspeção ou análise documental prévia.',
			),
			'wide'     => false,
		),
		array(
			'question' => 'A América atende somente a cidade de São Paulo?',
			'answer'   => array(
				'Sim. O atendimento da América é exclusivo ao município de São Paulo, capital: o imóvel ou a operação objeto da demanda deve estar localizado na capital. Escritórios de contabilidade de outras cidades podem encaminhar demandas de seus clientes, desde que o imóvel ou a operação esteja no município de São Paulo.',
				'Para casos na capital, o primeiro passo é solicitar o diagnóstico: a equipe faz a triagem e define o escopo e as condições, inclusive comerciais, antes de iniciar.',
			),
			'wide'     => false,
		),
	);
}

/**
 * Posts do blog ("Conteúdos").
 *
 * @return array
 */
function america_default_posts() {
	return array(
		array(
			'slug'      => 'o-que-verificar-antes-de-alugar-um-imovel-comercial',
			'title'     => 'O que verificar antes de alugar um imóvel comercial',
			'excerpt'   => 'Zoneamento, uso da edificação e exigências da atividade: o que cruzar antes de assinar o contrato de locação.',
			'cat'       => 'Viabilidade',
			'date'      => '2026-09-20',
			'image'     => 'blog-01.jpg',
			'image_alt' => 'Profissionais trabalhando em notebooks',
		),
		array(
			'slug'      => 'avcb-clcb-e-licenca-municipal-como-se-relacionam',
			'title'     => 'AVCB, CLCB e licença municipal: como se relacionam',
			'excerpt'   => 'Quando cada documento se aplica, quem emite e como eles se relacionam no licenciamento da empresa.',
			'cat'       => 'Serviços',
			'date'      => '2026-09-20',
			'image'     => 'blog-02.jpg',
			'image_alt' => 'Pastas com documentos',
		),
		array(
			'slug'      => 'cnpj-protocolo-e-licenca-diferencas-e-excecoes',
			'title'     => 'CNPJ, protocolo e licença: diferenças e exceções',
			'excerpt'   => 'Por que um CNPJ ativo ou um protocolo, por si só, não comprovam licença vigente.',
			'cat'       => 'Licenciamento empresarial',
			'date'      => '2026-09-20',
			'image'     => 'blog-03.jpg',
			'image_alt' => 'Mulher sorrindo em frente a prédio comercial',
		),
	);
}

/**
 * Links padrão dos menus (fallback e importador). [rótulo, URL, especial?].
 *
 * @return array
 */
function america_default_menus() {
	return array(
		'principal' => array(
			'name'  => 'Menu principal',
			'items' => array(
				array( 'Início', '#topo' ),
				array( 'Sobre', '#sobre' ),
				array( 'Soluções', '#solucoes' ),
				array( 'Saúde e clínicas', '#solucoes' ),
				array( 'Contadores', '#contadores' ),
				array( 'Cases', '#cases' ),
				array( 'Conteúdos', '#conteudos' ),
			),
		),
		'rodape-1'  => array(
			'name'  => 'Rodapé: Licenciamento e operação',
			'items' => array(
				array( 'Alvará de funcionamento', '#solucoes' ),
				array( 'AVCB e CLCB', '#solucoes' ),
				array( 'Licença sanitária', '#solucoes' ),
				array( 'Licença ambiental', '#solucoes' ),
				array( 'Certificado de segurança (AVS)', '#solucoes' ),
			),
		),
		'rodape-2'  => array(
			'name'  => 'Rodapé: Regularização do imóvel',
			'items' => array(
				array( 'Habite-se e regularização', '#solucoes' ),
				array( 'Acessibilidade', '#solucoes' ),
				array( 'Patrimônio histórico', '#solucoes' ),
				array( 'Registro de imóveis', '#solucoes' ),
			),
		),
		'rodape-3'  => array(
			'name'  => 'Rodapé: Institucional',
			'items' => array(
				array( 'Sobre a America', '#sobre' ),
				array( 'Para escritórios de contabilidade', '#contadores' ),
				array( 'Conteúdos', '#conteudos' ),
				array( 'Política de privacidade', '#', 'privacy' ), // Usa a página de privacidade do WP, se definida.
			),
		),
	);
}
