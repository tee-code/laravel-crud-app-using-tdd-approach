@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card">

                    <div class="card-header bg-danger text-white">
                        @include('components.go-to-index')
                        {{ __('Create Category') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("categories.store") }}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter category name">
                            </div>
                            <div class="form-group mt-2">
                                    <textarea class="form-control" name="description" placeholder="Provide a description for your category" rows="8">
                                    </textarea>
                            </div>
                            <button class="btn btn-primary mt-2" type="Submit" >Add Category</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
