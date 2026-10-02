import { chromium } from 'playwright';
const B = 'http://polygons.test'; const b = await chromium.launch(); const errs = [];
const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
p.on('pageerror', (e) => errs.push(p.url() + ' ' + e.message)); p.on('console', (m) => m.type() === 'error' && !m.text().includes('tawk') && errs.push(p.url() + ' ' + m.text()));
// Multi-step quote
await p.goto(B + '/prosfora/', { waitUntil: 'networkidle' });
await p.screenshot({ path: 'shots/p3-quote-1.png', fullPage: true });
const visible = async () => p.$$eval('.jet-form-builder-page', (ps) => ps.map((x, i) => getComputedStyle(x).display !== 'none' ? i : null).filter((x) => x !== null));
console.log('steps visible at start:', await visible(), '| progress items:', await p.$$eval('.jet-form-builder-progress-pages__item', (e) => e.length));
await p.click('.jet-form-builder__next-page >> visible=true'); await p.waitForTimeout(300);
console.log('next without choice → still step', await visible());
await p.click('label:has(input[name="services[]"][value="website"])'); await p.click('label:has(input[name="services[]"][value="seo"])');
console.log('checked:', await p.$$eval('input[name="services[]"]:checked', (e) => e.map((x) => x.value).join(',')));
await p.fill('[name=current_site]', 'https://example.com');
await p.click('.jet-form-builder__next-page >> visible=true'); await p.waitForTimeout(300);
console.log('after step 1 →', await visible());
await p.click('label:has(input[name=budget][value="1200-3000"])'); await p.click('label:has(input[name=timeline][value="1-3-months"])');
await p.screenshot({ path: 'shots/p3-quote-2.png' });
await p.click('.jet-form-builder__next-page >> visible=true'); await p.waitForTimeout(300);
console.log('after step 2 →', await visible());
await p.fill('[name=name]', 'Playwright Πελάτης'); await p.fill('[name=email]', 'client@example.test'); await p.fill('[name=message]', 'Test αιτήματος προσφοράς.');
await p.click('.jet-form-builder__action-button >> visible=true'); await p.waitForTimeout(2500);
console.log('quote result:', (await p.textContent('.jet-form-builder-messages-wrap')).trim());
// Audit form on home
await p.goto(B + '/', { waitUntil: 'networkidle' });
const au = p.locator('.pg-audit form');
await au.locator('[name=site_url]').fill('https://example.org'); await au.locator('[name=email]').fill('audit@example.test');
await au.locator('.jet-form-builder__action-button').click(); await p.waitForTimeout(2500);
console.log('audit result:', (await au.locator('.jet-form-builder-messages-wrap').textContent()).trim());
await p.$eval('.pg-audit', (e) => e.scrollIntoView()); await p.waitForTimeout(500); await p.screenshot({ path: 'shots/p3-audit.png' });
// Chat: nothing from tawk before click
const tawkReq = []; p.on('request', (r) => r.url().includes('tawk') && tawkReq.push(r.url()));
await p.goto(B + '/', { waitUntil: 'networkidle' }); await p.waitForTimeout(1000);
console.log('tawk requests before click:', tawkReq.length);
await p.click('.pg-chat'); await p.waitForTimeout(6000);
console.log('tawk requests after click:', tawkReq.length, '| our button hidden:', await p.$eval('.pg-chat', (e) => e.classList.contains('is-hidden')), '| tawk iframe:', await p.$$eval('iframe', (f) => f.filter((x) => (x.title || '').toLowerCase().includes('chat') || (x.src || '').includes('tawk')).length));
console.log('JS errors:', errs.length ? errs : 'none');
await b.close();
