<?php
use App\FleetVessel;
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
                <form id="gameForm" action="/editGame" method="POST" class="form-horizontal">
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

        <form id="fleetVesselsForm" action="/editGame" method="POST" class="form-horizontal">
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
                    Current game status: {{ucfirst($game->status)}}
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

            <table class="table is-bordered is-striped bs-plot-table">
                <tbody>

                <tr class="">
                    <th class="cell">Select</th>
                    <th class="cell">Name</th>
                    <th class="cell">Status</th>
                    <th class="cell">Length</th>
                    <th class="cell">Points</th>
                    <th class="cell">Id</th>
                </tr>

                @foreach ($fleet as $fleetVessel)
                    <tr class="">
                        <td class="cell">
                            <input type="radio" id="radio_id_{{$fleetVessel->fleet_vessel_id}}"
                                   name="vessel" value="{{$fleetVessel->fleet_vessel_id}}" onclick="onClickSelectVessel(this);" />
                        </td>
                        <td class="cell" id="name_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->vessel_name}}</td>
                        <td class="cell" id="status_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->status}}</td>
                        <td class="cell" id="length_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->length}}</td>
                        <td class="cell" id="points_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->points}}</td>
                        <td class="cell" id="points_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->fleet_vessel_id}}</td>
                    </tr>
                @endforeach

                </tbody>
            </table>

            <div class="field">
                <div class="">
                    Vessel Locations:<span id="notification" class="bs-notification">&nbsp;</span>
                </div>

            </div>

                <table class="table is-bordered is-striped bs-plot-table">
                    <tbody>

                    @for ($row=0; $row<=10; $row++)
                        <tr class="" id="row{{$row}}">

                            @for ($col=0; $col<=10; $col++)

                                @if ($row == 0)
                                    @if ($col > 0)
                                        <td class="cell has-text-centered bs-plot-cell-header">{{$col}}</td>
                                    @else
                                        <td class="cell">&nbsp;</td>
                                    @endif
                                @else
                                    @if ($col == 0)
                                        @if ($row > 0)
                                            <td class="cell has-text-centered bs-plot-cell-header">{{$row}}</td>
                                        @else
                                            <td class="cell">&nbsp;</td>
                                        @endif
                                    @else
                                        <td class="cell has-text-centered bs-pos-cell-blank"
                                            id="cell_{{$row}}_{{$col}}" onclick="onClickAllocateCell(this);">O</td>
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
        var fleetVessels = [];
        var fleetVessel = {};
        var fleetVesselLocations = [];
        var max_col = 10;
        var max_row = 10;

        // Load all the existing data for the fleet
        @foreach ($fleet as $fleetVessel)

            fleetVesselLocations = [];

            @foreach ($fleetVessel->locations as $fleetVesselLocation)
                fleetVesselLocations[fleetVesselLocations.length] = {
                    id: {{$fleetVesselLocation['id']}},
                    fleet_vessel_id: {{$fleetVesselLocation['fleet_vessel_id']}},
                    row: {{$fleetVesselLocation['row']}},
                    col: {{$fleetVesselLocation['col']}},
                    vessel_name: '{{$fleetVesselLocation['vessel_name']}}',
                };
            @endforeach

            fleetVessel = {
                fleetVesselId: {{$fleetVessel->fleet_vessel_id}},
                vessel_name: '{{$fleetVessel->vessel_name}}',
                status: '{{$fleetVessel['status']}}',
                length: {{$fleetVessel->length}},
                points: {{$fleetVessel->points}},
                locations: fleetVesselLocations
            };

            fleetVessels[fleetVessels.length] = fleetVessel;
        @endforeach

        /**
         * Allocates a cell to a vessel
         */
        function onClickAllocateCell(elem)
        {
            let selected = $("input[type='radio'][name='vessel']:checked");
            if (selected.length <= 0) {
                showNotification('Please select a vessel to allocate to this position');
                return false;
            }

            if ($(elem).hasClass('bs-pos-cell-plotted')) {
                showNotification('The location you clicked on has already been taken');
                return false;
            }

            // Get row/col from the clicked element
            let elemIdData = elem.id.split('_');
            let row = parseInt(elemIdData[1]);
            let col = parseInt(elemIdData[2]);

            let fleetVesselId = selected.val();
            fleetVessel = findFleetVessel(fleetVesselId);

            if ($(elem).hasClass('bs-pos-cell-started')) {
                fleetVesselByRowCol = findFleetVesselByRowCol(row, col);
                if (fleetVessel.fleetVesselId != fleetVesselByRowCol.fleetVesselId) {
                    showNotification('This location is occupied by another vessel');
                    return false;
                }
                // We set up the subject row/col to conform with the set function
                fleetVessel.subjectRow = 0;
                fleetVessel.subjectCol = 0;
                // Ok, release this plotted cell
                let location = {
                    fleetVessel: fleetVessel,
                    row: row,
                    col: col
                };
                ajaxCall('removeVesselLocation', JSON.stringify(location), updateFleetVessel);
                // Clear the cell and availability
                setElemStatusClass(elem, '');
                $(elem).html('O');
                // Generic removal of all cells flagged as available
                $('.cell').removeClass('bs-pos-cell-available');
                showNotification('Location has been cleared');
                return false;
            } else if (0 == fleetVessel.locations.length || $(elem).hasClass('bs-pos-cell-available')) {
                // Ok, we can start the plotting, or this cell can be plotted
            } else {
                showNotification('Please click on an available (pink) location');
                return false;
            }
            // Add this location to the current vessel
            fleetVessel.locations[fleetVessel.locations.length] = {
                id: 0,
                fleet_vessel_id: fleetVesselId,
                row: row,
                col: col,
                vessel_name: fleetVessel.vessel_name
            };
            fleetVessel.subjectRow = row;
            fleetVessel.subjectCol = col;

            // Post the new location to the server and await the return in the callback
            ajaxCall('setVesselLocation', JSON.stringify(fleetVessel), updateFleetVessel);

            return false;
        }

        /**
         * Allocates a cell to a vessel
         */
        function onClickSelectVessel(elem)
        {
            // Generic removal of all cells flagged as available
            $('.cell').removeClass('bs-pos-cell-available');
            // Get vessel id from the clicked element
            let elemIdData = elem.id.split('_');
            let fleetVesselId = parseInt(elemIdData[2]);

            fleetVessel = findFleetVessel(fleetVesselId);
            if ('{{FleetVessel::FLEET_VESSEL_STARTED}}' == fleetVessel.status) {
                // Show available cells corresponding with the first row/col
                availableCells(fleetVessel.locations[0].row, fleetVessel.locations[0].col, fleetVessel);
            }
        }

        /**
         * Handle the asynchronous Ajax call
         * @param returnedFleetVessel: is the returned data for this callback
         */
        function updateFleetVessel(returnedFleetVessel, row, col)
        {
            // Update the fleet vessel as a result of the new location
            let fleetVessel = null;
            for (let i=0; i<fleetVessels.length; i++) {
                if (fleetVessels[i].fleetVesselId == returnedFleetVessel.fleetVesselId) {
                    fleetVessels[i].status = returnedFleetVessel.status;
                    fleetVessels[i].locations = returnedFleetVessel.locations;

                    fleetVessel = fleetVessels[i];
                }
            }

            if (0 !== row && 0 != col) {
                // NB This function must be called here else we encounter a timing issue
                // between the Ajax call and the testing of the status of the returned fleet vessel
                // Plot available cells around the clicked cell, if any.
                availableCells(row, col, fleetVessel);
            }

            // Set the attributes of the clicked cell, by replotting all fleet locations
            plotFleetLocations();
        }

        /**
         * Find the fleet vessel details based on the fleet vessel id
         */
        function findFleetVessel(fleetVesselId)
        {
            for (let i=0; i<fleetVessels.length; i++) {
                let fleetVessel = fleetVessels[i];
                if (fleetVesselId == fleetVessel.fleetVesselId) {
                    return fleetVessel;
                }
            }
            alert('Error: Could not find fleet vessel for id ' + fleetVesselId);
        }

        /**
         * Find the fleet vessel details by row/col location
         */
        function findFleetVesselByRowCol(row, col)
        {
            for (let i=0; i<fleetVessels.length; i++) {
                let fleetVessel = fleetVessels[i];
                for (let j=0; j<fleetVessel.locations.length; j++) {
                    if (fleetVessel.locations[j].row == row && fleetVessel.locations[j].col == col) {
                        return fleetVessel;
                    }
                }
            }
            alert('Error: Could not find fleet vessel for row ' + row + ' and col' + col);
        }

        /**
         * Plot vessels which have been allocated positions on the grid
         */
        function plotFleetLocations()
        {
            for (let i=0; i<fleetVessels.length; i++) {
                let fleetVessel = fleetVessels[i];
                // Update the status, which may have changed
                $('#status_' + fleetVessel.fleetVesselId).html(fleetVessel.status);
                // Plot each location
                for (let j=0; j<fleetVessel.locations.length; j++) {
                    let location = fleetVessel.locations[j];
                    let cssClass = 'bs-pos-cell-started';
                    if ('{{FleetVessel::FLEET_VESSEL_PLOTTED}}' == fleetVessel.status) {
                        cssClass = 'bs-pos-cell-plotted';
                        // Disable the corresponding radio button, as this vessel is fully plotted
                        $('#radio_id_' + location.fleet_vessel_id).prop("disabled", true);
                    }
                    let tableCell = $('#cell_' + location.row + '_' + location.col);
                    setElemStatusClass(tableCell, cssClass);
                    tableCell.html(location.vessel_name.toUpperCase().charAt(0));
                }
                // NB If the selected vessel from above is now plotted then deselect it
                let selected = $("input[type='radio'][name='vessel']:checked");
                if (selected.length > 0) {
                    let fleetVesselId = selected.val();
                    fleetVessel = findFleetVessel(fleetVesselId);
                    if ('{{FleetVessel::FLEET_VESSEL_PLOTTED}}' == fleetVessel.status) {
                        $("input[type='radio'][name='vessel']").prop('checked', false);
                    }
                }
            }
        }

        /**
         * Highlight available cells
         */
        function availableCells(row, col, fleetVessel)
        {
            console.log('In Available cells------');
            // Generic removal of all cells flagged as available
            $('.cell').removeClass('bs-pos-cell-available');
            // Exit if the vessel is plotted
            if ('{{FleetVessel::FLEET_VESSEL_PLOTTED}}' == fleetVessel.status) {
                return;
            }

            let tryRow = row - (fleetVessel.length - 1);
            let tryCol = col - (fleetVessel.length - 1);

            let itr = 1;        // Maybe 0
            if (fleetVessel.length == 2) itr = 3;
            if (fleetVessel.length == 3) itr = 5;

            for (i=0; i<itr; i++) {
                for (j=0; j<itr; j++) {
                    //console.log('Pos i=' + i + ', j=' + j);
                    let elem = $('#cell_' + (tryRow + i) + '_' + (tryCol + j));
                    if ($(elem).hasClass('bs-pos-cell-plotted') || $(elem).hasClass('bs-pos-cell-started')) {
                        // Ignore this location
                    } else {
                        setElemStatusClass($('#cell_' + (tryRow + i) + '_' + (tryCol + j)), 'bs-pos-cell-available');
                    }
                }
            }

        }

        /**
         * Set the element to one status class
         */
        function setElemStatusClass(elem, newClass)
        {
            $(elem).removeClass('bs-pos-cell-available');
            $(elem).removeClass('bs-pos-cell-started');
            $(elem).removeClass('bs-pos-cell-plotted');
            $(elem).addClass(newClass);
        }

        /**
         * Output a notification
         */
        function showNotification(message)
        {
            $('#notification').html(message).show();
            $('#notification').delay(3000).fadeOut();
        }

        $(document).ready( function()
        {
            plotFleetLocations();

            return true;
        });
    </script>
@endsection