@extends('template.main')
@section('title', 'Review Pengajuan Review')
@section('content')
<label for="example1">Reviewer 1</label>
<table class='table table-bordered table-striped' id='example1'>
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @if ($cond1 == 1)
            
        @foreach($data_mhs1 as $data)
        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>{{$data->nim}}</td>
            <td>{{$data->name}}</td>
            
            <td>
                <form action="{{ route('review_pengajuan_review_action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="file_paper" value="{{ $data_paper1[$loop->index]->file_paper }}">
                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="id_dosen" value="{{ $dosen[0]->id }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="reviewer_ke" value="1">

                <button type="submit" class="btn btn-sm btn-info" formaction="{{ route('review_pengajuan_review_download') }}">Download</button>

                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_revisi1">Revisi</button>
                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_setujui1">Setujui</button>


                <!-- Modal -->
                <div class="modal fade" id="modal_revisi1">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white">

                        <div class="modal-header">
                        <h4 class="modal-title">Upload Revisi dan Penilaian Paper</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col">
                                    <p class="font-weight-bold"> Nama : {{ $data->name }} </p>
                                </div>
                                <div class="col text-right">
                                    <button type="button" class="btn btn-sm btn-warning mt-2" data-container="body" data-toggle="popover" data-placement="right" data-html="true" data-trigger='hover' data-content="≥8.5 = A,<br />
                                    ≥8 = AB <br />
                                    ≥7.5 = B <br />
                                    ≥7 = BC <br />
                                    ≥6.5 = C <br />
                                    <6.5 = E">
                                        Keterangan nilai
                                    </button>
                                </div>
                            </div>
                            <p class="font-weight-bold"> NIM : {{ $data->nim }} </p>

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

                            <label for="komentar_reviewer" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama revisi (Optional)" id="komentar_reviewer" name="komentar_reviewer"></textarea>
                            </div>


                            
                            {{-- <div class="row"> --}}
                            <div class="row border-bottom">
                                <div class="col mb-n1 mr-2 ml-2">
                                    <p class="text-center">Kriteria Penilaian</p>
                                </div>
                                <div class="col mb-n1 mr-2 ml-2">
                                    <p class="text-center">Bobot (m)</p>
                                </div>
                                <div class="col mb-n1 mr-2 ml-2">
                                    <p class="text-center">Skor 0-10 (X)</p>
                                </div>
                                <div class="col mb-n1 mr-2 ml-2">
                                    <p class="text-center">Nilai (mX)</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-1 ml-1 ">
                                    <p><i><b>A. SUBSTANSI</b></i></p>
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col ml-2 mr-2 mb-2">
                                    <p >Bobot tugas akhir  </p>
                                </div>
                                <div class="col ml-2 mr-2 mb-3">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris1" placeholder="0.15" id='pengali_baris1' value=0.15 readonly="readonly">
                                </div>
                                <div class="col ml-2 mr-2 mb-3">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris1" id='input_baris1'>
                                </div>
                                <div class="col ml-2 mr-2 mb-3">
                                    <input type="text" class="form-control hasil_total" name="hasil_baris1" id='hasil_baris1'readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    <p >Tingkat kebaruan <i>(novelty)</i> dibanding karya-karya sebelumnya </p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.3</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris2" placeholder="0.1" id='pengali_baris2' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris2"  id='input_baris2' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total" name="hasil_baris2"  id='hasil_baris2' readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                    <p>Ketepatan metodologi dalam mendapatkan hasil tugas akhir</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris3" placeholder="0.15" id='pengali_baris3' value=0.15 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris3"  id='input_baris3' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total" name="hasil_baris3"  id='hasil_baris3' readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                    <p>Kelengkapan dan ketepatan menganalisis hasil tugas akhir</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris4" placeholder="0.2" id='pengali_baris4' value=0.2 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris4"  id='input_baris4' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total" name="hasil_baris4"  id='hasil_baris4' readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                    <p>Kemutakhiran daftar pustaka</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris5" placeholder="0.1" id='pengali_baris5' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris5"  id='input_baris5' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total" name="hasil_baris5"  id='hasil_baris5' readonly="readonly">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-1 ml-1 ">
                                    <p><i><b>B. TATA TULIS</b></i></p>
                                </div>
                            </div>

                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    <p >Pemenuhan kaidah penulisan ilmiah (tata bahasa dan sistematika)  </p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris6" placeholder="0.1" id='pengali_baris6' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris6" id='input_baris6'>
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total" name="hasil_baris6" id='hasil_baris6'readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    <p >Kesinambungan judul, abstrak, pendahuluan, metodologi, hasil, analisis dan kesimpulan</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.3</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris7" placeholder="0.1" id='pengali_baris7' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris7"  id='input_baris7' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total" name="hasil_baris7"  id='hasil_baris7' readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                    <p>Kesesuaian dengan template artikel tugas akhir FTEK</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris8" placeholder="0.1" id='pengali_baris8' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris8"  id='input_baris8' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total" name="hasil_baris8"  id='hasil_baris8' readonly="readonly">
                                </div>
                            </div>


                            <div class="row">
                                <div class="col mb-2 mr-2 ml-2">
                                    <label for="total_view">Total</label>
                                    <input type="hidden" name="total"  id='total' >
                                    <br>
                                    <output type="text" name="total_view" id='total_view'> </output>
                                </div>
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
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white">

                        <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi Menyetujui dan Penilaian Paper</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            
                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold"> Nama : {{ $data->name }} </p>
                            </div>
                            <div class="col text-right">
                                <button type="button" class="btn btn-sm btn-warning mt-2" data-container="body" data-toggle="popover" data-placement="right" data-html="true" data-trigger='hover' data-content="≥8.5 = A,<br />
                                ≥8 = AB <br />
                                ≥7.5 = B <br />
                                ≥7 = BC <br />
                                ≥6.5 = C <br />
                                <6.5 = E">
                                    Keterangan nilai
                                </button>
                            </div>
                            
                        </div>
                        <p class="font-weight-bold"> NIM : {{ $data->nim }} </p>
                            <div class="row border-bottom">
                                <div class="col mb-n1 mr-2 ml-2">
                                    <p class="text-center">Kriteria Penilaian</p>
                                </div>
                                <div class="col mb-n1 mr-2 ml-2">
                                    <p class="text-center">Bobot (m)</p>
                                </div>
                                <div class="col mb-n1 mr-2 ml-2">
                                    <p class="text-center">Skor 0-10 (X)</p>
                                </div>
                                <div class="col mb-n1 mr-2 ml-2">
                                    <p class="text-center">Nilai (mX)</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-1 ml-1 ">
                                    <p><i><b>A. SUBSTANSI</b></i></p>
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col ml-2 mr-2 mb-2">
                                    <p >Bobot tugas akhir  </p>
                                </div>
                                <div class="col ml-2 mr-2 mb-3">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris12" placeholder="0.15" id='pengali_baris12' value=0.15 readonly="readonly">
                                </div>
                                <div class="col ml-2 mr-2 mb-3">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris12" id='input_baris12'>
                                </div>
                                <div class="col ml-2 mr-2 mb-3">
                                    <input type="text" class="form-control hasil_total2" name="hasil_baris12" id='hasil_baris12'readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    <p >Tingkat kebaruan <i>(novelty)</i> dibanding karya-karya sebelumnya </p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.3</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris22" placeholder="0.1" id='pengali_baris22' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris22"  id='input_baris22' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total2" name="hasil_baris22"  id='hasil_baris22' readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                    <p>Ketepatan metodologi dalam mendapatkan hasil tugas akhir</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris32" placeholder="0.15" id='pengali_baris32' value=0.15 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris32"  id='input_baris32' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total2" name="hasil_baris32"  id='hasil_baris32' readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                    <p>Kelengkapan dan ketepatan menganalisis hasil tugas akhir</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris42" placeholder="0.2" id='pengali_baris42' value=0.2 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris42"  id='input_baris42' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total2" name="hasil_baris42"  id='hasil_baris42' readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                    <p>Kemutakhiran daftar pustaka</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris52" placeholder="0.1" id='pengali_baris52' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris52"  id='input_baris52' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total2" name="hasil_baris52"  id='hasil_baris52' readonly="readonly">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col mt-2 mb-1 ml-1 ">
                                    <p><i><b>B. TATA TULIS</b></i></p>
                                </div>
                            </div>
  
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    <p >Pemenuhan kaidah penulisan ilmiah (tata bahasa dan sistematika)  </p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris62" placeholder="0.1" id='pengali_baris62' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris62" id='input_baris62'>
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total2" name="hasil_baris62" id='hasil_baris62'readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    <p >Kesinambungan judul, abstrak, pendahuluan, metodologi, hasil, analisis dan kesimpulan</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.3</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris72" placeholder="0.1" id='pengali_baris72' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris72"  id='input_baris72' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total2" name="hasil_baris72"  id='hasil_baris72' readonly="readonly">
                                </div>
                            </div>
                            <div class="row h-100 border-bottom">
                                <div class="col m-2 my-auto">
                                    {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                    <p>Kesesuaian dengan template artikel tugas akhir FTEK</p>
                                </div>
                                <div class="col m-2 my-auto">
                                    {{-- <p>0.4</p> --}}
                                    <input type="text" class="form-control" name="pengali_baris82" placeholder="0.1" id='pengali_baris82' value=0.1 readonly="readonly">
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris82"  id='input_baris82' >
                                </div>
                                <div class="col m-2 my-auto">
                                    <input type="text" class="form-control hasil_total2" name="hasil_baris82"  id='hasil_baris82' readonly="readonly">
                                </div>
                            </div>
  
                            <div class="row border-bottom">
                                <div class="col mb-2 mr-2 ml-2">
                                    <label for="total_view">Total</label>
                                    <input type="hidden" name="total2"  id='total2' >
                                    {{-- <input type="hidden" class="form-control" name="total"  id='total' > --}}
                                    <br>
                                    <output type="text" name="total_view2" id='total_view2'> </output>
                                </div>
  
                                {{-- <div class="col mb-2 mr-2 ml-2">
                                    <label for="aksara_view">Aksara</label>
                                    <input type="hidden" name="aksara"  id='aksara' >
                                    <br>
                                    <output type="text" name="aksara_view" id='aksara_view'> </output>
                                </div> --}}
                            </div>

                                <p><b> Apakah anda ingin menyetujui paper ini?</b></p>
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
    @else
            
    @endif
    </tbody>

</table>
<label for="example2" class="mt-3">Reviewer 2</label>
<table class='table table-bordered table-striped' id='example2'>
    <thead>
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama Mahasiswa</th>
            <th>Aksi</th>
        </tr>
    </thead>

    <tbody>
        @if ($cond2 == 1)
            

        @foreach($data_mhs2 as $data)
        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>{{$data->nim}}</td>
            <td>{{$data->name}}</td>
            
            <td>
                <form action="{{ route('review_pengajuan_review_action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="file_paper" value="{{ $data_paper2[$loop->index]->file_paper }}">
                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="id_dosen" value="{{ $dosen[0]->id }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="reviewer_ke" value="2">


                <button type="submit" class="btn btn-sm btn-info" formaction="{{ route('review_pengajuan_review_download') }}">Download</button>
                <button type="button" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modal_revisi2">Revisi</button>
                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_setujui2">Setujui</button>


                <!-- Modal -->
                <div class="modal fade" id="modal_revisi2">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white">

                        <div class="modal-header">
                        <h4 class="modal-title">Upload Revisi dan Penilaian Paper</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">

                        <div class="row">
                            <div class="col">
                                <p class="font-weight-bold"> Nama : {{ $data->name }} </p>
                            </div>
                            <div class="col text-right">
                                <button type="button" class="btn btn-sm btn-warning mt-2" data-container="body" data-toggle="popover" data-placement="right" data-html="true" data-trigger='hover' data-content="≥8.5 = A,<br />
                                ≥8 = AB <br />
                                ≥7.5 = B <br />
                                ≥7 = BC <br />
                                ≥6.5 = C <br />
                                <6.5 = E">
                                    Keterangan nilai
                                </button>
                            </div>
                        </div>
                        <p class="font-weight-bold"> NIM : {{ $data->nim }} </p>
        
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
        
                        <label for="komentar_reviewer" class="mt-3">Pesan/Komentar</label>
                        <div class="form-group">
                            <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama revisi (Optional)" id="komentar_reviewer" name="komentar_reviewer"></textarea>
                        </div>
        
        
                    {{-- <div class="row"> --}}
                        <div class="row border-bottom">
                            <div class="col mb-n1 mr-2 ml-2">
                                <p class="text-center">Kriteria Penilaian</p>
                            </div>
                            <div class="col mb-n1 mr-2 ml-2">
                                <p class="text-center">Bobot (m)</p>
                            </div>
                            <div class="col mb-n1 mr-2 ml-2">
                                <p class="text-center">Skor 0-10 (X)</p>
                            </div>
                            <div class="col mb-n1 mr-2 ml-2">
                                <p class="text-center">Nilai (mX)</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-1 ml-1 ">
                                <p><i><b>A. SUBSTANSI</b></i></p>
                            </div>
                        </div>
                        <div class="row h-100 border-bottom">
                            <div class="col ml-2 mr-2 mb-2">
                                <p >Bobot tugas akhir  </p>
                            </div>
                            <div class="col ml-2 mr-2 mb-3">
                                {{-- <p>0.4</p> --}}
                                <input type="text" class="form-control" name="pengali_baris1" placeholder="0.15" id='pengali_baris1' value=0.15 readonly="readonly">
                            </div>
                            <div class="col ml-2 mr-2 mb-3">
                                <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris1" id='input_baris1'>
                            </div>
                            <div class="col ml-2 mr-2 mb-3">
                                <input type="text" class="form-control hasil_total" name="hasil_baris1" id='hasil_baris1'readonly="readonly">
                            </div>
                        </div>
                        <div class="row h-100 border-bottom">
                            <div class="col m-2 my-auto">
                                <p >Tingkat kebaruan <i>(novelty)</i> dibanding karya-karya sebelumnya </p>
                            </div>
                            <div class="col m-2 my-auto">
                                {{-- <p>0.3</p> --}}
                                <input type="text" class="form-control" name="pengali_baris2" placeholder="0.1" id='pengali_baris2' value=0.1 readonly="readonly">
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris2"  id='input_baris2' >
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="text" class="form-control hasil_total" name="hasil_baris2"  id='hasil_baris2' readonly="readonly">
                            </div>
                        </div>
                        <div class="row h-100 border-bottom">
                            <div class="col m-2 my-auto">
                                {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                <p>Ketepatan metodologi dalam mendapatkan hasil tugas akhir</p>
                            </div>
                            <div class="col m-2 my-auto">
                                {{-- <p>0.4</p> --}}
                                <input type="text" class="form-control" name="pengali_baris3" placeholder="0.15" id='pengali_baris3' value=0.15 readonly="readonly">
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris3"  id='input_baris3' >
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="text" class="form-control hasil_total" name="hasil_baris3"  id='hasil_baris3' readonly="readonly">
                            </div>
                        </div>
                        <div class="row h-100 border-bottom">
                            <div class="col m-2 my-auto">
                                {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                <p>Kelengkapan dan ketepatan menganalisis hasil tugas akhir</p>
                            </div>
                            <div class="col m-2 my-auto">
                                {{-- <p>0.4</p> --}}
                                <input type="text" class="form-control" name="pengali_baris4" placeholder="0.2" id='pengali_baris4' value=0.2 readonly="readonly">
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris4"  id='input_baris4' >
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="text" class="form-control hasil_total" name="hasil_baris4"  id='hasil_baris4' readonly="readonly">
                            </div>
                        </div>
                        <div class="row h-100 border-bottom">
                            <div class="col m-2 my-auto">
                                {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                <p>Kemutakhiran daftar pustaka</p>
                            </div>
                            <div class="col m-2 my-auto">
                                {{-- <p>0.4</p> --}}
                                <input type="text" class="form-control" name="pengali_baris5" placeholder="0.1" id='pengali_baris5' value=0.1 readonly="readonly">
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris5"  id='input_baris5' >
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="text" class="form-control hasil_total" name="hasil_baris5"  id='hasil_baris5' readonly="readonly">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col mt-2 mb-1 ml-1 ">
                                <p><i><b>B. TATA TULIS</b></i></p>
                            </div>
                        </div>

                        <div class="row h-100 border-bottom">
                            <div class="col m-2 my-auto">
                                <p >Pemenuhan kaidah penulisan ilmiah (tata bahasa dan sistematika)  </p>
                            </div>
                            <div class="col m-2 my-auto">
                                {{-- <p>0.4</p> --}}
                                <input type="text" class="form-control" name="pengali_baris6" placeholder="0.1" id='pengali_baris6' value=0.1 readonly="readonly">
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris6" id='input_baris6'>
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="text" class="form-control hasil_total" name="hasil_baris6" id='hasil_baris6'readonly="readonly">
                            </div>
                        </div>
                        <div class="row h-100 border-bottom">
                            <div class="col m-2 my-auto">
                                <p >Kesinambungan judul, abstrak, pendahuluan, metodologi, hasil, analisis dan kesimpulan</p>
                            </div>
                            <div class="col m-2 my-auto">
                                {{-- <p>0.3</p> --}}
                                <input type="text" class="form-control" name="pengali_baris7" placeholder="0.1" id='pengali_baris7' value=0.1 readonly="readonly">
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris7"  id='input_baris7' >
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="text" class="form-control hasil_total" name="hasil_baris7"  id='hasil_baris7' readonly="readonly">
                            </div>
                        </div>
                        <div class="row h-100 border-bottom">
                            <div class="col m-2 my-auto">
                                {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                <p>Kesesuaian dengan template artikel tugas akhir FTEK</p>
                            </div>
                            <div class="col m-2 my-auto">
                                {{-- <p>0.4</p> --}}
                                <input type="text" class="form-control" name="pengali_baris8" placeholder="0.1" id='pengali_baris8' value=0.1 readonly="readonly">
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="number" max="10" min="0" step="any" class="form-control inputan" name="input_baris8"  id='input_baris8' >
                            </div>
                            <div class="col m-2 my-auto">
                                <input type="text" class="form-control hasil_total" name="hasil_baris8"  id='hasil_baris8' readonly="readonly">
                            </div>
                        </div>


                        <div class="row">
                            <div class="col mb-2 mr-2 ml-2">
                                <label for="total_view">Total</label>
                                <input type="hidden" name="total"  id='total' >
                                <br>
                                <output type="text" name="total_view" id='total_view'> </output>
                            </div>
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
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white">

                        <div class="modal-header">
                        <h4 class="modal-title">Konfirmasi Menyetujui dan Penilaian Paper</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">

                            <div class="row">
                                <div class="col">
                                    <p class="font-weight-bold"> Nama : {{ $data->name }} </p>
                                </div>
                                <div class="col text-right">
                                    <button type="button" class="btn btn-sm btn-warning mt-2" data-container="body" data-toggle="popover" data-placement="right" data-html="true" data-trigger='hover' data-content="≥8.5 = A,<br />
                                    ≥8 = AB <br />
                                    ≥7.5 = B <br />
                                    ≥7 = BC <br />
                                    ≥6.5 = C <br />
                                    <6.5 = E">
                                        Keterangan nilai
                                    </button>
                                </div>
                                
                            </div>
                            <p class="font-weight-bold"> NIM : {{ $data->nim }} </p>
                                <div class="row border-bottom">
                                    <div class="col mb-n1 mr-2 ml-2">
                                        <p class="text-center">Kriteria Penilaian</p>
                                    </div>
                                    <div class="col mb-n1 mr-2 ml-2">
                                        <p class="text-center">Bobot (m)</p>
                                    </div>
                                    <div class="col mb-n1 mr-2 ml-2">
                                        <p class="text-center">Skor 0-10 (X)</p>
                                    </div>
                                    <div class="col mb-n1 mr-2 ml-2">
                                        <p class="text-center">Nilai (mX)</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-2 mb-1 ml-1 ">
                                        <p><i><b>A. SUBSTANSI</b></i></p>
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col ml-2 mr-2 mb-2">
                                        <p >Bobot tugas akhir  </p>
                                    </div>
                                    <div class="col ml-2 mr-2 mb-3">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_baris12" placeholder="0.15" id='pengali_baris12' value=0.15 readonly="readonly">
                                    </div>
                                    <div class="col ml-2 mr-2 mb-3">
                                        <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris12" id='input_baris12'>
                                    </div>
                                    <div class="col ml-2 mr-2 mb-3">
                                        <input type="text" class="form-control hasil_total2" name="hasil_baris12" id='hasil_baris12'readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 my-auto">
                                        <p >Tingkat kebaruan <i>(novelty)</i> dibanding karya-karya sebelumnya </p>
                                    </div>
                                    <div class="col m-2 my-auto">
                                        {{-- <p>0.3</p> --}}
                                        <input type="text" class="form-control" name="pengali_baris22" placeholder="0.1" id='pengali_baris22' value=0.1 readonly="readonly">
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris22"  id='input_baris22' >
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="text" class="form-control hasil_total2" name="hasil_baris22"  id='hasil_baris22' readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 my-auto">
                                        {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                        <p>Ketepatan metodologi dalam mendapatkan hasil tugas akhir</p>
                                    </div>
                                    <div class="col m-2 my-auto">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_baris32" placeholder="0.15" id='pengali_baris32' value=0.15 readonly="readonly">
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris32"  id='input_baris32' >
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="text" class="form-control hasil_total2" name="hasil_baris32"  id='hasil_baris32' readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 my-auto">
                                        {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                        <p>Kelengkapan dan ketepatan menganalisis hasil tugas akhir</p>
                                    </div>
                                    <div class="col m-2 my-auto">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_baris42" placeholder="0.2" id='pengali_baris42' value=0.2 readonly="readonly">
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris42"  id='input_baris42' >
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="text" class="form-control hasil_total2" name="hasil_baris42"  id='hasil_baris42' readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 my-auto">
                                        {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                        <p>Kemutakhiran daftar pustaka</p>
                                    </div>
                                    <div class="col m-2 my-auto">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_baris52" placeholder="0.1" id='pengali_baris52' value=0.1 readonly="readonly">
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris52"  id='input_baris52' >
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="text" class="form-control hasil_total2" name="hasil_baris52"  id='hasil_baris52' readonly="readonly">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mt-2 mb-1 ml-1 ">
                                        <p><i><b>B. TATA TULIS</b></i></p>
                                    </div>
                                </div>

                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 my-auto">
                                        <p >Pemenuhan kaidah penulisan ilmiah (tata bahasa dan sistematika)  </p>
                                    </div>
                                    <div class="col m-2 my-auto">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_baris62" placeholder="0.1" id='pengali_baris62' value=0.1 readonly="readonly">
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris62" id='input_baris62'>
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="text" class="form-control hasil_total2" name="hasil_baris62" id='hasil_baris62'readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 my-auto">
                                        <p >Kesinambungan judul, abstrak, pendahuluan, metodologi, hasil, analisis dan kesimpulan</p>
                                    </div>
                                    <div class="col m-2 my-auto">
                                        {{-- <p>0.3</p> --}}
                                        <input type="text" class="form-control" name="pengali_baris72" placeholder="0.1" id='pengali_baris72' value=0.1 readonly="readonly">
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris72"  id='input_baris72' >
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="text" class="form-control hasil_total2" name="hasil_baris72"  id='hasil_baris72' readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 my-auto">
                                        {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                        <p>Kesesuaian dengan template artikel tugas akhir FTEK</p>
                                    </div>
                                    <div class="col m-2 my-auto">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_baris82" placeholder="0.1" id='pengali_baris82' value=0.1 readonly="readonly">
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="number" max="10" min="0" step="any" class="form-control inputan2" name="input_baris82"  id='input_baris82' >
                                    </div>
                                    <div class="col m-2 my-auto">
                                        <input type="text" class="form-control hasil_total2" name="hasil_baris82"  id='hasil_baris82' readonly="readonly">
                                    </div>
                                </div>

                                <div class="row border-bottom">
                                    <div class="col mb-2 mr-2 ml-2">
                                        <label for="total_view">Total</label>
                                        <input type="hidden" name="total2"  id='total2' >
                                        {{-- <input type="hidden" class="form-control" name="total"  id='total' > --}}
                                        <br>
                                        <output type="text" name="total_view2" id='total_view2'> </output>
                                    </div>

                                    {{-- <div class="col mb-2 mr-2 ml-2">
                                        <label for="aksara_view">Aksara</label>
                                        <input type="hidden" name="aksara"  id='aksara' >
                                        <br>
                                        <output type="text" name="aksara_view" id='aksara_view'> </output>
                                    </div> --}}
                                </div>

                                <p><b> Apakah anda ingin menyetujui paper ini?</b></p>                    
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
    @else
            
    @endif
    </tbody>

</table>
@endsection

@push('calculation')
    <script>
        $(function(){
            $('#input_baris1').change(function() {
                var hasil1 = 0;
                
                var pengali1 =$('#pengali_baris1').val();
                var input1 = $('#input_baris1').val();
                hasil1 = parseFloat(pengali1) * parseFloat(input1);
                hasil1 = hasil1.toFixed(2);
                $("#hasil_baris1").val(hasil1);
            });
        });


        $(function(){
            $('#input_baris2').change(function() {
                var hasil2 = 0;
                
                var pengali2 =$('#pengali_baris2').val();
                var input2 = $('#input_baris2').val();
                hasil2 = parseFloat(pengali2) * parseFloat(input2);
                hasil2 = hasil2.toFixed(2);
                $("#hasil_baris2").val(hasil2);
            });
        });

        $(function(){
            $('#input_baris3').change(function() {
                var hasil3 = 0;
                
                var pengali3 =$('#pengali_baris3').val();
                var input3 = $('#input_baris3').val();
                hasil3 = parseFloat(pengali3) * parseFloat(input3);
                hasil3 = hasil3.toFixed(2);
                $("#hasil_baris3").val(hasil3);
            });
        });
        $(function(){
            $('#input_baris4').change(function() {
                var hasil4 = 0;
                
                var pengali4 =$('#pengali_baris4').val();
                var input4 = $('#input_baris4').val();
                hasil4 = parseFloat(pengali4) * parseFloat(input4);
                hasil4 = hasil4.toFixed(2);
                $("#hasil_baris4").val(hasil4);
            });
        });
        $(function(){
            $('#input_baris5').change(function() {
                var hasil5 = 0;
                
                var pengali5 =$('#pengali_baris5').val();
                var input5 = $('#input_baris5').val();
                hasil5 = parseFloat(pengali5) * parseFloat(input5);
                hasil5 = hasil5.toFixed(2);
                $("#hasil_baris5").val(hasil5);
            });
        });
        $(function(){
            $('#input_baris6').change(function() {
                var hasil6 = 0;
                
                var pengali6 =$('#pengali_baris6').val();
                var input6 = $('#input_baris6').val();
                hasil6 = parseFloat(pengali6) * parseFloat(input6);
                hasil6 = hasil6.toFixed(2);
                $("#hasil_baris6").val(hasil6);
            });
        });
        $(function(){
            $('#input_baris7').change(function() {
                var hasil7 = 0;
                
                var pengali7 =$('#pengali_baris7').val();
                var input7 = $('#input_baris7').val();
                hasil7 = parseFloat(pengali7) * parseFloat(input7);
                hasil7 = hasil7.toFixed(2);
                $("#hasil_baris7").val(hasil7);
            });
        });
        $(function(){
            $('#input_baris8').change(function() {
                var hasil8 = 0;
                
                var pengali8 =$('#pengali_baris8').val();
                var input8 = $('#input_baris8').val();
                hasil8 = parseFloat(pengali8) * parseFloat(input8);
                hasil8 = hasil8.toFixed(2);
                $("#hasil_baris8").val(hasil8);
            });
        });

        $(function(){
            $('.inputan').change(function(){
            // $('#input_baris3').change(function(){
                var hasil_total = 0;

                $('.hasil_total').each(function () { 
                    hasil_total += parseFloat($(this).val());
                });

                hasil_total = hasil_total.toFixed(2);
                $('#total').val(hasil_total);
                $('#total_view').val(hasil_total);
                
            });
        });

        $(".inputan").attr({
            "max" : 10,
            "min" : 0,
        });

    </script>
@endpush

@push('calculation2')
    <script>
        $(function(){
            $('#input_baris12').change(function() {
                var hasil12 = 0;
                
                var pengali12 =$('#pengali_baris12').val();
                var input12 = $('#input_baris12').val();
                hasil12 = parseFloat(pengali12) * parseFloat(input12);
                hasil12 = hasil12.toFixed(2);
                $("#hasil_baris12").val(hasil12);
            });
        });


        $(function(){
            $('#input_baris22').change(function() {
                var hasil22 = 0;
                
                var pengali22 =$('#pengali_baris22').val();
                var input22 = $('#input_baris22').val();
                hasil22 = parseFloat(pengali22) * parseFloat(input22);
                hasil22 = hasil22.toFixed(2);
                $("#hasil_baris22").val(hasil22);
            });
        });

        $(function(){
            $('#input_baris32').change(function() {
                var hasil32 = 0;
                
                var pengali32 =$('#pengali_baris32').val();
                var input32 = $('#input_baris32').val();
                hasil32 = parseFloat(pengali32) * parseFloat(input32);
                hasil32 = hasil32.toFixed(2);
                $("#hasil_baris32").val(hasil32);
            });
        });
        $(function(){
            $('#input_baris42').change(function() {
                var hasil42 = 0;
                
                var pengali42 =$('#pengali_baris42').val();
                var input42 = $('#input_baris42').val();
                hasil42 = parseFloat(pengali42) * parseFloat(input42);
                hasil42 = hasil42.toFixed(2);
                $("#hasil_baris42").val(hasil42);
            });
        });
        $(function(){
            $('#input_baris52').change(function() {
                var hasil52 = 0;
                
                var pengali52 =$('#pengali_baris52').val();
                var input52 = $('#input_baris52').val();
                hasil52 = parseFloat(pengali52) * parseFloat(input52);
                hasil52 = hasil52.toFixed(2);
                $("#hasil_baris52").val(hasil52);
            });
        });
        $(function(){
            $('#input_baris62').change(function() {
                var hasil62 = 0;
                
                var pengali62 =$('#pengali_baris62').val();
                var input62 = $('#input_baris62').val();
                hasil62 = parseFloat(pengali62) * parseFloat(input62);
                hasil62 = hasil62.toFixed(2);
                $("#hasil_baris62").val(hasil62);
            });
        });
        $(function(){
            $('#input_baris72').change(function() {
                var hasil72 = 0;
                
                var pengali72 =$('#pengali_baris72').val();
                var input72 = $('#input_baris72').val();
                hasil72 = parseFloat(pengali72) * parseFloat(input72);
                hasil72 = hasil72.toFixed(2);
                $("#hasil_baris72").val(hasil72);
            });
        });
        $(function(){
            $('#input_baris82').change(function() {
                var hasil82 = 0;
                
                var pengali82 =$('#pengali_baris82').val();
                var input82 = $('#input_baris82').val();
                hasil82 = parseFloat(pengali82) * parseFloat(input82);
                hasil82 = hasil82.toFixed(2);
                $("#hasil_baris82").val(hasil82);
            });
        });

        $(function(){
            $('.inputan2').change(function(){
            // $('#input_baris3').change(function(){
                var hasil_total2 = 0;

                $('.hasil_total2').each(function () { 
                    hasil_total2 += parseFloat($(this).val());
                });

                hasil_total2 = hasil_total2.toFixed(2);
                $('#total2').val(hasil_total2);
                $('#total_view2').val(hasil_total2);
                
            });
        });

        $(".inputan").attr({
            "max" : 10,
            "min" : 0,
        });

    </script>
@endpush

@push('popover')
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
@endpush
