<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Surat Tugas {{ $data->nim }}</title>
    {{-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"> --}}
     
</head>
<body>
    {{-- {{ { !! $hasil['surat_tugas'] !!} }}}  }   --}}
    {{-- {!!$surat_tugas!!} --}}
    <table align="center" border="0">
        <thead>
            {{-- <tr>
                <td>
                    
                    <img src="{{ public_path("kop_surat.png") }}" alt="" width="900">
                </td>
            </tr> --}}
            {{-- <tr>
                <td>
                    <hr>    
                </td>
            </tr> --}}
        </thead>
        <tbody>
            <tr>
                {{-- <td align="right">Salatiga, {{ $current->isoFormat('LL') }}</td> --}}
                <td align="right">Salatiga, {{ $tanggal_awal }}</td>
                {{-- <td><p align="right">Salatiga, {{ $current->isoFormat('LL') }}</p> </td> --}}
            </tr>
            <tr>
                {{-- <td>Nomor : 31/I.3/FTEK/{{ $bulan_romawi . '/' . $current->year }}</td> --}}
                <td>Nomor : {{ $nomor_surat }}</td>
            </tr>
            <tr>
                <td><b>Hal : Tugas Skripsi </b></td>
            </tr>
            <tr>
                <td align="right"><p> Kepada yang terhormat,
                    <br>
                    <b>Sdr. {{ $data->name }} - {{ $data->nim }}</b>
                    <br>
                    Fakultas Teknik Elektronika dan Komputer
                    <br>
                    Universitas Kristen Satya Wacana
                    <br>
                    {{-- (Yang ini akan saya urutkan dengan CSS) --}}
                </p></td>
            </tr>
            <tr>
                <td>
                    Dengan ini Pimpinan Fakultas Teknik Elektronika dan Komputer Universitas Kristen Satya Wacana memberi tugas skripsi<br>
                    kepada saudara dalam bentuk <b>
                        @if ($jenis_skripsi === "perancangan")
                            Perancangan
                        @elseif ($jenis_skripsi === "penelitian")
                            Penelitian
                        @elseif ($jenis_skripsi === "studi_sistem")
                            Studi Sistem
                        @elseif ($jenis_skripsi === "studi_pustaka")
                            Studi Kepustakaan
                        @elseif ($jenis_skripsi === "kerja_lab")
                            Kerja Laboratorium
                        @endif
                    </b>
                </td>
                <tr>
                    <td>
                        <b>Judul : {{ $judul_skripsi }}</b>
                    </td>
                </tr>
                <tr>
                    <td>
                        <b>Beban : 6 SKS</b>
                    </td>
                </tr>
            </tr>
            <tr>
                <td>
                    <p><b><u><i> Spesifikasi Alat</i></u></b></p>
                    <p>{!!$spesifikasi_skripsi!!}</p>
                </td>
            </tr>

            <tr>
                <td>
                    <p><b><u><i> Uraian Tugas </i></u></b></p>
                    <p>{!!$uraian_tugas_skripsi!!}</p>
                    {{-- <p>{!!$testing!!}</p> --}}
                </td>
            </tr>

            <tr>
                <td>
                    <p><b><i><u>6 bulan setelah menerima Surat Tugas Skripsi ini harus melakukan Kolokium Lanjut</u></i></b></p>

                    {{-- <p>Waktu : <b>{{ $current->isoFormat('LL') }} - {{ $current->addMonths(9)->isoFormat('LL') }}</b></p> --}}
                    <p>Waktu : <b>{{ $tanggal_awal }} - {{ $tanggal_akhir }}</b></p>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Pembimbing : </p>
                    <p><b><i>Dosen 1 : {{ $dosen_1 }}</i></b> </p>
                    <p><b><i>Dosen 2 : {{ $dosen_2 }}</i></b> </p>
                </td>
            </tr>

            <tr>
                    <td align="right"><p> Pimpinan
                    <br>
                    Fakultas Teknik Elektronika dan Komputer
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <u>{{ $kaprogdi }}</u>
                    <br>
                    @if ($jenis_nim === '61')
                        Ka Program Studi Teknik Elektro    
                    @elseif ($jenis_nim === '62')
                        Ka Program Studi Teknik Komputer    
                    @endif
                    
                    </p>
                    </td>
                
            </tr>
            <tr>
                <td align="left">
                    <u><i><b>Tindasan: </b></i></u>
                    <br>
                    1. Ka. Konsentrasi
                    <br>
                    2. Wali Studi 
                    <br>
                    3. Pembimbing I 
                    <br>
                    4. Pembimbing II 
                    <br>
                    5. Arsip 
                </td>
            </tr>
        </tbody>
    </table>

    {{-- <p>Nama : {{ $data->name }}</p>
    <p>NIM : {{ $data->nim }}</p>
    <h1><p>Judul : {{ $judul_skripsi }}</p></h1> --}}
    {{-- <p><b><u>Spesifikasi Alat</u></b></p>
    <p>{!!$surat_tugas!!}</p> --}}

    <br><br>
    
    
    
</body>
</html>

