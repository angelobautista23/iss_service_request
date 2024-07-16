<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="{{ route('dashboard') }}" class="brand-link">
    <!-- <center> -->
    <!-- <img src="{{ asset('public/images/favicon.png') }}"
         alt="JCT"
         class="brand-image img-circle elevation-3"> -->
      <!-- <i class="fa fa-home"></i> -->
    <center><span class="brand-text font-weight-light">ISS Service Request</span></center>
    <!-- </center> -->
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item has-treeview">
          <a href="../RapidX/" class="nav-link">
            <i class="nav-icon fas fa-arrow-left"></i>
            <p>
              Return to RapidX
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="{{ route('dashboard') }}" class="nav-link">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="{{ route('my_tickets') }}" class="nav-link">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>
              My Tickets
            </p>
          </a>
        </li>

        @if($_SESSION["sr_admin"] == 1)
        <li class="nav-item has-treeview">
          <a href="{{ route('users') }}" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Users
            </p>
          </a>
        </li>

        <li class="nav-item has-treeview">
          <a href="{{ route('service_types') }}" class="nav-link">
            <i class="nav-icon fas fa-list"></i>
            <p>
              Service Types
            </p>
          </a>
        </li>
        @endif

        @if($_SESSION["sr_admin"] == 1 || $_SESSION["sr_iss_staff"] == 1)
        <li class="nav-item has-treeview">
          <a href="{{ route('ticketing') }}" class="nav-link">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>
              Ticketing
            </p>
          </a>
        </li>
        @endif

        @if($_SESSION["sr_admin"] == 1)
        <li class="nav-item has-treeview">
          <a href="{{ route('holidays') }}" class="nav-link">
            <i class="nav-icon fas fa-calendar-alt"></i>
            <p>
              Holidays
            </p>
          </a>
        </li>
        @endif

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>
