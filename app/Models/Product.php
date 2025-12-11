<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public $table = 'products';

    protected $fillable = [
        'name',
    ];

    public function contacts()
    {
        return $this->belongsToMany(Contact::class, 'contact_products')
            ->withPivot([
                'hosted_url',
                'autodesk',
                'envato_username',
                'envato_key',
            ])
            ->withTimestamps();
    }
}
