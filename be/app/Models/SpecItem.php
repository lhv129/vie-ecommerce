<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecItem extends Model
{
    use HasFactory;
    protected $fillable = ['label', 'group_id', 'unit', 'data_type'];

    public function group()
    {
        return $this->belongsTo(SpecGroup::class);
    }

}
