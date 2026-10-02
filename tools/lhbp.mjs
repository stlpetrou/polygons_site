import lighthouse from 'lighthouse';
import * as chromeLauncher from 'chrome-launcher';
import { chromium } from 'playwright';
const chrome = await chromeLauncher.launch({ chromePath: chromium.executablePath(), chromeFlags: ['--headless=new', '--no-sandbox'] });
const { lhr } = await lighthouse('http://polygons.test/', { port: chrome.port, output: 'json', logLevel: 'error', onlyCategories: ['best-practices', 'seo'] });
for (const cat of ['best-practices', 'seo']) for (const r of lhr.categories[cat].auditRefs) { const a = lhr.audits[r.id]; if (a.score !== null && a.score < 1 && r.weight > 0) console.log(cat, r.id, '-', a.title, (a.details?.items || []).slice(0, 2).map((i) => JSON.stringify(i).slice(0, 160)).join(' | ')); }
await chrome.kill();
