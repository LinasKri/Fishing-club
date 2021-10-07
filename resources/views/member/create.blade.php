@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Member</div>

                <div class="card-body">
                    <form method="POST" action="{{route('member.store')}}">
                        <div class="form-group form_group_extra">
                            <span class="masters form_span">Name:</span>
                            <input type="text" name="member_name" class="form_input" placeholder="Enter here" value="{{old('member_name')}}">

                            <span class="masters form_span">Surname:</span>
                            <input type="text" name="member_surname" class="form_input" placeholder="Enter here" value="{{old('member_surname')}}">
                        </div><br>
                        <div class="form-group form_group_extra">
                            <span class="masters form_span">Location:</span>
                            <input type="text" name="member_live" class="form_input" placeholder="Enter here" value="{{old('member_bet')}}">

                            <span class="masters form_span">Experience:</span>
                            <input type="text" name="member_experience" class="form_input" placeholder="Enter here" value="{{old('member_bet')}}">
                        </div>
                        <div class="form-group form_group_extra">
                            <span class="masters form_span">Register year:</span>
                            <input type="text" name="member_registered" class="form_input" placeholder="Enter here" value="{{old('member_bet')}}">
                        </div>

                        <select name="reservoir_id" class="masters form_group_extra">
                            @foreach ($reservoirs as $reservoir)
                            <option value="{{$reservoir->id}}">{{$reservoir->title}} (Area: {{$reservoir->area}})</option>
                            @endforeach
                        </select><br><br>
                        @csrf
                        <button type="submit" class="enterButton">ADD</button>
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
