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

                    <form id="editAdverbForm" action="" method="POST" class="form-horizontal">
                        {{ csrf_field() }}
                        <input type="hidden" name="adverbId" id="adverbId" value="{{(isset($adverb) ? $adverb->id: null)}}" />
                        <input type="hidden" name="returnToAdverb" id="returnToAdverb" value="{{$returnToAdverb}}" />
                        <input type="hidden" name="title" id="title" value="{{ $title }}" />
                        <input type="hidden" name="button" id="button" value="{{ $button  }}" />

                        <div class="form-group">
                            <table class="vocal-table">
                                <tr>
                                    <td class="vocal-table-entry">
                                        Adverb
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="adverb" id="adverb"
                                               class="response-text" value="{{(isset($adverb) ? $adverb->adverb: '')}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vocal-table-entry">
                                        Adverb translated to English
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="english" id="english"
                                               class="response-text" value="{{(isset($adverb) ? $adverb->english: '')}}" />
                                    </td>
                                </tr>
                                <tr>
                                    <td class="vocal-table-entry">
                                        Language
                                    </td>
                                    <td class="vocal-table-entry">
                                        <input type="text" name="language" id="language" readonly
                                               class="response-text" value="{{(isset($adverb) ? $adverb->lang: '')}}" />
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
                                <button type="button" class="btn btn-default btn-vocal" onclick="updateAdverb('adverbForm', '{{ url('/updateAdverb')}}')">
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
            $('#editAdverbForm').attr("action", "{{ url('/workWithAdverbs')}}").submit();
        }

        function updateAdverb() {
            if (validVerb()) {
                $('#editAdverbForm').attr("action", "{{ url('/updateAdverb')}}").submit();
            }
        }

        function validVerb() {
            let errs = [];
            let adv = $('#adverb').val();

            // NB Validate in reverse ordeer so that we position the cursor to the first invalid input field
            if ('' == $('#english').val()) {
                errs[errs.length] = 'English translation is required';
                $('#english').focus();
            }
            if ('' == adv) {
                errs[errs.length] = 'Adverb is required';
                $('#adverb').focus();
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
