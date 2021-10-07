@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Member</div>

                <div class="card-body">
                    <form method="POST" action="{{route('member.update',[$member])}}">
                        <div class="form-group">
                            <div class="masters">Name:</div>
                            <input type="text" name="member_name" class="form-control" value="{{$member->name}}">
                        </div>
                        <div class="form-group">
                            <div class="masters">Surname:</div>
                            <input type="text" name="member_surname" class="form-control" value="{{$member->surname}}">
                        </div>
                        <div class="form-group">
                            <div class="masters">Location:</div>
                            <input type="text" name="member_live" class="form-control" value="{{$member->live}}">
                        </div>
                        <div class="form-group">
                            <div class="masters">Experience:</div>
                            <input type="text" name="member_experience" class="form-control" value="{{$member->experience}}">
                        </div>
                        <div class="form-group">
                            <div class="masters">Registration date:</div>
                            <input type="text" name="member_registered" class="form-control" value="{{$member->registered}}">
                        </div>
                        
                        
                        <select name="reservoir_id" class="masters">
                            @foreach ($reservoirs as $reservoir)
                            <span>Reservoir:</span>
                            <option class="form-control" value="{{$reservoir->id}}" @if($reservoir->id == $member->reservoir_id) selected @endif>
                                {{$reservoir->title}} ({{$reservoir->area}} km2)
                            </option>
                            @endforeach
                        </select><br><br>
                        @csrf
                        <button type="submit" class="editButton">EDIT</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
@endsection
