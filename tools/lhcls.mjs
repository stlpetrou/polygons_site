// Lighthouse CLS forensics: node lhcls.mjs <path> — LayoutShift events from the LH trace (old→new rects),
// the culprit node, and the filmstrip (shots/film-N.jpg). Use when Lighthouse reports CLS you can't see.
import lighthouse from 'lighthouse';
import * as chromeLauncher from 'chrome-launcher';
import { chromium } from 'playwright';
import { writeFileSync, mkdirSync } from 'node:fs';
const BASE = process.env.BASE || 'http://polygons.test';
const path = process.argv[2] || '/';
const out = new URL('./shots/', import.meta.url).pathname; mkdirSync(out, { recursive: true });
const chrome = await chromeLauncher.launch({ chromePath: chromium.executablePath(), chromeFlags: ['--headless=new', '--no-sandbox'] });
const r = await lighthouse(BASE + path, { port: chrome.port, output: 'json', logLevel: 'error', onlyCategories: ['performance'] });
console.log(path, 'CLS', r.lhr.audits['cumulative-layout-shift'].displayValue);
for (const it of r.lhr.audits['layout-shifts'].details?.items || []) console.log('  culprit', it.score.toFixed(4), it.node?.selector, '|', (it.node?.nodeLabel || '').slice(0, 60).replace(/\n/g, ' '));
const tr = r.artifacts.Trace || r.artifacts.traces?.defaultPass;
const t0 = tr.traceEvents.find((e) => e.name === 'navigationStart')?.ts;
for (const e of tr.traceEvents.filter((x) => x.name === 'LayoutShift')) {
	const d = e.args.data; console.log(`  @${Math.round((e.ts - t0) / 1000)}ms score=${d.score.toFixed(4)}`);
	(d.impacted_nodes || []).forEach((n) => console.log('     node', n.node_id, 'old', n.old_rect, '→ new', n.new_rect));
}
r.lhr.audits['screenshot-thumbnails'].details.items.forEach((it, i) => writeFileSync(`${out}film-${i}.jpg`, Buffer.from(it.data.split(',')[1], 'base64')));
console.log('  filmstrip → shots/film-0..N.jpg');
await chrome.kill();
