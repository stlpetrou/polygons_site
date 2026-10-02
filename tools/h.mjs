import { chromium } from 'playwright';
const b = await chromium.launch();
for (const vp of [{ width: 1440, height: 900 }, { width: 1280, height: 720 }, { width: 1920, height: 1080 }]) {
  const p = await b.newPage({ viewport: vp });
  await p.goto('http://polygons.test/ti-kanoume/', { waitUntil: 'networkidle' });
  console.log(vp.width + 'x' + vp.height, await p.$$eval('.fx-stack > .e-con', (cs) => cs.map((c) => [c.offsetHeight, ...[...c.querySelectorAll(':scope > .e-con')].map((x) => x.offsetHeight)].join('/'))));
  await p.close();
}
await b.close();
