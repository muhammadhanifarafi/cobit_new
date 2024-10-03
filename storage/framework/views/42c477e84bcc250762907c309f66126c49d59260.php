

<?php $__env->startSection('title'); ?>
  Dashboard Monitoring Project <b><?php echo e($totalTasks); ?> Task</b>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('breadcrumb'); ?>
    <?php echo \Illuminate\View\Factory::parentPlaceholder('breadcrumb'); ?>
    <!-- <li class="active">Dashboard Monitoring Project</li> -->
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
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
                <div class="wizard-steps">
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(1,1)" style="text-align:center;color:black;text-decoration:none;">
                            <h3><?php echo e($trx_permintaan_pengembangan); ?></h3>
                         </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(1,2)" style="text-align:center;color:green;text-decoration:none;">
                            <h3><?php echo e($is_approve_permintaan_pengembangan); ?></h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(1,3)" style="text-align:center;color:white;text-decoration:none;">
                            <h3><?php echo e($is_not_approve_permintaan_pengembangan); ?></h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="inner">
              <!-- <h3><?php echo e($trx_permintaan_pengembangan); ?></h3> -->
              <p>Permintaan Pengembangan</p>
              <!-- <b>0%</b> -->
            </div>
            <div class="col-lg-12 col-xs-6">
                <!-- small box -->
            </div>
            <!-- <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div> -->
            <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
              onclick="showDetail(1)">Show detail <i class="fa fa-arrow-circle-right"></i>
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
          <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box" style="background-color : #9da832;">
              <div class="inner">
                  <div class="wizard-steps">
                      <div class="col">
                          <a href="javascript:void(0)" onclick="showDetail(2,1)" style="text-align:center;color:black;text-decoration:none;">
                              <h3><?php echo e($trx_persetujuan_pengembangan); ?></h3>
                          </a>
                      </div>
                      <div class="col">
                          <a href="javascript:void(0)" onclick="showDetail(2,2)" style="text-align:center;color:green;text-decoration:none;">
                            <h3><?php echo e($is_approve_persetujuan_pengembangan); ?></h3>
                          </a>
                      </div>
                      <div class="col">
                          <a href="javascript:void(0)" onclick="showDetail(2,3)" style="text-align:center;color:white;text-decoration:none;">
                            <h3><?php echo e($is_not_approve_persetujuan_pengembangan); ?></h3>
                          </a>
                      </div>
                  </div>
              </div>
              <div class="inner">
                <!-- <h3><?php echo e($trx_persetujuan_pengembangan); ?></h3> -->
                <p>Persetujuan Pengembangan</p>
                <!-- <b>0%</b> -->
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
              <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
                onclick="showDetail(2)">Show detail <i class="fa fa-arrow-circle-right"></i>
                <i class="fas fa-pencil-alt"></i>
              </a>
            </div>
          </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
                  <div class="wizard-steps">
                      <div class="col">
                          <a href="javascript:void(0)" onclick="showDetail(3,1)" style="text-align:center;color:black;text-decoration:none;">
                              <h3><?php echo e($trx_perencanaan_proyek); ?></h3>
                          </a>
                      </div>
                      <div class="col">
                          <a href="javascript:void(0)" onclick="showDetail(3,2)" style="text-align:center;color:green;text-decoration:none;">
                              <h3><?php echo e($is_approve_perencanaan_proyek); ?></h3>
                          </a>
                      </div>
                      <div class="col">
                          <a href="javascript:void(0)" onclick="showDetail(3,3)" style="text-align:center;color:white;text-decoration:none;">
                              <h3><?php echo e($is_not_approve_perencanaan_proyek); ?></h3>
                          </a>
                      </div>
                  </div>
              </div>
            <div class="inner">
              <!-- <h3><?php echo e($trx_perencanaan_proyek); ?></h3> -->
              <p>Perencanaan Proyek</p>
              <!-- <b>0%</b> -->
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
              onclick="showDetail(3)">Show detail <i class="fa fa-arrow-circle-right"></i>
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: grey; color: black;" >
            <div class="inner">
                <div class="wizard-steps">
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(4,1)" style="text-align:center;color:green;text-decoration:none;">
                            <h3>15</h3>
                         </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(4,2)" style="text-align:center;color:yellow;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(4,3)" style="text-align:center;color:red;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(1,4)" style="text-align:center;color:white;text-decoration:none;">
                            <h3>10</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="inner">
              <!-- <h3></h3> -->
              <p>Perencanaan Kebutuhan</p>
              <!-- <b>5%</b> -->
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
              onclick="showDetail(4)">Show detail <i class="fa fa-arrow-circle-right"></i>
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: #eab676; color: black;">
            <div class="inner">
                <div class="wizard-steps">
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(5,1)" style="text-align:center;color:green;text-decoration:none;">
                            <h3>15</h3>
                         </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(5,2)" style="text-align:center;color:yellow;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(5,3)" style="text-align:center;color:red;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(5,4)" style="text-align:center;color:white;text-decoration:none;">
                            <h3>10</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="inner">
              <h3></h3>
              <p>Analisis Desain</p>
              <!-- <b>25%</b> -->
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
              onclick="showDetail(5)">Show detail <i class="fa fa-arrow-circle-right"></i>
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: brown; color: black;">
            <div class="inner">
                <div class="wizard-steps">
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(6,1)" style="text-align:center;color:green;text-decoration:none;">
                            <h3>15</h3>
                         </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(6,2)" style="text-align:center;color:yellow;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(6,3)" style="text-align:center;color:red;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(6,4)" style="text-align:center;color:white;text-decoration:none;">
                            <h3>10</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="inner">
              <h3></h3>
              <p>User Acceptance Testing</p>
              <!-- <b>85%</b> -->
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
              onclick="showDetail(6)">Show detail <i class="fa fa-arrow-circle-right"></i>
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: #ff9966; color: black;">
            <div class="inner">
                <div class="wizard-steps">
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(7,1)" style="text-align:center;color:green;text-decoration:none;">
                            <h3>15</h3>
                         </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(7,2)" style="text-align:center;color:yellow;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(7,3)" style="text-align:center;color:red;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(7,4)" style="text-align:center;color:white;text-decoration:none;">
                            <h3>10</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="inner">
              <h3></h3>
              <p>Quality Assurance Testing</p>
              <!-- <b>95%</b> -->
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
              onclick="showDetail(7)">Show detail <i class="fa fa-arrow-circle-right"></i>
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: #999966; color: black;">
            <div class="inner">
                <div class="wizard-steps">
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(8,1)" style="text-align:center;color:green;text-decoration:none;">
                            <h3>15</h3>
                         </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(8,2)" style="text-align:center;color:yellow;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(8,3)" style="text-align:center;color:red;text-decoration:none;">
                            <h3>5</h3>
                        </a>
                    </div>
                    <div class="col">
                        <a href="javascript:void(0)" onclick="showDetail(8,4)" style="text-align:center;color:white;text-decoration:none;">
                            <h3>10</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="inner">
              <h3></h3>
              <p>Berita Acara Serah Terima</p>
              <!-- <b>100%</b> -->
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
              onclick="showDetail(8)">Show detail <i class="fa fa-arrow-circle-right"></i>
              <i class="fas fa-pencil-alt"></i>
            </a>
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

  function showDetail(id,id2) {
    $('#detailModal').modal('show');
    $.ajax({
      url: '/dashboard/getDetail2/' + id + '/' + id2,
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\ptsi_\resources\views/admin/dashboard_dev_data_ver4.blade.php ENDPATH**/ ?>