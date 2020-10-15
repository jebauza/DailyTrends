<?php

namespace App\Exports;

use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class PeopleExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents
{
    use Exportable;

    private $peopleCollection;

    public function __construct($peopleCollection)
    {
        $this->peopleCollection = $peopleCollection;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->peopleCollection;
    }

    public function headings(): array
    {
        return [
            'Nombre',
            'Especialidades',
            'Dirección'
        ];
    }

    /**
     * @param mixed $row
     *
     * @return array
     */
    public function map($row): array
    {
        return [
            $row['name'],
            $row['specialties'],
            $row['address']
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                //$event->sheet->getStyle()
                $cellRange = 'A1:W1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setBold(true);
                                /* ->setSize(16) */
                                /* ->getColor()->setRGB('0000ff') */

            },
        ];
    }


}
