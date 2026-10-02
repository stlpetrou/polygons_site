// Whole-site smoke test (use after every deploy): BASE=https://staging.example.com node smoke.mjs
// Crawls every URL in the Rank Math sitemap + 404, and per page reports: HTTP status, JS errors, failed requests,
// mixed content (http:// assets on https), leftover local domain, broken images, robots meta.
import { chromium } from 'playwright';
const BASE = (process.env.BASE || 'http://polygons.test').replace(/\/$/, '');
const LOCAL = process.env.LOCAL || 'polygons.test';
const get = async (u) => (await fetch(u)).text();
const index = await get(BASE + '/sitemap_index.xml');
const maps = [...index.matchAll(/<loc>([^<]+)<\/loc>/g)].map((m) => m[1]);
let urls = [];
for (const m of maps) urls.push(...[...(await get(m)).matchAll(/<loc>([^<]+)<\/loc>/g)].map((x) => x[1]).filter((u) => !/\.(jpe?g|png|webp|svg)$/i.test(u)));
urls = [...new Set(urls), BASE + '/den-yparxei-' + Date.now() + '/'];
console.log(`${urls.length} URLs from ${maps.length} sitemaps\n`);
const b = await chromium.launch();
let bad = 0;
for (const u of urls) {
	const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
	const issues = [];
	p.on('pageerror', (e) => issues.push('JS: ' + e.message.slice(0, 120)));
	p.on('requestfailed', (r) => { if (!/tawk|google|facebook/.test(r.url())) issues.push('FAILED: ' + r.url().slice(0, 120)); });
	p.on('response', (r) => { if (r.status() >= 400 && r.url() !== u && !/tawk/.test(r.url())) issues.push(r.status() + ': ' + r.url().slice(0, 120)); });
	p.on('request', (r) => { if (BASE.startsWith('https') && r.url().startsWith('http://')) issues.push('MIXED: ' + r.url().slice(0, 120)); });
	const res = await p.goto(u, { waitUntil: 'networkidle' }).catch((e) => ({ status: () => 'ERR ' + e.message.slice(0, 60) }));
	const html = await p.content();
	if (html.includes(LOCAL)) issues.push('LOCAL DOMAIN in HTML');
	const broken = await p.$$eval('img', (is) => is.filter((i) => i.complete && i.naturalWidth === 0 && i.loading !== 'lazy').map((i) => i.src));
	broken.forEach((s) => issues.push('BROKEN IMG: ' + s));
	const robots = await p.$eval('meta[name=robots]', (m) => m.content).catch(() => '-');
	const st = res.status();
	const expected = u.includes('/den-yparxei-') ? 404 : 200;
	if (st !== expected) issues.unshift(`STATUS ${st} (expected ${expected})`);
	if (issues.length) bad++;
	console.log(`${issues.length ? '✗' : '✓'} ${st} ${u.replace(BASE, '') || '/'}  [${robots}]`);
	issues.forEach((i) => console.log('    ' + i));
	await p.close();
}
console.log(`\n${urls.length - bad}/${urls.length} clean`);
await b.close();
