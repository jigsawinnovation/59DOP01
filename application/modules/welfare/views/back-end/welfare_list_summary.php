  <div id="chart_display"  style="display: none;">
    <div class="tabs-page-container">
          <ul class="nav nav-tabs">
              <li class="active"><a data-toggle="tab" href="#chartTab-1" aria-expanded="true">&nbsp;</a></li>
          </ul>

        <div class="tab-content">
            <div id="chartTab-1" class="tab-pane active">
              <div class="panel-body row">
                <div class="col-xs-12">
                  <div class="summary-title left" style="position: relative;top: 0px;">ภาพรวม: <span class="summary-title-sub">ปริมาณการให้บริการศูนย์พัฒนาการจัดสวัสดิการสังคมผู้สูงอายุ</span></div>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <!-- Styles -->
                  <style>
                  #chartdiv {
                    width: 95%;
                    height: 500px;
                  }
                  </style>

                  <!-- Resources -->
                  <script src="<?php echo base_url("assets/plugins/amcharts/amcharts.js")?>"></script>
                  <script src="<?php echo base_url("assets/plugins/amcharts/serial.js")?>"></script>
                  <script src="<?php echo base_url("assets/plugins/amcharts/plugins/animate/animate.min.js")?>"></script>
                  <script src="<?php echo base_url("assets/plugins/amcharts/plugins/export/export.min.js")?>"></script>
                  <link rel="stylesheet" href="<?php echo base_url("assets/plugins/amcharts/plugins/export/export.css")?>" type="text/css" media="all" />
                  <script src="<?php echo base_url("assets/plugins/amcharts/themes/light.js")?>"></script>
                  <?php
                  $stat = $this->common_model->custom_query("
                                SELECT
                                IF(YEAR(adm_info.date_of_req)+(IF(MONTH(adm_info.date_of_req)>9,1,0)),YEAR(adm_info.date_of_req)+(IF(MONTH(adm_info.date_of_req)>9,1,0)),'NULL') AS budget_year,
                                adm_info.date_of_req,
                                COUNT(adm_info.adm_id) AS count_info
                                FROM
                                adm_info
                                JOIN db_center.pers_info
                                ON adm_info.pers_id = pers_info.pers_id
                                GROUP BY budget_year
                                ORDER BY
                                budget_year ASC
                    ");


                  ?>


                  <!-- HTML -->
                  <center><div id="chartdiv"></div></center>
                </div>
                <div class="col-xs-12 col-sm-12">
                  <table width="100%" class="summary-report-table">
                    <tr>
                      <td class="summary-report-th" rowspan="3">ปีงบประมาณ</td>
                      <td class="summary-report-th" colspan="6">ปริมาณการให้บริการ (ราย)</td>
                    </tr>
                    <tr>
                      <td class="summary-report-th" colspan="5">รับเข้า</td>
                      <td class="summary-report-th" rowspan="2">จำหน่าย</td>
                    </tr>
                    <tr>
                      <td class="summary-report-th" width="15%">กลุ่ม A<br/>(ร้อยละ 0.00 - 33.33)</td>
                      <td class="summary-report-th" width="15%">กลุ่ม B<br/>(ร้อยละ 33.34 - 66.66)</td>
                      <td class="summary-report-th" width="15%">กลุ่ม C<br/>(ร้อยละ 66.67 - 100.00)</td>
                      <td class="summary-report-th" width="15%">ไม่ได้ประเมิน</td>
                      <td class="summary-report-th" width="15%">รวม</td>
                    </tr>
                    <?php
                    $total_a = 0;
                    $total_b = 0;
                    $total_c = 0;
                    $total_null = 0;
                    $total_sum_rate = 0;

                    foreach ($stat as $key => $row) {
                      $pers_info = $this->common_model->custom_query("
                                    SELECT IF(YEAR(adm_info.date_of_req)+(IF(MONTH(adm_info.date_of_req)>9,1,0)),YEAR(adm_info.date_of_req)+(IF(MONTH(adm_info.date_of_req)>9,1,0)),'NULL') AS budget_year,
                                    adm_info.date_of_req, pers_id
                                    FROM `adm_info`
                                    WHERE IF(YEAR(adm_info.date_of_req)+(IF(MONTH(adm_info.date_of_req)>9,1,0)),YEAR(adm_info.date_of_req)+(IF(MONTH(adm_info.date_of_req)>9,1,0)),'NULL') = '".$row['budget_year']."'
                        ");
                        $sum_a = 0;
                        $sum_b = 0;
                        $sum_c = 0;
                        $sum_null = 0;
                        //$total_sum_rate = 0;
                      foreach ($pers_info as $key => $row_info) {
                        $adm_irp = rowArray($this->welfare_model->getAll_admIrp($row_info['pers_id']));
                        $irp_result = $this->welfare_model->get_Percentage($adm_irp['irp_id']);
                        $ans_rate = $irp_result['ans_rate'];
                        if($ans_rate == 'A'){
                          $sum_a++;
                        }else if($ans_rate == 'B'){
                          $sum_b++;
                        }else if($ans_rate == 'C'){
                          $sum_c++;
                        }else{
                          $sum_null++;
                        }
                      }

                    $sum_rate = $sum_a+$sum_b+$sum_c+$sum_null;
                    $stat_chart[$row['budget_year']] = array('rate_a'=>$sum_a,'rate_b'=>$sum_b,'rate_c'=>$sum_c,'rate_null'=>$sum_null);
                    ?>
                    <tr>
                      <td class="summary-report-td center"><?php echo $row['budget_year']+543;?></td>
                      <td class="summary-report-td right"><?php echo number_format($sum_a);?></td>
                      <td class="summary-report-td right"><?php echo number_format($sum_b);?></td>
                      <td class="summary-report-td right"><?php echo number_format($sum_c);?></td>
                      <td class="summary-report-td right"><?php echo number_format($sum_null);?></td>
                      <td class="summary-report-td right"><?php echo number_format($sum_rate);?></td>
                      <td class="summary-report-td right">&nbsp;</td>
                    </tr>
                    <?php
                      $total_a += $sum_a;
                      $total_b += $sum_b;
                      $total_c += $sum_c;
                      $total_null += $sum_null;
                      $total_sum_rate += $sum_rate;
                    }
                    ?>
                    <tr>
                      <td class="summary-report-td-sum center">รวม</td>
                      <td class="summary-report-td-sum right"><?php echo number_format($total_a);?></td>
                      <td class="summary-report-td-sum right"><?php echo number_format($total_b);?></td>
                      <td class="summary-report-td-sum right"><?php echo number_format($total_c);?></td>
                      <td class="summary-report-td-sum right"><?php echo number_format($total_null);?></td>
                      <td class="summary-report-td-sum right"><?php echo number_format($total_sum_rate);?></td>
                      <td class="summary-report-td-sum right">&nbsp;</td>
                    </tr>
                  </table>
                  <!-- Chart code -->
                  <script>
                  var chart = AmCharts.makeChart("chartdiv", {
                            "type": "serial",
                            "theme": "light",
                            "legend": {
                                "autoMargins": false,
                                "borderAlpha": 0.2,
                                "equalWidths": false,
                                "horizontalGap": 10,
                                "markerSize": 16,
                                "fontSize": 16,
                                "useGraphSettings": true,
                                "valueAlign": "left",
                                "valueWidth": 0
                            },
                            "dataProvider": [
                            <?php foreach ($stat_chart as $budget_year => $row) { ?>
                            {
                                "year": "<?php echo $budget_year+543;?>",
                                "rate_a": <?php echo $row['rate_a'];?>,
                                "rate_b": <?php echo $row['rate_b'];?>,
                                "rate_c": <?php echo $row['rate_c'];?>,
                                "rate_null": <?php echo $row['rate_null'];?>
                            },
                            <?php } ?>
                            ],
                            "valueAxes": [{
                                "stackType": "100%",
                                "axisAlpha": 0,
                                "gridAlpha": 0,
                                "labelsEnabled": false,
                                "position": "left"
                            }],
                            "graphs": [{
                                "balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
                                "fillAlphas": 0.9,
                                "fontSize": 16,
                                "labelText": "[[percents]]%",
                                "lineAlpha": 0.5,
                                "title": "กลุ่ม A",
                                "type": "column",
                                "valueField": "rate_a"
                            }, {
                                "balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
                                "fillAlphas": 0.9,
                                "fontSize": 16,
                                "labelText": "[[percents]]%",
                                "lineAlpha": 0.5,
                                "title": "กลุ่ม B",
                                "type": "column",
                                "valueField": "rate_b"
                            }, {
                                "balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
                                "fillAlphas": 0.9,
                                "fontSize": 16,
                                "labelText": "[[percents]]%",
                                "lineAlpha": 0.5,
                                "title": "กลุ่ม C",
                                "type": "column",
                                "valueField": "rate_c"
                            }, {
                                "balloonText": "[[title]], [[category]]<br><span style='font-size:14px;'><b>[[value]]</b> ([[percents]]%)</span>",
                                "fillAlphas": 0.9,
                                "fontSize": 16,
                                "labelText": "[[percents]]%",
                                "lineAlpha": 0.5,
                                "title": "ไม่ได้ประเมิน",
                                "type": "column",
                                "valueField": "rate_null"
                            }],
                            "marginTop": 30,
                            "marginRight": 0,
                            "marginLeft": 0,
                            "marginBottom": 40,
                            "autoMargins": false,
                            "categoryField": "year",
                            "categoryAxis": {
                                "gridPosition": "start",
                                "fontSize": 16,
                                "axisAlpha": 0,
                                "gridAlpha": 0
                            },
                            "export": {
                              "enabled": true
                             }

                        });
                  </script>
                </div>
              </div>
            </div>
          </div>
      </div>
  </div>
