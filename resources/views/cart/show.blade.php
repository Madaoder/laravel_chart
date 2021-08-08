@extends('home_master')

@section('content')

<div class="container-xxl my-md-4 bd-layout">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">name</th>
                <th scope="col">qty</th>
                <th scope="col">price</th>
                <th scope="col">count</th>
                <th scope="col">enable</th>
                <th scope="col">action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <th scope="row">{{ $item->name }}</th>
                <td>
                    <select class="form-select" aria-label="Default select example">
                        @for($i=1; $i<=10; $i++) @if($i==$item->pivot->qty)
                            <option selected>{{ $item->pivot->qty }}</option>
                            @else
                            <option>{{ $i }}</option>
                            @endif
                            @endfor
                    </select>
                </td>
                <td>{{ $item->price }}</td>
                <td>{{ $item->price * $item->pivot->qty }}</td>
                <td>able</td>
                <td>
                    <form action="">
                        <button class="btn btn-danger">delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    total : {{ $order->sum }}
</div>
@endsection