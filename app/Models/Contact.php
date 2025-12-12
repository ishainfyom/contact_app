<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'region_code',
        'phone_number',
        'country',
        'city',
        'designation',
        'company_name',
        'website_url',
        'linkedin_url',
        'company_linkedin_url',
        'apollo_id',
        'company_apollo_id',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        //
    ];

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name).' '.ucfirst($this->last_name);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'contact_products')
            ->withPivot([
                'hosted_url',
                'authordesk',
                'envato_username',
                'envato_key',
            ])
            ->withTimestamps();
    }
}
