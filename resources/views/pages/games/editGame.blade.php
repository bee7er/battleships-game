<?php
use App\Game;
?>

@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">Edit Game</p>
            @include('common.msgs')
            @include('common.errors')

            <div class="panel-block">
                <p class="control">
                    Protagonist: {{ucfirst($game->protagonist_name)}}
                </p>
            </div>
            <div class="panel-block">
                <p class="control">
                    Opponent: {{ucfirst($game->opponent_name)}}
                </p>
            </div>
            <div class="panel-block">
                <form id="gamesForm" action="/editGame" method="POST" class="form-horizontal">
                    {{ csrf_field() }}

                    <input type="hidden" name="gameId" id="gameId" value="{{$game->id}}" />

                    <div class="field">
                        <div class="field">
                            <div class="dropdown is-hoverable">
                                <div class="dropdown-trigger">
                                    <button class="button" aria-haspopup="true" aria-controls="dropdown-menu">
                                        <span>Choose New Opponent</span>
                                  <span class="icon is-small">
                                    <i class="fas fa-angle-down" aria-hidden="true"></i>
                                  </span>
                                    </button>
                                </div>
                                <div class="dropdown-menu" id="dropdown-menu" role="menu">
                                    <div class="dropdown-content">
                                        @if (isset($users) && $users->count() > 0)
                                            @foreach($users as $user)
                                                <a href="" class="dropdown-item @if ($user->id == $game->opponent_id) {{'is-active'}} @endif"> {{$user->name}} </a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </article>

        <form id="gamesForm" action="/editGame" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <input type="hidden" name="gameId" id="gameId" value="{{$game->id}}" />
            <input type="hidden" name="fleetId" id="fleetId" value="{{$fleetId}}" />

            <div class="field">
                <label class="label">Game Name</label>
                <div class="control">
                    <input class="input" type="text" placeholder="Game name" name="name" id="name" value="{{$game->game_name}}">
                </div>
            </div>
            <div class="field">
                <div class="bs-status">
                    Current status: {{ucfirst($game->status)}}
                </div>
            </div>

            @if ($game->status == GAME::STATUS_ACTIVE || $game->status == GAME::STATUS_WINNER || $game->status == GAME::STATUS_LOSER)
                <div class="field">
                    <div class="">
                        Started at: {{$game->started_at}}
                    </div>
                </div>
                <div class="field">
                    <div class="">
                        Ended at: {{$game->ended_at}}
                    </div>
                </div>
            @endif

            <div class="field">
                <div class="">
                    Fleet Vessels:
                </div>
            </div>

            <table class="table is-bordered is-striped bs-pos-table">
                <tbody>

                <tr class="">
                    <th class="cell">Select</th>
                    <th class="cell">Name</th>
                    <th class="cell">Status</th>
                    <th class="cell">Length</th>
                    <th class="cell">Points</th>
                    <th class="cell">Row</th>
                    <th class="cell">Column</th>
                </tr>

                @foreach ($fleet as $fleetVessel)
                    <tr class="">
                        <td class="cell" id="id_{{$fleetVessel->fleet_vessel_id}}">
                            <input type="radio"
                                   name="vessel" value="{{$fleetVessel->fleet_vessel_id}}" />
                        </td>
                        <td class="cell" id="name_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->vessel_name}}</td>
                        <td class="cell" id="status_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->status}}</td>
                        <td class="cell" id="length_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->length}}</td>
                        <td class="cell" id="points_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->points}}</td>
                        <td class="cell" id="row_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->row}}</td>
                        <td class="cell" id="col_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->col}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            <div class="field">
                <div class="">
                    Vessel Locations:
                </div>
            </div>

                <table class="table is-bordered is-striped bs-pos-table">
                    <tbody>

                    @for ($i=0; $i<=10; $i++)
                        <tr class="" id="row{{$i}}">

                            @for ($j=0; $j<=10; $j++)

                                @if ($i == 0)
                                    @if ($j > 0)
                                        <td class="cell has-text-centered bs-pos-cell-header">{{$j}}</td>
                                    @else
                                        <td class="cell">&nbsp;</td>
                                    @endif
                                @else
                                    @if ($j == 0)
                                        @if ($i > 0)
                                            <td class="cell has-text-centered bs-pos-cell-header">{{$i}}</td>
                                        @else
                                            <td class="cell">&nbsp;</td>
                                        @endif
                                    @else
                                        <td class="cell has-text-centered" id="cell_{{$i}}_{{$j}}" onclick="allocateCell(this);">O</td>
                                    @endif
                                @endif

                            @endfor
                        </tr>
                    @endfor

                    </tbody>
                </table>

        </form>
        <div class="field">&nbsp;</div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">
        var startPos = [];
        var endPos = [];
        var vesselLocations = initFleetVesselData();

        /**
         * Allocates a cell to a vessel
         */
        function allocateCell(elem)
        {
            let selected = $("input[type='radio'][name='vessel']:checked");
            if (selected.length <= 0) {
                alert('Please select a vessel to allocate to this position');
                return false;
            }
            let max_col = 10;
            let max_row = 10;
            let fleetVesselId = selected.val();
            let elemIdData = elem.id.split('_');
            let row = parseInt(elemIdData[1]);
            let col = parseInt(elemIdData[2]);
            let fleetId = $('#fleetId').val();
            let vesselLength = parseInt($('#length_' + fleetVesselId).html()); // the selected vessel length
            if (1 == vesselLength) {
                elem.innerHTML = $('#name_' + fleetVesselId).html()[0].toUpperCase();
                $(elem).addClass('bs-pos-cell-selected');

            } else {
                elem.innerHTML = $('#name_' + fleetVesselId).html()[0].toUpperCase();
                $(elem).addClass('bs-pos-cell-started');
            }

            if (true == clickedLocation(row, col, vesselLength)) {
                if (1 == vesselLength) {
                    // Save the vessel location to the server
                    vesselLocations.fleetId = fleetId;
                    vesselLocations.fleetVesselId = fleetVesselId;
                    vesselLocations.vesselLength = vesselLength;
                    vesselLocations.locations[vesselLocations.locations.length] = startPos;
                    vesselLocations.locations[vesselLocations.locations.length] = endPos;

                    console.log('Sending: ' + JSON.stringify(vesselLocations));

                    ajaxCall('setVesselLocation', JSON.stringify(vesselLocations));

                    vesselLocations = initFleetVesselData();
                    startPos = [];
                    endPos = [];
                }
            }
            else {
                availableCells(row, col, vesselLength);
            }
        }

        /**
         * Capture the clicked location
         */
        function clickedLocation(row, col, vesselLength)
        {
            if (0 == startPos.length)
            {
                startPos[0] = row;
                startPos[1] = col;
                if (1 == vesselLength) {
                    // Length 1, so start and end are the same
                    endPos[0] = row;
                    endPos[1] = col;

                    return true;
                }
            } else {
                endPos[0] = row;
                endPos[1] = col;

                return true;
            }

            return false;
        }

        /**
         * Highlight available cells
         */
        function availableCells(row, col, vesselLength)
        {
            let tryRow = row - (vesselLength - 1);
            let tryCol = col - (vesselLength - 1);

            let itr = 1;        // Maybe 0
            if (vesselLength == 2) itr = 3;
            if (vesselLength == 3) itr = 5;

            for (i=0; i<itr; i++) {
                for (j=0; j<itr; j++) {
                    //console.log('Pos i=' + i + ', j=' + j);
                    $('#cell_' + (tryRow + i) + '_' + (tryCol + j)).addClass('bs-pos-cell-available');
                }
            }

        }

        /**
         * Initialise the fleet vessel data structure
         */
        function initFleetVesselData()
        {
            return {
                fleetId: 0,
                fleetVesselId: 0,
                vesselLength: 0,
                locations: []
            };
        }

        $(document).ready( function()
        {
            return false;
        });
    </script>
@endsection