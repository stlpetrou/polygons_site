// English version check: forms (contact, quote steps, audit), work filter, dropdown, language switch, mobile header. node entest.mjs
import { chromium } from 'playwright';
const BASE = process.env.BASE || 'http://polygons.test';
const b = await chromium.launch();
const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
const errors = []; p.on('pageerror', (e) => errors.push(e.message));
await p.goto(BASE + '/en/contact/', { waitUntil: 'networkidle' });
await p.fill('input[name="name"]', 'Test Visitor EN');
await p.fill('input[name="email"]', 'visitor-en@example.com');
await p.fill('textarea[name="message"]', 'Hello from the English contact form test.');
await p.click('.jet-form-builder__submit');
await p.waitForSelector('.jet-form-builder-messages-wrap div', { timeout: 15000 });
console.log('EN form result:', (await p.textContent('.jet-form-builder-messages-wrap')).trim());

// Quote (steps)
await p.goto(BASE + '/en/get-a-quote/', { waitUntil: 'networkidle' });
await p.click('label:has(input[name="services[]"][value="website"])');
await p.click('.jet-form-builder__next-page >> visible=true'); await p.waitForTimeout(300);
await p.click('label:has(input[name=budget][value="1200-3000"])'); await p.click('label:has(input[name=timeline][value="flexible"])');
await p.click('.jet-form-builder__next-page >> visible=true'); await p.waitForTimeout(300);
await p.fill('[name=name]', 'Quote Visitor EN'); await p.fill('[name=email]', 'quote-en@example.com');
await p.click('.jet-form-builder__action-button >> visible=true'); await p.waitForTimeout(2500);
console.log('EN quote result:', (await p.textContent('.jet-form-builder-messages-wrap')).trim());
// Audit on home
await p.goto(BASE + '/en/', { waitUntil: 'networkidle' });
const au = p.locator('.pg-audit form');
await au.locator('[name=site_url]').fill('https://example.org'); await au.locator('[name=email]').fill('audit-en@example.com');
await au.locator('.jet-form-builder__action-button').click(); await p.waitForTimeout(2500);
console.log('EN audit result:', (await au.locator('.jet-form-builder-messages-wrap').textContent()).trim());
// Work filter (AJAX must stay English)
await p.goto(BASE + '/en/work/', { waitUntil: 'networkidle' });
const titles = () => p.$$eval('#work .pg-project__title', (e) => e.map((x) => x.textContent.trim()));
console.log('work (all):', (await titles()).length, 'items | first:', (await titles())[0]);
await p.click('.pg-filter label:has-text("Branding")'); await p.waitForTimeout(1500);
console.log('work (Branding):', await titles(), '| "All" label:', (await p.textContent('.pg-filter .jet-radio-list__item:first-child')).trim());
// Dropdown
await p.hover('.pg-header .menu-item-has-children > a'); await p.waitForTimeout(400);
console.log('dropdown:', await p.$$eval('.pg-header .jet-nav__sub a', (a) => a.map((x) => x.textContent.trim())));
const sw = async (pg, path) => { await pg.goto(BASE + path, { waitUntil: 'domcontentloaded' }); const a = pg.locator('.pg-lang a').first(); return `${path} → [${(await a.textContent()).trim()}] ${await a.getAttribute('href')}`; };
for (const path of ['/', '/ti-kanoume/', '/ti-kanoume/seo/', '/en/services/brand-identity/', '/blog/', '/poso-grigoro-prepei-na-einai-ena-site/', '/oi-doulies-mas/', '/prosfora/']) console.log('switch', await sw(p, path));
const m = await b.newPage({ viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true });
await m.goto(BASE + '/en/', { waitUntil: 'networkidle' });
console.log('mobile lang switch visible:', await m.isVisible('.pg-lang a'), '| burger visible:', await m.isVisible('.pg-header .jet-nav__mobile-trigger'));
await m.screenshot({ path: new URL('./shots/en-mobile-header.png', import.meta.url).pathname, clip: { x: 0, y: 0, width: 390, height: 120 } });
console.log('JS errors:', errors);
await b.close();
