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
                  @default
                @endswitch
                </td>
            <td>
              <a href="{{ route('korkon_elektro_verif_kolokium_awal_download', ['user' => $data->nim]) }}" class="btn btn-sm btn-warning">Download</a>
              <button type="button" class="btn btn-sm btn-success verif" data-toggle="modal" data-target="#mhs-verif-{{ $data->nim }}">
                  Verifikasi
              </button>
              {{-- ----------------------------------------------------------------------------------------------- --}}
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
                      <form action="{{ route('korkon_elektro_verif_kolokium_awal_verified', ['user' => $data->nim]) }}" method="POST">
                        @csrf
                        <div class="row">
                          <div class="col-md-6"> 
                            <h5>NIM : {{ $data->nim }}</h5> 
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <div class="form-check">
                                
                                <input type="hidden" value="0" name="check_all" id="check_all">
                                
                                <input class="form-check-input check_all semua kotak" type="checkbox" value="1" name="check_all" id="check_all">
                                <label class="form-check-label" for="check_all">
                                  Check All
                                </label>
                              </div>
                            </div>
                          </div><!-- /.col -->
                        </div><!-- /.row -->
                        
                {{-- ----------------------------------------------------------------------------------------------- --}}
                        
                      <?php $counter_mhs = $loop->index; ?>
                      @if ($check_korkon[$loop->index] > 0 && ($check_korkon[$loop->index] < $check_mhs_send[$loop->index]))
                          {{-- JIka dosen check minimal 1, dan check_mhs_send 2, ato paling enggak selisih satu  --}}
                          {{-- Dengan posisi mhs lebih tinggi, maka masuk sini. --}}
                          <input type="hidden" class="form-control" name="check_korkon" value={{ $check_korkon[$counter_mhs] }}>
                          <input type="hidden" class="form-control" name="id_mhs" value={{ $data->id }}>
                          @foreach ($nama_field as $key => $value)
                          {{-- <input type="hidden" class="form-control" name="{{ $value }}" value={{ $kolokium_awal_status[0]->$value }}> --}}
                          <div class="row">
                            
                            <div class="col-md-6">
                              <div class="form-group">
                                <p>{{ $nama_only[$loop->index] }} </p>
                              </div>
                            </div><!-- /.col -->
                            {{-- {{ dd($value) }} --}}
                            {{-- {{ dd($kolokium_awal_status[$counter_mhs]->$value) }} --}}

                            <div class="col-md-2">
                              <div class="form-group">
                                <div class="form-check">
      
                                  @if ($kolokium_awal_status[$counter_mhs]->$value == 0)
                                    <input class="form-check-input semua_input" type="checkbox" value="1" name="{{ $key }}" id="{{ $key }}">
                                    <label class="form-check-label" for="{{ $key }}">
                                      Verifikasi
                                    </label>
                                  @else
                                    <input class="form-check-input" type="checkbox" value="1" name="{{ $key }}" id="{{ $key }}" checked disabled>
                                    {{-- <label class="form-check-label" for="{{ $key }}"> --}}
                                    <label class="form-check-label" for="centang">
                                      Verified
                                    </label>
                                  @endif   
                                </div>
                              </div>
                            </div><!-- /.col -->

                          </div>
                          @endforeach

                      @else
                      {{-- Jika check_mhs_send 1, yang mana baru upload masuk ini --}}
                      <input type="hidden" class="form-control" name="check_korkon" value={{ $check_korkon[$counter_mhs] }}>
                      <input type="hidden" class="form-control" name="id_mhs" value={{ $data->id }}>
                        @foreach ($nama_field as $key => $item)
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <p>{{ $nama_only[$loop->index] }} </p>
                            </div>
                          </div><!-- /.col -->

                          <div class="col-md-2">
                            <div class="form-group">
                              <div class="form-check">
                                
                                <input type="hidden" value="0" name="{{ $key }}">
                                <input class="form-check-input kotak" type="checkbox" value="1" name="{{ $key }}" id="{{ $key }}">
                                <label class="form-check-label" for="{{ $key }}">
                                  Verifikasi
                                </label>
                              </div>
                            </div>
                          </div><!-- /.col -->

                        </div>
                        @endforeach
                      @endif


                        {{-- @foreach ($nama as $key => $item)
                        <div class="row">

                          <div class="col-md-6">
                            <div class="form-group">
                              <p>{{ $item }} </p>
                            </div>
                          </div><!-- /.col -->

                          <div class="col-md-2">
                            <div class="form-group">
                              <div class="form-check">
                                <input type="hidden" value="0" name="{{ $key }}">
                                <input class="form-check-input" type="checkbox" value="1" name="{{ $key }}" id="{{ $key }}">
                                <label class="form-check-label" for="{{ $key }}">
                                  Verifikasi
                                </label>
                              </div>
                            </div>
                          </div><!-- /.col -->

                        </div>
                        @endforeach --}}

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
  //Ini fungsi ketika tombol verif dipencet
    $('.verif').click(function (event) {
        // $('input:checkbox').each(function () { this.checked = false; });
        $('.kotak').each(function () { this.checked = false; });
    });
  });


$(function () {
    $('.check_all').click(function (event) {
        //Ini fungsi ketika tombol check_all dipencet
        var selected = this.checked;
        // Iterate each checkbox
        // $(':checkbox').each(function () {    this.checked = selected; });
        $('.kotak').each(function () {  this.checked = selected; });

    });
  });
$(function () {
    $('.semua').click(function (event) {
        //Ini fungsi ketika tombol check_all dipencet
        var selected = this.checked;
        // Iterate each checkbox
        // $(':checkbox').each(function () {    this.checked = selected; });
        $('.semua_input').each(function () {  this.checked = selected; });

    });
  });

</script>
@endpush

{{-- // $(function () {
//   //Ini fungsi ketika tombol verif dipencet
//     $('.verif').click(function (event) {
//         // $('input:checkbox').each(function () { this.checked = false; });
//         $('.kotak').each(function () { this.checked = false; });
//     });
//   });


// $(function () {
//     $('.check_all').click(function (event) {
//         //Ini fungsi ketika tombol check_all dipencet
//         var selected = this.checked;
//         // Iterate each checkbox
//         // $(':checkbox').each(function () {    this.checked = selected; });
//         $('input:checkbox').each(function () {  this.checked = selected; });

//     });
//   }); --}}