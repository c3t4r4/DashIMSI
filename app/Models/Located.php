<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Located extends Model
{
    use HasFactory;

    protected $table = "locateds";

    protected $fillable = [
        'imsi_id',
        'timsi_id',
    ];

    /** Relationships */

    public function imsi()
    {
        return $this->hasOne(Imsi::class, 'id', 'imsi_id')->first();
    }

    public function timsi()
    {
        return $this->hasOne(Timsi::class, 'id', 'timsi_id')->first();
    }

    /** Scopes */
    public function scopeAllItens($query)
    {
        return $query->with('imsi')->with('timsi')->orderBy('updated_at', 'desc');
    }

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
