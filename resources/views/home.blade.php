@extends('home_master')

@section('content')

<div class="container-xxl my-md-4 bd-layout">
    <div class="row">
        <div class="col-3">
            <h1>Categories</h1>
            <div class="row">
                <div class="btn-group-vertical btn-group-lg">
                    <a href="{{ url('/') }}" class="btn btn-outline-primary">all</a>
                    <a href="{{ url('/computer') }}" class="btn btn-outline-primary">computer</a>
                    <a href="{{ url('/mouse') }}" class="btn btn-outline-primary">mouse</a>
                    <a href="{{ url('/keyboard') }}" class="btn btn-outline-primary">keyboard</a>
                </div>
            </div>
        </div>
        <div class="col-9">
            <h1>Products</h1>
            <div class="row">
                @foreach($items as $item)
                <div class="col-4 mb-3">
                    <div class="card">
                        <img src="{{ asset($item->image) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <div class="card-text" href="">{{ $item->name }}</div>
                            <p>$ {{ $item->price }}</p>
                            <a class="btn btn-success" href="{{ url('cart/'.$item->id) }}">add to chart</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection