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

                    <form id="editVerbForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="verbId" id="verbId" value="{{(isset($verb) ? $verb->id: null)}}" />
                        <input type="hidden" name="returnToVerb" id="returnToVerb" value="{{$returnToVerb}}" />
                        <input type="hidden" name="title" id="title" value="{{ $title }}" />
                        <input type="hidden" name="button" id="button" value="{{ $button  }}" />

                        <div class="form-group">
                            <table class="vocal-table">
                                <tr>
                                    <td class="vocal-table-entry">
                                        Verb infinitive
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="infinitive" id="infinitive"
                                               class="response-text" value="{{(isset($verb) ? $verb->infinitive: '')}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vocal-table-entry">
                                        Verb translated to English
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="english" id="english"
                                               class="response-text" value="{{(isset($verb) ? $verb->english: '')}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vocal-table-entry">
                                        Is the verb reflexive?
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="checkbox" name="reflexive" id="reflexive"
                                               class="response-text" value="1" {{(isset($verb) && $verb->reflexive=='1' ? 'checked': '')}} />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vocal-table-entry">
                                        Language
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="language" id="language" readonly
                                               class="response-text" value="{{(isset($verb) ? $verb->lang: '')}}" />
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
                                <button type="button" class="btn btn-default btn-vocal" onclick="updateVerb('verbForm', '{{ url('/updateVerb')}}')">
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
            $('#editVerbForm').attr("action", "{{ url('/workWithVerbs')}}").submit();
        }

        function updateVerb() {
            if (validVerb()) {
                $('#editVerbForm').attr("action", "{{ url('/updateVerb')}}").submit();
            }
        }

        function validVerb() {
            let errs = [];
            let inf = $('#infinitive').val();

            // NB Validate in reverse ordeer so that we position the cursor to the first invalid input field
            if ('' == $('#english').val()) {
                errs[errs.length] = 'English translation is required';
                $('#english').focus();
            }
            if ('' == inf) {
                errs[errs.length] = 'Verb infinitive is required';
                $('#infinitive').focus();
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
