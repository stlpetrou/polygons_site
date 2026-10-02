// Full-page screenshots: node shot.mjs [path ...]  → tools/shots/<name>-{desktop,mobile}.png
import { chromium } from 'playwright';
import { mkdirSync } from 'node:fs';

const BASE = process.env.BASE || 'http://polygons.test';
const paths = process.argv.slice(2).length ? process.argv.slice(2) : ['/', '/ti-kanoume/', '/oi-doulies-mas/', '/poioi-eimaste/', '/epikoinwnia/'];
const out = new URL('./shots/', import.meta.url).pathname;
mkdirSync(out, { recursive: true });

const devices = {
	desktop: { viewport: { width: 1440, height: 900 } },
	mobile: { viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true, deviceScaleFactor: 2 },
};

const browser = await chromium.launch();
for (const [name, opts] of Object.entries(devices)) {
	const ctx = await browser.newContext({ ...opts, reducedMotion: 'reduce' });
	const page = await ctx.newPage();
	const errors = [];
	page.on('pageerror', (e) => errors.push(e.message));
	page.on('console', (m) => m.type() === 'error' && errors.push(m.text()));
	for (const p of paths) {
		await page.goto(BASE + p, { waitUntil: 'networkidle' });
		// Trigger lazy content, then return to top.
		await page.evaluate(async () => {
			for (let y = 0; y < document.body.scrollHeight; y += 600) { window.scrollTo(0, y); await new Promise((r) => setTimeout(r, 60)); }
			window.scrollTo(0, 0);
		});
		await page.waitForTimeout(400);
		const file = `${out}${(p.replace(/\//g, '-').replace(/^-|-$/g, '') || 'home')}-${name}.png`;
		await page.screenshot({ path: file, fullPage: true });
		console.log(file);
	}
	if (errors.length) console.log(`[${name}] JS errors:\n  ` + [...new Set(errors)].join('\n  '));
	await ctx.close();
}
await browser.close();
