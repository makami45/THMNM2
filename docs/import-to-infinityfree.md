Importing your cloud MySQL database into InfinityFree

Overview
- InfinityFree provides its own MySQL databases that you manage through the control panel / phpMyAdmin.
- The usual approach is: export (dump) your current cloud DB -> import the SQL dump into InfinityFree's database -> update your app to use the InfinityFree DB credentials.

Steps

1) Create a destination database on InfinityFree
- Log in to your InfinityFree control panel.
- In "MySQL Databases" create a new database. Note the database name, username and password and the host name (often of the form `sqlXXX.infinityfree.com`).

2) Export your cloud database (several options)
- From a machine with network access to your cloud DB:

  - Using `mysqldump` (recommended for large or exact dumps):

    ```bash
    # using the SSL CA if your cloud DB requires SSL (use your ca.pem path)
    mysqldump --host=mysqlstudent-longnhatyi-9f82.b.aivencloud.com \
      --port=11215 --user=avnadmin --password='YOUR_PASSWORD' \
      --ssl-mode=REQUIRED --ssl-ca=ca.pem \
      --single-transaction --quick --lock-tables=false defaultdb > defaultdb.sql
    ```

  - Using a GUI (MySQL Workbench, DBeaver): connect with SSL and export a dump (or use the Export/Backup facility).

  - Using phpMyAdmin on the cloud side (if available): Export → SQL.

Notes: if your cloud DB requires SSL, include `--ssl-ca=ca.pem` (or configure the GUI with the CA). If you cannot connect from your local machine because of network rules, use the cloud provider's export feature.

3) Prepare the dump (optional)
- If the dump is very large (>50–100MB) you may need to split it or use BigDump (a staggered import PHP script) to avoid phpMyAdmin upload limits.

4) Import into InfinityFree
- Open InfinityFree control panel → MySQL Databases → phpMyAdmin for your new DB.
- Use Import → choose `defaultdb.sql` and upload. If upload size is limited, use BigDump (upload `bigdump.php` + `defaultdb.sql` to your site and run it from the browser), or split the SQL file.

5) Update your app to use InfinityFree DB creds
- In GitHub, replace the DB secrets (or add new ones) with InfinityFree credentials:
  - `DB_HOST` = InfinityFree DB host
  - `DB_PORT` = (usually 3306)
  - `DB_NAME`, `DB_USER`, `DB_PASS`
  - Remove `DB_SSL_CA` (InfinityFree internal DB typically does not require SSL)
- The repo's deploy workflow already writes `api/config.local.php` from these secrets — after the next push the site will use the new DB.

6) Verify
- Visit `https://your-site/api/debug.php` (we added this debug endpoint) to confirm DB connection.
- Then open the frontend and verify data appears.

Troubleshooting
- If phpMyAdmin import fails with timeouts or file size limits:
  - Use BigDump (https://www.ozerov.de/bigdump/), or
  - Split SQL into smaller files and import in sequence.
- If the app still returns 500 after import:
  - Check `api/debug.php` output for the exact error.
  - Ensure `api/config.local.php` contains the InfinityFree credentials and `ssl_ca` is null.

Security notes
- Never commit production DB credentials to the repo. Use GitHub Secrets as you already do. The deploy workflow writes `api/config.local.php` on the server from secrets.

If you want, I can:
- produce the `mysqldump` command you must run (insert your password), or
- help you run a staged import script (BigDump) by adding it to the repo and deploying it temporarily.
