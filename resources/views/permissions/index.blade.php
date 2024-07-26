@extends('layouts.admin')

@section('css')
 <meta name="csrf-token" content="{{ csrf_token() }}">
 <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
@endsection

@section('header')
    <div class="d-flex justify-between">
        <div>
            Permissions
        </div>
        <div>
            <a href="{{ route('permissions.create') }}"><button class="btn btn-dark">Create</button></a>
        </div>
    </div>
@endsection

@section('content')
<div class="container">
    <table id="myTable" class="table table-striped">
        <thead>
            <tr>
                <th>No</th>
                <th>Name</th>
                <th>Date</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>


<script>
  $(document).ready(function() {
    $('select[name="myTable_length"]').css('width', '60px');

    if (!$.fn.DataTable.isDataTable('#myTable')) {
      $('#myTable').DataTable({
        serverSide: true,
        ajax: "{{ route('permissions.data') }}",
        columns: [
          {
            "targets": 0,
            'width': '5%',
            "data": null,
            "render": function(data, type, row, meta) {
              return meta.row + 1;
            }
          },
          { data: 'name', name: 'name',width: '30%' },
          { data: 'created_at',
                    name: 'created_at',
                    "render": function(data, type, row) {
                        return moment(data).format('D MMM, YYYY');
                    },width: '20%' },
          { data: 'action', name: 'action', orderable: false, searchable: false }
        ]
      });
    }

    $("body").on('click','.delete',function() {
            var permissionId = $(this).data('id');
            var deleteUrl = "{{ route('permissions.delete', ':id') }}".replace(':id', permissionId);

            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: deleteUrl,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                title: "Error!",
                                text: "An error occurred while deleting the permission.",
                                icon: "error"
                            });
                        }
                    });
                }
            });
        });
  });
</script>




@endsection
