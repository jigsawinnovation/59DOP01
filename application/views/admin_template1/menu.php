<!DOCTYPE html>
<html>
    <head>
<<<<<<< HEAD
        <?php
            $site = $this->webinfo_model->getSiteInfo();
=======
        <?php 
            $site = $this->webinfo_model->getSiteInfo(); 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
            $title = $site['site_title'].'(Menu)';
        ?>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <meta name="description" content="<?php echo $site['deprt_descp'];?>">
        <meta name="keywords" content="<?php echo $site['deprt_keywd'];?>">
        <meta name="author" content="Sonchai058">

        <link rel="shortcut icon" href="<?php echo path($site['site_icon_file'],'webconfig');?>" type="image/x-icon">
        <link rel="icon" href="<?php echo path($site['site_icon_file'],'webconfig');?>" type="image/x-icon">

        <!-- *************** inspinia-3 Template: CSS *************** -->
        <?php echo css_asset('../plugins/Static_Full_Version/css/bootstrap.min.css'); ?>
        <?php echo css_asset('../plugins/Static_Full_Version/font-awesome/css/font-awesome.css'); ?>
        <?php echo css_asset('../plugins/Static_Full_Version/css/animate.css'); ?>
        <?php echo css_asset('../plugins/Static_Full_Version/css/style.css'); ?>
        <!-- *************** End inspinia-3 Template: CSS *************** -->

        <?php
          echo css_asset('../admin/css/fontsset.css');
        ?>

<<<<<<< HEAD

=======
  
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
        <?php //Set Background Path?>
        <style tyle="text/css">
            body {
              background: url('<?php echo path($site['site_bg_file'],'webconfig');?>');
            }
        </style>

<<<<<<< HEAD
        <?php
=======
        <?php  
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
          echo css_asset('../admin/css/menu.css');
        ?>

        <title><?php echo $title; ?></title>

</head>

<body>
    <div id="wrapper">

        <div class="row" >
            <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0; background: transparent !important;">
                <div class="navbar-header" style="margin: 0px auto auto 50px;">
                    <a href="<?php echo site_url('control/main_module');?>" title="<?php echo $site['site_title'];?>">
                        <h1 class="title"><?php echo strtoupper($site['site_name']);?></h1>
                        <h2 class="sec1_title"><?php echo $site['site_title'];?></h2>
                    </a>
                </div>
                <ul class="nav navbar-top-links navbar-right" style="margin: 0px; color: #fff !important">
                    <?php
                    //$user = get_session('user_firstname').' '.get_session('user_lastname');
                    $user = get_session('user_firstname');
                    ?>
                    <li title="<?php echo $user;?>">
<<<<<<< HEAD
                        <a style="font-size: 18px;" href="<?php echo base_url('member/edit_profile/edit/'.getUser()); ?>"> <span style="color: #fff !important" class="m-r-sm text-muted welcome-message"><?php echo $user;?></span> <img src="<?php echo base_url(get_session('user_photo_file'));?>" class="profile img-circle border-1" style="border: 4px #eee solid;" alt="<?php echo $user;?>" width="42" height="42">
=======
                        <a style="font-size: 18px;" href="<?php echo base_url('member/edit_profile/edit/'.getUser()); ?>"> <span style="color: #fff !important" class="m-r-sm text-muted welcome-message"><?php echo $user;?></span> <img src="<?php echo base_url(get_session('user_photo_file'));?>" class="profile img-circle border-1" style="border: 4px #eee solid;" alt="<?php echo $user;?>" width="42" height="42"> 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                        </a>
                    </li>

                    <li>
<<<<<<< HEAD
                        <a href="../assets/file/59DOP01-Manual.pdf" target="_blank" title="ช่วยเหลือ" style="display: inline;">
=======
                        <a title="ช่วยเหลือ" href="#help" style="display: inline;">
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                            <i style="font-size: 18px; color: #fff !important" class="fa fa-question-circle" aria-hidden="true"></i>
                        </a>
                        <a title="ออกจากระบบ" href="<?php echo site_url('manage/logout');?>" style="display: inline;">
                            <i style="font-size: 18px; color: #fff !important" class="fa fa-power-off" aria-hidden="true"></i>
                        </a>

                    </li>
                </ul>

            </nav>
        </div>

        <!--<div class="animated fadeInRight">-->
        <div class="row" style="background: transparent !important;">
            <div class="container" style="min-height: 600px;">

               <div class="row permiss_head" >
                    <div class="col-xs-12 col-sm-4 permiss_head-panel" title="ด้านสวัสดิการสังคมผู้สูงอายุ">
                        <div class="permiss_head-txt text-center">ด้านสวัสดิการสังคมผู้สูงอายุ</div>
                        <div class="row">
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(1);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(1,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(1);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(1,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"  
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('difficult/assist_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(11);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(11,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(11);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(11,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('welfare/welfare_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(20);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(20,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(20);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(20,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('funeral/funeral_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
<<<<<<< HEAD
                            </div>
                            <div class="col-sm-12 item">
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(28);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(28,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                            </div>    
                            <div class="col-sm-12 item">
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(28);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(28,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('adaptenvir/adaptenvir_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
<<<<<<< HEAD
                            </div>
=======
                            </div>                        
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 permiss_head-panel" title="ด้านการพัฒนาศักยภาพผู้สูงอายุ">
                        <div class="permiss_head-txt text-center">ด้านการพัฒนาศักยภาพผู้สูงอายุ</div>
                        <div class="row">
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(44);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(44,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(44);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(44,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('intelprop/intelprop_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(50);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(50,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(50);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(50,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('volunteer/volunteer_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-12 item">
                                &nbsp;
                            </div>
                            <div class="col-sm-12 item">
                                &nbsp;
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0" title="ด้านการเตรียมความพร้อมสู่วัยผู้สูงอายุ">
                        <div class="permiss_head-txt text-center">ด้านการเตรียมความพร้อมสู่วัยผู้สูงอายุ</div>
                        <div class="row">
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(53);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(53,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(53);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(53,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('prepare/prepare_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(57);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(57,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(57);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(57,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('school/school_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(63);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(63,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(63);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(63,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('jobs/jobs_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                            <div class="col-sm-12 item">
                                &nbsp;
                            </div>
                        </div>
                    </div>
               </div>
                <br/><br/>
               <div class="row permiss_head" style="border-top: 1px solid rgba(255,255,255,0.4);" >
                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(70);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(70,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(70);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(70,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('individual/individual_list');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(64);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(64,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(64);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(64,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo site_url('usm');?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 permiss_head-panel" style="border-right:0">
                        <br/>
                        <div class="row">
                            <div class="col-sm-12 item">
<<<<<<< HEAD
                                <a
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(74);
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(74,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled"
=======
                                <a 
                                <?php
                                $tmp = $this->admin_model->getOnce_Application(74);   
                                $tmp1 = $this->admin_model->chkOnce_usrmPermiss(74,get_session('user_id')); //Check User Permission
                                if(!isset($tmp1['perm_status'])) { ?>
                                     class="disabled" 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
                                <?php }else{?>href="<?php echo base_url("webconfig/webconfig_detail");?>"<?php }?>>
                                    <div class="col-sm-2 icon text-left" style="background-color: <?php echo $tmp['app_color'];?>">
                                        <i class="<?php echo $tmp['app_icon'];?>" aria-hidden="true"></i>
                                    </div>
                                    <div class="col-sm-9 txt">
                                    <?php if(isset($tmp['app_name'])){echo $tmp['app_name'];}?>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
<<<<<<< HEAD

=======
                
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
            </div>
        </div>

        <br/>
        <!--
        <div class="footer" style="background: transparent !important;">
        <div style="background: transparent !important;">
            <div class="pull-right" style="font-size: 14px; padding: 15px; color: #858C92 !important;">
                เวอร์ชั่น 1.0
            </div>
            <div style="font-size: 14px; padding: 15px; color: #858C92 !important;">
<<<<<<< HEAD
                © สงวนลิขสิทธ์โดย<strong> กรมกิจการผู้สูงอายุ</strong> พัฒนาโดย บริษัท จิ๊กซอว์ อินโนเวชั่น จำกัด
=======
                © สงวนลิขสิทธ์โดย<strong> กรมกิจการผู้สูงอายุ</strong> พัฒนาโดย บริษัท จิ๊กซอว์ อินโนเวชั่น จำกัด 
>>>>>>> 71d9a9911d6abf2844df74fb093d55aee2315f04
            </div>
        </div>
        -->

    </div>
</body>
    <!-- *************** inspinia-3 Template: JS *************** ----->
        <!-- Mainly scripts -->
    <?php echo js_asset('../plugins/Static_Full_Version/js/jquery-3.1.1.min.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/bootstrap.min.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/plugins/metisMenu/jquery.metisMenu.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>
        <!-- Custom and plugin javascript -->
    <?php echo js_asset('../plugins/Static_Full_Version/js/inspinia.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/plugins/pace/pace.min.js'); ?>
    <?php echo js_asset('../plugins/Static_Full_Version/js/plugins/slimscroll/jquery.slimscroll.min.js'); ?>
    <!-- *************** End inspinia-3 Template: JS *************** -->
</html>
