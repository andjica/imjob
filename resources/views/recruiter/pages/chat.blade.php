@extends('recruiter.template-recruiter')
@section('main-title', 'Chat with Contributor')

@section('title-dash', 'Chat')
@section('css')
@endsection

@section('content')
<div class="container m-0">
    <div class="row">
        <div class="col-lg-12">
            @include('recruiter.components.recruitment.chat')
        </div>
    </div>
</div>
@endsection

@section('js')
<script>

</script>
@endsection