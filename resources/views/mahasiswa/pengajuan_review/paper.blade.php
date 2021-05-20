@extends('template.main')
@section('title', 'Paper Pengajuan Review')
@section('content')

@if ($mhs[0]->progress < 4)
    <h6>Anda belum menyelesaikan kolokium lanjut</h6>
@else

    @if ($cond === 1)
        <h6>Silahkan mengupload paper pengajuan review anda. Format file : .docx. Maksimum size: 10MB</h6>
        <form action="{{ route('pengajuan_review_paper_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">

                            <label class="mt-1" for='file_paper'>Upload Paper Pengajuan Review</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input col-sm-6 @error('file_paper') is-invalid @enderror" id="file_paper" name="file_paper">
                                <label class="custom-file-label" for="file_paper">Pilih File</label>
                                @error('file_paper')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="komentar" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama paper (Optional)" id="komentar" name="komentar"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Paper</button>
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
                                    Apakah anda yakin ingin mengupload paper pengajuan review? 
                                    <br>
                                    (Data yang tersimpan tidak bisa diubah lagi)
                                    </div>
                                        
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Paper</button>
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
        <p>Anda sudah mengupload paper pengajuan review, silahkan menunggu dosen pembimbing memverifikasi dan mengecek paper pengajuan review anda!</p>
        <p>Status : </p>
        <p>Dosen 1 : 
            @if ($data_review_seen_last->check1 === 0)
                Belum mengecek 
            @else
                Sudah dicek
            @endif
        </p>
        <p>Dosen 2 : 
            @if ($data_review_seen_last->check2 === 0)
                Belum mengecek
            @else
                Sudah Dicek
            @endif
        </p>
    @elseif ($cond === 3)
        <p>Anda sudah mengupload revisi paper pengajuan review, silahkan menunggu dosen pembimbing memverifikasi dan mengecek revisi anda!</p>
        <p>Status : </p>
        <p>Dosen 1 : 
            @if ($data_review_seen_last->check1 === 0)
                Belum mengecek  
            @else
                Sudah Dicek
            @endif
        </p>
        <p>Dosen 2 : 
            @if ($data_review_seen_last->check2 === 0)
                Belum mengecek
            @else
                Sudah Dicek
            @endif
        </p>
    @elseif ($cond === 4)
        <h6>Silahkan mengupload revisi paper pengajuan review anda. Format file : .docx. Maksimum size: 10MB</h6>
        <form action="{{ route('pengajuan_review_paper_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">

                            <label class="mt-1" for='file_paper'>Upload Revisi Paper Pengajuan Review</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input col-sm-6 @error('file_paper') is-invalid @enderror" id="file_paper" name="file_paper">
                                <label class="custom-file-label" for="file_paper">Pilih File</label>
                                @error('file_paper')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="komentar" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama paper (Optional)" id="komentar" name="komentar"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Revisi Paper</button>
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
                                    Apakah anda yakin ingin mengupload revisi paper pengajuan review? 
                                    <br>
                                    (Data yang tersimpan tidak bisa diubah lagi)
                                    </div>
                                        
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Revisi Paper</button>
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
        <p>Paper anda sudah di setujui oleh dosen 1 dan dosen 2. Silahkan lanjut dengan mengupload berkas pengajuan review anda pada menu upload berkas pengajuan review</p>
        <p>Anda dapat mengunduh file paper yang sudah di-acc melalui tombol dibawah ini</p>
        <p>File Paper Anda: </p>
        <p><i><u>{{ $data_review_seen_last->file_paper }}</u></i></p>
        <form action="{{ route('pengajuan_review_paper_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            <input type="hidden" class="form-control" name="sender" value="{{ $data_review_seen_last->sender}}">
            <input type="hidden" class="form-control" name="file_paper" value="{{ $data_review_seen_last->file_paper}}">
            <button type="submit" class="btn btn-sm btn-info">Download</button>
        </form>
    @elseif ($cond === 6)
        <h6>Silahkan mengupload revisi hasil review dari reviewer. Format file : .docx. Maksimum size: 10MB</h6>
        <form action="{{ route('pengajuan_review_paper_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">

                            <label class="mt-1" for='file_paper'>Upload Revisi Paper Pengajuan Review</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input col-sm-6 @error('file_paper') is-invalid @enderror" id="file_paper" name="file_paper">
                                <label class="custom-file-label" for="file_paper">Pilih File</label>
                                @error('file_paper')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="komentar" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama paper (Optional)" id="komentar" name="komentar"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Revisi Paper</button>
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
                                    Apakah anda yakin ingin mengupload revisi paper? 
                                    <br>
                                    (Data yang tersimpan tidak bisa diubah lagi)
                                    </div>
                                        
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Revisi Paper</button>
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
        <p>Anda sudah mengupload revisi review paper, silahkan menunggu dosen pembimbing memverifikasi dan mengecek revisi anda!</p>
        <p>Status : </p>
        <p>Dosen 1 : 
            @if ($data_review_seen_last->check1 === 0)
                Belum mengecek  
            @else
                Sudah Dicek
            @endif
        </p>
        <p>Dosen 2 : 
            @if ($data_review_seen_last->check2 === 0)
                Belum mengecek
            @else
                Sudah Dicek
            @endif
        </p>

        @elseif ($cond === 8)
        <h6>Silahkan mengupload revisi paper pengajuan review anda. Format file : .docx. Maksimum size: 10MB</h6>
        <form action="{{ route('pengajuan_review_paper_upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
            
                <div class="content">
                    <div class="row">
                        <div class="col-sm-6">

                            <label class="mt-1" for='file_paper'>Upload Revisi Pengajuan Review</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input col-sm-6 @error('file_paper') is-invalid @enderror" id="file_paper" name="file_paper">
                                <label class="custom-file-label" for="file_paper">Pilih File</label>
                                @error('file_paper')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <label for="komentar" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama paper (Optional)" id="komentar" name="komentar"></textarea>
                            </div>

                            <div class="form-group mt-3">
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Upload Revisi Paper</button>
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
                                    Apakah anda yakin ingin mengupload revisi paper? 
                                    <br>
                                    (Data yang tersimpan tidak bisa diubah lagi)
                                    </div>
                                        
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="simpan" class="btn btn-success">Upload Revisi Paper</button>
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
            <p>Revisi review paper anda sudah di setujui oleh dosen 1 dan dosen 2. Revisi review anda otomatis masuk ke korkon. Silahkan menunggu korkon untuk memvalidasi revisi anda.</p>
            
            <p>Anda dapat mengunduh file revisi anda yang sudah di acc melalui tombol dibawah ini</p>
            <p>File Paper Anda: </p>
            <p><i><u>{{ $data_review_seen_last->file_paper }}</u></i></p>
            <form action="{{ route('pengajuan_review_paper_download') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
                <input type="hidden" class="form-control" name="sender" value="{{ $data_review_seen_last->sender}}">
                <input type="hidden" class="form-control" name="file_paper" value="{{ $data_review_seen_last->file_paper}}">
                <button type="submit" class="btn btn-sm btn-info">Download</button>
            </form>

            <hr>
            <p>Status</p>
            <p>Korkon : 
                @if ($data_review_seen_last->check_validasi_panitia_ujian === 0)
                    Belum memvalidasi  
                @else
                    Sudah memvalidasi
                @endif
            </p>


        @elseif ($cond == 10)
        {
            <p>Tidak ada revisi pada paper anda oleh reviewer. Revisi review anda otomatis masuk ke korkon. Silahkan menunggu korkon untuk memvalidasi revisi anda.</p>
            <p>Anda dapat mengunduh file revisi anda yang sudah di acc melalui tombol dibawah ini</p>
            <p>File Paper Anda: </p>
            <p><i><u>{{ $data_review_seen_last->file_paper }}</u></i></p>
            <form action="{{ route('pengajuan_review_paper_download') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="name_mhs" value={{ $mhs[0]->name }}>
                <input type="hidden" class="form-control" name="sender" value="{{ $data_review_seen_last->sender}}">
                <input type="hidden" class="form-control" name="file_paper" value="{{ $data_review_seen_last->file_paper}}">
                <button type="submit" class="btn btn-sm btn-info">Download</button>
            </form>
        }

    @endif


    @if ($cond!== 1)
        <label for="tabel_review" class="mt-5">Tabel History Paper Pengajuan Review</label>
        <table class='table table-bordered' id="tabel_review">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Revisi Ke</th>
                    <th>File Paper</th>
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
                @foreach($data_review as $key => $data)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>
                        @if ($data->nomor_revisi == 0)
                            -
                        @elseif ($data->nomor_revisi > 0)
                            {{ $data->nomor_revisi }}
                        @endif
                        
                    </td>
                    <td>{{$data->file_paper}}</td>
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
                        <form action="{{ route('pengajuan_review_paper_download') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" class="form-control" name="sender" value="{{ $data->sender}}">
                            <input type="hidden" class="form-control" name="file_paper" value="{{ $data->file_paper}}">
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