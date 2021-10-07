@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">New Reservoir</div>

                <div class="card-body">
                    <form method="POST" action="{{route('reservoir.store')}}" enctype="multipart/form-data">

                        <div class="form-group">
                            <p class="masters">Title:</p>
                            <input type="text" name="reservoir_title" class="form-control" placeholder="Enter Title here" value="{{old('reservoir_name')}}">
                        </div>
                        <div class="form-group">
                            <p class="masters">Reservoir Area:</p>
                            <input type="text" name="reservoir_area" class="form-control" placeholder="Enter Area size" value="{{old('reservoir_runs')}}">
                        </div>

                        <div class="form-group">
                            <p class="masters">Photo:</p>
                            <input type="file" name="reservoir_photo">
                        </div>
                        <div style="background-color: white">
                            <textarea name="reservoir_about" id="summernote" value="{{old('reservoir_about')}}"></textarea>
                        </div><br>
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
