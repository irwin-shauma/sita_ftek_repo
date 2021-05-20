@extends('template.main')
@section('title', 'Daftar Mahasiswa')
@section('content')
{{-- <a href="#" class="btn btn-warning btn-sm">Tambah Mahasiswa</a> --}}
{{-- <a href="/TU/daftar_mahasiswa/cetak_pdf" class="btn btn-primary btn-sm" target="_blank">Cetak PDF</a> <br> --}}
<table class='table table-bordered table-striped' id="example1">
      <thead>
          <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Progress</th>
            <th>Aksi</th>
          </tr>
      </thead>
      <tbody>
        
        @foreach($lists as $data)
        <tr>
            
            <td>{{ $loop->iteration }}</td>
            <td>{{$data->nim}}</td>
            <td>{{$data->name}}</td>
            <td>{{$data->progress}}</td>
            <td>
              <a href="/TU/daftar_mahasiswa/detail_mahasiswa/{{$data->id_mhs}}" class="btn btn-sm btn-success disabled" aria-disabled="true">Detail</a>
              {{-- <a href="#" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal-default">Edit</a> --}}
              <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#mhs-edit-{{ $data->nim }}">
                {{-- <i class="far fa-edit"></i> --}}
                Edit
              </button>
              <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#mhs-delete-{{ $data->nim }}">
                  Hapus
                </button>

                {{-- Modal Edit --}}
                <div class="modal fade" id="mhs-edit-{{ $data->nim }}">
                  <div class="modal-dialog">
                    <div class="modal-content bg-white">
                      <div class="modal-header">
                        <h4 class="modal-title">Edit Mahasiswa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                          
                          <form action="{{ route('daftar_update_mhs', ['user' => $data->nim]) }}" method="POST">
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
                              <label for="nim" class="col-sm-2 col-form-label">NIM</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" id="nim" value="{{ $data->nim }}" name="nim">
                                <div class="text-danger">
                                  @error('nim')
                                  {{ $message }}
                                  @enderror
                              </div>
                              </div>                  
                            </div>

                            <input type="hidden" value="{{ $data->id }}" name="mhs_id">
            
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
                <div class="modal fade" id="mhs-delete-{{ $data->nim }}">
                  <div class="modal-dialog">
                    <div class="modal-content bg-white">
                      <div class="modal-header">
                        <h4 class="modal-title">Hapus Mahasiswa</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                          </div>
                            <div class="modal-body">
                              <p>Apakah anda yakin ingin menghapus data ini?</p>
                              <p>NIM : {{$data->nim}}</p>

                            </div>
                          <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">TIDAK</button>
                        <a href="{{ route('daftar_destroy_mhs', ['user' => $data->nim]) }}" class="btn btn-outline-danger">YA</a>
                      </div>
                    </div>
                  </div>
                </div>

            </td>
        </tr>
      @endforeach
      </tbody>
</table>

{{-- @foreach ($mahasiswa as $data)
    
@endforeach --}}
@endsection