<?php

namespace App\Exports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class InventoryExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Inventory::all(['item_name', 'quantity', 'type', 'location', 'category', 'buy_method', 'buy_date']);
    }

    public function headings(): array
    {
        return [
            'Item Name',
            'Quantity',
            'Type',
            'Location',
            'Category',
            'Buy Method',
            'Buy Date'
        ];
    }
}
