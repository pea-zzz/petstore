<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable; 
use Illuminate\Foundation\Auth\User as Authenticatable; 
class Admin extends Authenticatable 
{ 
    use Notifiable; 

    // Specify the guard for admins
    protected $guard = 'admin'; 

    protected $fillable = [ 
        'name', 
        'email', 
        'password', 
    ]; 

    protected $hidden = [ 
        'password', 
        'remember_token',
    ]; 

    /**
     * Define a one-to-many relationship with the Item model
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }
} 
