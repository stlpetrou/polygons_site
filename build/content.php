<?php
/**
 * Site copy (Greek). Placeholder/sample entries are marked "δείγμα" — replace them from
 * WP admin (Έργα, Testimonials, Πελάτες, Πακέτα) with real material.
 */

function pg_services() {
	return array(
		'web'       => array(
			'n'     => '01',
			'title' => 'Web & UI Design',
			'short' => 'Ιστοσελίδες και interfaces που δεν είναι απλώς όμορφα: φορτώνουν γρήγορα, δουλεύουν άψογα σε κάθε οθόνη και οδηγούν τον επισκέπτη στο επόμενο βήμα.',
			'long'  => 'Σχεδιάζουμε και αναπτύσσουμε ιστοσελίδες με επίκεντρο τον χρήστη. Ξεκινάμε από τη δομή και την εμπειρία πλοήγησης, περνάμε στο οπτικό κομμάτι και καταλήγουμε σε ένα γρήγορο, ασφαλές site που διαχειρίζεσαι εύκολα μόνος σου.',
			'for'   => 'επιχειρήσεις που θέλουν site που φέρνει πελάτες',
			'time'  => '3–6 εβδομάδες',
			'list'  => array( 'Εταιρικές ιστοσελίδες & landing pages', 'UI/UX σχεδιασμός και prototyping', 'Responsive σχεδιασμός για κάθε οθόνη', 'Ηλεκτρονικά καταστήματα (e-shop)', 'Βελτιστοποίηση ταχύτητας & Core Web Vitals' ),
		),
		'branding'  => array(
			'n'     => '02',
			'title' => 'Εταιρική ταυτότητα & Graphics',
			'short' => 'Λογότυπο, χρώματα, τυπογραφία και εφαρμογές που δίνουν στην επιχείρησή σου μια αναγνωρίσιμη, συνεπή εικόνα, online και offline.',
			'long'  => 'Η εταιρική ταυτότητα είναι το σύνολο των οπτικών στοιχείων που κάνουν ένα brand αναγνωρίσιμο: λογότυπο, χρώματα, τυπογραφία και ύφος. Τα σχεδιάζουμε ώστε να λένε την ιστορία σου με συνέπεια σε κάθε σημείο επαφής.',
			'for'   => 'νέες επιχειρήσεις και brands που θέλουν ανανέωση',
			'time'  => '2–4 εβδομάδες',
			'list'  => array( 'Σχεδιασμός λογοτύπου', 'Brand identity & brand guidelines', 'Επαγγελματικές κάρτες & εταιρικά έντυπα', 'Social media graphics', 'Συσκευασίες & διαφημιστικό υλικό' ),
		),
		'hosting'   => array(
			'n'     => '03',
			'title' => 'Hosting & Συντήρηση',
			'short' => 'Γρήγοροι, ασφαλείς servers, SSL, backups και ενημερώσεις. Εμείς κρατάμε το site σου online, εσύ ασχολείσαι με την επιχείρησή σου.',
			'long'  => 'Ο web host παρέχει τον χώρο και τη σύνδεση που κάνουν το site σου προσβάσιμο σε όλο τον κόσμο. Εμείς πάμε ένα βήμα παραπέρα: φροντίζουμε την ταχύτητα, την ασφάλεια και τις ενημερώσεις, ώστε να μη χρειάζεται να το σκεφτείς ποτέ.',
			'for'   => 'όσους θέλουν το site τους σε σίγουρα χέρια',
			'time'  => 'ενεργοποίηση σε 1 ημέρα',
			'list'  => array( 'Γρήγορο, ασφαλές hosting για WordPress', 'Πιστοποιητικό SSL & τακτικά backups', 'Ενημερώσεις & παρακολούθηση ασφαλείας', 'Εταιρικά email', 'Τεχνική υποστήριξη από ανθρώπους' ),
		),
		'marketing' => array(
			'n'     => '04',
			'title' => 'SEO & Digital Marketing',
			'short' => 'Τεχνικό SEO, περιεχόμενο και στρατηγικές που φέρνουν τους σωστούς επισκέπτες και τους μετατρέπουν σε πελάτες.',
			'long'  => 'Ένα όμορφο site χρειάζεται και επισκέπτες. Με τεχνικό SEO, στοχευμένο περιεχόμενο και διαφήμιση στα κανάλια που μετράνε, σε βοηθάμε να σε βρίσκουν οι άνθρωποι που ψάχνουν ακριβώς αυτό που προσφέρεις.',
			'for'   => 'επιχειρήσεις που θέλουν περισσότερους πελάτες online',
			'time'  => 'συνεχής συνεργασία, αποτελέσματα από τον 3ο μήνα',
			'list'  => array( 'Τεχνικό SEO & SEO audit', 'Έρευνα λέξεων-κλειδιών & περιεχόμενο', 'Local SEO & Google Business Profile', 'Google Ads & social media διαφήμιση', 'Analytics & μηνιαίες αναφορές' ),
		),
	);
}

function pg_why() {
	return array(
		array( 'fas fa-layer-group', 'Όλα σε ένα σημείο', 'Design, ανάπτυξη, hosting και marketing από την ίδια ομάδα. Χωρίς ενδιάμεσους, χωρίς χαμένα emails.' ),
		array( 'fas fa-bolt', 'Ταχύτητα που μετράει', 'Χτίζουμε με γνώμονα την απόδοση: βελτιστοποιημένα sites που φορτώνουν γρήγορα και αρέσουν στη Google.' ),
		array( 'fas fa-bullseye', 'Σχεδιασμός με στόχο', 'Κάθε σχεδιαστική απόφαση υπηρετεί έναν σκοπό: να ξεχωρίσεις και να φέρεις αποτελέσματα.' ),
		array( 'fas fa-headset', 'Υποστήριξη μετά το launch', 'Δεν εξαφανιζόμαστε μετά την παράδοση. Είμαστε εδώ για αλλαγές, ενημερώσεις και ανάπτυξη.' ),
	);
}

function pg_steps() {
	return array(
		array( 'Γνωριμία', 'Μαθαίνουμε την επιχείρηση, το κοινό και τους στόχους σου.' ),
		array( 'Σχεδιασμός', 'Στήνουμε δομή, wireframes και οπτική πρόταση για έγκριση.' ),
		array( 'Υλοποίηση', 'Αναπτύσσουμε, δοκιμάζουμε και βελτιστοποιούμε για κάθε συσκευή.' ),
		array( 'Launch & ανάπτυξη', 'Βγαίνουμε online και συνεχίζουμε με hosting, SEO και υποστήριξη.' ),
	);
}

function pg_values() {
	return array(
		array( 'fas fa-magic', 'Δημιουργικότητα', 'Δεν αντιγράφουμε τάσεις. Ψάχνουμε την ιδέα που ταιριάζει μόνο σε σένα.' ),
		array( 'fas fa-handshake', 'Διαφάνεια', 'Ξεκάθαρες τιμές, ξεκάθαρα χρονοδιαγράμματα, ξεκάθαρη επικοινωνία σε κάθε βήμα.' ),
		array( 'fas fa-rocket', 'Εξερευνητικό πνεύμα', 'Δοκιμάζουμε νέα εργαλεία και τεχνικές για να είσαι πάντα ένα βήμα μπροστά.' ),
	);
}

function pg_about_story() {
	return '<p>Το όνομά μας δεν είναι τυχαίο. Όπως ένα πολύγωνο σχηματίζεται από πολλές πλευρές που ενώνονται σε ένα σύνολο, έτσι και η ψηφιακή παρουσία μιας επιχείρησης χρειάζεται design, τεχνολογία, φιλοξενία και προώθηση να δουλεύουν μαζί.</p>'
		. '<p>Στο Polygons ενώνουμε όλες αυτές τις πλευρές κάτω από την ίδια στέγη. Έτσι έχεις έναν συνεργάτη που γνωρίζει το project σου από την αρχή ως το τέλος, και ένα αποτέλεσμα που στέκει άρτιο από κάθε γωνία.</p>';
}

function pg_contact_info() {
	return array(
		array( 'fas fa-envelope', 'Email', '<a href="mailto:info@polygons.gr">info@polygons.gr</a>' ),
		array( 'fas fa-phone', 'Τηλέφωνο', '<a href="tel:+302100000000">+30 210 000 0000</a>' ),
		array( 'fas fa-clock', 'Ωράριο', 'Δευτέρα – Παρασκευή, 09:00 – 17:00' ),
	);
}

function pg_faq() {
	return array(
		array( 'Πόσο κοστίζει μια ιστοσελίδα;', 'Εξαρτάται από το μέγεθος και τις λειτουργίες που χρειάζεσαι. Τα πακέτα μας δίνουν μια ξεκάθαρη αφετηρία, ενώ για e-shop ή πιο σύνθετα projects ετοιμάζουμε γραπτή προσφορά μετά από μια σύντομη γνωριμία. Χωρίς κρυφές χρεώσεις.' ),
		array( 'Πόσο χρόνο χρειάζεται για να είναι έτοιμο το site μου;', 'Μια εταιρική ιστοσελίδα χρειάζεται συνήθως 3–6 εβδομάδες και ένα e-shop 6–10, ανάλογα με το περιεχόμενο και τους γύρους διορθώσεων. Από την πρώτη μέρα ξέρεις το χρονοδιάγραμμα.' ),
		array( 'Θα μπορώ να αλλάζω μόνος μου κείμενα και εικόνες;', 'Ναι. Κάθε site παραδίδεται με εύκολο σύστημα διαχείρισης και σύντομη εκπαίδευση, ώστε να κάνεις τις καθημερινές αλλαγές χωρίς να εξαρτάσαι από κανέναν.' ),
		array( 'Τι χρειάζεται να σας δώσω για να ξεκινήσουμε;', 'Λογότυπο (αν δεν έχεις, το σχεδιάζουμε), κείμενα και φωτογραφίες αν υπάρχουν, και μια ιδέα για το τι θέλεις να πετύχεις. Μπορούμε να αναλάβουμε και τη συγγραφή κειμένων.' ),
		array( 'Αναλαμβάνετε και το hosting και το domain;', 'Ναι. Καταχωρούμε το domain, φιλοξενούμε το site σε γρήγορους servers με SSL και backups, και στήνουμε τα εταιρικά σου email.' ),
		array( 'Τι γίνεται μετά την παράδοση;', 'Συνεχίζουμε μαζί. Με τα πακέτα συντήρησης φροντίζουμε ενημερώσεις, ασφάλεια και μικροαλλαγές, και είμαστε εδώ όποτε χρειαστείς κάτι νέο.' ),
		array( 'Θα εμφανίζεται το site μου στη Google;', 'Κάθε site χτίζεται SEO-ready: γρήγορο, με σωστή δομή και τεχνικές ρυθμίσεις. Για υψηλές θέσεις σε ανταγωνιστικές αναζητήσεις χρειάζεται συνεχής δουλειά, που καλύπτουν οι υπηρεσίες SEO.' ),
		array( 'Μπορείτε να ανανεώσετε το υπάρχον site μου;', 'Φυσικά. Αξιολογούμε τι λειτουργεί και τι όχι, κρατάμε ό,τι αξίζει (περιεχόμενο, SEO) και το μεταφέρουμε σε ένα σύγχρονο, γρήγορο site.' ),
	);
}

function pg_project_cats() {
	return array(
		'web-design' => 'Web Design',
		'branding'   => 'Branding',
		'e-shop'     => 'E-shop',
		'graphics'   => 'Graphics',
		'seo'        => 'SEO',
	);
}

function pg_projects() {
	$client = 'Όνομα πελάτη (δείγμα)';
	return array(
		array(
			'cat' => 'web-design', 'slug' => 'etairiki-istoselida-texniki-etaireia', 'title' => 'Εταιρική ιστοσελίδα για τεχνική εταιρεία', 'client' => $client, 'year' => '2025', 'services' => 'Web design · Development · Hosting',
			'excerpt'   => 'Νέα, γρήγορη ιστοσελίδα που παρουσιάζει καθαρά τις υπηρεσίες και φέρνει αιτήματα προσφοράς.',
			'highlight' => 'Νέο site με έμφαση στα αιτήματα προσφοράς',
			'challenge' => 'Το παλιό site ήταν αργό, δύσκολο στην ενημέρωση και δεν εξηγούσε με σαφήνεια τι προσφέρει η εταιρεία.',
			'solution'  => 'Νέα αρχιτεκτονική περιεχομένου, σελίδα ανά υπηρεσία, ξεκάθαρα calls-to-action και βελτιστοποίηση ταχύτητας.',
			'result'    => 'Ένα σύγχρονο site που διαχειρίζεται η ίδια η εταιρεία και οδηγεί τον επισκέπτη στο αίτημα προσφοράς.',
			'content'   => '<p>Περιγράψτε εδώ το έργο με περισσότερες λεπτομέρειες: στόχους, τεχνολογίες, συνεργασία με τον πελάτη.</p>',
		),
		array(
			'cat' => 'branding', 'slug' => 'rebranding-kafe-estiatorio', 'title' => 'Rebranding για καφέ-εστιατόριο', 'client' => $client, 'year' => '2025', 'services' => 'Λογότυπο · Brand identity · Έντυπα',
			'excerpt'   => 'Νέα ταυτότητα με χαρακτήρα, από το λογότυπο μέχρι τα μενού και τη σήμανση.',
			'highlight' => 'Νέο λογότυπο και πλήρες brand book',
			'challenge' => 'Το brand δεν ξεχώριζε σε μια γειτονιά με έντονο ανταγωνισμό και δεν είχε ενιαία εικόνα.',
			'solution'  => 'Λογότυπο, χρωματική παλέτα και τυπογραφία με ζεστό, σύγχρονο ύφος, εφαρμοσμένα σε μενού, social και σήμανση.',
			'result'    => 'Μια αναγνωρίσιμη ταυτότητα που χρησιμοποιείται με συνέπεια σε κάθε σημείο επαφής.',
			'content'   => '<p>Περιγράψτε εδώ το έργο με περισσότερες λεπτομέρειες.</p>',
		),
		array(
			'cat' => 'e-shop', 'slug' => 'eshop-kallyntika', 'title' => 'Ηλεκτρονικό κατάστημα για brand καλλυντικών', 'client' => $client, 'year' => '2024', 'services' => 'E-shop · UI/UX · SEO',
			'excerpt'   => 'E-shop με εύκολη αγορά από κινητό, online πληρωμές και σύνδεση με courier.',
			'highlight' => 'Πλήρες e-shop με online πληρωμές',
			'challenge' => 'Οι πωλήσεις γίνονταν μόνο μέσω social media και μηνυμάτων, με πολύ χειροκίνητη δουλειά.',
			'solution'  => 'E-shop σχεδιασμένο πρώτα για κινητό, με γρήγορο checkout, online πληρωμές και αυτόματη ενημέρωση αποθήκης.',
			'result'    => 'Οι παραγγελίες γίνονται πλέον αυτόματα, 24 ώρες το 24ωρο.',
			'content'   => '<p>Περιγράψτε εδώ το έργο με περισσότερες λεπτομέρειες.</p>',
		),
		array(
			'cat' => 'graphics', 'slug' => 'social-media-kampania-gymnastirio', 'title' => 'Social media καμπάνια για γυμναστήριο', 'client' => $client, 'year' => '2024', 'services' => 'Graphics · Social media',
			'excerpt'   => 'Οπτική καμπάνια για την έναρξη της σεζόν, σε όλα τα κανάλια του brand.',
			'highlight' => 'Ενιαίο οπτικό ύφος σε όλα τα κανάλια',
			'challenge' => 'Οι αναρτήσεις ήταν αποσπασματικές και δεν «έδεναν» μεταξύ τους.',
			'solution'  => 'Σύστημα από templates, χρώματα και φωτογραφικό ύφος για posts, stories και διαφημίσεις.',
			'result'    => 'Μια καμπάνια με συνέπεια, που η ομάδα του πελάτη μπορεί να συνεχίσει μόνη της.',
			'content'   => '<p>Περιγράψτε εδώ το έργο με περισσότερες λεπτομέρειες.</p>',
		),
		array(
			'cat' => 'web-design', 'slug' => 'landing-page-ekdilosi', 'title' => 'Landing page για επαγγελματική εκδήλωση', 'client' => $client, 'year' => '2024', 'services' => 'Landing page · Φόρμα εγγραφών',
			'excerpt'   => 'Μία σελίδα με όλες τις πληροφορίες της εκδήλωσης και online εγγραφές.',
			'highlight' => 'Online εγγραφές σε μία σελίδα',
			'challenge' => 'Οι εγγραφές γίνονταν με email και τηλέφωνα, κάτι που δυσκόλευε την οργάνωση.',
			'solution'  => 'Landing page με πρόγραμμα, ομιλητές και φόρμα εγγραφής με αυτόματη επιβεβαίωση.',
			'result'    => 'Όλες οι εγγραφές συγκεντρωμένες σε ένα σημείο, χωρίς χειροκίνητη δουλειά.',
			'content'   => '<p>Περιγράψτε εδώ το έργο με περισσότερες λεπτομέρειες.</p>',
		),
		array(
			'cat' => 'seo', 'slug' => 'local-seo-iatreio', 'title' => 'Local SEO για ιατρείο', 'client' => $client, 'year' => '2024', 'services' => 'Local SEO · Google Business Profile',
			'excerpt'   => 'Καλύτερη ορατότητα στις τοπικές αναζητήσεις και στους χάρτες της Google.',
			'highlight' => 'Βελτιστοποιημένο Google Business Profile',
			'challenge' => 'Το ιατρείο δεν εμφανιζόταν στις τοπικές αναζητήσεις, παρά την καλή του φήμη.',
			'solution'  => 'Τεχνικό SEO στο site, βελτιστοποίηση του Google Business Profile και στρατηγική για κριτικές.',
			'result'    => 'Περισσότερη ορατότητα εκεί που ψάχνουν οι ασθενείς της περιοχής.',
			'content'   => '<p>Περιγράψτε εδώ το έργο με περισσότερες λεπτομέρειες.</p>',
		),
	);
}

function pg_testimonials() {
	return array(
		array( 'name' => 'Όνομα Επώνυμο', 'role' => 'Θέση, Εταιρεία (δείγμα)', 'quote' => 'Από την πρώτη συνάντηση ένιωσα ότι μιλάμε την ίδια γλώσσα. Το νέο μας site είναι γρήγορο, όμορφο και, το πιο σημαντικό, μας φέρνει πελάτες.' ),
		array( 'name' => 'Όνομα Επώνυμο', 'role' => 'Θέση, Εταιρεία (δείγμα)', 'quote' => 'Είχαμε έναν συνεργάτη για όλα: λογότυπο, site και hosting. Καμία ταλαιπωρία, ξεκάθαρα χρονοδιαγράμματα και άμεση ανταπόκριση σε κάθε ερώτηση.' ),
		array( 'name' => 'Όνομα Επώνυμο', 'role' => 'Θέση, Εταιρεία (δείγμα)', 'quote' => 'Η ομάδα κατάλαβε τι χρειαζόμασταν πριν καν το εξηγήσουμε. Το αποτέλεσμα ξεπέρασε τις προσδοκίες μας.' ),
	);
}

function pg_packages() {
	return array(
		array( 'group' => 'web', 'title' => 'Starter', 'badge' => '', 'subtitle' => 'Για επαγγελματίες και μικρές επιχειρήσεις', 'price' => 'από €XXX', 'note' => 'εφάπαξ',
			'features' => array( 'Έως 5 σελίδες', 'Responsive σχεδιασμός', 'Φόρμα επικοινωνίας', 'Βασικό SEO setup', 'Εκπαίδευση διαχείρισης' ) ),
		array( 'group' => 'web', 'title' => 'Business', 'badge' => 'Δημοφιλές', 'subtitle' => 'Για επιχειρήσεις που θέλουν να ξεχωρίσουν', 'price' => 'από €XXX', 'note' => 'εφάπαξ',
			'features' => array( 'Έως 12 σελίδες', 'Custom σχεδιασμός', 'Blog / νέα', 'SEO setup & Google Analytics', 'Βελτιστοποίηση ταχύτητας', 'Εκπαίδευση διαχείρισης' ) ),
		array( 'group' => 'web', 'title' => 'E-shop', 'badge' => '', 'subtitle' => 'Για όσους πουλάνε online', 'price' => 'από €XXX', 'note' => 'εφάπαξ',
			'features' => array( 'Ηλεκτρονικό κατάστημα', 'Online πληρωμές', 'Σύνδεση με courier', 'Διαχείριση προϊόντων & αποθήκης', 'SEO για προϊόντα', 'Εκπαίδευση διαχείρισης' ) ),
		array( 'group' => 'hosting', 'title' => 'Basic', 'badge' => '', 'subtitle' => 'Για μικρά sites και landing pages', 'price' => '€XX', 'note' => '/μήνα',
			'features' => array( 'Γρήγοροι SSD servers', 'Δωρεάν SSL', 'Εβδομαδιαία backups', 'Εταιρικά email', 'Υποστήριξη μέσω email' ) ),
		array( 'group' => 'hosting', 'title' => 'Pro', 'badge' => 'Προτεινόμενο', 'subtitle' => 'Για εταιρικά sites με κίνηση', 'price' => '€XX', 'note' => '/μήνα',
			'features' => array( 'Όλα του Basic', 'Καθημερινά backups', 'Ενημερώσεις WordPress & plugins', 'Παρακολούθηση ασφαλείας', 'Προτεραιότητα στην υποστήριξη' ) ),
		array( 'group' => 'hosting', 'title' => 'Business', 'badge' => '', 'subtitle' => 'Για e-shops και απαιτητικά projects', 'price' => '€XX', 'note' => '/μήνα',
			'features' => array( 'Όλα του Pro', 'Αυξημένοι πόροι server', 'Βελτιστοποίηση ταχύτητας', 'Μηνιαία αναφορά', 'Τηλεφωνική υποστήριξη' ) ),
	);
}

function pg_form_blocks() {
	return '<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"label":"Ονοματεπώνυμο","name":"name","required":true,"autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"name","placeholder":"Το όνομά σου"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"email","label":"Email","name":"email","required":true,"autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"email","placeholder":"you@example.com"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"tel","label":"Τηλέφωνο","name":"phone","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"tel","placeholder":"Προαιρετικό"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/select-field {"field_options":[{"label":"Web & UI Design","value":"web"},{"label":"Εταιρική ταυτότητα & Graphics","value":"branding"},{"label":"Hosting & Συντήρηση","value":"hosting"},{"label":"SEO & Digital Marketing","value":"seo"},{"label":"Κάτι άλλο / Δεν είμαι σίγουρος","value":"other"}],"label":"Τι σε ενδιαφέρει;","name":"service","placeholder":"Επίλεξε υπηρεσία"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:jet-forms/textarea-field {"label":"Μήνυμα","name":"message","required":true,"placeholder":"Πες μας λίγα λόγια για το project σου"} /-->

<!-- wp:jet-forms/submit-field {"label":"Αποστολή μηνύματος"} /-->';
}

/** Multi-step quote form (3 steps + progress bar). */
function pg_quote_form_blocks() {
	$opts = function ( array $pairs ) {
		$o = array();
		foreach ( $pairs as $v => $l ) {
			$o[] = array( 'label' => $l, 'value' => $v );
		}
		return wp_json_encode( $o, JSON_UNESCAPED_UNICODE );
	};
	$services = $opts( array( 'website' => 'Ιστοσελίδα', 'eshop' => 'E-shop', 'branding' => 'Λογότυπο / εταιρική ταυτότητα', 'hosting' => 'Hosting & συντήρηση', 'seo' => 'SEO & digital marketing', 'other' => 'Κάτι άλλο' ) );
	$budget   = $opts( array( 'upto-1200' => 'Έως 1.200€', '1200-3000' => '1.200 – 3.000€', '3000-6000' => '3.000 – 6.000€', '6000-plus' => '6.000€ και πάνω', 'unknown' => 'Δεν ξέρω ακόμα' ) );
	$timeline = $opts( array( 'asap' => 'Άμεσα (μέσα στον μήνα)', '1-3-months' => 'Σε 1–3 μήνες', 'flexible' => 'Χωρίς βιασύνη' ) );
	return '<!-- wp:jet-forms/checkbox-field {"field_options":' . $services . ',"label":"Τι χρειάζεσαι;","desc":"Διάλεξε όσα ισχύουν.","name":"services","required":true,"class_name":"pg-choice"} /-->

<!-- wp:jet-forms/text-field {"field_type":"url","label":"Υπάρχον site (αν υπάρχει)","name":"current_site","placeholder":"https://","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"url"} /-->

<!-- wp:jet-forms/form-break-field {"label":"Επόμενο","label_progress":"Τι χρειάζεσαι"} /-->

<!-- wp:jet-forms/radio-field {"field_options":' . $budget . ',"label":"Budget","desc":"Ενδεικτικά, πριν από ΦΠΑ. Μας βοηθά να προτείνουμε τη σωστή λύση.","name":"budget","required":true,"class_name":"pg-choice"} /-->

<!-- wp:jet-forms/radio-field {"field_options":' . $timeline . ',"label":"Πότε θέλεις να ξεκινήσουμε;","name":"timeline","required":true,"class_name":"pg-choice"} /-->

<!-- wp:jet-forms/form-break-field {"label":"Επόμενο","label_progress":"Budget & χρόνος","add_prev":true,"prev_label":"Πίσω"} /-->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"label":"Ονοματεπώνυμο","name":"name","required":true,"placeholder":"Το όνομά σου","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"name"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"label":"Εταιρεία","name":"company","placeholder":"Προαιρετικό","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"organization"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"email","label":"Email","name":"email","required":true,"placeholder":"you@example.com","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"email"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"tel","label":"Τηλέφωνο","name":"phone","placeholder":"Προαιρετικό","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"tel"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:jet-forms/textarea-field {"label":"Πες μας λίγα λόγια","name":"message","placeholder":"Τι θέλεις να πετύχεις; Υπάρχει κάτι που σου αρέσει ή δεν σου αρέσει;"} /-->

<!-- wp:jet-forms/submit-field {"label":"Στείλε το αίτημα","add_prev":true,"prev_label":"Πίσω"} /-->

<!-- wp:jet-forms/form-break-field {"label_progress":"Στοιχεία"} /-->';
}

/** Free site audit: URL + email. */
function pg_audit_form_blocks() {
	return '<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"url","label":"Το site σου","name":"site_url","required":true,"placeholder":"https://","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"url"} /--></div>
<!-- /wp:column -->

<!-- wp:column -->
<div class="wp-block-column"><!-- wp:jet-forms/text-field {"field_type":"email","label":"Email για την αναφορά","name":"email","required":true,"placeholder":"you@example.com","autocomplete":"on","autocomplete_value":"custom","autocomplete_custom":"email"} /--></div>
<!-- /wp:column --></div>
<!-- /wp:columns -->

<!-- wp:jet-forms/submit-field {"label":"Κάνε μου δωρεάν έλεγχο"} /-->';
}

/** What happens after a quote request (shown next to the form). */
function pg_quote_steps() {
	return array(
		array( 'fas fa-paper-plane', 'Στέλνεις το αίτημα', 'Τρία σύντομα βήματα, λιγότερο από 2 λεπτά.' ),
		array( 'fas fa-comments', 'Μιλάμε', 'Επικοινωνούμε μαζί σου για να καταλάβουμε τι χρειάζεσαι.' ),
		array( 'fas fa-file-signature', 'Γραπτή προσφορά', 'Ξεκάθαρο κόστος και χρονοδιάγραμμα, χωρίς ψιλά γράμματα.' ),
	);
}

/* ======================================================= Phase 4: growth */

/** Service page URL (child of Τι κάνουμε). */
function pg_service_url( $key ) {
	return '/ti-kanoume/' . pg_service_pages()[ $key ]['slug'] . '/';
}

/**
 * One page per service (/ti-kanoume/<slug>/). Keys match pg_services().
 * cats = project categories shown as related work; packages = packages group shown (or '').
 */
function pg_service_pages() {
	return array(
		'web'       => array(
			'slug'     => 'kataskevi-istoselidas',
			'menu'     => 'Κατασκευή ιστοσελίδων',
			'eyebrow'  => 'Web & UI Design',
			'h1'       => 'Κατασκευή ιστοσελίδων<br>που φέρνουν πελάτες.',
			'lead'     => 'Σχεδιάζουμε και χτίζουμε γρήγορα, ασφαλή sites σε WordPress, που διαχειρίζεσαι μόνος σου και οδηγούν τον επισκέπτη στο επόμενο βήμα.',
			'intro_h'  => 'Το site σου είναι η πρώτη σου εντύπωση.',
			'intro'    => '<p>Ένα site είναι συχνά η πρώτη επαφή ενός πελάτη με την επιχείρησή σου. Αν αργεί, αν μπερδεύει ή αν δεν φαίνεται σωστά στο κινητό, ο επισκέπτης φεύγει πριν καν μάθει τι προσφέρεις.</p><p>Γι\' αυτό ξεκινάμε από τους στόχους σου και από το τι ψάχνουν οι πελάτες σου. Στήνουμε τη δομή, σχεδιάζουμε την εμπειρία και χτίζουμε ένα site που είναι γρήγορο από τη φύση του, όχι «διορθωμένο» μετά.</p>',
			'features' => array(
				array( 'fas fa-mobile-alt', 'Πρώτα για κινητό', 'Οι περισσότεροι επισκέπτες έρχονται από κινητό. Σχεδιάζουμε πρώτα γι\' αυτούς και μετά για τις μεγάλες οθόνες.' ),
				array( 'fas fa-tachometer-alt', 'Ταχύτητα & Core Web Vitals', 'Στόχος πάνω από 90 στο Google PageSpeed: ελαφρύς κώδικας, σωστές εικόνες, σωστό caching.' ),
				array( 'fas fa-search', 'SEO από την πρώτη μέρα', 'Σωστή δομή, τίτλοι, meta, schema και sitemap. Το site σου είναι έτοιμο να το βρει η Google.' ),
				array( 'fas fa-edit', 'Διαχείριση χωρίς εξάρτηση', 'Αλλάζεις κείμενα, εικόνες και έργα μόνος σου, με σύντομη εκπαίδευση και γραπτό οδηγό.' ),
				array( 'fas fa-universal-access', 'Προσβασιμότητα', 'Σωστές αντιθέσεις, πλοήγηση με πληκτρολόγιο και ετικέτες για αναγνώστες οθόνης. Καλύτερο για όλους.' ),
				array( 'fas fa-shield-alt', 'Ασφάλεια & backups', 'SSL, ενημερώσεις και τακτικά backups, ώστε το site σου να μένει online και προστατευμένο.' ),
			),
			'process'  => array(
				array( 'Γνωριμία & στόχοι', 'Συζητάμε για την επιχείρηση, το κοινό σου και τι θέλεις να πετύχει το site.' ),
				array( 'Δομή & wireframes', 'Ορίζουμε σελίδες, περιεχόμενο και τη διαδρομή του επισκέπτη, πριν από οποιοδήποτε χρώμα.' ),
				array( 'Σχεδιασμός & ανάπτυξη', 'Οπτική πρόταση για έγκριση και υλοποίηση σε WordPress, με δοκιμές σε κάθε συσκευή.' ),
				array( 'Έλεγχοι & launch', 'Ταχύτητα, SEO και φόρμες ελέγχονται πριν βγούμε online. Μετά μένουμε δίπλα σου.' ),
			),
			'cats'     => array( 'web-design', 'e-shop' ),
			'packages' => 'web',
			'faq'      => array(
				array( 'Σε ποια πλατφόρμα φτιάχνετε τα sites;', 'Σε WordPress, την πιο διαδεδομένη πλατφόρμα στον κόσμο. Έτσι το site σου δεν «κλειδώνει» σε έναν συνεργάτη και το διαχειρίζεσαι εύκολα.' ),
				array( 'Πόσες σελίδες χρειάζομαι;', 'Για τις περισσότερες επιχειρήσεις αρκούν 5–8: αρχική, υπηρεσίες, έργα, σχετικά με εμάς, επικοινωνία. Μια σελίδα ανά υπηρεσία βοηθά πολύ στη Google. Θα σου προτείνουμε τη σωστή δομή από την αρχή.' ),
				array( 'Θα γράψετε εσείς τα κείμενα;', 'Μπορούμε. Συνήθως γράφουμε ένα πρώτο κείμενο με βάση τη γνωριμία μας και εσύ το διορθώνεις, γιατί κανείς δεν ξέρει την επιχείρησή σου καλύτερα.' ),
				array( 'Φτιάχνετε και e-shop;', 'Ναι, με WooCommerce: online πληρωμές, σύνδεση με courier, διαχείριση αποθήκης και σχεδιασμός που κάνει την αγορά από κινητό εύκολη.' ),
			),
			'seo'      => array( 'Κατασκευή ιστοσελίδων & e-shop σε WordPress | Polygons', 'Κατασκευή ιστοσελίδων και e-shop σε WordPress: γρήγορα, responsive, έτοιμα για SEO και εύκολα στη διαχείριση. Ζήτα προσφορά από το Polygons.' ),
		),
		'branding'  => array(
			'slug'     => 'etairiki-taytotita',
			'menu'     => 'Εταιρική ταυτότητα',
			'eyebrow'  => 'Branding & Graphics',
			'h1'       => 'Εταιρική ταυτότητα<br>που θυμούνται.',
			'lead'     => 'Λογότυπο, χρώματα, τυπογραφία και εφαρμογές που δίνουν στο brand σου μια συνεπή, αναγνωρίσιμη εικόνα: στο site, στα social και στο χαρτί.',
			'intro_h'  => 'Σε κρίνουν πριν σε διαβάσουν.',
			'intro'    => '<p>Οι πελάτες σχηματίζουν γνώμη μέσα σε δευτερόλεπτα, πολύ πριν διαβάσουν τι κάνεις. Μια σωστά σχεδιασμένη ταυτότητα δείχνει επαγγελματισμό και σε ξεχωρίζει από τον ανταγωνισμό.</p><p>Δεν σχεδιάζουμε μόνο ένα λογότυπο. Φτιάχνουμε ένα σύστημα από χρώματα, γραμματοσειρές και κανόνες, που δουλεύει το ίδιο καλά σε μια κάρτα, σε ένα post και σε μια πινακίδα.</p>',
			'features' => array(
				array( 'fas fa-pen-nib', 'Σχεδιασμός λογοτύπου', 'Πρωτότυπες προτάσεις με σκεπτικό, σε όλες τις εκδοχές: οριζόντιο, κάθετο, σύμβολο, μονόχρωμο.' ),
				array( 'fas fa-palette', 'Χρώματα & τυπογραφία', 'Παλέτα και γραμματοσειρές που ταιριάζουν στον χαρακτήρα του brand και διαβάζονται άνετα παντού.' ),
				array( 'fas fa-book', 'Brand guidelines', 'Σύντομος οδηγός χρήσης της ταυτότητας, ώστε να μένει συνεπής με όποιον κι αν συνεργαστείς.' ),
				array( 'fas fa-id-card', 'Εταιρικά έντυπα', 'Κάρτες, επιστολόχαρτα, φάκελοι, παρουσιάσεις και προσφορές με ενιαία εικόνα.' ),
				array( 'fas fa-hashtag', 'Social media graphics', 'Templates για posts, stories και διαφημίσεις, που η ομάδα σου χρησιμοποιεί μόνη της.' ),
				array( 'fas fa-box-open', 'Συσκευασίες & σήμανση', 'Ετικέτες, συσκευασίες, πινακίδες και υλικό για εκθέσεις, έτοιμα για εκτύπωση.' ),
			),
			'process'  => array(
				array( 'Έρευνα', 'Μαθαίνουμε την ιστορία σου, το κοινό και τον ανταγωνισμό.' ),
				array( 'Κατεύθυνση', 'Moodboard με ύφος, χρώματα και αναφορές, για να συμφωνήσουμε πριν σχεδιάσουμε.' ),
				array( 'Προτάσεις', 'Προτάσεις λογοτύπου με σκεπτικό και γύροι διορθώσεων μέχρι να καταλήξουμε.' ),
				array( 'Εφαρμογές & παράδοση', 'Αρχεία για κάθε χρήση (web και εκτύπωση) και οδηγός χρήσης της ταυτότητας.' ),
			),
			'cats'     => array( 'branding', 'graphics' ),
			'packages' => '',
			'faq'      => array(
				array( 'Σε τι μορφή θα πάρω το λογότυπο;', 'Σε διανυσματικά αρχεία (SVG, PDF) για εκτύπωση και σε PNG/SVG για web και social, σε όλες τις εκδοχές χρωμάτων.' ),
				array( 'Πόσες προτάσεις λογοτύπου θα δω;', 'Συνήθως 2–3 διαφορετικές κατευθύνσεις. Στη συνέχεια δουλεύουμε μαζί πάνω σε αυτή που σε εκφράζει.' ),
				array( 'Μπορείτε να ανανεώσετε το υπάρχον λογότυπο;', 'Ναι. Συχνά ένα refresh κρατάει την αναγνωρισιμότητα που έχεις χτίσει και απλώς τη φέρνει στο σήμερα.' ),
				array( 'Χρειάζομαι και νέο site;', 'Όχι απαραίτητα. Αν όμως τα σχεδιάσουμε μαζί, η ταυτότητα και το site θα «μιλάνε» την ίδια γλώσσα από την πρώτη μέρα.' ),
			),
			'seo'      => array( 'Εταιρική ταυτότητα & σχεδιασμός λογοτύπου | Polygons', 'Σχεδιασμός λογοτύπου, εταιρική ταυτότητα, brand guidelines, έντυπα και social media graphics. Μια συνεπής, αναγνωρίσιμη εικόνα για το brand σου.' ),
		),
		'hosting'   => array(
			'slug'     => 'web-hosting',
			'menu'     => 'Hosting & συντήρηση',
			'eyebrow'  => 'Hosting & Συντήρηση',
			'h1'       => 'Hosting & συντήρηση<br>χωρίς άγχος.',
			'lead'     => 'Γρήγοροι servers, SSL, backups, ενημερώσεις και άνθρωποι που απαντούν. Εμείς κρατάμε το site σου online, εσύ ασχολείσαι με την επιχείρησή σου.',
			'intro_h'  => 'Το πού φιλοξενείται μετράει.',
			'intro'    => '<p>Ένα site που πέφτει, αργεί ή «χακάρεται» κοστίζει σε πελάτες και σε φήμη. Τις περισσότερες φορές το πρόβλημα δεν είναι το ίδιο το site, αλλά το πού φιλοξενείται και το ποιος το προσέχει.</p><p>Φιλοξενούμε τα sites σε servers που ρυθμίζουμε εμείς για WordPress, πίσω από Cloudflare για ταχύτητα και προστασία, και τα παρακολουθούμε ώστε να προλαβαίνουμε τα προβλήματα.</p>',
			'features' => array(
				array( 'fas fa-server', 'Servers για WordPress', 'Περιβάλλον ρυθμισμένο για ταχύτητα, με caching σε επίπεδο server.' ),
				array( 'fas fa-cloud', 'Cloudflare σε κάθε site', 'CDN, προστασία από επιθέσεις και γρήγορη φόρτωση από οπουδήποτε.' ),
				array( 'fas fa-lock', 'Δωρεάν SSL', 'Ασφαλής σύνδεση (https) με αυτόματη ανανέωση πιστοποιητικού.' ),
				array( 'fas fa-history', 'Τακτικά backups', 'Αντίγραφα ασφαλείας εκτός server, με γρήγορη επαναφορά όταν χρειαστεί.' ),
				array( 'fas fa-sync-alt', 'Ενημερώσεις & παρακολούθηση', 'Ενημερώνουμε με ασφάλεια WordPress και plugins και παρακολουθούμε τη διαθεσιμότητα του site.' ),
				array( 'fas fa-envelope-open-text', 'Εταιρικά email', 'Email στο domain σου, ρυθμισμένα σωστά ώστε να μην καταλήγουν στα spam.' ),
			),
			'process'  => array(
				array( 'Έλεγχος', 'Βλέπουμε τι έχεις σήμερα: domain, email, site και DNS.' ),
				array( 'Μεταφορά', 'Μεταφέρουμε site και email, με σχέδιο ώστε να μην υπάρξει διακοπή.' ),
				array( 'Ρύθμιση', 'Cloudflare, SSL, caching και backups, έτοιμα από την πρώτη μέρα.' ),
				array( 'Φροντίδα', 'Ενημερώσεις, παρακολούθηση και υποστήριξη όποτε τη χρειαστείς.' ),
			),
			'cats'     => array(),
			'packages' => 'hosting',
			'faq'      => array(
				array( 'Μπορείτε να μεταφέρετε το site μου από άλλον πάροχο;', 'Ναι. Αναλαμβάνουμε όλη τη μεταφορά (αρχεία, βάση δεδομένων, email) και τη σχεδιάζουμε ώστε να μην υπάρξει διακοπή.' ),
				array( 'Τι γίνεται αν το site μου πέσει ή χακαριστεί;', 'Το παρακολουθούμε και ειδοποιούμαστε αμέσως. Με τα backups επαναφέρουμε γρήγορα την τελευταία υγιή έκδοση και κλείνουμε το κενό.' ),
				array( 'Φιλοξενείτε sites που δεν φτιάξατε εσείς;', 'Συνήθως ναι, αφού πρώτα κάνουμε έναν έλεγχο για να δούμε σε τι κατάσταση είναι και αν χρειάζεται κάτι πριν τη μεταφορά.' ),
				array( 'Τι είναι το Cloudflare και γιατί το χρειάζομαι;', 'Είναι ένα δίκτυο που «στέκεται» μπροστά από το site: το κάνει πιο γρήγορο, το προστατεύει από επιθέσεις και κρύβει τον server. Στην καθημερινή σου χρήση δεν αλλάζει τίποτα.' ),
			),
			'seo'      => array( 'Web hosting & συντήρηση WordPress | Polygons', 'Γρήγορο, ασφαλές hosting για WordPress με Cloudflare, SSL, backups, ενημερώσεις και εταιρικά email. Μεταφορά του site σου χωρίς διακοπή.' ),
		),
		'marketing' => array(
			'slug'     => 'seo',
			'menu'     => 'SEO & digital marketing',
			'eyebrow'  => 'SEO & Marketing',
			'h1'       => 'SEO & digital marketing<br>που φέρνει πελάτες.',
			'lead'     => 'Τεχνικό SEO, περιεχόμενο, Google Business Profile και διαφήμιση. Σε βοηθάμε να σε βρίσκουν οι άνθρωποι που ψάχνουν ακριβώς αυτό που προσφέρεις.',
			'intro_h'  => 'Ένα site χωρίς επισκέπτες είναι βιτρίνα σε έρημο δρόμο.',
			'intro'    => '<p>Οι πελάτες σου ψάχνουν κάθε μέρα στη Google αυτό που προσφέρεις. Το ερώτημα είναι αν θα βρουν εσένα ή τον ανταγωνιστή σου.</p><p>Ξεκινάμε με έλεγχο του site και της αγοράς σου, διορθώνουμε ό,τι σε κρατάει πίσω και χτίζουμε σταθερά περιεχόμενο και φήμη. Χωρίς υποσχέσεις για «πρώτη θέση σε μια εβδομάδα», με μετρήσιμη πρόοδο κάθε μήνα.</p>',
			'features' => array(
				array( 'fas fa-stethoscope', 'SEO audit', 'Έλεγχος ταχύτητας, δομής, ευρετηρίασης και περιεχομένου, με λίστα προτεραιοτήτων.' ),
				array( 'fas fa-cogs', 'Τεχνικό SEO', 'Ταχύτητα, schema, sitemap, redirects και διορθώσεις που η Google «βλέπει» γρήγορα.' ),
				array( 'fas fa-key', 'Λέξεις-κλειδιά & περιεχόμενο', 'Βρίσκουμε τι ψάχνουν οι πελάτες σου και γράφουμε σελίδες και άρθρα που απαντούν.' ),
				array( 'fas fa-map-marker-alt', 'Local SEO', 'Google Business Profile, κριτικές και τοπικές αναζητήσεις, για να σε βρίσκουν στην περιοχή σου.' ),
				array( 'fas fa-bullhorn', 'Google Ads & social ads', 'Στοχευμένες καμπάνιες με σαφές budget και παρακολούθηση του κόστους ανά πελάτη.' ),
				array( 'fas fa-chart-line', 'Analytics & αναφορές', 'Μηνιαία αναφορά σε απλά ελληνικά: τι κάναμε, τι άλλαξε, τι ακολουθεί.' ),
			),
			'process'  => array(
				array( 'Έλεγχος', 'SEO audit του site και ανάλυση του ανταγωνισμού.' ),
				array( 'Στρατηγική', 'Στόχοι, λέξεις-κλειδιά και πλάνο εργασιών για τους επόμενους μήνες.' ),
				array( 'Υλοποίηση', 'Τεχνικές διορθώσεις, νέο περιεχόμενο, Google Business Profile και καμπάνιες.' ),
				array( 'Μέτρηση', 'Μηνιαία αναφορά και προσαρμογή του πλάνου με βάση τα αποτελέσματα.' ),
			),
			'cats'     => array( 'seo' ),
			'packages' => '',
			'faq'      => array(
				array( 'Σε πόσο καιρό θα δω αποτελέσματα;', 'Οι τεχνικές διορθώσεις φαίνονται συχνά μέσα σε λίγες εβδομάδες. Για σταθερή άνοδο σε ανταγωνιστικές αναζητήσεις υπολόγιζε 3–6 μήνες συνεχούς δουλειάς.' ),
				array( 'Εγγυάστε πρώτη θέση στη Google;', 'Όχι, και να προσέχεις όποιον το εγγυάται: κανείς δεν ελέγχει τη Google. Εγγυόμαστε σωστή δουλειά, διαφάνεια και μετρήσιμη πρόοδο.' ),
				array( 'Χρειάζομαι SEO αν κάνω ήδη διαφήμιση;', 'Η διαφήμιση φέρνει επισκέπτες όσο πληρώνεις. Το SEO χτίζει ορατότητα που μένει. Οι περισσότερες επιχειρήσεις κερδίζουν με τον συνδυασμό τους.' ),
				array( 'Κάνετε SEO σε site που δεν φτιάξατε εσείς;', 'Ναι. Ξεκινάμε με έλεγχο και σου λέμε ειλικρινά αν το site χρειάζεται διορθώσεις ή ανανέωση για να αποδώσει.' ),
			),
			'seo'      => array( 'SEO & digital marketing για επιχειρήσεις | Polygons', 'Τεχνικό SEO, local SEO, Google Business Profile, περιεχόμενο και διαφήμιση. Φέρε στο site σου τους πελάτες που ήδη ψάχνουν αυτό που προσφέρεις.' ),
		),
	);
}

/** Rank Math title + meta description per page slug. */
function pg_seo_meta() {
	return array(
		'arxiki'         => array( 'Polygons | Κατασκευή ιστοσελίδων, branding, hosting & SEO', 'Design studio για κατασκευή ιστοσελίδων, εταιρική ταυτότητα, hosting και SEO. Γρήγορα, όμορφα sites που φέρνουν πελάτες, από έναν συνεργάτη.' ),
		'ti-kanoume'     => array( 'Υπηρεσίες: web design, branding, hosting & SEO | Polygons', 'Κατασκευή ιστοσελίδων, εταιρική ταυτότητα, hosting και SEO από μία ομάδα. Δες τι περιλαμβάνει κάθε υπηρεσία, τα πακέτα και τις συχνές ερωτήσεις.' ),
		'oi-doulies-mas' => array( 'Οι δουλειές μας: ιστοσελίδες & branding | Polygons', 'Ιστοσελίδες, e-shops, λογότυπα και καμπάνιες που σχεδιάσαμε. Δες την πρόκληση, τη λύση και το αποτέλεσμα σε κάθε έργο.' ),
		'poioi-eimaste'  => array( 'Ποιοι είμαστε | Polygons design studio', 'Γνώρισε το Polygons: ένα δημιουργικό studio που ενώνει design, τεχνολογία, hosting και marketing για να ξεχωρίσει η ψηφιακή σου παρουσία.' ),
		'epikoinwnia'    => array( 'Επικοινωνία | Polygons', 'Στείλε μας μήνυμα για το project σου ή γράψε μας στο info@polygons.gr. Απαντάμε συνήθως μέσα στην ίδια εργάσιμη.' ),
		'prosfora'       => array( 'Ζήτα προσφορά για ιστοσελίδα, branding ή SEO | Polygons', 'Πες μας τι χρειάζεσαι σε τρία σύντομα βήματα και θα σου στείλουμε ξεκάθαρη προσφορά με κόστος και χρονοδιάγραμμα, χωρίς ψιλά γράμματα.' ),
		'blog'           => array( 'Blog: web design, SEO & branding | Polygons', 'Πρακτικοί οδηγοί και συμβουλές για ιστοσελίδες, SEO, hosting και εταιρική ταυτότητα, από την ομάδα του Polygons.' ),
	);
}

function pg_blog_cats() {
	return array( 'web-design' => 'Web design', 'seo' => 'SEO', 'branding' => 'Branding' );
}

/** Sample articles (written as guides; review before launch). Content is block markup for the WP editor. */
function pg_posts() {
	return array(
		array(
			'cat' => 'web-design', 'img' => 'web', 'date' => '2026-09-08 10:00:00', 'slug' => 'poso-grigoro-prepei-na-einai-ena-site',
			'title'   => 'Πόσο γρήγορο πρέπει να είναι ένα site;',
			'excerpt' => 'Τα Core Web Vitals με απλά λόγια: τι μετράει η Google, ποια είναι τα συνηθισμένα προβλήματα και πώς τα λύνουμε.',
			'content' => pg_blocks( array(
				'p:Όταν ένα site αργεί, ο επισκέπτης δεν περιμένει: γυρίζει πίσω στα αποτελέσματα της Google και πατάει τον επόμενο. Η ταχύτητα δεν είναι τεχνική λεπτομέρεια, είναι το πρώτο πράγμα που «βλέπει» ο πελάτης σου.',
				'h:Τι μετράει η Google',
				'p:Η Google αξιολογεί την εμπειρία φόρτωσης με τρεις δείκτες, τα Core Web Vitals:',
				'ul:<strong>LCP</strong> (Largest Contentful Paint): πόσο γρήγορα εμφανίζεται το βασικό περιεχόμενο. Στόχος: κάτω από 2,5 δευτερόλεπτα.|<strong>INP</strong> (Interaction to Next Paint): πόσο γρήγορα αντιδρά η σελίδα όταν πατάς κάτι. Στόχος: κάτω από 200 ms.|<strong>CLS</strong> (Cumulative Layout Shift): αν «πηδάει» το περιεχόμενο καθώς φορτώνει. Στόχος: κάτω από 0,1.',
				'h:Τα συνηθισμένα προβλήματα',
				'p:Στους ελέγχους που κάνουμε βλέπουμε ξανά και ξανά τα ίδια: τεράστιες εικόνες, δεκάδες plugins που φορτώνουν κώδικα σε κάθε σελίδα, βαριά themes με λειτουργίες που δεν χρησιμοποιούνται και φθηνό hosting χωρίς caching.',
				'h:Πώς το λύνουμε',
				'ul:Εικόνες σε WebP, στο σωστό μέγεθος, με lazy loading.|Κώδικας μόνο εκεί που χρειάζεται, όχι σε κάθε σελίδα.|Γραμματοσειρές φιλοξενημένες στο ίδιο το site.|Caching στον server και Cloudflare μπροστά από κάθε site.',
				'p:Θέλεις να δεις πού βρίσκεται το δικό σου site; <a href="/#elegxos">Ζήτα δωρεάν έλεγχο</a> και θα σου στείλουμε μια σύντομη αναφορά.',
			) ),
		),
		array(
			'cat' => 'seo', 'img' => 'marketing', 'date' => '2026-09-15 10:00:00', 'slug' => 'local-seo-7-vimata',
			'title'   => 'Local SEO: 7 βήματα για να σε βρίσκουν στην περιοχή σου',
			'excerpt' => 'Από το Google Business Profile μέχρι τις κριτικές: τι χρειάζεται για να εμφανίζεσαι στον χάρτη όταν σε ψάχνουν κοντά σου.',
			'content' => pg_blocks( array(
				'p:Όταν κάποιος ψάχνει «οδοντίατρος Χαλάνδρι» ή «καφέ κοντά μου», η Google δείχνει πρώτα έναν χάρτη με λίγες επιχειρήσεις. Αυτές οι θέσεις φέρνουν τα περισσότερα τηλεφωνήματα. Δες πώς να διεκδικήσεις μία.',
				'h:1. Διεκδίκησε το Google Business Profile σου',
				'p:Είναι δωρεάν και είναι η βάση του local SEO. Επιβεβαίωσε την επιχείρηση και συμπλήρωσε κάθε πεδίο: ωράριο, υπηρεσίες, περιοχές εξυπηρέτησης.',
				'h:2. Διάλεξε τη σωστή κατηγορία',
				'p:Η βασική κατηγορία επηρεάζει έντονα το σε ποιες αναζητήσεις εμφανίζεσαι. Προτίμησε την πιο συγκεκριμένη που σε περιγράφει.',
				'h:3. Ίδια στοιχεία παντού',
				'p:Επωνυμία, διεύθυνση και τηλέφωνο πρέπει να γράφονται ακριβώς ίδια στο site, στο προφίλ και στους καταλόγους.',
				'h:4. Κριτικές, συστηματικά',
				'p:Ζήτα κριτική από κάθε ικανοποιημένο πελάτη και απάντα σε όλες, ακόμα και στις αρνητικές.',
				'h:5. Φωτογραφίες & αναρτήσεις',
				'p:Πραγματικές φωτογραφίες του χώρου και της δουλειάς σου, και τακτικές αναρτήσεις με νέα και προσφορές.',
				'h:6. Μια σελίδα για κάθε υπηρεσία',
				'p:Στο site σου, κάθε βασική υπηρεσία χρειάζεται τη δική της σελίδα, με αναφορά στις περιοχές που εξυπηρετείς.',
				'h:7. Γρήγορο site, φιλικό στο κινητό',
				'p:Οι περισσότερες τοπικές αναζητήσεις γίνονται από κινητό. Αν το site αργεί, ο πελάτης καλεί τον επόμενο.',
				'p:Θέλεις βοήθεια; Δες τι κάνουμε στο <a href="/ti-kanoume/seo/">SEO & digital marketing</a>.',
			) ),
		),
		array(
			'cat' => 'branding', 'img' => 'branding', 'date' => '2026-09-22 10:00:00', 'slug' => 'logotypo-i-etairiki-taytotita',
			'title'   => 'Λογότυπο ή εταιρική ταυτότητα; Η διαφορά που μετράει',
			'excerpt' => 'Το λογότυπο είναι μόνο η αρχή. Τι είναι η εταιρική ταυτότητα, γιατί μετράει η συνέπεια και τι να ζητήσεις από τον designer σου.',
			'content' => pg_blocks( array(
				'p:Πολλές επιχειρήσεις ξεκινούν ζητώντας «ένα λογότυπο». Λογικό, είναι το πιο ορατό κομμάτι. Όμως το λογότυπο είναι μόνο η αρχή.',
				'h:Το λογότυπο',
				'p:Είναι η υπογραφή σου: ένα σύμβολο ή μια λέξη που σε κάνει αναγνωρίσιμο. Πρέπει να είναι απλό, να διαβάζεται σε μικρό μέγεθος και να δουλεύει και σε ένα χρώμα.',
				'h:Η εταιρική ταυτότητα',
				'p:Είναι το σύστημα γύρω από το λογότυπο: χρώματα, γραμματοσειρές, φωτογραφικό ύφος, εικονίδια και οι κανόνες για το πώς συνδυάζονται. Χάρη σε αυτό, ένα post, μια κάρτα και μια σελίδα του site μοιάζουν ότι έρχονται από το ίδιο brand.',
				'h:Γιατί μετράει η συνέπεια',
				'p:Κάθε φορά που κάποιος βλέπει το brand σου με τον ίδιο τρόπο, το θυμάται λίγο καλύτερα. Όταν κάθε υλικό φτιάχνεται «από την αρχή», αυτή η αναγνωρισιμότητα χάνεται.',
				'h:Τι να ζητήσεις από τον designer σου',
				'ul:Το λογότυπο σε όλες τις εκδοχές: οριζόντιο, κάθετο, σύμβολο, μονόχρωμο.|Διανυσματικά αρχεία για εκτύπωση και αρχεία για web.|Χρωματική παλέτα με κωδικούς για οθόνη και εκτύπωση.|Έναν σύντομο οδηγό χρήσης.',
				'p:Δες πώς δουλεύουμε την <a href="/ti-kanoume/etairiki-taytotita/">εταιρική ταυτότητα</a>.',
			) ),
		),
	);
}

/** Tiny block-markup builder: "p:…", "h:…" (h2), "ul:a|b|c". */
function pg_blocks( array $lines ) {
	$out = array();
	foreach ( $lines as $line ) {
		list( $type, $text ) = explode( ':', $line, 2 );
		if ( 'h' === $type ) {
			$out[] = "<!-- wp:heading -->\n<h2 class=\"wp-block-heading\">$text</h2>\n<!-- /wp:heading -->";
		} elseif ( 'ul' === $type ) {
			$items = array_map( function ( $i ) {
				return "<!-- wp:list-item -->\n<li>$i</li>\n<!-- /wp:list-item -->";
			}, explode( '|', $text ) );
			$out[] = "<!-- wp:list -->\n<ul class=\"wp-block-list\">" . implode( "\n", $items ) . "</ul>\n<!-- /wp:list -->";
		} else {
			$out[] = "<!-- wp:paragraph -->\n<p>$text</p>\n<!-- /wp:paragraph -->";
		}
	}
	return implode( "\n\n", $out );
}
