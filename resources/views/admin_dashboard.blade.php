@extends('layouts.admin_layout')

@section('title', 'Dashboard')

@section('content_page')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">

          <h1><i class="fas fa-tachometer-alt"></i> Dashboard</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        @if($_SESSION["sr_admin"] == 1)
        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-primary">
            <div class="inner">
              <br><br>
              <p>Users</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="{{ route('users') }}" class="small-box-footer">
              More info <i class="fas fa-users"></i>
            </a>
          </div>
        </div>

        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-success">
            <div class="inner">
              <br><br>
              <p>Service Types</p>
            </div>
            <div class="icon">
              <i class="fas fa-list"></i>
            </div>
            <a href="{{ route('service_types') }}" class="small-box-footer">
              More info <i class="fas fa-list"></i>
            </a>
          </div>
        </div>
        @endif

        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-purple">
            <div class="inner">
              <br><br>
              <p>My Tickets</p>
            </div>
            <div class="icon">
              <i class="fas fa-ticket-alt"></i>
            </div>
            <a href="{{ route('my_tickets') }}" class="small-box-footer">
              More info <i class="fas fa-ticket-alt"></i>
            </a>
          </div>
        </div>

        @if($_SESSION["sr_admin"] == 1 || $_SESSION["sr_iss_staff"] == 1)
        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-warning">
            <div class="inner">
              <br><br>
              <p>Ticketing</p>
            </div>
            <div class="icon">
              <i class="fas fa-ticket-alt"></i>
            </div>
            <a href="{{ route('ticketing') }}" class="small-box-footer">
              More info <i class="fas fa-ticket-alt"></i>
            </a>
          </div>
        </div>
        @endif

        @if($_SESSION["sr_admin"] == 1)
        <div class="col-lg-3 col-6">
          <!-- small card -->
          <div class="small-box bg-danger">
            <div class="inner">
              <br><br>
              <p>Holidays</p>
            </div>
            <div class="icon">
              <i class="fas fa-calendar"></i>
            </div>
            <a href="{{ route('holidays') }}" class="small-box-footer">
              More info <i class="fas fa-calendar"></i>
            </a>
          </div>
        </div>
        @endif

      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@endsection

@section('js_content')
<script type="text/javascript">
  $(document).ready(function () {
    bsCustomFileInput.init();
  });
</script>
@endsection
