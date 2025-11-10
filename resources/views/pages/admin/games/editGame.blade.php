<?php
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
                            <input type="text" id="gameName" name="gameName" value="@if (isset($game->id)){{$game->name}}@endif" />
                        </td>
                    </tr>
                    <tr class="">
                        <td class="cell bs-section-title">
                            Status:
                        </td>
                        <td class="cell">
                            <select name="status" id="status" aria-label="Game status" class="bs-listbox">
                                <option value="" class="">Select status</option>
                                @if (isset($statuses) && count($statuses) > 0)
                                    @foreach($statuses as $status)
                                        <option value="{{$status}}" @if ($status == $game->status) {{'selected'}}@endif>{{$status}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr class="">
                        <td class="cell bs-section-title">
                            Protagonist:
                        </td>
                        <td class="cell">
                            <select name="protagonistId" id="protagonistId" aria-label="Game protagonist" class="bs-listbox">
                                <option value="" class="">Select protagonist</option>
                                @if (isset($users) && $users->count() > 0)
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" @if ($user->id == $game->protagonist_id) {{'selected'}}@endif>{{$user->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr class="">
                        <td class="cell bs-section-title">
                            Opponent:
                        </td>
                        <td class="cell">
                            <select name="opponentId" id="opponentId" aria-label="Game opponent" class="bs-listbox">
                                <option value="" class="">Select a new opponent</option>
                                @if (isset($users) && $users->count() > 0)
                                    @foreach($users as $user)
                                        <option value="{{$user->id}}" @if ($user->id == $game->opponent_id) {{'selected'}}@endif>{{$user->name}}</option>
                                    @endforeach
                                @endif
                            </select>
                        </td>
                    </tr>
                    <tr class="">
                        <td class="cell" colspan="2">
                            <input class="button is-pulled-right mr-6" type="submit" value="Submit input" onclick="return submitRequest();" />
                            <input class="button is-pulled-right mr-6" type="submit" value="Cancel" onclick="return cancelRequest();" />
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
            let protagonistId = $('#protagonistId');
            let opponentId = $('#opponentId');
            let status = $('#status');

            let errors = [];
            let atLeastOne = false;
            if ('' == opponentId.val()) {
                errors[errors.length] = 'Please select an opponent for this game';
                atLeastOne = true;
                opponentId.focus();
            }
            if ('' == protagonistId.val()) {
                errors[errors.length] = 'Please select a protagonist for this game';
                atLeastOne = true;
                protagonistId.focus();
            }
            if (opponentId.val() == protagonistId.val()) {
                errors[errors.length] = 'Protagonist and opponent cannot be the same user';
                atLeastOne = true;
                protagonistId.focus();
            }

            if ('' == status.val()) {
                errors[errors.length] = 'Please select a status for this game';
                atLeastOne = true;
                status.focus();
            }

            if ('' == gameName.val()) {
                errors[errors.length] = 'Please enter a name for this game';
                atLeastOne = true;
                gameName.focus();
            }

            if (atLeastOne) {
                let errMsgs = sep = "";
                // Again in reverse order so the messages are in sync with the focus
                for (let i=(errors.length - 1); i>=0; i--) {
                    errMsgs += (sep + errors[i]);
                    sep = '<br />';
                }
                $('#customErrors').html(errMsgs).show().delay(3000).fadeOut();
                return false;
            }

            f.attr('method', 'POST');
            f.attr('action', '{{env("BASE_URL", "/")}}admin/updateGame');
            f.submit();
            return false;
        }

        /**
         * Cancel request
         */
        function cancelRequest()
        {
            let f = $('#gameForm');
            f.attr('method', 'GET');
            f.attr('action', '{{env("BASE_URL", "/")}}admin/games');
            f.submit();
            return false;
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection