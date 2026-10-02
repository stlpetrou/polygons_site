// Post-deploy functional test: BASE=https://staging.example.com TO=info@example.com node deploytest.mjs
// GR contact form + EN quote (sends REAL mail: visitor email = TO, so admin notice and confirmation both land in our inbox),
// AJAX filter language, language switcher, mobile header, Tawk chat.
import { chromium } from 'playwright';
const BASE = process.env.BASE || 'http://polygons.test'; const TO = process.env.TO || 'visitor@example.com';
const stamp = new Date().toISOString().slice(0, 16);
const b = await chromium.launch();
const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
const errors = []; p.on('pageerror', (e) => errors.push(e.message));
await p.goto(BASE + '/epikoinwnia/', { waitUntil: 'networkidle' });
await p.fill('input[name="name"]', 'ΔΟΚΙΜΗ deploy ' + stamp); await p.fill('input[name="email"]', TO);
await p.fill('textarea[name="message"]', 'Αυτόματη δοκιμή φόρμας μετά το deploy στο ' + BASE + '. Αγνοήστε.');
await p.click('.jet-form-builder__submit'); await p.waitForSelector('.jet-form-builder-messages-wrap div', { timeout: 20000 });
console.log('GR contact:', (await p.textContent('.jet-form-builder-messages-wrap')).trim());
await p.goto(BASE + '/en/get-a-quote/', { waitUntil: 'networkidle' });
await p.click('label:has(input[name="services[]"][value="website"])');
await p.click('.jet-form-builder__next-page >> visible=true'); await p.waitForTimeout(300);
await p.click('label:has(input[name=budget][value="1200-3000"])'); await p.click('label:has(input[name=timeline][value="flexible"])');
await p.click('.jet-form-builder__next-page >> visible=true'); await p.waitForTimeout(300);
await p.fill('[name=name]', 'TEST deploy ' + stamp); await p.fill('[name=email]', TO);
await p.click('.jet-form-builder__action-button >> visible=true'); await p.waitForTimeout(4000);
console.log('EN quote:', (await p.textContent('.jet-form-builder-messages-wrap')).trim());
for (const [path, label, lang] of [['/oi-doulies-mas/', 'Branding', 'el'], ['/en/work/', 'Branding', 'en']]) {
	await p.goto(BASE + path, { waitUntil: 'networkidle' });
	const titles = () => p.$$eval('.pg-project__title', (e) => e.map((x) => x.textContent.trim()));
	const all = (await titles()).length;
	await p.click(`.pg-filter label:has-text("${label}")`); await p.waitForTimeout(2500);
	console.log(`filter ${lang}: all=${all} → ${label}:`, await titles());
}
for (const path of ['/', '/ti-kanoume/seo/', '/en/services/brand-identity/', '/blog/', '/oi-doulies-mas/']) {
	await p.goto(BASE + path, { waitUntil: 'domcontentloaded' }); const a = p.locator('.pg-lang a').first();
	console.log('switch', path, '→', await a.getAttribute('href'));
}
const m = await b.newPage({ viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true });
await m.goto(BASE + '/', { waitUntil: 'networkidle' });
console.log('mobile: lang', await m.isVisible('.pg-lang a'), '| burger', await m.isVisible('.pg-header .jet-nav__mobile-trigger'));
const t = await b.newPage({ viewport: { width: 1440, height: 900 }, userAgent: 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36' });
const tawkErr = []; t.on('response', (r) => r.status() >= 400 && /tawk/.test(r.url()) && tawkErr.push(r.status() + ' ' + r.url().slice(0, 100)));
await t.goto(BASE + '/', { waitUntil: 'networkidle' }); await t.click('.pg-chat'); await t.waitForTimeout(10000);
console.log('Tawk loaded:', await t.evaluate(() => !!(window.Tawk_API && window.Tawk_API.maximize)), '| iframes:', (await t.$$('iframe')).length, '| tawk errors:', tawkErr.length ? tawkErr : 'none');
await t.screenshot({ path: new URL('./shots/deploy-chat.png', import.meta.url).pathname });
console.log('JS errors:', errors.length ? errors : 'none');
await b.close();
