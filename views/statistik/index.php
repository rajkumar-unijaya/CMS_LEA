<?php 
    use miloschuman\highcharts\Highcharts;
    use miloschuman\highcharts\GanttChart;
    use yii\web\JsExpression;
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
                                 echo GanttChart::widget([
                              'options' => [
                                 'title' => ['text' => 'Simple Gantt Chart'],
                                 'series' => [
                                       [
                                          'name' => 'Project 1',
                                          'data' => [
                              [
                                    'id' => 's',
                                    'name' => 'Start prototype',
                                    'start' => new JsExpression('Date.UTC(2014, 10, 18)'),
                                    'end' => new JsExpression('Date.UTC(2014, 10, 20)'),
                              ],
                              [
                                    'id' => 'b',
                                    'name' => 'Develop',
                                    'start' => new JsExpression('Date.UTC(2014, 10, 20)'),
                                    'end' => new JsExpression('Date.UTC(2014, 10, 25)'),
                                    'dependency' => 's',
                              ],
                              [
                                    'id' => 'a',
                                    'name' => 'Run acceptance tests',
                                    'start' => new JsExpression('Date.UTC(2014, 10, 23)'),
                                    'end' => new JsExpression('Date.UTC(2014, 10, 26)'),
                              ],
                              [
                                    'name' => 'Test prototype',
                                    'start' => new JsExpression('Date.UTC(2014, 10, 27)'),
                                    'end' => new JsExpression('Date.UTC(2014, 10, 29)'),
                                    'dependency' => [
                                       'a',
                                       'b',
                                    ],
                              ],
                           ],
                        ],
                  ],
               ],
            ]);
            ?>
                         </div>
                              </div>
                              </div>
              <!-- /.card-body -->
                         
               </div>
              </div>
           </div>
             
                  <!--- Chart no3-->
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
                                 'scripts' => [
                                    'modules/exporting',
                                    'themes/grid-light',
                                 ],
                                 'options' => [
                                    'title' => [
                                       'text' => 'Combination chart',
                                    ],
                                    'xAxis' => [
                                       'categories' => ['Apples', 'Oranges', 'Pears', 'Bananas', 'Plums'],
                                    ],
                                    'labels' => [
                                       'items' => [
                                             [
                                             
                                                'style' => [
                                                   'left' => '50px',
                                                   'top' => '18px',
                                                   'color' => new JsExpression('(Highcharts.theme && Highcharts.theme.textColor) || "black"'),
                                                ],
                                             ],
                                       ],
                                    ],
                                    'series' => [
                                       [
                                             'type' => 'column',
                                             'name' => 'Jane',
                                             'data' => [3, 2, 1, 3, 4],
                                       ],
                                       [
                                             'type' => 'column',
                                             'name' => 'John',
                                             'data' => [2, 3, 5, 7, 6],
                                       ],
                                       [
                                             'type' => 'column',
                                             'name' => 'Joe',
                                             'data' => [4, 3, 3, 9, 0],
                                       ],
                                       [
                                             'type' => 'spline',
                                             'name' => 'Average',
                                             'data' => [3, 2.67, 3, 6.33, 3.33],
                                             'marker' => [
                                                'lineWidth' => 2,
                                                'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
                                                'fillColor' => 'white',
                                             ],
                                       ],
                                       
                                    ],
                                 ]
                              ]);
                                          ?>
                         </div>
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
