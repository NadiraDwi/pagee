<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
.whisper-card {
    position: relative;
    border: 1px solid #ddd;
    border-radius: 10px;
    padding: 15px;
    margin-bottom: 15px;
    background: #fff;
}
.whisper-text { margin-bottom: 10px; font-size: 15px; }
.whisper-time { font-size: 12px; color:#666; }
.whisper-anon { font-size: 12px; float:right; color:#555; font-style: italic; }

/* Menu titik tiga */
.whisper-menu { position:absolute; top:10px; right:10px; z-index:20; }
.menu-btn { background:none; border:none; font-size:22px; cursor:pointer; }
.menu-dropdown {
    position:absolute; right:0; margin-top:5px;
    background:#fff; border:1px solid #ddd; border-radius:8px;
    width:110px; padding:5px 0;
    box-shadow:0 4px 10px rgba(0,0,0,0.15);
    z-index:50;
}
.menu-dropdown button {
    width:100%; padding:8px 12px; text-align:left;
    border:none; background:none; cursor:pointer;
}
.menu-dropdown button:hover { background:#f0f0f0; }

/* Modal */
.modal {
    position:fixed; inset:0; background:rgba(0,0,0,0.45);
    display:flex; align-items:center; justify-content:center;
    z-index:999;
}
.modal-small {
    background:#fff; width:380px; padding:20px;
    border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.20);
}
.modal-small textarea {
    width:100%; height:130px; padding:10px;
    border-radius:8px; border:1px solid #aaa; resize:vertical;
}
.modal-buttons {
    display:flex; justify-content:flex-end; gap:10px; margin-top:15px;
}
.btn-save { padding:8px 14px; background:#6f42c1; color:white; border:none; border-radius:6px; }
.btn-delete { padding:8px 14px; background:#d9534f; color:white; border:none; border-radius:6px; }
.btn-cancel { padding:8px 14px; background:#ccc; border:none; border-radius:6px; }

[x-cloak] { display:none !important; }
</style>

<div x-data="whisperHandler()">

    @if ($whispers->isEmpty())
        <div class="mt-4 text-center text-muted fst-italic">Belum ada whisper ✨</div>
    @else
        @foreach ($whispers as $w)
            <div class="whisper-card">
                <p class="whisper-text">{{ $w->isi }}</p>
                <span class="whisper-time">{{ $w->created_at->diffForHumans() }}</span>
                <span class="whisper-anon">- Anonymous</span>

                <!-- Menu titik tiga -->
                <div class="whisper-menu">
                    <button class="menu-btn" @click="toggleMenu({{ $w->id_post }})">⋮</button>
                    <div class="menu-dropdown" x-show="openMenu === {{ $w->id_post }}" x-cloak @click.outside="openMenu=null">
                        <button @click="edit({{ $w->id_post }}, '{!! json_encode($w->isi) !!}')">Edit</button>
                        <button @click="hapus({{ $w->id_post }})">Hapus</button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <!-- EDIT MODAL -->
    <div class="modal" x-show="editModal" x-cloak @click.self="editModal=false">
        <div class="modal-small">
            <h3>Edit Whisper</h3>
            <form :action="`/posts/${selected.id_post}`" method="POST">
                @csrf
                @method('PUT')
                <textarea name="isi" x-model="selected.isi" required></textarea>
                <div class="modal-buttons">
                    <button type="submit" class="btn-save">Simpan</button>
                    <button type="button" class="btn-cancel" @click="editModal=false">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <!-- DELETE MODAL -->
    <div class="modal" x-show="deleteModal" x-cloak @click.self="deleteModal=false">
        <div class="modal-small">
            <h3>Hapus whisper ini?</h3>
            <form :action="`/posts/${selected.id_post}`" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-buttons">
                    <button type="submit" class="btn-delete">Hapus</button>
                    <button type="button" class="btn-cancel" @click="deleteModal=false">Batal</button>
                </div>
            </form>
        </div>
    </div>

</div>

<script>
function whisperHandler() {
    return {
        openMenu: null,
        editModal: false,
        deleteModal: false,
        selected: { id_post:null, isi:'' },

        toggleMenu(id) {
            this.openMenu = (this.openMenu === id) ? null : id;
        },
        edit(id, isi) {
            this.selected = { id_post:id, isi:isi };
            this.editModal = true;
            this.openMenu = null;
        },
        hapus(id) {
            this.selected = { id_post:id };
            this.deleteModal = true;
            this.openMenu = null;
        }
    }
}
</script>
