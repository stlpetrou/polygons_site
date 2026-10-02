// Horizontal-overflow finder (mobile 390px by default): node overflow.mjs [path ...]  (WIDTH=360 to change)
// Lists the outermost elements that stick out past the viewport — the usual cause of sideways scroll/cut text.
import { chromium } from 'playwright';

const BASE = process.env.BASE || 'http://polygons.test';
const W = +(process.env.WIDTH || 390);
const paths = process.argv.slice(2).length ? process.argv.slice(2) : ['/'];
const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: W, height: 844 }, isMobile: true, hasTouch: true });
for (const p of paths) {
	await page.goto(BASE + p, { waitUntil: 'networkidle' });
	const res = await page.evaluate((W) => {
		const out = [];
		for (const el of document.querySelectorAll('body *')) {
			const r = el.getBoundingClientRect();
			if (r.width === 0 || r.right <= W + 1) continue;
			if (el.parentElement && el.parentElement.getBoundingClientRect().right > W + 1) continue; // report outermost only
			let clipped = false;
			for (let a = el.parentElement; a && a !== document.body; a = a.parentElement) {
				const o = getComputedStyle(a).overflowX;
				if (o === 'hidden' || o === 'clip' || o === 'auto' || o === 'scroll') { clipped = true; break; }
			}
			out.push(`${clipped ? '(clipped) ' : ''}<${el.tagName.toLowerCase()} class="${(el.className.baseVal ?? el.className).toString().slice(0, 80)}"> right=${Math.round(r.right)} w=${Math.round(r.width)}`);
		}
		return { scrollW: document.documentElement.scrollWidth, out: out.slice(0, 15) };
	}, W);
	console.log(`${p}  scrollWidth=${res.scrollW}${res.scrollW > W ? '  ⚠ PAGE SCROLLS SIDEWAYS' : ''}`);
	res.out.forEach((l) => console.log('   ' + l));
}
await browser.close();
