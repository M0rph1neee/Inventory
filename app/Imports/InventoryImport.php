<?php

namespace App\Imports;

use App\Models\Inventory;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Carbon;

class InventoryImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $buyDate = $this->transformDate($row['buy_date']);

        // Duplicate check for item_name
        $exists = Inventory::where('item_name', $row['item_name'])
            ->where('type', $row['type'])
            ->whereDate('buy_date', $buyDate)
            ->exists();

        if ($exists) {
            return null; // Skip duplicate entries
        }

        return new Inventory([
            // Import Item from Excel
            'item_name' => $row['item_name'],
            'quantity' => $row['quantity'],
            'type' => $row['type'],
            'location' => $row['where'],
            'category' => $row['category'],
            'buy_method' => $row['buy'],
            'buy_date' => $buyDate,
        ]);
    }

    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
            // Convert Excel numeric date to Y-m-d format
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
            }
        return \Carbon\Carbon::parse($value)->format('Y-m-d');
    } catch (\Exception $e) {
        return null;
        }
    }
}
