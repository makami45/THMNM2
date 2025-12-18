const apiUrl = 'api/students.php';

async function loadStudents() {
  const res = await fetch(apiUrl);
  const data = await res.json();
  const tbody = document.querySelector('#list tbody');
  tbody.innerHTML = '';
  data.forEach(s => {
    const tr = document.createElement('tr');
    tr.innerHTML = `<td>${s.id}</td><td>${escapeHtml(s.email)}</td><td>${escapeHtml(s.name)}</td><td>
      <button data-id="${s.id}" class="edit">Edit</button>
      <button data-id="${s.id}" class="del">Delete</button>
    </td>`;
    tbody.appendChild(tr);
  });
  document.querySelectorAll('.edit').forEach(b => b.addEventListener('click', onEdit));
  document.querySelectorAll('.del').forEach(b => b.addEventListener('click', onDelete));
}

function escapeHtml(s){ return String(s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

function onEdit(e){
  const id = e.target.dataset.id;
  fetch(apiUrl + '?id=' + id).then(r=>r.json()).then(s=>{
    document.getElementById('student-id').value = s.id;
    document.getElementById('email').value = s.email;
    document.getElementById('name').value = s.name;
  });
}

function onDelete(e){
  const id = e.target.dataset.id;
  if (!confirm('Xóa học sinh id=' + id + '?')) return;
  fetch(apiUrl + '?id=' + id, { method: 'DELETE' }).then(r=>r.json()).then(()=>loadStudents());
}

document.getElementById('save').addEventListener('click', async ()=>{
  const id = document.getElementById('student-id').value;
  const email = document.getElementById('email').value.trim();
  const name = document.getElementById('name').value.trim();
  if (!email || !name) return alert('email and name required');
  if (id) {
    await fetch(apiUrl, { method: 'PUT', headers: {'Content-Type':'application/json'}, body: JSON.stringify({id: parseInt(id), email, name}) });
  } else {
    await fetch(apiUrl, { method: 'POST', headers: {'Content-Type':'application/json'}, body: JSON.stringify({email, name}) });
  }
  clearForm();
  loadStudents();
});

document.getElementById('clear').addEventListener('click', clearForm);

function clearForm(){ document.getElementById('student-id').value=''; document.getElementById('email').value=''; document.getElementById('name').value=''; }

// initial load
loadStudents();
