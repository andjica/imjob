@extends('contributor.template-contributor')
@section('content')

    @foreach($posts as $p)
    {{$p->description}}<br>

        @if($p->image != null)
            {{$p->image}}
        @else
            
        @endif
    @endforeach
@endsection