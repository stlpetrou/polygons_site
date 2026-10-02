// Lighthouse (mobile preset): node lh.mjs [path ...]
import lighthouse from 'lighthouse';
import * as chromeLauncher from 'chrome-launcher';
import { chromium } from 'playwright';

const BASE = process.env.BASE || 'http://polygons.test';
const paths = process.argv.slice(2).length ? process.argv.slice(2) : ['/', '/ti-kanoume/', '/oi-doulies-mas/', '/poioi-eimaste/', '/epikoinwnia/'];

const chrome = await chromeLauncher.launch({ chromePath: chromium.executablePath(), chromeFlags: ['--headless=new', '--no-sandbox'] });
const pct = (v) => Math.round(v * 100);
for (const p of paths) {
	const { lhr } = await lighthouse(BASE + p, { port: chrome.port, output: 'json', logLevel: 'error', onlyCategories: ['performance', 'accessibility', 'best-practices', 'seo'] });
	const a = lhr.audits;
	console.log(
		`${p.padEnd(18)} perf ${pct(lhr.categories.performance.score)}  a11y ${pct(lhr.categories.accessibility.score)}  bp ${pct(lhr.categories['best-practices'].score)}  seo ${pct(lhr.categories.seo.score)}` +
		`  | FCP ${a['first-contentful-paint'].displayValue}  LCP ${a['largest-contentful-paint'].displayValue}  TBT ${a['total-blocking-time'].displayValue}  CLS ${a['cumulative-layout-shift'].displayValue}  weight ${Math.round(a['total-byte-weight'].numericValue / 1024)}KB`
	);
	if (process.env.VERBOSE) {
		for (const [id, au] of Object.entries(a)) {
			if (au.score !== null && au.score < 0.9 && au.scoreDisplayMode !== 'informative' && au.scoreDisplayMode !== 'notApplicable') console.log(`    - ${id}: ${au.title} ${au.displayValue || ''}`);
		}
	}
}
await chrome.kill();
