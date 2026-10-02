/* Polygons — site effects (#1 loader, #4 #5 #8 #10 #11 #12 #14). No dependencies. */
( function () {
	var d = document;
	var root = d.documentElement;
	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var fine = window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches;
	var off = function () { return reduce || root.classList.contains( 'fx-off' ); };
	var clamp = function ( v, a, b ) { return Math.max( a, Math.min( b, v ) ); };
	var $$ = function ( s, ctx ) { return Array.prototype.slice.call( ( ctx || d ).querySelectorAll( s ) ); };

	/* ---------- Reveal plumbing (#8) ---------- */
	var io = 'IntersectionObserver' in window ? new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( e ) {
			if ( e.isIntersecting ) {
				e.target.classList.add( 'is-in' );
				io.unobserve( e.target );
			}
		} );
	}, { rootMargin: '0px 0px -12% 0px' } ) : null;
	function reveal( el ) {
		// Only below-the-fold elements start hidden, so nothing visible on load flashes.
		if ( ! io || reduce || el.getBoundingClientRect().top < window.innerHeight * 0.9 ) {
			el.classList.add( 'is-in' );
			return;
		}
		el.classList.add( 'fx-pending' );
		io.observe( el );
	}
	$$( '.fx-hex .pg-project__media' ).forEach( reveal );
	$$( '.fx-stagger' ).forEach( function ( el ) {
		Array.prototype.forEach.call( el.children, function ( c, i ) { c.style.setProperty( '--i', i ); } );
		reveal( el );
	} );

	/* ---------- #5 Stack depth, #14 smart header ---------- */
	var stacks = $$( '.fx-stack' );
	function checkStacks() {
		// A card taller than the viewport can't be read while stuck: fall back to normal flow.
		stacks.forEach( function ( s ) {
			var cards = $$( ':scope > .e-con', s );
			var header = d.getElementById( 'jet-theme-core-header' );
			var top = ( header ? header.offsetHeight : 76 ) + 24;
			// Each card sticks at top + i*16px and must fit fully below that point.
			s.classList.toggle( 'fx-stack-off', cards.some( function ( c, i ) { return top + i * 16 + c.offsetHeight > window.innerHeight - 16; } ) );
			cards.forEach( function ( c, i ) { c.style.setProperty( '--i', i ); } );
		} );
	}
	checkStacks();
	window.addEventListener( 'resize', checkStacks );

	var lastY = window.scrollY, ticking = false;
	function onScrollFrame() {
		ticking = false;
		var y = window.scrollY, dy = y - lastY;
		lastY = y;
		if ( off() ) { return; }

		stacks.forEach( function ( s ) {
			if ( s.classList.contains( 'fx-stack-off' ) ) { return; }
			var cards = $$( ':scope > .e-con', s );
			cards.forEach( function ( c, i ) {
				var next = cards[ i + 1 ];
				if ( ! next ) { return; }
				var r = c.getBoundingClientRect(), n = next.getBoundingClientRect();
				var overlap = clamp( ( r.bottom - n.top ) / r.height, 0, 1 );
				c.style.setProperty( '--s', ( 1 - 0.06 * overlap ).toFixed( 3 ) );
				c.style.setProperty( '--b', ( 1 - 0.45 * overlap ).toFixed( 3 ) );
			} );
		} );

		if ( Math.abs( dy ) > 4 ) {
			var menuOpen = d.querySelector( '.jet-mobile-menu-active' );
			root.classList.toggle( 'fx-header-hidden', dy > 0 && y > 240 && ! menuOpen );
		}
	}
	window.addEventListener( 'scroll', function () {
		if ( ! ticking ) { ticking = true; requestAnimationFrame( onScrollFrame ); }
	}, { passive: true } );
	// Keyboard focus inside the header always brings it back.
	d.addEventListener( 'focusin', function ( e ) {
		if ( e.target.closest && e.target.closest( '#jet-theme-core-header' ) ) { root.classList.remove( 'fx-header-hidden' ); }
	} );

	/* ---------- Pointer effects: #4 glow, #10 tilt, #11 border, #12 magnetic (desktop only) ---------- */
	if ( fine && ! reduce ) {
		var decorate = function () {
			$$( '.fx-tilt .pg-project:not(.fx-tilt-el)' ).forEach( function ( el ) {
				el.classList.add( 'fx-tilt-el' );
				var sheen = d.createElement( 'span' );
				sheen.className = 'fx-sheen';
				el.appendChild( sheen );
			} );
			$$( '.fx-border .pg-pack, .fx-border .pg-card' ).forEach( function ( el ) { el.classList.add( 'fx-border-el' ); } );
		};
		decorate();
		// Listings re-render after JetSmartFilters AJAX — decorate the new cards too.
		d.addEventListener( 'jet-filter-content-rendered', decorate );
		if ( window.jQuery ) { window.jQuery( d ).on( 'jet-filter-content-rendered', decorate ); }

		var px = 0, py = 0, pending = false, lastTilt = null, lastMag = null;
		var resetTilt = function ( el ) {
			el.classList.remove( 'is-tilting' );
			[ '--rx', '--ry', '--ty' ].forEach( function ( p ) { el.style.removeProperty( p ); } );
		};
		d.addEventListener( 'pointermove', function ( e ) {
			px = e.clientX; py = e.clientY;
			if ( ! pending ) { pending = true; requestAnimationFrame( pointerFrame ); }
		}, { passive: true } );

		function pointerFrame() {
			pending = false;
			if ( off() ) { return; }
			var target = d.elementFromPoint( px, py );
			if ( ! target ) { return; }

			var glow = target.closest( '.fx-glow' );
			if ( glow ) {
				var g = glow.getBoundingClientRect();
				glow.style.setProperty( '--gx', ( px - g.left ) + 'px' );
				glow.style.setProperty( '--gy', ( py - g.top ) + 'px' );
			}

			var border = target.closest( '.fx-border-el' );
			if ( border ) {
				var b = border.getBoundingClientRect();
				border.style.setProperty( '--bx', ( px - b.left ) + 'px' );
				border.style.setProperty( '--by', ( py - b.top ) + 'px' );
			}

			var tilt = target.closest( '.fx-tilt-el' );
			if ( lastTilt && lastTilt !== tilt ) { resetTilt( lastTilt ); }
			if ( tilt ) {
				var t = tilt.getBoundingClientRect();
				var nx = ( px - t.left ) / t.width - 0.5, ny = ( py - t.top ) / t.height - 0.5;
				tilt.classList.add( 'is-tilting' );
				tilt.style.setProperty( '--ry', ( nx * 10 ).toFixed( 2 ) + 'deg' );
				tilt.style.setProperty( '--rx', ( -ny * 8 ).toFixed( 2 ) + 'deg' );
				tilt.style.setProperty( '--ty', '-6px' );
				tilt.style.setProperty( '--sx', ( 100 - ( nx + 0.5 ) * 100 ).toFixed( 1 ) + '%' );
			}
			lastTilt = tilt;

			var hit = null;
			$$( '.fx-magnetic' ).forEach( function ( m ) {
				var btn = m.querySelector( '.elementor-button' );
				if ( ! btn || hit ) { return; }
				var r = btn.getBoundingClientRect(), dx = px - ( r.left + r.width / 2 ), dy = py - ( r.top + r.height / 2 );
				if ( Math.abs( dx ) < r.width / 2 + 70 && Math.abs( dy ) < r.height / 2 + 70 ) {
					hit = m;
					m.classList.add( 'is-pulling' );
					m.style.setProperty( '--mx', ( dx * 0.22 ).toFixed( 1 ) + 'px' );
					m.style.setProperty( '--my', ( dy * 0.3 ).toFixed( 1 ) + 'px' );
				}
			} );
			if ( lastMag && lastMag !== hit ) {
				lastMag.classList.remove( 'is-pulling' );
				lastMag.style.removeProperty( '--mx' ); lastMag.style.removeProperty( '--my' );
			}
			lastMag = hit;
		}
		d.documentElement.addEventListener( 'pointerleave', function () { if ( lastTilt ) { resetTilt( lastTilt ); } } );
	}

	/* ---------- #1 Mesh: load its script only where used, never during page load ----------
	   Desktop: after load + idle. Touch devices: on the first touch/scroll, so the mesh never
	   competes with the first render on slow phones. */
	var meshHosts = $$( '.fx-mesh' );
	if ( meshHosts.length && window.polygonsFx && window.polygonsFx.mesh && ! reduce ) {
		var loaded = false;
		var loadMesh = function () {
			if ( loaded ) { return; }
			loaded = true;
			var s = d.createElement( 'script' );
			s.src = window.polygonsFx.mesh;
			s.async = true;
			d.body.appendChild( s );
		};
		if ( fine ) {
			window.addEventListener( 'load', function () {
				( window.requestIdleCallback || function ( cb ) { setTimeout( cb, 250 ); } )( loadMesh );
			} );
		} else {
			[ 'pointerdown', 'touchstart', 'scroll', 'keydown' ].forEach( function ( ev ) {
				window.addEventListener( ev, loadMesh, { once: true, passive: true } );
			} );
		}
	}
}() );
