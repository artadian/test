<?php include 'layout/css.php'; ?>

    <!-- Preloader -->
    <div class="preloader">
        <div class="cssload-speeding-wheel"></div>
    </div>
    <div id="wrapper"> 
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header"> <a class="navbar-toggle hidden-sm hidden-md hidden-lg " href="javascript:void(0)" data-toggle="collapse" data-target=".navbar-collapse"><i class="icon-grid"></i></a>
                <div class="top-left-part"><a class="logo" href="<?php echo base_url('admin/dashboard/') ?>"><b><img src="<?php echo base_url();?>optimum/title2.png" alt="Codeig" height="50px" width="200px"/></b><span class="hidden-xs"></span></a></div>
                <ul class="nav navbar-top-links navbar-left hidden-xs">
                    <li><a href="javascript:void(0)" class="open-close hidden-xs"><i class="icon-grid"></i></a></li>                    
                </ul>				
				
							
					
					 <ul class="nav navbar-top-links navbar-right pull-right">
                  
                
					
                    <!--<li class="dropdown"> <a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-feed"></i>
          <div class="notify"><span class=""></span><span class=""></span></div>
          </a>
                        <ul class="dropdown-menu dropdown-tasks animated bounceInRight">
                            <li>
                                <a href="#">
                                    <div>
                                        <p> <strong>Task 1</strong> <span class="pull-right text-muted">40% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p> <strong>Task 2</strong> <span class="pull-right text-muted">20% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100" style="width: 20%"> <span class="sr-only">20% Complete</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p> <strong>Task 3</strong> <span class="pull-right text-muted">60% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 60%"> <span class="sr-only">60% Complete (warning)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <p> <strong>Task 4</strong> <span class="pull-right text-muted">80% Complete</span> </p>
                                        <div class="progress progress-striped active">
                                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" style="width: 80%"> <span class="sr-only">80% Complete (danger)</span> </div>
                                        </div>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#"> <strong>See All Tasks</strong> <i class="fa fa-angle-right"></i> </a>
                            </li>
                        </ul>-->
                        <!-- /.dropdown-tasks -->
                    <!--</li>-->
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#"> <img src="<?php echo base_url();?>optimum/images/admin.jpg" alt="user-img" width="36" class="img-circle"><b class="hidden-xs"><?php echo $this->session->userdata('name'); ?></b> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li><a href="javascript:void(0)"><i class="ti-user"></i>  My Profile</a></li>                            
                            <li><a href="<?php echo base_url('admin/account/account_setting') ?>"><i class="ti-settings"></i>  Account Setting</a></li>
                            <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off"></i>  Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    	<!--<li class="right-side-toggle"> <a class="waves-effect waves-light" href="javascript:void(0)"><i class="ti-settings"></i></a></li>-->
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- Left navbar-header -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse slimscrollsidebar">
                <ul class="nav" id="side-menu">                    
                    <li class="user-pro">
                        <a href="#" class="waves-effect"><img src="<?php echo base_url();?>optimum/images/admin.jpg" alt="user-img" class="img-circle"> <span class="hide-menu"><?php echo $this->session->userdata('name'); ?><span class="fa arrow"></span></span>
                        </a>
                        <ul class="nav nav-second-level">
                            <li><a href="javascript:void(0)"><i class="ti-user"></i> My Profile</a></li>                           
                            <li><a href="<?php echo base_url('admin/account/account_setting') ?>"><i class="ti-settings"></i> Account Setting</a></li>
                            <li><a href="<?php echo base_url('auth/logout') ?>"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                    </li>
                    <li> <a href="<?php echo base_url('admin/dashboard') ?>" class="waves-effect"><i class="ti-dashboard p-r-10"></i> <span class="hide-menu">Dashboard</span></a> </li> 
                    <li> <a href="javascript:void(0);" class="waves-effect"><i class="icon-envelope p-r-10"></i> <span class="hide-menu"> Transaction <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="<?php echo base_url('admin/transaksi') ?>">Purchase Order</a></li>
                            <li> <a href="<?php echo base_url('admin/transaksi/GoodsReceipt') ?>">Goods Receipt</a></li>                          
                        
                        </ul>
                    </li>
					
                    <li> <a href="javascript:void(0);" class="waves-effect"><i class="icon-pin p-r-10"></i> <span class="hide-menu"> Master Data <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li><a href="<?php echo base_url('admin/masterdata/list_barang') ?>">Goods</a></li>               				
                            <li><a href="<?php echo base_url('admin/masterdata/list_supplier') ?>">Supplier</a></li>
                            
							
                        </ul>
                    </li>
                    <!-- 
					<li> <a href="#" class="waves-effect"><i class="icon-list p-r-10"></i> <span class="hide-menu"> Finished <span class="fa arrow"></span> </span></a>
                        <ul class="nav nav-second-level">                                                       
                            <li><a href="<?php echo base_url('admin/ongoingfinishpackage/list_ongoingfinish') ?>">On Going Package</a></li>      
                            <li><a href="<?php echo base_url('admin/sentpackage/sent_package') ?>">Sent Package</a></li>                  
                            <li> <a href="<?php echo base_url('admin/receivedpackage/received_package') ?>">Received Package</a></li>  
                       	</ul>
                    </li>
                   
                    <li> <a href="javascript:void(0);" class="waves-effect"><i class="icon-magnifier p-r-10"></i> <span class="hide-menu"> Tracking <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="<?php echo base_url('admin/trackingpackage/tracking_package') ?>">Tracking Package</a></li>
                            <li> <a href="<?php echo base_url('admin/trackingdocument/tracking_document') ?>">Tracking Document</a></li>               
                        </ul>
                    </li>
                    
                    <li> <a href="javascript:void(0);" class="waves-effect"><i class="icon-grid p-r-10"></i> <span class="hide-menu"> Report <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                        	<?php if ($this->session->userdata('userreport') <> NULL) { ?>
                            <li> <a href="<?php echo base_url('admin/reportsent/list_sent') ?>">Package Sent</a></li>                            <?php } ?>                        	
                        </ul>
                    </li>
                   
                   <li> <a href="javascript:void(0);" class="waves-effect"><i class="icon-question p-r-10"></i> <span class="hide-menu"> Help <span class="fa arrow"></span></span></a>
                        <ul class="nav nav-second-level">
                            <li> <a href="<?php echo base_url('admin/dashboard/user_manual') ?>">User Manual</a></li>
                        </ul>
                    </li> -->
                    
                    <li><a href="<?php echo base_url('auth/logout') ?>" class="waves-effect"><i class="icon-logout p-r-10"></i> <span class="hide-menu"> Log out</span></a></li>
                </ul>
            </div>
        </div>
        <!-- Left navbar-header end -->
       
	   
	    <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                
			<div class="row bg-title">
                    <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                        <h4 class="page-title"></h4>
                    </div>
                    <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12"> 
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>admin/dashboard/">Home</a></li>
                            <li class="active"> <?php echo $page_title; ?></li>
                        </ol>
                    </div>
                    <!-- /.col-lg-12 -->
                </div> 	
				
				
				
				
				<!--  row    ->
               <?php echo $main_content; ?>
                <!-- /.row -->
			
            </div>
            <!-- /.container-fluid -->
           <?php include 'layout/footer.php'; ?>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- jQuery -->
   <?php include 'layout/js.php'; ?>
