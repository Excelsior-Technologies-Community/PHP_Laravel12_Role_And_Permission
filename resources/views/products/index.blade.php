@extends('layouts.app')

@section('content')

<div class="row mb-3">
    <div class="col-lg-6">
        <h2>Products</h2>
    </div>

    <div class="col-lg-6 text-end">
        @can('product-create')
        <a class="btn btn-success btn-sm" href="{{ route('products.create') }}">
            <i class="fa fa-plus"></i> Create New Product
        </a>
        @endcan
    </div>
</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<form method="GET" action="{{ route('products.index') }}" class="mb-3">
    <div class="row">
        <div class="col-md-8">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Search Product..."
                value="{{ request('search') }}">
        </div>

        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">
                Search
            </button>
        </div>

        <div class="col-md-2">
            <a href="{{ route('products.index') }}" class="btn btn-secondary w-100">
                Reset
            </a>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <tr>
        <th>No</th>
        <th>Name</th>
        <th>Details</th>
        <th width="280px">Action</th>
    </tr>

    @forelse($products as $product)

    <tr>
        <td>{{ ++$i }}</td>
        <td>{{ $product->name }}</td>
        <td>{{ $product->detail }}</td>

        <td>
            <form action="{{ route('products.destroy',$product->id) }}" method="POST">

                <a class="btn btn-info btn-sm"
                   href="{{ route('products.show',$product->id) }}">
                    <i class="fa-solid fa-list"></i> Show
                </a>

                @can('product-edit')
                <a class="btn btn-primary btn-sm"
                   href="{{ route('products.edit',$product->id) }}">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
                @endcan

                @csrf
                @method('DELETE')

                @can('product-delete')
                <button type="submit" class="btn btn-danger btn-sm">
                    <i class="fa-solid fa-trash"></i> Delete
                </button>
                @endcan

            </form>
        </td>
    </tr>

    @empty

    <tr>
        <td colspan="4" class="text-center">
            No Products Found
        </td>
    </tr>

    @endforelse

</table>

<div class="d-flex justify-content-center mt-4">
    {{ $products->links() }}
</div>

@endsection