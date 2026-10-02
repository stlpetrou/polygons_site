/* Effects Lab only: ON/OFF toggle and the effects not (yet) used on the site: #6 #7 #9 #16 #17. */
( function () {
	var d = document;
	var root = d.documentElement;
	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var off = function () { return reduce || root.classList.contains( 'fx-off' ); };
	var clamp = function ( v, a, b ) { return Math.max( a, Math.min( b, v ) ); };
	var $$ = function ( s ) { return Array.prototype.slice.call( d.querySelectorAll( s ) ); };

	var toggle = d.createElement( 'button' );
	toggle.type = 'button';
	toggle.className = 'fx-toggle';
	toggle.innerHTML = '<i></i><span>Εφέ: ON</span>';
	toggle.addEventListener( 'click', function () {
		toggle.querySelector( 'span' ).textContent = root.classList.toggle( 'fx-off' ) ? 'Εφέ: OFF' : 'Εφέ: ON';
	} );
	d.body.appendChild( toggle );

	var io = new IntersectionObserver( function ( entries ) {
		entries.forEach( function ( e ) {
			if ( e.isIntersecting ) {
				e.target.classList.add( 'is-in' );
				e.target.dispatchEvent( new CustomEvent( 'fx:in' ) );
				io.unobserve( e.target );
			}
		} );
	}, { rootMargin: '0px 0px -12% 0px' } );
	function reveal( el ) {
		if ( reduce || el.getBoundingClientRect().top < window.innerHeight * 0.9 ) {
			el.classList.add( 'is-in' );
			el.dispatchEvent( new CustomEvent( 'fx:in' ) );
			return;
		}
		el.classList.add( 'fx-pending' );
		io.observe( el );
	}

	/* #6 */
	$$( '.fx-words' ).forEach( function ( widget ) {
		var i = 0;
		( function walk( node ) {
			Array.prototype.slice.call( node.childNodes ).forEach( function ( n ) {
				if ( 3 === n.nodeType ) {
					var frag = d.createDocumentFragment();
					n.textContent.split( /(\s+)/ ).forEach( function ( t ) {
						if ( ! t ) { return; }
						if ( /^\s+$/.test( t ) ) { frag.appendChild( d.createTextNode( t ) ); return; }
						var s = d.createElement( 'span' );
						s.className = 'fx-w';
						s.style.setProperty( '--i', i++ );
						s.textContent = t;
						frag.appendChild( s );
					} );
					n.parentNode.replaceChild( frag, n );
				} else if ( 1 === n.nodeType && 'BR' !== n.tagName ) {
					walk( n );
				}
			} );
		}( widget.querySelector( '.elementor-heading-title' ) || widget ) );
		reveal( widget );
	} );

	/* #16 */
	var glyphs = 'ΑΒΓΔΕΖΗΘΛΞΠΣΦΨΩ0123456789#%&*+<>/';
	$$( '.fx-decode' ).forEach( function ( widget ) {
		var el = widget.querySelector( '.elementor-heading-title' ) || widget;
		var text = el.textContent;
		el.innerHTML = '<span class="pg-sr-only"></span><span aria-hidden="true"></span>';
		el.firstChild.textContent = text;
		var vis = el.lastChild;
		vis.textContent = text;
		widget.addEventListener( 'fx:in', function () {
			if ( off() ) { return; }
			var start = performance.now();
			( function frame( now ) {
				var p = clamp( ( now - start ) / 900, 0, 1 ), out = '';
				for ( var k = 0; k < text.length; k++ ) {
					out += ( ' ' === text[ k ] || k < p * text.length ) ? text[ k ] : glyphs[ ( Math.random() * glyphs.length ) | 0 ];
				}
				vis.textContent = out;
				if ( p < 1 ) { requestAnimationFrame( frame ); }
			}( start ) );
		} );
		reveal( widget );
	} );

	/* #7 */
	$$( '.fx-progress' ).forEach( reveal );

	/* #9 fallback where scroll timelines aren't supported */
	var read = d.querySelector( '.fx-read' );
	if ( read && ! ( window.CSS && CSS.supports( 'animation-timeline: scroll()' ) ) ) {
		var setRead = function () {
			var max = root.scrollHeight - window.innerHeight;
			read.style.setProperty( '--p', max > 0 ? window.scrollY / max : 0 );
		};
		window.addEventListener( 'scroll', setRead, { passive: true } );
		setRead();
	}

	/* #17 */
	var track = d.querySelector( '.fx-velocity .pg-marquee__track' );
	var anim = track && track.getAnimations ? track.getAnimations()[ 0 ] : null;
	if ( anim && ! reduce ) {
		var lastY = window.scrollY, lastT = performance.now(), rate = 1, dir = 1, current = 1;
		window.addEventListener( 'scroll', function () {
			var now = performance.now(), v = ( window.scrollY - lastY ) / Math.max( 16, now - lastT );
			lastY = window.scrollY; lastT = now;
			if ( Math.abs( v ) > 0.05 ) { dir = v > 0 ? 1 : -1; }
			rate = clamp( Math.abs( v ) * 6, 1, 7 );
		}, { passive: true } );
		( function ease() {
			rate += ( 1 - rate ) * 0.04;
			current += ( rate * dir - current ) * 0.12;
			anim.playbackRate = off() ? 1 : current;
			requestAnimationFrame( ease );
		}() );
	}
}() );
