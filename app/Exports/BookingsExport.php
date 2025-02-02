<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BookingsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data['data']['bookings'] ?? [];
        Log::info('Datos recibidos en BookingsExport:', $this->data);
    }

    public function collection()
    {
        $bookings = collect($this->data);

        $sumTotalMonth = $bookings->sum('totalMonth');

        $bookings->push([
            'date' => 'Total General', 
            'fields' => array_fill(0, count($this->data[0]['fields']), ['field' => '', 'total' => 0]), 
            'totalMonth' => $sumTotalMonth, 
        ]);

        return $bookings;
    }

    public function map($row): array
    {
        $mappedRow = [$row['date']];

        if (isset($row['fields']) && is_array($row['fields'])) {
            foreach ($row['fields'] as $field) {
                $mappedRow[] = $field['total'] ?? 0;
            }
        } else {
            $mappedRow = array_merge($mappedRow, array_fill(0, 4, 0));
        }

        $mappedRow[] = $row['totalMonth'] ?? 0;

        $mappedRow = array_map(function ($value) {
            return $value ?? 0;
        }, $mappedRow);

        return $mappedRow;
    }

    public function headings(): array
    {
        $headings = ['Fecha'];

        if (!empty($this->data)) {
            foreach ($this->data[0]['fields'] as $field) {
                $headings[] = $field['field'];
            }
        }

        $headings[] = 'Total del mes';

        return $headings;
    }
}