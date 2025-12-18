# Student Project (PHP + API)

Project to manage students (add / edit / delete) using a PHP backend API and a simple HTML frontend.

Setup
- Copy this project into your web root (already placed at `C:/wamp64/www/student-project`).
- Edit `api/config.php` and fill your database credentials (host, port, database, username, password). If you use the cloud MySQL from your attachment, fill those values.

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

Notes about SSL / cloud DB
- If your cloud MySQL requires SSL, you may need to provide the CA certificate and enable PDO SSL options in `api/db.php`.
- InfinityFree may restrict remote MySQL connections from external hosts; if you host the site on InfinityFree and want to connect to your external cloud DB, ensure that remote connections are allowed and credentials/whitelist are set.
