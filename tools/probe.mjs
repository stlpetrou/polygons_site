import { chromium } from 'playwright';
const B = 'http://polygons.test';
const b = await chromium.launch();
const errs = [];
const page = async (vp) => { const p = await b.newPage({ viewport: vp }); p.on('pageerror', (e) => errs.push(p.url() + ' ' + e.message)); p.on('console', (m) => m.type() === 'error' && errs.push(p.url() + ' ' + m.text())); return p; };
let p = await page({ width: 1440, height: 900 });
for (const u of ['/', '/ti-kanoume/', '/oi-doulies-mas/', '/oi-doulies-mas/rebranding-kafe-estiatorio/', '/poioi-eimaste/', '/epikoinwnia/']) await p.goto(B + u, { waitUntil: 'networkidle' });
// Filter
await p.goto(B + '/oi-doulies-mas/', { waitUntil: 'networkidle' });
await p.click('.pg-filter label:has-text("SEO")'); await p.waitForTimeout(1500);
console.log('filter SEO →', await p.$$eval('#erga .jet-listing-grid__item', (e) => e.length), 'items');
// FAQ + tabs
await p.goto(B + '/ti-kanoume/', { waitUntil: 'networkidle' });
await p.click('.pg-faq__list summary >> nth=1'); await p.waitForTimeout(400);
console.log('faq open items:', await p.$$eval('.pg-faq__list details[open]', (e) => e.length));
await p.click('.pg-tabs .e-n-tab-title >> nth=1'); await p.waitForTimeout(400);
console.log('hosting tab visible packs:', await p.$$eval('.pg-tabs .e-n-tabs-content > .e-con', (cs) => cs.map((c) => getComputedStyle(c).display !== 'none' ? c.querySelectorAll('.jet-listing-grid__item').length : 0)));
console.log('faq schema:', (await p.content()).includes('"FAQPage"'));
// Form
await p.goto(B + '/epikoinwnia/', { waitUntil: 'networkidle' });
await p.fill('[name=name]', 'Playwright Test'); await p.fill('[name=email]', 'pw@example.test'); await p.selectOption('[name=service]', 'hosting'); await p.fill('[name=message]', 'Αυτοματοποιημένος έλεγχος φόρμας.');
await p.click('.jet-form-builder__action-button'); await p.waitForTimeout(2500);
console.log('form:', (await p.textContent('.jet-form-builder-messages-wrap').catch(() => '')).trim());
// Mobile menu
const m = await page({ width: 390, height: 844 });
await m.goto(B + '/', { waitUntil: 'networkidle' });
await m.click('.pg-nav .jet-nav__mobile-trigger'); await m.waitForTimeout(600);
console.log('mobile menu open:', await m.$eval('.pg-nav .jet-nav-wrap', (e) => e.classList.contains('jet-mobile-menu-active')));
console.log('JS errors:', errs.length ? errs : 'none');
await b.close();
