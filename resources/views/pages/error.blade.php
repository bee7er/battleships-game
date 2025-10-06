@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container is-fluid">
        <div class="notification">

            <section class="hero">
                <div class="hero-head">
                    <p class="title">Whoops Something Went Wrong!</p>
                </div>
                <div class="hero-body">
                    <form id="errorForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <div class="field is-grouped">
                            <div class="control">
                                Sorry, you need to be logged in to access that page
                            </div>
                        </div>

                        <div class="field is-grouped">
                            <div class="control">
                                <button class="button is-link is-light" onclick="gotoUrl('errorForm', '/home')">Continue ...</button>
                            </div>
                        </div>

                    </form>
                </div>
            </section>
        </div>

    </div>

@endsection

