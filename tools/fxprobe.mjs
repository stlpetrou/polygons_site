import { chromium } from 'playwright';
const B = 'http://polygons.test';
const b = await chromium.launch();
const errs = [];
const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
p.on('pageerror', (e) => errs.push(p.url() + ' ' + e.message)); p.on('console', (m) => m.type() === 'error' && errs.push(p.url() + ' ' + m.text()));
const reqs = []; p.on('request', (r) => reqs.push(r.url()));
for (const u of ['/', '/ti-kanoume/', '/oi-doulies-mas/', '/oi-doulies-mas/rebranding-kafe-estiatorio/', '/poioi-eimaste/', '/epikoinwnia/']) {
  reqs.length = 0;
  await p.goto(B + u, { waitUntil: 'networkidle' }); await p.waitForTimeout(900);
  const info = await p.evaluate(() => ({
    mesh: !!document.querySelector('.fx-mesh__canvas.is-on'),
    vt: [...document.querySelectorAll('img')].map((i) => i.style.viewTransitionName).filter(Boolean).length,
    tilt: document.querySelectorAll('.fx-tilt-el').length, border: document.querySelectorAll('.fx-border-el').length,
    stack: [...document.querySelectorAll('.fx-stack')].map((s) => s.classList.contains('fx-stack-off') ? 'off' : 'on').join(','),
  }));
  console.log(u.padEnd(36), JSON.stringify(info), 'meshJS:', reqs.some((r) => r.includes('fx-mesh.js')));
}
// stack behaviour
await p.goto(B + '/ti-kanoume/#hosting', { waitUntil: 'networkidle' }); await p.waitForTimeout(800);
console.log('anchor #hosting top:', await p.$eval('#hosting', (e) => Math.round(e.getBoundingClientRect().top)));
await p.goto(B + '/ti-kanoume/', { waitUntil: 'networkidle' });
await p.$eval('.fx-stack', (s) => window.scrollTo(0, s.getBoundingClientRect().top + scrollY + 900)); await p.waitForTimeout(700);
await p.screenshot({ path: 'shots/fx-stack.png' });
console.log('first card scale:', await p.$eval('.fx-stack > .e-con', (c) => getComputedStyle(c).transform));
// header hide
await p.mouse.wheel(0, 600); await p.waitForTimeout(500);
console.log('header hidden on scroll down:', await p.evaluate(() => document.documentElement.classList.contains('fx-header-hidden')));
await p.mouse.wheel(0, -300); await p.waitForTimeout(500);
console.log('header shown on scroll up:', !(await p.evaluate(() => document.documentElement.classList.contains('fx-header-hidden'))));
// filter still works + tilt re-decorates
await p.goto(B + '/oi-doulies-mas/', { waitUntil: 'networkidle' });
await p.click('.pg-filter label:has-text("Branding")'); await p.waitForTimeout(1500);
console.log('filter Branding:', await p.$$eval('#erga .jet-listing-grid__item', (e) => e.length), 'tilt after ajax:', await p.$$eval('#erga .fx-tilt-el', (e) => e.length));
// mobile
const m = await b.newPage({ viewport: { width: 390, height: 844 }, isMobile: true, hasTouch: true });
m.on('pageerror', (e) => errs.push('mobile ' + e.message));
await m.goto(B + '/ti-kanoume/', { waitUntil: 'networkidle' });
console.log('mobile stack:', await m.$eval('.fx-stack > .e-con', (c) => getComputedStyle(c).position), '| tilt on touch:', await m.$$eval('.fx-tilt-el', (e) => e.length));
await m.goto(B + '/', { waitUntil: 'networkidle' }); await m.waitForTimeout(1500);
console.log('mobile mesh:', await m.$$eval('.fx-mesh__canvas', (e) => e.length));
await m.click('.pg-nav .jet-nav__mobile-trigger'); await m.waitForTimeout(500);
console.log('mobile menu:', await m.$eval('.pg-nav .jet-nav-wrap', (e) => e.classList.contains('jet-mobile-menu-active')));
console.log('JS errors:', errs.length ? errs : 'none');
await b.close();
