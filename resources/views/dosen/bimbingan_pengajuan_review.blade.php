@extends('template.main')
@section('title', 'Bimbingan Pengajuan Review')
@section('content')
    <label for="tabel_paper">Tabel Paper Pengajuan Review Pembimbing 1</label>
    <table class='table table-bordered' id="example1">
        <thead>
            <tr>
                <th>No</th>
                <th>Mahasiswa</th>
                <th>NIM</th>
                <th>Revisi Ke</th>
                <th>File paper</th>
                <th>Pesan/Komentar</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
            <tbody>

                @if ($mhs_dosen1 !== 'empty' && $data_paper_dosen1 !== 'empty')
                    @foreach($data_paper_dosen1 as $data1)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $mhs_dosen1[$loop->index]->name }}</td>
                        <td>{{ $mhs_dosen1[$loop->index]->nim }}</td>
                        <td>{{ $data1->nomor_revisi }}</td>
                        <td>{{ $data1->file_paper }}</td>
                        <td>{{ $data1->komentar }}</td>
                        <td>{{ $data1->updated_at }}</td>
                        <td>
                            <form action="{{ route('bimbingan_pengajuan_review_action') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" name="file_paper" value="{{ $data1->file_paper }}">
                            <input type="hidden" class="form-control" name="id_mhs" value="{{ $mhs_dosen1[$loop->index]->id }}">
                            <input type="hidden" class="form-control" name="nim" value="{{ $mhs_dosen1[$loop->index]->nim }}">
                            <input type="hidden" class="form-control" name="pembimbing_ke" value="1">
                            <input type="hidden" class="form-control" name="name_mhs" value="{{ $mhs_dosen1[$loop->index]->name }}">
 
                            <button type="submit" class="btn btn-sm btn-info" formaction="{{ route('bimbingan_pengajuan_review_download') }}">Download</button>
                                
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_revisi1">Revisi</button>
                            <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_setujui1">Setujui</button>
    
    
                            <!-- Modal -->
                            <div class="modal fade" id="modal_revisi1">
                                <div class="modal-dialog">
                                <div class="modal-content bg-white">
    
                                    <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="file_revisi">Upload Revisi</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input col-sm-6 @error('file_revisi') is-invalid @enderror" id="file_revisi" name="file_revisi">
                                            <label class="custom-file-label" for="file_revisi">Pilih File</label>
                                            @error('file_revisi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <label for="komentar_pembimbing" class="mt-3">Pesan/Komentar</label>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama revisi (Optional)" id="komentar_pembimbing" name="komentar_pembimbing"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="revisi" class="btn btn-success">Revisi</button>
                                    </div>
                                </div>
                                </div>
                            </div>
    
    
                            <!-- Modal -->
                            <div class="modal fade" id="modal_setujui1">
                                <div class="modal-dialog">
                                <div class="modal-content bg-white">
    
                                    <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda ingin menyetujui paper ini?
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="setujui" class="btn btn-success">Setujui</button>
                                    </div>
                                </div>
                                </div>
                            </div>
    
                            </form>
                        
                        </td>
                    </tr>
                    @endforeach
    
                @endif
            </tbody>
        </thead>

    </table>
    <label for="tabel_paper" class="mt-5">Tabel Paper Pengajuan Review Pembimbing 2</label>
    <table class='table table-bordered' id="example2">
        <thead>
            <tr>
                <th>No</th>
                <th>Mahasiswa</th>
                <th>NIM</th>
                <th>Revisi Ke</th>
                <th>File paper</th>
                <th>Pesan/Komentar</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
            <tbody>

                @if ($mhs_dosen2 !== 'empty' && $data_paper_dosen2 !== 'empty')
                
                @foreach($data_paper_dosen2 as $data2)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{ $mhs_dosen2[$loop->index]->name }}</td>
                    <td>{{ $mhs_dosen2[$loop->index]->nim }}</td>
                    <td>{{ $data2->nomor_revisi }}</td>
                    <td>{{ $data2->file_paper }}</td>
                    <td>{{ $data2->komentar }}</td>
                    <td>{{ $data2->updated_at }}</td>
                    <td>
                        
                        <form action="{{ route('bimbingan_pengajuan_review_action') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" class="form-control" name="file_paper" value="{{ $data2->file_paper }}">
                            <input type="hidden" class="form-control" name="id_mhs" value="{{ $mhs_dosen2[$loop->index]->id }}">
                            <input type="hidden" class="form-control" name="nim" value="{{ $mhs_dosen2[$loop->index]->nim }}">
                            <input type="hidden" class="form-control" name="pembimbing_ke" value="2">
                            <input type="hidden" class="form-control" name="name_mhs" value="{{ $mhs_dosen2[$loop->index]->name }}">
                            <button type="submit" class="btn btn-sm btn-info" formaction="{{ route('bimbingan_pengajuan_review_download') }}">Download</button>
                            
                            <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_revisi2">Revisi</button>
                            <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_setujui2">Setujui</button>
    
    
                            <!-- Modal -->
                            <div class="modal fade" id="modal_revisi2">
                                <div class="modal-dialog">
                                <div class="modal-content bg-white">
    
                                    <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        <label for="file_revisi">Upload Revisi</label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input col-sm-6 @error('file_revisi') is-invalid @enderror" id="file_revisi" name="file_revisi">
                                            <label class="custom-file-label" for="file_revisi">Pilih File</label>
                                            @error('file_revisi')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <label for="komentar_pembimbing" class="mt-3">Pesan/Komentar</label>
                                        <div class="form-group">
                                            <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama revisi (Optional)" id="komentar_pembimbing" name="komentar_pembimbing"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="revisi" class="btn btn-success">Revisi</button>
                                    </div>
                                </div>
                                </div>
                            </div>
    
    
                            <!-- Modal -->
                            <div class="modal fade" id="modal_setujui2">
                                <div class="modal-dialog">
                                <div class="modal-content bg-white">
    
                                    <div class="modal-header">
                                    <h4 class="modal-title">Konfirmasi</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah anda ingin menyetujui paper ini?
                                    </div>
                                    <div class="modal-footer justify-content-between">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                                    <button type="submit" name="action" value="setujui" class="btn btn-success">Setujui</button>
                                    </div>
                                </div>
                                </div>
                            </div>
    
                            </form>
                        
                        </td>
                    </td>
                </tr>
                @endforeach
            @endif
            
        </tbody>
    </table>
@endsection
