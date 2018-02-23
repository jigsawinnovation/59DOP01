<!DOCTYPE html>
<html>
    <head>
        <?php
            $site = $this->webinfo_model->getSiteInfo();
            $title = $title!=''?$title:$site['site_title'].'(Index Page)';
        ?>

        <meta charset="utf-8">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta name="viewport" content="width=1000, initial-scale=1.0">

        <meta name="description" content="<?php echo $site['deprt_descp'];?>">
        <meta name="keywords" content="<?php echo $site['deprt_keywd'];?>">
        <meta name="author" content="Sonchai058">

        <link rel="shortcut icon" href="<?php echo path($site['site_icon_file'],'webconfig');?>" type="image/x-icon">
        <link rel="icon" href="<?php echo path($site['site_icon_file'],'webconfig');?>" type="image/x-icon">

  <?php //Set Background Path?>
  <style tyle="text/css">
    body {
        //background: url('<?php echo path($site['site_bg_file'],'webconfig');?>');
    }
  </style>

  <?php $this->load->file('assets/admin/tools/tools_config.php');?>

  <?php
        if($this->template->content_view_set==1){
            $this->load->file('assets/modules/'.uri_seg(1).'/tools/back-end/tools_config.php');
        }
    ?>

    <title><?php echo $title;?></title>

<style>
/* Template-specific stuff
 *
 * Customizations just for the template; these are not necessary for anything
 * with disabling the responsiveness.
 */

/* Account for fixed navbar */
body {
  min-width: 1000px;
  padding-top: 70px;
  padding-bottom: 30px;
}

/* Finesse the page header spacing */
.page-header {
  margin-bottom: 30px;
}
.page-header .lead {
  margin-bottom: 10px;
}


/* Non-responsive overrides
 *
 * Utilitze the following CSS to disable the responsive-ness of the container,
 * grid system, and navbar.
 */

/* Reset the container */
.container {
  width: 1000px;
  max-width: none !important;
}

/* Demonstrate the grids */
.col-xs-4 {
/*  padding-top: 15px;
  padding-bottom: 15px;
  background-color: #eee;
  background-color: rgba(86,61,124,.15);
  border: 1px solid #ddd;
  border: 1px solid rgba(86,61,124,.2);*/
}

.container .navbar-header,
.container .navbar-collapse {
  margin-right: 0;
  margin-left: 0;
}

/* Always float the navbar header */
.navbar-header {
  float: left;
}

/* Undo the collapsing navbar */
.navbar-collapse {
  display: block !important;
  height: auto !important;
  padding-bottom: 0;
  overflow: visible !important;
}

.navbar-toggle {
  display: none;
}
.navbar-collapse {
  border-top: 0;
}

.navbar-brand {
  margin-left: -15px;
}

/* Always apply the floated nav */
.navbar-nav {
  float: left;
  margin: 0;
}
.navbar-nav > li {
  float: left;
}
.navbar-nav > li > a {
  padding: 15px;
}

/* Redeclare since we override the float above */
.navbar-nav.navbar-right {
  float: right;
}

/* Undo custom dropdowns */
.navbar .navbar-nav .open .dropdown-menu {
  position: absolute;
  float: left;
  background-color: #fff;
  border: 1px solid #ccc;
  border: 1px solid rgba(0, 0, 0, .15);
  border-width: 0 1px 1px;
  border-radius: 0 0 4px 4px;
  -webkit-box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
          box-shadow: 0 6px 12px rgba(0, 0, 0, .175);
}
.navbar-default .navbar-nav .open .dropdown-menu > li > a {
  color: #333;
}
.navbar .navbar-nav .open .dropdown-menu > li > a:hover,
.navbar .navbar-nav .open .dropdown-menu > li > a:focus,
.navbar .navbar-nav .open .dropdown-menu > .active > a,
.navbar .navbar-nav .open .dropdown-menu > .active > a:hover,
.navbar .navbar-nav .open .dropdown-menu > .active > a:focus {
  color: #fff !important;
  //background-color: #428bca !important;
}
.navbar .navbar-nav .open .dropdown-menu > .disabled > a,
.navbar .navbar-nav .open .dropdown-menu > .disabled > a:hover,
.navbar .navbar-nav .open .dropdown-menu > .disabled > a:focus {
  color: #999 !important;
  //background-color: transparent !important;
}
</style>
</head>

<body class="pace-done mini-navbar">

  <div id="wrapper" style="margin-top: -25px">

    <div class="row">
        <?php
        $nav_bg = isset($nav_bg)?$nav_bg:"#072b42";
        $ficon = isset($ficon)?$ficon:"";
        $headlink =  isset($headlink)?$headlink:"";
        if(isset($usrpm['app_parent_id'])) {
            $row = $this->admin_model->getOnce_Application($usrpm['app_parent_id']);
            $nav_bg = !empty($row['app_color'])?$row['app_color']:"#072b42";
            $ficon = !empty($row['app_icon'])?$row['app_icon']:"";
            $headlink = $row['app_link'];
        }
        ?>
        <nav class="navbar navbar-fixed-top" role="navigation" style="font-size: 20px; min-height: 44px; margin-bottom: 0;background-color: <?php echo $nav_bg;?>; ">
            <div class="navbar-header">
                <a style="color: #fff;" href="<?php echo $headlink;?>" title="<?php echo $site['site_title'];?>">
                    <i style="padding-left:10px;padding-top: 12px;font-size: 20px; color: #fff !important" class="<?php echo $ficon;?>" aria-hidden="true"></i> <?php echo $head_title;?>
                </a>
            </div>
            <style type="text/css">
                .nav.navbar-right > li > a{
                    padding-top: 9px;
                    padding-bottom: 0px;
                }
                .navbar-top-links li a{
                    padding-left: 0px;
                    padding-right: 0px;
                    min-height: 44px;
                }
                .navbar-top-links li:last-child{
                    margin-right: 20px;
                }

            </style>
            <ul class="nav navbar-top-links navbar-right" style="position: relative; background-color: rgba(37, 31, 31, 0.37);padding-top: 6px;height: 44px;">

                <?php
                  //$user = get_session('user_firstname').' '.get_session('user_lastname');
                  $user = get_session('user_firstname');
                ?>
                <li title="<?php echo $user;?>" style="margin-top: -5px; margin-bottom: 0px;">
                  <a style="position: absolute; left:-240px; top:-25px; display:table; width: 240px;padding-top: 5px;"  href="<?php echo base_url('member/edit_profile/edit/'.uri_seg(1).'/'.uri_seg(2)); ?>" title="<?php echo $user;?>">

                      <!-- <img src="<?php echo path(get_session('user_photo_file'),'member');?>" class="profile img-circle border-1" style="border: 2px #eee solid; position: absolute; left: -25px; top: 11px;" width="26" height="26">   -->
                      <span class="m-r-sm text-muted welcome-message" style="padding-left:5px;font-weight: initial; font-size: 20px; color:#fff; display: block; float: right; max-width: 190px;  white-space: nowrap;overflow: hidden;text-overflow: ellipsis;"><?php echo $user;?></span>

                      <img src="<?php echo base_url(get_session('user_photo_file'));?>" class="profile img-circle border-1" style="margin-top:2px;border: 2px #fff solid;  display:block;float: right" width="26" height="26">


                  </a>
                  <script type="text/javascript">

                      function onmodal_edit(){
                           $('#edit_profile').modal('show');
                      }
                  </script>
                </li>

                <li>
                    <a title="เมนูหลัก" style="display: inline; color:#fff" dropdown-toggle" data-toggle="dropdown">
                        <i style="font-size: 14px; color: #fff !important" class="fa fa-windows" aria-hidden="true"></i>เมนูหลัก
                    </a>
                    <?php $this->load->view($this->template->name.'/head_menu_list');?>
                </li>
                <!-- Message Box -->
                <!-- <li class="dropdown">
                    <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i style="font-size: 22px; color: #2f4250 !important" class="fa fa-comments" aria-hidden="true"></i>  <span class="label label-danger" style="top:4px;right: 4px;">16</span>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="<?php echo path(get_session('user_photo_file'),'member');?>">
                                </a>
                                <div class="media-body">
                                    <small class="pull-right">46h ago</small>
                                    <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">3 days ago at 7:58 pm - 10.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="<?php echo path(get_session('user_photo_file'),'member');?>">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right text-navy">5h ago</small>
                                    <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                                    <small class="text-muted">Yesterday 1:21 pm - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="dropdown-messages-box">
                                <a href="profile.html" class="pull-left">
                                    <img alt="image" class="img-circle" src="<?php echo path(get_session('user_photo_file'),'member');?>">
                                </a>
                                <div class="media-body ">
                                    <small class="pull-right">23h ago</small>
                                    <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                                    <small class="text-muted">2 days ago at 2:30 am - 11.06.2014</small>
                                </div>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="mailbox.html">
                                    <i class="fa fa-envelope text-warning"></i> <strong>Read All Messages</strong>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li> -->
                <!-- End Message Box -->
                <li style='padding-left: 5px;border-left: 1px <?php echo $nav_bg;?> solid'>
                    <a title="คู่มือช่วยเหลือ"  href="../assets/file/59DOP01-Manual.pdf" target="_blank" style="display: inline; color:#fff">
                        <i style="font-size: 14px; color: #fff !important" class="fa fa-life-ring" aria-hidden="true"></i>คู่มือช่วยเหลือ
                    </a>
                </li>
                <li  style='padding-left: 5px;border-left: 1px <?php echo $nav_bg;?> solid'>
                    <a title="ออกจากระบบ" href="<?php echo site_url('manage/logout');?>" style="display: inline; color:#fff">
                        <i style="font-size: 14px; color: #fff !important" class="fa fa-power-off" aria-hidden="true"></i>ออกจากระบบ
                    </a>
                </li>

            </ul>

        </nav>
    </div>
    <style type="text/css">
        .minimalize-styl-2{
            margin: 5px 5px 5px 20px;
        }
    </style>
    <div class="row wrapper border-bottom white-bg page-heading" style="margin-top: 0px; padding: 0 !important; color: #000">
        <div class="col-xs-12 col-sm-5" style="padding-right: 30px;">


                <!-- *Permission Menu -->
              <?php //$this->load->view($this->template->name.'/head_menu');?>
                <!-- End *Permission Menu -->

            <ol class="breadcrumb" style="font-size: 16px;padding-left: 0px; margin-top: 6px; margin-bottom: 0px;">
                <li class="active" style="width: 100%; display:table; color: #000">&nbsp;&nbsp;<?php echo $title;?></li>
            </ol>
        </div>
        <div class="col-xs-12 col-sm-7">
            <div style="float: right" id="menu_topright">
                <!--
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-top: 11px; margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 5px 20px 3px 20px;" href="<?php echo site_url('control/main_module');?>"><i class="fa fa-plus" aria-hidden="true"></i> </a>
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-top: 11px; margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 5px 20px 3px 20px;" href="<?php echo site_url('control/main_module');?>"><i class="fa fa-filter" aria-hidden="true"></i> </a>
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-top: 11px; margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 5px 20px 3px 20px;" href="<?php echo site_url('control/main_module');?>"><i class="fa fa-file-excel-o" aria-hidden="true"></i> </a>
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary" style="margin-top: 11px; margin-left: 0px; background-color: #2f4250; border: 0;font-size: 17px; padding: 5px 20px 3px 20px;" href="<?php echo site_url('control/main_module');?>"><i class="fa fa-caret-left" aria-hidden="true"></i> </a>
                -->
            </div>
        </div>
    </div>

    <div class="wrapper wrapper-content animated fadeInRight" style="padding: 0px !important">
        <div class="row">
            <div class="col-lg-12">
                <div class="ibox float-e-margins" style="margin-bottom:0px">
                    <div class="ibox-content p-xs" style="min-height: 550px;">
                    <style type="text/css">
                        .dataTables_wrapper{
                            padding-bottom: 0px;
                        }
                        #dtable_info ,#dtable_paginate{
                            font-size: 16px !important;
                        }
                    </style>
                    <?php
                        if($this->template->content_view_set==0)
                            $this->load->view($this->template->name.'/'.$content_view);
                        else
                            $this->load->file(APPPATH.'modules/'.uri_seg(1).'/views/back-end/'.$content_view.'.php');
                    ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row border-top border-bottom" style="background-color: #fff">
            <div class="col-lg-12" style="padding: 3px 22px;">
                <div class="pull-right" style="font-size: 16px; color: #2f4050 !important;">
                    เวอร์ชั่น 1.0
                </div>
                <div style="font-size: 16px; color: #2f4050 !important;">
                    © สงวนลิขสิทธิ์โดย <strong>กรมกิจการผู้สูงอายุ</strong> | พัฒนาโดย <strong>บริษัท จิ๊กซอว์ อินโนเวชั่น จำกัด</strong>
                </div>
            </div>
        </div> -->

    </div>


    </div>

</body>

<?php $this->load->file('assets/admin/tools/tools_script.php'); ?>
<?php
    if($this->template->content_view_set==1){
        $this->load->file('assets/modules/'.uri_seg(1).'/tools/back-end/tools_script.php');
    }
?>
</html>
