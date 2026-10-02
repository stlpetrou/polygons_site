# polygons.gr — site code

Only our code lives here: child theme `polygons`, mu-plugin `polygons-performance.php`, the build scripts (`build/`), QA tools (`tools/`) and project notes (`_projectKnowledge/`).
WordPress core, plugins, uploads, the database and `wp-config.php` are **not** in git.

* Local: LocalWP site "Polygons" → http://polygons.test
* Staging: https://staging.polygons.gr — auto-deploys from `main` (Plesk Git → copies theme + mu-plugin into `wp-content/`)
* Content lives in the database; after launch the live DB is the source of truth.
* QA after every deploy: `cd tools && npm i && BASE=https://staging.polygons.gr node smoke.mjs`
