<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Bike extends Model
{
    use HasFactory;

    protected $fillable = ['store', 'mac_address', 'reference', 'status', 'available','lng','ltd'];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Deleted'];

    public static function laratablesStatus($record)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($record['status']) . '">' . self::$status[$record['status']] . '</span>';
    }

    public static function laratablesCustomAction($record)
    {
        return '<i onclick="doEdit(' . $record['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $record['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['mac_address', 'reference'];
    }

    public static function laratablesStore($record)
    {
        return (isset($record->storeData)) ? $record->storeData->name  : '<strong class="text-danger">No User Assigned</strong>';
    }

    public function storeData()
    {
        return $this->hasOne(Store::class, 'id', 'store');
    }

    public static function laratablesQueryConditions($query)
    {
        if (Auth::user()->usertype == 1) {
            return $query->whereIn('status', [1,2])->with('storeData');
        } else {
            return $query->whereIn('status', [1, 2])->where('owner', Auth::user()->id)->with('storeData');;
        }
    }
}
