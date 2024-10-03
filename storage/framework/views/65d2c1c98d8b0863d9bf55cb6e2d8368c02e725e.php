

<?php $__env->startSection('title'); ?>
  Dashboard Monitoring Project
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('breadcrumb'); ?>
    <li class="active">Dashboard Monitoring Project</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<style>
    .wizard-steps {
        padding: 1%;
        display: flex;
        flex-direction: row; /* Ini akan membuat elemen-elemen di dalamnya ditampilkan secara vertikal */
    }
</style>
<div class="row">
        <div class="col-lg-6 col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Permintaan Pengembangan</h3>
                    <br>
                </div>
                <!-- /.box-header -->
                <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box" style="background-color:#ebab34">
                        <div class="inner">
                            <div class="wizard-steps">
                                <div class="col">
                                    <h3 style="text-align:center;color:black"><?php echo e($trx_permintaan_pengembangan-> all_task); ?></h3>
                                    <p>All Task</p>
                                </div>
                                <div class="col" style="padding-left: 70px;">
                                    <h3 style="text-align:center;color:green"><?php echo e($trx_permintaan_pengembangan-> done); ?></h3>
                                    <p>Done</p>
                                </div>
                                <div class="col" style="padding-left: 70px;">
                                    <h3 style="text-align:center;color:yellow"><?php echo e($trx_permintaan_pengembangan-> on_progress); ?></h3>
                                    <p>On Progress</p>
                                </div>
                            </div>
                        <!-- <b>0%</b> -->
                        </div>
                        <div class="icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                    </div>
                </div>
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_permintaan_pengembangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data->nomor_dokumen); ?></td>
                                <td><a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                                    onclick="showDetail(1)">Show detail <i class="fa fa-arrow-circle-right"></i>
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Persetujuan Pengembangan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example2" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_persetujuan_pengembangan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data->nomor_dokumen); ?></td>
                                <td><a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                                    onclick="showDetail(2)">Show detail <i class="fa fa-arrow-circle-right"></i>
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Perencanaan Proyek</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example3" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_perencanaan_proyek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data->nomor_dokumen); ?></td>
                                <td><a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                                    onclick="showDetail(3)">Show detail <i class="fa fa-arrow-circle-right"></i>
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Perencanaan Kebutuhan</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example4" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_perencanaan_kebutuhan; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data->nomor_dokumen); ?></td>
                                <td><a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                                    onclick="showDetail(4)">Show detail <i class="fa fa-arrow-circle-right"></i>
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Analisis Desain</h3>
                    <br>
                </div>
                <!-- /.box-header -->
                <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <div class="wizard-steps">
                                <div class="col">
                                    <h3><?php echo e($trx_analisis_desain-> all_task); ?></h3>
                                    <p>All Task</p>
                                </div>
                                <div class="col" style="padding-left: 70px;">
                                    <h3 style="text-align:center;"><?php echo e($trx_analisis_desain-> done); ?></h3>
                                    <p>Done</p>
                                </div>
                                <div class="col" style="padding-left: 70px;">
                                    <h3 style="text-align:center;"><?php echo e($trx_analisis_desain-> on_progress); ?></h3>
                                    <p>On Progress</p>
                                </div>
                            </div>
                        <!-- <b>0%</b> -->
                        </div>
                        <div class="icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example5" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_analisis_desain; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data->nomor_dokumen); ?></td>
                                <td><a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                                    onclick="showDetail(5)">Show detail <i class="fa fa-arrow-circle-right"></i>
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">User Acceptance Testing</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example6" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_user_acceptance_testing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data->nomor_dokumen); ?></td>
                                <td><a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                                    onclick="showDetail(6)">Show detail <i class="fa fa-arrow-circle-right"></i>
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Quality Assurance Testing</h3>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example7" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_quality_assurance_testing; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data->nomor_dokumen); ?></td>
                                <td><a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                                    onclick="showDetail(7)">Show detail <i class="fa fa-arrow-circle-right"></i>
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <div class="col-lg-6 col-xs-6">
            <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Berita Acara Serah Terima</h3>
                    <br>
                </div>
                <!-- /.box-header -->
                <div class="col-lg-12 col-xs-6">
                    <!-- small box -->
                    <div class="small-box bg-green">
                        <div class="inner">
                            <div class="wizard-steps">
                                <div class="col">
                                    <h3><?php echo e($trx_serah_terima_aplikasi-> all_task); ?></h3>
                                    <p>All Task</p>
                                </div>
                                <div class="col" style="padding-left: 70px;">
                                    <h3 style="text-align:center;"><?php echo e($trx_serah_terima_aplikasi-> done); ?></h3>
                                    <p>Done</p>
                                </div>
                                <div class="col" style="padding-left: 70px;">
                                    <h3 style="text-align:center;"><?php echo e($trx_serah_terima_aplikasi-> on_progress); ?></h3>
                                    <p>On Progress</p>
                                </div>
                            </div>
                        <!-- <b>0%</b> -->
                        </div>
                        <div class="icon">
                            <i class="fa fa-bar-chart"></i>
                        </div>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example8" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Nomor Dokumen</th>
                                <th>Detail</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $data_serah_terima_aplikasi; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($data->nomor_dokumen); ?></td>
                                <td><a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                                    onclick="showDetail(8)">Show detail <i class="fa fa-arrow-circle-right"></i>
                                    <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.box-body -->
            </div>
        </div>
      </div>
      <?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<!-- ChartJS -->
<script src="<?php echo e(asset('AdminLTE-2/bower_components/chart.js/Chart.js')); ?>"></script>
<script>
  $(function() {
      // Get context with jQuery - using jQuery's .get() method.
      var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
      // This will get the first returned node in the jQuery collection.
      var salesChart = new Chart(salesChartCanvas);

      var salesChartData = {
          labels: <?php echo e(json_encode($data_tanggal)); ?>,
          datasets: [
              {
                  label: 'Pendapatan',
                  fillColor           : 'rgba(60,141,188,0.9)',
                  strokeColor         : 'rgba(60,141,188,0.8)',
                  pointColor          : '#3b8bba',
                  pointStrokeColor    : 'rgba(60,141,188,1)',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(60,141,188,1)',
                  data: <?php echo e(json_encode($data_pendapatan)); ?>

              }
          ]
      };

      var salesChartOptions = {
          pointDot : false,
          responsive : true
      };

      salesChart.Line(salesChartData, salesChartOptions);
  });

  function showDetail(id) {
    $('#detailModal').modal('show');
    $.ajax({
      url: '/dashboard/getDetail/' + id,
      type: 'GET',
      success: function(response) {
        $('#detailTable tbody').empty();
        // Inisialisasi nomor urut
        let no = 1;

        // Looping dan masukkan data ke dalam tabel
        response.forEach(function(item) {
                // Tentukan kelas warna berdasarkan nilai progress
                let progressClass = '';
                let progressText = '';

                if (item.progress === 100) {
                    progressClass = 'btn-success'; // Warna hijau untuk 100%
                    progressText = 'Done';
                } else if (item.progress === 0) {
                    progressClass = 'btn-danger'; // Warna merah untuk 0%
                    progressText = 'Belum Dimulai';
                } else {
                    progressClass = 'btn-warning'; // Warna kuning untuk 1-99%
                    progressText = item.progress + '%'; // Tampilkan nilai progress
                }

                $('#detailTable tbody').append(
                  `<tr>
                        <td>${no++}</td>
                        <td>${item.nomor_dokumen}</td>
                        <td>${item.latar_belakang}</td>
                        <td>${item.pic}</td>
                        <td><button class="btn ${progressClass} btn-sm">${progressText}</button></td>
                    </tr>`
                );
        });
      }
    });
  }
</script>
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel"><b>Detail Data Project Berjalan</h5></b></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered" id="detailTable">
          <thead>
            <tr>
              <th>No. </th>
              <th>Nomor Project</th>
              <th>Nama Project</th>
              <th>PIC</th>
              <th>Progress Pengerjaan</th>
            </tr>
          </thead>
          <tbody>
            <!-- Data akan dimasukkan secara dinamis oleh JavaScript -->
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
  $(function () {
    $('#example1').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false
    })
    $('#example2').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false
    })
    $('#example3').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false
    })
    $('#example4').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false
    })
    $('#example5').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false
    })
    $('#example6').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false
    })
    $('#example7').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false
    })
    $('#example8').DataTable({
        "pageLength": 10,
        "lengthChange": false,
        "searching": false
    })
  })
</script>
<script>
  function showDetail(id) {
    $('#detailModal').modal('show');
    $.ajax({
      url: '/dashboard/getDetail/' + id,
      type: 'GET',
      success: function(response) {
        $('#detailTable tbody').empty();
        // Inisialisasi nomor urut
        let no = 1;

        // Looping dan masukkan data ke dalam tabel
        response.forEach(function(item) {
                // Tentukan kelas warna berdasarkan nilai progress
                let progressClass = '';
                let progressText = '';

                if (item.progress === 100) {
                    progressClass = 'btn-success'; // Warna hijau untuk 100%
                    progressText = 'Done';
                } else if (item.progress === 0) {
                    progressClass = 'btn-danger'; // Warna merah untuk 0%
                    progressText = 'Belum Dimulai';
                } else {
                    progressClass = 'btn-warning'; // Warna kuning untuk 1-99%
                    progressText = item.progress + '%'; // Tampilkan nilai progress
                }

                $('#detailTable tbody').append(
                  `<tr>
                        <td>${no++}</td>
                        <td>${item.nomor_dokumen}</td>
                        <td>${item.latar_belakang}</td>
                        <td>${item.pic}</td>
                        <td><button class="btn ${progressClass} btn-sm">${progressText}</button></td>
                    </tr>`
                );
        });
      }
    });
  }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ptsi_\resources\views/admin/dashboard_dev_data_ver3.blade.php ENDPATH**/ ?>