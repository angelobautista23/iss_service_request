<!DOCTYPE html>
<html>
<head>
	<title>ISS Service Request</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<!-- <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"> -->
	<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous"> -->

	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('public/template/plugins/fontawesome-free/css/all.min.css') }}">
	<!-- Ionicons -->
	<!-- <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css"> -->
	<!-- Google Font: Source Sans Pro -->
	<!-- <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> -->
	<!-- DataTables -->
	<link rel="stylesheet" href="{{ asset('public/template/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
	<!-- Tempusdominus Bbootstrap 4 -->
	<link rel="stylesheet" href="{{ asset('public/template/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

	<!-- Select2 -->
	<link rel="stylesheet" href="{{ asset('public/template/plugins/select2/css/select2.min.css') }}">

	<link rel="stylesheet" href="{{ asset('public/template/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

	<!-- Theme style -->
	<link rel="stylesheet" href="{{ asset('public/template/dist/css/adminlte.min.css') }}">

	<!-- SweetAlert2 -->
	<link rel="stylesheet" href="{{ asset('public/template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
	<!-- Toastr -->
	<link rel="stylesheet" href="{{ asset('public/template/plugins/toastr/toastr.min.css') }}">
	<!-- Confirm -->
	<link rel="stylesheet" href="{{ asset('public/template/plugins/jquery-confirm/jquery-confirm.min.css') }}" />

	<!-- <link rel="stylesheet" href="{{ asset('public/bootstrap-modal-ios/bootstrap-modal-ios.css') }}"> -->

	<!-- <link rel="stylesheet" type="text/css" href="{{ asset('public/css/toastr.min.css') }}"> -->
	<!-- <meta http-equiv="Content-Type" content="text/html;charset=UTF-8"> -->
</head>
<body style="background: url('{!! URL::asset('public/images/BG.jpg') !!}'); background-size: cover; background-repeat: no-repeat;">

	<div class="container">
		<div class="container-fluid">
			<center>
				<br><br><br><br><br><br>
				<div class="card" style="width: 500px; border-radius: 20px;">
				  	<div class="card-body">
				  		<img src="{{ asset('public/images/check-icon.png') }}" style="max-width: 100px;">
				  		<br><br>
				    	<h4 class="text-center"><b>SUBMISSION CONFIRMED!</b></h4>
				    	<label style="font-size: 20px;">Thank you for answering the PMI Recall Exam.</label style="font-size: 20px;">
			    		<br><br>
			    		@if($exam_info != null)
				    		@php

				    			$percentage = ($exam_info->total_correct/$exam_info->total_points) * 100
				    		@endphp
					    	<label style="font-size: 20px;">{{ $exam_info->total_correct }}/{{ $exam_info->total_points }} = ({{ number_format((float)$percentage) }}%)</label style="font-size: 20px;">
				    		<br>
				    		@if($exam_info->passed == 1)
					    		<label style="font-size: 20px; color: green;">Passed</label style="font-size: 20px;">
					    	@else
					    		<label style="font-size: 20px; color: red;">Failed</label style="font-size: 20px;">
					    	@endif
					   	@else
					   		<label style="font-size: 20px; color: red;">No data found.</label style="font-size: 20px;">
					    @endif
			    		<br><br>
				    	<a href="{{ route('exam') }}" class="btn btn-primary">GO BACK</a>	
				  	</div>
				</div>
			</center>
		</div>
	</div>

	<script src="{{ asset('public/template/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
	<script src="{{ asset('public/template/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

	<!-- SweetAlert2 -->
	<script src="{{ asset('public/template/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
	<!-- Toastr -->
	<script src="{{ asset('public/template/plugins/toastr/toastr.min.js') }}"></script>
	<script type="text/javascript">
		let mins = 15;
		let idleLimit = mins * 60;
		let timer = idleLimit;

		setInterval(function(){ 
			timer--;
			// console.log(timer);
			if(timer <= 0){
				window.location = 'http://192.168.3.188/recall_exam/exam';
			}
		}, 1000);

		$(function(){
			$(document).mousemove(function(event){
			  	timer = idleLimit;
			});

			$(document).keyup(function(event){
			  	timer = idleLimit;
			});
		});
	</script>
</body>
</html>