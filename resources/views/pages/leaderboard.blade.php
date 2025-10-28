@extends('layouts.app')
@section('title') leaderboard @parent @endsection

@section('content')

    <div class="container is-fluid">
        @include('common.msgs')
        @include('common.errors')

        <div class="bs-add-link is-pulled-right" title="Add a new game">
            <a class="bs-games-button" href="javascript: location.reload();">Refresh</a>
        </div>

        <form id="gamesForm" action="/" method="GET" class="form-horizontal">

            <table class="table is-fullwidth is-bordered is-striped">
                <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Games Played</th>
                    <th>Vessels Destroyed</th>
                    <th>Points Scored</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Games Played</th>
                    <th>Vessels Destroyed</th>
                    <th>Points Scored</th>
                    <th>Action</th>
                </tr>
                </tfoot>
                <tbody>

                @if (isset($users) && $users->count() > 0)
                    @foreach($users as $user)
                        <tr>
                            <td>{{$user->id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->games_played}}</td>
                            <td>{{$user->vessels_destroyed}}</td>
                            <td>{{$user->points_scored}}</td>
                            <td><div title="User profile"><a class="bs-games-button" href="javascript: location.href='/profile?userId={{$user->id}}'">User profile</a></div></td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td class="bs-no-data" colspan="99">No users found</td>
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
         * Engage in the game battle
         */
        function gotoProfile(userId) {
            location. '/playGrid');
            f.submit();
            return false;
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
