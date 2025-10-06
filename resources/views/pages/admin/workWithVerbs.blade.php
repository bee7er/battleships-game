@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="index-title">
                        Work with Verbs
                    </div><div class="index-action">
                        <button type="submit" class="btn btn-default" onclick="addItem();">
                            <i class="fa fa-btn fa-plus"></i>Add
                        </button>
                    </div>
                </div>

                <div class="panel-body">
                    @include('common.msgs')
                    @include('common.errors')

                    <form id="formId" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="verbId" id="verbId" value="" />


                        <div class="">
                            <div class="">Position to: <input type="text" class="input-position" name="position" id="position" value="{{$position}}" />
                            Filter: <input type="text" class="input-filter" name="filter" id="filter" value="{{$filter}}" />
                                <button type="submit" class="btn btn-default input-position" onclick="clearSearch();">
                                    <i class="fa fa-btn fa-question"></i>Clear
                                </button>
                            <button type="submit" class="btn btn-default input-position" onclick="searchData();">
                                <i class="fa fa-btn fa-question"></i>Search
                            </button></div>
                        </div>

                        <div class="form-group">
                            <table class="vocal-table">
                                <tr>
                                    <th class="vocal-table-header">
                                        Verb
                                    </th>
                                    <th class="vocal-table-header">
                                        English
                                    </th>
                                    <th class="vocal-table-header">
                                        Language
                                    </th>
                                    <th class="vocal-table-header">
                                        Action
                                    </th>
                                </tr>
                                @if(isset($verbs) && count($verbs)>0)
                                    @foreach($verbs as $verbEntry)
                                        <tr>
                                            <td class="vocal-table-entry">
                                                {{$verbEntry->infinitive}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                {{$verbEntry->english}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                {{$verbEntry->lang}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                <button type="submit" class="btn btn-default" onclick="editItem({{$verbEntry->id}});">
                                                    <i class="fa fa-btn fa-pencil"></i>Edit
                                                </button>
                                                <button type="button" class="btn btn-default" onclick="deleteItem({{$verbEntry->id}});">
                                                    <i class="fa fa-btn fa-exclamation"></i>Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="vocal-table-entry" colspan="99">
                                            No verbs met the search criteria
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div style="text-align: right;padding-right: 15px;">
                                <button type="button" class="btn btn-default btn-vocal" onclick="gotoUrl('formId', '{{ url('/admin')}}')">
                                    <i class="fa fa-btn fa-home"></i>Home
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
        function addItem() {
            $('#verbId').val(null);
            $('#formId').attr("action", "{{ url('/addVerb') }}").submit();
        }

        function editItem(id) {
            $('#verbId').val(id);
            $('#formId').attr("action", "{{ url('/editVerb') }}").submit();
        }

        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this entry?')) {
                $('#verbId').val(id);
                $('#formId').attr("action", "{{ url('/deleteVerb') }}").submit();
            }
        }

        function searchData() {
            let pos = $('#position').val();
            if ('' == pos) {
                pos = '%20';
            }
            let fil = $('#filter').val();
            if ('' == fil) {
                fil = '%20';
            }

            $('#formId').attr("method", 'GET');
            $('#formId').attr("action", "{{ url('/workWithVerbs') }}/" + pos + "/" + fil).submit();
        }

        function clearSearch() {
            $('#position').val('');
            $('#filter').val('');
            $('#formId').attr("action", "{{ url('/workWithVerbs') }}").submit();
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
