@extends('contributor.template-contributor')
@section('content')
    <div class="container m-0">
        <div class="row">
            @foreach ($posts as $p)
                <div class="col-lg-5">
                    <div class="card shadow-sm border mt-2">
                        <div class="card-body">
                            {{ $p->description }}<br>

                            @if ($p->image != null)
                                <img src={{ $p->image }} alt={{ $p->image }} />
                            @else
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
