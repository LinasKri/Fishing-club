@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-l-8 col-xl-6">
            <div class="card">
                <div class="card-header">Edit Reservoir</div>

                <div class="card-body">
                    <form method="POST" action="{{route('reservoir.update',$reservoir)}}" enctype="multipart/form-data">

                        <div class="form-group">
                            <div class="masters">Name:</div>
                            <input type="text" name="reservoir_title" class="form-control" value="{{$reservoir->title}}">
                        </div>
                        <div class="form-group">
                            <div class="masters">Runs:</div>
                            <input type="text" name="reservoir_area" class="form-control" value="{{$reservoir->area}}">
                        </div>

                        <div class="form-group">
                            <div class="small-photo">
                                @if($reservoir->photo)
                                <img src="{{$reservoir->photo}}">

                                <label style="color: white">Delete photo</label>
                                <input type="checkbox" name="delete_reservoir_photo">

                                <div class="delete_photo_control">
                                    @else
                                    <img src="{{asset('no-image.png')}}">
                                    @endif
                                    <p class="masters">Photo:</p>
                                    <input type="file" name="reservoir_photo" class="">
                                </div>
                            </div>
                        </div>
                        <div style="background-color: white">
                            <textarea name="reservoir_about" id="summernote" value="{{old('reservoir_about')}}">{{$reservoir->about}}</textarea>
                        </div><br>
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
