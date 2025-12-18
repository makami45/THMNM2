# Student Project (PHP + API)

Project to manage students (add / edit / delete) using a PHP backend API and a simple HTML frontend.

Setup
- Copy this project into your web root (already placed at `C:/wamp64/www/student-project`).
- Edit `api/config.php` and fill your database credentials (host, port, database, username, password). If you use the cloud MySQL from your attachment, fill those values.
 - Edit `api/config.php` and fill your database credentials (host, port, database, username, password). If you use the cloud MySQL from your attachment, fill those values.

Environment variables (recommended)
- This project now reads DB credentials from environment variables. Create a private `.env` locally (not tracked) or set variables on the server:

	- `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASS`, `DB_SSL_CA`

Example: copy `.env.example` to `.env` and fill values for local testing. `.env` is ignored by `.gitignore`.

Local testing
- Start WAMP (Apache + MySQL) and ensure `student_db` exists.
- Open `http://localhost/index.php` (or your local virtual host) to view the app.

Notes
- This repo has been cleaned of CI/CD and cloud integration. The project defaults now target local WAMP development.
