@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card">
                    <div class="p-3">
                        <h2 class="float-start">
                            {{ __('Posts') }}
                        </h2>
                        @auth()
                            <a href="{{ route("posts.create") }}" class="float-end btn-primary p-2 text-white btn">Create -></a>
                        @endauth
                    </div>

                    @foreach($posts as $post)
                        <div class="">
                            <div class="card-header bg-primary text-white">

                                {{ $post->category->name }}

                                <span class="float-end">

                                <a href="{{ route("posts.slug", $post->slug) }}" class="text-white bi-eye"></a>

                                    @can("delete", $post)

                                         <form class = "d-inline mt-0" method = "POST" action="{{ route('posts.destroy', $post->id) }}">

                                             @csrf
                                             @method('DELETE')
                                             <button type="submit" class="btn btn-primary m-0 p-0"><i class="bi-trash"></i> </button>

                                         </form>
                                        @endcan

                            </span>
                            </div>

                            <div class="card-body">

                                <h2>{{ $post->title }}</h2>

                                {!! $post->body !!}
                                <br>

                                <strong>by {{ $post->user->name }}</strong>
                                <strong>on {{ $post->created_at }}</strong>

                            </div>
                        </div>

                    @endforeach

                    {{ $posts->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
@endsection
