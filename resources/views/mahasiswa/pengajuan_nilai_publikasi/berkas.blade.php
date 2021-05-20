@extends('template.main')
@section('title', 'Berkas Pengajuan Nilai Publikasi')
@section('content')

@if ($progress < 4)
    <p>Anda belum menyelesaikan kolokium lanjut!</p>
@elseif ($progress === 4)

<h6>Tiap file, Max: 10MB; Bertipe .jpg, .png, .pdf. Khusus untuk makalah/paper pengajuan nilai publikasi adalah : .docx</h6>

<form action="{{ route('pengajuan_publikasi_berkas_upload') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="content">
        <div class="row">

            <div class="col-sm-6">
                <input type="hidden" class="form-control" name="check_admin" value={{ $check_admin }}>
                <input type="hidden" class="form-control" name="id_mhs" value={{ $mhs[0]->id }}>
                <input type="hidden" class="form-control" name="nim_mhs" value={{ $mhs[0]->nim }}>

                <label class="mt-3" for='makalah'>1. Makalah/Paper</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="makalah" name="makalah">
                    <label class="custom-file-label" for="makalah">Pilih File</label>
                    <div class="text-danger">
                        @error('makalah')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <label class="mt-3" for='letter_of_acceptance'>2. Letter of Acceptance</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="letter_of_acceptance" name="letter_of_acceptance">
                    <label class="custom-file-label" for="letter_of_acceptance">Pilih File</label>
                    <div class="text-danger">
                        @error('letter_of_acceptance')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <label class="mt-3" for='scan_ijazah'>3. Scan Ijasah SLTA/SMA</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="scan_ijazah" name="scan_ijazah">
                    <label class="custom-file-label" for="scan_ijazah">Pilih File</label>
                    <div class="text-danger">
                        @error('scan_ijazah')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <label class="mt-3" for='transkrip_nilai'>4. Transkrip nilai yang telah dilegalisir</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="transkrip_nilai" name="transkrip_nilai">
                    <label class="custom-file-label" for="transkrip_nilai">Pilih File</label>
                    <div class="text-danger">
                        @error('transkrip_nilai')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <label class="mt-3" for='tagihan_pembayaran'>5. Tagihan Pembayaran</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="tagihan_pembayaran" name="tagihan_pembayaran">
                    <label class="custom-file-label" for="tagihan_pembayaran">Pilih File</label>
                    <div class="text-danger">
                        @error('tagihan_pembayaran')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <label class="mt-3" for='transkrip_poin'>6. Transkrip Poin Keaktifan</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="transkrip_poin" name="transkrip_poin">
                    <label class="custom-file-label" for="transkrip_poin">Pilih File</label>
                    <div class="text-danger">
                        @error('transkrip_poin')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <label class="mt-3" for='kartu_studi'>7. Kartu Studi</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="kartu_studi" name="kartu_studi">
                    <label class="custom-file-label" for="kartu_studi">Pilih File</label>
                    <div class="text-danger">
                        @error('kartu_studi')
                        {{ $message }}
                        @enderror
                    </div>
                </div>
                <label class="mt-3" for='cek_plagiasi'>8. Hasil cek plagiasi Turnitin</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input col-sm-6" id="cek_plagiasi" name="cek_plagiasi">
                    <label class="custom-file-label" for="cek_plagiasi">Pilih File</label>
                    <div class="text-danger">
                        @error('cek_plagiasi')
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
                        Apakah anda yakin ingin mengupload berkas Pengajuan Nilai Publikasi? 
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
@elseif($progress > 4)
    {{-- @if ($progress === 5)
        <p>Anda sudah mengupload berkas pengajuan nilai publikasi, silahkan menunggu admin memverifikasi berkas anda</p>
    @else
        <p>Selamat, Anda telah menyelesaikan skripsi anda!.</p>
    @endif --}}

    @if ($check_admin > 0 && ($check_admin == $pengajuan_publikasi_status[0]->check_mhs_send))
    <h6>Tiap file, Max: 10MB; Bertipe .jpg, .png, .pdf. Khusus untuk makalah/paper pengajuan nilai publikasi adalah : .docx</h6>
    <h6>Silahkan upload berkas yang tidak terverifikasi oleh Admin</h6>
    <form action="{{ route('pengajuan_publikasi_berkas_upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <div class="content">
            <div class="row">
    
                <div class="col-sm-6">
                    
                    <input type="hidden" class="form-control" name="check_admin" value={{ $check_admin }}>
                    <input type="hidden" class="form-control" name="id_mhs" value={{ $mhs[0]->id }}>
                    <input type="hidden" class="form-control" name="nim_mhs" value={{ $mhs[0]->nim }}>
                    @foreach ($nama_field as $key => $value)
                    <input type="hidden" class="form-control" name="{{ $value }}" value={{ $pengajuan_publikasi_status[0]->$value }}>
                    @if ($pengajuan_publikasi_status[0]->$value == 0)
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
                            Apakah anda yakin ingin mengupload berkas Pengajuan Nilai Publikasi yang tidak terverifikasi? 
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
    @elseif($check_admin == 0 && ($check_admin < $pengajuan_publikasi_status[0]->check_mhs_send))
        <p>Anda sudah mengupload berkas pengajuan nilai publikasi, silahkan menunggu admin memverifikasi berkas anda</p>
    @elseif($check_admin > 0 && ($check_admin < $pengajuan_publikasi_status[0]->check_mhs_send))
        <p>Anda sudah mengupload berkas pengajuan nilai publikasi yang tidak terverifikasi, silahkan menunggu admin memverifikasi berkas anda</p>
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
            @if ($check_admin == 0 || $check_admin == null)
                @if ($pengajuan_publikasi_status[0]->$key == null)
                    Belum Terverifikasi
                @else
                    Terverifikasi
                @endif
            @elseif ($check_admin > 0)
                @if ($pengajuan_publikasi_status[0]->$key == 0)
                    Tidak Terverifikasi
                @else
                    Terverifikasi
                @endif  
                
            @endif
                
            </td>
        </tr>
        @endforeach
    </tbody>
    </table>
@endif
@endsection