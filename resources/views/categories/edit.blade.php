@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card">

                    <div class="card-header bg-danger text-white">
                        @include('components.go-to-index')
                        {{ __('Edit Category') }}
                    </div>

                    <div class="card-body">

                        <form method ="POST" action="{{ route("categories.update", $category->id) }}">

                            {{csrf_field()}}

                            {{ method_field("PUT") }}

                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" value="{{ $category->name }}">
                            </div>

                            <div class="form-group mt-2">
                                    <textarea class="form-control" name="description" rows="8">
                                        {{ $category->description }}
                                    </textarea>
                            </div>

                            <button class="btn btn-primary mt-2" type="Submit" >Edit Category</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
