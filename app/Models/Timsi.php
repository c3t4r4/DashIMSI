<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timsi extends Model
{
    use HasFactory;

    protected $table = "timsis";

    protected $fillable = [
        'imsi_id',
        'timsi',
    ];

    /** Relationships */

    public function imsi()
    {
        return $this->hasOne(Imsi::class, 'id', 'imsi_id')->first();
    }

    public function locateds()
    {
        return $this->belongsTo(Located::class, 'timsi_id', 'id');
    }

    /** Scopes */

    /** Atributtes */

    protected function updatedAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => convertDateTimeBR($value),
            set: fn ($value) => convertStringToDate($value),
        );
    }

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => convertDateTimeBR($value),
            set: fn ($value) => convertStringToDate($value),
        );
    }
}
