import { chromium } from 'playwright';
const b = await chromium.launch(); const p = await b.newPage({ viewport: { width: 1440, height: 900 } });
await p.goto('http://polygons.test/ti-kanoume/', { waitUntil: 'networkidle' });
console.log(await p.$eval('.fx-stack > .e-con > .e-con', (col) => [...col.children].map((w) => w.className.match(/elementor-widget-[a-z-]+/)?.[0] + ':' + w.offsetHeight + (w.querySelector('.elementor-icon-list-items') ? ' display=' + getComputedStyle(w.querySelector('.elementor-icon-list-items')).display : ''))));
await b.close();
