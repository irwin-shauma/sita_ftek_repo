@extends('template.main')
@section('title', 'Daftar Dosen')
@section('content')
<table class='table table-bordered table-striped' id="example1">
    <thead>
        <tr>
          <th>No</th>
          <th>NIP</th>
          <th>Nama Dosen</th>
          <th>User Id</th>
          <th>Aksi</th>
        </tr>
    </thead>
    <tbody>

      @foreach($lists as $data)
      <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{$data->nip}}</td>
          <td>{{$data->name}}</td>
          <td>{{ $data->user_id }}</td>
          <td>
            <a href="/TU/daftar_mahasiswa/detail_mahasiswa/{{$data->id_mhs}}" class="btn btn-sm btn-success disabled" aria-disabled="true">Detail</a>
            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#dsn-edit-{{ $data->nip }}">
              Edit
            </button>
            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#dsn-delete-{{ $data->nip }}">
                Hapus
            </button>

            {{-- Modal Edit --}}
            <div class="modal fade" id="dsn-edit-{{ $data->nip }}">
              <div class="modal-dialog">
                <div class="modal-content bg-white">
                  <div class="modal-header">
                    <h4 class="modal-title">Edit Dosen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                      
                      <form action="{{ route('daftar_update_dsn', ['user' => $data->nip]) }}" method="POST">
                        @csrf
                        <div class="form-group row">
                          <label for="name" class="col-sm-2 col-form-label">Nama</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" value="{{ $data->name }}" name="name">
                            <div class="text-danger">
                              @error('name')
                              {{ $message }}
                              @enderror
                          </div>
                          </div>
                        </div>
        
                        <div class="form-group row">
                          <label for="nip" class="col-sm-2 col-form-label">NIP</label>
                          <div class="col-sm-10">
                            <input type="text" class="form-control" id="nip" value="{{ $data->nip }}" name="nip">
                            <div class="text-danger">
                              @error('nip')
                              {{ $message }}
                              @enderror
                          </div>
                          </div>                  
                        </div>
        
                        <input type="hidden" value="{{ $data->id }}" name="dsn_id">

                  </div>
                  
                    <div class="modal-footer justify-content-between">
                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>

                     </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>

            {{-- Modal Delete --}}
            <div class="modal fade" id="dsn-delete-{{ $data->nip }}">
              <div class="modal-dialog">
                <div class="modal-content bg-white">
                  <div class="modal-header">
                    <h4 class="modal-title">Hapus Dosen</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                      </div>
                        <div class="modal-body">
                          <p>Apakah anda yakin ingin menghapus data ini?</p>
                          <p>NIP : {{$data->nip}}</p>

                        </div>
                      <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">TIDAK</button>
                    <a href="{{ route('daftar_destroy_dsn', ['user' => $data->nip]) }}" class="btn btn-outline-danger">YA</a>
                  </div>
                </div>
              </div>
            </div>

          </td>
      </tr>
    @endforeach
    </tbody>
</table>
@endsection
{{-- @push('name')
<script>
    $(function(){
        $('#example').DataTable();
    });
</script>
@endpush --}}
 

{{-- <a href="/TU/daftar_dosen/tambah_dosen" class="btn btn-info btn-sm">Tambah Dosen</a> <br> --}}
