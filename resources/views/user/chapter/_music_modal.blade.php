{{-- ==========================
      MODAL MUSIK
========================== --}}
<div class="modal fade" id="musicModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Cari Musik</h5>
                <button class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- INPUT SEARCH --}}
                <div class="input-group mb-3 music-search-bar">
                    <input type="text" id="music_query" class="form-control" placeholder="Cari musik...">
                    <button class="btn-music-search" onclick="searchAudius()">Cari</button>
                </div>

                {{-- LIST RESULT --}}
                <div id="music_results" class="music-scroll"></div>

                {{-- AUDIO PREVIEW --}}
                <h6 class="mt-3" id="preview_label" style="display:none;">Preview:</h6>
                <audio id="music_player" controls style="width:100%; display:none;"></audio>

            </div>

        </div>
    </div>
</div>
