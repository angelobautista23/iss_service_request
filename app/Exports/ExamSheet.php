<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use \Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithDrawings;

class ExamSheet implements FromView, WithTitle, ShouldAutoSize, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    protected $year;
    protected $data;
    protected $sheet_title;

    function __construct($year, $data, $sheet_title)
    {
        $this->year = $year;
        $this->data = $data;
        $this->sheet_title = $sheet_title;
    }

    public function view(): View {
        return view('exports.exam', ['data' => $this->data, 'year' => $this->year]);
        // return view('exports.test');
	}

    public function title(): string
    {
        return $this->sheet_title;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
            	// $event->sheet->setAllBorders('thin');
                // $event->sheet->getDelegate()->getStyle('C1')->getFont()->setSize(30);
                $event->sheet->getDelegate()->getStyle('A1:Z1')->getFont()->setSize(12);
            },
        ];
    }
}
