@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-sm-10 col-md-10 col-lg-8 col-xl-7">
            <div class="card">
                <div class="card-header">List of Members</div>
                <form action="{{route('member.index')}}" method="get" class="sort-form">

                    <fieldset>
                        <legend>Sort by:</legend>
                        <label>Surname</label><input type="radio" name="sort_by" value="surname" @if($sort=='surname' ) checked @endif>
                        <label>Name</label><input type="radio" name="sort_by" value="name" @if($sort=='name' ) checked @endif>
                    </fieldset>
                    <fieldset>
                        <legend>Direction:</legend>
                        <label>Asc</label><input type="radio" name="dir" value="asc" @if($dir=='asc' ) checked @endif>
                        <label>Desc</label><input type="radio" name="dir" value="desc" @if($dir=='desc' ) checked @endif>
                    </fieldset>
                    <button type="submit" class="enterButton">Sort</button>
                    <a href="{{route('member.index')}}" class="enterButton">Clear</a>
                </form>

                <form action="{{route('member.index')}}" method="get" class="sort-form">
                    <fieldset>
                        <legend>Filter by:</legend>
                        <select name="reservoir_id" class="masters">
                            @foreach ($reservoirs as $reservoir)
                            <option value="{{$reservoir->id}}" @if($defaultReservoir==$reservoir->id) selected @endif>
                                {{$reservoir->title}}
                            </option>
                            @endforeach
                        </select>
                    </fieldset>
                    <button type="submit" class="enterButton">Filter</button>
                    <a href="{{route('member.index')}}" class="enterButton">Clear</a>
                </form>

                <form action="{{route('member.index')}}" method="get" class="sort-form">
                    <fieldset>
                        <legend>Search by Member:</legend>
                        <input type="text" name="s" class="masters" value="{{$s}}" placeholder="Search">
                    </fieldset>
                    <button type="submit" name="do_search" value="1" class="enterButton">Search</button>
                    <a href="{{route('member.index')}}" class="enterButton">Clear</a>
                </form>

                <div class="card-body card-extra">

                    @forelse ($members as $member)
                    <div class="res_list" style="padding: 15px">
                        {{-- <div class="info_block"> --}}
                        <div class="masters">{{$member->name}} {{$member->surname}}</div>
                        <span style="color: white">Reservoir: {{$member->memberReservoir->title}} ({{$member->memberReservoir->area}} km2)</span>
                        {{-- </div> --}}
                        <div class="index_btns">
                            <form method="POST" action="{{route('member.destroy', [$member])}}">
                                <a href="{{route('member.edit',[$member])}}" class="editButton">EDIT</a>
                                @csrf
                                <button type="submit" class="deleteButton">DELETE</button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <h3>No results found </h3>
                    @endforelse
                </div>
            </div>
            <div class="pager-links col-md-8">
                {{ $members->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
