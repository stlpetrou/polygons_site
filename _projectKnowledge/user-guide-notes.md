# User guide notes (P → becomes the handover guide)

Running notes of "how do I change X without the developer". Written for an editor who knows WordPress basics. Turn into the final Greek guide at handover.

## Content (JetEngine — WP admin menu)
* **Έργα** → Add new: title, excerpt (card/hero subtitle), featured image (card + project hero; 4:3 works best, WebP ≤ 1200px), category (Κατηγορίες έργων), fields: Πελάτης, Έτος, Υπηρεσίες, Website, Βασικό αποτέλεσμα, Η πρόκληση / Η λύση / Το αποτέλεσμα, Gallery, **Προβολή στην αρχική** (switch = appears in "Επιλεγμένα έργα", max 3). Order = "Order" field (page attributes). The project page is created automatically.
* **Testimonials** → title = name, text = quote, field "Θέση & εταιρεία". Order field.
* **Πελάτες** → title, featured image = logo (SVG/PNG, transparent, ~200×44), URL.
* **Πακέτα** → title, Ομάδα (Ιστοσελίδες/Hosting = which tab), Σήμα (e.g. «Δημοφιλές» → highlighted card), Για ποιον είναι, Τιμή, Σημείωση τιμής, Τι περιλαμβάνει (repeater rows). Order field.
* **Κατηγορίες έργων** → the filter pills on the portfolio page (alphabetical).

* **Blog** → Posts → Add new (normal WordPress editor): title, text (use Heading 2 for sections), **Excerpt** (= card text *and* Google description, ~150 chars), **Featured image** (16:9 or 4:3), one **Category**. It appears on /blog/ automatically; categories with posts get a filter pill. Layout: Crocoblock → Theme Builder → «Blog — archive» / «Άρθρο — single».

## SEO (Rank Math)
* Every page/post/project: Rank Math box under the editor (or in Elementor: the Rank Math tab) → edit **SEO title** (≤ 60 chars) and **description** (140–160). Green score is a guide, not a goal.
* Breadcrumbs, schema, sitemap (`/sitemap_index.xml`) are automatic. A removed/renamed page → Rank Math → Redirections: add a 301.
* Social image: Rank Math → Titles & Meta → Global → OpenGraph thumbnail (default is `og-default.jpg`); per page in the Social tab.

## Service pages
* Pages → Τι κάνουμε → children «Κατασκευή ιστοσελίδων», «Εταιρική ταυτότητα», «Hosting & συντήρηση», «SEO & digital marketing». Edit in Elementor like any page (features = icon boxes, FAQ = accordion). A new service = duplicate one, set Parent = Τι κάνουμε, add it to the menu under «Τι κάνουμε» (Appearance → Menus, drag it indented) and to «Footer · Υπηρεσίες».

* **404 page**: Crocoblock → Theme Builder → template «404» (edit in Elementor).

## English version (Polylang)
* Every list in WP admin (Pages, Posts, Έργα, Testimonials, Πακέτα) shows a flag column. Greek ↔ English entries are linked as translations. New entry in both languages: create the Greek one → «+» under the English flag → fill it in English (projects: same featured image/gallery/category).
* Menus: Appearance → Menus → «Main menu (EN)» / «Footer · Services (EN)».
* English templates and cards (Crocoblock → Theme Builder / JetEngine → Listings): «Header (EN)», «Footer (EN)», «404 (EN)», «Project — single (EN)», «Blog — archive (EN)», «Article — single (EN)», «Project card (EN)», «Package card (EN)», «Article card (EN)» — used automatically on /en/.
* English forms (JetFormBuilder): «Contact form (EN)», «Quote request (EN, steps)», «Free site audit (EN)». Filter: JetSmartFilters → «Project category (EN)».
* The EL/EN button in the header goes to the translation of the current page, or to the other language's home if there is none.

## Look & feel (Elementor → Site Settings)
* Global Colors: Neon Red (accents/glow), CTA fill (filled buttons — keep AA contrast with white), Text, White, Background, Surface, Muted…
* Global Fonts: Display (Jura), Headings, Body, Eyebrow (small red uppercase kicker), Lead, Small. H1–H3 sizes are fluid (`clamp`).
* Buttons: radius/padding/colours for every button site-wide.

## Pages (Elementor)
* Text/images: edit directly. Section "kicker" above titles = heading with Eyebrow style.
* Contact data (email/phone/hours) currently typed in: Επικοινωνία page (3 icon boxes) + Footer template (Templates → Footer). *(Later: one settings page.)*
* Header/Footer: Crocoblock → Theme Builder → Header / Footer templates. Menus: Appearance → Menus («Κύριο μενού», «Footer · Υπηρεσίες»).
* FAQ: Τι κάνουμε page → accordion widget (items = questions; each item's container = answer). FAQ schema is on automatically.
* Forms (JetFormBuilder → Forms): «Φόρμα επικοινωνίας», «Αίτημα προσφοράς (βήματα)», «Δωρεάν έλεγχος site». Edit fields/options (e.g. budget ranges), email texts (Post Submit Actions) and messages there. Notifications go to **info@polygons.gr**; the visitor gets a confirmation email. All submissions: JetFormBuilder → Form Records.
* Quote page: Pages → «Ζήτα προσφορά» (`/prosfora/`). Every «Ζήτα προσφορά» button links there.
* Chat button: Templates → Footer → HTML widget with `data-tawk="<property>/<widget>"` (change the ID there). Reply to chats from the Tawk.to app; set office hours in the Tawk dashboard. The chat script loads only when a visitor clicks.

## Effects — CSS classes (Elementor → Advanced → CSS Classes)
Add the class to switch an effect on for that element, remove it to switch it off.
| Class | On | Effect |
|---|---|---|
| `fx-mesh` | hero section | #1 interactive polygon mesh |
| `fx-neon-on` | section containing a `.pg-neon` title | #2 neon switching on |
| `fx-draw` | on the HTML widget's wrapper div of the hexagon SVG | #3 logo draws itself |
| `fx-glow` | a container/panel | #4 cursor glow |
| `fx-stack` | container whose children are cards | #5 stacking cards (desktop, auto-off if cards too tall) |
| `fx-stagger` | grid of cards | staggered entrance |
| `fx-hex` | project listing grid | #8 hexagon image reveal |
| `fx-tilt` | project listing grid | #10 3D tilt (desktop) |
| `fx-border` | grid of cards / packages listing | #11 border light (desktop) |
| `fx-magnetic` | a button widget | #12 magnetic button (desktop) |
| (site-wide) | — | #13 page transitions, #14 smart header |
Styling hooks (not effects): `pg-card`, `pg-eyebrow`, `pg-btn pg-btn--primary|--ghost`, `pg-hero`, `pg-page-hero`, `pg-cta__panel`, `pg-section--alt`, `pg-sr-only` (visually hidden heading).

## Don'ts
* Don't type colours/sizes in widgets — use the globals.
* Don't delete the `(δείγμα)` entries before real ones exist (layouts expect content).
* Keep the effects lab page unpublished/noindex.
