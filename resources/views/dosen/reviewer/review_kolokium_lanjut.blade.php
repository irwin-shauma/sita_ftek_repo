@extends('template.main')
@section('title', 'Review Proposal Lanjut')
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
                <form action="{{ route('review_kolokium_lanjut_action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="file_proposal" value="{{ $data_proposal1[$loop->index]->file_proposal }}">
                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="reviewer_ke" value="1">

                <button type="submit" class="btn btn-sm btn-info" formaction="{{ route('review_kolokium_lanjut_download') }}">Download</button>

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
                            <label for="komentar_reviewer" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama revisi (Optional)" id="komentar_reviewer" name="komentar_reviewer"></textarea>
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
                            Apakah anda ingin menyetujui proposal ini?
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
                <form action="{{ route('review_kolokium_lanjut_action') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" class="form-control" name="file_proposal" value="{{ $data_proposal2[$loop->index]->file_proposal }}">
                <input type="hidden" class="form-control" name="id_mhs" value="{{ $data->id }}">
                <input type="hidden" class="form-control" name="nim" value="{{ $data->nim }}">
                <input type="hidden" class="form-control" name="name" value="{{ $data->name }}">
                <input type="hidden" class="form-control" name="reviewer_ke" value="2">


                <button type="submit" class="btn btn-sm btn-info" formaction="{{ route('review_kolokium_lanjut_download') }}">Download</button>

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
                            <label for="komentar_reviewer" class="mt-3">Pesan/Komentar</label>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" placeholder="Anda bisa memasukkan pesan/komentar untuk dikirimkan bersama revisi (Optional)" id="komentar_reviewer" name="komentar_reviewer"></textarea>
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
                            Apakah anda ingin menyetujui proposal ini?
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
