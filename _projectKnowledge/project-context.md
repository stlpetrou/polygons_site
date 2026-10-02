# Project context — polygons.gr (P)

## Facts
* Polygons Studio — graphic & web services (web/UI design, branding, hosting, SEO/marketing). Greek market; site copy in Greek, hero signature in English ("The ultimate ALL-IN-ONE Graphic & Web Services").
* Brand: black background, neon red `#F15152` (CTA fill `#D63536` for AA), electric blue `#4A5BFF` glows, Jura (display) + Inter (text), hexagon logo (`logo.svg`).
* Old site (live): only the home had content; inner pages empty; Elementor Pro; 50+ CSS/JS files.
* Container 1440px (Kit), 24px gutter (20px mobile) — changed from 1240 on 2026-09-30 to match the playbook default.
* Local: LocalWP "Polygons", `http://polygons.test`, admin user ID 1. Paths: `app/public`, build scripts `build/`, QA `tools/`.

## Stack in use
Elementor 4.3 free, Kava + child theme `polygons`, Rank Math (free, no account), Polylang (el default, en at /en/), JetThemeCore, JetBlocks, JetEngine (CPTs: projects/Έργα, testimonials, clients, packages; taxonomy project_cat), JetSmartFilters, JetFormBuilder. Inactive: JetElements, JetTricks (not used). Performance mu-plugin `polygons-performance.php`.

## Structure
Pages: Αρχική, Τι κάνουμε (stacked service cards, packages tabs, FAQ), Οι δουλειές μας (listing + category filter), Ποιοι είμαστε, Επικοινωνία (JFB form → record + admin email). Project single via JetThemeCore template at `/oi-doulies-mas/<slug>/` (moved from `/erga/` on 2026-09-30; old URLs 301). Effects Lab at `/effects-lab/` (noindex).

## Effects live
#1 mesh (home hero; touch: loads on first interaction), #2 neon on, #3 logo draw (hero, about), #4 CTA glow, #5 stacking service cards (desktop, fit-checked), #8 hexagon image reveal, #10 tilt, #11 border light, #12 magnetic CTA, #13 view transitions (project card → single), #14 smart header, + staggered entrance on home services. Lab-only: #6 #7 #9 #15 #16 #17.

## Phase 3 (conversion) — done 2026-09-30
* `/prosfora/` multi-step quote form (services → budget & timeline → details), progress bar, records + email to info@ + confirmation to the visitor. All «Ζήτα προσφορά» buttons point there.
* «Δωρεάν έλεγχος» band (URL + email form) on home and services page.
* Chat: Tawk.to (property `6abd4b04fd2d7034457f3282/1k3pmq2dh`) behind our button, loads on click; locally Tawk returns 500 on session start → verify on staging (widget/domain settings in the Tawk dashboard).
* Site email: **info@polygons.gr** (alias). Personal address never on the site.

## Phase 4 (growth) — done 2026-09-30 (EN version pending decision)
* Service pages (children of Τι κάνουμε): `/ti-kanoume/kataskevi-istoselidas/`, `/etairiki-taytotita/`, `/web-hosting/`, `/seo/` — hero + intro + 6 features + 4 steps + packages (web/hosting) + related projects (by project_cat) + service FAQ (schema) + other services + CTA. Linked from home cards, services overview («Αναλυτικά»), main-menu dropdown, footer.
* Blog: native posts, `/blog/` = posts page; JetThemeCore «Blog — archive» + «Άρθρο — single» templates; categories Web design / SEO / Branding (+ Γενικά default); 3 sample guide articles written by us (to review); 9 per page, real pagination. Shortcodes in theme: `[pg_archive_title] [pg_blog_cats] [pg_pagination] [pg_post_meta]`.
* Rank Math: titles/descriptions for every page (content.php `pg_seo_meta()` + service `seo`), OG image `og-default.jpg`, PNG logo, Organization schema, breadcrumbs in every inner hero (+ projects under «Οι δουλειές μας»), sitemap `/sitemap_index.xml` (pages, posts, projects, categories), effects-lab noindex.
* Greek 404 page (JetThemeCore «404» template, neon title + links), Rank Math 404 title in Greek.
* Perf fixes found on the way: unused Swiper CSS dropped site-wide; heading CSS loaded early on template views (blog/post/project CLS → 0).

## Decisions pending / deferred
* Settings page with ON/OFF switches — at the end of setup.
* Switch to "Elementor is the source of truth" (stop build scripts) — when the developer says setup is done.
* Viber/WhatsApp: waiting for a business number (landline + WhatsApp Business or second eSIM). Booking: later (Google Calendar / Calendly / JetAppointment). Optional mobile sticky CTA bar: not built.
* EN version **complete 2026-10-01** (Polylang, `/en/`): every page (home, services + 4 service pages, work, about, blog `/en/articles/`, contact, get-a-quote, 404), all 6 projects, 3 testimonials, 6 packages, 3 articles + categories, EN listing cards/templates (auto-swapped by JetEngine/JetThemeCore), EN contact/quote/audit forms, EN filter. Copy in `build/content-en.php`. Known: CPT base stays `/en/oi-doulies-mas/<slug>/` (Polylang free doesn't translate it).
* CLS work 2026-10-01: metric-matched fallback fonts (Inter/Jura, per subset and weight) via Kit fallback; card images sized with `75cqw`; logo aspect-ratio. CLS 0 on all page types on slow 4G.

## Placeholders (real content not provided yet — developer said keep them)
Contact phone/hours (email is real: info@polygons.gr); 3 blog articles (our drafts); 6 projects (covers, texts, client names); 3 testimonials; 6 client logos; package prices (`€XXX`); counters in the lab.

## Measurements (Lighthouse mobile, local)
After Phase 4: home 93, other pages 92–97; a11y 100 and SEO 100 on all 14 page types; CLS 0. Best-practices 78 = no HTTPS locally.
