<?php
/**
 * Página inicial: monta as seções na ordem do Figma (frame 7053:458).
 * Mapa seção → template-part em MODEL.md.
 *
 * @package America
 */

defined( 'ABSPATH' ) || exit;

get_header();

$america_sections = array(
	'hero',         // 2. Heros "Cidade" 7065:3613 e "Sócio" 7022:1370 (slider; modelo no Personalizar)
	'trust',        // 3. Empresas que confiam · 7065:3636
	'decision',     // 4. Decisão empresarial · 7053:588
	'property',     // 5. Imóvel, atividade e operação · 7053:521
	'docs',         // 6. Documentos · 7065:3684
	'method',       // 7. Método América · 7116:1172
	'about',        // 8. Quem faz · 7085:3239
	'cases',        // 9. Cases · 7053:616
	'testimonials', // 10. Depoimentos · 7053:841
	'accountants',  // 11. Para contadores · 7053:869
	'blog',         // 12. Blog · 7053:924
	'faq',          // 13. FAQ · 7053:975
);

foreach ( $america_sections as $america_section ) {
	get_template_part( 'template-parts/' . $america_section );
}

get_footer();
