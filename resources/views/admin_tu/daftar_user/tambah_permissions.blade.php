@extends('template.main')
@section('title', 'Tambah Permissions')
@section('content')
<button type="button" class="btn btn-sm btn-info mb-3" data-toggle="modal" data-target="#tambah_permission">
  Tambah Permission
</button>
<table class='table table-bordered table-striped' id="example1">
      <thead>
          <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Dosen</th>
            <th>Permission</th>
            <th>Aksi</th>
          </tr>
      </thead>
      
      <tbody>
        @foreach($dosen as $data)
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $data->nip }}</td>
          <td>{{ $data->name }}</td>
          <td>
            {{-- {{ dd($users[$loop->index]) }} --}}
            @if ($users[$loop->index]->getPermissionNames() == null)
                - 
            @else
                <?php $counter = $loop->index ?>
                @foreach ($users[$counter]->getPermissionNames() as $item)
                  {{ $item }},
                @endforeach
                {{-- {{ $users[$loop->index]->getPermissionNames()[0] }} --}}
                
            @endif
          </td>
          <td>
            {{-- {{ dd($data->nip) }} --}}
            <button type="button" class="btn btn-sm btn-warning verif" data-toggle="modal" data-target="#delete_permission-{{ $data->nip }}">
              Hapus
            </button>

            {{-- --------------------------------------------------------------------------------- --}}
            <div class="modal fade" id="delete_permission-{{ $data->nip }}">
              <div class="modal-dialog">
                <div class="modal-content bg-white">
                  
                  <div class="modal-header">
                    <h4 class="modal-title">Hapus Permission</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  
                  
                  <div class="modal-body">
                    <form action="{{ route('delete_permission') }}" method="POST">
                      @csrf
                      <div class="row">
                        <div class="col-md-6"> 
                          <h5>NIP : {{ $data->nip }}</h5> 
                        </div>
                      </div><!-- /.row -->
                      
                  {{-- ----------------------------------------------------------------------------------------------- --}}
                      
                    <?php $counter = $loop->index; ?>
                        <input type="hidden" class="form-control" name="id_user_dosen" value={{ $users[$loop->index]->id }}>
                        @foreach ($users[$loop->index]->getPermissionNames() as $key)
                        <div class="row">
                          
                          <div class="col-md-6">
                            <div class="form-group">
                              <p>{{ $key}} </p>
                            </div>
                          </div><!-- /.col -->
              
                            <div class="col-md-2">
                              <div class="form-group">
                                <div class="form-check">
                                    <input type="hidden" class="form-control" name="{{ $key }}" value='0'>
                                    <input class="form-check-input semua_input" type="checkbox" value="1" name="{{ $key }}" id="{{ $key }}">
                                    <label class="form-check-label" for="{{ $key }}">
                                      Hapus
                                    </label>
                                </div>
                              </div>
                            </div><!-- /.col -->
            
                        </div>
                        @endforeach
            
                  </div>
                      
                  <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Hapus</button>
                  </div>
            
                </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>



          </td>
        </tr>
        @endforeach
      </tbody>
</table>




    {{-- Modal Edit --}}
    <div class="modal fade" id="tambah_permission">
      <div class="modal-dialog">
        <div class="modal-content bg-white">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Permission</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="{{ route('apply_permission') }}" method="POST">
              @csrf
            <div class="form-group row">
              <label for="user_id" class="col-sm-3 col-form-label">Nip - Nama</label>
              <div class="col-sm-7">
                  <select name="user_id" id="inputState" class="form-control">
                      @foreach ($dosen_all as $data)
                          <option value="{{ $data->user_id }}">{{ $data->nip }} - {{ $data->name}}</option>
                      @endforeach
                  </select>
              </div>
            </div>
    
            <div class="form-group row">
              <label for="permission" class="col-sm-3 col-form-label">Permission</label>
              <div class="col-sm-7">
                  <select name="permission" id="inputState" class="form-control">
                      @foreach ($permissions as $permission)
                          <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                      @endforeach
                  </select>
              </div>
            </div>
    
          </div>
          
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
    
            </form>
        </div>
        <!-- /.modal-content -->
      </div>
      <!-- /.modal-dialog -->
    </div>











{{-- 
<table class='table table-bordered'>
      <thead>
          <tr>
            <th>No</th>
            <th>NIP</th>
            <th>Nama Dosen</th>
            <th>Permission</th>
            <th>Aksi</th>
          </tr>
      </thead>
      <tbody>
      </tbody>
</table> --}}
@endsection