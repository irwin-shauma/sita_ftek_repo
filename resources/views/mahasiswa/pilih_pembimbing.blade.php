@extends('template.main')
@section('title', 'Pilih Pembimbing')
@section('content')
@if ($progress === null)
    
    <p>Silahkan memilih dosen pembimbing I dan pembimbing II</p>

    <form action="{{ route('data_pembimbing') }}" method="POST" enctype="multipart/form-data">
    @csrf
        <div class="content">
            <div class="row">
                <div class="col-sm-6 mt-2">
                
                    <label for="pilih_dosen1" class="mt-3">Pilih Dosen Pembimbing 1</label>
                        <select class="browser-default custom-select rounded-0 mt-2" id='pilih_dosen1' name="pilih_dosen1">
                            @foreach ($dosen as $dsn)
                                <option value="{{ $dsn->id }}">{{ $dsn->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">
                            @error('pilih_dosen1')
                            {{ $message }}
                            @enderror
                        </div>

                    <label for="pilih_dosen2" class="mt-3">Pilih Dosen Pembimbing 2</label>
                        <select class="browser-default custom-select rounded-0 mt-2" id='pilih_dosen2' name="pilih_dosen2">
                            @foreach ($dosen as $dsn)
                                <option value="{{ $dsn->id }}">{{ $dsn->name }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger">
                            @error('pilih_dosen2')
                                <strong>{{ $message }}</strong>
                        @enderror
                        </div>
                    <div class="form-group mt-3">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal_simpan">Simpan</button>
                    </div>

                    {{-- Modal Begin --}}
                    <div class="modal fade" id="modal_simpan">
                        <div class="modal-dialog">
                        <div class="modal-content bg-white">
                
                            <div class="modal-header">
                            <h4 class="modal-title">Konfirmasi</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            </div>
                
                            <div class="modal-body">
                            Apakah anda yakin ingin menyimpan pilihan dosen pembimbing anda? 
                            <br>
                            (Data yang tersimpan tidak bisa diubah lagi)
                            </div>
                                
                            <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                            <button type="submit" name="action" value="simpan" class="btn btn-success">Simpan</button>
                            </div>
                
                        </div>
                        <!-- /.modal-content -->
                        </div>
                        <!-- /.modal-dialog -->
                    </div>
                    {{-- Modal End --}}

                </div>
            </div>
        </div>
    </form>

@else
    <p>Anda sudah memilih dosen pembimbing.</p>
    <label for="dosen_pembimbing_1">Dosen Pembimbing I</label>
    <input type="text" class="form-control mb-3" id="dosen_pembimbing_1" placeholder="{{ $pembimbing[0] }}" disabled>
    <label for="dosen_pembimbing_2">Dosen Pembimbing II</label>
    <input type="text" class="form-control mb-3" id="dosen_pembimbing_2" placeholder="{{ $pembimbing[1] }}" disabled>
@endif
@endsection