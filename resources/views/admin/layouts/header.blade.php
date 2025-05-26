  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>

    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->


      <!-- Messages Dropdown Menu -->

    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <div class="brand-link" style="text-align: center;">
      <span class="brand-text"> Ecommerce</span>
      </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->




      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="{{url('admin/dashboard')}}" class="nav-link @if(Request::segment(2) =='dashboard') active @endif">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
               
              </p>
            </a>
          </li>

          <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
              <li class="nav-item">
                <a href="{{url('admin/admin/list')}}" class="nav-link @if(Request::segment(2) =='admin') active @endif">
                  <i class="nav-icon fas fa-users"></i>
                  <p>
                    Admin
                   
                  </p>
                </a>
              </li>

              <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <li class="nav-item">
                    <a href="{{url('admin/category/list')}}" class="nav-link @if(Request::segment(2) =='category') active @endif">
                      <i class="nav-icon fas fa-list-alt"></i>
                      <p>
                        Category
                       
                      </p>
                    </a>
                  </li>
                  
                  
                  <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                      <li class="nav-item">
                        <a href="{{url('admin/sub_category/list')}}" class="nav-link @if(Request::segment(2) =='sub_category') active @endif">
                          <i class="nav-icon fas fa-list-alt"></i>
                          <p>
                            Sub Category
                           
                          </p>
                        </a>
                      </li>

                      <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                          <li class="nav-item">
                            <a href="{{url('admin/brand/list')}}" class="nav-link @if(Request::segment(2) =='brand') active @endif">
                              <i class="nav-icon fas fa-list-alt"></i>
                              <p>
                                Brand
                               
                              </p>
                            </a>
                          </li>
                          <nav class="mt-2">
                            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                              <li class="nav-item">
                                <a href="{{url('admin/color/list')}}" class="nav-link @if(Request::segment(2) =='color') active @endif">
                                  <i class="nav-icon fas fa-list-alt"></i>
                                  <p>
                                    Color
                                   
                                  </p>
                                </a>
                              </li>
                                    


                  <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                      <li class="nav-item">
                        <a href="{{url('admin/product/list')}}" class="nav-link @if(Request::segment(2) =='product') active @endif">
                          <i class="nav-icon fas fa-list-alt"></i>
                          <p>
                            Product
                           
                          </p>
                        </a>
                      </li>              
    




          <li class="nav-item">
            <a href="{{url('admin/logout')}}" class="nav-link">
              <i class="nav-icon fas fa-sign-out-alt"></i>
              <p>
                Logout
               
              </p>
            </a>
          </li>


          

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
