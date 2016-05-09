<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SIMURA | Point Of Sales</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link href="<?php echo base_url("assets/css/bootstrap.min.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/css/jquery-ui.min.css"); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url("assets/css/jquery-ui.theme.min.css"); ?>" rel="stylesheet" type="text/css" />

    <!-- Ionicons -->
    <link rel="stylesheet" href="<?php echo base_url("assets/css/font-awesome.min.css")?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/ionicons.min.css")?>">

    <!-- Theme style -->
    <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/AdminLTE.min.css")?>">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="<?php echo base_url("assets/dist/css/skins/skin-blue.min.css")?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/dropzone.css")?>">
    <link rel="stylesheet" href="<?php echo base_url("assets/css/main.css")?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="<?php echo base_url("assets/js/html5shiv.min.js")?>">
        <script src="<?php echo base_url("assets/js/respond.min.js")?>">
    <![endif]-->


<style>
  #tooltip {
    position: absolute;
    width: 90px;
    height: auto;
    padding: 10px;
    background-color: white;
    -webkit-border-radius: 10px;
    -moz-border-radius: 10px;
    border-radius: 10px;
    -webkit-box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.4);
    -moz-box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.4);
    box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.4);
    pointer-events: none;
  }
  #tooltip.hidden {
    display: none;
  }
  #tooltip p {
    margin: 0;
    font-family: sans-serif;
    font-size: 12px;
    line-height: 16px;
  }
  .indent {
    padding-left: 5px;
  }
  rect {
    -moz-transition: all 0.3s;
    -webkit-transition: all 0.3s;
    -o-transition: all 0.3s;
    transition: all 0.3s;
  }
  rect:hover {
    fill: orange;
  }
  .axis path, .axis line {
    fill: none;
    stroke: black;
    shape-rendering: crispEdges;
  }
  .axis text {
    font-family: sans-serif;
    font-size: 11px;
  }
  /*.legend {
      padding: 2px;
      border: 2px solid black;
  }*/
</style>

  </head>

  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

      <!-- Main Header -->
      <header class="main-header">

        <!-- Logo -->
        <a href="<?=  base_url()?>admin" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>SPOS</b></span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>SPOS</b>dashboard</span>
        </a>

        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <!-- Navbar Right Menu -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->

              <!-- User Account Menu -->
              <li class="user user-menu">
                <script type="text/javascript">
                  /*
                  var currentDate = new Date();
                  var day = currentDate.getDate();
                  var month = currentDate.getMonth() + 1;
                  var year = currentDate.getFullYear();
                  document.write("<a href="#"><b>" + day + "/" + month + "/" + year + "</b></a>");
                  */
                </script>
              </li>

              <?php /*
              <!-- User Account Menu -->
              <li class="user user-menu">
                <a href="<?php base_url() ?>/ICS_NEW/admin/contacts" class="btn">Contacts</a>
              </li>
              */ ?>
              <li class="user user-menu">
                <a href="<?php base_url() ?>/spos/login/logout" class="btn">Sign out</a>
              </li>
            
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">

        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">

          <!-- Sidebar Menu -->
          <ul class="sidebar-menu">
            <?php
            $user = $this->ion_auth->user()->row();
            //echo $user->username;


              $group = $this->ion_auth->get_users_groups()->row()->name;
              //var_dump($group);

                //if(!($group == 'admin' || $group == 'sales')) {
                if(!($group == 'sales')) {

              }else{
             ?>

            <li><a href="#"><i class="fa fa-th-list"></i><span><?php echo strtoupper($user->first_name); ?><span></a></li>
            <li><a href="<?=  base_url()?>inventory/invoice"><i class="fa fa-th-list"></i><span>New Invoice<span></a></li>
            <li class="treeview">
              <a href="#" marked="1">
                <i class="fa fa-cog"></i> <span>Inventory</span>
                <i class="fa fa-angle-left pull-right"></i>
              </a>
              <ul class="treeview-menu" style="display: none;">
                <li><a href="<?=  base_url()?>inventory/index" marked="1"><i class="fa fa-circle-o"></i> All Inventory</a></li>
                <li><a href="<?=  base_url()?>inventory/add_to_inventory" marked="1"><i class="fa fa-circle-o"></i> Add Inventory</a></li>
                <li><a href="<?=  base_url()?>inventory/transfer_or_return" marked="1"><i class="fa fa-circle-o"></i>Return/Transfer</a></li>
           </ul>
            </li>


              <li><a href="<?=  base_url()?>inventory/all_invoice" marked="1"><i class="fa fa-circle-o"></i> All Invoice</a></li>
              <li><a href="<?=  base_url()?>inventory/get_daily_product_summary" marked="1"><i class="fa fa-circle-o"></i> Daily Summary</a></li>

             <?php } ?>
            <?php if($group == 'admin'){ ?>
              <li class="treeview">
                <a href="#" marked="1">
                  <i class="fa fa-cog"></i> <span>Summary</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                  <li><a href="<?=  base_url()?>inventory/all_invoice_for_admin" marked="1"><i class="fa fa-circle-o"></i> All Invoice</a></li>
                  <li><a href="<?=  base_url()?>inventory/get_all_daily_product_summary_admin" marked="1"><i class="fa fa-circle-o"></i> Daily Summary</a></li>
                  <li><a href="<?=  base_url()?>inventory/all_inventory" marked="1"><i class="fa fa-circle-o"></i> All Inventory</a></li>
                </ul>
              </li>
              <li class="treeview">
                <a href="#" marked="1">
                  <i class="fa fa-cog"></i> <span>Variables</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                  <li><a href="<?=  base_url()?>inventory/add_product_category" marked="1"><i class="fa fa-circle-o"></i> Category</a></li>
                  <li><a href="<?=  base_url()?>inventory/add_product_name" marked="1"><i class="fa fa-circle-o"></i> Product Name</a></li>
                  <!--<li><a href="<?php  //base_url() ?>inventory/add_product_code" marked="1"><i class="fa fa-circle-o"></i> Product Code</a></li>-->
                  <li><a href="<?=  base_url()?>inventory/add_product_color" marked="1"><i class="fa fa-circle-o"></i> Color</a></li>
                  <li><a href="<?=  base_url()?>inventory/add_product_size" marked="1"><i class="fa fa-circle-o"></i>Size</a></li>
                  <li><a href="<?=  base_url()?>inventory/add_product_fabric" marked="1"><i class="fa fa-circle-o"></i> Fabric Details</a></li>
                </ul>
              </li>

              <li class="treeview">
                <a href="#" marked="1">
                  <i class="fa fa-cog"></i> <span>Products</span>
                  <i class="fa fa-angle-left pull-right"></i>
                </a>
                <ul class="treeview-menu" style="display: none;">
                  <li><a href="<?=  base_url()?>inventory/add_product"><i class="fa fa-th-list"></i> <span>Add Product<span></a></li>

                </ul>
              </li>



            <?php } ?>
            <?php if($group == 'admin'){  ?>
              <li><a href="<?=  base_url()?>auth/index"><i class="fa fa-th-list"></i> <span>Users<span></a></li>
            <?php } ?>
    </ul>
        </section>
        <!-- /.sidebar -->
      </aside>

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
