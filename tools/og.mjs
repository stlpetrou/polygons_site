// Social/brand images rendered from HTML with the site's own fonts & logo:
//   node og.mjs  → build/assets/og-default.jpg (1200×630), build/assets/logo-512.png (Google logo, SVG not accepted)
import { chromium } from 'playwright';
import { readFileSync } from 'node:fs';

const theme = new URL('../app/public/wp-content/themes/polygons/assets/', import.meta.url).pathname;
const out = new URL('../build/assets/', import.meta.url).pathname;
const logo = readFileSync(theme + 'img/logo.svg', 'utf8');
const font = (f) => `url(data:font/woff2;base64,${readFileSync(theme + 'fonts/' + f).toString('base64')})`;
const css = `
@font-face{font-family:Inter;font-weight:100 900;src:${font('inter-latin.woff2')};unicode-range:U+0000-00FF,U+2000-206F}
@font-face{font-family:Inter;font-weight:100 900;src:${font('inter-greek.woff2')};unicode-range:U+0370-03FF}
@font-face{font-family:Jura;font-weight:300 700;src:${font('jura-latin.woff2')};unicode-range:U+0000-00FF,U+2000-206F}
*{margin:0;box-sizing:border-box}body{background:#07070a;color:#fff;font-family:Inter}`;

const og = `<style>${css}
.wrap{width:1200px;height:630px;padding:72px 80px;display:flex;flex-direction:column;justify-content:space-between;position:relative;overflow:hidden;
 background:radial-gradient(700px 420px at 88% 20%,#f1515233,transparent 70%),radial-gradient(600px 400px at 0% 100%,#4a5bff22,transparent 70%),#07070a}
.brand{display:flex;align-items:center;gap:20px;font-family:Jura;font-weight:700;font-size:34px;letter-spacing:.28em}
.brand svg{width:56px;height:64px}
h1{font-size:76px;line-height:1.05;letter-spacing:-.02em;font-weight:700;max-width:900px}
h1 span{color:#f15152;text-shadow:0 0 28px #f1515288}
p{font-size:28px;color:#b9bcc8}
.hex{position:absolute;right:-60px;bottom:-80px;width:420px;opacity:.12}
</style><div class="wrap"><div class="brand">${logo}POLYGONS</div>
<h1>Ιστοσελίδες, branding, hosting &amp; SEO. <span>Όλα σε ένα studio.</span></h1>
<p>polygons.gr · Graphic &amp; Web Services</p><div class="hex">${logo}</div></div>`;

const mark = `<style>${css}.m{width:512px;height:512px;display:grid;place-items:center;background:#07070a}.m svg{width:300px;height:348px}</style><div class="m">${logo}</div>`;

const browser = await chromium.launch();
const page = await browser.newPage({ viewport: { width: 1200, height: 630 } });
await page.setContent(og);
await page.evaluate(() => document.fonts.ready);
await page.screenshot({ path: out + 'og-default.jpg', type: 'jpeg', quality: 86 });
await page.setViewportSize({ width: 512, height: 512 });
await page.setContent(mark);
await page.screenshot({ path: out + 'logo-512.png' });
await browser.close();
console.log('ok', out);
