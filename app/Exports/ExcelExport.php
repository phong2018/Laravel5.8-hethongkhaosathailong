<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExcelExport  implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    
    /*Truyền data từ controller vào để xuất ra*/
    public $sheet_data,$sheet_header,$sheet_col,$baocao2=[];
  
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
                        'bold' => true,
                        'size' => 12,
                    ]
                ]);

                

                $event->sheet->getColumnDimension('B')->setAutoSize(false);
                $event->sheet->getColumnDimension('B')->setWidth(70);
                
               

         
                 
                //--------border cho cell
                $styleArray = [
				    'borders' => [
				        'allBorders' => [
				            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
				            'color' => ['argb' => 'red'],
				        ],
                    ],
                     'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP,
                        

                    ],
				];

				$countrow=count($this->sheet_data);
				for($no=1;$no<=$countrow;$no++){
				    $cellRange = 'A'.($no+1).':'.$this->sheet_col.($no+1); 					
                    $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray($styleArray);
                    $event->sheet->getStyle($cellRange)->getAlignment()->setWrapText(true); 
                }
 

                //-----------merge cho header
                //
                //plg xu ly bao cao mãu 2
                if(count($this->baocao2)>0){
                   $cot=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z', 'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ'];

                   for($i=3;$i<(3+$this->baocao2['socauhoi']*$this->baocao2['sodapan']);$i=$i+$this->baocao2['socauhoi'])
                   $event->sheet->mergeCells($cot[$i].'2:'.$cot[($i+$this->baocao2['socauhoi']-1)].'2');
                    //---------
                    $event->sheet->getStyle('A3:'.$this->sheet_col.'3')->applyFromArray([
 
                        'font' => [
                            'bold' => true,
                            'size' => 12,
                        ]
                    ]);
                }
                //----------
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