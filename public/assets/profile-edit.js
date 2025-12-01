/* profile-edit.js
   - previews for header & foto
   - debounced username availability (POST)
   - skeleton hide after load
   - theme toggle (pastel dark default)
   - show/hide password
   - ripple effect on save
   - accessible keyboard triggers
*/

const $ = sel => document.querySelector(sel);
const $$ = sel => Array.from(document.querySelectorAll(sel));

/* ---------- Preview image handlers ---------- */
const headerUpload = $('#headerUpload');
const fotoUpload = $('#fotoUpload');
const headerPreview = $('#headerPreview');
const fotoPreview = $('#fotoPreview');

if (headerUpload) {
  headerUpload.addEventListener('change', e => {
    const f = e.target.files && e.target.files[0];
    if (!f) return;
    headerPreview.src = URL.createObjectURL(f);
    headerPreview.onload = () => URL.revokeObjectURL(headerPreview.src);
  });
}
if (fotoUpload) {
  fotoUpload.addEventListener('change', e => {
    const f = e.target.files && e.target.files[0];
    if (!f) return;
    fotoPreview.src = URL.createObjectURL(f);
    fotoPreview.onload = () => URL.revokeObjectURL(fotoPreview.src);
    // subtle scale animation
    fotoPreview.style.transform = 'scale(0.98)';
    setTimeout(()=> fotoPreview.style.transform = '', 220);
  });
}

/* ---------- Debounced username check (POST) ---------- */
const usernameInput = $('#usernameInput');
const usernameStatus = $('#usernameStatus');
const usernameSpinner = $('#usernameSpinner');

const debounce = (fn, wait=500) => {
  let t;
  return (...args) => { clearTimeout(t); t = setTimeout(()=> fn(...args), wait); };
};

const checkUsername = async (value) => {
  if (!value || value.trim().length < 3) {
    usernameStatus.textContent = '';
    usernameStatus.className = 'text-muted small';
    usernameSpinner?.classList.add('visually-hidden');
    return;
  }
  usernameSpinner?.classList.remove('visually-hidden');
  try {
    const res = await fetch(usernameCheckUrl, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
      body: JSON.stringify({ username: value })
    });
    const data = await res.json();
    usernameSpinner?.classList.add('visually-hidden');
    if (data.available || data.available === true) {
      usernameStatus.textContent = 'Username tersedia';
      usernameStatus.className = 'username-available small';
    } else {
      usernameStatus.textContent = 'Username sudah dipakai';
      usernameStatus.className = 'username-taken small';
    }
  } catch (err) {
    console.error(err);
    usernameSpinner?.classList.add('visually-hidden');
    usernameStatus.textContent = 'Gagal memeriksa';
    usernameStatus.className = 'text-muted small';
  }
};

if (usernameInput) usernameInput.addEventListener('input', debounce(e => checkUsername(e.target.value), 600));

/* ---------- Skeleton hide on load ---------- */
window.addEventListener('load', () => {
  const skeleton = document.getElementById('skeleton');
  if (!skeleton) return;
  setTimeout(() => {
    skeleton.style.transition = 'opacity .45s ease, transform .45s ease';
    skeleton.style.opacity = 0;
    skeleton.style.transform = 'translateY(-8px)';
    setTimeout(()=> skeleton.remove(), 520);
  }, 380);
});

/* ---------- Theme toggle (pastel-dark default) ---------- */
const modeToggle = $('#modeToggle');
const modeIcon = $('#modeIcon');
const body = document.body;

const applyTheme = (t) => {
  if (t === 'light') {
    body.classList.remove('pastel-dark');
    body.classList.add('light-mode');
    modeIcon.className = 'fa-solid fa-moon';
  } else {
    body.classList.remove('light-mode');
    body.classList.add('pastel-dark');
    modeIcon.className = 'fa-solid fa-sun';
  }
  localStorage.setItem('pref-theme', t);
};

const saved = localStorage.getItem('pref-theme') || 'dark';
applyTheme(saved === 'light' ? 'light' : 'dark');

modeToggle?.addEventListener('click', () => {
  const now = body.classList.contains('pastel-dark') ? 'dark' : 'light';
  applyTheme(now === 'dark' ? 'light' : 'dark');
});

/* ---------- Show / Hide password ---------- */
const togglePassword = $('#togglePassword');
const passwordField = $('#passwordField');
togglePassword?.addEventListener('click', () => {
  if (!passwordField) return;
  const isPass = passwordField.type === 'password';
  passwordField.type = isPass ? 'text' : 'password';
  togglePassword.innerHTML = isPass ? '<i class="fa-solid fa-eye-slash"></i>' : '<i class="fa-solid fa-eye"></i>';
});

/* ---------- Ripple on save button & submit ---------- */
const saveBtn = $('#saveBtn');
if (saveBtn) {
  saveBtn.addEventListener('click', (ev) => {
    const rect = saveBtn.getBoundingClientRect();
    const circle = document.createElement('span');
    circle.className = 'ripple';
    const size = Math.max(rect.width, rect.height) * 1.6;
    circle.style.width = circle.style.height = size + 'px';
    circle.style.left = (ev.clientX - rect.left - size/2) + 'px';
    circle.style.top = (ev.clientY - rect.top - size/2) + 'px';
    saveBtn.appendChild(circle);
    setTimeout(()=> circle.remove(), 700);
    // Submit the form linked by form attribute
    const form = document.getElementById(saveBtn.getAttribute('form'));
    if (form) form.submit();
  });
}

/* ---------- keyboard accessibility for cover & photo wrappers ---------- */
$$('.cover-wrapper, .profile-photo').forEach(elem => {
  elem.addEventListener('keypress', e => {
    if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); elem.click(); }
  });
});

document.addEventListener("DOMContentLoaded", () => {
    const body = document.body;
    const toggleBtn = document.getElementById("modeToggle");
    const icon = document.getElementById("modeIcon");

    // Ambil theme dari localStorage
    const saved = localStorage.getItem("theme");

    if (saved === "dark") {
        body.classList.add("dark-mode");
        icon.classList.replace("fa-sun", "fa-moon");
    } else {
        body.classList.remove("dark-mode");
        icon.classList.replace("fa-moon", "fa-sun");
    }

    toggleBtn.addEventListener("click", () => {
        body.classList.toggle("dark-mode");

        if (body.classList.contains("dark-mode")) {
            icon.classList.replace("fa-sun", "fa-moon");
            localStorage.setItem("theme", "dark");
        } else {
            icon.classList.replace("fa-moon", "fa-sun");
            localStorage.setItem("theme", "light");
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
  const toast = document.getElementById('toast-success');
  if(toast) {
    toast.classList.add('show'); // munculkan
    setTimeout(() => {
      toast.classList.remove('show');
      toast.classList.add('hide');
      setTimeout(() => toast.remove(), 400); // hapus dari DOM setelah animasi
    }, 3000); // 3 detik
  }
});
