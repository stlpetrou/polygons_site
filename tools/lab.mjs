import { chromium } from 'playwright';
const b = await chromium.launch();
const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
const errs = []; p.on('pageerror', (e) => errs.push(e.message)); p.on('console', (m) => m.type() === 'error' && errs.push(m.text()));
await p.goto('http://polygons.test/effects-lab/', { waitUntil: 'networkidle' });
await p.waitForTimeout(1800);
await p.mouse.move(520, 380); await p.waitForTimeout(150); await p.mouse.move(560, 420); await p.waitForTimeout(400);
await p.screenshot({ path: 'shots/lab-1-hero.png' });
console.log(JSON.stringify(await p.evaluate(() => ({
  robots: document.querySelector('meta[name=robots]')?.content,
  canvas: !!document.querySelector('.fx-mesh__canvas.is-on'),
  words: document.querySelectorAll('.fx-w').length,
  decode: !!document.querySelector('.fx-decode [aria-hidden]'),
  tilt: document.querySelectorAll('.fx-tilt-el').length,
  border: document.querySelectorAll('.fx-border-el').length,
  fxjs: [...document.scripts].some((s) => s.src.includes('effects.js')),
}))));
const shot = async (sel, name, dy = -120) => { await p.$eval(sel, (el, dy) => window.scrollTo(0, el.getBoundingClientRect().top + scrollY + dy), dy); await p.waitForTimeout(1400); await p.screenshot({ path: `shots/lab-${name}.png` }); };
await shot('.fx-words', '2-words', -300);
await shot('.fx-stack', '3-stack', 200);
await p.mouse.wheel(0, 500); await p.waitForTimeout(800); await p.screenshot({ path: 'shots/lab-3b-stack.png' });
await shot('.fx-progress', '4-progress', -350);
await shot('.fx-hex', '5-projects', -200);
const card = await p.$('.fx-tilt-el'); const bb = await card.boundingBox(); await p.mouse.move(bb.x + bb.width * 0.8, bb.y + bb.height * 0.25); await p.waitForTimeout(300); await p.screenshot({ path: 'shots/lab-5b-tilt.png' });
await shot('.fx-border', '6-border', -150);
const pk = await p.$('.fx-border-el'); const pb = await pk.boundingBox(); await p.mouse.move(pb.x + 30, pb.y + 40); await p.waitForTimeout(300); await p.screenshot({ path: 'shots/lab-6b-border.png' });
await shot('.fx-glow', '7-cta', -200);
const btn = await p.$('.fx-magnetic .elementor-button'); const bt = await btn.boundingBox(); await p.mouse.move(bt.x + bt.width + 40, bt.y - 30); await p.waitForTimeout(300); await p.screenshot({ path: 'shots/lab-7b-cta.png' });
console.log('header hidden after scroll down:', await p.evaluate(() => document.documentElement.classList.contains('fx-header-hidden')));
console.log('JS errors:', errs.length ? errs : 'none');
await b.close();
