@extends('template.main')
@section('title', 'Verifikasi Kolokium Awal')
@section('content')
    Verifikasi Kolokium Awal
<table class='table table-bordered' id="example1">
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
                <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#mhs-verif-{{ $data->nim }}">
                  {{-- <i class="far fa-edit"></i> --}}
                  Verifikasi
                </button>
               
                  {{-- Modal Edit --}}
                  <div class="modal fade" id="mhs-verif-{{ $data->nim }}">
                    <div class="modal-dialog">
                      <div class="modal-content bg-white">

                        <div class="modal-header">
                          <h4 class="modal-title">Verifikasi Kolokium Awal</h4>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>

                        <div class="modal-body">
                          <h5>NIM : {{ $data->nim }}</h5>

                          @foreach ($nama as $item)
                          <div class="row">
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <p>{{ $item }} </p>
                                {{-- <input type="text" placeholder="{{ $item }}" /> --}}
                                {{-- <a href="" class="btn btn-sm btn-warning">Download</a> --}}
                                
                              </div>
                            </div><!-- /.col -->
                            <div class="col-md-3">
                              <a href="{{ route('download_berkas_awal', ['user' => $data->nim]) }}" class="btn btn-sm btn-warning">Download</a>
                            </div><!-- /.col -->

                            <div class="col-md-2">
                              <div class="form-group">
                                <div class="custom-control custom-checkbox mt-1">
                                  <input class="custom-control-input" type="checkbox" id="kbox1" value="option1">
                                  <label for="customCheckbox1" class="custom-control-label">Verifikasi</label>
                                </div>
                              </div>
                            </div><!-- /.col -->

                          </div>
                          @endforeach
                      
                        
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
  
            </td>
        </tr>
      @endforeach
      </tbody>

</table>

{{-- @foreach ($mahasiswa as $data)
    
@endforeach --}}
@endsection
