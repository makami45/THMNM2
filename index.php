<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Student Manager</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>
  <main>
    <h1>Quản lý học sinh</h1>

    <section id="form">
      <input id="student-id" type="hidden">
      <label>Email <input id="email" type="email"></label>
      <label>Name <input id="name" type="text"></label>
      <button id="save">Lưu</button>
      <button id="clear">Clear</button>
    </section>

    <section>
      <h2>Danh sách</h2>
      <table id="list">
        <thead><tr><th>ID</th><th>Email</th><th>Name</th><th>Actions</th></tr></thead>
        <tbody></tbody>
      </table>
    </section>
  </main>
  <script src="assets/app.js"></script>
</body>
</html>
