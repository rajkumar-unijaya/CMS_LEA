<?php 
    use miloschuman\highcharts\Highcharts;
   

?>

<div class="container-fluid">
    <h3 style="padding-top: 1.5rem;">Statistik / Laporan</h3>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="../dashboard/index">Laman Utama</a></li>
            <li class="breadcrumb-item active" aria-current="page">Statistik / Laporan</li>
        </ol>
    </nav>

    <div class="row">
			<div class="col-lg-12">	
         <div class="card-body">

               <div class="row">
						<div class="col-md-6">
							  <div class="form-group">
								    <label>Pilih Jenis Statistik<span class="text-danger">*</span></label>
                            <select class="custom-select rounded-0" name="Kes" id="kes">
                            <option value="0">-- Pilih Statistik --</option>
                           <option value="1">Kes Dihantar Per Tahun</option>
                           <option value="2">Kes Dihantar Per Bulan</option>
                           <option value="3">Kes Dihantar Per Hari</option>
                           <option value="4">Jenis Sosial Media</option>
                           <option value="5">Kes Selesai Dalam Tempoh Masa (within Dateline < 14 Day)</option>
                           <option value="6">Kes Selesai Luar Tempoh Masa (Out of Dateline > 14 Day)</option>
                           <option value="7">Kes Mengikut Status</option>
                           <option value="8">Kes Mengikut Bulan</option>
                           <option value="9">Kes Mengikut Tahun</option>
                           <option value="10">Kes Mengikut Jenis Kesalahan</option>
                           <option value="11">Kes Kesalahan Mengikut Tagging</option>
                           </select>	
					       </div>
						  </div>
              </div>
             <br>

             <div class="row">
			      <div class="col-lg-12">	

               <div class="item panel panel-info"><!-- widgetBody -->
                      <div class="panel-heading"style=" padding: 10px;">
                      <b>Statistik Per Bulan</b>

                              <div class="pull-right">
                              <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                              <i class="fa fa-angle-down"></i>                                 </button>
                              </div>
                      </div>
                              <div class="collapse show" id="collapseExample">
                              <div class="card-body">
                                 <div class="chart">
                                    <?php 
                        echo Highcharts::widget([
                           'options'=>'{
                              "title": { "text": "Kes Dihantar Per Hari" },
                              "xAxis": {
                                 "categories": ["Apples", "Bananas", "Oranges"]
                              },
                              "yAxis": {
                                 "title": { "text": "Fruit eaten" }
                              },
                              "series": [
                                 { "name": "Jane", "data": [1, 0, 4] },
                                 { "name": "John", "data": [5, 7,3] }
                              ]
                           }'
                        ]);

                        ?> 
                                 </div>
                              </div>
                              </div>
              <!-- /.card-body -->
                         
               </div>
              </div>
           </div>

             <div class="row">
			      <div class="col-lg-12">	

               <div class="item panel panel-info"><!-- widgetBody -->
                      <div class="panel-heading"style=" padding: 10px;">
                      <b>Statistik Per Tahun</b>

                              <div class="pull-right">
                              <button class="btn btn-primary btn-sm" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                 <i class="fa fa-angle-down"></i>
                                 </button>
                              </div>
                      </div>
                              <div class="collapse in" id="collapseExample">
                              <div class="card-body">
                                 <div class="chart">
                                 <?php 
                        echo Highcharts::widget([
                           'options'=>'{
                              "title": { "text": "Kes Dihantar Per Hari" },
                              "xAxis": {
                                 "categories": ["Apples", "Bananas", "Oranges", "Peach"]
                              },
                              "yAxis": {
                                 "title": { "text": "Fruit eaten" }
                              },
                              "series": [
                                 { "name": "Jane", "data": [1, 0, 4,10] },
                                 { "name": "John", "data": [5, 7,3, 7] }
                              ]
                           }'
                        ]);

                        ?>                                  </div>
                              </div>
                              </div>
              <!-- /.card-body -->
                         
               </div>
              </div>
           </div>
             
 

              
</div>
</div>
</div>
</div>
<!-- jQuery -->
<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- ChartJS -->
<script src="../../plugins/chart.js/Chart.min.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
<!-- Page specific script -->
<script>
  $(function () {
//-------------
    //- LINE CHART -
    //--------------
    var lineChartCanvas = $('#lineChart').get(0).getContext('2d')
    var lineChartOptions = $.extend(true, {}, areaChartOptions)
    var lineChartData = $.extend(true, {}, areaChartData)
    lineChartData.datasets[0].fill = false;
    lineChartData.datasets[1].fill = false;
    lineChartOptions.datasetFill = false

    var lineChart = new Chart(lineChartCanvas, {
      type: 'line',
      data: lineChartData,
      options: lineChartOptions
    })