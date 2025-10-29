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
                            <li><strong>Setup:</strong> Each player places their ships on a grid, which consists of 10x10 squares, without showing their opponent.</li>
                            <li><strong>Ships:</strong> The fleet consists of several ships of different sizes:
                                <ul>
                                    <li>1 x Battleship (3 squares)</li>
                                    <li>2 x Submarine (2 squares)</li>
                                    <li>2 x Destroyer (2 squares)</li>
                                    <li>3 x Zodiac (1 squares)</li>
                                </ul>
                            </li>
                            <li><strong>Guessing:</strong> Players take turns firing virtual missiles at coordinates (e.g., A5, G7) to attack their opponent's grid.</li>
                            <li><strong>Hit or Miss:</strong> The opponent's grid shows where the missile hit and the effect it had.</li>
                            <li><strong>Sinking a Ship:</strong> If a player hits all the squares occupied by a ship, it's considered sunk.</li>
                            <li><strong>Winning:</strong> The game ends when one player has sunk all of their opponent's ships. That player is the winner.</li>
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

                        <h4 class="title is-5">What just happened?</h4>
                        <p>When the game is over, it is set to <span class="has-text-link">completed</span>.  Use the <span class="has-text-link">Replay</span> link to see a simulation of how the game progressed.</p>
                        <p>The destruction of vessels and the points scored are accumulated in your profile.</p>
                        <p>Go to the <span class="has-text-link">Leaderboard</span> page to see how your performances compare with others.</p>
                        <h4 class="title is-5">Have fun!</h4>
                    </div>
                </div>
            </section>
        </article>
    </section>

@endsection

