<?php
use App\FleetVessel;
use App\Game;
?>

@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">Play Game</p>
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
                            <td class="cell @if ($myGo) {{'bs-status'}} @endif">
                                {{ucfirst($myUser->name)}} @if ($myGo) {{'<< Your go!'}} @endif
                            </td>
                            <td class="cell bs-section-title">
                                Them:
                            </td>
                            <td class="cell @if (!$myGo) {{'bs-status'}} @endif">
                                {{ucfirst($theirUser->name)}}  @if (!$myGo) {{'<< Their go!'}} @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

        </article>
        <div class="field">
            <div class="">Messages: <span id="notification" class="bs-notification">&nbsp;</span></div>
        </div>

        <div class="columns">

            <div class="column">

                <table class="table is-bordered is-striped">
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
                                            <td class="cell has-text-centered bs-plot-cell-header">{{$row}}</td>
                                        @else
                                            <td class="cell">&nbsp;</td>
                                        @endif
                                    @else
                                        <td class="cell has-text-centered bs-pos-cell-blank"
                                            id="myCell_{{$row}}_{{$col}}">O</td>
                                    @endif
                                @endif

                            @endfor
                        </tr>
                    @endfor

                    </tbody>
                </table>
            </div>

            <div class="column">

                <table class="table is-bordered" style="margin-top:50%;">
                    <tbody>
                    <tr class=""><td class="bs-pos-cell-shot">Location has been bombed but missed the fleet</td></tr>
                    <tr class=""><td class="bs-pos-cell-hit">Location has been bombed and hit a target</td></tr>
                    </tbody>
                </table>
            </div>

            <div class="column">

                <table class="table is-bordered is-striped">
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
                                            <td class="cell has-text-centered bs-plot-cell-header">{{$row}}</td>
                                        @else
                                            <td class="cell">&nbsp;</td>
                                        @endif
                                    @else
                                        <td class="cell has-text-centered bs-pos-cell-blank"
                                            id="theirCell_{{$row}}_{{$col}}" onclick="onClickShootCell(this);">O</td>
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

    <div class="">
        <div style="text-align: center;padding:40px 0 10px 0;">&copy; {{ (new DateTime)->format('Y') }} Brian Etheridge</div>
    </div>
@endsection

@section('page-scripts')
    <script type="text/javascript">
        var gameId = {{$game->id}};
        var myFleetVessels = [];
        var theirFleetVessels = [];
        var fleetVesselLocations = [];
        var myUserId = {{$myUser->id}};
        var theirUserId = {{$theirUser->id}};
        var gridSize = 10;

        // Load all the existing data for the fleet
        @foreach ($myFleet as $fleetVessel)

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

            myFleetVessels[myFleetVessels.length] = fleetVessel;
        @endforeach

        // Load all the existing data for the fleet
        @foreach ($theirFleet as $fleetVessel)

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

            theirFleetVessels[theirFleetVessels.length] = fleetVessel;
        @endforeach

        /**
         * Shoots a missile at cell to try to bomb a vessel
         */
        function onClickShootCell(elem)
        {
            if ($(elem).hasClass('bs-pos-cell-shot') || $(elem).hasClass('bs-pos-cell-hit')) {
                showNotification('You have already shot that location. Try again.');
                return false;
            }

            // Get row/col from the clicked element
            let elemIdData = elem.id.split('_');
            let row = parseInt(elemIdData[1]);
            let col = parseInt(elemIdData[2]);

            theirFleetVesselByRowCol = findTheirFleetVesselByRowCol(row, col);
            if (null == theirFleetVesselByRowCol) {
                showNotification('Sorry you missed');
                $(elem).addClass('bs-pos-cell-shot');
            }
            showNotification('Wahey! Good shot');
            $(elem).addClass('bs-pos-cell-hit');

            // Ok, notify the server of this move
            let location = {
                gameId: gameId,
                userId: myUserId,
                row: row,
                col: col,
                user_token: getCookie('user_token')
            };

            // ========================================================================
            ajaxCall('shotVesselLocation', JSON.stringify(location), updateTheirFleetLocations);

            return false;
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
                    let cssClass = 'bs-pos-cell-plotted';
                    let tableCell = $('#myCell_' + location.row + '_' + location.col);
                    setElemStatusClass(tableCell, cssClass);
                    tableCell.html(location.vessel_name.toUpperCase().charAt(0));
                }
            }
            for (let i=0; i<theirFleetVessels.length; i++) {
                let fleetVessel = theirFleetVessels[i];
                // Plot each location
                for (let j=0; j<fleetVessel.locations.length; j++) {
                    let location = fleetVessel.locations[j];
                    let cssClass = 'bs-pos-cell-plotted';
                    let tableCell = $('#theirCell_' + location.row + '_' + location.col);
                    setElemStatusClass(tableCell, cssClass);
                    tableCell.html(location.vessel_name.toUpperCase().charAt(0));
                }
            }
        }

        /**
         * Callback function receiving the latest move by the opponent
         */
        function updateMyFleetLocations(returnedMoveData)
        {
            console.log('updateMyFleetLocations');
            console.log(returnedMoveData);
        }

        /**
         * Callback function receiving the latest move by the opponent
         */
        function updateTheirFleetLocations(returnedMoveData)
        {
            console.log('updateTheirFleetLocations');
            console.log(returnedMoveData);
        }

        /**
         * Find the fleet vessel details based on the fleet vessel id
         */
        function findMyFleetVessel(fleetVesselId)
        {
            for (let i=0; i<myFleetVessels.length; i++) {
                let fleetVessel = myFleetVessels[i];
                if (fleetVesselId == fleetVessel.fleetVesselId) {
                    return fleetVessel;
                }
            }
            alert('Error: Could not find my fleet vessel for id ' + fleetVesselId);
        }

        /**
         * Find the fleet vessel details based on the fleet vessel id
         */
        function findTheirFleetVessel(fleetVesselId)
        {
            for (let i=0; i<theirFleetVessels.length; i++) {
                let fleetVessel = theirFleetVessels[i];
                if (fleetVesselId == fleetVessel.fleetVesselId) {
                    return fleetVessel;
                }
            }
            alert('Error: Could not find their fleet vessel for id ' + fleetVesselId);
        }

        /**
         * Find the fleet vessel details by row/col location
         */
        function findMyFleetVesselByRowCol(row, col)
        {
            for (let i=0; i<myFleetVessels.length; i++) {
                let fleetVessel = myFleetVessels[i];
                for (let j=0; j<fleetVessel.locations.length; j++) {
                    if (fleetVessel.locations[j].row == row && fleetVessel.locations[j].col == col) {
                        return fleetVessel;
                    }
                }
            }
            alert('Error: Could not find my fleet vessel for row ' + row + ' and col' + col);
        }

        /**
         * Find the fleet vessel details by row/col location
         */
        function findTheirFleetVesselByRowCol(row, col)
        {
            for (let i=0; i<theirFleetVessels.length; i++) {
                let fleetVessel = theirFleetVessels[i];
                for (let j=0; j<fleetVessel.locations.length; j++) {
                    if (fleetVessel.locations[j].row == row && fleetVessel.locations[j].col == col) {
                        return fleetVessel;
                    }
                }
            }
            return null;
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
         * Callback function to handle the asynchronous Ajax call
         */
        function setGameStatus(returnedGameStatus)
        {
            $('#gameStatus').html(returnedGameStatus);
        }

        /**
         * Output a notification
         */
        function showNotification(message)
        {
            $('#notification').html(message).show();
            $('#notification').delay(3000).fadeOut();
        }

        // Call across to the server to see if there have been any chanegs
        let intervalId;
        function startCheckingForMoves() {
            intervalId = setInterval(checkForChanges, 2000);
        }
        function stopCheckingForCHanges() {
            clearInterval(intervalId);
            // release our intervalId from the variable
            intervalId = null;
        }
        function checkForChanges() {
            // Ok, release this plotted cell
            let moveData = {
                gameId: gameId,
                userId: theirUserId,
                user_token: getCookie('user_token')
            };

            ajaxCall('getLatestOpponentMove', JSON.stringify(moveData), updateMyFleetLocations)
        }

        $(document).ready( function()
        {
            plotFleetLocations();

            //startCheckingForMoves();

            return true;
        });
    </script>
@endsection