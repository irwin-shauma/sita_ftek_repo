@extends('template.main')
@section('title', 'Penilaian Tugas Akhir')
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
        @foreach($mhs1 as $data)
        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>{{$data->nim}}</td>
            <td>{{$data->name}}</td>
            
            <td>
                <form action="{{ route('bimbingan_penilaian_tugas_akhir_action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="id_dosen" value="{{ $id_dosen }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="judul" value="{{ $judul1[$loop->index]->judul }}">
                {{-- <input type="hidden" class="form-control" name="reviewer_ke" value="1"> --}}

                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#modal_penilaian1-{{ $data->nim }}">Penilaian</button>

                <!-- Modal -->
                <div class="modal fade" id="modal_penilaian1-{{ $data->nim }}">
                    <div class="modal-dialog">
                    {{-- <div class="modal-dialog modal-lg"> --}}
                    <div class="modal-content bg-white ">

                        <div class="modal-header">
                        <h4 class="modal-title">Penilaian Tugas Akhir</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        </div>
                        <div class="modal-body">
                            <p class="font-weight-bold"> Nama : {{ $data->name }} </p>
                            <p class="font-weight-bold"> NIM : {{ $data->nim }} </p>
                            <p class="font-weight-bold"> Judul : {{ $judul1[$loop->index]->judul }} </p>
                            <div class="row">
                                <div class="col mb-2">
                                    <label for="nilai" class="mt-3">Nilai</label>
                                    <input type="number" class="form-control inputan" name="nilai" id='nilai' max="10" min="0" step="any">

                                    <button type="button" class="btn btn-sm btn-warning mt-2" data-container="body" data-toggle="popover" data-placement="left" data-html="true" data-trigger='hover' data-content="≥8.5 = A,<br />
                                    ≥8 = AB <br />
                                    ≥7.5 = B <br />
                                    ≥7 = BC <br />
                                    ≥6.5 = C <br />
                                    <6.5 = E">
                                        Keterangan nilai
                                    </button>
                                </div>
                                <div class="col mb-2">
                                    <label for="komentar" class="mt-3">Pesan/Komentar</label>
                                    <textarea class="form-control" rows="3" placeholder="Berikan keterangan jika nilai yang diberikan lebih tingi dari  8 atau kurang dari 7 " id="komentar" name="komentar"></textarea>
                                </div>
                            </div>


                                <div class="row col-mt-n2">

                                    <div class="col mt-2">
                                        <label for="total_view">Total</label>
                                        <input type="hidden" name="total"  id='total' >
                                        <br>
                                        <output type="text" name="total_view" id='total_view'> </output>
                                    </div>

                                    {{-- <div class="col mt-2">
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

@endsection

@push('calculation')
    <script>

    $(function(){
        $('#nilai').change(function(){
        
        var hasil_total = parseFloat($('#nilai').val());
            
            hasil_total = hasil_total.toFixed(2);

            // hasil_total = hasil_total;
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

</script>

@endpush

@push('popover')
<script>
    $(function () {
        $('[data-toggle="popover"]').popover({
            // data-content=" ≥8.5 A,<br />≥8 AB,<br />≥7.5 B,<br />≥7 BC,<br />≥6.5 C,<br /><6.5 E";

        })
    })
</script>
@endpush


