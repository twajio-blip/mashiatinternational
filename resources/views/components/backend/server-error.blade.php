@props(['form_id', 'request_form'])
<!-- Laravel Javascript Validation -->
<script src="{{ asset('vendor/jsvalidation/js/jsvalidation.js') }}"></script>
{!! JsValidator::formRequest("App\Http\Requests\\$request_form", "#$form_id") !!}


 