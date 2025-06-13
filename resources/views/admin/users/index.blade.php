<<<<<<< HEAD
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Kelola Pengguna</h2>
            {{-- Jika ada halaman untuk menambah pengguna, tambahkan tautan di sini --}}
            {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus me-1"></i>Tambah Pengguna
            </a> --}}
        </div>
    </x-slot>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-people"></i> {{-- Icon disesuaikan untuk pengguna --}}
                <span>Daftar Pengguna ({{ $users->total() ?? count($users) }})</span> {{-- Menyesuaikan dengan pagination atau koleksi --}}
            </div>

            @if(($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->count() > 0) || ($users instanceof \Illuminate\Support\Collection && $users->isNotEmpty()))
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status Ban</th>
                                <th width="250">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'warning' : 'info' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($user->is_banned)
                                            <span class="badge bg-danger">Banned</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            {{-- Tombol Promote/Demote --}}
                                            @if ($user->role == 'user')
                                                <form action="{{ route('admin.users.promote', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-info w-100 mb-1">
                                                        <i class="bi bi-arrow-up-circle me-1"></i>Promote
                                                    </button>
                                                </form>
                                            @elseif ($user->role == 'admin' && $user->id !== Auth::id())
                                                <form action="{{ route('admin.users.demote', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-warning w-100 mb-1">
                                                        <i class="bi bi-arrow-down-circle me-1"></i>Demote
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Tombol Ban/Unban --}}
                                            <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="d-inline">
                                                @csrf

                                                @if ($user->is_banned)
                                                    <input type="hidden" name="is_banned" value="0"> {{-- Set is_banned ke false untuk unban --}}
                                                    <button type="submit" class="btn btn-sm btn-success w-100">
                                                        <i class="bi bi-check-circle me-1"></i>Unban
                                                    </button>
                                                @else
                                                    <input type="hidden" name="is_banned" value="1"> {{-- Set is_banned ke true untuk ban --}}
                                                    <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin membanned user ini?');">
                                                        <i class="bi bi-slash-circle me-1"></i>Ban
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Belum ada pengguna</h5>
                    <p class="text-muted">Tidak ada pengguna yang terdaftar saat ini.</p>
                    {{-- Jika ada halaman untuk menambah pengguna, tambahkan tautan di sini --}}
                    {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-2"></i>Tambah Pengguna Pertama
                    </a> --}}
                </div>
            @endif
        </div>
    </div>

    {{-- Anda bisa menambahkan modal konfirmasi jika diperlukan untuk aksi seperti promote/demote/ban --}}
    {{-- <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Aksi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmActionButton">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <script>
        // Contoh fungsi untuk konfirmasi aksi (jika Anda ingin menggunakan modal untuk promote/demote/ban)
        // function confirmAction(userId, actionType, message) {
        //     document.getElementById('modalMessage').textContent = message;
        //     const confirmButton = document.getElementById('confirmActionButton');
        //     confirmButton.onclick = function() {
        //         // Lakukan submit form yang sesuai
        //         // Contoh: if (actionType === 'ban') { document.getElementById('banForm_' + userId).submit(); }
        //         // Anda perlu menyesuaikan ini dengan form dan logic Anda
        //         const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        //         modal.hide();
        //     };
        //     const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        //     modal.show();
        // }
    </script> --}}
=======
<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Kelola Pengguna</h2>
            {{-- Jika ada halaman untuk menambah pengguna, tambahkan tautan di sini --}}
            {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="bi bi-plus me-1"></i>Tambah Pengguna
            </a> --}}
        </div>
    </x-slot>

    <div class="container py-4">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="section-container">
            <div class="section-header">
                <i class="bi bi-people"></i> {{-- Icon disesuaikan untuk pengguna --}}
                <span>Daftar Pengguna ({{ $users->total() ?? count($users) }})</span> {{-- Menyesuaikan dengan pagination atau koleksi --}}
            </div>

            @if(($users instanceof \Illuminate\Pagination\LengthAwarePaginator && $users->count() > 0) || ($users instanceof \Illuminate\Support\Collection && $users->isNotEmpty()))
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Status Ban</th>
                                <th width="250">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-{{ $user->role == 'admin' ? 'warning' : 'info' }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if ($user->is_banned)
                                            <span class="badge bg-danger">Banned</span>
                                        @else
                                            <span class="badge bg-success">Aktif</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            {{-- Tombol Promote/Demote --}}
                                            @if ($user->role == 'user')
                                                <form action="{{ route('admin.users.promote', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-info w-100 mb-1">
                                                        <i class="bi bi-arrow-up-circle me-1"></i>Promote
                                                    </button>
                                                </form>
                                            @elseif ($user->role == 'admin' && $user->id !== Auth::id())
                                                <form action="{{ route('admin.users.demote', $user->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit" class="btn btn-sm btn-warning w-100 mb-1">
                                                        <i class="bi bi-arrow-down-circle me-1"></i>Demote
                                                    </button>
                                                </form>
                                            @endif

                                            {{-- Tombol Ban/Unban --}}
                                            <form action="{{ route('admin.users.updateStatus', $user->id) }}" method="POST" class="d-inline">
                                                @csrf

                                                @if ($user->is_banned)
                                                    <input type="hidden" name="is_banned" value="0"> {{-- Set is_banned ke false untuk unban --}}
                                                    <button type="submit" class="btn btn-sm btn-success w-100">
                                                        <i class="bi bi-check-circle me-1"></i>Unban
                                                    </button>
                                                @else
                                                    <input type="hidden" name="is_banned" value="1"> {{-- Set is_banned ke true untuk ban --}}
                                                    <button type="submit" class="btn btn-sm btn-danger w-100" onclick="return confirm('Apakah Anda yakin ingin membanned user ini?');">
                                                        <i class="bi bi-slash-circle me-1"></i>Ban
                                                    </button>
                                                @endif
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if($users instanceof \Illuminate\Pagination\LengthAwarePaginator)
                    <div class="d-flex justify-content-center mt-4">
                        {{ $users->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="bi bi-people display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Belum ada pengguna</h5>
                    <p class="text-muted">Tidak ada pengguna yang terdaftar saat ini.</p>
                    {{-- Jika ada halaman untuk menambah pengguna, tambahkan tautan di sini --}}
                    {{-- <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-2"></i>Tambah Pengguna Pertama
                    </a> --}}
                </div>
            @endif
        </div>
    </div>

    {{-- Anda bisa menambahkan modal konfirmasi jika diperlukan untuk aksi seperti promote/demote/ban --}}
    {{-- <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Aksi
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="modalMessage"></p>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-danger" id="confirmActionButton">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div> --}}

    {{-- <script>
        // Contoh fungsi untuk konfirmasi aksi (jika Anda ingin menggunakan modal untuk promote/demote/ban)
        // function confirmAction(userId, actionType, message) {
        //     document.getElementById('modalMessage').textContent = message;
        //     const confirmButton = document.getElementById('confirmActionButton');
        //     confirmButton.onclick = function() {
        //         // Lakukan submit form yang sesuai
        //         // Contoh: if (actionType === 'ban') { document.getElementById('banForm_' + userId).submit(); }
        //         // Anda perlu menyesuaikan ini dengan form dan logic Anda
        //         const modal = bootstrap.Modal.getInstance(document.getElementById('confirmModal'));
        //         modal.hide();
        //     };
        //     const modal = new bootstrap.Modal(document.getElementById('confirmModal'));
        //     modal.show();
        // }
    </script> --}}
>>>>>>> b88775a99336bcdb2b8f8b25eecd9f99d6501801
</x-app-layout>