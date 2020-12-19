<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class TestExport  implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    
    /*Truyền data từ controller vào để xuất ra*/
    public $sheet_data,$sheet_header,$sheet_col;
  
    //--------
    public function collection()
    {
        return $this->sheet_data;
    }
    ///--------
    public function headings(): array
    {
        return $this->sheet_header;
    }
    //----------
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
            	//-------size cho header
                $cellRange = 'A1:'.$this->sheet_col.'2';  
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);
                //--------font-bold cho header
                $event->sheet->getStyle('A1:'.$this->sheet_col.'2')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
                //--------border cho cell
                $styleArray = [
				    'borders' => [
				        'allBorders' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				            'color' => ['argb' => 'red'],
				        ],
				    ],
				];

				$countrow=count($this->sheet_data);
				for($no=1;$no<=$countrow+1;$no++){
				    $cellRange = 'A'.($no+1).':'.$this->sheet_col.($no+1); 					
				    $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
				}
                //-----------merge cho header
                $event->sheet->mergeCells('A1:'.$this->sheet_col.'1');
            },
        ];
    }

}

/*
$styleArray = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
    'borders' => [
        'top' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
    'fill' => [
        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_GRADIENT_LINEAR,
        'rotation' => 90,
        'startColor' => [
            'argb' => 'FFA0A0A0',
        ],
        'endColor' => [
            'argb' => 'FFFFFFFF',
        ],
    ],
];

 return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
*/