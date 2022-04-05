@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-10">
                <div class="card">

                    <div class="card-header bg-danger text-white">
                        @include('components.go-to-index')
                        {{ $category->name }}
                        <span class="float-end">
                            <a href="{{ route("categories.edit", $category->id) }}" class="text-white bi-pen"></a>
                            <form method="POST" action="{{ route("categories.delete", $category->id) }}">
                                    {{csrf_field()}}
                                {{method_field('DELETE')}}
                                    <a type="submit" class="text-white bi-trash"></a>
                                </form>
                        </span>
                    </div>

                    <div class="card-body">

                         {!! $category->description !!}

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
