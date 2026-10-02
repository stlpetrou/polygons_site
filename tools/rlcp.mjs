// Observed (real) LCP, 5 runs, mobile + Slow 4G + CPU×4: node rlcp.mjs [path ...]
// Use when Lighthouse's *simulated* LCP jumps between two values on an unchanged page.
import { chromium } from 'playwright';
const BASE = process.env.BASE || 'http://polygons.test';
const b = await chromium.launch();
for (const path of process.argv.slice(2).length ? process.argv.slice(2) : ['/']) {
	const res = [];
	for (let i = 0; i < 5; i++) {
		const p = await b.newPage({ viewport: { width: 412, height: 823 }, isMobile: true, hasTouch: true });
		const cdp = await p.context().newCDPSession(p);
		await cdp.send('Emulation.setCPUThrottlingRate', { rate: 4 });
		await cdp.send('Network.emulateNetworkConditions', { offline: false, latency: 150, downloadThroughput: 1.6e6 / 8, uploadThroughput: 750e3 / 8 });
		await p.addInitScript(() => { window.__l = 0; new PerformanceObserver((l) => { for (const e of l.getEntries()) window.__l = Math.round(e.startTime); }).observe({ type: 'largest-contentful-paint', buffered: true }); });
		await p.goto(BASE + path, { waitUntil: 'networkidle' });
		res.push(await p.evaluate(() => window.__l));
		await p.close();
	}
	console.log(`${path.padEnd(30)} real LCP ms: ${res.join(', ')}  (median ${res.sort((a, b) => a - b)[2]})`);
}
await b.close();
