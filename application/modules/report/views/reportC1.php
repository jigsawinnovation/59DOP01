<?php
/**
 * Created by PhpStorm.
 * User: sanitkeawtawan
 * Date: 6/18/2017 AD
 * Time: 22:49
 */ ?>
<div class="page" size="A4" <?php echo @($layout) ? "layout=\"{$layout}\"" : "" ?>>
  <div class="body smalled">
    <div class="row">
      <div class="border" style="padding: 3px">
        <div><strong>ส่วนที่ 1: ข้อมูลผู้ยื่นขอ (ผู้ยื่นขอรับเงินสงเคราะห์ในการจัดการงานศพผู้สูงอายุตามประเพณี)</strong></div>
        <div>
          เลขบัตรประจำตัวประชาชน<span class="_input _20 "><?php echo $res->idcard ?>&nbsp;</span>
          คำนำหน้า <span class="_input _10 "><?php echo $res->prename ?>&nbsp;</span>
          ชื่อตัว <span class="_input _15 "><?php echo $res->name ?>&nbsp;</span>
          ชื่อสกุล <span class="_input _15 "><?php echo $res->surname ?>&nbsp;</span>
        </div>
        <div>
          วันเดือนปีเกิด <span class="_input _30 "><?php echo $res->date_of_birth ?>&nbsp;</span>
          ความเกี่ยวข้องกับผู้สูงอายุที่เสียชีวิต <span class="_input _40"><?php echo $res->relation ?>&nbsp;</span>
        </div>
        <div>
          บ้านเลขที่ <span class="_input _15"><?php echo $res->addr->no ?>&nbsp;</span>
          หมู่ที่ <span class="_input _20 "><?php echo $res->addr->moo ?>&nbsp;</span>
          ตรอก/ซอย <span class="_input _20 "><?php echo $res->addr->lane ?>&nbsp;</span>
          ถนน <span class="_input _20 "><?php echo $res->addr->street ?>&nbsp;</span>
        </div>
        <div>
          ตำบล/แขวง <span class="_input _15"><?php echo $res->addr->locality ?>&nbsp;</span>
          อำเภอ/เขต <span class="_input _20"><?php echo $res->addr->district ?>&nbsp;</span>
          จังหวัด <span class="_input _20"><?php echo $res->addr->province ?>&nbsp;</span>
          รหัสไปรษณีย์ <span class="_input _15"><?php echo $res->addr->postcode ?>&nbsp;</span>
        </div>
        <div>
          เบอร์โทรศัพท์ (ที่ติดต่อได้) <span class="_input _20"><?php echo $res->phone ?>&nbsp;</span>
        </div>
        <div style="padding-top: 10px">
          <div class="row">
            <div class="col-xs-8" style="line-height: 22px">
              ข้าพเจ้าขอรับรองว่าข้อความและเอกสารที่ได้ยื่นนี้เป็นความจริงทุกประการ และข้าพเจ้าไม่เคยได้รับเงินสงเคราะห์
              ในการจัดการศพผู้สูงอายุรายนี้มาก่อน หากข้อความและเอกสารที่ยื่นเรื่องนี้เป็นเท็จ ข้าพเจ้ายินยอมให้ดำเนินการตามกฎหมาย
            </div>
            <div class="col-xs-4">
              <div style="line-height: 22px;text-align: center">
                <div>(ลงชื่อ)<span class="_input _50"><?php echo "{$res->name} {$res->surname}" ?>&nbsp;</span>ผู้ยื่นคำขอ</div>
                <div>(<span class="_input _60">&nbsp;</span>)</div>
                <div>วันที่ <span class="_input _50"><?php echo "{$res->date->day}/{$res->date->month}/{$res->date->year}" ?>&nbsp;</span></div>
              </div>
            </div>
            </div>


        </div>
      </div>

    <div class="border" style="padding: 3px;margin-top: 5px">
      <div><strong>ส่วนที่ 2: ข้อมูลผู้สูงอายุ (ผู้สูงอายุที่เสียชีวิต)</strong></div>

      <div>
        เลขบัตรประจำตัวประชาชน<span class="_input _20 "><?php echo $res->dead->idcard ?>&nbsp;</span>
        คำนำหน้า <span class="_input _10 "><?php echo $res->dead->prename ?>&nbsp;</span>
        ชื่อตัว <span class="_input _15 "><?php echo $res->dead->name ?>&nbsp;</span>
        ชื่อสกุล <span class="_input _15 "><?php echo $res->dead->surname ?>&nbsp;</span>
      </div>
      <div>
        วันเดือนปีเกิด <span class="_input _30 "><?php echo $res->dead->date_of_birth ?>&nbsp;</span>
      </div>
      <div><strong>ที่อยู่ตามทะเบียนบ้าน</strong></div>
      <div>
        บ้านเลขที่ <span class="_input _15"><?php echo $res->addr->no ?>&nbsp;</span>
        หมู่ที่ <span class="_input _20 "><?php echo $res->addr->moo ?>&nbsp;</span>
        ตรอก/ซอย <span class="_input _20 "><?php echo $res->addr->lane ?>&nbsp;</span>
        ถนน <span class="_input _20 "><?php echo $res->addr->street ?>&nbsp;</span>
      </div>
      <div>
        ตำบล/แขวง <span class="_input _15"><?php echo $res->addr->locality ?>&nbsp;</span>
        อำเภอ/เขต <span class="_input _20"><?php echo $res->addr->district ?>&nbsp;</span>
        จังหวัด <span class="_input _20"><?php echo $res->addr->province ?>&nbsp;</span>
        รหัสไปรษณีย์ <span class="_input _15"><?php echo $res->addr->postcode ?>&nbsp;</span>
      </div>
      <div>
        ที่อยู่ปัจจุบัน [] ตรงกับที่อยู่ตามทะเบียนบ้าน
      </div>
      <div>
        บ้านเลขที่ <span class="_input _15"><?php echo $res->addr->no ?>&nbsp;</span>
        หมู่ที่ <span class="_input _20 "><?php echo $res->addr->moo ?>&nbsp;</span>
        ตรอก/ซอย <span class="_input _20 "><?php echo $res->addr->lane ?>&nbsp;</span>
        ถนน <span class="_input _20 "><?php echo $res->addr->street ?>&nbsp;</span>
      </div>
      <div>
        ตำบล/แขวง <span class="_input _15"><?php echo $res->addr->locality ?>&nbsp;</span>
        อำเภอ/เขต <span class="_input _20"><?php echo $res->addr->district ?>&nbsp;</span>
        จังหวัด <span class="_input _20"><?php echo $res->addr->province ?>&nbsp;</span>
        รหัสไปรษณีย์ <span class="_input _15"><?php echo $res->addr->postcode ?>&nbsp;</span>
      </div>
      <div>
        วันที่เสียชีวิต	<span class="_input _30"><?php echo $res->dead->date_of_death ?>&nbsp;</span>
        ด้วยสาเหตุ <span class="_input _30"><?php echo $res->dead->desc ?>&nbsp;</span>
      </div>
      <div>
        ใบมรณะบัตรเลขที่	<span class="_input _15"><?php echo $res->dead->doc_no ?>&nbsp;</span>
        ออกให้โดย <span class="_input _15"><?php echo $res->dead->doc_by ?>&nbsp;</span>
        วันที่ออกใบมรณะบัตร <span class="_input _15"><?php echo $res->dead->doc_date ?>&nbsp;</span>
      </div>
    </div>
      <div class="border" style="padding: 3px;margin-top: 5px">
        <div><strong>ส่วนที่ 3: ข้อมูลผู้รับรอง (ให้การรับรองผู้รับผิดชอบในการจัดการงานศพผู้สูงอายุตามประเพณี)</strong></div>
        <div>
          เลขบัตรประจำตัวประชาชน<span class="_input _20 "><?php echo $res->aprv->idcard ?>&nbsp;</span>
          คำนำหน้า <span class="_input _10 "><?php echo $res->aprv->prename ?>&nbsp;</span>
          ชื่อตัว <span class="_input _15 "><?php echo $res->aprv->name ?>&nbsp;</span>
          ชื่อสกุล <span class="_input _15 "><?php echo $res->aprv->surname ?>&nbsp;</span>
        </div>
        <div>
          วันเดือนปีเกิด <span class="_input _15 "><?php echo $res->aprv->date_of_birth ?>&nbsp;</span>
          ตำแหน่ง <span class="_input _30"><?php echo $res->aprv->position ?>&nbsp;</span>
          หน่วยงาน <span class="_input _30"><?php echo $res->aprv->org ?>&nbsp;</span>
        </div>
        <div>
          บ้านเลขที่ <span class="_input _15"><?php echo $res->aprv->addr->no ?>&nbsp;</span>
          หมู่ที่ <span class="_input _20 "><?php echo $res->aprv->addr->moo ?>&nbsp;</span>
          ตรอก/ซอย <span class="_input _20 "><?php echo $res->aprv->addr->lane ?>&nbsp;</span>
          ถนน <span class="_input _20 "><?php echo $res->aprv->addr->street ?>&nbsp;</span>
        </div>
        <div>
          ตำบล/แขวง <span class="_input _15"><?php echo $res->aprv->addr->locality ?>&nbsp;</span>
          อำเภอ/เขต <span class="_input _20"><?php echo $res->aprv->addr->district ?>&nbsp;</span>
          จังหวัด <span class="_input _20"><?php echo $res->aprv->addr->province ?>&nbsp;</span>
          รหัสไปรษณีย์ <span class="_input _15"><?php echo $res->aprv->addr->postcode ?>&nbsp;</span>
        </div>
        <div>
          เบอร์โทรศัพท์ (ที่ติดต่อได้) <span class="_input _20"><?php echo $res->aprv->phone ?>&nbsp;</span>
        </div>
        <div style="padding-top: 10px">
          <div class="row">
            <div class="col-xs-8">
              ข้าพเจ้าขอรับรองว่าผู้ยื่นคำขอดังกล่าวเป็นผู้รับผิดชอบในการจัดการศพผู้สูงอายุรายนี้จริง
            </div>
            <div class="col-xs-4">
              <div style="line-height: 22px;text-align: center">
                <div>(ลงชื่อ)<span class="_input _50"><?php echo "{$res->aprv->name} {$res->aprv->surname}" ?>&nbsp;</span>ผู้รับรอง</div>
                <div>(<span class="_input _60">&nbsp;</span>)</div>
                <div>วันที่ <span class="_input _50"><?php echo "{$res->aprv->date_of_req_pers_aprv}"?>&nbsp;</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="border" style="padding: 3px;margin-top: 5px">
        <div><strong>ส่วนที่ 4: ข้อมูลผู้รับรอง (กรณีไม่ได้รับการสำรวจข้อมูลความจำเป็นพื้นฐาน (จปฐ.) ในปีที่เสียชีวิต)</strong></div>

        <div>
          เลขบัตรประจำตัวประชาชน<span class="_input _20 "><?php echo $res->aprv2->idcard ?>&nbsp;</span>
          คำนำหน้า <span class="_input _10 "><?php echo $res->aprv2->prename ?>&nbsp;</span>
          ชื่อตัว <span class="_input _15 "><?php echo $res->aprv2->name ?>&nbsp;</span>
          ชื่อสกุล <span class="_input _15 "><?php echo $res->aprv2->surname ?>&nbsp;</span>
        </div>
        <div>
          วันเดือนปีเกิด <span class="_input _15 "><?php echo $res->aprv2->date_of_birth ?>&nbsp;</span>
          ตำแหน่ง <span class="_input _30"><?php echo $res->aprv2->position ?>&nbsp;</span>
          หน่วยงาน <span class="_input _30"><?php echo $res->aprv2->org ?>&nbsp;</span>
        </div>
        <div>
          บ้านเลขที่ <span class="_input _15"><?php echo $res->aprv2->addr->no ?>&nbsp;</span>
          หมู่ที่ <span class="_input _20 "><?php echo $res->aprv2->addr->moo ?>&nbsp;</span>
          ตรอก/ซอย <span class="_input _20 "><?php echo $res->aprv2->addr->lane ?>&nbsp;</span>
          ถนน <span class="_input _20 "><?php echo $res->aprv2->addr->street ?>&nbsp;</span>
        </div>
        <div>
          ตำบล/แขวง <span class="_input _15"><?php echo $res->aprv2->addr->locality ?>&nbsp;</span>
          อำเภอ/เขต <span class="_input _20"><?php echo $res->aprv2->addr->district ?>&nbsp;</span>
          จังหวัด <span class="_input _20"><?php echo $res->aprv2->addr->province ?>&nbsp;</span>
          รหัสไปรษณีย์ <span class="_input _15"><?php echo $res->aprv2->addr->postcode ?>&nbsp;</span>
        </div>
        <div>
          เบอร์โทรศัพท์ (ที่ติดต่อได้) <span class="_input _20"><?php echo $res->aprv2->phone ?>&nbsp;</span>
        </div>
        <div style="padding-top: 10px">
          <div class="row">
            <div class="col-xs-8" style="line-height: 22px">
              ข้าพเจ้าขอรับรองว่าผู้สูงอายุที่เสียชีวิตอยู่ในครัวเรือนยากจนและไม่ได้รับการสำรวจข้อมูลความจำเป็นพื้นฐาน (จปฐ.) กรมการพัฒนาชุมชน กระทรวงมหาดไทย หรือกรุงเทพมหานคร หรือเมืองพัทยา โดยได้ตรวจสอบผู้สูงอายุแล้วไม่ปรากฏรายชื่ออยู่ในการสำรวจข้อมูลความจำเป็นพื้นฐาน (จปฐ.) และผู้สูงอายุอยู่ในครัวเรือนที่ยากจน โดยมีรายได้ในครัวเรือนเฉลี่ยต่อปีตามเกณฑ์รายได้ข้อมูลความจำเป็นพื้นฐาน (จปฐ.) ในปีที่เสียชีวิตจริง
            </div>
            <div class="col-xs-4">
              <div style="line-height: 22px;text-align: center">
                <div>(ลงชื่อ)<span class="_input _50"><?php echo "{$res->aprv2->name} {$res->aprv2->surname}" ?>&nbsp;</span>ผู้รับรอง</div>
                <div>(<span class="_input _60">&nbsp;</span>)</div>

                <div>วันที่ <span class="_input _50"><?php echo "{$res->aprv2->date_of_not_survey_aprv}"?>&nbsp;</span></div>
              </div>
            </div>
          </div>
        </div>
      </div>


      </div>
  </div>
</div>
