@extends('layouts.app')
@section('title') home @parent @endsection

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
                    What's it all about?
                </div>
                <div class="hero-body">
                    Who knows?
                </div>
            </section>
        </div>

    </div>

@endsection

