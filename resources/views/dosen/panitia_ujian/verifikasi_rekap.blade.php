@extends('template.main')
@section('title', 'Verifikasi Rekap Nilai')
@section('content')
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
        @foreach($get_mhs_data as $data)
        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>{{$data->nim}}</td>
            <td>{{$data->name}}</td>
        <td>
            {{-- <button type="button" class="btn btn-sm btn-success verif" data-toggle="modal" data-target="#verifikasi_rekap">
                Verifikasi Rekap Nilai
            </button>
            --}}

            <form action="{{ route('verifikasi_rekap_action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="reviewer_ke" value="2">
                <input type="hidden" class="form-control" name="id_dosen" value="{{ $id_dosen }}">

                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#verifikasi_rekap">Verifikasi Rekap Nilai</button>

                <!-- Modal -->
                <div class="modal fade" id="verifikasi_rekap">
                    <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white">

                        <div class="modal-header">
                            <h4 class="modal-title">Verifikasi Rekap Nilai</h4>
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
                                        <p class="text-center">Komponen Nilai</p>
                                    </div>
                                    <div class="col mb-n1 mr-2 ml-2">
                                        <p class="text-center">Nilai (X)</p>
                                    </div>
                                    <div class="col mb-n1 mr-2 ml-2">
                                        <p class="text-center">Bobot (m)</p>
                                    </div>
                                    <div class="col mb-n1 mr-2 ml-2">
                                        <p class="text-center">Nilai (mX)</p>
                                    </div>
                                </div>

                                <div class="row h-100 border-bottom mt-3">
                                    <div class="col ml-2 mr-2 mb-2">
                                        <p >Pembimbing </p>
                                    </div>
                                    <div class="col ml-2 mr-2 mb-3">
                                        <input type="text" step="any" class="form-control inputan" name="nilai_bimbingan" id='nilai_bimbingan' value="{{ $get_nilai_bimbingan_array[$loop->index] }}" readonly="readonly">
                                    </div>
                                    <div class="col ml-2 mr-2 mb-3">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_nilai_bimbingan" placeholder={{ $pengali_nilai_bimbingan }} id='pengali_nilai_bimbingan' value={{ $pengali_nilai_bimbingan }} readonly="readonly">
                                    </div>
                                    <div class="col ml-2 mr-2 mb-3">
                                        <input type="text" class="form-control hasil_total" name="hasil_nilai_bimbingan" id='hasil_nilai_bimbingan' value="{{ $hasil_nilai_bimbingan[$loop->index] }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 mr-2 mb-2">
                                        <p >Penguji 1</p>
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        <input type="text" step="any" class="form-control inputan" name="nilai_penguji_1"  id='nilai_penguji_1' value="{{ $get_nilai_paper_reviewer1_array[$loop->index] }}" readonly="readonly">
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        {{-- <p>0.3</p> --}}
                                        <input type="text" class="form-control" name="pengali_nilai_penguji_1" placeholder={{ $pengali_nilai_penguji }} id='pengali_nilai_penguji_1' value={{ $pengali_nilai_penguji }} readonly="readonly">
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        <input type="text" class="form-control hasil_total" name="hasil_nilai_penguji_1"  id='hasil_nilai_penguji_1' value="{{ $hasil_nilai_penguji_1[$loop->index] }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 mr-2 mb-2">
                                        {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                        <p>Penguji 2</p>
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        <input type="text" step="any" class="form-control inputan" name="nilai_penguji_2"  id='nilai_penguji_2' value="{{ $get_nilai_paper_reviewer2_array[$loop->index] }}" readonly="readonly">
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_nilai_penguji_2" placeholder={{ $pengali_nilai_penguji }} id='pengali_nilai_penguji_2' value={{ $pengali_nilai_penguji }} readonly="readonly">
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        <input type="text" class="form-control hasil_total" name="hasil_nilai_penguji_2"  id='hasil_nilai_penguji_2' value="{{ $hasil_nilai_penguji_2[$loop->index] }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row h-100 border-bottom">
                                    <div class="col m-2 mr-2 mb-2">
                                        {{-- <input type="text" class="form-control" name="notice2" placeholder="Penguasaan Materi" id='notice2' disabled> --}}
                                        <p>Kolokium Lanjut</p>
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        <input type="text" step="any" class="form-control inputan" name="nilai_kolokium_lanjut"  id='nilai_kolokium_lanjut' value="{{ $total_nilai_kolokium_lanjut[$loop->index] }}" readonly="readonly">
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        {{-- <p>0.4</p> --}}
                                        <input type="text" class="form-control" name="pengali_nilai_kolokium_lanjut" placeholder={{ $pengali_nilai_kolokium_lanjut }} id='pengali_nilai_kolokium_lanjut' value={{ $pengali_nilai_kolokium_lanjut }} readonly="readonly">
                                    </div>
                                    <div class="col m-2 mr-2 mb-3">
                                        <input type="text" class="form-control hasil_total" name="hasil_nilai_kolokium_lanjut"  id='hasil_nilai_kolokium_lanjut' value="{{ $hasil_nilai_kolokium_lanjut[$loop->index] }}" readonly="readonly">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col mb-2 mr-2 ml-2">
                                        <label for="total_view">Total</label>
                                        <input type="hidden" name="total_all"  id='total_all' value={{ $total_all[$loop->index] }}>
                                        {{-- <input type="hidden" class="form-control" name="total" id='total' > --}}
                                        <br>
                                        {{-- <output type="text" name="total_view" id='total_view' value={{ $total_all[$loop->index] }}> </output> --}}
                                        {{ $total_all[$loop->index] }}
                                    </div>
                                    <div class="col mb-2 mr-2 ml-2">
                                        <label for="aksara_view">Aksara</label>
                                        <input type="hidden" name="aksara"  id='aksara' value={{ $aksara[$loop->index] }}>
                                        <br>
                                        {{-- <output type="text" name="aksara_view" id='aksara_view' value={{ $aksara[$loop->index] }}> </output> --}}
                                        {{ $aksara[$loop->index] }}
                                    </div>
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
    </tbody>

</table>
@endsection

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


@push('popover')
<script>
    $(function () {
        $('[data-toggle="popover"]').popover()
    })
</script>
@endpush
