@extends('layouts.app')
@section('title') profile @parent @endsection

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
                    <div class="content">

                        <form id="gameForm" action="/updateUser" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <input type="hidden" name="userId" id="userId" value="{{$user->id}}" />

                            <table class="table is-bordered is-striped bs-form-table">
                                <tbody>
                                <tr class="">
                                    <td class="cell bs-section-title">
                                        Name:
                                    </td>
                                    <td class="cell">
                                        {{$user->name}}
                                    </td>
                                </tr>
                                <tr class="">
                                    <td class="cell bs-section-title">
                                        Email:
                                    </td>
                                    <td class="cell">
                                        {{$user->email}}
                                    </td>
                                </tr>
                                <tr class="">
                                    <td class="cell bs-section-title">
                                        Games played:
                                    </td>
                                    <td class="cell">
                                        {{$user->games_played}}
                                    </td>
                                </tr>
                                <tr class="">
                                    <td class="cell bs-section-title">
                                        Vessels destroyed:
                                    </td>
                                    <td class="cell">
                                        {{$user->vessels_destroyed}}
                                    </td>
                                </tr>
                                <tr class="">
                                    <td class="cell bs-section-title">
                                        Points scored:
                                    </td>
                                    <td class="cell">
                                        {{$user->points_scored}}
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </form>

                    </div>
                </div>
            </section>
        </div>

    </div>

@endsection
