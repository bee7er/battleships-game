@extends('layouts.app')
@section('title') admin @parent @endsection

@section('content')

    <section class="container is-fluid">

        <article class="panel is-success">
            <p class="panel-heading">Admin Dashboard</p>
            @include('common.msgs')
            @include('common.errors')

            <section class="hero">
                <div class="hero-body">
                    <div class="content">
                        <div class="field">
                            <div class=""><span class="bs-table-title">Messages:</span> <span id="notification" class="bs-notification">&nbsp;</span></div>
                        </div>

                        <a href="javascript: workWithUsers();">Work with Users</a>

                    </div>
                </div>
            </section>
        </article>
    </section>

@endsection

@section('page-scripts')
    <script type="text/javascript">

        /**
         * Output a notification
         */
        function showNotification(message)
        {
            let notification = $('#notification');
            notification.html(message).show();
            notification.delay(3000).fadeOut();
        }

        function workWithUsers()
        {
            showNotification('Coming soon!');
            return true;

            let homeForm = $('#homeForm');
            homeForm.attr("action", "{{ url('workWithVerbs')}}");
            homeForm.submit();
        }
    </script>
@endsection
