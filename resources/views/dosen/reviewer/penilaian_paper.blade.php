@extends('template.main')
@section('title', 'Penilaian Paper')
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
                <form action="{{ route('penilaian_paper_action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="reviewer_ke" value="1">
                <input type="hidden" class="form-control" name="id_dosen" value="{{ $id_dosen }}">

                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_penilaian1">Penilaian</button>

                <!-- Modal -->
                <div class="modal fade" id="modal_penilaian1">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white ">

                        <div class="modal-header">
                        <h4 class="modal-title">Penilaian Paper Pengajuan Review</h4>
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
                                    {{-- <div class="col mb-2 mr-2 ml-2">
                                        <label for="aksara_view">Aksara</label>
                                        <input type="hidden" name="aksara"  id='aksara' >
                                        <br>
                                        <output type="text" name="aksara_view" id='aksara_view'> </output>
                                    </div> --}}

                                </div>
                            {{-- </div> --}}
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
                <form action="{{ route('penilaian_paper_action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="reviewer_ke" value="2">
                <input type="hidden" class="form-control" name="id_dosen" value="{{ $id_dosen }}">

                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_penilaian2">Penilaian</button>


                <!-- Modal -->
                <div class="modal fade" id="modal_penilaian2">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white">

                        <div class="modal-header">
                            <h4 class="modal-title">Penilaian Paper Pengajuan Review</h4>
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
                                        {{-- <input type="hidden" class="form-control" name="total"  id='total' > --}}
                                        <br>
                                        <output type="text" name="total_view" id='total_view'> </output>
                                    </div>

                                    {{-- <div class="col mb-2 mr-2 ml-2">
                                        <label for="aksara_view">Aksara</label>
                                        <input type="hidden" name="aksara"  id='aksara' >
                                        <br>
                                        <output type="text" name="aksara_view" id='aksara_view'> </output>
                                    </div> --}}
                                </div>
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

{{-- pengali_baris1, input_baris1, hasil_baris1 --}}
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
            
            // var aksara = '';

            // if (hasil_total >= 8.5 ) {
            //     hasil = 'A';
            // }
            // else if ((hasil_total < 8.5) && (hasil_total >= 8))
            // {
            //     hasil = 'AB';
            // }
            // else if ((hasil_total < 8) && (hasil_total >= 7.5))
            // {
            //     hasil = 'B';
            // }
            // else if ((hasil_total < 7.5) && (hasil_total >= 7))
            // {
            //     hasil = 'BC';
            // }
            // else if ((hasil_total < 7) && (hasil_total >= 6.5))
            // {
            //     hasil = 'C';
            // }
            // else if ((hasil_total < 6.5))
            // {
            //     hasil = 'E';
            // }
            // $('#aksara').val(hasil);
            // $('#aksara_view').val(hasil);

                // console.log($('#aksara_view').val());
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




