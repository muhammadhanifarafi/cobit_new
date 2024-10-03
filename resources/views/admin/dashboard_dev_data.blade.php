@extends('layouts.master')

@section('title')
    Dashboard
@endsection

@section('breadcrumb')
    @parent
    <li class="active">Dashboard</li>
@endsection

@section('content')

<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{ $trx_perencanaan_proyek }}</h3>
              <p>Perencanaan</p>
            </div>
            <div class="icon">
              <i class="fa fa-shopping-cart"></i>
            </div>
            <a class="small-box-footer" href="javascript:void(0)" title="Show Detail"
              onclick="showDetail(1)">Show detail <i class="fa fa-arrow-circle-right"></i>
              <i class="fas fa-pencil-alt"></i>
            </a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{ $trx_perencanaan_kebutuhan}}</h3>
              <p>Analisis dan Desain</p>
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
              <h3>{{ $trx_analisis_desain}}</h3>
              <p>Pengembangan</p>
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
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $trx_user_acceptance_testing}}</h3>

              <p>User Acceptance Testing</p>
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
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{ $trx_quality_assurance_testing}}</h3>

              <p>Implementasi</p>
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
      </div>
      @endsection
@push('scripts')
<!-- ChartJS -->
<script src="{{ asset('AdminLTE-2/bower_components/chart.js/Chart.js') }}"></script>
<script>
  $(function() {
      // Get context with jQuery - using jQuery's .get() method.
      var salesChartCanvas = $('#salesChart').get(0).getContext('2d');
      // This will get the first returned node in the jQuery collection.
      var salesChart = new Chart(salesChartCanvas);

      var salesChartData = {
          labels: {{ json_encode($data_tanggal) }},
          datasets: [
              {
                  label: 'Pendapatan',
                  fillColor           : 'rgba(60,141,188,0.9)',
                  strokeColor         : 'rgba(60,141,188,0.8)',
                  pointColor          : '#3b8bba',
                  pointStrokeColor    : 'rgba(60,141,188,1)',
                  pointHighlightFill  : '#fff',
                  pointHighlightStroke: 'rgba(60,141,188,1)',
                  data: {{ json_encode($data_pendapatan) }}
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

    $.ajax({
      url: '/dashboard/getDetail/' + id,
      type: 'GET',
      success: function(response) {
        $('#detailTable tbody').empty();
        // Inisialisasi nomor urut
        let no = 1;

        // Looping dan masukkan data ke dalam tabel
        response.forEach(function(item) {
          $('#detailTable tbody').append(
            '<tr><td>' + no++ + '</td><td>' + item.nomor_proyek + '</td><td>' + item.deskripsi + '</td></tr>'
          );
        });
        $('#detailModal').modal('show');
      }
    });
  }
</script>
<!-- Modal -->
<div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel">Detail Data</h5>
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
              <th>Status</th>
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
@endpush