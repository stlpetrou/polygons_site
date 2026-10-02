/* Polygons — #1 interactive polygon mesh. Loaded on demand by fx.js (after load + idle). */
( function () {
	var d = document;
	var root = d.documentElement;
	var reduce = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;
	var fine = window.matchMedia( '(hover: hover) and (pointer: fine)' ).matches;
	var off = function () { return reduce || root.classList.contains( 'fx-off' ); };
	var clamp = function ( v, a, b ) { return Math.max( a, Math.min( b, v ) ); };

	function initMesh( host ) {
		var canvas = d.createElement( 'canvas' );
		canvas.className = 'fx-mesh__canvas';
		canvas.setAttribute( 'aria-hidden', 'true' );
		host.insertBefore( canvas, host.firstChild );
		var ctx = canvas.getContext( '2d' );
		var lowEnd = ( navigator.hardwareConcurrency || 4 ) <= 4 || ! fine;
		var dpr = Math.min( window.devicePixelRatio || 1, lowEnd ? 1 : 1.5 );
		// Touch / low-end: draw one frame, then animate only for a moment after each touch.
		var activeUntil = 0;
		var running = function ( t ) { return visible && ! d.hidden && ! off() && ( ! lowEnd || t < activeUntil ); };
		var W, H, pts = [], cols, rows, visible = true, raf = 0;
		var pointer = { x: -9999, y: -9999, active: false };
		var R = lowEnd ? 180 : 240;

		function build() {
			var rect = host.getBoundingClientRect();
			W = rect.width; H = rect.height;
			canvas.width = W * dpr; canvas.height = H * dpr;
			ctx.setTransform( dpr, 0, 0, dpr, 0, 0 );
			var gap = lowEnd ? 110 : 72;
			cols = Math.ceil( W / gap ) + 2; rows = Math.ceil( H / ( gap * 0.866 ) ) + 2;
			pts = [];
			for ( var r = 0; r < rows; r++ ) {
				for ( var c = 0; c < cols; c++ ) {
					pts.push( {
						bx: c * gap + ( r % 2 ? gap / 2 : 0 ) - gap + ( Math.random() - 0.5 ) * gap * 0.35,
						by: r * gap * 0.866 - gap + ( Math.random() - 0.5 ) * gap * 0.35,
						ph: Math.random() * Math.PI * 2,
					} );
				}
			}
		}

		// Edges are batched by brightness bucket: a handful of stroke() calls per frame instead of one per line.
		var BUCKETS = 6, paths;
		function edge( a, b ) {
			var dist = Math.hypot( ( a.x + b.x ) / 2 - pointer.x, ( a.y + b.y ) / 2 - pointer.y );
			var k = clamp( 1 - dist / R, 0, 1 );
			var bucket = k > 0 ? Math.min( BUCKETS, Math.ceil( k * BUCKETS ) ) : 0;
			paths[ bucket ].push( a.x, a.y, b.x, b.y );
		}
		function flush() {
			for ( var bk = 0; bk <= BUCKETS; bk++ ) {
				var arr = paths[ bk ];
				if ( ! arr.length ) { continue; }
				var k = bk / BUCKETS;
				ctx.strokeStyle = bk ? 'rgba(241,81,82,' + ( 0.06 + k * 0.85 ).toFixed( 3 ) + ')' : 'rgba(255,255,255,0.05)';
				ctx.lineWidth = 0.6 + k * 1.2;
				ctx.beginPath();
				for ( var j = 0; j < arr.length; j += 4 ) { ctx.moveTo( arr[ j ], arr[ j + 1 ] ); ctx.lineTo( arr[ j + 2 ], arr[ j + 3 ] ); }
				ctx.stroke();
			}
		}

		var frameGap = lowEnd ? 1000 / 30 : 0, lastFrame = 0;
		function draw( t ) {
			raf = 0;
			if ( frameGap && t - lastFrame < frameGap ) { // capped frame rate on touch / low-end devices
				if ( running( t ) ) { raf = requestAnimationFrame( draw ); }
				return;
			}
			lastFrame = t;
			paths = [];
			for ( var bi = 0; bi <= BUCKETS; bi++ ) { paths.push( [] ); }
			ctx.clearRect( 0, 0, W, H );
			if ( ! pointer.active && ! lowEnd ) {
				// Desktop idle: a slow drifting light keeps the mesh alive without input.
				pointer.x = W * ( 0.5 + 0.35 * Math.sin( t / 3100 ) );
				pointer.y = H * ( 0.5 + 0.30 * Math.cos( t / 2300 ) );
			}
			for ( var i = 0; i < pts.length; i++ ) {
				var p = pts[ i ];
				p.x = p.bx + Math.sin( t / 1800 + p.ph ) * 4;
				p.y = p.by + Math.cos( t / 2100 + p.ph ) * 4;
			}
			for ( var r = 0; r < rows; r++ ) {
				for ( var c = 0; c < cols; c++ ) {
					var a = pts[ r * cols + c ];
					if ( c + 1 < cols ) { edge( a, pts[ r * cols + c + 1 ] ); }
					if ( r + 1 < rows ) {
						var dl = r % 2 ? c : c - 1, dr = r % 2 ? c + 1 : c;
						if ( dl >= 0 ) { edge( a, pts[ ( r + 1 ) * cols + dl ] ); }
						if ( dr < cols ) { edge( a, pts[ ( r + 1 ) * cols + dr ] ); }
					}
				}
			}
			flush();
			var g = ctx.createRadialGradient( pointer.x, pointer.y, 0, pointer.x, pointer.y, R );
			g.addColorStop( 0, 'rgba(241,81,82,0.10)' ); g.addColorStop( 1, 'rgba(241,81,82,0)' );
			ctx.fillStyle = g; ctx.fillRect( 0, 0, W, H );
			if ( running( t ) ) { raf = requestAnimationFrame( draw ); }
		}
		function start() { if ( ! raf && visible && ! d.hidden && ! off() ) { raf = requestAnimationFrame( draw ); } }

		build();
		if ( reduce || lowEnd ) {
			pointer.x = W * 0.3; pointer.y = H * 0.4; pointer.active = true;
			draw( 0 ); // one static frame
		} else {
			start();
		}
		canvas.classList.add( 'is-on' );

		var track = function ( e ) {
			var r = host.getBoundingClientRect();
			pointer.x = e.clientX - r.left; pointer.y = e.clientY - r.top; pointer.active = true;
			if ( lowEnd ) { activeUntil = performance.now() + 1500; start(); }
		};
		host.addEventListener( 'pointermove', track, { passive: true } );
		host.addEventListener( 'pointerdown', track, { passive: true } );
		host.addEventListener( 'pointerleave', function () { pointer.active = false; } );
		new IntersectionObserver( function ( es ) { visible = es[ 0 ].isIntersecting; start(); } ).observe( host );
		d.addEventListener( 'visibilitychange', start );
		d.addEventListener( 'click', function ( e ) { if ( e.target.closest && e.target.closest( '.fx-toggle' ) ) { setTimeout( start, 0 ); } } );
		var rs;
		window.addEventListener( 'resize', function () { clearTimeout( rs ); rs = setTimeout( function () { build(); start(); }, 200 ); } );
	}

	Array.prototype.forEach.call( d.querySelectorAll( '.fx-mesh' ), initMesh );
}() );
