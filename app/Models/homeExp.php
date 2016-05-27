<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class homeExp extends Model
{
    //
    public $table ="home_exp";
    public $primaryKey="exp_id";
    public $timestamps=true;
    protected $dateFormat="U";
}
