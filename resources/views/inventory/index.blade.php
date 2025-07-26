@extends('layouts.app')

@section('title', 'Inventory Index')

@section('content')
    <div class="d-flex justify-content-between align-items-start mb-4">
        <h2>Inventory</h2>

        {{-- Logout Button --}}
        <div class="d-flex flex-column align-items-end gap-2">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>

        {{-- Add Button --}}
        @if (Auth::user()->role === 'owner' || Auth::user()->role === 'operator')  
            <a href="{{ route('inventory.create') }}" class="btn btn-purple">+ Add Item</a>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    
    @endif

    {{-- Filter Dropdown --}}
    <form method="GET" action="{{ route('inventory.index') }}" class="row g-2 mb-4">
        <div class="col-md-2">
            <select name="type" class="form-select">
                <option value="">Type</option>
                @php
                    $typeOptions = ['Armor', 'Axe', 'Bow', 'Cape', 'Class', 'Dagger', 'Floor Item', 'Gauntlet', 'Gun', 'Helm', 'House', 'Item', 'Mace', 'Misc', 'Necklace', 'Pet', 'Polearm', 'Quest Item', 'Resource', 'Staff', 'Sword', 'Wall Item', 'Whip'];
                @endphp
                @foreach ($typeOptions as $type)
                    <option value="{{ $type }}" @selected(request('type') == $type)>{{ $type }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="location" class="form-select">
                <option value="">Where</option>
                @php
                    $locationOptions = ['Bank', 'Inventory'];
                @endphp
                @foreach ($locationOptions as $location)
                    <option value="{{ $location }}" @selected(request('location') == $location)>{{ $location }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="buy-method" class="form-select">
                <option value="">Buy</option>
                @php
                    $buyOptions = ['AC', 'Gold'];
                @endphp
                @foreach ($buyOptions as $buy)
                    <option value="{{ $buy }}" @selected(request('buy_method') == $buy)>{{ $buy }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="category" class="form-select">
                <option value="">Category</option>
                @php
                    $categoryOptions = ['Free', 'Member'];
                @endphp
                @foreach ($categoryOptions as $cat)
                    <option value="{{ $cat }}" @selected(request('category') == $cat)>{{ $cat }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-1">
            <button class="btn btn-purple w-100">Filter</button>
        </div>
        <div class="col-md-1">
            <button type="button" id="resetFilter" class="btn btn-secondary w-100">Reset</button>
        </div>
    </form>

    {{-- Responsive Table --}}
    <div class="table-responsive">
        <table id="inventoryTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Qty</th>
                    <th>Type</th>
                    <th>Where</th>
                    <th>Buy Method</th>
                    <th>Category</th>
                    <th>Buy Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inventories as $item)
                    <tr>
                        <td>{{ $item->item_name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->type }}</td>
                        <td>{{ $item->location }}</td>
                        <td>{{ $item->buy_method }}</td>
                        <td>{{ $item->category }}</td>
                        <td>{{ \Carbon\Carbon::parse($item->buy_date)->format('d M Y') }}</td>
                        <td>
                            {{-- Action Column --}}
                            @if (Auth::user()->role === 'owner')
                                
                                <a href="{{ route('inventory.edit', $item->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete Item?')">Delete</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#inventoryTable').DataTable({
                pageLength: 50
            });

            // Reset Filter button
            $('#resetFilter').on('click', function() {
                // Clear all filter inputs
                $('input[name="search"]').val('');
                $('select[name="type"]').val('');
                $('select[name="location"]').val('');
                $('select[name="buy-method"]').val('');
                $('select[name="category"]').val('');

                // Re-Submit the form to reset filters
                $('form').submit();
            });
        });
    </script>
@endsection