@extends('backend.master')
@section('title', '- Role & Permissions')
@section('content')
<div class="container-fluid">
    <div class="wrapper-table p-3 bg-white rounded">
        <div class="w-100 mt-3 mb-3">
            @role('cabor')
            <a class="btn btn-danger" href="{{route('sport-branch.role-permission.create', $sport_branch->id)}}">Tambah Role</a>
            @endrole
        </div>

        <div class="table-responsive-sm">
            <table class="table table-hover table-striped" id="dataTable">
                <thead>
                    <tr>
                        <th>Nama Role</th>
                        <th class="text-center">Kelola</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>
</div>
@section('script-footer')
<script type="text/javascript">
  $(function () {

    let table = $('#dataTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('sport-branch.role-permission.index', $sport_branch->id) }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'action', orderable: false, searchable: false, 
                render: function(dataField){ 
                    let id = JSON.parse(dataField);
                    return `@role('cabor')<div class="text-center"><a href="{{url('sport-branch/`+id[0]+`/role-permission/`+id[1]+`/edit')}}" class='edit m-1'><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z"/>
                  </svg></a></div>@endrole`;
                } 
            },
        ]
    });
  });
</script>
@endsection
@endsection