import lighthouse from 'lighthouse';
import * as chromeLauncher from 'chrome-launcher';
import { chromium } from 'playwright';
const chrome = await chromeLauncher.launch({ chromePath: chromium.executablePath(), chromeFlags: ['--headless=new', '--no-sandbox'] });
const { lhr } = await lighthouse('http://polygons.test/', { port: chrome.port, output: 'json', logLevel: 'error', onlyCategories: ['performance'] });
for (const id of Object.keys(lhr.audits).filter((k) => /lcp|largest/.test(k))) console.log(id, JSON.stringify(lhr.audits[id].details || {}).slice(0, 700));
await chrome.kill();
