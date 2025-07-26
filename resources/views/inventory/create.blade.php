@extends('layouts.app')

@section('title', 'Add Item')

@section('content')
    <div class="container mt-5 text-white">
        <h2 class="mb-4">Add Item Inventory</h2>

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Something went wrong!</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('inventory.store') }}" method="POST" class="bg-dark p-4 rounded shadow">
            @csrf

            {{-- Filter Dropdown --}}
            <div class="mb-3">
                <label for="item_name" class="form-label">Item Name</label>
                <input type="text" class="form-control" id="item_name" name="item_name" value="{{ old('item_name') }}" required>
            </div>

            <div class="mb-3">
                <label for="quantity" class="form-label">Qty</label>
                <input type="number" class="form-control" id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" required>
            </div>

            <div class="mb-3">
                <label for="type" class="form-label">Type</label>
                <select name="type" id="type" class="form-select" required>
                    <option value="">--- Select Type ---</option>
                    @php
                        $typeOptions = ['Armor', 'Axe', 'Bow', 'Cape', 'Class', 'Dagger', 'Floor Item', 'Gauntlet', 'Gun', 'Helm', 'House', 'Item', 'Mace', 'Misc', 'Necklace', 'Pet', 'Polearm', 'Quest Item', 'Resource', 'Staff', 'Sword', 'Wall Item', 'Whip'];
                    @endphp
                    @foreach ($typeOptions as $type)
                        <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Where</label>
                <select name="location" id="location" class="form-select" required>
                    <option value="">--- Select Location ---</option>
                    @php
                        $locationOptions = ['Bank', 'Inventory'];
                    @endphp
                    @foreach ($locationOptions as $location)
                        <option value="{{ $location }}" {{ old('location') === $location ? 'selected' : '' }}>{{ $location }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="buy_method" class="form-label">Buy</label>
                <select name="buy_method" id="buy_method" class="form-select" required>
                    <option value="">--- Select Buy ---</option>
                    @php
                        $buyOptions = ['AC', 'Gold'];
                    @endphp
                    @foreach ($buyOptions as $buy)
                        <option value="{{ $buy }}" {{ old('buy_method') === $buy ? 'selected' : '' }}>{{ $buy }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select name="category" id="category" class="form-select" required>
                    <option value="">--- Select Category ---</option>
                    @php
                        $categoryOptions = ['Free', 'Member'];
                    @endphp
                    @foreach ($categoryOptions as $category)
                        <option value="{{ $category }}" {{ old('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="buy_date" class="form-label">Buy Date</label>
                <input type="date" class="form-control" id="buy_date" name="buy_date" value="{{ old('buy_date', date('d-m-Y')) }}" required>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('inventory.index') }}" class="btn btn-secondary">Back</a>
                <button type="submit" class="btn btn-purple">Add Item</button>
            </div>
        </form>
    </div>
@endsection