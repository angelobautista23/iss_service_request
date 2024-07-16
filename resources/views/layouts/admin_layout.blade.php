@php
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
    }

    $isAuthorized = false;
    $user_level = 0;
@endphp
@if($isLogin)


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ISS Service Request | @yield('title')</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" type="image/png" href="{{ asset('public/images/favicon.png') }}">

  @include('shared.css_links.css_links')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
  @include('shared.pages.header')

  @include('shared.pages.nav')

  @yield('content_page')

  @include('shared.pages.footer')
</div>

<script type="text/javascript">
    let globalLink = "{{ route('link') }}";
    let _token = "{{ csrf_token() }}";
    let globalPublic = "{!! URL::asset('public/path') !!}";

    console.log(globalPublic);

    let cnfrmLoading;
    let cnfrmAutoLogin;
    let cnfrmLogout;
</script>

@include('shared.js_links.js_links')
@include('shared.pages.common')
@yield('js_content')

<script type="text/javascript">
  // JS Confirm Lazy Loading
  cnfrmLoading = $.dialog({
    lazyOpen: true,
    title: '',
    content: '<i class="fa fa-spinner fa-pulse"></i> Loading...',
    type: 'orange',
    closeIcon: false,
    // autoClose: 'btnAction|8000',
    // backgroundDismiss: true,
  });

  cnfrmAutoLogin = $.confirm({
    lazyOpen: true,
    title: 'Session Expired',
    content: 'Your session is expired, you will be automatically logged out in 10 seconds.',
    type: 'red',
    autoClose: 'logoutUser|10000',
    buttons: {
      logoutUser: {
        text: 'Logout now',
        action: function () {
          window.location = dashboard;
        }
      },
    }
  });

  cnfrmLogout = $.confirm({
    lazyOpen: true,
    title: 'Logout',
    content: 'Please confirm to continue.',
    backgroundDismiss: true,
    type: 'blue',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-blue',
        keys: ['enter'],
        action: function(){
          Logout();
        }
      },
      cancel: function () {

      },
    }
  });
</script>

<!-- MODALS -->
<div class="modal fade" id="modalLogout">
  <div class="modal-dialog">
    <div class="modal-content modal-sm">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-user"></i> Logout</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post" id="formSignOut">
        @csrf
        <div class="modal-body">
          <label>Are you sure to logout?</label>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
          <button type="submit" id="btnSignOut" class="btn btn-primary"><i id="iBtnSignOutIcon" class="fa fa-check"></i> Yes</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<div class="modal fade" id="mdlChangePassword">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-unlock text-info"></i> Change Password</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="frmChangePassword">
        @csrf
        <div class="modal-body">
          <div class="card-body">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Old Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="password" placeholder="Old Password">
                <span class="text-danger float-sm-right input-error"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">New Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="new_password" placeholder="New Password">
                <span class="text-danger float-sm-right input-error"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Confirm Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password">
                <span class="text-danger float-sm-right input-error"></span>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btnChangePass"><i id="iBtnChangePassIcon" class="fa fa-check"></i> Change</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="mdlSelectBranch">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-cube text-info"></i> Select Branch</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="frmSelectBranch">
        @csrf
        <div class="modal-body">
          <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-hover" id="tblBranches" style="width: 100%;">
                  <thead>
                    <tr>
                      <th>Code</th>
                      <th>Description</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>

                  </tbody>
                </table>
              </div> <!-- .table-responsive -->

          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <!-- <button type="submit" class="btn btn-primary btnSelectBranch"><i id="iBtnSelectBranchIcon" class="fa fa-check"></i> Select</button> -->
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">
  let dashboard = globalLink.replace('link', 'dashboard');
  let dtBranches;

  // JS Confirm Lazy Loading
  cnfrmLoading = $.dialog({
    lazyOpen: true,
    title: '',
    content: '<i class="fa fa-spinner fa-pulse"></i> Loading...',
    type: 'orange',
    closeIcon: false,
    // autoClose: 'btnAction|8000',
    // backgroundDismiss: true,
  });

  cnfrmAutoLogin = $.confirm({
    lazyOpen: true,
    title: 'Session Expired',
    content: 'Your session is expired, you will be automatically logged out in 10 seconds.',
    type: 'red',
    autoClose: 'logoutUser|10000',
    buttons: {
      logoutUser: {
        text: 'Logout now',
        action: function () {
          window.location = dashboard;
        }
      },
    }
  });

  cnfrmLogout = $.confirm({
    lazyOpen: true,
    title: 'Logout',
    content: 'Please confirm to continue.',
    backgroundDismiss: true,
    type: 'blue',
    buttons: {
      confirm: {
        text: 'Confirm',
        btnClass: 'btn-blue',
        keys: ['enter'],
        action: function(){
          Logout();
        }
      },
      cancel: function () {

      },
    }
  });

  // FUNCTIONS
  function Logout(){
    let url = globalLink.replace('link', 'logout');
    let urlLogin = globalLink.replace('link', 'dashboard');
    $.ajax({
        url: url,
        method: 'get',
        data: {
            _token: _token,
        },
        dataType: 'json',
        beforeSend() {
            cnfrmLoading.open();
        },
        success(data){
            cnfrmLoading.close();

            if(data['result'] == 1){
                window.location = urlLogin;
            }
            else{
                toastr.error('Logout Failed');
            }
        },
        error(xhr, data, status){
            cnfrmLoading.close();
            toastr.error('Logout Failed');
        }
    });
  }



  $(document).ready(function(){
    // ACTIONS
    $("#aLogout").click(function(){
      cnfrmLogout.open();
    });

    $("#aChangePass").click(function(){
      $("#mdlChangePassword").modal('show');
      $("#frmChangePassword")[0].reset();
    });

    $(".aSelectBranch").click(function(){
      $("#mdlSelectBranch").modal('show');
      dtBranches.draw();
    });

    $("#formSignOut").submit(function(e){
      e.preventDefault();
      SignOut();
    });

    $(document).on('click','#tblBranches tbody tr',function(e){
      $(this).closest('tbody').find('tr').removeClass('table-active');
      $(this).closest('tr').addClass('table-active');
    });

    $.fn.dataTable.ext.errMode = 'none';

    $("#tblBranches").on('click', '.btnRowSelectBranch', function(e){
      let branchId = $(this).attr('branch-id');
      let title = '';

      $.confirm({
        title: 'Select Branch',
        content: 'Please confirm to continue.',
        backgroundDismiss: true,
        type: 'blue',
        buttons: {
          confirm: {
            text: 'Confirm',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function(){
              SelectBranch(branchId);
              cnfrmLoading.open();
            }
          },
          cancel: function () {

          },
        }
      });
    });

    function SelectBranch(branchId){
      let url = globalLink.replace('link', 'select_branch');
      let login = globalLink.replace('link', 'login');

      $.ajax({
          url: url,
          method: 'post',
          data: {
            branch_id: branchId,
            _token: _token,
          },
          dataType: 'json',
          beforeSend() {
              cnfrmLoading.open();
          },
          success(data){
              cnfrmLoading.close();

              if(data['auth'] == 1){
                  if(data['result'] == 1){
                    toastr.success('Branch Selected Successfully!');
                    location.reload();
                  }
                  else{
                    toastr.error('Branch Selection Failed!');
                  }
              }
              else{ // if session expired
                  cnfrmAutoLogin.open();
              }
          },
          error(xhr, data, status){
              cnfrmLoading.close();
              toastr.success('Branch Selection Failed!');
          }
      });
    }

    $("#frmChangePassword").submit(function(e){
      e.preventDefault();
      let url = globalLink.replace('link', 'change_password');
      let login = globalLink.replace('link', 'login');

      $.ajax({
          url: url,
          method: 'post',
          data: $("#frmChangePassword").serialize(),
          dataType: 'json',
          beforeSend() {
              $(".btnChangePass").prop('disabled', true);
              $(".btnChangePass").html('Updating...');
              $(".input-error", $("#frmChangePassword")).text('');
              $(".form-control", $("#frmChangePassword")).removeClass('is-invalid');
              cnfrmLoading.open();
          },
          success(data){
              $(".btnChangePass").prop('disabled', false);
              $(".btnChangePass").html('Change');
              cnfrmLoading.close();
              $("input[name='name']", $("#frmChangePassword")).focus();

              if(data['auth'] == 1){
                  if(data['result'] == 1){
                    toastr.success('Password Changed!');
                    $("#frmChangePassword")[0].reset();
                    $(".input-error", $("#frmChangePassword")).text('');
                    $(".form-control", $("#frmChangePassword")).removeClass('is-invalid');
                  }
                  else{
                      if(data['error'] != null){
                          if(data['error']['password'] != null){
                              $("input[name='password']", $("#frmChangePassword")).addClass('is-invalid');
                              $("input[name='password']", $("#frmChangePassword")).siblings('.input-error').text(data['error']['password']);
                          }
                          else{
                              $("input[name='password']", $("#frmChangePassword")).removeClass('is-invalid');
                              $("input[name='password']", $("#frmChangePassword")).siblings('.input-error').text('');
                          }

                          if(data['error']['new_password'] != null){
                              $("input[name='new_password']", $("#frmChangePassword")).addClass('is-invalid');
                              $("input[name='new_password']", $("#frmChangePassword")).siblings('.input-error').text(data['error']['new_password']);
                          }
                          else{
                              $("input[name='new_password']", $("#frmChangePassword")).removeClass('is-invalid');
                              $("input[name='new_password']", $("#frmChangePassword")).siblings('.input-error').text('');
                          }

                          if(data['error']['confirm_password'] != null){
                              $("input[name='confirm_password']", $("#frmChangePassword")).addClass('is-invalid');
                              $("input[name='confirm_password']", $("#frmChangePassword")).siblings('.input-error').text(data['error']['confirm_password']);
                          }
                          else{
                              $("input[name='confirm_password']", $("#frmChangePassword")).removeClass('is-invalid');
                              $("input[name='confirm_password']", $("#frmChangePassword")).siblings('.input-error').text('');
                          }
                      }

                      if(data['login_success'] == 0){
                        toastr.error('Password not matched!');
                        $("input[name='password']", $("#frmChangePassword")).addClass('is-invalid');
                        $("input[name='password']", $("#frmChangePassword")).siblings('.input-error').text('Password not matched.');
                      }
                  }
              }
              else{ // if session expired
                  cnfrmAutoLogin.open();
              }
          },
          error(xhr, data, status){
              cnfrmLoading.close();
              $(".btnChangePass").prop('disabled', false);
              $(".btnChangePass").html('Change');
              toastr.error('Updating Failed!');
          }
      });
    });

    $("body").css({"overflow-y" : "auto"});
    $(document).on("hidden.bs.modal", function () {
        $("body").addClass("modal-open");
        $("body").css({"overflow-y" : "auto"});
    });
    $(document).on("show.bs.modal", function () {
        $("body").css({"overflow-y" : "hidden"});
    });

  });
</script>

</body>
</html>
@else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endauth
