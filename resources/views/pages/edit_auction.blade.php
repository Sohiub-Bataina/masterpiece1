<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <div class="container mt-5">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center">Edit Auction</h2>
            </div>
            <div class="card-body">
                <form action="{{ route('auctions.update', $auction->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="auction_name" class="form-label">Auction Name</label>
                        <input type="text" id="auction_name" name="auction_name" value="{{ old('auction_name', $auction->auction_name) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="start_time" class="form-label">Start Time</label>
                        <input type="datetime-local" id="start_time" name="start_time" value="{{ old('start_time', $auction->start_time) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="end_time" class="form-label">End Time</label>
                        <input type="datetime-local" id="end_time" name="end_time" value="{{ old('end_time', $auction->end_time) }}" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="item_name" class="form-label">Item Name</label>
                        <input type="text" id="item_name" name="item_name" value="{{ old('item_name', $auction->item_name) }}" class="form-control">
                    </div>

                    <div class="mb-3">
    <label for="status" class="form-label">Status</label>
    <select id="status" name="status" class="form-select" required>
        <option value="pending" {{ $auction->status == 'pending' ? 'selected' : '' }}>Pending</option>
        <option value="active" {{ $auction->status == 'active' ? 'selected' : '' }}>Active</option>
        <option value="ended" {{ $auction->status == 'ended' ? 'selected' : '' }}>Ended</option>
        <option value="cancelled" {{ $auction->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
    </select>
</div>


                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Update Auction</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layout>
