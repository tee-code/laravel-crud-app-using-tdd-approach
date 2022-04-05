@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card">

                    <div class="card-header bg-danger text-white">
                        @include('components.go-to-post-index')
                        {{ __('Create Post') }}
                    </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route("posts.store") }}">
                            {{csrf_field()}}
                            <div class="form-group">
                                <input type="text" class="form-control" name="title" id="title" placeholder="Enter post title">
                            </div>
                            <div class="form-group mt-2">
                                <select name="category_id" id="category_id" class="form-control">

                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div class="form-group mt-2">
                                    <textarea class="form-control" name="body" placeholder="Provide a description for your category" rows="20">
                                    </textarea>
                            </div>
                            <button class="btn btn-primary mt-2" type="Submit" >Add Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
