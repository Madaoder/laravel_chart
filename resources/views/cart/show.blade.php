@extends('home_master')

@section('content')

<div class="container-xxl my-md-4 bd-layout">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">name</th>
                <th scope="col">qty</th>
                <th scope="col">price</th>
                <th scope="col">total</th>
                <th scope="col">action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $item)
            <tr>
                <th scope="row">{{ $item['name'] }}</th>
                <td>
                    <form name="qtyForm" id="{{ 'item'.$item['id'] }}" action="{{ url('cart/'.$item['id']) }}" method="POST">
                        @csrf
                        <select class="qtySelect" name="qty" id="{{ $item['id'] }}">
                            @for($i=1; $i<=10; $i++) @if($i==$item['qty']) <option selected>{{ $item['qty'] }}</option>
                                @endif
                                <option>{{ $i }}</option>
                                @endfor
                        </select>
                    </form>
                </td>
                <td>{{ $item['price'] }}</td>
                <td>{{ $item['price'] * $item['qty'] }}</td>
                <td>
                    <form id="deleteForm" action="{{ url('cart/'.$item['id']) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger">delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    total : {{ $total }}
</div>

<script>
    const selectElements = document.querySelectorAll('.qtySelect');
    const items = <?php echo json_encode($items); ?>;
    for (let i = 0; i < selectElements.length; i++) {
        selectElements[i].addEventListener('change', (event) => {
            document.getElementById(`item${selectElements[i].id}`).submit();
        });
    };
</script>
@endsection