# Student Project (PHP + API)

Project to manage students (add / edit / delete) using a PHP backend API and a simple HTML frontend.

Setup
- Copy this project into your web root (already placed at `C:/wamp64/www/student-project`).
- Edit `api/config.php` and fill your database credentials (host, port, database, username, password). If you use the cloud MySQL from your attachment, fill those values.
 - Edit `api/config.php` and fill your database credentials (host, port, database, username, password). If you use the cloud MySQL from your attachment, fill those values.

Environment variables (recommended)
- This project now reads DB credentials from environment variables. Create a private `.env` locally (not tracked) or set variables on the server:

	- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_SSL_CA`

- Example: copy `.env.example` to `.env` and fill values for local testing. `.env` is ignored by `.gitignore`.

Local testing
- From project root run:

```bash
php -S localhost:8000 -t C:/wamp64/www/student-project
```
Then open `http://localhost:8000/index.php`.

GitHub → InfinityFree automatic deploy
- This repository includes a GitHub Actions workflow that deploys via FTP on each push to `main`.
- Add the following repository Secrets in GitHub: `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`, `FTP_REMOTE_DIR` (usually `/htdocs` for InfinityFree).
- Push to your GitHub repo `main` branch to trigger automatic deploy.

Setting env vars on InfinityFree
- InfinityFree doesn't provide a dedicated environment variable UI. Two options:
	1) Use an `.htaccess` file in your site root to set variables (note this file will contain secrets):

```
SetEnv DB_HOST mysqlstudent-longnhatyi-9f82.b.aivencloud.com
SetEnv DB_PORT 11215
SetEnv DB_NAME defaultdb
SetEnv DB_USER avnadmin
SetEnv DB_PASS your_password_here
```

	2) Edit `api/config.php` on the server after deployment and set the real password there (do not commit it to git). This is less automated but keeps secrets out of repository history.

Notes about SSL / cloud DB
- If your cloud MySQL requires SSL, you may need to provide the CA certificate and enable PDO SSL options in `api/db.php`.
- InfinityFree may restrict remote MySQL connections from external hosts; if you host the site on InfinityFree and want to connect to your external cloud DB, ensure that remote connections are allowed and credentials/whitelist are set.

Security note
- Never commit real secrets to the repository. Use environment variables, server configuration, or a non-tracked file for passwords and certificates.

---
Deploy trigger
- Last deploy trigger: 2025-12-18 (commit to trigger GitHub Actions deploy)
