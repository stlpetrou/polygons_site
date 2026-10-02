// Layout-shift finder: node clsprobe.mjs [path ...] — mobile 412px, CPU ×4 + slow network (close to Lighthouse), lists each shift and its sources.
// Counts shifts flagged hadRecentInput too (Playwright's touch emulation sets it; Lighthouse and real users without input count them).
// Find the cause by A/B: BLOCK=<regex> env aborts matching requests (e.g. BLOCK=woff2 → font-swap shifts disappear).
import { chromium } from 'playwright';
const BASE = process.env.BASE || 'http://polygons.test';
const b = await chromium.launch();
for (const path of process.argv.slice(2)) {
	const p = await b.newPage({ viewport: { width: 412, height: 823 }, isMobile: true, hasTouch: true });
	const cdp = await p.context().newCDPSession(p);
	await cdp.send('Emulation.setCPUThrottlingRate', { rate: 4 });
	await cdp.send('Network.emulateNetworkConditions', { offline: false, latency: 150, downloadThroughput: 1.6e6 / 8, uploadThroughput: 750e3 / 8 });
	if (process.env.BLOCK) await p.route(new RegExp(process.env.BLOCK), (r) => r.abort());
	await p.addInitScript(() => { window.__s = []; new PerformanceObserver((l) => { for (const e of l.getEntries()) window.__s.push({ t: Math.round(e.startTime), v: +e.value.toFixed(4), input: e.hadRecentInput, src: e.sources.map((s) => `${(s.node?.className?.toString?.() || s.node?.nodeName || '?').slice(0, 70)} y ${Math.round(s.previousRect.y)}→${Math.round(s.currentRect.y)} h ${Math.round(s.previousRect.height)}→${Math.round(s.currentRect.height)}`) }); }).observe({ type: 'layout-shift', buffered: true }); });
	await p.goto(BASE + path, { waitUntil: 'networkidle' }); await p.waitForTimeout(1500);
	const s = await p.evaluate(() => window.__s);
	console.log(`${path}  CLS≈${s.reduce((a, x) => a + x.v, 0).toFixed(3)}`);
	s.forEach((x) => console.log(`  @${x.t}ms ${x.v}\n    ` + x.src.join('\n    ')));
	await p.close();
}
await b.close();
