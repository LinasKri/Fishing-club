@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-12 col-md-10 col-lg-8 col-xl-8">
            <div class="card">
                <div class="card-header">List of Reservoirs</div>
                <form action="{{route('reservoir.index')}}" method="get" class="sort-form" style="place-content: center">
                    <fieldset>
                        <legend>Sort by:</legend>
                        <label>Title</label>
                        <input type="radio" class="masters" name="sort_by" value="title" @if($sort=='title' ) checked @endif>
                        <label>Area</label>
                        <input type="radio" class="masters" name="sort_by" value="area" @if($sort=='area' ) checked @endif>
                    </fieldset>
                    <fieldset>
                        <legend>Direction:</legend>
                        <label>Asc</label><input type="radio" name="dir" value="asc" @if($dir=='asc' ) checked @endif>
                        <label>Desc</label><input type="radio" name="dir" value="desc" @if($dir=='desc' ) checked @endif>
                    </fieldset>
                    <button type="submit" class="enterButton">Sort</button>
                    <a href="{{route('reservoir.index')}}" class="enterButton">Clear</a>
                </form>
                <div class="card-body card-extra">
                    <ul>
                        @foreach ($reservoirs as $reservoir)
                        <div class="res_list">
                            <div class="photo">
                                @if($reservoir->photo)
                                <img src="{{$reservoir->photo}}">
                                @else
                                <img src="{{asset('no-image.png')}}">
                                @endif
                            </div>
                            <div class="nearPhoto">
                                <div>
                                    <div class="masters" style="font-weight: bold">
                                        Reservoir:
                                        {{$reservoir->title}}
                                    </div><br>
                                    <span style="color: white">
                                        (Area: {{$reservoir->area}} km2 |
                                        Member count: {{$reservoir->reservoirHasMembers->count()}})
                                    </span>
                                </div>
                                <form method="POST" action="{{route('reservoir.destroy', $reservoir)}}">
                                    <a href="{{route('reservoir.show',[$reservoir])}}" class="editButton">More info</a>
                                    <a href="{{route('reservoir.edit',[$reservoir])}}" class="editButton">EDIT</a>
                                    @csrf
                                    <button type="submit" class="deleteButton">DELETE</button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                        <br>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
