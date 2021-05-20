@extends('template.main')
@section('title', 'Daftar Bimbingan')
@section('content')
{{-- <a href="#" class="btn btn-warning btn-sm">Tambah Mahasiswa</a> --}}
{{-- <a href="/TU/daftar_mahasiswa/cetak_pdf" class="btn btn-primary btn-sm" target="_blank">Cetak PDF</a> <br> --}}
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h3 class="card-title">Pembimbing 1</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
          <table class='table table-bordered table-striped' id="example1">
            <thead>
              <tr>
                <th>No</th>
                <th>NIM</th>
                <th>NAMA</th>
                <th>PROGRESS</th>
                {{-- <th></th> --}}
              </tr>
            </thead>
            <tbody>
                @foreach ($mhs1 as $data)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $data[0]->nim}}</td>
                    <td>{{ $data[0]->name}}</td>
                    {{-- <td>{{ $data[0]->progress}}</td> --}}
                    <td>
                      @switch($data[0]->progress)
                          @case(0)
                              Kolokium Awal
                              @break
                          @case(1)
                              Menunggu Verifikasi Kolokium Awal
                              @break
                          @case(2)
                              Kolokium Lanjut
                              @break
                          @case(3)
                              Menunggu Verifikasi Kolokium Lanjut
                              @break
                          @case(4)
                              Pengajuan Review / Nilai Publikasi
                              @break
                          @case(5)
                              Menunggu Verifikasi Pengajuan Review / Nilai Publikasi
                              @break
                          @case(6)
                              Lulus
                              @break
                          @default
                        @endswitch
                        </td>
                  </tr>
                @endforeach
            </tbody>
          </table>
          
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
    <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Pembimbing 2</h3>
          </div>
          <!-- /.card-header -->
          <div class="card-body">
            <table class='table table-bordered table-striped' id="example2">
              <thead>
                <tr>
                  <th>No</th>
                  <th>NIM</th>
                  <th>NAMA</th>
                  <th>PROGRESS</th>
                  {{-- <th></th> --}}
                </tr>
              </thead>
              <tbody>
                  @foreach ($mhs2 as $data)
                  <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $data[0]->nim}}</td>
                      <td>{{ $data[0]->name}}</td>
                      {{-- <td>{{ $data[0]->progress}}</td> --}}
                      <td>
                      @switch($data[0]->progress)
                          @case(0)
                              Kolokium Awal
                              @break
                          @case(1)
                              Menunggu Verifikasi Kolokium Awal
                              @break
                          @case(2)
                              Kolokium Lanjut
                              @break
                          @case(3)
                              Menunggu Verifikasi Kolokium Lanjut
                              @break
                          @case(4)
                              Pengajuan Review / Nilai Publikasi
                              @break
                          @case(5)
                              Menunggu Verifikasi Pengajuan Review / Nilai Publikasi
                              @break
                          @case(6)
                              Lulus
                              @break
                          @default
                        @endswitch
                        </td>
                    </tr>
                  @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
  </div>
@endsection