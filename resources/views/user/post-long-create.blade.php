@extends('user.layouts')

@section('title', 'Long Post')

@section('content')

{{-- RIGHT SIDEBAR --}}
@include('user.sidebar')

<div class="card shadow-sm mb-3">
  <div class="card-body">

    <h5 class="mb-3">Tulis Long Post</h5>

    <form id="postForm" action="{{ route('posts.store.long') }}" method="POST" enctype="multipart/form-data" novalidate>
      @csrf
      <input type="hidden" name="jenis_post" value="long">

      {{-- JUDUL --}}
      <div class="mb-3">
          <input type="text" name="judul" id="judul" class="form-control" placeholder="Judul Post" required>
          <div class="invalid-feedback" id="judulError"></div>
      </div>

      {{-- ISI --}}
      <div class="mb-3">
          <textarea name="isi" id="isi" class="form-control" rows="10" placeholder="Deskripsi Post" required></textarea>
          <div class="invalid-feedback" id="isiError"></div>
      </div>

      {{-- COVER --}}
      <div class="mb-3">
          <label class="form-label fw-semibold">Cover Post (opsional)</label>
          <input type="file" name="cover" id="coverInput" class="form-control" accept="image/*">
          <div class="invalid-feedback" id="coverError"></div>

          <div class="mt-3">
              <img id="coverPreview" src="#" alt="Preview Cover"
                   style="display:none; max-width: 200px; border-radius: 8px; border: 1px solid #ddd;">
          </div>
      </div>

      {{-- ADD PEOPLE --}}
      <div class="mb-3">
          <button type="button" id="addPeopleBtn" class="btn btn-outline-purple">
              <i class="fa-solid fa-user-plus me-1"></i> Add People
          </button>
          <input type="hidden" name="mentions" id="mentionsInput">
          <div id="selectedUsers" class="mt-2 d-flex flex-wrap gap-2"></div>
      </div>

      <div class="text-end">
          <button type="submit" class="btn btn-purple">Posting</button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL PILIH USER --}}
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

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', () => {

    // ===== FORM ELEMENTS =====
    const form = document.getElementById('postForm');
    const judul = document.getElementById('judul');
    const isi = document.getElementById('isi');
    const cover = document.getElementById('coverInput');

    const judulError = document.getElementById('judulError');
    const isiError = document.getElementById('isiError');
    const coverError = document.getElementById('coverError');
    const coverPreview = document.getElementById('coverPreview');

    // ===== COVER PREVIEW + VALIDASI =====
    cover.addEventListener('change', function(){
        const file = cover.files[0];
        if(!file){
            coverPreview.style.display = 'none';
            coverPreview.src = "#";
            cover.classList.remove('is-invalid');
            coverError.textContent = '';
            return;
        }

        const allowedTypes = ['image/jpeg','image/jpg','image/png','image/webp'];
        if(!allowedTypes.includes(file.type)){
            cover.classList.add('is-invalid');
            coverError.textContent = 'Hanya JPG, JPEG, PNG, WEBP yang diperbolehkan';
            coverPreview.style.display = 'none';
            cover.value = '';
        } else if(file.size > 2 * 1024 * 1024){
            cover.classList.add('is-invalid');
            coverError.textContent = 'Ukuran maksimal 2MB';
            coverPreview.style.display = 'none';
            cover.value = '';
        } else {
            cover.classList.remove('is-invalid');
            coverError.textContent = '';
            const reader = new FileReader();
            reader.onload = e => {
                coverPreview.src = e.target.result;
                coverPreview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    // ===== MENTIONS =====
    const mentionsInput = document.getElementById('mentionsInput');
    const selectedUsersDiv = document.getElementById('selectedUsers');
    let selectedIds = [];

    const addPeopleBtn = document.getElementById('addPeopleBtn');
    const userModalEl = document.getElementById('userModal');
    const userModal = new bootstrap.Modal(userModalEl);

    addPeopleBtn.addEventListener('click', () => userModal.show());

    document.querySelectorAll('.modal-user').forEach(item => {
        item.addEventListener('click', function(){
            const id = this.dataset.id;
            const name = this.textContent.trim();
            if(!selectedIds.includes(id)){
                selectedIds.push(id);

                // buat chip
                const chip = document.createElement('div');
                chip.classList.add('px-3','py-2');
                chip.style.backgroundColor = "#6f42c1";
                chip.style.color = "white";
                chip.style.borderRadius = "20px";
                chip.style.display = "flex";
                chip.style.alignItems = "center";
                chip.style.gap = "6px";
                chip.innerHTML = `<span>${name}</span><button class="btn btn-sm btn-light p-0 px-2" data-remove="${id}" style="border-radius:50%; font-weight:bold;">X</button>`;
                selectedUsersDiv.appendChild(chip);

                // hapus chip
                chip.querySelector('[data-remove]').addEventListener('click', function(){
                    selectedIds = selectedIds.filter(uid => uid != id);
                    mentionsInput.value = JSON.stringify(selectedIds);
                    chip.remove();
                });
            }

            mentionsInput.value = JSON.stringify(selectedIds);
            userModal.hide();
        });
    });

    // search modal
    document.getElementById('searchUser').addEventListener('keyup', function(){
        const keyword = this.value.toLowerCase();
        document.querySelectorAll('#userModalList .modal-user').forEach(item => {
            item.classList.toggle('d-none', !item.textContent.toLowerCase().includes(keyword));
        });
    });

    // ===== FORM VALIDASI =====
    form.addEventListener('submit', function(e){
        let valid = true;

        // Judul
        if(judul.value.trim() === ''){
            judul.classList.add('is-invalid');
            judulError.textContent = 'Judul wajib diisi';
            valid = false;
        } else if(judul.value.length > 255){
            judul.classList.add('is-invalid');
            judulError.textContent = 'Judul maksimal 255 karakter';
            valid = false;
        } else {
            judul.classList.remove('is-invalid');
            judulError.textContent = '';
        }

        // Isi
        if(isi.value.trim() === ''){
            isi.classList.add('is-invalid');
            isiError.textContent = 'Isi post wajib diisi';
            valid = false;
        } else {
            isi.classList.remove('is-invalid');
            isiError.textContent = '';
        }

        // Cover opsional
        if(cover.files.length > 0){
            const file = cover.files[0];
            const allowedTypes = ['image/jpeg','image/jpg','image/png','image/webp'];
            if(!allowedTypes.includes(file.type)){
                cover.classList.add('is-invalid');
                coverError.textContent = 'Hanya JPG, JPEG, PNG, WEBP yang diperbolehkan';
                valid = false;
            } else if(file.size > 2*1024*1024){
                cover.classList.add('is-invalid');
                coverError.textContent = 'Ukuran maksimal 2MB';
                valid = false;
            } else {
                cover.classList.remove('is-invalid');
                coverError.textContent = '';
            }
        }

        if(!valid){
            e.preventDefault();
            e.stopPropagation();
        }
    });

});
</script>
@endpush
