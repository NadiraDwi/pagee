@extends('user.layouts')

@section('title', 'Long Post')

@section('content')

<div class="card shadow-sm mb-3">
  <div class="card-body">

    <h5 class="mb-3">Tulis Long Post</h5>

    <form action="{{ route('posts.store.long') }}" method="POST" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="jenis_post" value="long">

      {{-- JUDUL --}}
      <div class="mb-3">
          <input type="text" name="judul" class="form-control" placeholder="Judul Post" required>
      </div>

      {{-- ISI --}}
      <div class="mb-3">
          <textarea class="form-control" name="isi" rows="10" placeholder="Deskripsi Post" required></textarea>
      </div>

      {{-- COVER --}}
      <div class="mb-3">
          <label class="form-label fw-semibold">Cover Post (opsional)</label>
          <input type="file" name="cover" id="coverInput" class="form-control" accept="image/*">

          <div class="mt-3">
              <img id="coverPreview" src="#" alt="Preview Cover"
                   style="display:none; max-width: 200px; border-radius: 8px; border: 1px solid #ddd;">
          </div>
      </div>

      <!-- ADD PEOPLE (chip styling) -->
      <div class="mb-3">
      <button type="button" id="addPeopleBtn" class="btn btn-outline-purple">
          <i class="fa-solid fa-user-plus me-1"></i> Add People
      </button>
      
      <!-- Input hidden untuk menyimpan ID user yang dipilih -->
      <input type="hidden" name="mentions" id="mentionsInput">
      </div>

      <div class="text-end">
          <button type="submit" class="btn btn-purple">Posting</button>
      </div>

    </form>
  </div>
</div>

  <!-- MODAL PILIH USER -->
<div class="modal fade" id="userModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Pilih User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="text" id="searchUser" class="form-control mb-2" placeholder="Cari user...">

        <ul class="list-group" id="userModalList">
          @foreach($users as $u)
              @if($u->id_user != auth()->user()->id_user && $u->role != 'admin')
                  <li class="list-group-item list-group-item-action modal-user"
                      data-id="{{ $u->id_user }}">
                    {{ $u->nama }} — <small>{{ $u->email }}</small>
                  </li>
              @endif
          @endforeach

        </ul>
      </div>
    </div>
  </div>
</div>

@endsection


@section('rightbar')

<div class="card shadow-sm mb-3">
  <div class="card-body">
    <h5 class="fw-bold text-purple">
      <i class="fa-solid fa-music me-2"></i>Musik Populer
    </h5>
    <ul class="list-unstyled small mt-2">
      <li>Daylight - David Kushner</li>
      <li>Blue - Keshi</li>
      <li>Runaway - AURORA</li>
    </ul>
  </div>
</div>

<div class="card shadow-sm">
  <div class="card-body">
    <h5 class="fw-bold text-purple">
      <i class="fa-solid fa-fire me-2"></i>Tren Whisper
    </h5>
    <ul class="list-unstyled small mt-2">
      @foreach($trends as $trend)
        <li>{{ $trend }}</li>
      @endforeach
    </ul>
  </div>
</div>

@endsection


@push('scripts')
<script>
document.getElementById('coverInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('coverPreview');

    if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block';
        }

        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        preview.src = "#";
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('assets/script.js') }}"></script>

<script>
let mentionsInput = document.getElementById('mentionsInput');
let selectedIds = []; 
let selectedUsersDiv = null;

// Buat container chip jika belum ada
function ensureSelectedUserContainer() {
    selectedUsersDiv = document.getElementById('selectedUsers');
    if (!selectedUsersDiv) {
        selectedUsersDiv = document.createElement("div");
        selectedUsersDiv.id = "selectedUsers";
        selectedUsersDiv.className = "mt-2 d-flex flex-wrap gap-2";
        document.getElementById("addPeopleBtn").insertAdjacentElement("afterend", selectedUsersDiv);
    }
}
ensureSelectedUserContainer();

// === OPEN MODAL ===
document.getElementById('addPeopleBtn').addEventListener('click', function () {
    let modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('userModal'));
    modal.show();
});

// === PILIH USER DARI MODAL ===
document.querySelectorAll('.modal-user').forEach(item => {
    item.addEventListener('click', function () {
        let id = this.dataset.id;
        let name = this.textContent.trim();

        // Cegah duplikasi
        if (!selectedIds.includes(id)) {
            selectedIds.push(id);
            addUserChip(id, name);
        }

        mentionsInput.value = JSON.stringify(selectedIds);

        // Tutup modal
        bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
    });
});

// === CHIP USER ===
function addUserChip(id, name) {
    let chip = document.createElement('div');

    chip.classList.add('px-3', 'py-2');
    chip.style.backgroundColor = "#6f42c1"; // UNGU SAMA SEPERTI TOMBOL SUBMIT
    chip.style.color = "white";
    chip.style.borderRadius = "20px";
    chip.style.display = "flex";
    chip.style.alignItems = "center";
    chip.style.gap = "6px";

    chip.innerHTML = `
        <span>${name}</span>
        <button class="btn btn-sm btn-light p-0 px-2" 
                style="border-radius:50%; font-weight:bold;" 
                data-remove="${id}">
            X
        </button>
    `;

    selectedUsersDiv.appendChild(chip);

    // Tombol hapus
    chip.querySelector("[data-remove]").addEventListener("click", function () {
        let removeId = this.dataset.remove;

        // Remove from array
        selectedIds = selectedIds.filter(uid => uid != removeId);

        // Update input hidden
        mentionsInput.value = JSON.stringify(selectedIds);

        // Remove chip
        chip.remove();
    });
}

// === SEARCH USER DI MODAL ===
document.getElementById('searchUser').addEventListener('keyup', function () {
    let keyword = this.value.toLowerCase();
    let items = document.querySelectorAll('#userModalList .modal-user');

    items.forEach(item => {
        let name = item.textContent.toLowerCase();
        item.classList.toggle('d-none', !name.includes(keyword));
    });
});
</script>
@endpush
