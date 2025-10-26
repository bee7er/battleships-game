<?php
use App\FleetVesselLocation;
use App\FleetVessel;
use App\Game;
?>

@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">Replay Game</p>
            @include('common.msgs')
            @include('common.errors')

            <form id="gameForm" action="" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <input type="hidden" name="gameId" id="gameId" value="{{$game->id}}" />

                <table class="table is-bordered is-striped bs-form-table">
                    <tbody>
                        <tr class="">
                            <td class="cell bs-section-title">
                                Game name:
                            </td>
                            <td class="cell">
                                {{ucfirst($game->game_name)}}
                            </td>
                            <td class="cell bs-section-title">
                                Game status:
                            </td>
                            <td class="cell bs-status" id="gameStatus">
                                {{ucfirst($game->status)}}
                            </td>
                        </tr>
                        <tr class="">
                            <td class="cell bs-section-title">
                                You:
                            </td>
                            <td id="myGoId" class="cell">
                                {{ucfirst($myUser->name)}}
                            </td>
                            <td class="cell bs-section-title">
                                Them:
                            </td>
                            <td id="theirGoId" class="cell">
                                {{ucfirst($theirUser->name)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

        </article>
        <div class="field">
            <div class=""><span class="bs-table-title">Messages:</span> <span id="notification" class="bs-notification">&nbsp;</span></div>
        </div>

        <div class="columns">

            <div class="column">

                <table class="table is-bordered is-striped bs-plot-table">
                    <tbody>
                    <tr class="">
                        <th class="bs-section-title" colspan="99">My Fleet Vessel Locations:</th>
                    </tr>

                    @for ($row=0; $row<=10; $row++)
                        <tr class="" id="myRow{{$row}}">

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
                                            <td class="cell has-text-centered bs-plot-cell-header">{{getAlpha($row)}}</td>
                                        @else
                                            <td class="cell">&nbsp;</td>
                                        @endif
                                    @else
                                        <td class="cell grid-cell has-text-centered bs-pos-cell-blank"
                                            id="myCell_{{$row}}_{{$col}}">O</td>
                                    @endif
                                @endif

                            @endfor
                        </tr>
                    @endfor

                    </tbody>
                </table>
            </div>

            <div class="column  has-text-centered">
                <table class="table is-bordered bs-plot-table">
                    <tbody>
                    <tr class=""><td class="bs-pos-key-blank bs-table-title" colspan="2">Key to colours:</td></tr>
                    <tr class=""><td class="bs-pos-key-plotted">&nbsp;</td><td class="bs-pos-cell-blank">Vessel plotted</td></tr>
                    <tr class=""><td class="bs-pos-key-strike">&nbsp;</td><td class="bs-pos-cell-blank">Location has been bombed but missed the fleet</td></tr>
                    <tr class=""><td class="bs-pos-key-hit">&nbsp;</td><td class="bs-pos-cell-blank">Location has been bombed and hit a target</td></tr>
                    <tr class=""><td class="bs-pos-key-destroyed">&nbsp;</td><td class="bs-pos-cell-blank">Vessel destroyed</td></tr>
                    </tbody>
                </table>

                <hr />
                <span class="bs-table-title">Start or stop the replay:</span>
                <div>
                    <button class="button bs-random_button" onclick="return startPlottingMoves();">Start Replay</button>
                </div>
                <div>
                    <button class="button bs-random_button" onclick="return stopPlottingMoves();">Stop Replay</button>
                </div>
            </div>

            <div class="column">

                <table class="table is-bordered is-striped bs-plot-table">
                    <tbody>
                    <tr class="">
                        <th class="bs-section-title" colspan="99">Their Fleet Vessel Locations:</th>
                    </tr>

                    @for ($row=0; $row<=10; $row++)
                        <tr class="" id="theirRow{{$row}}">

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
                                            <td class="cell has-text-centered bs-plot-cell-header">{{getAlpha($row)}}</td>
                                        @else
                                            <td class="cell">&nbsp;</td>
                                        @endif
                                    @else
                                        <td class="cell grid-cell has-text-centered bs-pos-cell-blank"
                                            id="theirCell_{{$row}}_{{$col}}">O</td>
                                    @endif
                                @endif

                            @endfor
                        </tr>
                    @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        var gameId = {{$game->id}};
        var winnerId = {{$game->winner_id}};
        var myFleetId = 0;
        var theirFleetId = 0;
        var myFleetVessels = [];
        var theirFleetVessels = [];
        var allMoves = [];
        var allMovesClone = null;
        var fleetVesselLocations = [];
        var myUserId = {{$myUser->id}};
        var theirUserId = {{$theirUser->id}};
        var myName = '{{ucfirst($myUser->name)}}';
        var theirName = '{{ucfirst($theirUser->name)}}';
        var myGo = {{$myGo}};
        var gameOver = false;

        // Load all the existing data for my fleet
        @foreach ($myFleet as $fleetVessel)

            fleetVesselLocations = [];
            myFleetId = {{$fleetVessel->id}};

            @foreach ($fleetVessel->locations as $fleetVesselLocation)
                    fleetVesselLocations[fleetVesselLocations.length] = {
                        id: {{$fleetVesselLocation['id']}},
                        fleet_vessel_id: {{$fleetVesselLocation['fleet_vessel_id']}},
                        row: {{$fleetVesselLocation['row']}},
                        col: {{$fleetVesselLocation['col']}},
                        status: '{{FleetVesselLocation::FLEET_VESSEL_LOCATION_NORMAL}}',
                        vessel_name: '{{$fleetVesselLocation['vessel_name']}}'
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

            myFleetVessels[myFleetVessels.length] = fleetVessel;
        @endforeach

        // Load all the existing data for their fleet
        @foreach ($theirFleet as $fleetVessel)

            fleetVesselLocations = [];
            theirFleetId = {{$fleetVessel->id}};

            @foreach ($fleetVessel->locations as $fleetVesselLocation)
                    fleetVesselLocations[fleetVesselLocations.length] = {
                        id: {{$fleetVesselLocation['id']}},
                        fleet_vessel_id: {{$fleetVesselLocation['fleet_vessel_id']}},
                        row: {{$fleetVesselLocation['row']}},
                        col: {{$fleetVesselLocation['col']}},
                        status: '{{FleetVesselLocation::FLEET_VESSEL_LOCATION_NORMAL}}',
                        vessel_name: '{{$fleetVesselLocation['vessel_name']}}'
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

            theirFleetVessels[theirFleetVessels.length] = fleetVessel;
        @endforeach

        // Load all the moves for each user
        @foreach ($allMoves as $aMove)
                allMoves[allMoves.length] = {
                    id: {{$aMove->id}},
                    player_id: {{$aMove->player_id}},
                    row: {{$aMove->row}},
                    col: {{$aMove->col}}
                };
        @endforeach

        if (null == allMovesClone) {
            // Back up the all moves array, so we can restore it later
            allMovesClone = jQuery.extend(true, [], allMoves);
        }

        /**
         * Plot vessels which have been allocated positions on the grid
         */
        function plotFleetLocations()
        {
            for (let i=0; i<myFleetVessels.length; i++) {
                let fleetVessel = myFleetVessels[i];
                // Plot each location
                for (let j=0; j<fleetVessel.locations.length; j++) {
                    let location = fleetVessel.locations[j];
                    let tableCell = $('#myCell_' + location.row + '_' + location.col);
                    let cssClass = 'bs-pos-cell-plotted';
                    setElemStatusClass(tableCell, cssClass);
                    tableCell.html(location.vessel_name.toUpperCase().charAt(0));
                }
            }
            for (let i=0; i<theirFleetVessels.length; i++) {
                let fleetVessel = theirFleetVessels[i];
                // Plot each location
                for (let j=0; j<fleetVessel.locations.length; j++) {
                    let location = fleetVessel.locations[j];
                    let tableCell = $('#theirCell_' + location.row + '_' + location.col);
                    let cssClass = 'bs-pos-cell-plotted';
                    setElemStatusClass(tableCell, cssClass);
                    tableCell.html(location.vessel_name.toUpperCase().charAt(0));
                }
            }
        }

        /**
         * Derive the css status from the location status
         */
        function getCssClass(location, defaultClass)
        {
            // This is the default class for a location occupied by a fleet vessel
            let cssClass = defaultClass;
            if ('{{FleetVesselLocation::FLEET_VESSEL_LOCATION_HIT}}' == location.status) {
                cssClass = 'bs-pos-cell-hit';
            } else if ('{{FleetVesselLocation::FLEET_VESSEL_LOCATION_DESTROYED}}' == location.status) {
                cssClass = 'bs-pos-cell-destroyed';
            }

            return cssClass;
        }

        /**
         * Set whether it is my go or not, or whether I won or not
         */
        function setMyGoOrTheirGo()
        {
            if (gameOver) {
                if (winnerId == myUserId) {
                    $('#myGoId').addClass('bs-status').html(myName + " WINNER ;o)");
                    $('#theirGoId').addClass('bs-status').html(theirName + " LOSER :o(");
                } else {
                    $('#myGoId').addClass('bs-status').html(myName + " LOSER :o(");
                    $('#theirGoId').addClass('bs-status').html(theirName + " WINNER ;o)");
                }
            } else {
                if (myGo) {
                    $('#myGoId').addClass('bs-status').html(myName);
                    $('#theirGoId').removeClass('bs-status').html(theirName);
                } else {
                    $('#theirGoId').addClass('bs-status').html(theirName);
                    $('#myGoId').removeClass('bs-status').html(myName);
                }
            }
        }

        /**
         * Set the element to one status class
         */
        function setElemStatusClass(elem, newClass)
        {
            $(elem).removeClass('bs-pos-cell-destroyed');
            $(elem).removeClass('bs-pos-cell-hit');
            $(elem).removeClass('bs-pos-cell-strike');
            $(elem).removeClass('bs-pos-cell-available');
            $(elem).removeClass('bs-pos-cell-started');
            $(elem).removeClass('bs-pos-cell-plotted');
            $(elem).addClass(newClass);
        }

        /**
         * Clears the entire grid
         */
        function clearGrid()
        {
            // Generic removal of all classes of all cells
            let cells = $('.grid-cell');
            cells.removeClass('bs-pos-cell-destroyed');
            cells.removeClass('bs-pos-cell-hit');
            cells.removeClass('bs-pos-cell-strike');
            cells.removeClass('bs-pos-cell-available');
            cells.removeClass('bs-pos-cell-started');
            cells.removeClass('bs-pos-cell-plotted');
            cells.html('O');

            return cells;
        }

        /**
         * Output a notification
         */
        function showNotification(message)
        {
            let notification = $('#notification');
            notification.html(message).show();
            notification.delay(3000).fadeOut();
        }

        // We are going to plot each move in turn
        let intervalId;
        function startPlottingMoves()
        {
            clearGrid();
            if (null == allMoves || allMoves.length <= 0) {
                // Restore all moves from cloned backup
                allMoves = allMovesClone;
            }
            plotFleetLocations();
            gameOver = false;
            setMyGoOrTheirGo();

            intervalId = setInterval(plotMoveLocations, 700);
        }
        function stopPlottingMoves()
        {
            clearInterval(intervalId);
            // release our intervalId from the variable
            intervalId = null;
        }

        /**
         * Plot moves by each player
         * NB My moves go on to their grid
         */
        function plotMoveLocations()
        {
            let elem = allMoves.pop();
            if (null == elem) {
                stopPlottingMoves();
                gameOver = true;
            } else {
                let tableCell = null;
                if (elem.player_id == myUserId) {
                    myGo = true;
                    tableCell = $('#theirCell_' + elem.row + '_' + elem.col);
                } else  {
                    myGo = false;
                    tableCell = $('#myCell_' + elem.row + '_' + elem.col);
                }
                let newStatus = checkFleetVesselLocationsForStatus(elem.row, elem.col);
                setElemStatusClass(tableCell, newStatus);
            }
            setMyGoOrTheirGo();
        }

        /**
         * Check all locations of the affected fleet vessel to determine the status
         */
        function checkFleetVesselLocationsForStatus(row, col)
        {
            let newStatus = 'bs-pos-cell-strike';
            // Look for the fleet vessel, if found, check all locations, i.e. the various bits of the vessel
            let fleetVessels = (myGo ? theirFleetVessels: myFleetVessels);
            let fleetVessel = findFleetVesselByRowCol(row, col, fleetVessels);
            if (null != fleetVessel) {
                // We have a hit, but check the status of all locations
                newStatus = 'bs-pos-cell-hit';
                if (fleetVessel.length == 1) {
                    fleetVessel.locations[0].status = '{{FleetVesselLocation::FLEET_VESSEL_LOCATION_DESTROYED}}';
                    newStatus = 'bs-pos-cell-destroyed';
                } else {
                    // Set the status of the location that has been hit
                    for (let i=0; i<fleetVessel.locations.length; i++) {
                        let loc = fleetVessel.locations[i];
                        if (loc.row == row && loc.col == col) {
                            loc.status = '{{FleetVesselLocation::FLEET_VESSEL_LOCATION_HIT}}';
                            break;
                        }
                    }
                    // Have they all been hit?
                    let atLeastOneNotHit = false;
                    for (let i=0; i<fleetVessel.locations.length; i++) {
                        let loc = fleetVessel.locations[i];
                        if (loc.status != '{{FleetVesselLocation::FLEET_VESSEL_LOCATION_HIT}}') {
                            atLeastOneNotHit = true;
                            break;
                        }
                    }
                    // If they've all been hit, then they are all destroyed
                    if (false == atLeastOneNotHit) {
                        for (let i=0; i<fleetVessel.locations.length; i++) {
                            let loc = fleetVessel.locations[i];
                            loc.status = '{{FleetVesselLocation::FLEET_VESSEL_LOCATION_DESTROYED}}';
                            let tableCell = $((myGo ? '#theirCell_': '#myCell_') + loc.row + '_' + loc.col);
                            setElemStatusClass(tableCell, 'bs-pos-cell-destroyed');
                        }
                        newStatus = 'bs-pos-cell-destroyed';
                    }
                }
            }
            return newStatus;
        }
        function findFleetVesselByRowCol(row, col, fleetVessels)
        {
            for (let i=0; i<fleetVessels.length; i++) {
                let fleetVessel = fleetVessels[i];
                for (let j=0; j<fleetVessel.locations.length; j++) {
                    if (fleetVessel.locations[j].row == row && fleetVessel.locations[j].col == col) {
                        return fleetVessel;
                    }
                }
            }
            // Not found, so not a hit.
            return null;
        }

        $(document).ready( function()
        {
            plotFleetLocations();

            setMyGoOrTheirGo();

            return true;
        });
    </script>
@endsection