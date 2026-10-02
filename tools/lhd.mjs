import lighthouse from 'lighthouse';
import * as chromeLauncher from 'chrome-launcher';
import { chromium } from 'playwright';
const url = 'http://polygons.test' + (process.argv[2] || '/');
const chrome = await chromeLauncher.launch({ chromePath: chromium.executablePath(), chromeFlags: ['--headless=new', '--no-sandbox'] });
const { lhr } = await lighthouse(url, { port: chrome.port, output: 'json', logLevel: 'error' });
const a = lhr.audits;
const lcp = a['largest-contentful-paint-element'] || a['lcp-breakdown-insight'];
console.log('LCP element:', JSON.stringify(lcp?.details?.items?.[0]?.items?.[0]?.node?.snippet || lcp?.details?.items?.[0]?.node?.snippet || '').slice(0, 300));
console.log('LCP phases:', JSON.stringify((a['lcp-breakdown-insight']?.details?.items?.[0]?.items || []).map((i) => [i.subpart || i.label, Math.round(i.duration)])));
console.log('render-blocking:', JSON.stringify((a['render-blocking-insight']?.details?.items || []).map((i) => [i.url?.replace('http://polygons.test', '').split('?')[0], Math.round(i.wastedMs || i.totalBytes / 1024)])));
for (const id of Object.keys(lhr.categories.accessibility.auditRefs.reduce((o, r) => (o[r.id] = 1, o), {}))) {
	const au = a[id]; if (au && au.score === 0) console.log('a11y FAIL:', id, '→', (au.details?.items || []).slice(0, 3).map((i) => i.node?.snippet?.slice(0, 140)).join(' | '));
}
await chrome.kill();
