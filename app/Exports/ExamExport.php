<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
Use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\ExamSheet;

class ExamExport implements ShouldAutoSize, WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $year;
	protected $data;

    function __construct($year, $data)
    {
        $this->year = $year;
		$this->data = $data;
    }

    //for multiple sheets
    public function sheets(): array
    {
        $sheets = [];

    	$sheets[] = new ExamSheet($this->year, $this->data, 'EXAMS - ' . $this->year);
    	
        return $sheets;
    }
}
