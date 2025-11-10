<?php
use App\FleetVessel;
use App\Game;
?>

@extends('layouts.app')
@section('title') edit game @parent @endsection

@section('content')

    <div class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">@if (isset($game->id)){{'Edit Game'}}@else{{'Add Game'}}@endif</p>
            @include('common.msgs')
            @include('common.errors')

            <form id="gameForm" action="{{env("BASE_URL", "/")}}updateGame" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <input type="hidden" name="gameId" id="gameId" value="{{$game->id}}" />

                <table class="table is-bordered is-striped bs-form-table">
                    <tbody>
                        <tr class="">
                            <td class="cell bs-section-title" colspan="2">
                                <div class="cell bs-errors" id="customErrors"></div>
                            </td>
                        </tr>
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
                                Game name:
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

            let errors = [];
            let atLeastOne = false;
            if ('' == gameName.val()) {
                errors[errors.length] = 'Please enter a name for this game';
                atLeastOne = true;
                gameName.focus();
            }

            if ('' == opponentId.val()) {
                errors[errors.length] = 'Please select an opponent for this game';
                atLeastOne = true;
                opponentId.focus();
            }
            if (atLeastOne) {
                let errMsgs = sep = "";
                for (let i=0; i<errors.length; i++) {
                    errMsgs += (sep + errors[i]);
                    sep = '<br />';
                }
                let ce = $('#customErrors');
                ce.html(errMsgs).show().delay(3000).fadeOut();
                return false;
            }

            f.attr('action', '{{env("BASE_URL", "/")}}updateGame');
            f.submit();
            return false;
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection