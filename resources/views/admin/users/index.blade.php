@extends('layouts.dash', ['activePage' => 'admin_users', 'title' => 'Administrar usuarios', 'navName' => 'Usuarios del Sistema', 'activeButton' => 'adminactiveButton'])

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Inicio</a></li>
            <li class="breadcrumb-item">Administracion</li>
            <li class="breadcrumb-item active" aria-current="page"><a href="{{route('admin.users.index')}}">Usuarios</a></li>
        </ol>
    </nav>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-md-6">
                    <h4>Lista de Usuarios</h4>
                </div>
                <div class="col-md-6 text-right"><a href="{{route('admin.users.create')}}" class="btn btn-lab-pdm-primary btn-sm">Crear Usuario</a></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-full-width table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Estado</th>
                        <th>Roles</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>{!! ($user->active)? '<a onclick="openActiveModal('.$user->id.'); return false" class="btn btn-link text-primary">Activo</a>' : '<a onclick="openActiveModal('.$user->id.'); return false;" class="btn btn-link text-danger">Desactivado</a>'  !!}</td>
                            <td>{{implode(', ', $user->roles()->get()->pluck('name')->toArray())}}</td>
                            <td>
                                @can('edit-users')
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-success btn-sm m-1"><i class="far fa-edit"></i></a>&nbsp;
                                @endcan
                                @can('delete-users')
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="float-left">
                                    @csrf
                                    {{method_field('DELETE')}}
                                    <button type="submit" class="btn btn-danger btn-sm m-1"><i class="far fa-trash-alt"></i></button>
                                </form>
                                    @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

    </div>

    <!-- Modal -->
    <div class="modal fade" id="activeModal" tabindex="-1" aria-labelledby="activeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form onsubmit="sendActivoDes(this); return false;">
                <input type="hidden" name="user_id">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        function openActiveModal(userId){
            $.ajax({
                url: "{{ url('/admin/users/a-get-user/') }}/"+userId,
                type: 'POST',
                success: function (data) {
                    console.log(JSON.stringify(data));

                    $("#activeModal").modal('show');
                    $("#activeModal .modal-body").empty().append(showMessage(data.user.active, data.user.name));
                    $("#activeModal input[name='user_id']").val(data.user.id);
                    // location.reload();
                }
            });
        }

        function showMessage(active, nombre){
            let html = '';
            if(active){
                html += '<div class="alert alert-danger" role="alert">';
                html += 'Usted desactivara al usuario <b>'+nombre+'</b>';
                html += '</div>';
            } else {
                html += '<div class="alert alert-success" role="alert">';
                html += 'Usted activara al usuario <b>'+nombre+'</b>';
                html += '</div>';
            }

            return html;
        }

        function sendActivoDes(form){
            $.ajax({
                url: "{{ route('admin.ajax.user.active') }}",
                type: 'POST',
                data: $(form).serialize(),
                success: function (data) {
                    console.log(JSON.stringify(data));
                    location.reload();
                }
            });
        }
    </script>
@endpush
