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
        <div class="imag text-center"><img src="/img/mojlogo.png"  style='height:130px; width:100%' class="img-circl" alt="User Image"> </div></div>
        <!--<div class="info">
          <p>Alexander Pierce</p>
          <a href="#"><i class="fa fa-cog"></i></a> <a href="#"><i class="fa fa-envelope-o"></i></a> <a href="#"><i class="fa fa-power-off"></i></a> </div>-->
      </div>
      
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MANAGEMENT</li>
        <?php if ($_SESSION['role'] != 'user'): ?>
        <li><a href='index'><i class='fa fa-external-link-square'></i>Entry</a></li>
        <?php endif; ?>
        <li><a href='dashboard'><i class='fa fa-columns'></i>Dashboard</a></li>
        <li class="activ treeview"> <a href="#"> <i class="fa fa-briefcase"></i> <span>Case Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <?php if ($_SESSION['role'] != 'user'): ?>
            <li class="active"><a href="create_case">Add New Case</a></li>
            <!--<li><a href="unassigned_cases">Un-Assigned Cases</a></li>
            <li><a href="assigned_cases">Assigned Cases</a></li>-->
            <li><a href='cases'>All Cases</a></li>
            
            <?php else : ?>
            <li><a href='cases'>My Cases</a></li>
            <li><a href="share_case">Share Case</a></li>
            <?php endif; ?>
          </ul>
        </li>
        <?php if ($_SESSION['role'] != 'user') : ?>
        <li class="treeview"> <a href="#"> <i class="fa fa-users"></i> <span>User Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="create_user">Add New User</a></li>
            <li><a href="users">All Users</a></li>
          </ul>
        </li>
        <?php endif; ?>
        <?php if ($_SESSION['role'] == 'super_admin') : ?>
        <li class="treeview"> <a href="#"> <i class="fa fa-home "></i> <span>Location Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="create_center">Add New Center</a></li>
           <!-- <li><a href="list_centers">List All Centers</a></li>-->
            
          </ul>
        </li>
        <?php endif; ?>
         <li class="treeview"> <a href="#"> <i class="fa fa-file-text-o"></i> <span>Report Management</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="case_report">Case Report</a></li>
            <li><a href="petition_report">Petition Report</a></li>
            <li><a href="activity_report">Activity Report</a></li>
          </ul>
        </li>
       <!-- <li class="treeview"> <a href="#"> <i class="fa fa-briefcase"></i> <span>UI Elements</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="ui-cards.html" class="active">Cards</a></li>
            <li><a href="ui-user-card.html">User Cards</a></li>
            <li><a href="ui-tab.html">Tab</a></li>
            <li><a href="ui-grid.html">Grid</a></li>
            <li><a href="ui-buttons.html">Buttons</a></li>
            <li><a href="ui-notification.html">Notification</a></li>
            <li><a href="ui-progressbar.html">Progressbar</a></li>
            <li><a href="ui-range-slider.html">Range slider</a></li>
            <li><a href="ui-timeline.html">Timeline</a></li>
            <li><a href="ui-horizontal-timeline.html">Horizontal Timeline</a></li>
            <li><a href="ui-breadcrumb.html">Breadcrumb</a></li>
            <li><a href="ui-typography.html">Typography</a></li>
            <li><a href="ui-bootstrap-switch.html">Bootstrap Switch</a></li>
            <li><a href="ui-tooltip-popover.html">Tooltip &amp; Popover</a></li>
            <li><a href="ui-list-media.html">List Media</a></li>
            <li><a href="ui-carousel.html">Carousel</a></li>
          </ul>
        </li>
        <li class="header">FORMS, TABLE & WIDGETS</li>
        <li class="treeview"> <a href="#"> <i class="fa fa-edit"></i> <span>Forms</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="form-elements.html">Form Elements</a></li>
            <li><a href="form-validation.html">Form Validation</a></li>
            <li><a href="form-wizard.html">Form Wizard</a></li>
            <li><a href="form-layouts.html">Form Layouts</a></li>
            <li><a href="form-uploads.html">Form File Upload</a></li>
            
            <li><a href="form-summernote.html">Summernote</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-table"></i> <span>Tables</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="table-basic.html">Basic Tables</a></li>
            <li><a href="table-layout.html">Table Layouts</a></li>
            <li><a href="table-data-table.html">Data Tables</a></li>
            <li><a href="table-jsgrid.html">Js Grid Table</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-th"></i> <span>Widgets</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="widget-data.html">Data Widgets</a></li>
            <li><a href="widget-apps.html">Apps Widgets</a></li>
          </ul>
        </li>
        <li class="header">EXTRA COMPONENTS</li>
        <li class="treeview"> <a href="#"><i class="fa fa-bar-chart"></i> <span>Charts</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="chart-morris.html">Morris Chart</a></li>
            <li><a href="chart-chartist.html">Chartis Chart</a></li>
            
            <li><a href="chart-knob.html">Knob Chart</a></li>
            <li><a href="chart-chart-js.html">Chartjs</a></li>
            <li><a href="chart-peity.html">Peity Chart</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-files-o"></i> <span>Sample Pages</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="pages-blank.html">Blank page</a></li>
            <li class="treeview"><a href="#">Authentication <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
              <ul class="treeview-menu">
                <li><a href="pages-login.html">Login 1</a></li>
                <li><a href="pages-login-2.html">Login 2</a></li>
                <li><a href="pages-register.html">Register</a></li>
                <li><a href="pages-register2.html">Register 2</a></li>
                <li><a href="pages-lockscreen.html">Lockscreen</a></li>
                <li><a href="pages-recover-password.html">Recover password</a></li>
              </ul>
            </li>
            <li><a href="pages-profile.html">Profile page</a></li>
            <li><a href="pages-invoice.html">Invoice</a></li>
            <li><a href="pages-treeview.html">Treeview</a></li>
            <li><a href="pages-pricing.html">Pricing</a></li>
            <li><a href="pages-gallery.html">Gallery</a></li>
            <li><a href="pages-faq.html">Faqs</a></li>
            <li><a href="pages-404.html">404 Error Page</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-map-marker"></i> <span>Maps</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="map-google.html">Google Maps</a></li>
            <li><a href="map-vector.html" class="active">Vector Maps</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-paint-brush"></i> <span>Icons</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="icon-fontawesome.html">Fontawesome Icons</a></li>
            <li><a href="icon-themify.html">Themify Icons</a></li>
            <li><a href="icon-linea.html">Linea Icons</a></li>
            <li><a href="icon-weather.html">Weather Icons</a></li>
            <li><a href="icon-simple-lineicon.html">Simple Lineicons</a></li>
            <li><a href="icon-flag.html">Flag Icons</a></li>
          </ul>
        </li>
        <li class="treeview"> <a href="#"> <i class="fa fa-share"></i> <span>Multilevel</span> <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
          <ul class="treeview-menu">
            <li><a href="#">Level One</a></li>
            <li class="treeview"> <a href="#">Level One <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
              <ul class="treeview-menu">
                <li><a href="#"> Level Two</a></li>
                <li class="treeview"> <a href="#">Level Two <span class="pull-right-container"> <i class="fa fa-angle-left pull-right"></i> </span> </a>
                  <ul class="treeview-menu">
                    <li><a href="#">Level Three</a></li>
                    <li><a href="#">Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#">Level One</a></li>
          </ul>
        </li>-->
      </ul>
    </div>
    <!-- /.sidebar --> 
  </aside>