<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sheet extends Model
{
    use HasFactory;

    protected $appends = ['location_string'];

    public static function fetchSheetsByGrid()
    {
        $ordered_sheets = static::orderBy('row', 'asc')
            ->orderBy('column', 'asc')
            ->get();

        $sheets_by_grid = [];
        foreach ($ordered_sheets as $sheet) {
            $sheets_by_grid[$sheet->row][$sheet->column] = $sheet;
        }

        return $sheets_by_grid;
    }

    public function getLocationStringAttribute()
    {
        return $this->row."-".$this->column;
    }

    public function getFormattedLocationString($format = 'a-1')
    {
        $formatted = '';

        foreach(str_split($format) as $char){
            if($char === 'a'){
                $formatted .= $this->row;
            }elseif($char === '1'){
                $formatted .= $this->column;
            }elseif($char === 'A'){
                $formatted .= strtoupper($this->row);
            }else{
                $formatted .= $char; 
            }
        }

        return $formatted;
    }
}
