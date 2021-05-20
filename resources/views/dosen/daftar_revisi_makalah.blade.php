@extends('template.main')
@section('title', 'Daftar Revisi Makalah')
@section('content')
<label for="example1">Tabel Pembimbing 1</label>
<table class='table table-bordered table-striped' id="example1">
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>NAMA</th>
            <th>Aksi</th>
            {{-- <th></th> --}}
        </tr>
    </thead>
        <tbody>
            @foreach ($mhs1 as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->nim}}</td>
                <td>{{ $data->name}}</td>
                <td>
                    {{-- <form action="{{ route('daftar_revisi_makalah_download') }}" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        {{-- <input type="hidden" class="form-control" name="file_proposal" value="{{ $data_proposal1[$loop->index]->file_proposal }}">
                        <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                        <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                        <input type="hidden" class="form-control" name="reviewer_ke" value="1"> --}}
                        {{-- <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}"> --}}
        
                        {{-- <button type="submit" class="btn btn-sm btn-info" formaction="{{ route('review_kolokium_awal_download') }}">Download</button> --}}
        
                        {{-- <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_revisi1">Revisi</button> --}}
                    <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_lihat_daftar">Lihat Daftar Makalah</button>
        
                    <!-- Modal -->
                    <div class="modal fade" id="modal_lihat_daftar">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content bg-white">
    
                            <div class="modal-header">
                            <h4 class="modal-title">Daftar Review Makalah</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <p class="font-weight-bold"> Nama : {{ $data->name }} </p>
                                        <p class="font-weight-bold"> NIM : {{ $data->nim }} </p>
                                    </div>
                                </div>

                                <label for="tabel_review" class="mt-5">Tabel History Paper Pengajuan Review</label>
                            <div class="table-responsive">
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
                                        <?php $nim = $data->nim ?>
                                        @foreach($data_review1_filtered as $key => $data)
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
                                                <form action="{{ route('daftar_revisi_makalah_download') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                            
                                                    <input type="hidden" class="form-control" name="sender" value="{{ $data->sender}}">
                                                    <input type="hidden" class="form-control" name="nim" value="{{ $nim}}">
                                                    <input type="hidden" class="form-control" name="file_paper" value="{{ $data->file_paper}}">
                                                    <button type="submit" class="btn btn-sm btn-info">Download</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                                
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="action" value="setujui" class="btn btn-success">Setujui</button>
                            </div>
                        </div>
                        </div>
                    </div>
        
                        {{-- </form> --}}
                        </td>

                </tr>
                @endforeach
            </tbody>
        </table>

<label for="example1">Tabel Pembimbing 2</label>
    <table class='table table-bordered table-striped' id="example2">
        <thead>
            <tr>
                <th>No</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>Aksi</th>
                {{-- <th></th> --}}
            </tr>
        </thead>
            <tbody>
                @foreach ($mhs2 as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->nim}}</td>
                <td>{{ $data->name}}</td>
                <td>
                    {{-- <form action="{{ route('daftar_revisi_makalah_download') }}" method="POST" enctype="multipart/form-data"> --}}
                        @csrf
                        {{-- <input type="hidden" class="form-control" name="file_proposal" value="{{ $data_proposal1[$loop->index]->file_proposal }}">
                        <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                        <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                        <input type="hidden" class="form-control" name="reviewer_ke" value="1"> --}}
                        {{-- <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}"> --}}
        
                        {{-- <button type="submit" class="btn btn-sm btn-info" formaction="{{ route('review_kolokium_awal_download') }}">Download</button> --}}
        
                        {{-- <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_revisi1">Revisi</button> --}}
                    <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_lihat_daftar2">Lihat Daftar Makalah</button>
        
                    <!-- Modal -->
                    <div class="modal fade" id="modal_lihat_daftar2">
                        <div class="modal-dialog modal-xl">
                        <div class="modal-content bg-white">
    
                            <div class="modal-header">
                            <h4 class="modal-title">Daftar Review Makalah</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col">
                                        <p class="font-weight-bold"> Nama : {{ $data->name }} </p>
                                        <p class="font-weight-bold"> NIM : {{ $data->nim }} </p>
                                    </div>
                                </div>

                                <label for="tabel_review" class="mt-5">Tabel History Paper Pengajuan Review</label>
                            <div class="table-responsive">
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
                                        <?php $nim = $data->nim ?>
                                        @foreach($data_review2_filtered as $key => $data)
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
                                                <form action="{{ route('daftar_revisi_makalah_download') }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                            
                                                    <input type="hidden" class="form-control" name="sender" value="{{ $data->sender}}">
                                                    <input type="hidden" class="form-control" name="nim" value="{{ $nim}}">
                                                    <input type="hidden" class="form-control" name="file_paper" value="{{ $data->file_paper}}">
                                                    <button type="submit" class="btn btn-sm btn-info">Download</button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                                
                            </div>
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="action" value="setujui" class="btn btn-success">Setujui</button>
                            </div>
                        </div>
                        </div>
                    </div>
        
                        {{-- </form> --}}
                        </td>

                </tr>
                        @endforeach
        </tbody>
    </table>
@endsection