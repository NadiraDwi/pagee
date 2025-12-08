@extends('user.layouts')

@section('title', 'Chapter')
@section('nav-chapter', 'active')

@section('content')

@php
    use Carbon\Carbon;
@endphp
<style>
.chapter-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 18px;
    border-radius: 10px;
    border: 1px solid #eee;
    background: #fff;
    transition: 0.2s ease;
    text-decoration: none;
    color: inherit;
}
.chapter-row:hover {
    background: #f6f1ff;
    border-color: #d9c9ff;
    cursor: pointer;
}
.chapter-number { font-weight: 600; color: #6f42c1; }
.chapter-title { flex:1; margin-left:12px; font-weight:500; color:#000; }
.btn-outline-purple {
    border:1.8px solid #6f42c1; color:#6f42c1; padding:5px 14px; font-size:14px;
    border-radius:8px; background:transparent; transition:0.2s; text-decoration:none !important;
}
.btn-outline-purple:hover { background:#6f42c1; color:#fff; }
.header-cover {
    width:100%; height:220px; border-radius:12px; background-size:cover; background-position:center;
    background-repeat:no-repeat; margin-bottom:20px; position:relative; overflow:hidden;
}
.header-cover::after {
    content:""; position:absolute; inset:0; background:rgba(0,0,0,0.35);
}
.header-title { position:absolute; bottom:15px; left:20px; z-index:2; color:white; font-size:22px; font-weight:700; }
</style>

{{-- HEADER COVER --}}
<div class="header-cover" style="background-image: url('{{ asset('storage/'.$post->cover->cover_path) }}')">
    <div class="header-title">{{ $post->judul }}</div>
</div>

<!-- Updated view with tabs for Author Info and Chapters -->
<!-- You can paste this into your Blade view and adapt as needed -->

<div class="container">

  <!-- TABS NAV -->
  <ul class="nav nav-tabs mb-3" id="chapterTab" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link active" id="author-tab" data-bs-toggle="tab" data-bs-target="#authorTab" type="button" role="tab">Author</button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link" id="chapter-tab" data-bs-toggle="tab" data-bs-target="#chapterTabContent" type="button" role="tab">Chapters</button>
    </li>
  </ul>

  <style>
    .nav-tabs .nav-link.active {
        color: #6f42c1 !important;
        font-weight: 600;
    }
    #authorTab strong {
        color: #6f42c1;
    }

    .chapter-title a { color:#000 !important; text-decoration:none !important; }
</style>

  <!-- TAB CONTENT -->
  <div class="tab-content" id="chapterTabContentWrapper">

    <!-- TAB 1: AUTHOR INFO -->
    <div class="tab-pane fade show active p-3" id="authorTab" role="tabpanel">
        <div class="mb-3">
            <strong>Penulis:</strong> {{ $post->user->nama }}<br>
            <small>Email: {{ $post->user->email }}</small><br>

        @if($post->collabs->count() > 0)
            <strong>Collaborators:</strong><br>
                @foreach($post->collabs as $c)
                    {{ $c->user2->nama }} — <small>{{ $c->user2->email }}</small><br>
                @endforeach
        @endif

        <strong>Tanggal Terbit: </strong><small>{{ $post->created_at->format('d M Y H:i') }}</small>
        </div>

        <hr>
        <strong>Sinopsis</strong>
        <div class="mt-2" style="text-align: justify;">{!! nl2br(e($post->isi)) !!}</div>
    </div>

    <!-- TAB 2: CHAPTER LIST -->
    <div class="tab-pane fade p-3" id="chapterTabContent" role="tabpanel">
      
    {{-- Button Tambah Chapter & Add People (Owner/Collab) --}}
    @auth
    {{-- Button Tambah Chapter & Add People --}}
    @auth
    @if($isOwner || $isCollaborator)
    <div class="d-flex align-items-center gap-2 mb-4">
        <a href="{{ route('chapter.create', $post->id_post) }}" class="btn-outline-purple">
            + Tambah Chapter
        </a>

        <button type="button" id="addPeopleBtn" class="btn btn-outline-purple">
            <i class="fa-solid fa-user-plus me-1"></i> Add People
        </button>
    </div>
    @endif
    @endauth

    {{-- Container chip user --}}
    <input type="hidden" id="mentionsInput">
    <div id="selectedUsers" class="mb-3 d-flex flex-wrap gap-2"></div>
    @endauth

    {{-- List Chapter --}}
    <div class="d-flex flex-column gap-2">
    @forelse ($chapters as $i => $chapter)
        @php
            $isBeforeRelease = $chapter->scheduled_at?->isFuture() ?? false;
            $isRestricted = !($isOwner || $isCollaborator) && $isBeforeRelease;
        @endphp

        <div class="chapter-row {{ $isRestricted ? 'bg-light text-muted' : '' }}" 
            style="{{ $isRestricted ? 'cursor:not-allowed; opacity:.7;' : '' }}">
            
            <div class="chapter-number">Chapter {{ $i+1 }}</div>

            <div class="chapter-title">
                @if($isRestricted)
                    {{ $chapter->judul_chapter }}
                @else
                    <a href="{{ route('chapter.read', [$post->id_post, $chapter->id_chapter]) }}">
                        {{ $chapter->judul_chapter }}
                    </a>
                @endif
            </div>

            @if($chapter->scheduled_at)
                <span class="badge {{ $isBeforeRelease ? 'bg-warning text-dark' : '' }}" style="font-size:11px;">
                    @if($isBeforeRelease)
                        Rilis pada {{ $chapter->scheduled_at->format('d M Y H:i') }}
                    @endif
                </span>
            @endif
        </div>
    @empty
        <p class="text-muted">Belum ada chapter.</p>
    @endforelse
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
                @if($u->id_user != auth()->id() && $u->role != 'admin' && !$post->collabs->pluck('id_user2')->contains($u->id_user))
                <li class="list-group-item list-group-item-action modal-user" data-id="{{ $u->id_user }}">
                    {{ $u->nama }} — <small>{{ $u->email }}</small>
                </li>
                @endif
            @endforeach
            </ul>
        </div>
        </div>
    </div>
    </div>

        <div id="chapterLoopPlaceholder"></div>
    </div>

  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
const existingCollabs = @json($post->collabs->map(fn($c)=>['id'=>$c->id_user2,'name'=>$c->user2->nama]));

let mentionsInput = document.getElementById('mentionsInput');
let selectedIds = [];
let selectedUsersDiv = document.getElementById("selectedUsers");

window.addEventListener("DOMContentLoaded", () => {
    existingCollabs.forEach(u => {
        selectedIds.push(String(u.id));
        addUserChip(String(u.id), u.name);
    });
    mentionsInput.value = JSON.stringify(selectedIds);
});

document.getElementById('addPeopleBtn')?.addEventListener('click', () => {
    bootstrap.Modal.getOrCreateInstance(document.getElementById('userModal')).show();
});

document.querySelectorAll('.modal-user').forEach(item => {
    item.addEventListener('click', function () {
        let id = this.dataset.id;
        let name = this.childNodes[0].textContent.trim();
        if (!selectedIds.includes(id)) {
            selectedIds.push(id);
            addUserChip(id, name);
            saveToDatabase(id);
        }
        mentionsInput.value = JSON.stringify(selectedIds);
        bootstrap.Modal.getInstance(document.getElementById('userModal')).hide();
    });
});

function addUserChip(id,name){
    let chip = document.createElement('div');
    chip.classList.add('px-3','py-2');
    chip.style.cssText = "background:#6f42c1;color:white;border-radius:20px;display:flex;align-items:center;gap:6px;margin-right:6px;";
    chip.innerHTML = `<span>${name}</span>
        <button class="btn btn-sm btn-light p-0 px-2" style="border-radius:50%; font-weight:bold;" data-remove="${id}">X</button>`;
    selectedUsersDiv.appendChild(chip);

    chip.querySelector("[data-remove]").addEventListener("click", function(){
        selectedIds = selectedIds.filter(uid=>uid!=id);
        mentionsInput.value = JSON.stringify(selectedIds);
        chip.remove();
        removeFromDatabase(id);
    });
}

function saveToDatabase(userID){
    fetch("{{ route('collab.add') }}",{method:"POST",
        headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}","Content-Type":"application/json"},
        body:JSON.stringify({id_post:"{{ $post->id_post }}",id_user:userID})})
    .then(res=>res.json()).then(data=>console.log(data));
}

function removeFromDatabase(userID){
    fetch("{{ route('collab.remove') }}",{method:"POST",
        headers:{"X-CSRF-TOKEN":"{{ csrf_token() }}","Content-Type":"application/json"},
        body:JSON.stringify({id_post:"{{ $post->id_post }}",id_user:userID})})
    .then(res=>res.json()).then(()=>location.reload());
}

document.getElementById('searchUser')?.addEventListener('keyup',function(){
    let keyword=this.value.toLowerCase();
    document.querySelectorAll('#userModalList .modal-user').forEach(item=>{
        item.classList.toggle('d-none',!item.textContent.toLowerCase().includes(keyword));
    });
});
</script>
@endpush
