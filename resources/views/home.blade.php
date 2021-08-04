@extends('home_master')
@section('content')
<div class="container-xxl my-md-4 bd-layout">
    <div class="row">
        <div class="col-4">
            <h1>Categories</h1>
            <div class="row ps-5">
                <div class="col-2">
                    <div class="btn-group-vertical" role="group" aria-label="Basic checkbox toggle button group">
                        <input type="checkbox" class="btn-check" id="btncheck1" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck1">Checkbox 1</label>

                        <input type="checkbox" class="btn-check" id="btncheck2" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck2">Checkbox 2</label>

                        <input type="checkbox" class="btn-check" id="btncheck3" autocomplete="off">
                        <label class="btn btn-outline-primary" for="btncheck3">Checkbox 3</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-8">
            <h1>Products</h1>
        </div>
    </div>
</div>
@endsection