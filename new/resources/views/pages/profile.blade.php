@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">
        <div class="notification">
            @include('common.msgs')
            @include('common.errors')

            <section class="hero">
                <div class="hero-head">
                    <p class="title">Profile</p>
                </div>
                <div class="hero-body">
                    Your stuff here
                </div>
                <div class="hero-body">
                    And here
                </div>
            </section>
        </div>

    </div>

@endsection
