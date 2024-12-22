<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="auctions"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create Auction"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3>Create Auction</h3>
                        </div>
                        <div class="card-body" style="padding: 0.5rem;">
                            <form action="{{ route('auctions.store') }}" method="POST" enctype="multipart/form-data" id="auctionForm">
                                @csrf

                                <div class="mb-3">
                                    <label for="auction_name" class="form-label">Auction Name *</label>
                                    <input type="text" name="auction_name" class="form-control" id="auction_name" required>
                                </div>


                                <div class="mb-3">
                                    <label for="item_id" class="form-label">Item *</label>
                                    <select name="item_id" id="item_id" class="form-control" required>
                                        <option value="" disabled selected>Select an item</option>
                                        @foreach($customItems as $item)
                                            <option value="{{ $item->id }}" data-auction-id="{{ $item->auction_id }}">
                                                {{ $item->item_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <small id="item-error" class="text-danger d-none">The selected item is already associated with another auction.</small>
                                </div>

                                <div class="mb-3">
                                    <label for="announcement_start_time" class="form-label">Announcement Start Time *</label>
                                    <input type="datetime-local" name="announcement_start_time" class="form-control" id="announcement_start_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="announcement_end_time" class="form-label">Announcement End Time *</label>
                                    <input type="datetime-local" name="announcement_end_time" class="form-control" id="announcement_end_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="inspection_start_time" class="form-label">Inspection Start Time *</label>
                                    <input type="datetime-local" name="inspection_start_time" class="form-control" id="inspection_start_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="inspection_end_time" class="form-label">Inspection End Time *</label>
                                    <input type="datetime-local" name="inspection_end_time" class="form-control" id="inspection_end_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="start_time" class="form-label">Start Time *</label>
                                    <input type="datetime-local" name="start_time" class="form-control" id="start_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="end_time" class="form-label">End Time *</label>
                                    <input type="datetime-local" name="end_time" class="form-control" id="end_time" required>
                                </div>

                                <div class="mb-3">
                                    <label for="minimum_price" class="form-label">Minimum Price *</label>
                                    <input type="number" name="minimum_price" step="0.01" class="form-control" id="minimum_price" required>
                                </div>

                                <div class="mb-3">
                                    <label for="starting_price" class="form-label">Starting Price *</label>
                                    <input type="number" name="starting_price" step="0.01" class="form-control" id="starting_price" required>
                                </div>

                                <div class="mb-3">
                                    <label for="minimum_bid" class="form-label">Minimum Bid *</label>
                                    <input type="number" name="minimum_bid" step="0.01" class="form-control" id="minimum_bid" required>
                                </div>

                                <div class="mb-3">
                                    <label for="main_image" class="form-label">Main Image</label>
                                    <input type="file" name="main_image" class="form-control" id="main_image" accept="image/png, image/jpeg, image/jpg">
                                </div>

                                <div class="mb-3">
                                    <label for="insurance_fee" class="form-label">Insurance Fee *</label>
                                    <input type="number" name="insurance_fee" step="0.01" class="form-control" id="insurance_fee" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Create Auction</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<script>
    // تحقق من ارتباط العنصر بمزاد آخر
    document.getElementById('item_id').addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const auctionId = selectedOption.getAttribute('data-auction-id');
        const errorMessage = document.getElementById('item-error');

        if (auctionId) {
            errorMessage.classList.remove('d-none');
        } else {
            errorMessage.classList.add('d-none');
        }
    });

    // تحقق من ترتيب التواريخ
    document.getElementById('auctionForm').addEventListener('submit', function (e) {
        const announcementStart = new Date(document.getElementById('announcement_start_time').value);
        const inspectionStart = new Date(document.getElementById('inspection_start_time').value);
        const startTime = new Date(document.getElementById('start_time').value);

        if (announcementStart >= inspectionStart) {
            alert("Announcement Start Time must be before Inspection Start Time.");
            e.preventDefault();
        } else if (inspectionStart >= startTime) {
            alert("Inspection Start Time must be before Auction Start Time.");
            e.preventDefault();
        }
    });
</script>
