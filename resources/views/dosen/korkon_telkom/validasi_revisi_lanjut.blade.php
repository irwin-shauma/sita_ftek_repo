@extends('template.main')
@section('title', 'Validasi Revisi Lanjut')
@section('content')
<label for="example1">Tabel Validasi Revisi Proposal Kolokium Lanjut</label>

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
        @foreach($data_mhs as $data)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{$data->nim}}</td>
            <td>{{$data->name}}</td>
        <td>
            <button type="button" class="btn btn-sm btn-success verif" data-toggle="modal" data-target="#modal_validasi-{{ $data->nim }}">
                Validasi
            </button>
            
                {{-- Modal Edit --}}
            <div class="modal fade" id="modal_validasi-{{ $data->nim }}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content bg-white">

                    <div class="modal-header">
                        <h4 class="modal-title">Validasi Revisi Proposal Kolokium Lanjut</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                    
                    <form action="{{ route('korkon_telkom_validasi_revisi_lanjut_download') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <p>Nama : {{ $data->name }}</p>
                    <p>NIM : {{ $data->nim }}</p>
                    <table class='table table-bordered table-striped'>
                        <tbody>
                            <tr>
                                <td>Mahasiswa</td>
                                <td>
                                    @foreach ($data_proposal_seen as $item)
                                        @if ($item->mhs_id === $data->id)
                                            {{ $item->file_proposal }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    {{-- Form untuk tombol download --}}
                                    
                                        @csrf
                
                                        @foreach ($data_proposal_seen as $item)
                                        @if ($item->mhs_id === $data->id)
                                        <input type="hidden" class="form-control" name="nim" value="{{ $data->nim}}">
                                            <input type="hidden" class="form-control" name="id_mhs" value="{{ $item->mhs_id}}">
                                            <input type="hidden" class="form-control" name="file_proposal_mahasiswa" value="{{ $item->file_proposal}}">
                                                {{-- {{ $item->file_proposal }} --}}
                                            @endif
                                        @endforeach
                                        <button type="submit" class="btn btn-sm btn-info" name="action" value="mahasiswa">Download</button>
                                    {{-- </form> --}}

                                    
                                </td>
                            </tr>
                            <tr>
                                <td>Reviewer 1</td>

                                @if ($data_review1 == 'kosong')
                                    <td colspan="2">Reviewer 1 tidak memberikan revisi. </td>    
                                @else
                                    @foreach ($data_review1 as $item)
                                        @if ($item->mhs_id === $data->id && $item->file_proposal !== null)
                                            <td>{{ $item->file_proposal }}</td></td>
                                            <td>
                                                
                                                    @csrf
                                                        <input type="hidden" class="form-control" name="nim" value="{{ $data->nim}}">
                                                        <input type="hidden" class="form-control" name="id_mhs" value="{{ $item->mhs_id}}">
                                                        <input type="hidden" class="form-control" name="file_proposal_reviewer1" value="{{ $item->file_proposal}}">
                                                        <button type="submit" class="btn btn-sm btn-info" name="action" value="reviewer_1">Download</button>
                                                {{-- </form> --}}
                                            </td>
                                        @else
                                            <td colspan="2">Reviewer 1 tidak memberikan revisi. </td>
                                        @endif
                                    @endforeach
                                @endif
                            </tr>
                            <tr>
                                <td>Reviewer 2</td>
                                @if ($data_review2 == 'kosong')
                                    <td colspan="2">Reviewer 2 tidak memberikan revisi. </td>    
                                @else
                                    @foreach ($data_review2 as $item)
                                        @if ($item->mhs_id === $data->id && $item->file_proposal !== null)
                                            <td>{{ $item->file_proposal }} </td>
                                            <td>
                                                    @csrf
                                                        <input type="hidden" class="form-control" name="nim" value="{{ $data->nim}}">
                                                        <input type="hidden" class="form-control" name="id_mhs" value="{{ $item->mhs_id}}">
                                                        <input type="hidden" class="form-control" name="file_proposal_reviewer2" value="{{ $item->file_proposal}}">
                                                        <button type="submit" class="btn btn-sm btn-info" name="action" value="reviewer_2">Download</button>
                                                {{-- </form> --}}
                                            </td>
                                        @else
                                            <td colspan="2">Reviewer 2 tidak memberikan revisi. </td>    
                                        @endif
                                    @endforeach

                                @endif
                            </tr>
                        </tbody>
                    </table>
                    </div>

                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" formaction="{{ route('korkon_telkom_validasi_revisi_lanjut_validated') }}">Validasi</button>
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
