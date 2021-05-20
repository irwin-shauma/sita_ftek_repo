@extends('template.main')
@section('title', 'Verifikasi Kolokium Awal')
@section('content')
<table class='table table-bordered table-striped' id='example1'>
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
            <td>
              @switch($data->progress)
                  @case(0)
                      Kolokium Awal
                      @break
                  @case(1)
                      Menunggu Verifikasi Kolokium Awal
                      @break
                  @case(2)
                      Kolokium Lanjut
                      @break
                  @case(3)
                      Menunggu Verifikasi Kolokium Lanjut
                      @break
                  @case(4)
                      Pengajuan Review / Nilai Publikasi
                      @break
                  @case(5)
                      Menunggu Verifikasi Pengajuan Review / Nilai Publikasi
                      @break
                  @case(6)
                      Lulus
                      @break
                  @default
                @endswitch
                </td>
            <td>
              <a href="{{ route('download_berkas_awal', ['user' => $data->nim]) }}" class="btn btn-sm btn-warning">Download</a>  
              <button type="button" class="btn btn-sm btn-success verif" data-toggle="modal" data-target="#mhs-verif-{{ $data->nim }}">

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
                      <form action="{{ route('verif_kolokium_awal_verified', ['user' => $data->nim]) }}" method="POST">
                      @csrf
                      <div class="row">
                        <div class="col-md-6"> 
                            <h5>NIM : {{ $data->nim }}</h5> 
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <div class="form-check">
                              <input class="form-check-input check_all" type="checkbox" value="1" name="check-all" id="check_all">
                              <label class="form-check-label" for="check_all">
                                Check All
                              </label>
                            </div>
                          </div>
                        </div><!-- /.col -->
                      </div><!-- /.row -->

                        @foreach ($nama as $key => $item)
                        <div class="row">

                          <div class="col-md-6">
                            <div class="form-group">
                              <p>{{ $item }} </p>
                            </div>
                          </div><!-- /.col -->

                          <div class="col-md-2">
                            <div class="form-group">
                              <div class="form-check">
                                {{-- <input class="form-check-input" type="checkbox" value="{{ $key }}" name="nomor[]" id="flexCheckDefault"> --}}
                                <input class="form-check-input" type="checkbox" value="1" name="{{ $key }}" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                  Verifikasi
                                </label>
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
@endsection

@push('checkboxes_all')
<script>


$(function () {
    $('.verif').click(function (event) {
        
        $('input:checkbox').each(function () {    this.checked = false; });

    });
  });


$(function () {
    $('.check_all').click(function (event) {
        
        var selected = this.checked;
        // Iterate each checkbox
        // $(':checkbox').each(function () {    this.checked = selected; });
        $('input:checkbox').each(function () {    this.checked = selected; });

    });
  });
</script>
@endpush
