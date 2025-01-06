<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="auctions"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Auction"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3>Edit Auction</h3>
                        </div>
                        <div class="card-body" style="padding: 0.5rem;">
                            <form action="{{ route('auctions.update', $auction->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="auction_name" class="form-label">Auction Name *</label>
                                    <input type="text" name="auction_name" value="{{ old('auction_name', $auction->auction_name) }}" class="form-control" id="auction_name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="item_id" class="form-label">Item *</label>
                                    <select name="item_id" id="item_id" class="form-control" required>
                                        <option value="" disabled>Select an item</option>
                                        @foreach($customItems as $item)
                                            <option value="{{ $item->id }}" {{ $auction->item_id == $item->id ? 'selected' : '' }}>
                                                {{ $item->item_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small id="item-error" class="text-danger d-none">The selected item is already associated with another auction.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="announcement_start_time" class="form-label">Announcement Start Time *</label>
                                    <input type="datetime-local" name="announcement_start_time" value="{{ old('announcement_start_time', $auction->announcement_start_time) }}" class="form-control" id="announcement_start_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="announcement_end_time" class="form-label">Announcement End Time *</label>
                                    <input type="datetime-local" name="announcement_end_time" value="{{ old('announcement_end_time', $auction->announcement_end_time) }}" class="form-control" id="announcement_end_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="inspection_start_time" class="form-label">Inspection Start Time *</label>
                                    <input type="datetime-local" name="inspection_start_time" value="{{ old('inspection_start_time', $auction->inspection_start_time) }}" class="form-control" id="inspection_start_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="inspection_end_time" class="form-label">Inspection End Time *</label>
                                    <input type="datetime-local" name="inspection_end_time" value="{{ old('inspection_end_time', $auction->inspection_end_time) }}" class="form-control" id="inspection_end_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time *</label>
                                    <input type="datetime-local" name="start_time" value="{{ old('start_time', $auction->start_time) }}" class="form-control" id="start_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time *</label>
                                    <input type="datetime-local" name="end_time" value="{{ old('end_time', $auction->end_time) }}" class="form-control" id="end_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="minimum_price" class="form-label">Minimum Price *</label>
                                    <input type="number" name="minimum_price" value="{{ old('minimum_price', $auction->minimum_price) }}" step="0.01" class="form-control" id="minimum_price" required>
                                </div>

                                <div class="mb-3">
                                    <label for="starting_price" class="form-label">Starting Price *</label>
                                    <input type="number" name="starting_price" value="{{ old('starting_price', $auction->starting_price) }}" step="0.01" class="form-control" id="starting_price" required>
                                </div>

                                <div class="mb-3">
                                    <label for="minimum_bid" class="form-label">Minimum Bid *</label>
                                    <input type="number" name="minimum_bid" value="{{ old('minimum_bid', $auction->minimum_bid) }}" step="0.01" class="form-control" id="minimum_bid" required>
                                </div>

                                <div class="mb-3">
                                    <label for="main_image" class="form-label">Main Image</label>
                                    <input type="file" name="main_image" class="form-control" id="main_image" accept="image/png, image/jpeg, image/jpg">
                                    @if($auction->main_image)
                                        <img src="{{ asset($auction->main_image) }}" alt="Current Image" class="img-thumbnail mt-2" width="150">
                                    @endif
                                </div>

                                <div class="mb-3">
                                    <label for="insurance_fee" class="form-label">Insurance Fee *</label>
                                    <input type="number" name="insurance_fee" value="{{ old('insurance_fee', $auction->insurance_fee) }}" step="0.01" class="form-control" id="insurance_fee" required>
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary">Update Auction</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
