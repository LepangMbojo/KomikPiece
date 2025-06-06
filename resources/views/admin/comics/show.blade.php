<x-app-layout>
    {{-- Header Halaman --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 mb-0">Detail Komik</h2>
                <small class="text-muted">{{ $komik->judul }}</small>
            </div>
            <div>
                <a href="{{ route('admin.comics') }}" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-arrow-left me-1"></i>Kembali ke Daftar Komik
                </a>
                <a href="{{ route('admin.comics.edit', $komik->id) }}" class="btn btn-warning btn-sm">
                    <i class="bi bi-pencil-square me-1"></i>Edit Komik Ini
                </a>
            </div>
        </div>
    </x-slot>

    <div class="container py-4">
        {{-- Notifikasi Sukses atau Error --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            {{-- KOLOM KIRI: INFO SINGKAT & COVER --}}
            <div class="col-md-4">
                <div class="card mb-4">
                    <img src="{{ $komik->cover_image }}" class="card-img-top" alt="Cover {{ $komik->judul }}" style="object-fit: cover; height: 400px; background-color: #1a1a1a;">
                    <div class="card-body">
                        <h5 class="card-title text-primary">{{ $komik->judul }}</h5>
                        <p class="card-text text-muted">{{ $komik->author }} ({{ $komik->release_year }})</p>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Status
                            <span class="badge bg-info rounded-pill">{{ ucfirst($komik->status) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Chapter
                            <span class="badge bg-primary rounded-pill">{{ $komik->chapters->count() }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Total Views
                            <span class="badge bg-secondary rounded-pill">{{ number_format($komik->views) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Rating
                            <span class="badge bg-warning rounded-pill">{{ $komik->rating ?? 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- KOLOM KANAN: DESKRIPSI & MANAJEMEN CHAPTER --}}
            <div class="col-md-8">
                <div class="section-container mb-4">
                    <h5 class="mb-3"><i class="bi bi-text-left me-2"></i>Deskripsi</h5>
                    <p style="white-space: pre-wrap;">{{ $komik->deskripsi }}</p>
                </div>

                <div class="section-container">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="mb-0"><i class="bi bi-list-ol me-2"></i>Daftar Chapter</h5>
                        <a href="{{ route('admin.comics.add-chapter', $komik->id) }}" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Tambah Chapter Baru
                        </a>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-dark table-hover align-middle">
                            <thead>
                                <tr>
                                    <th scope="col">Chapter</th>
                                    <th scope="col">Judul</th>
                                    <th scope="col">Halaman</th>
                                    <th scope="col">Tanggal Upload</th>
                                    <th scope="col" class="text-end">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($komik->chapters->sortByDesc('chapter_number') as $chapter)
                                    <tr>
                                        <th scope="row">{{ $chapter->chapter_number }}</th>
                                        <td>{{ $chapter->title ?: '-' }}</td>
                                        <td>{{ count($chapter->pages) }}</td>
                                        <td>{{ $chapter->created_at->format('d M Y') }}</td>
                                        <td class="text-end">
                                            {{-- Tombol Lihat Chapter (di halaman publik) --}}
                                            <a href="{{ route('komik.chapter', ['id' => $komik->id, 'chapter' => $chapter->chapter_number]) }}" class="btn btn-sm btn-info" title="Lihat Chapter" target="_blank">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            {{-- Tombol Hapus Chapter --}}
                                            <form action="{{ route('admin.comics.chapters.delete', ['comicId' => $komik->id, 'chapterId' => $chapter->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Anda yakin ingin menghapus Chapter {{ $chapter->chapter_number }} secara permanen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus Chapter">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">Belum ada chapter untuk komik ini.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>