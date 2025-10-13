<?php
use App\FleetVessel;
use App\Game;
?>

@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">@if (isset($game->id)){{'Edit Game'}}@else{{'Add Game'}}@endif</p>
            @include('common.msgs')
            @include('common.errors')

            <form id="gameForm" action="/updateGame" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <input type="hidden" name="gameId" id="gameId" value="{{$game->id}}" />

                <table class="table is-bordered is-striped bs-form-table">
                    <tbody>
                        <tr class="">
                            <td class="cell bs-section-title">
                                Game status:
                            </td>
                            <td class="cell bs-status" id="gameStatus">
                                @if (isset($game->id))
                                    {{ucfirst($game->status)}}
                                @else
                                    New
                                @endif
                            </td>
                        </tr>
                        <tr class="">
                            <td class="cell bs-section-title">
                                Name:
                            </td>
                            <td class="cell">
                                <input type="text" id="gameName" name="gameName" value="@if (isset($game->id)){{ucfirst($game->name)}}@endif" />
                            </td>
                        </tr>
                        <tr class="">
                            <td class="cell bs-section-title">
                                Protagonist:
                            </td>
                            <td class="cell">
                                {{ucfirst($user->name)}}
                            </td>
                        </tr>
                        @if (isset($game->id))
                            <tr class="">
                                <td class="cell bs-section-title">
                                    Your Opponent:
                                </td>
                                <td class="cell">
                                    <input type="hidden" id="opponentId" value="{{$game->opponent_id}}" />
                                    {{ucfirst($opponent->name)}}
                                </td>
                            </tr>
                        @else
                            <tr class="">
                                <td class="cell bs-section-title">
                                    Choose Your Opponent
                                </td>
                                <td class="cell">
                                    <select name="opponentId" id="opponentId" aria-label="Game opponent" class="bs-listbox">
                                        <option value="" class="">Select a new opponent</option>
                                        @if (isset($users) && $users->count() > 0)
                                            @foreach($users as $user)
                                                    <option value="{{$user->id}}" @if ($user->id == $game->opponent_id) {{'selected'}}@endif>{{ucfirst($user->name)}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </td>
                            </tr>
                        @endif
                        <tr class="">
                            <td class="cell" colspan="2">
                                <input class="button is-pulled-right mr-6" type="submit" value="Submit input" onclick="return submitRequest();" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>

        </article>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">
        /**
         * Validate the form and submit the add request
         */
        function submitRequest()
        {
            let f = $('#gameForm');
            let gameName = $('#gameName');
            let opponentId = $('#opponentId');

            let errorMsg = false;
            if ('' == gameName.val()) {
                alert('Please enter a name for this game');
                gameName.focus();
                errorMsg = true;
            }

            if ('' == opponentId.val()) {
                alert('Please select an opponent for this game');
                opponentId.focus();
                errorMsg = true;
            }
            if (true == errorMsg) {
                return false;
            }

            f.attr('action', '/updateGame');
            f.submit();
            return false;
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection