<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public $table = 'tags';

    protected $fillable = ['name'];

    /**
     * The contacts that belong to the tag.
     */
    public function contacts()
    {
        return $this->belongsToMany(Contact::class);
    }
}
