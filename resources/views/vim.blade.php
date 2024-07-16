<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>ISS Service Request | VIM</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  @include('shared.css_links.css_links')
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-tickets"></i> Open Tickets</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <!-- Start Page Content -->
            <div class="card-body">

                  <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-sm table-bordered table-hover" id="tblOpenTickets" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Ticket ID</th>
                          <th>Request</th>
                          <th>Requestor</th>
                          <th>Created At</th>
                          <th>CC</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td colspan="5">No record found.</td>
                        </tr>
                      </tbody>
                    </table>
                  </div> <!-- .table-responsive -->
                </div> <!-- .col-sm-12 -->
              </div> <!-- .row -->
            </div>
            <!-- !-- End Page Content -->

          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-tickets"></i> In Progress Tickets</h1>
        </div>
      </div>
    </div><!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-12">
          <!-- general form elements -->
          <div class="card card-primary">
            <!-- Start Page Content -->
            <div class="card-body">

                  <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-sm table-bordered table-hover" id="tblInProgressTickets" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Ticket ID</th>
                          <th>Request</th>
                          <th>Requestor</th>
                          <th>Assignee</th>
                          <th>TRT</th>
                          <th>Due Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                            <td colspan="6">No record found.</td>
                        </tr>
                      </tbody>
                    </table>
                  </div> <!-- .table-responsive -->
                </div> <!-- .col-sm-12 -->
              </div> <!-- .row -->
            </div>
            <!-- !-- End Page Content -->

          </div>
          <!-- /.card -->
        </div>
      </div>
      <!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>
  <!-- /.content -->

</div>

<script src="{{ asset('public/template/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('public/template/plugins/moment/moment.min.js') }}"></script>

<script type="text/javascript">
    let globalLink = "{{ route('link') }}";
    let _token = "{{ csrf_token() }}";
    let globalPublic = "{!! URL::asset('public/path') !!}";

    console.log(globalPublic);

    let cnfrmLoading;
    let cnfrmAutoLogin;
    let cnfrmLogout;

  // FUNCTIONS
  function ViewOpenTickets(){
    let url = globalLink.replace('link', 'view_open_tickets');
    $.ajax({
        url: url,
        method: 'get',
        data: {
        },
        dataType: 'json',
        beforeSend() {
        },
        success(data){
            if(data['auth'] == 1){
                if(data['data'].length > 0){
                    let result = "";
                    for(let index = 0; index < data['data'].length; index ++) {
                        result += '<tr ';
                        if(data['data'][index]['time_diff'] > 900) {
                            result += 'style="background-color: #8637ed;"';
                        }
                        result += '>';
                        result += '<td>#' + data['data'][index]['id'] + '</td>';
                        result += '<td>#' + data['data'][index]['request'] + '</td>';
                        result += '<td>' + data['data'][index]['requestor_info']['name'] + '</td>';
                        result += '<td>' + moment(data['data'][index]['created_at']).format('MMMM DD, YYYY hh:mm:ss A') + '</td>';
                        result += '<td>' + data['data'][index]['cc'] + '</td>';
                        result += '</tr>';
                    }

                    $("#tblOpenTickets tbody").html(result);
                }
                else{
                    $("#tblOpenTickets tbody").html('<tr><td colspan="5">No record found.</td></tr>');
                }
            }
            else{ // if session expired
            }
        },
        error(xhr, data, status){
        }
    });
  }

  function ViewInProgressTickets(){
    let url = globalLink.replace('link', 'view_in_progress_tickets');
    $.ajax({
        url: url,
        method: 'get',
        data: {
        },
        dataType: 'json',
        beforeSend() {
        },
        success(data){
            if(data['auth'] == 1){
                if(data['data'].length > 0){
                    let result = "";
                    for(let index = 0; index < data['data'].length; index ++) {
                        result += '<tr ';
                        if(data['data'][index]['time_diff'] <= 0) {
                            result += 'style="background-color: #f26d63;"';
                        }
                        result += '>';
                        result += '<td>#' + data['data'][index]['id'] + '</td>';
                        result += '<td>#' + data['data'][index]['request'] + '</td>';
                        result += '<td>' + data['data'][index]['requestor_info']['name'] + '</td>';
                        result += '<td>' + data['data'][index]['second_assignee_info']['name'] + '</td>';
                        result += '<td>';
                        let strTRT = data['data'][index]['trt'];
                        switch(strTRT) {
                            case 0.4:
                              strTRT = "E4";
                              break;
                            case 1:
                              strTRT = "R1";
                              break;
                            case 2:
                              strTRT = "R2";
                              break;
                            case 3:
                              strTRT = "R3";
                              break;
                            case 4:
                              strTRT = "R4";
                              break;
                            case 5:
                              strTRT = "R5";
                              break;
                            default:
                              strTRT = ""
                              break;
                        }
                        result += strTRT;
                        result += '</td>';
                        result += '<td>' + moment(data['data'][index]['due_date']).format('MMMM DD, YYYY hh:mm:ss A') + '</td>';
                        result += '</tr>';
                    }

                    $("#tblInProgressTickets tbody").html(result);
                }
                else{
                    $("#tblInProgressTickets tbody").html('<tr><td colspan="5">No record found.</td></tr>');
                }
            }
            else{ // if session expired
            }
        },
        error(xhr, data, status){
        }
    });
  }


  $(document).ready(function(){
    // ACTIONS
    ViewOpenTickets();
    ViewInProgressTickets();

    setInterval(ViewOpenTickets, 60000);
    setInterval(ViewInProgressTickets, 60000);
  });
</script>

</body>
</html>
