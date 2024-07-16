@php
	$summary_data = json_decode($summary);
	$sec1Ctr = 0;
	$sec2Ctr = 0;
	$sec3Ctr = 0;

	for($index = 0; $index < count($summary_data->questions); $index++) {
		if($summary_data->questions[$index]->section == 1) {
			$sec1Ctr++;
		}
		else if($summary_data->questions[$index]->section == 2) {
			$sec2Ctr++;
		}
		else if($summary_data->questions[$index]->section == 3) {
			$sec3Ctr++;
		}
	}
@endphp
<!DOCTYPE html>
<html>
<head>
    <title>({{ $employee_no }}) {{ $lastname }}, {{ $firstname }}, {{ $middlename }}</title>
    <style type="text/css">
    	body {
    		font-family: Arial;
    		font-size: 18px;
    	}
    	td.span {
    		font-size: 18px;
    	}
    	.divCards {
    		margin-bottom: 10px;
    	}
    	table {
    		page-break-before:auto;
    	}
    </style>
</head>
<body>
	<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
    	<p style="font-size: 40px !important; margin: 10px 10px !important;">ISS Service Request - {{ $summary_data->position_desc }}</p>
	</div>
    <div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
    	<p style="margin: 10px 10px !important;">{{ $summary_data->position_remarks }}</p>
	</div>
	<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
    	<p style="margin: 10px 10px !important;">Full Name (Surname, First Name, Middle Name)</p>
    	<p style="margin: 10px 10px !important;"><u>{{ $lastname }}, {{ $firstname }}, {{ $middlename }}</u></p>
	</div>
	<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
    	<p style="margin: 10px 10px !important;">Date hired</p>
    	<p style="margin: 10px 10px !important;"><u>{{ $date_hired }}</u></p>
	</div>
	<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
    	<p style="margin: 10px 10px !important;">Employee Number</p>
    	<p style="margin: 10px 10px !important;"><u>{{ $employee_no }}</u></p>
	</div>
	<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
    	<p style="margin: 10px 10px !important;">Immediate Superior</p>
    	<p style="margin: 10px 10px !important;"><u>{{ $immediate_superior }}</u></p>
	</div>
	<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
    	<p style="margin: 10px 10px !important;">Organization</p>
    	<p style="margin: 10px 10px !important;"><u>{{ $agency }}</u></p>
	</div>

	@if($sec1Ctr > 0)
		<br>
		<p style="margin: 10px 10px !important;">GENERAL KNOWLEDGE</p>
		<table width="100%" border="0">
			@for($index = 0; $index < count($summary_data->questions); $index++)
				@if($summary_data->questions[$index]->section == 1)
					<tr>
						<td>
							<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
								<table width="100%" border="0">
									<tr>
										<td width="90%">
											<p style="margin: 10px 10px !important;">{{ $summary_data->questions[$index]->description }}</p>
										</td>
										<td width="10%" style="float: right; text-align: right; font-size: 12px;">{{ $summary_data->questions[$index]->points }} point(s)</td>
									</tr>
									<tr>
										@php
											$choices = json_decode($summary_data->questions[$index]->choices);
										@endphp

										<td colspan="2">
											@if($summary_data->questions[$index]->image != null)
												<img src="{{url('/public/storage/question_images/')}}/{{ $summary_data->questions[$index]->image }}" style="max-height: 100px; max-height: 100px; margin: 10px 10px;"><br>
											@endif

											@for($index2 = 0; $index2 < count($choices); $index2++)
												@php
													$checked = "";
													if($index2 == $summary_data->questions[$index]->user_answer) {
														$checked = "checked";
													}
												@endphp
												<input type="radio" name="rdo_choice_{{$summary_data->questions[$index]->id}}" {{ $checked }} /> <span>{{ $choices[$index2]->choice}}</span> <br>
											@endfor
										</td>
									</tr>
								</table>
					    	
							</div>
						</td>
					</tr>
				@endif
			@endfor
		</table>
	@endif

	@if($sec2Ctr > 0)
		<br>
		<p style="margin: 10px 10px !important;">HEALTH AND SAFETY</p>
		<table width="100%" border="0">
			@for($index = 0; $index < count($summary_data->questions); $index++)
				@if($summary_data->questions[$index]->section == 2)
					<tr>
						<td>
							<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
								<table width="100%" border="0">
									<tr>
										<td width="90%">
											<p style="margin: 10px 10px !important;">{{ $summary_data->questions[$index]->description }}</p>
										</td>
										<td width="10%" style="float: right; text-align: right; font-size: 12px;">{{ $summary_data->questions[$index]->points }} point(s)</td>
									</tr>
									<tr>
										@php
											$choices = json_decode($summary_data->questions[$index]->choices);
										@endphp

										<td colspan="2">
											@if($summary_data->questions[$index]->image != null)
												<img src="{{url('/public/storage/question_images/')}}/{{ $summary_data->questions[$index]->image }}" style="max-height: 100px; max-height: 100px; margin: 10px 10px;"><br>
											@endif

											@for($index2 = 0; $index2 < count($choices); $index2++)
												@php
													$checked = "";
													if($index2 == $summary_data->questions[$index]->user_answer) {
														$checked = "checked";
													}
												@endphp
												<input type="radio" name="rdo_choice_{{$summary_data->questions[$index]->id}}" {{ $checked }} /> <span>{{ $choices[$index2]->choice}}</span> <br>
											@endfor
										</td>
									</tr>
								</table>
					    	
							</div>
						</td>
					</tr>
				@endif
			@endfor
		</table>
	@endif

	@if($sec3Ctr > 0)
		<br>
		<p style="margin: 10px 10px !important;">TECHNICAL EXAM</p>
		<table width="100%" border="0">
			@for($index = 0; $index < count($summary_data->questions); $index++)
				@if($summary_data->questions[$index]->section == 3)
					<tr>
						<td>
							<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
								<table width="100%" border="0">
									<tr>
										<td width="90%">
											<p style="margin: 10px 10px !important;">{{ $summary_data->questions[$index]->description }}</p>
										</td>
										<td width="10%" style="float: right; text-align: right; font-size: 12px;">{{ $summary_data->questions[$index]->points }} point(s)</td>
									</tr>
									<tr>
										@php
											$choices = json_decode($summary_data->questions[$index]->choices);
										@endphp

										<td colspan="2">
											@if($summary_data->questions[$index]->image != null)
												<img src="{{url('/public/storage/question_images/')}}/{{ $summary_data->questions[$index]->image }}" style="max-height: 100px; max-height: 100px; margin: 10px 10px;"><br>
											@endif

											@for($index2 = 0; $index2 < count($choices); $index2++)
												@php
													$checked = "";
													if($index2 == $summary_data->questions[$index]->user_answer) {
														$checked = "checked";
													}
												@endphp
												<input type="radio" name="rdo_choice_{{$summary_data->questions[$index]->id}}" {{ $checked }} /> <span>{{ $choices[$index2]->choice}}</span> <br>
											@endfor
										</td>
									</tr>
								</table>
					    	
							</div>
						</td>
					</tr>
				@endif
			@endfor
		</table>
	@endif

	<br><br>
	<div class="divCards" style="width: 100%; border-radius: 5px; border: 1px solid gray; padding: 5px;">
    	<p style="margin: 10px 10px !important;">RESULT</p>
		@php

			$percentage = ($total_correct/$total_points) * 100
		@endphp
    	<p style="margin: 10px 10px !important;"><u>{{ $total_correct }}/{{ $total_points }} = ({{ number_format((float)$percentage) }}%)</u></p>
		@if($passed == 1)
    		<p style="margin: 10px 10px !important; color: green;"><u>Passed</u></p>
    	@else
    		<p style="margin: 10px 10px !important; color: red;"><u>Failed</u></p>
    	@endif
	</div>
</body>
</html>