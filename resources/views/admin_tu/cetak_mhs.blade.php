<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>MAHASISWA</title>
  <style>
    table {
      border-collapse: collapse;
    }
    thead{
      display: table-header-group;
    }
    th {
      background-color : lightblue;
    }
    tfoot {
      display: table-row-group;
    }
    tr {
      page-break-inside: avoid;
    }
    tr:nth-child(even) {
      background-color: lightgray;
    }
    h2 {
      text-align: center;
    }
  </style>
</head>
<body>
  <h2>Tabel Daftar Mahasiswa FTEK</h2>
<div>
    <table width="100%" align="center" border="1">
        <thead align="center">
            <tr>
              <th>No</th>
              <th>NIM</th>
              <th>Nama Mahasiswa</th>
              <th>Status</th>
              <th>Pembimbing 1</th>
              <th>Pembimbing 2</th>
            </tr>
        </thead>
        <tbody align="center">
          @foreach($lists as $data)
          <tr>
              <td>{{$loop->iteration}}</td>
              <td>{{$data->nim}}</td>
              <td>{{$data->name}}</td>
              {{-- <td>{{$data->progress}}</td> --}}
              <td>
                @switch($data->progress)
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
              <td>{{$dosen_pembimbing_1[$loop->index][0]->name }}</td>
              <td>{{$dosen_pembimbing_2[$loop->index][0]->name }}</td>
          </tr>
        @endforeach 
        </tbody>
    </table>
</div>
</body>
</html>

