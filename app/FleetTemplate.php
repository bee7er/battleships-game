<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FleetTemplate extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'fleet_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['vessel_id'];

    /**
     * Get the fleet vessel size and their lengths, to return the fleet location size
     */
    public static function getFleetLocationSize()
    {
        $builder = self::select(
            array(
                'fleet_templates.id',
                'fleet_templates.vessel_id',
                'vessels.length'
            )
        )
            ->join('vessels', 'vessels.id', '=', 'fleet_templates.vessel_id');

        $fleetTemplates = $builder->get();
        $fleetLocationSize = 0;
        if (isset($fleetTemplates) && $fleetTemplates->count() > 0) {
            foreach ($fleetTemplates as $fleetTemplate) {
                $fleetLocationSize += $fleetTemplate->length;
            }
        }

        return $fleetLocationSize;
    }
}