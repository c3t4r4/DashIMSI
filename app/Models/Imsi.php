<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imsi extends Model
{
    use HasFactory;

    protected $table = "imsis";

    protected $fillable = [
        'imsi'
    ];

    /** Relationships */

    public function timsis()
    {
        return $this->belongsTo(Timsi::class, 'imsi_id', 'id');
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
        );
    }

    protected function createdAt(): Attribute
    {
        return new Attribute(
            get: fn ($value) => convertDateTimeBR($value),
        );
    }
}
