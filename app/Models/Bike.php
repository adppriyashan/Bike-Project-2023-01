<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Bike extends Model
{
    use HasFactory;

    protected $fillable = ['store', 'mac_address', 'reference', 'status', 'available', 'lng', 'ltd', 'locked', 'intensity', 'temperature', 'humidity', 'air_quality', 'rainy', 'waterlevel'];

    public static $status = [1 => 'Active', 2 => 'Inactive', 3 => 'Deleted'];
    public static $rainy = ['Not Rainy', 'Rainy'];
    public static $waterlevel = ['Flood Not Detected', 'Flood Detected'];

    public static function laratablesStatus($record)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($record['status']) . '">' . self::$status[$record['status']] . '</span>';
    }

    public static function laratablesRainy($record)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($record['rainy'] + 1) . '">' . self::$rainy[$record['rainy']] . '</span>';
    }

    public static function laratablesWaterlevel($record)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($record['waterlevel'] + 1) . '">' . self::$waterlevel[$record['waterlevel']] . '</span>';
    }

    public static function laratablesAdditionalColumns()
    {
        return ['ltd', 'lng'];
    }

    public static function laratablesCustomAction($record)
    {
        return '<a target="_blank" href="https://www.google.com/maps/search/?api=1&query=' . $record['ltd'] . ',' . $record['lng'] . '"><i class="la la-map text-primary"></i></a><i onclick="doEdit(' . $record['id'] . ')" class="la la-edit ml-1 text-warning"></i><i onclick="doDelete(' . $record['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
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
            return $query->whereIn('status', [1, 2])->with('storeData');
        } else {
            return $query->whereIn('status', [1, 2])->wherein('store',  Store::where('status', 1)->where('owner', Auth::user()->id)->pluck('id')->toArray())->with('storeData');;
        }
    }
}
