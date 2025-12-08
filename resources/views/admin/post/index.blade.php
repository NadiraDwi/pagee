@extends('admin.layouts')

@section('title', 'Manajemen Postingan')

@section('content')

@push('custom-css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
@endpush

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">Postingan</li>
                    <li class="breadcrumb-item">Manajemen Postingan</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h2 class="mb-0">Manajemen Postingan</h2>
</div>

<div class="card">
    <div class="card-body">
        <table id="post-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="60px" class="text-center">#</th>
                    <th>Postingan</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th width="180px" class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<!-- Modal Detail Post -->
<div class="modal fade" id="postDetailModal" tabindex="-1" aria-labelledby="postDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="postDetailModalLabel">Detail Post</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="postDetailContent">
        <!-- Loading spinner -->
        <div class="text-center my-5">
          <div class="spinner-border" role="status">
            <span class="visually-hidden">Loading...</span>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

@endsection

@push('custom-js')
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function() {
    // DataTables
    $('#post-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.post.list') }}",
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'isi' },
            { data: 'user' },
            { data: 'tanggal' },
            { data: 'action', orderable: false, searchable: false, className: 'text-center' }
        ]
    });
});

// Tampilkan modal detail post
function showPostDetail(id) {
    var modalEl = document.getElementById('postDetailModal');
    var modal = new bootstrap.Modal(modalEl);
    modal.show();

    // Loading spinner
    $('#postDetailContent').html(`
        <div class="text-center my-5">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    `);

    // Fetch konten via AJAX
    $.ajax({
        url: '/admin/post/show/' + id,
        type: 'GET',
        success: function(res){
            $('#postDetailContent').html(res);
        },
        error: function(){
            $('#postDetailContent').html('<p class="text-danger text-center">Gagal memuat data.</p>');
        }
    });
}

// Hapus post dari modal
function deletePostModal(id) {
    Swal.fire({
        title: "Hapus postingan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
    }).then((res)=>{
        if(res.isConfirmed){
            $.ajax({
                url: '/admin/post/delete/' + id,
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function(){
                    Swal.fire("Berhasil", "Postingan dihapus", "success");

                    // tutup modal
                    var modalEl = document.getElementById('postDetailModal');
                    var modal = bootstrap.Modal.getInstance(modalEl);
                    modal.hide();

                    // reload DataTables
                    $('#post-table').DataTable().ajax.reload();
                },
                error: function(){
                    Swal.fire("Gagal", "Terjadi kesalahan", "error");
                }
            });
        }
    });
}
</script>
@endpush
