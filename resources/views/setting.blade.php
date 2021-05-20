@extends('template.main')
@section('title', 'Setting')
@section('content')

<table class="table" id="example1">
    <thead>
        <tr>
            <th scope="col">No</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Email</th>
            <th scope="col">Role</th>
            <th scope="col">Permissions</th>
            <th scope="col">Action</th>
        </tr>
    </thead>
    <tbody>

        @foreach ($users as $user)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->getRoleNames()[0] }}</td>
            <td>{{ $user->getPermissionNames()[0]}}</td>
            <td>
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-default-{{ $user->id }}">
                    <i class="far fa-edit"></i>
                </button>
                {{-- <a href="{{ url('/edit/' . $user->id) }}" class="btn btn-sm btn-success"><i class="far fa-edit"></i></a> --}}
                <div class="btn btn-sm btn-danger"><i class="far fa-trash-alt"></i></div>


                <div class="modal fade" id="modal-default-{{ $user->id }}">
                    <div class="modal-dialog">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h4 class="modal-title">Edit Role</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">

                            {{-- <form action="{{ url('/edit/' . $user->id) }}" method="POST"> --}}
                            <form action="{{ url('/edit/' . $user->id) }}" method="POST">
                                @csrf
                                <div class="form-group row">
                                  <label for="nama" class="col-sm-2 col-form-label">Nama</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control-plaintext" id="nama" value="{{ $user->name }}" readonly name="nama">
                                  </div>
                                </div>
                
                                <div class="form-group row">
                                  <label for="email" class="col-sm-2 col-form-label">Email</label>
                                  <div class="col-sm-10">
                                    <input type="text" class="form-control-plaintext" id="email" value="{{ $user->email }}" readonly name="email">
                                  </div>                  
                                </div>
                
                                <div class="form-group row">
                                    <label for="role" class="col-sm-2 col-form-label">Role</label>
                                    <div class="col-sm-10">
                                        <select name="role" id="inputState" class="form-control">
                                            @foreach ($roles_all as $role)
                                                <option value="{{ $role->id }}">{{ $role->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                          </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                  </div>
                  <!-- /.modal -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

@endsection