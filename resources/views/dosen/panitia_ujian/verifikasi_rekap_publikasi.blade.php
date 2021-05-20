@extends('template.main')
@section('title', 'Verifikasi Rekap Nilai Publikasi')
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

            <form action="{{ route('verifikasi_rekap_publikasi_action') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <button type="button" class="btn btn-sm btn-success " data-toggle="modal" data-target="#verifikasi_rekap">Verifikasi Rekap Nilai Publikasi</button>

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

                            <div class="row">
                                <div class="col mb-2 mr-2 ml-2">
                                    <label for="total_view">Total</label>
                                    <input type="hidden" name="total_all"  id='total_all' value={{ $total_all }}>
                                    <br>
                                    {{ $total_all }}
                                </div>
                                <div class="col mb-2 mr-2 ml-2">
                                    <label for="aksara_view">Aksara</label>
                                    <input type="hidden" name="aksara"  id='aksara' value={{ $aksara }}>
                                    <br>
                                    {{ $aksara }}
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
