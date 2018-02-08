<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="description" content="<?php echo $web_description; ?>">
	<meta name="keywords" content="<?php echo $web_keyword; ?>">
	<meta name="author" content="<?php echo $web_author; ?>">
	<link rel="shortcut icon" href="<?php echo site_url("assets/modules/webconfig/images/".$web_icon);?>" type="image/x-icon">
    <link rel="icon" href="<?php echo site_url("assets/modules/webconfig/images/".$web_icon);?>" type="image/x-icon">
	<title>กรมกิจการผู้สูงอายุ</title>
    <?php $this->load->file("assets/tools/tools_webconfig.php");?>
</head>
<body>
	<?php 
	$this->load->view("web_template1/header/header");
	$this->load->view($content_view);
	$this->load->view("web_template1/footer/footer"); 
	?>

<?php $this->load->file("assets/tools/tools_webscript.php");?>
   
</body>
</html>