@extends('layouts.app')
@section('title') leaderboard @parent @endsection

@section('content')

    <div class="container is-fluid">
        <div class="notification">
            @include('common.msgs')
            @include('common.errors')

            <section class="hero">
                <div class="hero-head">
                    <p class="title">Leaderboard</p>
                </div>
                <div class="hero-body">
                    <div class="content">
                        Follow the leaders
                    </div>
                </div>
            </section>
        </div>

    </div>

@endsection

