<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Kelola Komik</h2>
            <a href="{{ route('admin.comics.create') }}" class="btn btn-primary">
                <i class="bi bi-plus me-1"></i>Tambah Komik
            </a>
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
                <i class="bi bi-book"></i>
                <span>Daftar Komik ({{ $comics->total() }})</span>
            </div>

            @if($comics->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th width="80">Cover</th>
                                <th>Judul</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Bahasa</th>
                                <th>Chapters</th>
                                <th>Rating</th>
                                <th>Favorite</th>
                                <th>Dibuat</th>
                                <th width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($comics as $comic)
                                <tr>
                                    <td>
                                        <img src="{{ asset('storage/' . $comic->cover) }}" 
                                             alt="{{ $comic->judul }}" 
                                             class="img-thumbnail"
                                             style="width: 60px; height: 80px; object-fit: cover;">
                                    </td>
                                    <td>
                                        <strong>{{ $comic->judul }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($comic->deskripsi, 50) }}</small>
                                    </td>
                                    <td>{{ $comic->author }}</td>
                                    <td>
                                        <span class="badge bg-{{ $comic->status == 'ongoing' ? 'success' : ($comic->status == 'completed' ? 'primary' : 'warning') }}">
                                            {{ ucfirst($comic->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $comic->language }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $comic->chapters_count }} chapters</span>
                                    </td>
                                    <td>{{ $comic->rating ?? 0 }}</td>
                                    <td>{{ $comic->Favorite }}</td>
                                    <td>{{ $comic->created_at->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group-vertical btn-group-sm" role="group">
                                            <a href="{{ route('admin.comics.show', $comic->id) }}" 
                                               class="btn btn-info btn-sm">
                                                <i class="bi bi-eye"></i> Detail
                                            </a>
                                            <a href="{{ route('admin.comics.edit', $comic->id) }}" 
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <a href="{{ route('admin.comics.add-chapter', $comic->id) }}" 
                                               class="btn btn-success btn-sm">
                                                <i class="bi bi-plus"></i> Chapter
                                            </a>
                                            <button type="button" class="btn btn-danger btn-sm" 
                                                    onclick="confirmDelete({{ $comic->id }}, '{{ $comic->judul }}')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $comics->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-book display-1 text-muted"></i>
                    <h5 class="mt-3 text-muted">Belum ada komik</h5>
                    <p class="text-muted">Mulai dengan menambahkan komik pertama</p>
                    <a href="{{ route('admin.comics.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus me-2"></i>Tambah Komik Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark">
                <div class="modal-header border-secondary">
                    <h5 class="modal-title text-danger">
                        <i class="bi bi-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus komik <strong id="comicTitle"></strong>?</p>
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle me-2"></i>
                        <strong>Peringatan:</strong> Semua chapter dan file terkait akan ikut terhapus dan tidak dapat dikembalikan!
                    </div>
                </div>
                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <form id="deleteForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash me-2"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmDelete(comicId, comicTitle) {
            document.getElementById('comicTitle').textContent = comicTitle;
            document.getElementById('deleteForm').action = `/admin/comics/${comicId}`;
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
        }
    </script>
</x-app-layout>