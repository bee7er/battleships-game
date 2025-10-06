<?php
use App\Game;
?>

@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">
        @include('common.msgs')
        @include('common.errors')

        <div class="bs-add-link is-pulled-right" title="Add a new game"><a href="">Add Game</a></div>

        <form id="gamesForm" action="/editGame" method="POST" class="form-horizontal">
            <input type="hidden" name="gameId" id="gameId" value="" />

            <table class="table is-fullwidth is-bordered is-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Opponent</th>
                    <th>Status</th>
                    <th>Started at</th>
                    <th>Ended at</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Opponent</th>
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
                        <td>{{$game->opponent_name}}</td>
                        <td>{{$game->status}}</td>
                        <td>{{$game->started_at}}</td>
                        <td>{{$game->ended_at}}</td>
                        <td>
                            @if ($game->status == Game::STATUS_EDIT || $game->status == Game::STATUS_READY)
                                <div title="Edit the game"><a href="javascript: gotoEdit({{$game->id}})">Edit</a></div>
                            @endif
                            <div title="Delete the game"><a href="">Delete</a></div>
                            @if ($game->status == Game::STATUS_WINNER || $game->status == Game::STATUS_LOSER)
                                    <div title="Run simulation"><a href="">Run</a></div>
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
         * Edit the requested game
         */
        function gotoEdit(gameId) {
            let f = $('#gamesForm');
            let h = $('#gameId');
            h.val(gameId);
            f.submit();
            return false;
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
