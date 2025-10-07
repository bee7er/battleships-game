@extends('layouts.app')
@section('title') home @parent @endsection

@section('content')

    <div class="container">
        <div class="col-sm-offset-1 col-sm-10">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ $title }}
                </div>

                <div class="panel-body">
                    @include('common.msgs')
                    @include('common.errors')

                    <form id="editAdjectiveForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="adjectiveId" id="adjectiveId" value="{{(isset($adjective) ? $adjective->id: null)}}" />
                        <input type="hidden" name="returnToAdjective" id="returnToAdjective" value="{{$returnToAdjective}}" />
                        <input type="hidden" name="title" id="title" value="{{ $title }}" />
                        <input type="hidden" name="button" id="button" value="{{ $button  }}" />

                        <div class="form-group">
                            <table class="vocal-table">
                                <tr>
                                    <td class="vocal-table-entry">
                                        Adjective
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="adjective" id="adjective"
                                               class="response-text" value="{{(isset($adjective) ? $adjective->adjective: '')}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vocal-table-entry">
                                        Adjective translated to English
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="english" id="english"
                                               class="response-text" value="{{(isset($adjective) ? $adjective->english: '')}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vocal-table-entry">
                                        Language
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="language" id="language" readonly
                                               class="response-text" value="{{(isset($adjective) ? $adjective->lang: '')}}" />
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <!-- Action Button -->
                        <div class="form-group">
                            <div style="text-align: right;padding-right: 15px;">
                                <button type="button" class="btn btn-default btn-vocal" onclick="cancelEdit()">
                                    <i class="fa fa-btn fa-home"></i>Cancel
                                </button>
                                <button type="button" class="btn btn-default btn-vocal" onclick="updateAdjective('adjectiveForm', '{{ url('/updateAdjective')}}')">
                                    <i class="fa fa-btn fa-plus"></i>{{ $button }}
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
        function cancelEdit() {
            $('#editAdjectiveForm').attr("action", "{{ url('/workWithAdjectives')}}").submit();
        }

        function updateAdjective() {
            if (validVerb()) {
                $('#editAdjectiveForm').attr("action", "{{ url('/updateAdjective')}}").submit();
            }
        }

        function validVerb() {
            let errs = [];
            let adv = $('#adjective').val();

            // NB Validate in reverse ordeer so that we position the cursor to the first invalid input field
            if ('' == $('#english').val()) {
                errs[errs.length] = 'English translation is required';
                $('#english').focus();
            }
            if ('' == adv) {
                errs[errs.length] = 'Adjective is required';
                $('#adjective').focus();
            }

            if (0 < errs.length) {
                let msgs = '';
                let sep = '';
                // Build error msgs in reverse order so we position the cursor to the first invalid field
                for(let i=(errs.length - 1); i>=0; i--) {
                    msgs += (sep + errs[i]);
                    sep = "\n";
                }

                alert(msgs);

                return false;
            }
            return true;
        }

        $(document).ready( function()
        {

        });
    </script>
@endsection
