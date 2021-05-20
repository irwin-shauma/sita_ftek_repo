@extends('template.main')
@section('title', 'Penjadwalan Kolokium Lanjut')
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
                        <h4 class="modal-title">Penjadwalan Kolokium Lanjut</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                    <form action="{{ route('korkon_tek_kom_penjadwalan_lanjut_data') }}" method="POST">
                    @csrf
                        <div class="row">
                            <div class="col-md-6"> 
                                <h5>NIM : {{ $data->nim }}</h5> 
                            </div>
                        </div>

                        <div class="form-group mt-2">
                                <label for="penjadwalan">Penjadwalan Kolokium Lanjut</label>
                                <input type="date" min="{{ $current->format('Y-m-d') }}" id="penjadwalan" name="penjadwalan" class="form-control @error('penjadwalan') is-invalid @enderror">
                                <div class="text-danger">
                                    @error('penjadwalan')
                                    {{ $message }}
                                    @enderror
                                </div>
                            
                                <label for="pilih_reviewer1" class="mt-3">Reviewer 1</label>
                                <input type="text" class="form-control mb-3" id="pilih_reviewer1" placeholder="{{$reviewer1[$loop->index]}}" name="pilih_reviewer1" value="{{$reviewer1[$loop->index]}}" readonly="readonly">
                                
                                <label for="pilih_reviewer2" class="mt-3">Reviewer 2</label>
                                <input type="text" class="form-control mb-3" id="pilih_reviewer2" placeholder="{{$reviewer2[$loop->index]}}" name="pilih_reviewer2" value="{{$reviewer2[$loop->index]}}" readonly="readonly">
                                <input type="hidden" class="form-control" name="id_mhs" value="{{$data->id}}">
                                
                        </div>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
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
