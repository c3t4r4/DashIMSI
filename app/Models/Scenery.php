<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scenery extends Model
{
    use HasFactory;

    protected $table = "sceneries";

    protected $fillable = [
        'description',
        'lat',
        'lng',
        'start',
        'finish',
    ];

    /** Relationships */

    /** Scopes */

    /** Atributtes */

    protected function start(): Attribute
    {
        return new Attribute(
            get: fn ($value) => convertDateTimeBR($value),
        );
    }

    protected function finish(): Attribute
    {
        return new Attribute(
            get: fn ($value) => convertDateTimeBR($value),
        );
    }

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