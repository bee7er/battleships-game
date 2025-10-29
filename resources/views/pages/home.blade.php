@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <section class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">Why Battleships?</p>
            @include('common.msgs')
            @include('common.errors')
            <input type="hidden" id="userToken" value="{{$userToken}}" />

            <section class="hero">
                <div class="hero-body">
                    <div class="content">
                        <p>The inspiration for writing this game came from a visit to the Newhaven Fort, on the south side of Newhaven, known as Seahaven. The fort recently had a major facelift and I took two of my grandsons there on a day trip to enjoy its many attractions.</p>

                        <p>One such attraction was an animated version of Battleships, which my grandsons very much enjoyed.  I thought it would be fun to write an online version of the game for them to play against each other.</p>

                        <p>I've probably spent too much time writing this version of the game, as it is more complicated than it might seem, given how easy it is to play the manual/verbal version using pieces of paper to record the location of the fleet.</p>

                        <p>Plus, it looks as though the boys have moved on to K-pop Demon Hunters.</p>

                        <p>Anyway, it was fun writing it and I hope there aren't any major bugs.</p>
                    </div>
                </div>
            </section>
        </article>
    </section>

@endsection

@section('page-scripts')
    <script type="text/javascript">
        $(document).ready( function()
        {
            setCookie('user_token', $('#userToken').val(), 1);
        });
    </script>
@endsection
