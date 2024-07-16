@extends('layouts.admin_layout')

@section('title', 'My Tickets')

@section('content_page')
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1><i class="fas fa-tickets"></i> My Tickets</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
            <li class="breadcrumb-item active">My Tickets</li>
          </ol>
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
              <div class="row">
                <div class="col-sm-12">
                  @php
                    $display = 'block';
                  @endphp
                  <div class="float-sm-left" style="min-width: 200px; display: {{ $display }}">
                    <div class="form-group row">
                      <div class="col">
                        <div class="input-group input-group-sm mb-3">
                          <div class="input-group-prepend w-20">
                            <span class="input-group-text w-100">Status</span>
                          </div>
                          <select class="form-control form-control-sm selFilByStat" name="status">
                            <option value="1" selected="true">Open</option>
                            <option value="2">In Progress</option>
                            <option value="3">For Verification</option>
                            <option value="4">Confirmed</option>
                            <option value="5">Cancelled</option>
                          </select>
                        </div>
                      </div>
                    </div> <!-- .form-group row -->
                  </div> <!-- .float-sm-left -->

                  <div class="float-sm-right">
                    <button class="btn btn-primary btn-sm btnAddTicket"><i class="fa fa-plus"></i> Add New</button>
                  </div> <!-- .float-sm-right -->
                  <br><br>

                  <div class="table-responsive">
                    <table class="table table-sm table-bordered table-hover" id="tblTickets" style="width: 100%;">
                      <thead>
                        <tr>
                          <th>Created At</th>
                          <th>Ticket ID</th>
                          <th>Created At <br>Assigned At <br>Due Date</th>
                          <th>Subject <br><br>Attachment</th>
                          <th>Request</th>
                          <th>CC</th>
                          <th>Status - TRT</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>

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
<!-- /.content-wrapper -->

<!-- MODALS -->
<div class="modal fade" id="mdlSaveTicket">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-info-circle text-info"></i> Ticket Details</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form class="form-horizontal" id="frmSaveTicket">
        @csrf
        <div class="modal-body">
          <div class="card-body">
            <div class="form-group row">
              <label class="col-sm-2 col-form-label">To </label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="ticket_id" placeholder="Ticket ID" style="display: none;">
                <input type="text" class="form-control" name="to" placeholder="servicerequest@pricon.ph" value="servicerequest@pricon.ph" readonly="true">
                <span class="text-danger float-sm-right input-error"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">CC </label>
              <div class="col-sm-10">
                <select class="form-control select2bs4 select2 selAddTicketCC" name="cc[]" placeholder="Type here..." multiple="true"></select>
                <span class="text-danger float-sm-right input-error"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Subject</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" name="subject" placeholder="Subject">
                <span class="text-danger float-sm-right input-error"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Attachment</label>
              <div class="col-sm-10">
                <input type="file" class="form-control" name="attachments" placeholder="Attachment">
                <span class="text-danger float-sm-right input-error"></span>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label">Request</label>
              <div class="col-sm-10">
                <textarea type="text" class="form-control" name="requests" placeholder="Type here..." rows="4"></textarea>
                <span class="text-danger float-sm-right input-error"></span>
              </div>
            </div>

          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary btnSaveTicket">Save</button>
        </div>
      </form>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="mdlViewTicketLogs">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><i class="fa fa-info-circle text-info"></i> Ticket Logs</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
        <div class="modal-body">
          <div class="card-body">
          <div class="table-responsive">
            <input type="text" class="form-control txtTicketLogTicketId" readonly style="display: none;">
            <table class="table table-sm table-bordered table-hover" id="tblTicketLogs" style="width: 100%;">
                <thead>
                <tr>
                    <th>Date Time</th>
                    <th>Description</th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            </div> <!-- .table-responsive -->

            <form class="form-horizontal" id="frmCommentTicket">
                @csrf
                <div class="form-group row">
                    <label class="col-sm-12 col-form-label">Comment </label>
                    <div class="col-sm-6">
                        <input type="text" class="form-control" name="ticket_id" placeholder="Ticket ID" readonly="true" style="display: none;">
                        <textarea class="form-control" name="comment" placeholder="Enter your comment here..." required></textarea>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-primary btnCommentTicket">Send</button>
            </form>

          </div>
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
    </div>
    <!-- /.modal-content -->
  </div>
  <!-- /.modal-dialog -->
</div>

<script type="text/javascript">
  // Variables
  let dtTickets, frmSaveTicket, btnSaveTicket, frmCommentTicket, btnCommentTicket;
</script>

@endsection

@section('js_content')
<!-- Custom Links -->
<script src="{{ asset('public/scripts/client/Ticket.js') }}"></script>

<!-- JS Codes -->
<script type="text/javascript">
  $(document).ready(function () {
    frmSaveTicket = $("#frmSaveTicket");
    btnSaveTicket = $('.btnSaveTicket');

    frmCommentTicket = $("#frmCommentTicket");
    btnCommentTicket = $('.btnCommentTicket');

    bsCustomFileInput.init();
    //Initialize Select2 Elements
    $('.select2').select2();

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    });

    toastr.options = {
      "closeButton": false,
      "debug": false,
      "newestOnTop": true,
      "progressBar": true,
      "positionClass": "toast-top-right",
      "preventDuplicates": false,
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "3000",
      "timeOut": "3000",
      "extendedTimeOut": "3000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut",
    };

    $(document).on('click','#tblTickets tbody tr',function(e){
      $(this).closest('tbody').find('tr').removeClass('table-active');
      $(this).closest('tr').addClass('table-active');
    });

    $.fn.dataTable.ext.errMode = 'none';

    dtTickets = $("#tblTickets").DataTable({
      "processing" : false,
      "serverSide" : true,
      "ajax" : {
        url: "{{ route('view_my_tickets') }}",
        data: function (param){
            param.status = $(".selFilByStat").val();
        }
      },

      "columns":[
        { "data" : "created_at", visible:false },
        { "data" : function(data) {
          return "#" + data.id;
        } },
        { "data" : "raw_created_at" },
        { "data" : "raw_subject" },
        { "data" : "request" },
        { "data" : "raw_cc" },
        { "data" : "raw_status" },
        { "data" : "raw_action", orderable:false, searchable:false }
      ],

      "columnDefs": [
        {
          "targets": [0, 1, 2],
          "data": null,
          "defaultContent": "--"
        },
        // { "visible": false, "targets": 1 }
      ],
      "order": [[ 0, "desc" ]],
      "initComplete": function(settings, json) {

      },
      "drawCallback": function( settings ) {

      }
    }).on( 'error', function () {
      toastr.warning('DataTable not loaded properly. Please reload the page. <br> <button class="pull-right btn btn-danger btn-xs btnReload float-sm-right">Reload</button>');
    });//end of dtTickets

    $(document).on('click', '.btnReload', function(){
      // window.location.reload();
      dtTickets.draw();
    });

    $(".selFilByStat").change(function(e){
      dtTickets.draw();
    });

    $('.selAddTicketCC').select2({
        placeholder: "",
        minimumInputLength: 2,
        allowClear: true,
        ajax: {
           url: "{{ route('get_cbo_rx_user_emails') }}",
           type: "get",
           dataType: 'json',
           delay: 250,
           // quietMillis: 100,
           data: function (params) {
            return {
              search: params.term, // search term
            };
           },
           processResults: function (response) {
             return {
                results: response
             };
           },
           cache: true
        },
    });

    $(".btnAddTicket").click(function(e){
      $("#mdlSaveTicket").modal('show');
      frmSaveTicket[0].reset();
      $('select[name="cc[]"]', frmSaveTicket).val('').change();
      $(".input-error", frmSaveTicket).text('');
      $(".form-control", frmSaveTicket).removeClass('is-invalid');
    });

    $('#mdlSaveTicket').on('shown.bs.modal', function (e) {
      $('input[name="description"]', frmSaveTicket).focus();
    })

    $("#tblTickets").on('click', '.btnActions', function(e){
      let ticketId = $(this).attr('ticket-id');
      let action = $(this).attr('action');
      let status = $(this).attr('status');
      let title = '';

      if(action == 1){
        if(status == 5){
          title = 'Cancel Ticket';
        }
        else if(status == 1){
          title = 'Restore Ticket';
        }
        else if(status == 4){
          title = 'Confirm Ticket';
        }
      }
      // else if(action == 2){
      //   title = 'Reset Password';
      // }

      $.confirm({
        title: title,
        content: 'Please confirm to continue.',
        backgroundDismiss: true,
        type: 'blue',
        buttons: {
          confirm: {
            text: 'Confirm',
            btnClass: 'btn-blue',
            keys: ['enter'],
            action: function(){
              TicketAction(ticketId, action, status);
              cnfrmLoading.open();
            }
          },
          cancel: function () {

          },
        }
      });
    });

    $("#frmSaveTicket").submit(function(e){
      e.preventDefault();
      SaveTicket();
    });

    $("#tblTickets").on('click', '.btnEditTicket', function(e){
      let ticketId = $(this).attr('ticket-id');
      GetTicketById(ticketId);
    });

    $("#tblTickets").on('click', '.btnViewTicketLogs', function(e){
      let ticketId = $(this).attr('ticket-id');
      $(".txtTicketLogTicketId").val(ticketId);
      $('input[name="ticket_id"]', frmCommentTicket).val(ticketId);
      GetTicketLogsById(ticketId);
    });

    $("#frmCommentTicket").submit(function(e){
      e.preventDefault();
      CommentTicket();
    });

  });
</script>
@endsection
