import { chromium } from 'playwright';
const b = await chromium.launch();
for (const vp of [{ width: 1536, height: 864 }, { width: 1440, height: 900 }, { width: 1366, height: 768 }]) {
  const p = await b.newPage({ viewport: vp });
  await p.goto('http://polygons.test/ti-kanoume/', { waitUntil: 'networkidle' });
  const r = await p.$eval('.fx-stack', (s) => [s.classList.contains('fx-stack-off') ? 'OFF' : 'ON', Math.max(...[...s.children].map((c) => c.offsetHeight))]);
  console.log(vp.width + 'x' + vp.height, r);
  if (vp.height === 900) {
    await p.$eval('.fx-stack', (s) => window.scrollTo(0, s.getBoundingClientRect().top + scrollY + 1100)); await p.waitForTimeout(900);
    await p.screenshot({ path: 'shots/fx-stack.png' });
  }
  await p.close();
}
await b.close();
