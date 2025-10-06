@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="index-title">
                        Work with Adjectives
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
                        <input type="hidden" name="adjectiveId" id="adjectiveId" value="" />


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
                                        Adjective
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
                                @if(isset($adjectives) && count($adjectives)>0)
                                    @foreach($adjectives as $adjectiveEntry)
                                        <tr>
                                            <td class="vocal-table-entry">
                                                {{$adjectiveEntry->adjective}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                {{$adjectiveEntry->english}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                {{$adjectiveEntry->lang}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                <button type="submit" class="btn btn-default" onclick="editItem({{$adjectiveEntry->id}});">
                                                    <i class="fa fa-btn fa-pencil"></i>Edit
                                                </button>
                                                <button type="button" class="btn btn-default" onclick="deleteItem({{$adjectiveEntry->id}});">
                                                    <i class="fa fa-btn fa-exclamation"></i>Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="vocal-table-entry" colspan="99">
                                            No adjectives met the search criteria
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
            $('#adjectiveId').val(null);
            $('#formId').attr("action", "{{ url('/addAdjective') }}").submit();
        }

        function editItem(id) {
            $('#adjectiveId').val(id);
            $('#formId').attr("action", "{{ url('/editAdjective') }}").submit();
        }

        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this entry?')) {
                $('#adjectiveId').val(id);
                $('#formId').attr("action", "{{ url('/deleteAdjective') }}").submit();
            }
            return false;
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
            let lang = $('#languageCode').val();

            $('#formId').attr("method", 'GET');
            $('#formId').attr("action", "{{ url('/workWithAdjectives') }}/" + pos + "/" + fil).submit();
        }

        function clearSearch() {
            $('#position').val('');
            $('#filter').val('');
            $('#formId').attr("action", "{{ url('/workWithAdjectives') }}").submit();
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
