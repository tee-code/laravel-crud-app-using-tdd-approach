@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card">

                    <div class="card-header bg-danger text-white">
                        @include('components.go-to-post-index')
                        {{ __('Edit Post') }}
                    </div>

                    <div class="card-body">

                        <form method ="POST" action="{{ route("posts.update", $post->id) }}">

                            {{csrf_field()}}

                            {{ method_field("PUT") }}

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" id="title" value="{{ $post->title }}">
                            </div>

                            <div class="form-group mt-2">
                                <label for="title">Slug</label>
                                <input type="text" class="form-control" name="slug" id="slug" value="{{ $post->slug }}">
                            </div>

                            <div class="form-group mt-2">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-control">

                                    <option value="">Select Category</option>

                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}"
                                        <?php
                                            if($category->id == $post->category->id){
                                            echo "selected";
                                        }
                                        ?>
                                        >{{ $category->name }}</option>
                                    @endforeach

                                </select>
                            </div>

                            <div class="form-group mt-2">
                                <label for="body">Body</label>
                                    <textarea class="form-control" name="body" rows="20">
                                        {{ $post->body }}
                                    </textarea>
                            </div>

                            <button class="btn btn-primary mt-2" type="Submit" >Edit Post</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
