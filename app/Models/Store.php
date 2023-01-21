<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Store extends Model
{
    use HasFactory;

    public static $status = [1 => 'Active', 2 => 'Deleted'];

    protected $fillable = ['owner', 'name', 'address', 'lng', 'ltd', 'informations', 'status'];

    public static function laratablesStatus($record)
    {
        return '<span class="badge badge-' . (new Colors)->getColor($record['status']) . '">' . self::$status[$record['status']] . '</span>';
    }

    public static function laratablesOwner($record)
    {
        return (isset($record->userData)) ? $record->userData->name . ' (' . $record->userData->email . ')' : '<strong class="text-danger">No User Assigned</strong>';
    }

    public static function laratablesCustomAction($record)
    {
        return '<i onclick="doEdit(' . $record['id'] . ')" class="la la-edit ml1 text-warning"></i><i onclick="doDelete(' . $record['id'] . ')" class="la la-trash ml-1 text-danger"></i>';
    }

    public static function laratablesSearchableColumns()
    {
        return ['name', 'informations', 'address'];
    }

    public static function laratablesQueryConditions($query)
    {
        if (Auth::user()->usertype == 1) {
            return $query->where('status', 1)->with('userData');
        } else {
            return $query->where('status', 1)->where('owner', Auth::user()->id)->with('userData');
        }
    }

    public function userData()
    {
        return $this->hasOne(User::class, 'id', 'owner');
    }
}
