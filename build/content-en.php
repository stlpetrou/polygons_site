<?php
/**
 * English copy (Polylang, /en/). Mirrors content.php; keys match the Greek functions.
 * Every Greek page, project, testimonial, package and article has an English translation.
 */

function pg_en_services() {
	return array(
		'web'       => array(
			'n'     => '01',
			'title' => 'Web & UI Design',
			'short' => 'Websites and interfaces that do more than look good: they load fast, work flawlessly on every screen and move visitors to the next step.',
			'long'  => 'We design and build user-centred websites. We start with structure and navigation, move on to the visual layer and end with a fast, secure site you can easily manage yourself.',
			'for'   => 'businesses that want a site that brings in clients',
			'time'  => '3–6 weeks',
			'list'  => array( 'Business websites & landing pages', 'UI/UX design and prototyping', 'Responsive design for every screen', 'Online stores (e-shop)', 'Speed & Core Web Vitals optimisation' ),
		),
		'branding'  => array(
			'n'     => '02',
			'title' => 'Brand Identity & Graphics',
			'short' => 'Logo, colours, typography and applications that give your business a recognisable, consistent image, online and offline.',
			'long'  => 'A brand identity is the set of visual elements that make a brand recognisable: logo, colours, typography and tone. We design them to tell your story consistently at every touchpoint.',
			'for'   => 'new businesses and brands ready for a refresh',
			'time'  => '2–4 weeks',
			'list'  => array( 'Logo design', 'Brand identity & guidelines', 'Business cards & stationery', 'Social media graphics', 'Packaging & promotional material' ),
		),
		'hosting'   => array(
			'n'     => '03',
			'title' => 'Hosting & Maintenance',
			'short' => 'Fast, secure servers, SSL, backups and updates. We keep your site online, you focus on your business.',
			'long'  => 'We go beyond plain hosting: we look after speed, security and updates on servers tuned for WordPress, behind Cloudflare, so you never have to think about it.',
			'for'   => 'anyone who wants their site in safe hands',
			'time'  => 'live within 1 day',
			'list'  => array( 'Fast, secure WordPress hosting', 'SSL certificate & regular backups', 'Updates & security monitoring', 'Business email', 'Support from real people' ),
		),
		'marketing' => array(
			'n'     => '04',
			'title' => 'SEO & Digital Marketing',
			'short' => 'Technical SEO, content and campaigns that bring the right visitors and turn them into clients.',
			'long'  => 'A beautiful site needs visitors. With technical SEO, targeted content and advertising on the channels that matter, we help the people looking for exactly what you offer find you.',
			'for'   => 'businesses that want more clients online',
			'time'  => 'ongoing, results from month 3',
			'list'  => array( 'Technical SEO & SEO audit', 'Keyword research & content', 'Local SEO & Google Business Profile', 'Google Ads & social media ads', 'Analytics & monthly reports' ),
		),
	);
}

function pg_en_why() {
	return array(
		array( 'fas fa-layer-group', 'All in one place', 'Design, development, hosting and marketing from the same team. No middlemen, no lost emails.' ),
		array( 'fas fa-bolt', 'Speed that counts', 'We build for performance: optimised sites that load fast and that Google likes.' ),
		array( 'fas fa-bullseye', 'Design with a purpose', 'Every design decision serves a goal: to make you stand out and bring results.' ),
		array( 'fas fa-headset', 'Support after launch', 'We don’t disappear after delivery. We’re here for changes, updates and growth.' ),
	);
}

function pg_en_steps() {
	return array(
		array( 'Discovery', 'We learn about your business, your audience and your goals.' ),
		array( 'Design', 'Structure, wireframes and a visual proposal for your approval.' ),
		array( 'Build', 'We develop, test and optimise for every device.' ),
		array( 'Launch & grow', 'We go live and keep going with hosting, SEO and support.' ),
	);
}

function pg_en_values() {
	return array(
		array( 'fas fa-magic', 'Creativity', 'We don’t copy trends. We look for the idea that fits only you.' ),
		array( 'fas fa-handshake', 'Transparency', 'Clear prices, clear timelines, clear communication at every step.' ),
		array( 'fas fa-rocket', 'Explorer’s spirit', 'We try new tools and techniques so you’re always a step ahead.' ),
	);
}

function pg_en_story() {
	return '<p>Our name is no accident. Just as a polygon is made of many sides joined into one shape, a business’s digital presence needs design, technology, hosting and promotion working together.</p>'
		. '<p>At Polygons we bring all these sides under one roof. You get one partner who knows your project from start to finish, and a result that holds up from every angle.</p>';
}

function pg_en_faq() {
	return array(
		array( 'How much does a website cost?', 'It depends on the size and the features you need. For online stores or more complex projects we prepare a written quote after a short call. No hidden fees.' ),
		array( 'How long until my site is ready?', 'A business website usually takes 3–6 weeks and an online store 6–10, depending on content and rounds of feedback. You know the timeline from day one.' ),
		array( 'Can I edit texts and images myself?', 'Yes. Every site comes with an easy content management system and a short training session, so you can make everyday changes on your own.' ),
		array( 'Do you work with clients outside Greece?', 'Yes. We work remotely with clear written briefs, video calls and shared previews at every step.' ),
		array( 'Do you handle hosting and the domain?', 'Yes. We register the domain, host the site on fast servers with SSL and backups, and set up your business email.' ),
		array( 'What happens after launch?', 'We keep going together: maintenance plans cover updates, security and small changes, and we’re here whenever you need something new.' ),
	);
}

function pg_en_contact_info() {
	return array(
		array( 'fas fa-envelope', 'Email', '<a href="mailto:info@polygons.gr">info@polygons.gr</a>' ),
		array( 'fas fa-phone', 'Phone', '<a href="tel:+302100000000">+30 210 000 0000</a>' ),
		array( 'fas fa-clock', 'Hours', 'Monday – Friday, 09:00 – 17:00 (Athens time)' ),
	);
}

/** Title + meta description per EN page slug (Rank Math). */
function pg_en_seo_meta() {
	return array(
		'home'     => array( 'Polygons | Web design, branding, hosting & SEO studio', 'Design studio in Greece for websites, brand identity, hosting and SEO. Fast, beautiful sites that bring in clients, from one partner.' ),
		'services' => array( 'Services: web design, branding, hosting & SEO | Polygons', 'Web design, brand identity, hosting and SEO from one team. See what each service includes and answers to common questions.' ),
		'about'    => array( 'About us | Polygons design studio', 'Meet Polygons: a creative studio that brings design, technology, hosting and marketing together to make your digital presence stand out.' ),
		'contact'  => array( 'Contact | Polygons', 'Tell us about your project or email info@polygons.gr. We usually reply within the same working day.' ),
	);
}

function pg_en_form_blocks() {
	return '<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"label":"Full name","name":"name","required":true,"autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"name","placeholder":"Your name"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"email","label":"Email","name":"email","required":true,"autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"email","placeholder":"you@example.com"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"label":"Company","name":"company","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"organization","placeholder":"Optional"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/select-field {"field_options":[{"label":"Web & UI Design","value":"web"},{"label":"Brand Identity & Graphics","value":"branding"},{"label":"Hosting & Maintenance","value":"hosting"},{"label":"SEO & Digital Marketing","value":"seo"},{"label":"Something else / Not sure","value":"other"}],"label":"What are you interested in?","name":"service","placeholder":"Choose a service"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:jet-forms/textarea-field {"label":"Message","name":"message","required":true,"placeholder":"Tell us a little about your project, budget and timeline"} /-->

<!-- wp:jet-forms/submit-field {"label":"Send message"} /-->';
}

/* ======================================================= Full EN version */

function pg_en_service_url( $key ) {
	return '/en/services/' . pg_en_service_pages()[ $key ]['slug'] . '/';
}

/** Service pages (/en/services/<slug>/), same structure as pg_service_pages(). */
function pg_en_service_pages() {
	return array(
		'web'       => array(
			'slug'     => 'web-design',
			'menu'     => 'Web design',
			'eyebrow'  => 'Web & UI Design',
			'h1'       => 'Websites that<br>bring in clients.',
			'lead'     => 'We design and build fast, secure WordPress sites that you manage yourself and that guide visitors to the next step.',
			'intro_h'  => 'Your website is your first impression.',
			'intro'    => '<p>A website is often a client’s first contact with your business. If it’s slow, confusing or broken on mobile, visitors leave before they even learn what you offer.</p><p>That’s why we start from your goals and from what your clients are looking for. We plan the structure, design the experience and build a site that is fast by nature, not “fixed” afterwards.</p>',
			'features' => array(
				array( 'fas fa-mobile-alt', 'Mobile first', 'Most visitors arrive on a phone. We design for them first, then for larger screens.' ),
				array( 'fas fa-tachometer-alt', 'Speed & Core Web Vitals', 'A 90+ Google PageSpeed target: lean code, properly sized images, proper caching.' ),
				array( 'fas fa-search', 'SEO from day one', 'Clean structure, titles, meta, schema and sitemap. Your site is ready for Google.' ),
				array( 'fas fa-edit', 'Manage it yourself', 'Edit texts, images and projects on your own, with short training and a written guide.' ),
				array( 'fas fa-universal-access', 'Accessibility', 'Proper contrast, keyboard navigation and screen-reader labels. Better for everyone.' ),
				array( 'fas fa-shield-alt', 'Security & backups', 'SSL, updates and regular backups keep your site online and protected.' ),
			),
			'process'  => array(
				array( 'Discovery & goals', 'We talk about your business, your audience and what the site must achieve.' ),
				array( 'Structure & wireframes', 'We define pages, content and the visitor journey before any colour.' ),
				array( 'Design & build', 'A visual proposal for approval, then a WordPress build tested on every device.' ),
				array( 'Checks & launch', 'Speed, SEO and forms are checked before going live. Then we stay by your side.' ),
			),
			'cats'     => array( 'web-design', 'e-shop' ),
			'packages' => 'web',
			'faq'      => array(
				array( 'Which platform do you build on?', 'WordPress, the most widely used platform in the world. Your site is never locked to one vendor and is easy to manage.' ),
				array( 'How many pages do I need?', 'For most businesses 5–8 are enough: home, services, work, about, contact. A page per service helps a lot with Google. We’ll suggest the right structure from the start.' ),
				array( 'Will you write the copy?', 'We can. Usually we write a first draft after our discovery call and you refine it, because nobody knows your business better than you.' ),
				array( 'Do you build online stores?', 'Yes, with WooCommerce: online payments, courier integration, stock management and a design that makes buying on mobile easy.' ),
			),
			'seo'      => array( 'Web design & WordPress websites | Polygons', 'Web design and online stores on WordPress: fast, responsive, SEO-ready and easy to manage. Get a quote from Polygons.' ),
		),
		'branding'  => array(
			'slug'     => 'brand-identity',
			'menu'     => 'Brand identity',
			'eyebrow'  => 'Branding & Graphics',
			'h1'       => 'A brand identity<br>people remember.',
			'lead'     => 'Logo, colours, typography and applications that give your brand a consistent, recognisable image: on your site, on social and in print.',
			'intro_h'  => 'People judge you before they read you.',
			'intro'    => '<p>Clients form an opinion within seconds, long before they read what you do. A well-designed identity signals professionalism and sets you apart from the competition.</p><p>We don’t just design a logo. We create a system of colours, typefaces and rules that works just as well on a business card, a social post and a shop sign.</p>',
			'features' => array(
				array( 'fas fa-pen-nib', 'Logo design', 'Original concepts with a rationale, in every version: horizontal, stacked, symbol, one colour.' ),
				array( 'fas fa-palette', 'Colours & typography', 'A palette and typefaces that match the brand’s character and read well everywhere.' ),
				array( 'fas fa-book', 'Brand guidelines', 'A short guide to using the identity, so it stays consistent whoever you work with.' ),
				array( 'fas fa-id-card', 'Stationery', 'Business cards, letterheads, folders, presentations and proposals with one look.' ),
				array( 'fas fa-hashtag', 'Social media graphics', 'Templates for posts, stories and ads that your team can use on its own.' ),
				array( 'fas fa-box-open', 'Packaging & signage', 'Labels, packaging, signs and trade-show material, ready for print.' ),
			),
			'process'  => array(
				array( 'Research', 'We learn your story, your audience and your competitors.' ),
				array( 'Direction', 'A moodboard with style, colours and references, agreed before we design.' ),
				array( 'Concepts', 'Logo concepts with a rationale and rounds of refinement until we land it.' ),
				array( 'Applications & delivery', 'Files for every use (web and print) and a guide to using the identity.' ),
			),
			'cats'     => array( 'branding', 'graphics' ),
			'packages' => '',
			'faq'      => array(
				array( 'In what format will I get the logo?', 'Vector files (SVG, PDF) for print and PNG/SVG for web and social, in every colour version.' ),
				array( 'How many logo concepts will I see?', 'Usually 2–3 different directions. Then we refine together the one that represents you.' ),
				array( 'Can you refresh my existing logo?', 'Yes. A refresh often keeps the recognition you’ve built and simply brings it up to date.' ),
				array( 'Do I need a new website too?', 'Not necessarily. But if we design them together, your identity and your site speak the same language from day one.' ),
			),
			'seo'      => array( 'Brand identity & logo design | Polygons', 'Logo design, brand identity, brand guidelines, stationery and social media graphics. A consistent, recognisable image for your brand.' ),
		),
		'hosting'   => array(
			'slug'     => 'web-hosting',
			'menu'     => 'Hosting & maintenance',
			'eyebrow'  => 'Hosting & Maintenance',
			'h1'       => 'Hosting & maintenance<br>without the stress.',
			'lead'     => 'Fast servers, SSL, backups, updates and people who answer. We keep your site online, you focus on your business.',
			'intro_h'  => 'Where your site lives matters.',
			'intro'    => '<p>A site that goes down, slows down or gets hacked costs you clients and reputation. Most of the time the problem isn’t the site itself, but where it’s hosted and who looks after it.</p><p>We host sites on servers we tune for WordPress, behind Cloudflare for speed and protection, and we monitor them so we catch problems early.</p>',
			'features' => array(
				array( 'fas fa-server', 'Servers for WordPress', 'An environment tuned for speed, with server-level caching.' ),
				array( 'fas fa-cloud', 'Cloudflare on every site', 'CDN, attack protection and fast loading from anywhere.' ),
				array( 'fas fa-lock', 'Free SSL', 'Secure https connection with automatic certificate renewal.' ),
				array( 'fas fa-history', 'Regular backups', 'Off-server backups with fast restores when needed.' ),
				array( 'fas fa-sync-alt', 'Updates & monitoring', 'Safe WordPress and plugin updates, uptime monitoring.' ),
				array( 'fas fa-envelope-open-text', 'Business email', 'Email on your domain, set up properly so it doesn’t land in spam.' ),
			),
			'process'  => array(
				array( 'Review', 'We look at what you have today: domain, email, site and DNS.' ),
				array( 'Migration', 'We move site and email with a plan, so there’s no downtime.' ),
				array( 'Setup', 'Cloudflare, SSL, caching and backups, ready from day one.' ),
				array( 'Care', 'Updates, monitoring and support whenever you need it.' ),
			),
			'cats'     => array(),
			'packages' => 'hosting',
			'faq'      => array(
				array( 'Can you move my site from another host?', 'Yes. We handle the whole migration (files, database, email) and plan it so there’s no downtime.' ),
				array( 'What if my site goes down or gets hacked?', 'We monitor it and get notified immediately. With backups we quickly restore the last healthy version and close the gap.' ),
				array( 'Do you host sites you didn’t build?', 'Usually yes, after a review to check their state and whether anything needs fixing before the move.' ),
				array( 'What is Cloudflare and why do I need it?', 'A network that sits in front of your site: it makes it faster, protects it from attacks and hides the server. Nothing changes in your daily use.' ),
			),
			'seo'      => array( 'Web hosting & WordPress maintenance | Polygons', 'Fast, secure WordPress hosting with Cloudflare, SSL, backups, updates and business email. Site migration without downtime.' ),
		),
		'marketing' => array(
			'slug'     => 'seo',
			'menu'     => 'SEO & digital marketing',
			'eyebrow'  => 'SEO & Marketing',
			'h1'       => 'SEO & digital marketing<br>that brings in clients.',
			'lead'     => 'Technical SEO, content, Google Business Profile and advertising. We help the people looking for exactly what you offer find you.',
			'intro_h'  => 'A site without visitors is a shop window on an empty street.',
			'intro'    => '<p>Your clients search Google every day for what you offer. The question is whether they find you or your competitor.</p><p>We start with an audit of your site and your market, fix what holds you back and steadily build content and reputation. No “page one in a week” promises, just measurable progress every month.</p>',
			'features' => array(
				array( 'fas fa-stethoscope', 'SEO audit', 'Speed, structure, indexing and content review, with a priority list.' ),
				array( 'fas fa-cogs', 'Technical SEO', 'Speed, schema, sitemap, redirects and fixes Google notices quickly.' ),
				array( 'fas fa-key', 'Keywords & content', 'We find what your clients search for and write pages and articles that answer.' ),
				array( 'fas fa-map-marker-alt', 'Local SEO', 'Google Business Profile, reviews and local searches, so people nearby find you.' ),
				array( 'fas fa-bullhorn', 'Google Ads & social ads', 'Targeted campaigns with a clear budget and cost per client tracked.' ),
				array( 'fas fa-chart-line', 'Analytics & reports', 'A monthly report in plain language: what we did, what changed, what’s next.' ),
			),
			'process'  => array(
				array( 'Audit', 'SEO audit of your site and competitor analysis.' ),
				array( 'Strategy', 'Goals, keywords and a work plan for the coming months.' ),
				array( 'Execution', 'Technical fixes, new content, Google Business Profile and campaigns.' ),
				array( 'Measure', 'Monthly report and plan adjustments based on results.' ),
			),
			'cats'     => array( 'seo' ),
			'packages' => '',
			'faq'      => array(
				array( 'How soon will I see results?', 'Technical fixes often show within weeks. For steady growth in competitive searches, allow 3–6 months of continuous work.' ),
				array( 'Do you guarantee first place on Google?', 'No, and be careful with anyone who does: nobody controls Google. We guarantee proper work, transparency and measurable progress.' ),
				array( 'Do I need SEO if I already advertise?', 'Ads bring visitors while you pay. SEO builds visibility that lasts. Most businesses win with both.' ),
				array( 'Do you do SEO on sites you didn’t build?', 'Yes. We start with an audit and tell you honestly whether the site needs fixes or a rebuild to perform.' ),
			),
			'seo'      => array( 'SEO & digital marketing for businesses | Polygons', 'Technical SEO, local SEO, Google Business Profile, content and ads. Bring the clients already searching for what you offer to your site.' ),
		),
	);
}

/** EN translations of the sample projects, same order as pg_projects(). */
function pg_en_projects() {
	$client = 'Client name (sample)';
	return array(
		array( 'slug' => 'business-website-engineering-company', 'title' => 'Business website for an engineering company', 'client' => $client, 'services' => 'Web design · Development · Hosting',
			'excerpt' => 'A new, fast website that presents the services clearly and brings in quote requests.', 'highlight' => 'New site focused on quote requests',
			'challenge' => 'The old site was slow, hard to update and didn’t explain clearly what the company offers.', 'solution' => 'New content architecture, a page per service, clear calls to action and speed optimisation.',
			'result' => 'A modern site the company manages itself, leading visitors to request a quote.', 'content' => '<p>Describe the project in more detail here: goals, technologies, collaboration with the client.</p>' ),
		array( 'slug' => 'cafe-restaurant-rebranding', 'title' => 'Rebranding for a café-restaurant', 'client' => $client, 'services' => 'Logo · Brand identity · Print',
			'excerpt' => 'A new identity with character, from the logo to the menus and signage.', 'highlight' => 'New logo and full brand book',
			'challenge' => 'The brand didn’t stand out in a highly competitive neighbourhood and lacked a consistent image.', 'solution' => 'Logo, colour palette and typography with a warm, modern feel, applied to menus, social and signage.',
			'result' => 'A recognisable identity used consistently at every touchpoint.', 'content' => '<p>Describe the project in more detail here.</p>' ),
		array( 'slug' => 'cosmetics-online-store', 'title' => 'Online store for a cosmetics brand', 'client' => $client, 'services' => 'E-shop · UI/UX · SEO',
			'excerpt' => 'An online store with easy mobile checkout, online payments and courier integration.', 'highlight' => 'Full e-shop with online payments',
			'challenge' => 'Sales happened only through social media and messages, with a lot of manual work.', 'solution' => 'A mobile-first e-shop with fast checkout, online payments and automatic stock updates.',
			'result' => 'Orders now come in automatically, 24 hours a day.', 'content' => '<p>Describe the project in more detail here.</p>' ),
		array( 'slug' => 'gym-social-media-campaign', 'title' => 'Social media campaign for a gym', 'client' => $client, 'services' => 'Graphics · Social media',
			'excerpt' => 'A visual campaign for the season launch across all of the brand’s channels.', 'highlight' => 'One visual style across all channels',
			'challenge' => 'Posts were fragmented and didn’t feel connected.', 'solution' => 'A system of templates, colours and photo style for posts, stories and ads.',
			'result' => 'A consistent campaign the client’s team can continue on its own.', 'content' => '<p>Describe the project in more detail here.</p>' ),
		array( 'slug' => 'event-landing-page', 'title' => 'Landing page for a professional event', 'client' => $client, 'services' => 'Landing page · Registration form',
			'excerpt' => 'One page with all the event information and online registration.', 'highlight' => 'Online registration on one page',
			'challenge' => 'Registrations came in by email and phone, which made organising difficult.', 'solution' => 'A landing page with programme, speakers and a registration form with automatic confirmation.',
			'result' => 'All registrations in one place, with no manual work.', 'content' => '<p>Describe the project in more detail here.</p>' ),
		array( 'slug' => 'local-seo-medical-practice', 'title' => 'Local SEO for a medical practice', 'client' => $client, 'services' => 'Local SEO · Google Business Profile',
			'excerpt' => 'Better visibility in local searches and on Google Maps.', 'highlight' => 'Optimised Google Business Profile',
			'challenge' => 'Despite its good reputation, the practice didn’t appear in local searches.', 'solution' => 'Technical SEO on the site, Google Business Profile optimisation and a review strategy.',
			'result' => 'More visibility where local patients are searching.', 'content' => '<p>Describe the project in more detail here.</p>' ),
	);
}

function pg_en_testimonials() {
	return array(
		array( 'name' => 'Full Name', 'role' => 'Role, Company (sample)', 'quote' => 'From the first meeting I felt we spoke the same language. Our new site is fast, beautiful and, most importantly, it brings us clients.' ),
		array( 'name' => 'Full Name', 'role' => 'Role, Company (sample)', 'quote' => 'We had one partner for everything: logo, website and hosting. No hassle, clear timelines and quick answers to every question.' ),
		array( 'name' => 'Full Name', 'role' => 'Role, Company (sample)', 'quote' => 'The team understood what we needed before we even explained it. The result exceeded our expectations.' ),
	);
}

function pg_en_packages() {
	return array(
		array( 'title' => 'Starter', 'badge' => '', 'subtitle' => 'For professionals and small businesses', 'price' => 'from €XXX', 'note' => 'one-off',
			'features' => array( 'Up to 5 pages', 'Responsive design', 'Contact form', 'Basic SEO setup', 'Content management training' ) ),
		array( 'title' => 'Business', 'badge' => 'Popular', 'subtitle' => 'For businesses that want to stand out', 'price' => 'from €XXX', 'note' => 'one-off',
			'features' => array( 'Up to 12 pages', 'Custom design', 'Blog / news', 'SEO setup & Google Analytics', 'Speed optimisation', 'Content management training' ) ),
		array( 'title' => 'E-shop', 'badge' => '', 'subtitle' => 'For selling online', 'price' => 'from €XXX', 'note' => 'one-off',
			'features' => array( 'Online store', 'Online payments', 'Courier integration', 'Product & stock management', 'Product SEO', 'Content management training' ) ),
		array( 'title' => 'Basic', 'badge' => '', 'subtitle' => 'For small sites and landing pages', 'price' => '€XX', 'note' => '/month',
			'features' => array( 'Fast SSD servers', 'Free SSL', 'Weekly backups', 'Business email', 'Email support' ) ),
		array( 'title' => 'Pro', 'badge' => 'Recommended', 'subtitle' => 'For business sites with traffic', 'price' => '€XX', 'note' => '/month',
			'features' => array( 'Everything in Basic', 'Daily backups', 'WordPress & plugin updates', 'Security monitoring', 'Priority support' ) ),
		array( 'title' => 'Business', 'badge' => '', 'subtitle' => 'For e-shops and demanding projects', 'price' => '€XX', 'note' => '/month',
			'features' => array( 'Everything in Pro', 'More server resources', 'Speed optimisation', 'Monthly report', 'Phone support' ) ),
	);
}

function pg_en_blog_cats() {
	return array( 'web-design' => array( 'website-tips', 'Web design' ), 'seo' => array( 'seo-tips', 'SEO' ), 'branding' => array( 'branding-tips', 'Branding' ) );
}

/** EN translations of the sample articles, same order as pg_posts(). */
function pg_en_posts() {
	return array(
		array(
			'slug' => 'how-fast-should-a-website-be', 'title' => 'How fast should a website be?',
			'excerpt' => 'Core Web Vitals in plain words: what Google measures, the usual problems and how we fix them.',
			'content' => pg_blocks( array(
				'p:When a site is slow, visitors don’t wait: they go back to Google and click the next result. Speed isn’t a technical detail, it’s the first thing your client “sees”.',
				'h:What Google measures',
				'p:Google rates the loading experience with three metrics, the Core Web Vitals:',
				'ul:<strong>LCP</strong> (Largest Contentful Paint): how fast the main content appears. Target: under 2.5 seconds.|<strong>INP</strong> (Interaction to Next Paint): how fast the page responds when you tap something. Target: under 200 ms.|<strong>CLS</strong> (Cumulative Layout Shift): whether content “jumps” as it loads. Target: under 0.1.',
				'h:The usual problems',
				'p:In the audits we run we see the same things again and again: huge images, dozens of plugins loading code on every page, heavy themes with unused features and cheap hosting without caching.',
				'h:How we fix them',
				'ul:Images in WebP, at the right size, lazy-loaded.|Code only where it’s needed, not on every page.|Fonts hosted on the site itself.|Server caching and Cloudflare in front of every site.',
				'p:Want to know where your site stands? <a href="/en/#free-audit">Request a free audit</a> and we’ll send you a short report.',
			) ),
		),
		array(
			'slug' => 'local-seo-7-steps', 'title' => 'Local SEO: 7 steps to get found in your area',
			'excerpt' => 'From Google Business Profile to reviews: what it takes to appear on the map when people search nearby.',
			'content' => pg_blocks( array(
				'p:When someone searches “dentist near me” or “coffee in Chalandri”, Google first shows a map with a few businesses. Those spots get most of the calls. Here’s how to claim one.',
				'h:1. Claim your Google Business Profile',
				'p:It’s free and it’s the foundation of local SEO. Verify the business and fill in every field: hours, services, service areas.',
				'h:2. Choose the right category',
				'p:The primary category strongly affects which searches you appear in. Pick the most specific one that describes you.',
				'h:3. Same details everywhere',
				'p:Business name, address and phone must be written exactly the same on your site, your profile and in directories.',
				'h:4. Reviews, systematically',
				'p:Ask every happy client for a review and reply to all of them, including the negative ones.',
				'h:5. Photos & posts',
				'p:Real photos of your space and your work, and regular posts with news and offers.',
				'h:6. A page for every service',
				'p:On your site, every main service needs its own page, mentioning the areas you serve.',
				'h:7. A fast, mobile-friendly site',
				'p:Most local searches happen on mobile. If the site is slow, the client calls the next business.',
				'p:Need help? See what we do in <a href="/en/services/seo/">SEO & digital marketing</a>.',
			) ),
		),
		array(
			'slug' => 'logo-vs-brand-identity', 'title' => 'Logo or brand identity? The difference that matters',
			'excerpt' => 'A logo is just the beginning. What a brand identity is, why consistency matters and what to ask your designer for.',
			'content' => pg_blocks( array(
				'p:Many businesses start by asking for “a logo”. Makes sense, it’s the most visible part. But the logo is only the beginning.',
				'h:The logo',
				'p:It’s your signature: a symbol or a word that makes you recognisable. It must be simple, readable at small sizes and work in one colour.',
				'h:The brand identity',
				'p:It’s the system around the logo: colours, typefaces, photo style, icons and the rules for combining them. Thanks to it, a post, a business card and a web page look like they come from the same brand.',
				'h:Why consistency matters',
				'p:Every time someone sees your brand the same way, they remember it a little better. When every piece is made “from scratch”, that recognition is lost.',
				'h:What to ask your designer for',
				'ul:The logo in every version: horizontal, stacked, symbol, one colour.|Vector files for print and files for web.|A colour palette with codes for screen and print.|A short usage guide.',
				'p:See how we approach <a href="/en/services/brand-identity/">brand identity</a>.',
			) ),
		),
	);
}

function pg_en_quote_form_blocks() {
	$opts = function ( array $pairs ) {
		$o = array();
		foreach ( $pairs as $v => $l ) {
			$o[] = array( 'label' => $l, 'value' => $v );
		}
		return wp_json_encode( $o, JSON_UNESCAPED_UNICODE );
	};
	$services = $opts( array( 'website' => 'Website', 'eshop' => 'Online store', 'branding' => 'Logo / brand identity', 'hosting' => 'Hosting & maintenance', 'seo' => 'SEO & digital marketing', 'other' => 'Something else' ) );
	$budget   = $opts( array( 'upto-1200' => 'Up to €1,200', '1200-3000' => '€1,200 – 3,000', '3000-6000' => '€3,000 – 6,000', '6000-plus' => '€6,000 and up', 'unknown' => 'Not sure yet' ) );
	$timeline = $opts( array( 'asap' => 'Right away (this month)', '1-3-months' => 'In 1–3 months', 'flexible' => 'No rush' ) );
	return '<!-- wp:jet-forms/checkbox-field {"field_options":' . $services . ',"label":"What do you need?","desc":"Choose all that apply.","name":"services","required":true,"class_name":"pg-choice"} /-->

<!-- wp:jet-forms/text-field {"field_type":"url","label":"Current website (if any)","name":"current_site","placeholder":"https://","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"url"} /-->

<!-- wp:jet-forms/form-break-field {"label":"Next","label_progress":"What you need"} /-->

<!-- wp:jet-forms/radio-field {"field_options":' . $budget . ',"label":"Budget","desc":"Indicative, excluding VAT. It helps us suggest the right solution.","name":"budget","required":true,"class_name":"pg-choice"} /-->

<!-- wp:jet-forms/radio-field {"field_options":' . $timeline . ',"label":"When would you like to start?","name":"timeline","required":true,"class_name":"pg-choice"} /-->

<!-- wp:jet-forms/form-break-field {"label":"Next","label_progress":"Budget & timing","add_prev":true,"prev_label":"Back"} /-->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"label":"Full name","name":"name","required":true,"placeholder":"Your name","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"name"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"label":"Company","name":"company","placeholder":"Optional","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"organization"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"email","label":"Email","name":"email","required":true,"placeholder":"you@example.com","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"email"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"tel","label":"Phone","name":"phone","placeholder":"Optional","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"tel"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:jet-forms/textarea-field {"label":"Tell us a little more","name":"message","placeholder":"What do you want to achieve? Anything you like or dislike?"} /-->

<!-- wp:jet-forms/submit-field {"label":"Send request","add_prev":true,"prev_label":"Back"} /-->

<!-- wp:jet-forms/form-break-field {"label_progress":"Your details"} /-->';
}

function pg_en_audit_form_blocks() {
	return '<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"url","label":"Your website","name":"site_url","required":true,"placeholder":"https://","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"url"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"email","label":"Email for the report","name":"email","required":true,"placeholder":"you@example.com","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"email"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:jet-forms/submit-field {"label":"Get my free audit"} /-->';
}

function pg_en_audit_strings() {
	return array(
		'eyebrow' => 'Free audit',
		'title'   => 'How fast is your website?',
		'text'    => 'Send us the address and we’ll reply with a short report on what’s holding you back, and how to fix it.',
		'list'    => array( 'Speed & Core Web Vitals (mobile and desktop)', 'SEO basics: titles, meta, structure', 'Mobile experience & accessibility' ),
		'anchor'  => 'free-audit',
	);
}

function pg_en_quote_steps() {
	return array(
		array( 'fas fa-paper-plane', 'You send the request', 'Three short steps, under 2 minutes.' ),
		array( 'fas fa-comments', 'We talk', 'We get in touch to understand what you need.' ),
		array( 'fas fa-file-signature', 'Written quote', 'Clear cost and timeline, no small print.' ),
	);
}

function pg_en_seo_meta_more() {
	return array(
		'work'        => array( 'Our work: websites & branding | Polygons', 'Websites, online stores, logos and campaigns we designed. See the challenge, the solution and the result of every project.' ),
		'articles'    => array( 'Articles: web design, SEO & branding | Polygons', 'Practical guides and tips on websites, SEO, hosting and brand identity from the Polygons team.' ),
		'get-a-quote' => array( 'Get a quote for a website, branding or SEO | Polygons', 'Tell us what you need in three short steps and we’ll send you a clear quote with cost and timeline, no small print.' ),
	);
}
