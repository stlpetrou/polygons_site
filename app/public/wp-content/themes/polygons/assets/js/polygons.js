/* Polygons — tiny progressive enhancements (no dependencies). */
( function () {
	var root = document.documentElement;
	root.classList.add( 'pg-js' );

	// Header background once the page is scrolled.
	var ticking = false;
	function onScroll() {
		root.classList.toggle( 'is-scrolled', window.scrollY > 24 );
		ticking = false;
	}
	window.addEventListener( 'scroll', function () {
		if ( ! ticking ) {
			ticking = true;
			requestAnimationFrame( onScroll );
		}
	}, { passive: true } );
	onScroll();

	// Reveal cards and section intros as they enter the viewport.
	if ( ! ( 'IntersectionObserver' in window ) || window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}
	var targets = document.querySelectorAll( '.pg-intro, .pg-card, .pg-feature, .pg-cta__panel, .pg-form-card, .pg-meta' );
	var io = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( entry ) {
			if ( entry.isIntersecting ) {
				entry.target.classList.add( 'is-in' );
				io.unobserve( entry.target );
			}
		} );
	}, { rootMargin: '0px 0px -8% 0px' } );
	targets.forEach( function ( el, i ) {
		// Cards inside a staggered group are animated by fx.js.
		if ( el.closest( '.fx-stagger' ) ) {
			return;
		}
		// Only hide what is below the fold, so nothing visible on load ever flashes.
		if ( el.getBoundingClientRect().top < window.innerHeight ) {
			return;
		}
		el.classList.add( 'pg-reveal' );
		el.style.transitionDelay = ( i % 4 ) * 70 + 'ms';
		io.observe( el );
	} );
}() );

/* Chat launcher: the Tawk.to widget (~400 KB) loads only when the visitor clicks. */
( function () {
	var btn = document.querySelector( '.pg-chat[data-tawk]' );
	if ( ! btn ) {
		return;
	}
	var loaded = false, ready = false, failed = false;
	btn.addEventListener( 'click', function () {
		var api = window.Tawk_API;
		if ( failed ) { // chat service unavailable → contact page instead
			window.location.href = '/epikoinwnia/';
			return;
		}
		if ( loaded && api && api.maximize ) {
			api.showWidget();
			api.maximize();
			btn.classList.add( 'is-hidden' );
			return;
		}
		loaded = true;
		btn.classList.add( 'is-loading' );
		window.Tawk_API = window.Tawk_API || {};
		window.Tawk_LoadStart = new Date();
		setTimeout( function () {
			if ( ! ready ) {
				failed = true;
				btn.classList.remove( 'is-loading' );
				btn.setAttribute( 'aria-label', 'Το chat δεν είναι διαθέσιμο — στείλε μας μήνυμα' );
			}
		}, 8000 );
		window.Tawk_API.onLoad = function () {
			ready = true;
			btn.classList.remove( 'is-loading' );
			btn.classList.add( 'is-hidden' );
			window.Tawk_API.maximize();
		};
		// Back to our light button when the visitor closes the chat.
		window.Tawk_API.onChatMinimized = function () {
			window.Tawk_API.hideWidget();
			btn.classList.remove( 'is-hidden' );
		};
		var s = document.createElement( 'script' );
		s.async = true;
		s.src = 'https://embed.tawk.to/' + btn.getAttribute( 'data-tawk' );
		s.charset = 'UTF-8';
		s.setAttribute( 'crossorigin', '*' );
		document.body.appendChild( s );
	} );
}() );
