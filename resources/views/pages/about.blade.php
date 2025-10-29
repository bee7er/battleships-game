@extends('layouts.app')
@section('title') about @parent @endsection

@section('content')

    <section class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">About Battleships</p>
            @include('common.msgs')
            @include('common.errors')

            <section class="hero">
                <div class="hero-body">
                    <div class="content">
                        <h2 class="title is-4">Battleships Game Description</h2>
                        <p>Battleships is a popular guessing game played between two players.</p>
                        <p>It is a classic game of strategy and luck, requiring players to balance guessing and deduction to outmanoeuvre their opponent.</p>

                        <h3 class="title is-4">Objective</h3>
                        <p>Each player has a fleet of ships placed on a grid, and the objective is to sink all of the opponent's ships by guessing their locations.</p>

                        <h3 class="title is-4">Gameplay</h3>
                        <ol class="is-4">
                            <li><b>Setup:</b> Each player places their ships on a grid, which consists of 10x10 squares, without showing their opponent.</li>
                            <li><b>Ships:</b> The fleet consists of several ships of different sizes:
                                <ul>
                                    <li>1 x Battleship (3 squares)</li>
                                    <li>2 x Submarine (2 squares)</li>
                                    <li>2 x Destroyer (2 squares)</li>
                                    <li>3 x Zodiac (1 squares)</li>
                                </ul>
                            </li>
                            <li><b>Guessing:</b> Players take turns firing virtual missiles at coordinates (e.g., A5, G7) to attack their opponent's grid.</li>
                            <li><b>Hit or Miss:</b> The opponent's grid shows where the missile hit and the effect it had.</li>
                            <li><b>Sinking a Ship:</b> If a player hits all the squares occupied by a ship, it's considered sunk.</li>
                            <li><b>Winning:</b> The game ends when one player has sunk all of their opponent's ships. That player is the winner.</li>
                        </ol>

                        <h3 class="title is-4">How to play</h3>

                        <h4 class="title is-5">My Games</h4>
                        <p>Go to page <span class="has-text-link">My Games</span> to view available games which you have created or where you have been invited to play by an opponent.</p>
                        <p>Click on the <span class="has-text-link">Add Game</span> link to create a new game.</p>
                        <p>Give the game a name, so that it can be identified among all the others and choose an opponent from the list of other players.</p>
                        <p>Edit the grid by selecting a vessel and plotting it on the grid where appropriate.</p>
                        <p>To distribute the vessels randomly on the grid use the <span class="has-text-link">Go Random</span> button.  Click <span class="has-text-link">Save Random</span>, when a distribution you like is achieved.</p>
                        <p>Click <span class="has-text-link">Accept</span> against a game to which you have been invited.</p>
                        <p>When both the game owner and opponent have completed editing their grid the game is ready to play.</p>
                        <p>Click <span class="has-text-link">Engage</span> to play the game.</p>
                        <p>The winner is the player who first destroys all the opponent's fleet vessels.</p>

                        <h4 class="title is-5">Game Status</h4>
                        <p>Each game goes through a number of statuses (stati?) depending on the actions of the players.</p>
                        <ol class="is-4">
                            <li><b>New:</b> The initial status of a game.  Click <span class="has-text-link">Accept</span> to start editing as an opponent.</li>
                            <li><b>Edit:</b> When each player is in the process of editing the game. Click <span class="has-text-link">Edit grid</span> to plot vessels.</li>
                            <li><b>Waiting:</b> When one of the players has plotted all their vessels; waiting for the opponent to plot theirs.</li>
                            <li><b>Ready:</b> When both players have plotted all their vessels. Each player clicks <span class="has-text-link">Engage</span> to start playing.</li>
                            <li><b>Engaged:</b> When the game is being played.</li>
                            <li><b>Completed:</b> When the game has been won by one of the players. Click <span class="has-text-link">Replay</span> to see a simulation of the game. Click <span class="has-text-link">Delete</span> to remove the game from the list (a soft delete).</li>
                        </ol>

                        <h4 class="title is-5">What just happened?</h4>
                        <p>As mentioned above, when the game is over, it is set to <span class="has-text-link">completed</span> and the <span class="has-text-link">Replay</span> link can be used to see a simulation of how the game progressed. Use this option to improve your strategy when playing next time.  You will have noticed that vessels can be plotted vertically, horizontally and diagonally. You should bear this in mind while deciding on your next move.  When replaying the game you get to see the full distribution of your opponent's vessels, and can perhaps see opportunities you missed during the game.</p>
                        <p>The destruction of vessels and the points scored are accumulated in your profile.</p>
                        <p>Go to the <span class="has-text-link">Leaderboard</span> page to see how your performances compare with others.</p>

                        <h4 class="title is-5">Have fun!</h4>
                    </div>
                </div>
            </section>
        </article>
    </section>

@endsection

