<style>
    ul.treeview-menu li{
        /*text-align:center;*/
        margin-left: 40px;
    }
</style>
<!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar bg-dark" style='height:100%'> 
    <!-- sidebar: style can be found in sidebar.less -->
    <div class="sidebar"> 
      <!-- Sidebar user panel -->
      <div class="user-panel bg-white">
          <?php if($_SESSION['concern'] == 1){
            $imgPath =  "../img/mojlogo.png";
          }else if($_SESSION['concern'] == 2){
            $imgPath =   "../img/cmclogo.jpeg";  
          }
          ?>
        <div class="imag text-center"><img src="<?php echo $imgPath; ?>"  style='height:130px; width:100%' class="img-circl" alt="User Image"> </div></div>
        <!--<div class="info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-cog"></i></a> <a href="#"><i class="fa fa-envelope-o"></i></a> <a href="#"><i class="fa fa-power-off"></i></a> </div>-->
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MANAGEMENT</li>
        <!--<?php //if ($_SESSION['role'] != 'user'): ?>-->
        <!--<li><a href='index'><i class='fa fa-external-link-square'></i>Entry</a></li>-->
        <!--<?php //endif; ?>-->
        <li><a href='dashboard.php'><i class='fa fa-columns'></i>Dashboard</a></li>
        <li class="activ treeview"> <a href="#"> <i class="fa fa-briefcase"></i> <span>Case Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <?php if ($_SESSION['role'] != 'user'): ?>
            <li class="active"><a href="create_case.php">Add New Case</a></li>
            <!--<li><a href="unassigned_cases">Un-Assigned Cases</a></li>
            <li><a href="assigned_cases">Assigned Cases</a></li>-->
            <li><a href='cases.php'>All Cases</a></li>
            <li><a href="find_case.php">Find a Case</a></li>
            
            <?php else : ?>
            <li><a href='cases.php'>My Cases</a></li>
            <li><a href="find_case.php">Find a Case</a></li>
            <?php endif; ?>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-user"></i> <span>Client Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <?php if ($_SESSION['role'] != 'user'): ?>
            <li class="active"><a href="create_client.php">Add New Client</a></li>
            <!--<li><a href="unassigned_cases">Un-Assigned Cases</a></li>
            <li><a href="assigned_cases">Assigned Cases</a></li>-->
            <li><a href='clients.php'>All Clients</a></li>

            <?php else : ?>
            <li><a href='clients.php'>My Clients</a></li>
            <?php endif; ?>
          </ul>
        </li>

        <?php if ($_SESSION['role'] != 'user') : ?>
        <li class="treeview"> <a href="#"> <i class="fa fa-users"></i> <span>User Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="create_user.php">Add New User</a></li>
            <li><a href="users.php">All Users</a></li>
          </ul>
        </li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] == 'super_admin') : ?>
        <li class="treeview"> <a href="#"> <i class="fa fa-home "></i> <span>Location Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="create_center.php">Add New Center</a></li>
           <!-- <li><a href="list_centers">List All Centers</a></li>-->
            
          </ul>
        </li>
        <?php endif; ?>
         <li class="treeview"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>Report Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <!--<li><a href="#">Petition</a></li>-->
            <!--<li><a href="#">Complain</a></li>-->
        <?php if ($_SESSION['role'] != 'user') : ?>
        <li class=""><a href="closed.php">Closed Matter (s)</a> </li>
            <li><a href="ongoing.php">Ongoing Matter (s)</a></li>
            
            <!--<li><a href="center_report">Center Report</a></li>-->
            
        <?php endif; ?>
        <li><a href="case_report.php">Case Report</a></li>
          </ul>
        </li>

        <li><a href="activity_report.php"><i class="fa fa-pie-chart"></i> <span>CMC Infographics</span>  </a></li>

      </ul>
    </div>
    <!-- /.sidebar --> 
  </aside>