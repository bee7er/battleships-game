@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-2 col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Admin Page Actions
                </div>

                <div class="panel-body">
                    @include('common.errors')

                    <form id="homeForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}

                        <!-- Action Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default" onclick="workWithVerbs();">
                                    <i class="fa fa-btn fa-plus"></i>Work with verbs
                                </button>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default" onclick="workWithAdverbs();">
                                    <i class="fa fa-btn fa-plus"></i>Work with adverbs
                                </button>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-6">
                                <button type="submit" class="btn btn-default" onclick="workWithAdjectives();">
                                    <i class="fa fa-btn fa-plus"></i>Work with adjectives
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-scripts')
    <script type="text/javascript">
        function workWithVerbs() {
            $('#homeForm').attr("action", "{{ url('workWithVerbs')}}");
            $('#homeForm').submit();
        }

        function workWithAdverbs() {
            $('#homeForm').attr("action", "{{ url('workWithAdverbs')}}");
            $('#homeForm').submit();
        }

        function workWithAdjectives() {
            $('#homeForm').attr("action", "{{ url('workWithAdjectives')}}");
            $('#homeForm').submit();
        }
    </script>
@endsection
