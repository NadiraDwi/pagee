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
                    <th>Judul</th>
                    <th>Penulis</th>
                    <th>Tanggal</th>
                    <th width="180px" class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('custom-js')
<script>
$('#post-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('admin.post.list') }}",
    columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
        { data: 'judul' },
        { data: 'user' },
        { data: 'tanggal' },
        { data: 'action', orderable: false, searchable: false, className: 'text-center' }
    ]
});
</script>

<script>
function deletePost(id){
    Swal.fire({
        title: "Hapus postingan?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
    }).then((res)=>{
        if(res.isConfirmed){
            $.ajax({
                url: "{{ url('/admin/post/delete') }}/" + id,
                type: "DELETE",
                data: { _token:"{{ csrf_token() }}" },
                success: function(){
                    Swal.fire("Berhasil", "Postingan dihapus", "success");
                    $('#post-table').DataTable().ajax.reload();
                }
            });
        }
    });
}
</script>
@endpush
