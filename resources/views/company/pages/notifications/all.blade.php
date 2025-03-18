@extends('company.template-company')
@section('css')
<style>
    .background-image {
        background: url("{{ asset('images/card-company-info.svg') }}") no-repeat 250px;
        
        font-family: 'Arial', sans-serif;
         /* Ensure it covers the full height of the viewport */
        
   
        justify-content: center;
        align-items: center;
    }
    .border-danger
    {
        border:1px solid red !important;
    }
   
</style>
@endsection
@section('content')
<div class="container">
  
</div>

@endsection
