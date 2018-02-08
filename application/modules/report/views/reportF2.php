<?php
/**
 * Created by PhpStorm.
 * User: sanitkeawtawan
 * Date: 6/20/2017 AD
 * Time: 20:57
 */?>
<div class="page" size="A4" <?php echo @($layout) ? "layout=\"{$layout}\"" : "" ?>>
  <div class="body large" style="line-height: 30px;">
    <div class="row">
      <div class="col col-xs-4 text-left">
      </div>
      <div class="col col-xs-4 text-center">
        <div class="logo-dop"></div>
      </div>
      <div class="col col-xs-4 text-right">
        <div>แบบสอบถามหมายเลข <span class="_inline _input"><?php echo makeText($res->number,10)?></span></div>
        <div>แบบฟอร์ม อผส.02</div>
      </div>
    </div>
    <div class="row">
      <div class="text-center caption">
        กรมกิจการผู้สูงอายุ<br>
        แบบสอบถามสำหรับผู้ที่เป็นอาสาสมัครดูแลผู้สูงอายุ (อผส.)
      </div>
    </div>
    <div class="row">
      <div style="border: 1px solid #000000; padding: 10px">
        <div><span style="text-decoration: underline">ส่วนที่ 1</span> ข้อมูลทั่วไปของผู้ตอบแบบสอบถาม</div>
        <div>จงทำเครื่องหมาย <div class="checked"></div> ลงในช่อง <div class="checkbox"></div> หรือเติมคำในช่องว่างที่ตรงกับความคิดเห็นของท่านมากที่สุด</div>
        <div>1. อบต./เทศบาล <span class="_input _30"><?php echo $res->gov?></span> จังหวัด <span class="_input _30"><?php echo $res->province?></span></div>
        <div>2. เพศ <div class="checkbox <?php echo ($res->sex==1)?"checked":"";?>"></div> ชาย <div class="checkbox <?php echo ($res->sex==2)?"checked":"";?>"></div> หญิง  ชื่อ – นามสกุล (อผส.) <span class="_input _30"><?php echo $res->name." ".$res->surname ?></span></div>
        <div>3. อายุ <span class="_input _30"><?php echo $res->age ?></span> ปี  สังกัด <span class="_input _30"><?php echo $res->org ?></span></div>
        <div>4. ระดับการศึกษา
          <div style="padding-left: 20px">
              <?php
              foreach ($res->edu as $edu){

                  ?>
                <div class="_30 _inline-blog">
                  <div class="checkbox <?php echo ($edu->check)?"checked":"";?>"></div>
                    <?php echo $edu->title?>
                    <?php if($edu->remark){ ?>
                      <span class="_input _20"><?php echo $edu->remark ?> </span>
                    <?php }?>
                </div>
                  <?php
              }
              ?>
          </div>
        </div>
        <div>5. อาชีพ
          <div style="padding-left: 20px">
            <div class="_40 _inline-blog"> <div class="checkbox <?php echo ($res->job=='เกษตรกรรม')?"checked":"";?>"></div> เกษตรกรรม</div>
            <div class="_20 _inline-blog"> <div class="checkbox <?php echo ($res->job=='รับจ้างทั่วไป')?"checked":"";?>"></div> รับจ้างทั่วไป</div>
            <div class="_20 _inline-blog"> <div class="checkbox <?php echo ($res->job=='รับราชการ')?"checked":"";?>"></div> รับราชการ</div>
            <div class="_40 _inline-blog"> <div class="checkbox <?php echo ($res->job=='ค้าขาย/ธุรกิจส่วนตัว')?"checked":"";?>"></div> ค้าขาย/ธุรกิจส่วนตัว</div>
            <?php
            if($res->job=!'เกษตรกรรม'&&$res->job=!'รับจ้างทั่วไป'&&$res->job=!'รับราชการ'&&$res->job=!'ค้าขาย/ธุรกิจส่วนตัว'){
                $res->job="อื่น ๆ";
            }else{
                $res->job_other="";
            }
            ?>
            <div class="_50 _inline-blog"> <div class="checkbox <?php echo ($res->job=='อื่น ๆ')?"checked":"";?>"></div> อื่น ๆ (ระบุ) <span class="_input _30"><?php echo $res->job_other ?></span></div>
          </div>
        </div>
        <div>
          6. ปัจจุบันท่านดำรงตำแหน่งใดบ้างในหมู่บ้าน/ตำบล (ตอบได้มากกว่า 1 ข้อ)
          <div style="padding-left: 20px">

              <?php
              foreach ($res->pos as $pos){

                  ?>
                <div class="_30 _inline-blog">
                  <div class="checkbox <?php echo ($pos->check)?"checked":"";?>"></div>
                    <?php echo $pos->title?>
                    <?php if($pos->remark){ ?>
                      <span class="_input _20"><?php echo $pos->remark ?> </span>
                    <?php }?>
                </div>
                  <?php
              }
              ?>
        </div>
        </div>
        <div>
          <span style="text-decoration: underline">ส่วนที่ 2</span> การปฏิบัติงานของ อผส.
        </div>
        <div>1. ท่านเป็น อผส. มาแล้วกี่ปี (ระบุ) <span class="_input _30"><?php echo $res->experience ?></span> ปี</div>
        <div>2. ก่อนปฏิบัติหน้าที่ อผส. ท่านเคยได้รับการอบรมการดูแลผู้สูงอายุหรือไม่
          <div style="padding-left: 20px">
            <div class="_100 _inline-blog"> <div class="checkbox <?php echo ($res->caring=='เคยได้รับการอบรม')?"checked":"";?>"></div> เคย จากหน่วยงาน (ระบุ) <span class="_input _30"><?php echo $res->caring1 ?></span>	</div>
            <div class="_100 _inline-blog"> <div class="checkbox <?php echo ($res->caring=='ไม่เคยได้รับการอบรม')?"checked":"";?>"></div> ไม่เคย หลักสูตร เรื่อง (ระบุ) <span class="_input _30"><?php echo $res->caring2 ?></span> </div>
          </div>
        </div>
        <div>3. ท่านได้รับการอบรมเรื่องการดูแลผู้สูงอายุครั้งสุดท้ายเมื่อไหร่ (ระบุ) <span class="_input _10"><?php echo $res->train ?></span> <?php echo $res->train_unit?><br>
          <table class="table-bordered table table-normal" style="width: 100%">
            <thead>
            <tr>
              <th width="60%">รายชื่อผู้สูงอายุในความดูแล</th>
              <th width="10%">อายุ</th>
              <th width="30%">อผส.ดูแลผู้สูงอายุ<br>(ครั้ง/สัปดาห์/เดือน)</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($res->carings as $val) {?>
            <tr>
              <td><?php echo $val->name?></td>
              <td><?php echo $val->age?></td>
              <td><?php echo $val->count ." ".$val->count_per?></td>

            </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="page" size="A4" <?php echo @($layout) ? "layout=\"{$layout}\"" : "" ?>>
  <div class="body large" style="line-height: 30px;">

    <div class="row">
      <div style="border: 1px solid #000000; padding: 10px">
        <div>
          5. ในช่วงที่ผ่านมา ท่านให้การดูแล/ช่วยเหลือผู้สูงอายุในเรื่องใดบ้าง
          <table class="table-bordered table table-normal" style="width: 100%">
            <thead>
            <tr>
              <th width="5%">ข้อ</th>
              <th width="50%">กิจกรรม</th>
              <th width="10%">ทำ</th>
              <th width="10%">ไม่ได้ทำ</th>
              <th width="25%">หมายเหตุ</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach($res->check as $index=>$val) {?>
              <tr>
                <td><?php echo $index+1 ?></td>
                <td><?php echo $val->title ?></td>
                <td class="text-center"><?php echo ($val->check=='1')?"<div class='checked'></div>":"" ?></td>
                <td  class="text-center"><?php echo ($val->check=='0')?"<div class='checked'></div>":"" ?></td>
                <td><?php echo $val->comment ?></td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <div style="padding-top: 10px">6. ข้อเสนอแนะอื่นๆ</div>
        <div>
          <span class="_inline _input"><?php echo makeText($res->comment,800)?></span>
        </div>
      </div>
    </div>
  </div>
</div>
