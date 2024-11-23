<x-layout bodyClass="g-sidenav-show bg-gray-200">
    <x-navbars.sidebar activePage="user-management"></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="User Management"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4">
            <div class="row">
                <!-- Admin Users Section -->
                <div class="col-12 mb-5">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3>Admin Users</h3>
                        </div>
                        <div class="card-body" style="padding: 0.5rem;">
                            <div class="table-responsive">
                                <table class="table align-items-center" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NAME</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">EMAIL</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ROLE</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PHONE NUMBER</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RESIDENCE</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">GENDER</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CREATION DATE</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($admins as $admin)
                                            <tr>
                                                <td>{{ $admin->full_name }}</td>
                                                <td class="text-center">{{ $admin->email }}</td>
                                                <td class="text-center">{{ ucfirst($admin->role) }}</td>
                                                <td class="text-center">{{ $admin->phone_number }}</td>
                                                <td class="text-center">{{ $admin->residence }}</td>
                                                <td class="text-center">{{ $admin->gender }}</td>
                                                <td class="text-center">{{ $admin->created_at->format('d/m/Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('users.edit', $admin->id) }}" class="btn btn-success btn-link">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-link" onclick="confirmDelete({{ $admin->id }})">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                    <form id="delete-form-{{ $admin->id }}" action="{{ route('users.destroy', $admin->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $admins->links() }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Users Section -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header p-3">
                            <h3>Customer Users</h3>
                        </div>
                        <div class="card-body" style="padding: 0.5rem;">
                            <div class="table-responsive">
                                <table class="table align-items-center" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">NAME</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">EMAIL</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ROLE</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PHONE NUMBER</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">RESIDENCE</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">INSURANCE BALANCE</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">CREATION DATE</th>
                                            <th class="text-secondary opacity-7"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($customers as $customer)
                                            <tr>
                                                <td>{{ $customer->full_name }}</td>
                                                <td class="text-center">{{ $customer->email }}</td>
                                                <td class="text-center">{{ ucfirst($customer->role) }}</td>
                                                <td class="text-center">{{ $customer->phone_number }}</td>
                                                <td class="text-center">{{ $customer->residence }}</td>
                                                <td class="text-center">{{ $customer->insurance_balance }}</td>
                                                <td class="text-center">{{ $customer->created_at->format('d/m/Y') }}</td>
                                                <td class="text-center">
                                                    <a href="{{ route('users.edit', $customer->id) }}" class="btn btn-success btn-link">
                                                        <i class="material-icons">edit</i>
                                                    </a>
                                                    <button type="button" class="btn btn-danger btn-link" onclick="confirmDelete({{ $customer->id }})">
                                                        <i class="material-icons">close</i>
                                                    </button>
                                                    <form id="delete-form-{{ $customer->id }}" action="{{ route('users.destroy', $customer->id) }}" method="POST" style="display: none;">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $customers->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-plugins></x-plugins>
</x-layout>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This action cannot be undone!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${userId}`).submit();
            }
        });
    }
</script>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: "{{ session('success') }}",
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: "{{ session('error') }}",
        });
    </script>
@endif

