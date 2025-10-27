@extends('layouts.app')
@section('title') about @parent @endsection

@section('content')

    <div class="container is-fluid">
        <div class="notification">
            @include('common.msgs')
            @include('common.errors')

            <section class="hero">
                <div class="hero-head">
                    <p class="title">About Battleships</p>
                </div>
                <div class="hero-body">
                    <div class="content">
                        <h2 class="title is-3">Battleships Game Description</h2>
                        <p>Battleships is a popular guessing game played between two players.</p>
                        <p>It is a classic game of strategy and luck, requiring players to balance guessing and deduction to outmanoeuvre their opponent.</p>

                        <h3 class="title is-3">Objective</h3>
                        <p>Each player has a fleet of ships placed on a grid, and the objective is to sink all of the opponent's ships by guessing their locations.</p>

                        <h3 class="title is-3">Gameplay</h3>
                        <ol class="is-size-5">
                            <li><strong>Setup:</strong> Each player places their ships on a grid, typically 10x10 squares, without showing their opponent.</li>
                            <li><strong>Ships:</strong> The fleet consists of several ships of different sizes, usually:
                                <ul>
                                    <li>1 x Battleship (3 squares)</li>
                                    <li>2 x Submarine (2 squares)</li>
                                    <li>2 x Destroyer (2 squares)</li>
                                    <li>3 x Zodiac (1 squares)</li>
                                </ul>
                            </li>
                            <li><strong>Guessing:</strong> Players take turns calling out coordinates (e.g., A5, G7) to attack their opponent's grid.</li>
                            <li><strong>Hit or Miss:</strong> The opponent responds with "Hit" if the guess is correct, or "Miss" if it's not.</li>
                            <li><strong>Sinking a Ship:</strong> If a player hits all the squares occupied by a ship, it's considered sunk.</li>
                            <li><strong>Winning:</strong> The game ends when one player has sunk all of their opponent's ships. That player is the winner.</li>
                        </ol>
                    </div>
                </div>
            </section>
        </div>

    </div>

@endsection

