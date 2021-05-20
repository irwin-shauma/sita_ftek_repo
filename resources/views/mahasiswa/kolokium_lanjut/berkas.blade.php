@extends('template.main')
@section('title', 'Berkas Kolokium Lanjut')
@section('content')

@if ($progress < 2)
    <p>Anda belum menyelesaikan Kolokium Awal!</p>
@elseif ($progress === 2)

<h6>Tiap file, Max: 10MB; Bertipe .jpg, .png, .pdf. Khusus untuk proposal lanjut adalah : .docx</h6>

<form action="{{ route('kolokium_lanjut_berkas_upload') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="content">
        <div class="row">

            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="check_korkon" value={{ $check_korkon }}>
                <input type="hidden" class="form-control" name="tipe_korkon" value={{ $tipe_korkon[0] }}>
                <input type="hidden" class="form-control" name="id_mhs" value={{ $mhs[0]->id }}>
                <input type="hidden" class="form-control" name="nim_mhs" value={{ $mhs[0]->nim }}>
                <label class="mt-3" for='proposal_lanjut'>1. Proposal Lanjut</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="proposal_lanjut" name="proposal_lanjut">
                    <label class="custom-file-label" for="proposal_lanjut">Pilih File</label>
                    <div class="text-danger">
                        @error('proposal_lanjut')
                        {{ $message }}
                        @enderror
                    </div>
                </div>

                <label class="mt-3" for='surat_tugas'>2. Scan Surat Tugas</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="surat_tugas" name="surat_tugas">
                    <label class="custom-file-label" for="surat_tugas">Pilih File</label>
                    <div class="text-danger">
                        @error('surat_tugas')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <div class="form-group mt-3">
                    <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Berkas</button>
                </div>

                {{-- Modal Begin --}}
                <div class="modal fade" id="modal_simpan">
                    <div class="modal-dialog">
                    <div class="modal-content bg-white">
            
                        <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
            
                        <div class="modal-body">
                        Apakah anda yakin ingin mengupload berkas Kolokium Lanjut? 
                        <br>
                        (Data yang tersimpan tidak bisa diubah lagi)
                        </div>
                            
                        <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                        <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Berkas</button>
                        </div>
            
                    </div>
                    <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                {{-- Modal End --}}


            </div>
        </div>
    </div>

</form>

@elseif ($progress > 2)
    {{-- @if ($progress === 3)
        <p>Anda sudah mengupload berkas kolokium lanjut, silahkan menunggu korkon memverifikasi berkas anda</p>
    @else
        <p>Anda sudah  menyelesaikan kolokium lanjut.</p>
    @endif --}}
    @if ($check_korkon > 0 && ($check_korkon == $kolokium_lanjut_status[0]->check_mhs_send))
    <h6>Tiap file, Max: 10MB; Bertipe .jpg, .png, .pdf. Khusus untuk proposal lanjut adalah : .docx</h6>
    <h6>Silahkan upload berkas yang tidak terverifikasi oleh Korkon</h6>
    
    <form action="{{ route('kolokium_lanjut_berkas_upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <div class="content">
            <div class="row">
    
                <div class="col-sm-6">
                    
                    <input type="hidden" class="form-control" name="check_korkon" value={{ $check_korkon }}>
                    {{-- <input type="hidden" class="form-control" name="check_korkon" value={{ $kolokium_awal_status[0]->check_korkon }}> --}}
                    <input type="hidden" class="form-control" name="id_mhs" value={{ $mhs[0]->id }}>
                    <input type="hidden" class="form-control" name="nim_mhs" value={{ $mhs[0]->nim }}>
                    @foreach ($nama_field as $key => $value)
                    <input type="hidden" class="form-control" name="{{ $value }}" value={{ $kolokium_lanjut_status[0]->$value }}>
                    @if ($kolokium_lanjut_status[0]->$value == 0)
                    <label class="mt-3" for={{ $key }}>{{ $loop->iteration }}. {{ $check_nama[$value] }} </label>
                    <div class="custom-file">
                            <input type="file" class="custom-file-input col-sm-6" id={{ $key }} name={{ $key }}>
                            <label class="custom-file-label" for={{ $key }}>Pilih File</label>
                            <div class="text-danger">
                                @error($key)
                                {{ $message }}
                                @enderror
                            </div>
                        </div>
                        @endif   
                    @endforeach
            
                    <div class="form-group mt-3">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Berkas</button>
                    </div>
    

                    {{-- Modal Begin --}}
                    <div class="modal fade" id="modal_simpan">
                        <div class="modal-dialog">
                        <div class="modal-content bg-white">
                
                            <div class="modal-header">
                            <h4 class="modal-title">Konfirmasi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                
                            <div class="modal-body">
                            Apakah anda yakin ingin mengupload berkas Kolokium Lanjut yang tidak terverifikasi? 
                            <br>
                            (Data yang tersimpan tidak bisa diubah lagi)
                            </div>
                                
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Berkas</button>
                            </div>
                
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    {{-- Modal End --}}


                </div>
            </div>
        </div>
    
    </form>
    @elseif($check_korkon == 0 && ($check_korkon < $kolokium_lanjut_status[0]->check_mhs_send))
        <p>Anda sudah mengupload berkas kolokium lanjut, silahkan menunggu korkon memverifikasi berkas anda</p>
    @elseif($check_korkon > 0 && ($check_korkon < $kolokium_lanjut_status[0]->check_mhs_send))
        <p>Anda sudah mengupload berkas kolokium lanjut yang tidak terverifikasi, silahkan menunggu korkon memverifikasi berkas anda</p>
    @endif

    <p>Tabel Status Verifikasi</p>
    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>No</th>
                <th>Berkas</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($check_nama as $key => $data)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data}}</td>
                <td>
                    @if ($check_korkon == 0 || $check_korkon == null)
                        @if ($kolokium_lanjut_status[0]->$key == null)
                            Belum Terverifikasi
                        @else
                            Terverifikasi
                        @endif
                    @elseif ($check_korkon > 0)
                        @if ($kolokium_lanjut_status[0]->$key == 0)
                            Tidak Terverifikasi
                        @else
                            Terverifikasi
                        @endif  
                        
                    @endif
                    
                </td>
            </tr>
            @endforeach
        </tbody>




        {{-- <tbody>
            @foreach($nama as $key => $data)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$data}}</td>
                <td>
                    @if ($kolokium_lanjut_status[0]->$key == null)
                        Belum Terverifikasi
                    @else
                        Terverifikasi
                    @endif
                    
                </td>
            </tr>
            @endforeach
        </tbody> --}}
    </table>
@endif
@endsection