import { chromium } from 'playwright';
const b = await chromium.launch();
for (const w of [1440, 1920]) {
  const p = await b.newPage({ viewport: { width: w, height: 1000 } });
  for (const u of ['/', '/ti-kanoume/', '/oi-doulies-mas/', '/oi-doulies-mas/rebranding-kafe-estiatorio/', '/poioi-eimaste/', '/epikoinwnia/']) {
    await p.goto('http://polygons.test' + u, { waitUntil: 'networkidle' });
    const r = await p.evaluate(() => {
      const inners = [...document.querySelectorAll('.e-con-boxed > .e-con-inner')].map((e) => Math.round(e.getBoundingClientRect().width));
      const hdr = document.querySelector('.pg-header > .e-con-inner'); const ftr = document.querySelector('.pg-footer > .e-con-inner');
      return { inner: [...new Set(inners)].join('/'), header: hdr && Math.round(hdr.getBoundingClientRect().left), footer: ftr && Math.round(ftr.getBoundingClientRect().left), overflow: document.documentElement.scrollWidth > innerWidth, stack: document.querySelector('.fx-stack')?.classList.contains('fx-stack-off') };
    });
    console.log(w, u.padEnd(36), JSON.stringify(r));
  }
  await p.close();
}
await b.close();
