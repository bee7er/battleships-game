@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">
        <div class="notification">
            @include('common.msgs')
            @include('common.errors')

            <section class="hero">
                <div class="hero-head">
                    <p class="title">Home</p>
                </div>
                <div class="hero-body">
                    Home page stuff here
                </div>
            </section>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">

    </script>
@endsection
