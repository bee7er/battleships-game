<?php
use App\Game;
?>

@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">
        @include('common.msgs')
        @include('common.errors')

        <div class="bs-add-link is-pulled-right" title="Add a new game"><a href="javascript: gotoAddGame()">Add Game</a></div>

        <form id="gamesForm" action="/editGame" method="GET" class="form-horizontal">
            <input type="hidden" name="gameId" id="gameId" value="" />

            <table class="table is-fullwidth is-bordered is-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Game Name</th>
                    <th>Protagonist</th>
                    <th>Opponent</th>
                    <th>Fleet Name</th>
                    <th>Status</th>
                    <th>Started at</th>
                    <th>Ended at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Game Name</th>
                    <th>Protagonist</th>
                    <th>Opponent</th>
                    <th>Fleet Name</th>
                    <th>Status</th>
                    <th>Started at</th>
                    <th>Ended at</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>

                @if (isset($games) && $games->count() > 0)
                    @foreach($games as $game)
                    <tr>
                        <td>{{$game->id}}</td>
                        <td>{{$game->name}}</td>
                        <td>{{$game->protagonist_name}}</td>
                        <td>{{$game->opponent_name}}</td>
                        <td>{{isset($game->fleet) ? $game->fleet->fleet_name: 'not set yet'}}</td>
                        <td>{{$game->status}}</td>
                        <td>{{$game->started_at}}</td>
                        <td>{{$game->ended_at}}</td>
                        <td>
                            @if ($game->status == Game::STATUS_EDIT
                             || $game->status == Game::STATUS_WAITING)
                                @if ($game->protagonist_id == $userId)
                                    <div title="Edit the game"><a href="javascript: gotoEdit({{$game->id}})">Edit</a></div>
                                @else
                                    @if (isset($game->opponent_fleet))
                                        <div title="Edit the game"><a href="javascript: gotoEdit({{$game->id}})">Edit</a></div>
                                    @else
                                        <div title="Accept the game"><a href="javascript: gotoAccept({{$game->id}})">Accept</a></div>
                                    @endif
                                @endif
                            @else
                                @if ($game->status == Game::STATUS_READY)
                                    <div title="Start the game"><a href="javascript: gotoEngage({{$game->id}})">Engage</a></div>
                                @endif
                            @endif
                            <div title="Delete the game"><a href="javascript: gotoDelete({{$game->id}})">Delete</a></div>
                            @if ($game->status == Game::STATUS_WINNER || $game->status == Game::STATUS_LOSER)
                                    <div title="Run simulation"><a href="">Rerun</a></div>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="bs-no-data" colspan="99">You have not yet created any games</td>
                    </tr>
                @endif

                </tbody>
            </table>
        </form>

    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">
        /**
         * Add a new game
         */
        function gotoAddGame() {
            let f = $('#gamesForm');
            f.attr('action', '/addGame');
            f.submit();
            return false;
        }
        /**
         * Engage in the game battle
         */
        function gotoEngage(gameId) {
            alert('Not coded yet');
            return false;


            let f = $('#gamesForm');
            let h = $('#gameId');
            h.val(gameId);
            f.attr('action', '/engageGame');
            f.submit();
            return false;
        }

        /**
         * Accept as an opponent to the requested game
         */
        function gotoAccept(gameId) {
            let f = $('#gamesForm');
            let h = $('#gameId');
            h.val(gameId);
            f.attr('action', '/acceptGame');
            f.submit();
            return false;
        }

        /**
         * Edit the requested game
         */
        function gotoEdit(gameId) {
            let f = $('#gamesForm');
            let h = $('#gameId');
            h.val(gameId);
            f.attr('action', '/editGame');
            f.submit();
            return false;
        }

        /**
         * Delete the game
         */
        function gotoDelete(gameId) {
            alert('Not coded yet');
            return false;


            let f = $('#gamesForm');
            let h = $('#gameId');
            h.val(gameId);
            f.attr('action', '/deleteGame');
            f.submit();
            return false;
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
