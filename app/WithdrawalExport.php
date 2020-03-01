<?php

namespace App;

use App\Withdrawal;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class WithdrawalExport implements FromCollection, WithHeadings, WithEvents
{   
    use Exportable;

    public function headings(): array
    {
        return [
            '#',
            'USER ID',
            'USERNAME',
            'AMOUNT',
            'NAME',
            'MOBILE',
            'ADDRESS',
            'DATE REQUESTED',

        ];
    }

    public function __construct(string $remittance, int $total)
    {
        $this->remittance = $remittance;
        $this->total = $total + 2;
    }

    public function registerEvents(): array
    {
        return [
            BeforeExport::class  => function(BeforeExport $event) {
                $event->writer->setCreator('Leonard Biano');
                $event->writer->setTitle('Remittance Payout - '.$this->remittance);

            },
            AfterSheet::class    => function(AfterSheet $event) {
            	$event->sheet->getDelegate()->getStyle('A1:G'.$this->total)->applyFromArray(
			         [
			             'font' => [
			                 'name' => 'Arial',
			                 'bold' => false,
			                 'italic' => false,
			                 'size' => 10
			             ],
			             'borders' => [
						        'allBorders' => [
						            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
						            'color' => ['argb' => 'FF000000'],
						        ],
						    ],
			             'alignment' => [
			                 'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			                 'vertical' =>\PhpOffice\PhpSpreadsheet\Style\ Alignment::VERTICAL_CENTER,
			                 'wrapText' => true,
			             ],
			             'quotePrefix'    => true,
			         ]
			     );
            	$event->sheet->getDelegate()->getColumnDimension('A')->setWidth(5);
            	$event->sheet->getDelegate()->getColumnDimension('B')->setWidth(30);
            	$event->sheet->getDelegate()->getColumnDimension('C')->setWidth(20);
            	$event->sheet->getDelegate()->getColumnDimension('D')->setWidth(35);
            	$event->sheet->getDelegate()->getColumnDimension('E')->setWidth(30);
            	$event->sheet->getDelegate()->getColumnDimension('F')->setWidth(50);
            	$event->sheet->getDelegate()->getColumnDimension('G')->setWidth(20);
                $event->sheet->getDelegate()->getStyle('A1:W1')->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A1:W1')->getFont()->setBold('bold');
                $event->sheet->getDelegate()->getStyle('A1:G'.$this->total)->getAlignment()->setHorizontal('center');
                $event->sheet->getDelegate()->getStyle('A1:G'.$this->total)->getAlignment()->setWrapText(true);

                $event->sheet->getDelegate()->getStyle('A'.$this->total.':G'.$this->total)->getFont()->setSize(12);
                $event->sheet->getDelegate()->getStyle('A'.$this->total.':G'.$this->total)->getFont()->setBold('bold');
                $event->sheet->getDelegate()->getCell('B'.$this->total)->setValue('TOTAL AMOUNT');
                $event->sheet->getDelegate()->getCell('C'.$this->total)->setValue('=SUM(C2:C54)');


                

 
            },
        ];
    }

    public function collection()
    {
    	$withdrawals = Withdrawal::with('user')->where('mode','REMITTANCE')->where('status','PENDING')->where('details', 'LIKE', '%'. $this->remittance .'%')->orderBy('created_at','desc')->get();

        $withdrawal_data = [];

        foreach ($withdrawals as $key => $value) {

            $details = preg_split('/<br>/i', $value->details);
            
            $data = [
                'no' => $key+1,
                'user_id' => $value->user_id,
                'username' => $value->user_username,
                'amount' => $value->amount - (( 10 / 100 ) * $value->amount ) - 100,
                'name' => str_replace('NAME: ','',$details[0]),
                'mobile' => str_replace('MOBILE: ','',$details[1]),
                'address' => str_replace('ADDRESS: ','',$details[2]),
                'date' => date("F j, Y",strtotime($value->created_at))
            ];

            array_push($withdrawal_data, $data);
        }

        return collect($withdrawal_data);


        // return Withdrawal::query()->select('user_id','user_username', 'amount', 'details')->where('mode','REMITTANCE')->where('status','PENDING')->where('details', 'LIKE', '%'. $this->remittance .'%');
    }
}