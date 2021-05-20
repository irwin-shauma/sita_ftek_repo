@extends('template.main')
@section('title', 'Penugasan Review')
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
        @foreach($mhs as $data)
        <tr>

            <td>{{ $loop->iteration }}</td>
            <td>{{$data->nim}}</td>
            <td>{{$data->name}}</td>
        <td>
            <button type="button" class="btn btn-sm btn-success verif" data-toggle="modal" data-target="#penjadwalan_mahasiswa">
                Jadwalkan
            </button>
            

                {{-- Modal Edit --}}
            <div class="modal fade" id="penjadwalan_mahasiswa">
                <div class="modal-dialog">
                    <div class="modal-content bg-white">

                    <div class="modal-header">
                        <h4 class="modal-title">Penugasan Review</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                    <form action="{{ route('penugasan_review_action') }}" method="POST">
                    @csrf

                    <input type="hidden" class="form-control" name="id_mhs" value={{ $data->id }}>

                        <div class="form-group">
                            <div class="row">
                                <div class="col">
                                    <label for="penugasan_date">Penugasan</label>
                                    <input type="date" min="{{ $current->format('Y-m-d') }}" id="penugasan_date" name="penugasan_date" class="form-control @error('penugasan_date') is-invalid @enderror">
                                    <div class="text-danger">
                                        @error('penugasan_date')
                                        {{ $message }}
                                        @enderror
                                    </div>
                                </div>
                            </div>


                            <div class="row mt-3 mb-n4">
                                <div class="col">
                                    <p>Anda akan menugaskan reviewer untuk mereview paper milik : </p>
                                    <p>Nama : {{ $data->name }} <br> NIM : {{ $data->nim }}</p>
                                    
    
                                    <p>Serta menugaskan pembimbing untuk menilai bimbingan mahasiswa tersebut.</p>
                                </div>
                            </div>


                                <input type="hidden" class="form-control" name="id_mhs" value="{{$data->id}}">
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tugaskan</button>
                    </div>

                </form>
                </div>
                <!-- /.modal-content -->
              </div>
              <!-- /.modal-dialog -->
            </div>

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
@endpush
