<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <div class="container">
        <h2>Edit Item</h2>
        <form action="{{ route('items.update', $customItem->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="item_name">Item Name</label>
                <input type="text" id="item_name" name="item_name" value="{{ old('item_name', $customItem->item_name) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="base_price">Base Price</label>
                <input type="text" id="base_price" name="base_price" value="{{ old('base_price', $customItem->base_price) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="quantity">Quantity</label>
                <input type="number" id="quantity" name="quantity" value="{{ old('quantity', $customItem->quantity) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="category_id">Category</label>
                <input type="text" id="category_id" name="category_id" value="{{ old('category_id', $customItem->category_id) }}" class="form-control" required>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Item</button>
            </div>
        </form>
    </div>
</x-layout>
