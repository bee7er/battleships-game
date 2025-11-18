<?php
use App\FleetVessel;
use App\Game;

$fleetId = 0;
?>

@extends('layouts.app')
@section('title') edit grid @parent @endsection

@section('content')

    <div class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">Edit Game Grid</p>
            @include('common.msgs')
            @include('common.errors')

            <form id="gameForm" action="{{env("BASE_URL", "/")}}updateGame" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <input type="hidden" name="gameId" id="gameId" value="{{$game->id}}" />

                <table class="table is-bordered is-striped bs-form-table">
                    <tbody>
                        <tr class="">
                            <td class="cell bs-section-title">
                                Game status:
                            </td>
                            <td class="cell bs-status">
                                <span id="gameStatus">{{ucfirst($game->status)}}</span>
                                <span id="engageLink" class="is-pulled-right">
                                    <a class="bs-games-button" href="javascript: location.href='{{env("BASE_URL", "/")}}playGrid?gameId={{$game->id}}'">Engage</a>
                                </span>
                            </td>
                        </tr>
                        <tr class="">
                            <td class="cell bs-section-title">
                                Game name:
                            </td>
                            <td class="cell">
                                {{ucfirst($game->game_name)}}
                            </td>
                        </tr>
                        <tr class="">
                            <td class="cell bs-section-title">
                                Protagonist:
                            </td>
                            <td class="cell">
                                {{ucfirst($game->protagonist_name)}}
                            </td>
                        </tr>
                        <tr class="">
                            <td class="cell bs-section-title">
                                Opponent:
                            </td>
                            <td class="cell">
                                {{ucfirst($game->opponent_name)}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

        </article>
        <div class="field">
            <div class="bs-section-help">Select each vessel and plot its positions on the grid.</div>
            <div class="bs-section-help">Each vessel has a length corresponding with the number of positions which must be plotted.</div>
            <div class="bs-section-help">Click the <b>Go Random</b> button to have the game generate a random set of positions.</div>
            <div class=""><span class="bs-messages-title">Messages:</span> <span id="notification" class="bs-notification">&nbsp;</span></div>
        </div>

        <div class="columns">

            <div class="column">

                <table class="table is-bordered is-striped bs-plot-table">
                    <tbody>
                    <tr class="">
                        <th class="bs-grid-title" colspan="99">Fleet Vessels:</th>
                    </tr>

                    <tr class=" bs-grid-title">
                        <th class="cell">Select</th>
                        <th class="cell">Name</th>
                        <th class="cell">Status</th>
                        <th class="cell">Length</th>
                        <th class="cell">Points</th>
                    </tr>

                    @if (isset($fleet) && count($fleet) > 0)
                        @foreach ($fleet as $fleetVessel)
                            <?php $fleetId = $fleetVessel->id; ?>
                            <tr class="" onclick="selectRow('{{$fleetVessel->fleet_vessel_id}}')">
                                <td class="cell">
                                    <input type="radio" id="radio_id_{{$fleetVessel->fleet_vessel_id}}"
                                           name="vessel" value="{{$fleetVessel->fleet_vessel_id}}" onclick="onClickSelectVessel(this);" />
                                </td>
                                <td class="cell" id="name_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->vessel_name}}</td>
                                <td class="cell" id="status_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->status}}</td>
                                <td class="cell" id="length_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->length}}</td>
                                <td class="cell" id="points_{{$fleetVessel->fleet_vessel_id}}">{{$fleetVessel->points}}</td>
                            </tr>
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>


            <div class="column has-text-centered is-one-quarter">
                <table class="table is-bordered bs-plot-table">
                    <tbody>
                    <tr class=""><td class="bs-grid-title" colspan="2">Key to colours:</td></tr>
                    <tr class=""><td class="bs-pos-key-available">&nbsp;</td><td class="bs-pos-key-blank">Available location</td></tr>
                    <tr class=""><td class="bs-pos-key-started">&nbsp;</td><td class="bs-pos-key-blank">Vessel started</td></tr>
                    <tr class=""><td class="bs-pos-key-plotted">&nbsp;</td><td class="bs-pos-key-blank">Vessel plotted</td></tr>
                    </tbody>
                </table>
                <hr />
                <div>
                    <button class="button bs-random_button" onclick="return goRandom();">Go Random</button>
                </div>
                <div>
                    <button class="button bs-random_button" onclick="return cancelRandom();">Cancel Random</button>
                </div>
                <div>
                    <button class="button bs-random_button" onclick="return saveRandom();">Save Random</button>
                </div>
            </div>


            <div class="column">

                <table class="table is-bordered is-striped bs-plot-table">
                    <tbody>
                    <tr class="">
                        <th class="bs-grid-title" colspan="99">Vessel Locations Grid:</th>
                    </tr>

                    @for ($row=0; $row<=10; $row++)
                        <tr class="" id="row{{$row}}">

                            @for ($col=0; $col<=10; $col++)

                                @if ($row == 0)
                                    @if ($col > 0)
                                        <td class="cell has-text-centered bs-plot-cell-header">{{$col}}</td>
                                    @else
                                        <td class="cell bs-grid-title">&nbsp;</td>
                                    @endif
                                @else
                                    @if ($col == 0)
                                        @if ($row > 0)
                                            <td class="cell has-text-centered bs-plot-cell-header">{{getAlpha($row)}}</td>
                                        @else
                                            <td class="cell bs-grid-title">&nbsp;</td>
                                        @endif
                                    @else
                                        <td class="cell grid-cell has-text-centered bs-pos-cell-blank"
                                            id="cell_{{$row}}_{{$col}}" onclick="onClickAllocateCell(this);">O</td>
                                    @endif
                                @endif

                            @endfor
                        </tr>
                    @endfor

                    </tbody>
                </table>

                <div class="field">&nbsp;</div>
                <div class="field">&nbsp;</div>
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">
        var gameId = {{$game->id}};
        var fleetId = {{$fleetId}};
        var opponentId = {{$game->opponent_id}}
        var fleetVessels = [];
        var fleetVessel = {};
        var fleetVesselLocations = [];
        var gridSize = 10;
        var randomMode = false;
        var fleetVesselsClone = null;
        var fleetLocationSize = {{$fleetLocationSize}};

        // Load all the existing data for the fleet
        @if (isset($fleet) && count($fleet) > 0)
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
        @endif

        /**
         * Allocates a cell to a vessel
         */
        function onClickAllocateCell(elem)
        {
            if (allVesselsPlotted()) {
                showNotification('All the vessels have been plotted.');
                return false;
            }

            if (true == randomMode) {
                showNotification('Cancel random allocation of vessels to continue');
                return false;
            }

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

            // If already started then we undo that and remove it from the locations for this vessel
            if ($(elem).hasClass('bs-pos-cell-started')) {
                // User re-clicked on an allocated cell, so undo the selection
                removeCellAllocation(elem, row, col);

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
            // Add game, fleet and opponent ids for some checking server side
            fleetVessel.gameId = gameId;
            fleetVessel.fleetId = fleetId;
            fleetVessel.opponentId = opponentId;
            fleetVessel.subjectRow = row;
            fleetVessel.subjectCol = col;
            fleetVessel.user_token = getCookie('user_token');

            // ========================================================================
            // Post the new location to the server and await the return in the callback
            ajaxCall('setVesselLocation', JSON.stringify(fleetVessel), updateFleetVessel);

            return false;
        }

        /**
         * User has clicked on a started cell, or has abandoned allocating for a vessel
         * by clicking on another vessel.  We remove the cell from the set of allocated ones.
         */
        function removeCellAllocation(elem, row, col)
        {
            fleetVesselByRowCol = findFleetVesselByRowCol(row, col);
            if (fleetVessel.fleetVesselId != fleetVesselByRowCol.fleetVesselId) {
                showNotification('This location is occupied by another vessel');
                return false;
            }

            fleetVessel.subjectRow = 0;
            fleetVessel.subjectCol = 0;
            // TODO We may need this
            // If there is a second allocated elem then we want to reposition to that on return
            if (2 == fleetVessel.locations.length) {
                for (let i=0; i<fleetVessel.locations.length; i++) {
                    let location = fleetVessel.locations[i];
                    if (location.row != row || location.col != col) {
                        fleetVessel.subjectRow = location.row;
                        fleetVessel.subjectCol = location.col;
                        break;
                    }
                }
            }
            // Ok, release this plotted cell
            let location = {
                gameId: gameId,
                fleetVessel: fleetVessel,
                row: row,
                col: col,
                user_token: getCookie('user_token')
            };

            // ========================================================================
            ajaxCall('removeVesselLocation', JSON.stringify(location), updateFleetVessel);
            // Clear the cell and availability
            setElemStatusClass(elem, '');
            $(elem).html('O');
            // Generic removal of all cells flagged as available
            $('.grid-cell').removeClass('bs-pos-cell-available');

            showNotification('Location has been cleared');
        }

        /**
         * Allocates a cell to a vessel
         */
        function onClickSelectVessel(rowElem)
        {
            // Generic removal of all cells flagged as available or started
            $('.grid-cell').removeClass('bs-pos-cell-available');
            let starteds = $('.bs-pos-cell-started');
            if (starteds.length > 0) {
                let started = starteds[0];
                // Get row/col from the clicked element
                let elemIdData = started.id.split('_');
                let row = parseInt(elemIdData[1]);
                let col = parseInt(elemIdData[2]);
                let fleetVesselStarted = findFleetVesselByRowCol(row, col);
                // No other locations will be involved
                fleetVesselStarted.subjectRow = 0;
                fleetVesselStarted.subjectCol = 0;
                // If there are any started cells then we remove them all
                let location = {
                    gameId: gameId,
                    fleetVessel: fleetVesselStarted,
                    user_token: getCookie('user_token')
                };

                // ========================================================================
                ajaxCall('removeAllVesselLocations', JSON.stringify(location), updateFleetVessel);
            }
            // Clear all started cells
            $('.bs-pos-cell-started').each(function() {
                $(this).html('O');
                $(this).removeClass('bs-pos-cell-started');
            });

            return false;
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
            if (null == fleetVessels || [] == fleetVessels || 0 == fleetVessels.length) {
                return;
            }
            for (let i = 0; i < fleetVessels.length; i++) {
                let fleetVessel = fleetVessels[i];
                // Update the status, which may have changed
                $('#status_' + fleetVessel.fleetVesselId).html(fleetVessel.status);
                // Plot each location
                for (let j = 0; j < fleetVessel.locations.length; j++) {
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
            // Generic removal of all cells flagged as available
            $('.grid-cell').removeClass('bs-pos-cell-available');

            // Exit if the vessel is already plotted
            if ('{{FleetVessel::FLEET_VESSEL_PLOTTED}}' == fleetVessel.status) {
                return;
            }

            let numberOfAvailableCells = 0;
            // For length three we need to examine whether three in a row will fit somewhere
            if (3 == fleetVessel.length && 2 == fleetVessel.locations.length) {
                // We need at least one available cell
                numberOfAvailableCells = lengthThreeTwoAllocated(row, col, fleetVessel);

            } else {

                let tryRow = row - (fleetVessel.length - 1);
                let tryCol = col - (fleetVessel.length - 1);

                let itr = 1;        // Maybe 0, or (2 x length - 1)
                if (fleetVessel.length == 2) itr = 3;
                if (fleetVessel.length == 3) itr = 5;

                for (i = 0; i < itr; i++) {
                    if ((tryRow + i) <= 0 || (tryRow + i) > gridSize) continue;

                    for (j = 0; j < itr; j++) {
                        if ((tryCol + j) <= 0 || (tryCol + j) > gridSize) continue;

                        let elem = $('#cell_' + (tryRow + i) + '_' + (tryCol + j)); //.html('' + i + j);    // To see offsets
                        if ($(elem).hasClass('bs-pos-cell-plotted') || $(elem).hasClass('bs-pos-cell-started')) {
                            // Ignore this location
                        } else {
                            let idx = ('' + i + j);
                            if (fleetVessel.length == 2) {
                                if ('01' == idx || '10' == idx || '12' == idx || '21' == idx) {
                                    setElemStatusClass(elem, 'bs-pos-cell-available');
                                    numberOfAvailableCells += 1;
                                }
                            } else {
                                if ('02' == idx || '12' == idx || '23' == idx || '24' == idx
                                    || '32' == idx || '42' == idx || '20' == idx || '21' == idx
                                ) {
                                    setElemStatusClass(elem, 'bs-pos-cell-available');
                                    numberOfAvailableCells += 1;
                                }
                            }
                        }
                    }
                }

                // For length three with only one allocated we need to examine whether three in a row will fit
                if (fleetVessel.length == 3 && 1 == fleetVessel.locations.length) {
                    numberOfAvailableCells = lengthThreeOneAllocated(row, col, fleetVessel);
                }
            }
            // Check that there is somewhere to go
            if (numberOfAvailableCells < (fleetVessel.length - fleetVessel.locations.length)) {
                showNotification('There is not enough room or no squares available in that position. Please move it elsewhere.');
                return;
            }
            showNotification('Now click on one of the highlighted (pink) locations');
        }


        /**
         * Highlight available cells when dealing with length three, when two have already been allocated
         */
        function lengthThreeTwoAllocated(row, col, fleetVessel)
        {
            let tryRow = row - 2;
            let tryCol = col - 2;
            let itr = 5;        // A 5 x 5 set of cells which could possibly available
            let numberOfAvailableCells = 0;

            // There can only be 1 or 2 cells already started, as 3 would mean the vessel has been plotted
            // This reduces the cells that are available
            // Create an array of all elems with the started class, narrows down those available even more
            let hasStarted = [];
            let availableElems = [];
            for (i = 0; i < itr; i++) {
                if ((tryRow + i) <= 0 || (tryRow + i) > gridSize) continue;

                for (j = 0; j < itr; j++) {
                    if ((tryCol + j) <= 0 || (tryCol + j) > gridSize) continue;

                    elem = $('#cell_' + (tryRow + i) + '_' + (tryCol + j)); //.html('' + i + j);    // To see offsets
                    let elemObj = {
                        elem: elem,
                        idx: ('' + i + j)       // Speeds things up below
                    };
                    if ($(elem).hasClass('bs-pos-cell-started')) {
                        hasStarted[hasStarted.length] = elemObj;
                    } else {
                        if ($(elem).hasClass('bs-pos-cell-plotted')) {
                            // Ignore this location
                        } else {
                            // This location is possibly available
                            availableElems[availableElems.length] = elemObj;
                        }
                    }
                }
            }
            // For testing purposes use the .html('' + i + j) in line above to show the matrix of cell locations. It makes
            // sense of the bank of number tests below.
            // For each offset cell it can only be used if another required cell is available to complete the set of three
            // The starting position is always 2,2, the following table can be read as:
            //      if the other started cell is '02', then only '12' can be used, if it is available
            //      if the other started cell is '12', then '02' or '32' can be used, if available
            for (let i = 0; i < hasStarted.length; i++) {
                let started = hasStarted[i];
                let n1 = 0;
                let n2 = 0;

                if ('02' == started.idx) { n1=setAvailableElem(availableElems, '12'); }
                if ('12' == started.idx) { n1=setAvailableElem(availableElems, '02'); n2=setAvailableElem(availableElems, '32'); }
                if ('20' == started.idx) { n1=setAvailableElem(availableElems, '21'); }
                if ('21' == started.idx) { n1=setAvailableElem(availableElems, '20'); n2=setAvailableElem(availableElems, '23'); }
                if ('23' == started.idx) { n1=setAvailableElem(availableElems, '21'); n2=setAvailableElem(availableElems, '24'); }
                if ('24' == started.idx) { n1=setAvailableElem(availableElems, '23'); }
                if ('32' == started.idx) { n1=setAvailableElem(availableElems, '12'); n2=setAvailableElem(availableElems, '42'); }
                if ('42' == started.idx) { n1=setAvailableElem(availableElems, '32'); }

                numberOfAvailableCells += (n1 + n2);
            }

            return numberOfAvailableCells;
        }

        /**
         * Set the element to be available if not blocked by already being allocated
         */
        function setAvailableElem(availableElems, idx)
        {
            for (let j=0; j<availableElems.length; j++) {
                let elemObj = availableElems[j];
                if (idx == elemObj.idx) {
                    $(elemObj.elem).addClass('bs-pos-cell-available');
                    return 1;
                }
            }
            return 0;
        }

        /**
         * Highlight available cells when dealing with length three, when only one is currently allocated
         */
        function lengthThreeOneAllocated(row, col, fleetVessel)
        {
            let tryRow = row - 2;
            let tryCol = col - 2;
            let itr = 5;        // A 5 x 5 set of cells which could possibly be available
            let numberOfAvailableCells = 0;

            // Create an array of all elems with the available class, these are those that might be possible
            let hasAvailable = [];
            for (i = 0; i < itr; i++) {
                if ((tryRow + i) <= 0 || (tryRow + i) > gridSize) continue;

                for (j = 0; j < itr; j++) {
                    if ((tryCol + j) <= 0 || (tryCol + j) > gridSize) continue;

                    elem = $('#cell_' + (tryRow + i) + '_' + (tryCol + j));
                    if ($(elem).hasClass('bs-pos-cell-available')) {
                        hasAvailable[hasAvailable.length] = {
                            elem: elem,
                            idx: ('' + i + j)       // Speeds things up below
                        };
                        if (2 == i && 2 == j) {
                            // Do not count the primary cell, it is always at 2,2
                        } else {
                            numberOfAvailableCells += 1;
                        }
                    }
                }
            }

            // For each offset cell it can only be used if a required cell is available to complete the set of three
            // So '02' is only available if '12' is also available
            for (let i = 0; i < hasAvailable.length; i++) {
                let avail = hasAvailable[i];
                if (
                        '02' == avail.idx && !hasAvailableElem(hasAvailable, '12')
                        || '12' == avail.idx && (!hasAvailableElem(hasAvailable, '02') && !hasAvailableElem(hasAvailable, '32'))
                        || '20' == avail.idx && !hasAvailableElem(hasAvailable, '21')
                        || '21' == avail.idx && (!hasAvailableElem(hasAvailable, '20') && !hasAvailableElem(hasAvailable, '23'))
                        || '23' == avail.idx && (!hasAvailableElem(hasAvailable, '21') && !hasAvailableElem(hasAvailable, '24'))
                        || '24' == avail.idx && !hasAvailableElem(hasAvailable, '23')
                        || '32' == avail.idx && (!hasAvailableElem(hasAvailable, '12') && !hasAvailableElem(hasAvailable, '42'))
                        || '42' == avail.idx && !hasAvailableElem(hasAvailable, '32')
                ) {
                    // The cell cannot be used as a required cell isn't available
                    setElemStatusClass(avail.elem, '');
                    numberOfAvailableCells -= 1;
                }
            }

            return numberOfAvailableCells;
        }

        /**
         * Try to find the requested elem
         */
        function hasAvailableElem(elemAry, idx)
        {
            for (let j=0; j<elemAry.length; j++) {
                let elem = elemAry[j];
                if (idx == elem.idx) {
                    return true;
                }
            }
            return false;
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
            $('#gameStatus').html(returnedGameStatus.gameStatus);
            if ('{{Game::STATUS_READY}}' == returnedGameStatus.gameStatus.toLowerCase()
                    || '{{Game::STATUS_ENGAGED}}' == returnedGameStatus.gameStatus.toLowerCase()
            ) {
                $('#engageLink').show();
            }
        }

        /**
         * Clicking anywhere on a table row selects that radio button, for convenience
         */
        function selectRow(fleetVesselId)
        {
            let elem = $('#radio_id_' + fleetVesselId);
            elem.prop('checked', true);
            // Process the selected eleemnt
            onClickSelectVessel(elem.get(0));
        }

        /**
         * Callback function to handle the asynchronous Ajax call
         * @param returnedFleetVessel: is the returned data for this callback
         */
        function updateFleetVessel(returnedFleetVessel)
        {
            let row = returnedFleetVessel.subjectRow;
            let col = returnedFleetVessel.subjectCol;
            // Update the fleet vessel as a result of the new location
            let fleetVessel = null;
            for (let i=0; i<fleetVessels.length; i++) {
                if (fleetVessels[i].fleetVesselId == returnedFleetVessel.fleetVesselId) {
                    fleetVessels[i].status = returnedFleetVessel.status;
                    fleetVessels[i].locations = returnedFleetVessel.locations;

                    fleetVessel = fleetVessels[i];
                }
            }

            if (0 != row && 0 != col) {
                // NB This function must be called here else we encounter a timing issue
                // between the Ajax call and the testing of the status of the returned fleet vessel
                // Plot available cells around the clicked cell, if any.
                availableCells(row, col, fleetVessel);
            }

            // Set the attributes of the clicked cell, by replotting all fleet locations
            plotFleetLocations();

            // Check the status of the game, as it may have changed
            let statusCheck = {
                gameId: returnedFleetVessel.gameId,
                user_token: getCookie('user_token')
            };
            // =====================================================================
            ajaxCall('getGameStatus', JSON.stringify(statusCheck), setGameStatus);
        }

        /**
         * Randomly plot an entire set of vessels
         */
        function goRandom()
        {
            randomMode = true;

            // Uncheck all radio buttons.  User must cancel random to continue editing locations.
            $("input[type='radio'][name='vessel']").prop('checked', false);
            let cells = clearGrid();
            cells.addClass('unoccupied');       // Sets all cells as being available

            // Disable all the radio buttons
            $(':radio').prop("disabled", true);
            if (null == fleetVesselsClone) {
                // Back up the fleet vessels so we can go back if the user cancels
                fleetVesselsClone = jQuery.extend(true, [], fleetVessels);
            }

            for (let i = 0; i < fleetVessels.length; i++) {
                // For each vessel we allocate a cell for each part of it, its length
                let fleetVessel = fleetVessels[i];
                fleetVessel.status = '{{FleetVessel::FLEET_VESSEL_AVAILABLE}}';
                fleetVessel.locations = [];
                let location = selectCellAndBuildLocation('unoccupied', fleetVessel);
                fleetVessel.locations[fleetVessel.locations.length] = location;

                // If there are more vessel parts, we work out available cells around it and attach one of them
                if (fleetVessel.length >= 2) {
                    availableCells(location.row, location.col, fleetVessel);
                    // Now we select from the bs-pos-cell-available cells
                    location = selectCellAndBuildLocation('bs-pos-cell-available', fleetVessel);
                    fleetVessel.locations[fleetVessel.locations.length] = location;
                }

                if (fleetVessel.length > 2) {
                    availableCells(location.row, location.col, fleetVessel);
                    fleetVessel.locations[fleetVessel.locations.length] = selectCellAndBuildLocation('bs-pos-cell-available', fleetVessel);
                }
            }

            let gridCell = $('.grid-cell');
            gridCell.removeClass('unoccupied');
            gridCell.removeClass('bs-pos-cell-available');

            let checkStartedCells = $('.bs-pos-cell-started' );
            if (fleetLocationSize != checkStartedCells.length) {
                alert('Fleet vessel overlap detected with count ' + checkStartedCells.length);
            }
        }

        /**
         * Randomly chooses an available cell, builds and returns a location object
         */
        function selectCellAndBuildLocation(cellSelector, fleetVessel)
        {
            let selectedAvailableCells = $('.' + cellSelector);
            // Obtain a random unoccupied cell
            let cellNumber = Math.floor(Math.random() * selectedAvailableCells.length) + 1;
            // Work out its row/col from its id
            let elem = selectedAvailableCells.eq(cellNumber - 1);
            let elemIdData = elem.prop('id').split('_');
            let rowInt = parseInt(elemIdData[1]);
            let colInt = parseInt(elemIdData[2]);
            // Set this cell to be occupied and assign the first letter of the vessel type
            let selectedCell = $('#' + elem.prop('id'));
            selectedCell.addClass('bs-pos-cell-started');
            selectedCell.removeClass(cellSelector);
            selectedCell.removeClass('unoccupied');
            selectedCell.html(fleetVessel.vessel_name.toUpperCase().charAt(0));
            // Build a location object which we'll send to the server to update the db
            let location = {
                id: 0,
                fleet_vessel_id: fleetVessel.fleetVesselId,
                row: rowInt,
                col: colInt,
                vessel_name: fleetVessel.vessel_name
            };

            return location;
        }

        /**
         * Cancel the random allocation of cells
         */
        function cancelRandom()
        {
            if (false == randomMode) {
                return;
            }
            randomMode = false;

            // Enable all the radio buttons
            $(':radio').prop("disabled", false);
            // Restore the original set of locations
            clearGrid();
            fleetVessels = fleetVesselsClone;
            // Clear the back up collection
            fleetVesselsClone = null;
            // Replot the original set of locations, if any
            plotFleetLocations();
        }

        /**
         * Save the random allocation of cells
         */
        function saveRandom()
        {
            if (false == randomMode) {
                return;
            }
            randomMode = false;

            // Convert all fleet vessel started locations to plotted locations
            $('.bs-pos-cell-started').addClass('bs-pos-cell-plotted');
            $('.bs-pos-cell-plotted').removeClass('bs-pos-cell-started');

            for (let i = 0; i < fleetVessels.length; i++) {
                fleetVessels[i].status = '{{FleetVessel::FLEET_VESSEL_PLOTTED}}';
            }
            let postData = {
                gameId: gameId,
                fleetId: fleetId,
                fleetVessels: fleetVessels,
                user_token: getCookie('user_token')
            };

            // ========================================================================
            // Post the new vessel locations to the server and await the return in the callback
            ajaxCall('replaceFleetVesselLocations', JSON.stringify(postData), replacedFleetVesselLocations);

        }

        /**
         * Callback from replacing fleet locations with the randomly generated set
         */
        function replacedFleetVesselLocations(returnedFleetVesselData)
        {
            // Check the result and reload page
            let fleetVesselCount = returnedFleetVesselData.fleetVesselCount;
            let fleetVesselLocationCount = returnedFleetVesselData.fleetVesselLocationCount;

            location.reload();
        }

        /**
         * Examine the vessels, are they all plotted?
         */
        function allVesselsPlotted()
        {
            let allPlotted  = true;
            for (let i=0; i<fleetVessels.length; i++) {
                let fleetVessel = fleetVessels[i];
                if (fleetVessel.status != '{{FleetVessel::FLEET_VESSEL_PLOTTED}}') {
                    allPlotted = false;
                }
            }
            return allPlotted;
        }

        /**
         * Clears the entire grid
         */
        function clearGrid()
        {
            // Generic removal of all classes of all cells
            let cells = $('.grid-cell');
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

        $(document).ready( function()
        {
            @if (Game::STATUS_READY != $game->status && Game::STATUS_ENGAGED != $game->status)
                $('#engageLink').hide();
            @endif

            plotFleetLocations();

            return true;
        });
    </script>
@endsection