@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="index-title">
                        Work with Adverbs
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
                        <input type="hidden" name="adverbId" id="adverbId" value="" />


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
                                        Adverb
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
                                @if(isset($adverbs) && count($adverbs)>0)
                                    @foreach($adverbs as $adverbEntry)
                                        <tr>
                                            <td class="vocal-table-entry">
                                                {{$adverbEntry->adverb}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                {{$adverbEntry->english}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                {{$adverbEntry->lang}}
                                            </td>
                                            <td class="vocal-table-entry">
                                                <button type="submit" class="btn btn-default" onclick="editItem({{$adverbEntry->id}});">
                                                    <i class="fa fa-btn fa-pencil"></i>Edit
                                                </button>
                                                <button type="button" class="btn btn-default" onclick="deleteItem({{$adverbEntry->id}});">
                                                    <i class="fa fa-btn fa-exclamation"></i>Delete
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td class="vocal-table-entry" colspan="99">
                                            No adverbs met the search criteria
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
            $('#adverbId').val(null);
            $('#formId').attr("action", "{{ url('/addAdverb') }}").submit();
        }

        function editItem(id) {
            $('#adverbId').val(id);
            $('#formId').attr("action", "{{ url('/editAdverb') }}").submit();
        }

        function deleteItem(id) {
            if (confirm('Are you sure you want to delete this entry?')) {
                $('#adverbId').val(id);
                $('#formId').attr("action", "{{ url('/deleteAdverb') }}").submit();
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
            $('#formId').attr("action", "{{ url('/workWithAdverbs') }}/" + pos + "/" + fil).submit();
        }

        function clearSearch() {
            $('#position').val('');
            $('#filter').val('');
            $('#formId').attr("action", "{{ url('/workWithAdverbs') }}").submit();
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
