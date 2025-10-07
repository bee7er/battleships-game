<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Vessel extends Model
{
    const VESSEL_TYPE_BATTLESHIP = 'battleship';
    const VESSEL_TYPE_DESTROYER = 'destroyer';
    const VESSEL_TYPE_SUBMARINE = 'submarine';
    const VESSEL_TYPE_ZODIAC = 'zodiac';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vessels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'length', 'points'];

}