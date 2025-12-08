@extends('admin.layouts')

@section('title', 'Manajemen User')

@section('content')

@push('custom-css')
<link href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css" rel="stylesheet"/>
@endpush

<div class="page-header">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item">User</li>
                    <li class="breadcrumb-item">Manajemen User</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between mb-3">
    <h2 class="mb-0">Manajemen User</h2>
</div>

<div class="card">
    <div class="card-body">
        <table id="user-table" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th width="60px" class="text-center">#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th width="180px" class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@push('custom-js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$('#user-table').DataTable({
    processing: true,
    serverSide: true,
    ajax: "{{ route('admin.user.list') }}",  // ✔ sesuai prefix admin/user/list
    columns: [
        { data: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
        { data: 'nama' },
        { data: 'email' },
        { data: 'role' },
        { data: 'action', orderable: false, searchable: false, className: 'text-center' }
    ]
});
</script>

<script>
function deleteData(id) {
    Swal.fire({
        title: "Hapus user?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Hapus",
    }).then((res)=>{
        if(res.isConfirmed){
            $.ajax({
                url: "{{ url('/admin/user/delete') }}/" + id, // ✔ auto /admin/user/delete/{id}
                type: "DELETE",
                data: { _token:"{{ csrf_token() }}" },
                success: function(){
                    Swal.fire("Berhasil", "Data dihapus", "success");
                    $('#user-table').DataTable().ajax.reload();
                }
            });
        }
    });
}
</script>
@endpush
