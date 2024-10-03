<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Dokumen Perencanaan Kebutuhan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        .no-border {
            border: none;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .text-left {
            text-align: left;
        }
        .bold {
            font-weight: bold;
        }
        .page-break {
            page-break-after: always;
        }
        .side-content-header{
            font-size: 11px;
        }
    </style>
</head>
<body>

@foreach($datakebutuhan as $kebutuhan)
<div class="header">
    <table>
        <tr>
            <td rowspan="4">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/logo_ptsi.png'))) }}" alt="Logo" width="100">
            </td>
            <td rowspan="4" class="text-center" style="width:350px;">
                <h3>Perencanaan Proyek Pengembangan Sistem Informasi</h3>
            </td>
            <td class="side-content-header">No. Dokumen</td>
            <td class="side-content-header">FP-DTI03-0C</td>
        </tr>
        <tr class="side-content-header">
            <td>No. Revisi</td>
            <td>0</td>
        </tr>
        <tr class="side-content-header">
            <td>Tanggal Revisi</td>
            <td>2024</td>
        </tr>
        <tr class="side-content-header">
            <td>Halaman</td>
            <td>1</td>
        </tr>
    </table>
</div>

<h4 class="text-right" style="font-size:11px;"><strong>NO: {{--{{ $datapermintaan->first()->nomor_dokumen }}--}}</strong></h4>
<h3 class="text-center bold" style="font-size:11px;">PERANCANAAN KEBUTUHAN SISTEM INFORMASI</h3>
<div class="bordered">
    <table class="table-container" style="font-size:11px;">
        <tr>
            <th style="width: 25%;">Nomor Proyek</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">xxxxxxxxxxxxx (Nomor Proyek Perlu disepakati)</td>
        </tr>
        <tr>
            <th style="width: 25%;">Nama Proyek</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">{{ $kebutuhan->nama_proyek }}</td>
        </tr>
        <tr>
            <th style="width: 25%;">Deskripsi</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">{{ $kebutuhan->deskripsi }}</td>
        </tr>
        <tr>
            <th style="width: 25%;">Pemilik Proyek</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">{{ $kebutuhan->pemilik_proyek }}</td>
        </tr>
        <tr>
            <th style="width: 25%;">Manajer Proyek</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">{{ $kebutuhan->manajer_proyek }}</td>
        </tr>
        <tr>
            <th style="width: 25%;">Stakeholders</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">{{ $kebutuhan->stakeholders }}</td>
        </tr>
        <tr>
            <th style="width: 25%;">Kebutuhan Fungsional</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">{{ $kebutuhan->kebutuhan_fungsional }}</td>
        </tr>
        <tr>
            <th style="width: 25%;">Kebutuhan Non-Fungsional</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">{{ $kebutuhan->kebutuhan_nonfungsional }}</td>
        </tr>
        <tr>
            <th style="width: 25%;">Lampiran</th>
            <td style="width: 5%;">:</td>
            <td style="width: 70%;">{{ $kebutuhan->lampiran }}</td>
        </tr>
    </table>

    <table class="table" style="font-size:11px;">
        <tr>
            <th class="text-center" colspan="2">Disiapkan oleh</th>
            <th class="text-center" colspan="2">Disetujui oleh</th>
        </tr>
        <tr>
            <td colspan="2" style="height: 100px;"></td>
            <td colspan="2" style="height: 100px;"></td>
        </tr>
        <tr>
            <td class="text-center" colspan="2">{{ $kebutuhan->nama_pemohon }}<br>{{$kebutuhan->jabatan_pemohon}}</td>
            <td class="text-center" colspan="2">{{ $kebutuhan->nama }}<br>{{$kebutuhan->jabatan}}</td>
        </tr>
        <tr>
            <td class="text-center" colspan="2">Tanggal: {{ \Carbon\Carbon::parse($kebutuhan->tanggal_disiapkan)->format('d-m-Y') }}</td>
            <td class="text-center" colspan="2">Tanggal: {{ \Carbon\Carbon::parse($kebutuhan->tanggal_disetujui)->format('d-m-Y') }}</td>
        </tr>
    </table>

    @if (!$loop->last)
    <div class="page-break"></div>
    @endif

@endforeach

</body>
</html>
