<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FleetVessel extends Model
{
    const FLEET_VESSEL_AVAILABLE = 'available';
    const FLEET_VESSEL_POSITIONED = 'positioned';
    const FLEET_VESSEL_DESTROYED = 'destroyed';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fleet_vessels';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['fleet_id', 'vessel_id'];

}