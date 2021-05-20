@extends('template.main')
@section('title', 'Berkas Kolokium Awal')
@section('content')
@if ($progress === null)
<p>Anda belum memilh dosen pembimbing!</p>
@elseif ($progress === 0)
    <h6>Tiap file, Max: 10MB; Bertipe .jpg, .png, .pdf. Khusus untuk proposal awal adalah : .docx</h6>
    
    <form action="{{ route('kolokium_awal_berkas_upload') }}" method="POST" enctype="multipart/form-data">
        @csrf
    
        <div class="content">
            <div class="row">
    
                <div class="col-sm-6">
                    <input type="hidden" class="form-control" name="check_korkon" value={{ $check_korkon }}>
                    {{-- <input type="hidden" class="form-control" name="check_korkon" value={{ $kolokium_awal_status[0]->check_korkon }}> --}}
                    <input type="hidden" class="form-control" name="id_mhs" value={{ $mhs[0]->id }}>
                    <input type="hidden" class="form-control" name="nim_mhs" value={{ $mhs[0]->nim }}>
                    <label class="mt-3" for='kartu_studi_tetap'>1. Kartu Studi Tetap (KST) </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input col-sm-6" id="kartu_studi_tetap" name="kartu_studi_tetap">
                        <label class="custom-file-label" for="kartu_studi_tetap">Pilih File</label>
                        <div class="text-danger">
                            @error('kartu_studi_tetap')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <label class="mt-3" for='transkrip_nilai'>2. Transkrip Nilai </label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input col-sm-6" id="transkrip_nilai" name="transkrip_nilai">
                        <label class="custom-file-label" for="transkrip_nilai">Pilih File</label>
                        <div class="text-danger">
                            @error('transkrip_nilai')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <label class="mt-3" for='form_pengajuan_ta'>3. Form Pengajuan Tugas Akhir</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input col-sm-6" id="form_pengajuan_ta" name="form_pengajuan_ta">
                        <label class="custom-file-label" for="form_pengajuan_ta">Pilih File</label>
                        <div class="text-danger">
                            @error('form_pengajuan_ta')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <label class="mt-3" for='tagihan_pembayaran'>4. Tagihan Pembayaran</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input col-sm-6" id="tagihan_pembayaran" name="tagihan_pembayaran">
                        <label class="custom-file-label" for="tagihan_pembayaran">Pilih File</label>
                        <div class="text-danger">
                            @error('tagihan_pembayaran')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <label class="mt-3" for='proposal_awal'>5. Proposal Skripsi Awal</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input col-sm-6" id="proposal_awal" name="proposal_awal">
                        <label class="custom-file-label" for="proposal_awal">Pilih File</label>
                        <div class="text-danger">
                            @error('proposal_awal')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <label class="mt-3" for='lembar_reviewer'>6. Lembar Usulan Reviewer</label>
                    <div class="custom-file">
                        <input type="file" class="custom-file-input col-sm-6" id="lembar_reviewer" name="lembar_reviewer">
                        <label class="custom-file-label" for="lembar_reviewer">Pilih File</label>
                        <div class="text-danger">
                            @error('lembar_reviewer')
                            {{ $message }}
                            @enderror
                        </div>
                    </div>
            
                    <label for="tipe_korkon" class="mt-3">Pilih Korkon</label>
                    <select class="browser-default custom-select rounded-0 mt-2" id='tipe_korkon' name="tipe_korkon">
                        @foreach ($korkon_list as $korkon => $data)
                            <option value={{ $korkon }}>{{ $data }}</option>
                        @endforeach
                    </select>
                    <div class="text-danger">
                        @error('tipe_korkon')
                        {{ $message }}
                        @enderror
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
                            Apakah anda yakin ingin mengupload berkas Kolokium Awal? 
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
    
    


@elseif ($progress > 0)
    {{-- @if ($progress === 1)
        <p>Anda sudah mengupload berkas kolokium awal, silahkan menunggu korkon memverifikasi berkas anda</p>
    @else
        <p>Anda sudah  menyelesaikan kolokium awal.</p>
    @endif --}}
    @if ($check_korkon > 0 && ($check_korkon == $kolokium_awal_status[0]->check_mhs_send))
        <h6>Tiap file, Max: 10MB; Bertipe .jpg, .png, .pdf. Khusus untuk proposal awal adalah : .docx</h6>
        <h6>Silahkan upload berkas yang tidak terverifikasi oleh Korkon</h6>
        
        <form action="{{ route('kolokium_awal_berkas_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
        
            <div class="content">
                <div class="row">
        
                    <div class="col-sm-6">
                        
                        <input type="hidden" class="form-control" name="check_korkon" value={{ $check_korkon }}>
                        {{-- <input type="hidden" class="form-control" name="check_korkon" value={{ $kolokium_awal_status[0]->check_korkon }}> --}}
                        <input type="hidden" class="form-control" name="id_mhs" value={{ $mhs[0]->id }}>
                        <input type="hidden" class="form-control" name="nim_mhs" value={{ $mhs[0]->nim }}>
                        @foreach ($nama_field as $key => $value)
                        <input type="hidden" class="form-control" name="{{ $value }}" value={{ $kolokium_awal_status[0]->$value }}>
                        @if ($kolokium_awal_status[0]->$value == 0)
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
                                Apakah anda yakin ingin mengupload berkas Kolokium Awal yang tidak terverifikasi? 
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
        @elseif($check_korkon == 0 && ($check_korkon < $kolokium_awal_status[0]->check_mhs_send))
            <p>Anda sudah mengupload berkas kolokium awal, silahkan menunggu korkon memverifikasi berkas anda</p>
        @elseif($check_korkon > 0 && ($check_korkon < $kolokium_awal_status[0]->check_mhs_send))
            <p>Anda sudah mengupload berkas kolokium awal yang tidak terverifikasi, silahkan menunggu korkon memverifikasi berkas anda</p>
        
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
                    {{-- {{ dd($kolokim_awal_status[0]->$key) }} --}}
                    @if ($check_korkon == 0 || $check_korkon == null)
                        @if ($kolokium_awal_status[0]->$key == null)
                            Belum Terverifikasi
                        @else
                            Terverifikasi
                        @endif
                    @elseif ($check_korkon > 0)
                        @if ($kolokium_awal_status[0]->$key == 0)
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