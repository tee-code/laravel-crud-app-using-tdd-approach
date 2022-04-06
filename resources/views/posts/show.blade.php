@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card">

                    <div class="card-header bg-danger text-white">

                        @include('components.go-to-post-index')

                        {{ $post->category->name }}

                        <span class="float-end">
                            @can('update', $post)
                                <a href="{{ route("posts.edit", $post->id) }}" class="text-white bi-pen"></a>
                            @endcan

                            @can("delete", $post)
                                    <form class="d-inline" method="POST" action="{{ route("posts.destroy", $post->id) }}">
                                    {{csrf_field()}}
                                {{method_field('DELETE')}}
                                    <a type="submit" class="text-white bi-trash"></a>
                                </form>
                                @endcan
                        </span>
                    </div>

                    <div class="card-body">

                        <h2>{{ $post->title }}</h2>

                         {!! $post->body !!}

                        <br>

                        <strong>
                            by {{ $post->user->name }} on {{ $post->created_at }}
                        </strong>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
