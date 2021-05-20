@extends('template.main')
@section('title', 'Proposal Awal')
@section('content')

@if ($mhs[0]->progress === null)
    <h6>Anda belum memilih dosen pembimbing</h6>
@else
    @if ($cond === 1)
        <h6>Silahkan mengupload proposal awal anda. Format file : .docx. Maksimum size: 10MB</h6>
        <form action="{{ route('kolokium_awal_proposal_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">

                            <label class="mt-1" for='file_proposal'>Upload Proposal Awal</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input col-sm-6 @error('file_proposal') is-invalid @enderror" id="file_proposal" name="file_proposal">
                                <label class="custom-file-label" for="file_proposal">Pilih File</label>
                                @error('file_proposal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="komentar" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama proposal (Optional)" id="komentar" name="komentar"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Proposal</button>
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
                                    Apakah anda yakin ingin mengupload proposal awal? 
                                    <br>
                                    (Data yang tersimpan tidak bisa diubah lagi)
                                    </div>
                                        
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Proposal</button>
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
    @elseif ($cond === 2)
        <p>Anda sudah mengupload proposal awal, silahkan menunggu dosen pembimbing memverifikasi dan mengecek proposal awal anda!</p>
        <p>Status : </p>
        <p>Dosen 1 : 
            @if ($data_proposal_seen_last->check1 === 0)
                Belum mengecek 
            @else
                Sudah dicek
            @endif
        </p>
        <p>Dosen 2 : 
            @if ($data_proposal_seen_last->check2 === 0)
                Belum mengecek
            @else
                Sudah Dicek
            @endif
        </p>
    @elseif ($cond === 3)
        <p>Anda sudah mengupload revisi proposal awal, silahkan menunggu dosen pembimbing memverifikasi dan mengecek revisi anda!</p>
        <p>Status : </p>
        <p>Dosen 1 : 
            @if ($data_proposal_seen_last->check1 === 0)
                Belum mengecek  
            @else
                Sudah Dicek
            @endif
        </p>
        <p>Dosen 2 : 
            @if ($data_proposal_seen_last->check2 === 0)
                Belum mengecek
            @else
                Sudah Dicek
            @endif
        </p>
    @elseif ($cond === 4)
        <h6>Silahkan mengupload revisi proposal awal anda. Format file : .docx. Maksimum size: 10MB</h6>
        <form action="{{ route('kolokium_awal_proposal_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">

                            <label class="mt-1" for='file_proposal'>Upload Revisi Proposal Awal</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input col-sm-6 @error('file_proposal') is-invalid @enderror" id="file_proposal" name="file_proposal">
                                <label class="custom-file-label" for="file_proposal">Pilih File</label>
                                @error('file_proposal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="komentar" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama proposal (Optional)" id="komentar" name="komentar"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Revisi Proposal</button>
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
                                    Apakah anda yakin ingin mengupload revisi proposal? 
                                    <br>
                                    (Data yang tersimpan tidak bisa diubah lagi)
                                    </div>
                                        
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Revisi Proposal</button>
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

    @elseif ($cond === 5)
        <p>Proposal anda sudah di setujui oleh dosen 1 dan dosen 2. Silahkan lanjut dengan mengupload berkas kolokium awal anda pada menu upload berkas kolokium awal.</p>
        <p>Anda dapat mengunduh file proposal yang sudah di-acc melalui tombol dibawah ini</p>
        <p>File Proposal Anda: </p>
        <p><i><u>{{ $data_proposal_seen_last->file_proposal }}</u></i></p>
        <form action="{{ route('kolokium_awal_proposal_download') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            <input type="hidden" class="form-control" name="sender" value="{{ $data_proposal_seen_last->sender}}">
            <input type="hidden" class="form-control" name="file_proposal" value="{{ $data_proposal_seen_last->file_proposal}}">
            <button type="submit" class="btn btn-sm btn-info">Download</button>
        </form>
    @elseif ($cond === 6)
        <h6>Silahkan mengupload revisi hasil review dari reviewer. Format file : .docx. Maksimum size: 10MB</h6>
        <form action="{{ route('kolokium_awal_proposal_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">

                            <label class="mt-1" for='file_proposal'>Upload Revisi Proposal Awal</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input col-sm-6 @error('file_proposal') is-invalid @enderror" id="file_proposal" name="file_proposal">
                                <label class="custom-file-label" for="file_proposal">Pilih File</label>
                                @error('file_proposal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="komentar" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama proposal (Optional)" id="komentar" name="komentar"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Revisi Proposal</button>
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
                                    Apakah anda yakin ingin mengupload revisi proposal? 
                                    <br>
                                    (Data yang tersimpan tidak bisa diubah lagi)
                                    </div>
                                        
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Revisi Proposal</button>
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
        @elseif ($cond === 7)
        <p>Anda sudah mengupload revisi review proposal, silahkan menunggu dosen pembimbing memverifikasi dan mengecek revisi anda!</p>
        <p>Status : </p>
        <p>Dosen 1 : 
            @if ($data_proposal_seen_last->check1 === 0)
                Belum mengecek  
            @else
                Sudah Dicek
            @endif
        </p>
        <p>Dosen 2 : 
            @if ($data_proposal_seen_last->check2 === 0)
                Belum mengecek
            @else
                Sudah Dicek
            @endif
        </p>

        @elseif ($cond === 8)
        <h6>Silahkan mengupload revisi proposal awal anda. Format file : .docx. Maksimum size: 10MB</h6>
        <form action="{{ route('kolokium_awal_proposal_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">

                            <label class="mt-1" for='file_proposal'>Upload Revisi Proposal Awal</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input col-sm-6 @error('file_proposal') is-invalid @enderror" id="file_proposal" name="file_proposal">
                                <label class="custom-file-label" for="file_proposal">Pilih File</label>
                                @error('file_proposal')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="komentar" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama proposal (Optional)" id="komentar" name="komentar"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Revisi Proposal</button>
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
                                    Apakah anda yakin ingin mengupload revisi proposal? 
                                    <br>
                                    (Data yang tersimpan tidak bisa diubah lagi)
                                    </div>
                                        
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Revisi Proposal</button>
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
        @elseif ($cond === 9)
            <p>Revisi review proposal anda sudah di setujui oleh dosen 1 dan dosen 2. Revisi review anda otomatis masuk ke korkon. Silahkan menunggu korkon untuk memvalidasi revisi anda.</p>
            {{-- <p>Revisi review proposal anda sudah di setujui oleh dosen 1 dan dosen 2. Silahkan lanjut dengan mengupload revisi tersebut di halaman upload berkas kolokium awal.</p> --}}
            <p>Anda dapat mengunduh file revisi anda yang sudah di acc melalui tombol dibawah ini</p>
            <p>File Proposal Anda: </p>
            <p><i><u>{{ $data_proposal_seen_last->file_proposal }}</u></i></p>
            <form action="{{ route('kolokium_awal_proposal_download') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
                <input type="hidden" class="form-control" name="sender" value="{{ $data_proposal_seen_last->sender}}">
                <input type="hidden" class="form-control" name="file_proposal" value="{{ $data_proposal_seen_last->file_proposal}}">
                <button type="submit" class="btn btn-sm btn-info">Download</button>
            </form>

            <hr>
            <p>Status</p>
            <p>Korkon : 
                @if ($data_proposal_seen_last->check_validasi_korkon === 0)
                    Belum memvalidasi  
                @else
                    Sudah memvalidasi
                @endif
            </p>


        @elseif ($cond == 10)
        {
            <p>Tidak ada revisi pada proposal anda oleh reviewer. Revisi review anda otomatis masuk ke korkon. Silahkan menunggu korkon untuk memvalidasi revisi anda.</p>
            <p>Anda dapat mengunduh file revisi anda yang sudah di acc melalui tombol dibawah ini</p>
            <p>File Proposal Anda: </p>
            <p><i><u>{{ $data_proposal_seen_last->file_proposal }}</u></i></p>
            <form action="{{ route('kolokium_awal_proposal_download') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
                <input type="hidden" class="form-control" name="sender" value="{{ $data_proposal_seen_last->sender}}">
                <input type="hidden" class="form-control" name="file_proposal" value="{{ $data_proposal_seen_last->file_proposal}}">
                <button type="submit" class="btn btn-sm btn-info">Download</button>
            </form>
        }

    @endif


    @if ($cond!== 1)
        <label for="tabel_proposal" class="mt-5">Tabel History Proposal Awal</label>
        {{-- <p>Tabel Data Proposal</p> --}}
        <table class='table table-bordered' id="tabel_proposal">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Revisi Ke</th>
                    <th>File Proposal</th>
                    <th>Pesan/Komentar</th>
                    <th>Pengirim</th>
                    <th>Tanggal</th>
                    <th>Persetujuan Dosen 1</th>
                    <th>Persetujuan Dosen 2</th>
                    <th>Persetujuan Reviewer 1</th>
                    <th>Persetujuan Reviewer 2</th>
                    <th>Download</th>

                </tr>
            </thead>
            <tbody>
                @foreach($data_proposal as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        @if ($data->nomor_revisi == 0)
                            -
                        @elseif ($data->nomor_revisi > 0)
                            {{ $data->nomor_revisi }}
                        @endif
                        
                    </td>
                    <td>{{$data->file_proposal}}</td>
                    <td>{!!$data->komentar!!}</td>
                    <td>
                        @if ($data->sender == 1)
                            Pembimbing 1
                        @elseif ($data->sender == 2)
                            Pembimbing 2
                        @else
                            {{$data->sender}}
                        @endif
                        
                    </td>
                    <td>{{$data->created_at}}</td>
                    <td>
                        {{-- {{ $data->acc1 }} --}}
                        @if ($data->acc1 == 0)
                            -
                        @else
                            <i class="fas fa-check"></i>
                        @endif
                    </td>
                    <td>
                        {{-- {{ $data->acc2 }} --}}
                        @if ($data->acc2 == 0)
                            -
                        @else
                            <i class="fas fa-check"></i>
                        @endif
                    </td>
                    <td>
                        {{-- {{ $data->acc2 }} --}}
                        @if ($data->review_acc1 == 0)
                            -
                        @else
                            <i class="fas fa-check"></i>
                        @endif
                    </td>
                    <td>
                        {{-- {{ $data->review_acc2 }} --}}
                        @if ($data->review_acc2 == 0)
                            -
                        @else
                            <i class="fas fa-check"></i>
                        @endif
                    </td>

                    <td>
                        <form action="{{ route('kolokium_awal_proposal_download') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>

                            <input type="hidden" class="form-control" name="sender" value="{{ $data->sender}}">
                            <input type="hidden" class="form-control" name="file_proposal" value="{{ $data->file_proposal}}">
                            <button type="submit" class="btn btn-sm btn-info">Download</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
            
    @endif

@endif

@endsection