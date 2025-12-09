<!-- Alpine.js -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

<style>
    .post-card {
        position: relative;
        border: 1px solid #ddd;
        padding: 15px;
        border-radius: 10px;
        background: #fff;
        margin-bottom: 15px;
    }

    .post-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .post-header img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .post-menu-wrapper {
        position: absolute;
        right: 10px;
        top: 10px;
    }

    .menu-btn {
        background: none;
        border: none;
        font-size: 22px;
        cursor: pointer;
        padding: 3px;
    }

    .menu-dropdown {
        position: absolute;
        right: 0;
        margin-top: 5px;
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        width: 110px;
        padding: 5px 0;
        box-shadow: 0 4px 10px rgba(0,0,0,0.15);
        z-index: 100;
    }

    [x-cloak] { display: none !important; }

    .menu-dropdown button {
        width: 100%;
        padding: 8px 12px;
        text-align: left;
        border: none;
        background: none;
        cursor: pointer;
    }

    .menu-dropdown button:hover {
        background: #f0f0f0;
    }

    /* Global modal */
    .modal {
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.45);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .modal-small {
        background: white;
        width: 380px;
        padding: 20px;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(0,0,0,0.20);
    }

    .modal-small textarea {
        width: 100%;
        height: 130px;
        padding: 10px;
        border-radius: 8px;
        border: 1px solid #aaa;
        resize: vertical;
    }

    .modal-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 15px;
    }

    .btn-save {
        padding: 8px 14px;
        background: #007bff;
        border: none;
        color: white;
        border-radius: 6px;
    }

    .btn-delete {
        padding: 8px 14px;
        background: #d9534f;
        border: none;
        color: white;
        border-radius: 6px;
    }

    .btn-cancel {
        padding: 8px 14px;
        background: #ccc;
        border: none;
        border-radius: 6px;
    }
</style>


<!-- ROOT -->
<div x-data="{ 
        editModal:false,
        deleteModal:false,
        selectedPost:{ id:null, isi:'' }
    }">

    <div class="posts-grid mt-3">

        @foreach ($whispers as $post)
            <div class="post-card" x-data="{ menu:false }">

                <div class="post-header">
                    <img src="{{ $post->user->foto ? asset('storage/'.$post->user->foto) : 'https://via.placeholder.com/40' }}">

                    <div>
                        <span class="user-name">{{ $post->user->nama }}</span><br>
                        <span class="post-date">
                            {{ $post->tanggal_dibuat 
                                ? \Carbon\Carbon::parse($post->tanggal_dibuat)->format('d M Y H:i') 
                                : $post->created_at->format('d M Y H:i') 
                            }}
                        </span>
                    </div>

                    <!-- MENU TITIK TIGA -->
                    <div class="post-menu-wrapper">
                        <button class="menu-btn" @click="menu = !menu">⋮</button>

                        <div class="menu-dropdown"
                             x-show="menu"
                             x-cloak
                             @click.outside="menu = false">

                            <button 
                                @click="
                                    selectedPost = { 
                                        id:'{{ $post->id_post }}', 
                                        isi:`{{ $post->isi }}`
                                    };
                                    editModal = true;
                                    menu = false;
                                ">
                                Edit
                            </button>

                            <button 
                                @click="
                                    selectedPost = { id:'{{ $post->id_post }}' };
                                    deleteModal = true;
                                    menu = false;
                                ">
                                Hapus
                            </button>

                        </div>
                    </div>
                </div>

                <div class="post-body mt-2">
                    <h5>{{ $post->judul }}</h5>
                    <p>{{ $post->isi }}</p>
                </div>

            </div>
        @endforeach

    </div>


    <!-- EDIT MODAL (SMALL) -->
    <div class="modal"
         x-show="editModal"
         x-cloak
         @click.self="editModal = false">

        <div class="modal-small">
            <h2>Edit Post</h2>

            <form :action="'/posts/' + selectedPost.id" method="POST">
                @csrf
                @method('PUT')

                <textarea name="isi" x-model="selectedPost.isi"></textarea>

                <div class="modal-buttons">
                    <button type="submit" class="btn-save">Simpan</button>
                    <button type="button" class="btn-cancel" @click="editModal = false">Batal</button>
                </div>
            </form>
        </div>
    </div>


    <!-- DELETE MODAL (SMALL) -->
    <div class="modal"
         x-show="deleteModal"
         x-cloak
         @click.self="deleteModal = false">

        <div class="modal-small">
            <h3 style="margin-bottom: 15px;">Yakin ingin menghapus post ini?</h3>

            <form :action="'/posts/' + selectedPost.id" method="POST">
                @csrf
                @method('DELETE')

                <div class="modal-buttons">
                    <button type="submit" class="btn-delete">Hapus</button>
                    <button type="button" class="btn-cancel" @click="deleteModal = false">Batal</button>
                </div>
            </form>
        </div>
    </div>

</div>
