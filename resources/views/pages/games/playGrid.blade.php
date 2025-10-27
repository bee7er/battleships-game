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
                <table class="table is-bordered bs-plot-table">
                    <tbody>
                    <tr class=""><td class="bs-pos-key-blank bs-table-title" colspan="2">Key to colours:</td></tr>
                    <tr class=""><td class="bs-pos-key-plotted">&nbsp;</td><td class="bs-pos-cell-blank">Vessel plotted</td></tr>
                    <tr class=""><td class="bs-pos-key-strike">&nbsp;</td><td class="bs-pos-cell-blank">Location has been bombed but missed the fleet</td></tr>
                    <tr class=""><td class="bs-pos-key-hit">&nbsp;</td><td class="bs-pos-cell-blank">Location has been bombed and hit a target</td></tr>
                    <tr class=""><td class="bs-pos-key-destroyed">&nbsp;</td><td class="bs-pos-cell-blank">Vessel destroyed</td></tr>
                    </tbody>
                </table>
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
                                        <td class="cell has-text-centered bs-pos-cell-blank"
                                            id="theirCell_{{$row}}_{{$col}}" onclick="onClickStrikeCell(this);">O</td>
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
        var myFleetId = 0;
        var theirFleetId = 0;
        var myFleetVessels = [];
        var theirFleetVessels = [];
        var myMoves = [];
        var theirMoves = [];
        var fleetVesselLocations = [];
        var myUserId = {{$myUser->id}};
        var theirUserId = {{$theirUser->id}};
        var gridSize = 10;
        var myGo = {{($myGo ? 'true': 'false')}};
        var myName = '{{ucfirst($myUser->name)}}';
        var theirName = '{{ucfirst($theirUser->name)}}';
        var gameOver = ('{{Game::STATUS_COMPLETED}}' == '{{$game->status}}');
        if (gameOver) {
            setMyGoOrTheirGo();
        }

        // Load all the existing data for the fleet
        @foreach ($myFleet as $fleetVessel)

            fleetVesselLocations = [];
            myFleetId = {{$fleetVessel->id}};

            @foreach ($fleetVessel->locations as $fleetVesselLocation)
                    fleetVesselLocations[fleetVesselLocations.length] = {
                        id: {{$fleetVesselLocation['id']}},
                        fleet_vessel_id: {{$fleetVesselLocation['fleet_vessel_id']}},
                        row: {{$fleetVesselLocation['row']}},
                        col: {{$fleetVesselLocation['col']}},
                        status: '{{$fleetVesselLocation['vessel_location_status']}}',
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

        // Load all the existing data for the fleet
        @foreach ($theirFleet as $fleetVessel)

            fleetVesselLocations = [];
            theirFleetId = {{$fleetVessel->id}};

            @foreach ($fleetVessel->locations as $fleetVesselLocation)
                    fleetVesselLocations[fleetVesselLocations.length] = {
                        id: {{$fleetVesselLocation['id']}},
                        fleet_vessel_id: {{$fleetVesselLocation['fleet_vessel_id']}},
                        row: {{$fleetVesselLocation['row']}},
                        col: {{$fleetVesselLocation['col']}},
                        status: '{{$fleetVesselLocation['vessel_location_status']}}',
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
        @foreach ($myMoves as $aMove)
                myMoves[myMoves.length] = {
                    id: {{$aMove->id}},
                    row: {{$aMove->row}},
                    col: {{$aMove->col}}
                };
        @endforeach
        @foreach ($theirMoves as $aMove)
                theirMoves[theirMoves.length] = {
                    id: {{$aMove->id}},
                    row: {{$aMove->row}},
                    col: {{$aMove->col}}
                };
        @endforeach

        /**
         * Shoots a missile at cell to try to bomb a vessel
         */
        function onClickStrikeCell(elem)
        {
            if (gameOver) {
                showNotification('The game is now over');
                setMyGoOrTheirGo();
                return false;
            }

            if (!myGo) {
                showNotification('It is not your go');
                return false;
            }

            if ($(elem).hasClass('bs-pos-cell-strike')
                    || $(elem).hasClass('bs-pos-cell-hit')
                    || $(elem).hasClass('bs-pos-cell-destroyed')
            ) {
                showNotification('You have already fired at that location, try again');
                return false;
            }

            // Get row/col from the clicked element
            let elemIdData = elem.id.split('_');
            let row = parseInt(elemIdData[1]);
            let col = parseInt(elemIdData[2]);

            theirFleetVesselByRowCol = findTheirFleetVesselByRowCol(row, col);
            if (null == theirFleetVesselByRowCol) {
                showNotification('Sorry you missed');
                playAudio('splash');
            } else {
                showNotification('Bang! good shot, you have hit something');
                $(elem).addClass('bs-pos-cell-hit');
                playAudio('hit');
            }

            // Ok, notify the server of this move, me striking their fleet
            let location = {
                gameId: gameId,
                userId: myUserId,
                fleetId: theirFleetId,
                row: row,
                col: col,
                user_token: getCookie('user_token')
            };

            // ========================================================================
            ajaxCall('strikeVesselLocation', JSON.stringify(location), updateTheirFleetLocationsCallback);

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
                    let tableCell = $('#myCell_' + location.row + '_' + location.col);
                    let cssClass = getCssClass(location, 'bs-pos-cell-plotted');
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
                    let cssClass = getCssClass(location, '');
                    setElemStatusClass(tableCell, cssClass);
                    // Only show the vessel identifier if it has been hit or destroyed
                    if ('{{FleetVesselLocation::FLEET_VESSEL_LOCATION_HIT}}' == location.status
                        || '{{FleetVesselLocation::FLEET_VESSEL_LOCATION_DESTROYED}}' == location.status) {
                        tableCell.html(location.vessel_name.toUpperCase().charAt(0));
                    }
                }
            }
        }

        /**
         * Plot moves by each player
         * NB My moves go on to their grid
         */
        function plotMoveLocations()
        {
            for (let i=0; i<myMoves.length; i++) {
                let aMove = myMoves[i];
                let tableCell = $('#theirCell_' + aMove.row + '_' + aMove.col);
                setElemStatusClass(tableCell, 'bs-pos-cell-strike');
            }
            for (let i=0; i<theirMoves.length; i++) {
                let aMove = theirMoves[i];
                let tableCell = $('#myCell_' + aMove.row + '_' + aMove.col);
                setElemStatusClass(tableCell, 'bs-pos-cell-strike');
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
         * Callback function receiving the latest move by the opponent
         */
        function updateMyFleetLocationsCallback(returnedMoveData)
        {
            if (null != returnedMoveData) {
                // Updating my grid with their moves
                theirMoves[theirMoves.length] = {
                    id: returnedMoveData.move.id,
                    row: returnedMoveData.move.row,
                    col: returnedMoveData.move.col
                };

                // Update my fleet vessel location status
                if (null != returnedMoveData.affectedLocations) {
                    for (let i=0; i<returnedMoveData.affectedLocations.length; i++) {
                        let loc = returnedMoveData.affectedLocations[i];
                        let fleetVessel = findMyFleetVessel(loc.fleetVesselId);
                        // Find the corresponding fleet vessel location
                        for (let j=0; j<fleetVessel.locations.length; j++) {
                            let fvl = fleetVessel.locations[j];
                            if (fvl.id == loc.fleetVesselLocationId) {
                                fvl.status = loc.status;
                                break;
                            }
                        }
                    }
                }
                plotMoveLocations();
                plotFleetLocations();

                stopCheckingForMoves();

                myGo = true;
                setMyGoOrTheirGo();

                let statusCheck = {
                    gameId: gameId,
                    userId: myUserId,
                    fleetId: theirFleetId,
                    user_token: getCookie('user_token')
                };
                // ========================================================================
                ajaxCall('getGameStatus', JSON.stringify(statusCheck), setGameStatusCallback);
            }
        }

        /**
         * Callback function receiving the latest move by the opponent
         */
        function updateTheirFleetLocationsCallback(returnedMoveData)
        {
            if (null != returnedMoveData) {
                // We update their grid with my moves
                myMoves[myMoves.length] = {
                    id: returnedMoveData.move.id,
                    row: returnedMoveData.move.row,
                    col: returnedMoveData.move.col
                };
                console.log(returnedMoveData.affectedLocations);
                // Update their fleet vessel location status
                if (null != returnedMoveData.affectedLocations) {
                    for (let i = 0; i < returnedMoveData.affectedLocations.length; i++) {
                        let loc = returnedMoveData.affectedLocations[i];
                        let fleetVessel = findTheirFleetVessel(loc.fleetVesselId);
                        // Find the corresponding fleet vessel location
                        for (let j = 0; j < fleetVessel.locations.length; j++) {
                            let fvl = fleetVessel.locations[j];
                            if (fvl.id == loc.fleetVesselLocationId) {
                                fvl.status = loc.status;
                                checkForSound(loc.status);
                                break;
                            }
                        }
                    }
                }

                plotMoveLocations();
                plotFleetLocations();

                // Now we poll the server for their response
                startCheckingForMoves();

                myGo = false;
                setMyGoOrTheirGo();
            }

            // I have just made a move, so we want to check for moves by me and the
            // destruction of their fleet
            let statusCheck = {
                gameId: gameId,
                userId: myUserId,
                fleetId: theirFleetId,
                user_token: getCookie('user_token')
            };
            // ========================================================================
            ajaxCall('getGameStatus', JSON.stringify(statusCheck), setGameStatusCallback);
        }

        /**
         * Find the fleet vessel details based on the fleet vessel id
         */
        function findMyFleetVessel(fleetVesselId)
        {
            return findFleetVessel(fleetVesselId, myFleetVessels, 'my');
        }
        function findTheirFleetVessel(fleetVesselId)
        {
            return findFleetVessel(fleetVesselId, theirFleetVessels, 'their');
        }
        function findFleetVessel(fleetVesselId, fleetVessels, which)
        {
            for (let i=0; i<fleetVessels.length; i++) {
                let fleetVessel = fleetVessels[i];
                if (fleetVesselId == fleetVessel.fleetVesselId) {
                    return fleetVessel;
                }
            }
            alert('Error: Could not find ' + which + ' fleet vessel for id ' + fleetVesselId);

            return null;
        }

        /**
         * Find the fleet vessel details by row/col location
         */
        function findMyFleetVesselByRowCol(row, col)
        {
            return findFleetVesselByRowCol(row, col, myFleetVessels, 'my');
        }
        function findTheirFleetVesselByRowCol(row, col)
        {
            return findFleetVesselByRowCol(row, col, theirFleetVessels, 'their');
        }
        function findFleetVesselByRowCol(row, col, fleetVessels, which)
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
         * Callback function to handle the asynchronous Ajax call
         */
        function setGameStatusCallback(returnedGameStatus)
        {
            $('#gameStatus').html(returnedGameStatus);
            gameOver = ('{{Game::STATUS_COMPLETED}}' == returnedGameStatus.toLowerCase());
            if (gameOver) {
                setMyGoOrTheirGo();
            }
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

        /**
         * Set whether it is my go or not, or whether I won or not
         */
        function setMyGoOrTheirGo()
        {
            if (gameOver) {
                if (myGo) {
                    $('#myGoId').addClass('bs-status').html(myName + " YOU LOST !! :o(");
                    $('#theirGoId').removeClass('bs-status').html(theirName);
                } else {
                    $('#myGoId').addClass('bs-status').html(myName + " YOU WON !! ;o)");
                    $('#theirGoId').removeClass('bs-status').html(theirName);
                }
            } else {
                if (myGo) {
                    $('#myGoId').addClass('bs-status').html(myName + ' << Your go!');
                    $('#theirGoId').removeClass('bs-status').html(theirName);
                } else {
                    $('#theirGoId').addClass('bs-status').html(theirName + ' << Their go!');
                    $('#myGoId').removeClass('bs-status').html(myName);
                }
            }
        }

        // Call across to the server to see if there have been any changes
        let intervalId;
        function startCheckingForMoves()
        {
            //console.log('Starting to check for moves on the server');
            intervalId = setInterval(checkForChanges, 2000);
        }
        function stopCheckingForMoves()
        {
            //console.log('Stop checking for moves on the server');
            clearInterval(intervalId);
            // release our intervalId from the variable
            intervalId = null;
        }
        function checkForChanges()
        {
            // We call across to the server to see if they have struck my grid
            // We find their latest move and see if it has impacted my fleet
            let moveData = {
                gameId: gameId,
                userId: theirUserId,
                fleetId: myFleetId,
                user_token: getCookie('user_token')
            };

            // ========================================================================
            ajaxCall('getLatestOpponentMove', JSON.stringify(moveData), updateMyFleetLocationsCallback)
        }

        $(document).ready( function()
        {
            plotMoveLocations();

            plotFleetLocations();

            setMyGoOrTheirGo();

            if (gameOver) {
                showNotification('Great game is now over');
            } else {

                if (!myGo) {
                    // We poll the server for their move
                    startCheckingForMoves();
                }
            }

            return true;
        });
    </script>
@endsection