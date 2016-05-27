<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    //
    public $table ="home_option";
    public $primaryKey="option_id";
    public $timestamps=true;
    protected $dateFormat="U";
}
