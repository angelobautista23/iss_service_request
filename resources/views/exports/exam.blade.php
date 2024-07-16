<table>
	<tr>
      <th rowspan="2"><b>#</b></th>
      <th rowspan="2"><b>E.N</b></th>
      <th rowspan="2"><b>Employee Name</b></th>
      <th rowspan="2"><b>Position</b></th>
      <th rowspan="2"><b>Section</b></th>
      <th rowspan="2"><b>Date of Exam</b></th>
      <th colspan="2"><b>Exam Result</b></th>
      <th rowspan="2"><b>Immediate Superior</b></th>
      <th rowspan="2"><b>Remarks</b></th>
    </tr>
    <tr>
      <th><b>Score</b></th>
      <th><b>%</b></th>
    </tr>
	@for($index = 0; $index < count($data); $index++){
		<tr>
			<td>{{ $index + 1 }}</td>
			<td>{{ $data[$index]->employee_no }}</td>
			<td>{{ $data[$index]->lastname }}, {{ $data[$index]->firstname }} {{ $data[$index]->middlename }}</td>
			<td>{{ $data[$index]->p_description }}</td>
			<td>{{ $data[$index]->section }}</td>
			<td>{{ \Carbon\Carbon::parse($data[$index]->created_at)->format('d.m.Y') }}</td>
			<td>{{ $data[$index]->total_correct }}</td>
			@php
				$percentage = 0;
				if($data[$index]->total_correct > 0) {
					$percentage = number_format((float)($data[$index]->total_correct / $data[$index]->total_points * 100));
				}

				if($data[$index]->passed == 1){
                	if($data[$index]->take > 1) {
                		$remarks = "Passed Retake (" . $data[$index]->take . ")";
                	}
                	else{
                    	$remarks = "Passed";
                	}
                }
                else if($data[$index]->passed == 0){
                	if($data[$index]->take > 1) {
                    	$remarks = "Failed (" . $data[$index]->take . ")";
                    }
                    else{
                    	$remarks = "Failed";
                    }
                }
			@endphp
			<td>{{ $percentage }}%</td>
			<td>{{ $data[$index]->immediate_superior }}</td>
			<td>{{ $remarks }}</td>
		</tr>
	@endfor
</table>