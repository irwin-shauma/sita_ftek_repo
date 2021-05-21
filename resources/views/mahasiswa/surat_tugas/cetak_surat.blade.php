@extends('template.main')
@section('title', 'Cetak Surat Tugas')
@section('content')
@if ($data_mhs->progress > 1 )
  @if ($data_nomor_surat->judul === null)
    <form method="post" action="{{ route('surat_tugas') }}">
      @csrf
      <div class="form-group">
        <label for="nomor_surat">Nomor Surat Tugas</label>
        <input type="text" class="form-control mb-3" id="nomor_surat" placeholder="{{$data_nomor_surat->nomor}}" name="nomor_surat" value="{{ $data_nomor_surat->nomor }}" readonly="readonly">
        <label for="judul_skripsi">Judul Skripsi</label>
        <input type="text" class="form-control mb-3" id="judul_skripsi" placeholder="Masukkan judul skripsi anda" name="judul_skripsi">
        <input type="hidden" class="form-control" id="dosen_1" name="dosen_1" value="{{ $data_dosen[0] }}">
        <input type="hidden" class="form-control" id="dosen_2" name="dosen_2" value="{{ $data_dosen[1] }}">
        <input type="hidden" class="form-control" id="tanggal_awal" name="tanggal_awal" value="{{ $data_nomor_surat->tanggal_awal }}">
        <input type="hidden" class="form-control" id="tanggal_akhir" name="tanggal_akhir" value="{{ $data_nomor_surat->tanggal_akhir }}">
        @if ($jenis_nim === '61')
          <input type="hidden" class="form-control" id="kaprogdi" name="kaprogdi" value="{{ $kaprogdi_elektro }}">
        @elseif ($jenis_nim === '62')
          <input type="hidden" class="form-control" id="kaprogdi" name="kaprogdi" value="{{ $kaprogdi_tekkom }}">
        @endif
        <label for="spesifikasi_skripsi">Spesifikasi</label>
        <textarea name="spesifikasi_skripsi" id="spesifikasi_skripsi" cols="30" rows="10" placeholder="Masukkan spesifikasi skripsi anda"></textarea>
      
        <label class="mt-3" for="uraian_tugas_skripsi">Uraian Tugas</label>
        <textarea class="mb-3" name="uraian_tugas_skripsi" id="uraian_tugas_skripsi" cols="30" rows="10" placeholder="Masukkan uraian tugas skripsi anda"></textarea>

        <label class="mt-3" for="jenis_skripsi">Pilih Jenis Skripsi</label>
        <select id="jenis_skripsi" name="jenis_skripsi" class="custom-select mb-3">
          <option value="penelitian">Penelitian</option>
          <option value="perancangan">Perancangan</option>
          <option value="studi_sistem">Studi Sistem</option>
          <option value="studi_pustaka">Studi Kepustakaan</option>
          <option value="kerja_lab">Kerja Laboratorium</option>
        </select>
      </div>
      <div class="row">
        <div class="col">
          <button type=”submit” name='action' value="preview" class="btn btn-info btn-block" onclick="$('form').attr('target', '_blank');">Preview</button>
        </div>
        <div class="col">
          <button type="button" name='simpan' class="btn btn-success btn-block" data-toggle="modal" data-target="#modal_simpan">Simpan</button>
        </div>
      </div>

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
              Apakah anda yakin ingin menyimpan surat tugas ini? 
              <br>
              (Data yang tersimpan tidak bisa diubah lagi)
            </div>
                
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              <button type="submit" name="action" value="simpan" class="btn btn-success" onclick="$('form').attr('target', '_self');">Simpan</button>
            </div>

          </div>
        </div>
      </div>
    </form>

  @else
    <p> Anda sudah menyimpan surat tugas. </p>
    <label for="nomor_surat">Nomor Surat Tugas</label>
    <input type="text" class="form-control mb-3" id="nomor_surat" placeholder="{{$data_nomor_surat->nomor}}" disabled>
    <label for="judul_skripsi">Judul Skripsi</label>
    <input type="text" class="form-control mb-3" id="judul_skripsi" placeholder="{{ $data_nomor_surat->judul }}" disabled>
    <h3>Silahkan download surat tugas skripsi anda disini : </h3>
    <a href="{{ route('download_surat_tugas', ['user' =>$data_mhs->nim]) }}" class="btn btn-lg btn-warning">Download</a>  
  @endif
@else
    <p>Anda belum menyelesaikan Kolokium Awal!</p>
@endif
@endsection

@push('ckeditor')
<script>
ClassicEditor
    .create( document.querySelector( '#spesifikasi_skripsi'), {
    toolbar: {
					items: [
						'bold',
						'italic',
						'underline',
						'bulletedList',
						'numberedList',
						'|',
						'outdent',
						'indent',
						'|',
						'undo',
						'redo',
						'specialCharacters',
						'removeFormat'
					]
				},
				language: 'id',
				licenseKey: '',
				
      })
    .catch( error => {
        console.error( error );
    } );
</script>
<script>
ClassicEditor
    .create( document.querySelector( '#uraian_tugas_skripsi'), {
    toolbar: {
					items: [
						'bold',
						'italic',
						'underline',
						'bulletedList',
						'numberedList',
						'|',
						'outdent',
						'indent',
						'|',
						'undo',
						'redo',
						'specialCharacters',
						'removeFormat'
					]
				},
				language: 'id',
				licenseKey: '',
				
      })
    .setData(
      'test'
    )
    .catch( error => {
        console.error( error );
    } );
</script>
@endpush