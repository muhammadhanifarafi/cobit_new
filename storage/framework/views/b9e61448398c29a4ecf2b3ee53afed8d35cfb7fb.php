<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Dokumen Perencanaan UAT</title>
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

<?php $__currentLoopData = $dataUserAcceptanceTesting; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $useracceptancetesting): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<div class="header">
    <table>
        <tr>
            <td rowspan="4">
                <img src="data:image/png;base64,<?php echo e(base64_encode(file_get_contents(public_path('img/logo_ptsi.png')))); ?>" alt="Logo" width="100">
            </td>
            <td rowspan="4" class="text-center" style="width:350px;">
                <h3>Perencanaan User Acceptance Testing (UAT)</h3>
            </td>
            <td class="side-content-header">No. Dokumen</td>
            <td class="side-content-header">FP-DTI03-F</td>
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

<h4 class="text-right" style="font-size:11px;"><strong>NO: <?php echo e($useracceptancetesting->first()->nomor_proyek); ?></strong></h4>
<h3 class="text-center bold" style="font-size:11px;">PERENCANAAN USER ACCEPTANCE TESTING (UAT)</h3>
<table style="font-size:11px;">
    <tr>
        <td>Nama Aplikasi</td>
        <td><?php echo e($useracceptancetesting->nama_aplikasi); ?></td>
    </tr>
    <tr>
        <td>Jenis Aplikasi</td>
        <td><?php echo e($useracceptancetesting->jenis_aplikasi); ?></td>
    </tr>
    <tr>
        <td>Kebutuhan Fungsional</td>
        <td><?php echo e($useracceptancetesting->kebutuhan_nonfungsional); ?></td>
    </tr>
    <tr>
        <td>Unit Pemilik Proses Bisnis</td>
        <td><?php echo e($useracceptancetesting->unit_pemilik_proses_bisnis); ?></td>
    </tr>
    <tr>
        <td>Lokasi Pengujian</td>
        <td><?php echo e($useracceptancetesting->lokasi_pengujian); ?></td>
    </tr>
    <tr>
        <td>Tanggal Pengujian</td>
        <td><?php echo e(\Carbon\Carbon::parse($useracceptancetesting->tgl_pengujian)->format('d M Y')); ?></td>
    </tr>
    <tr>
        <td>Manual Book</td>
        <td><?php echo e($useracceptancetesting->manual_book); ?></td>
    </tr>
</table>

<table class="table" style="font-size:11px;">
    <tr>
        <th class="text-center" colspan="2">Diketahui oleh</th>
        <th class="text-center" colspan="2">Disetujui oleh</th>
    </tr>
    <tr>
        <td colspan="2" style="height: 100px;"></td>
        <td colspan="2" style="height: 100px;"></td>
    </tr>
    <tr>
        <td class="text-center" colspan="2"><?php echo e($useracceptancetesting->nama_penyusun); ?><br><?php echo e($useracceptancetesting->jabatan_penyusun); ?></td>
        <td class="text-center" colspan="2"><?php echo e($useracceptancetesting->nama_penyetuju); ?><br><?php echo e($useracceptancetesting->jabatan_penyetuju); ?></td>
    </tr>
    <tr>
        <td class="text-center" colspan="2">Tanggal: <?php echo e(\Carbon\Carbon::parse($useracceptancetesting->tgl_disusun)->format('d-m-Y')); ?></td>
        <td class="text-center" colspan="2">Tanggal: <?php echo e(\Carbon\Carbon::parse($useracceptancetesting->tanggal_disetujui)->format('d-m-Y')); ?></td>
    </tr>
</table>

<?php if(!$loop->last): ?>
<div class="page-break"></div>
<?php endif; ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

</body>
</html>
<?php /**PATH C:\laragon\www\ptsi_\resources\views/user_acceptance_testing/dokumenperencanaan.blade.php ENDPATH**/ ?>