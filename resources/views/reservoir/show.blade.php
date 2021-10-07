@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$reservoir->title}}</div>

                <div class="card-body">
                    <div class="masters">
                        <small>Reservoir title: {{$reservoir->title}}</small>
                    </div>
                    <div class="masters">
                        <small>Area:{{$reservoir->arae}}</small>
                    </div>
                    <div class="masters">
                        <small>Member count:{{$reservoir->reservoirHasMembers->count()}}</small>
                    </div>
                    <div class="masters" >
                        <small>About:{!!$reservoir->about!!}</small>
                    </div>
                    <a href="{{route('reservoir.edit',[$reservoir])}}" class="editButton">EDIT</a>
                    <a href="{{route('reservoir.pdf',[$reservoir])}}" class="editButton">Download PDF</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
