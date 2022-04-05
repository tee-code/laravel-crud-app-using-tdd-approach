@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card">
                    <div class="p-3">
                        <h2 class="float-start">
                            {{ __('Categories') }}
                        </h2>
                        @auth()
                            <a href="{{ route("categories.create") }}" class="float-end btn-primary p-2 text-white btn">Create -></a>
                        @endauth
                    </div>

                    @foreach($categories as $category)
                        <div class="card-header bg-danger text-white">

                            {{ $category->name }}

                            <span class="float-end">

                                <a href="{{ route("categories.show", $category->id) }}" class="text-white bi-eye"></a>

                                 <form class = "d-inline" method = "POST" action="{{ route('categories.delete', $category->id) }}">

                                     @csrf
                                     @method('DELETE')
                                     <button type="submit" class="btn btn-danger"><i class="bi-trash"></i> </button>

                                 </form>

                            </span>
                        </div>

                        <div class="card-body">
                            {!! $category->description !!}
                        </div>
                    @endforeach

                    {{ $categories->links('pagination::bootstrap-5') }}

                </div>
            </div>
        </div>
    </div>
@endsection
