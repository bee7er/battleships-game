@extends('layouts.app')
@section('title') login @parent @endsection

@section('content')

    <section class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">Login</p>
            @include('common.msgs')
            @include('common.errors')

            <section class="hero">
                <div class="hero-body">
                    <div class="content">

                        <form id="loginForm" action="{{env("BASE_URL", "/")}}auth/login" method="POST" class="form-horizontal">
                            {{ csrf_field() }}

                            <div class="field">
                                <label class="label">Email</label>
                                <div class="control">
                                    <input class="input is-success" type="email" placeholder="Email input" name="email" id="email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="field">
                                <label class="label">Password</label>
                                <div class="control">
                                    <input class="input" type="password" name="password" id="password" placeholder="Password" />
                                </div>
                            </div>

                            <div class="field">
                                <div class="control">
                                    <input type="checkbox" name="remember" id="remember"> Remember Me
                                </div>
                            </div>

                            <div class="field is-grouped">
                                <div class="control">
                                    <button type="submit" class="button is-link">Submit</button>
                                </div>
                                <div class="control">
                                    <button class="button is-link is-light" onclick="gotoUrl('loginForm', '{{env("BASE_URL", "/")}}home')">Cancel</button>
                                </div>
                            </div>

                        </form>

                    </div>
                </div>
            </section>
        </article>
    </section>

@endsection



@section('content')

    <div class="container is-max-desktop">
        <div class="notification">
            @include('common.msgs')
            @include('common.errors')

            <form id="loginForm" action="{{env("BASE_URL", "/")}}auth/login" method="POST" class="form-horizontal">
                {{ csrf_field() }}

                <div class="field">
                    <label class="label">Email</label>
                    <div class="control">
                        <input class="input is-success" type="email" placeholder="Email input" name="email" id="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="field">
                    <label class="label">Password</label>
                    <div class="control">
                        <input class="input" type="password" name="password" id="password" placeholder="Password" />
                    </div>
                </div>

                <div class="field">
                    <div class="control">
                        <input type="checkbox" name="remember" id="remember"> Remember Me
                    </div>
                </div>

                <div class="field is-grouped">
                    <div class="control">
                        <button type="submit" class="button is-link">Submit</button>
                    </div>
                    <div class="control">
                        <button class="button is-link is-light" onclick="gotoUrl('loginForm', '{{env("BASE_URL", "/")}}home')">Cancel</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">

    </script>
@endsection
