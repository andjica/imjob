@extends('company-freelancer.template-company-freelancer')
@section('main-title', 'Chat wit Contributors')

@section('title-dash', 'Chat')
@section('css')
@endsection

@section('content')
<div class="container m-0">
    <div class="row">
        <div class="col-lg-12">
    @include('company-freelancer.components.recruitment.chat-all')
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

</script>
@endsection