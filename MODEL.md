# América Licenciamentos — Modelo de dados (WordPress)

Fonte do design: Figma `rtso7UyplM3JxHBBVGfTPS`, frame **Desktop - Página inicial** (`7053:458`, 1440 × 12501).
HTML estático de referência: `index.html` + `assets/`. Tema: `theme/america-licenciamentos/`.

Decisões padrão (não informadas pelo cliente, ajustar se necessário):
- Meta boxes **nativos** (sem ACF).
- Atualização via **Git Updater** (`GitHub Theme URI` no `style.css`).
- Assets do Figma viram mídia importada pelo **seeder** (um clique em Aparência → Importar conteúdo inicial).
- Admin operado por marketing/cliente leigo: campos com rótulos em português e ajuda curta.

## Conteúdo

| Conteúdo | Tipo | Slug WP | Campos principais |
|---|---|---|---|
| Soluções / documentos (aba "Segurança regulatória") | CPT | `amr_solucao` | título, resumo (excerpt), texto do link, URL do link, ícone (select: factory, storefront, certificate, firstaid, shield, leaf, person, bank, file), imagem da aba (featured), ordem (menu_order) |
| Clientes ("Empresas que confiam" e grade de cases) | CPT | `amr_cliente` | nome (título), logo (featured), largura/altura de exibição, setor (taxonomia `amr_setor`: Varejo, Alimentação, Saúde, Construção e incorporação, Indústria), exibir na faixa do topo (checkbox), ordem |
| Depoimentos | CPT | `amr_depoimento` | citação (content), nome, cargo/empresa, logo (featured) |
| Perguntas frequentes | CPT | `amr_faq` | pergunta (título), resposta (content), ordem |
| Conteúdos (blog) | Post nativo | `post` | título, resumo, categoria, data, imagem destacada |
| Etapas do Método América | Customizer | `theme_mod` | 4 × (título, descrição) |
| Impactos ("decisão empresarial") | Customizer | `theme_mod` | 4 × texto |
| Imóvel / Atividade / Operação | Customizer | `theme_mod` | 3 × (título, texto, imagem) |
| Hero | Customizer | `theme_mod` | eyebrow, título, descrição, imagem de fundo, CTA 1/2 (texto + URL) |
| Quem faz (Sobre) | Customizer | `theme_mod` | eyebrow, título, 2 parágrafos, 3 estatísticas (valor + legenda), 3 fotos, citação, autor, cargo |
| Para contadores | Customizer | `theme_mod` | título, 3 parágrafos, imagem, 3 etapas, link |
| Contato global | Customizer | `theme_mod` | telefone, e-mail, horário, endereço, Instagram, LinkedIn, Facebook, CNPJ/razão social |
| Textos das caixas de CTA | Customizer | `theme_mod` | 3 textos + URL do botão "Solicitar diagnóstico" |
| Home | Página única | `/` (front-page.php) | montada pelos template-parts acima |

## Mapa de seções (Figma → template-part)

| Ordem | Seção | Node ID | Template-part |
|---|---|---|---|
| 1 | Header | 7053:459 | `header.php` |
| 2 | Hero | 7065:3613 | `template-parts/hero.php` |
| 3 | Empresas que confiam | 7065:3636 | `template-parts/trust.php` |
| 4 | Decisão empresarial | 7053:588 | `template-parts/decision.php` |
| 5 | Imóvel, atividade e operação | 7053:521 | `template-parts/property.php` |
| 6 | Documentos (9 abas) | 7065:3684 / 7001:768 | `template-parts/docs.php` |
| 7 | Método América | 7116:1172 | `template-parts/method.php` |
| 8 | Quem faz (3 fotos) | 7085:3239 / 7001:2271 | `template-parts/about.php` |
| 9 | Cases | 7053:616 | `template-parts/cases.php` |
| 10 | Depoimentos | 7053:841 | `template-parts/testimonials.php` |
| 11 | Para contadores | 7053:869 | `template-parts/accountants.php` |
| 12 | Blog | 7053:924 | `template-parts/blog.php` |
| 13 | FAQ | 7053:975 (respostas: 7101:638) | `template-parts/faq.php` |
| 14 | Footer | 7053:1035 | `footer.php` |

## Tokens estruturais

`--frame-w: 1440px` · `--content-w: 1216px` · `--section-px: clamp(20px, 7.78vw, 112px)` · `--content-gap: 56px`
