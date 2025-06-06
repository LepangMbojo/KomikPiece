<x-app-layout>
    {{-- Header Halaman Edit --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Edit Komik: {{ $komik->judul }}</h2>
            <a href="{{ route('admin.comics') }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali
            </a>
        </div>
    </x-slot>

    <div class="container py-4">
        <div class="section-container">
            @if($errors->any())
                <div class="alert alert-danger">
                    <h6><i class="bi bi-exclamation-triangle me-2"></i>Terjadi Kesalahan:</h6>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            {{-- Form mengarah ke route 'update' dengan method 'PUT' --}}
            <form action="{{ route('admin.comics.update', $komik->id) }}" method="POST" enctype="multipart/form-data" id="comicForm">
                @csrf
                @method('PUT') {{-- Method Spoofing untuk update --}}
                
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-book me-2"></i>Informasi Komik</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    {{-- Semua input diisi dengan data yang ada: old('nama_field', $komik->nama_field) --}}
                                    <div class="col-12">
                                        <label for="judul" class="form-label">Judul Komik *</label>
                                        <input type="text" class="form-control" id="judul" name="judul" 
                                               value="{{ old('judul', $komik->judul) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="author" class="form-label">Author *</label>
                                        <input type="text" class="form-control" id="author" name="author" 
                                               value="{{ old('author', $komik->author) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="release_year" class="form-label">Tahun Rilis *</label>
                                        <input type="number" class="form-control" id="release_year" name="release_year" 
                                               min="1900" max="{{ date('Y') }}" value="{{ old('release_year', $komik->release_year) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="ongoing" {{ old('status', $komik->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                            <option value="completed" {{ old('status', $komik->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="hiatus" {{ old('status', $komik->status) == 'hiatus' ? 'selected' : '' }}>Hiatus</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="language" class="form-label">Bahasa *</label>
                                        <select class="form-control" id="language" name="language" required>
                                            <option value="">Pilih Bahasa</option>
                                            @foreach($languages as $language)
                                                <option value="{{ $language }}" {{ old('language', $komik->language) == $language ? 'selected' : '' }}>
                                                    {{ $language }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-12">
                                        <label for="genre" class="form-label">Genre *</label>
                                        <select class="form-control" id="genre" name="genre" required>
                                            <option value="">Pilih Genre</option>
                                            @foreach($genres as $genre)
                                                <option value="{{ $genre }}" {{ old('genre', $komik->genre) == $genre ? 'selected' : '' }}>
                                                    {{ $genre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="deskripsi" class="form-label">Deskripsi *</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" 
                                                  placeholder="Tulis sinopsis komik..." required>{{ old('deskripsi', $komik->deskripsi) }}</textarea>
                                        <div class="form-text">Minimal 10 karakter</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Bagian "Chapter Pertama" dihapus dari form edit --}}
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-image me-2"></i>Ganti Cover</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <label for="cover" class="form-label">Upload Cover Baru (Opsional)</label>
                                    {{-- 'required' dihapus dari input cover --}}
                                    <input type="file" class="form-control" id="cover" name="cover" 
                                           accept="image/*">
                                    <div class="form-text">Format: JPG, PNG, GIF, WEBP. Max 5MB</div>
                                </div>
                                
                                <div id="coverPreview" class="mt-3">
                                    @if($komik->cover_image)
                                        <img src="{{ $komik->cover_image }}" alt="Cover saat ini" class="preview-image">
                                    @else
                                        <div class="border rounded p-4 text-muted">
                                            <i class="bi bi-image display-4"></i>
                                            <p class="mt-2 mb-0">Tidak ada cover</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <i class="bi bi-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.comics') }}" class="btn btn-secondary btn-lg ms-2">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
        .preview-image {
            max-width: 100%;
            max-height: 400px; /* Disesuaikan agar lebih besar */
            object-fit: contain; /* Gunakan contain agar gambar utuh */
            border-radius: 8px;
            background-color: #1a1a1a;
        }
        
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>

    <script>
        // Cover preview (logikanya sama, akan menggantikan preview yang ada)
        document.getElementById('cover').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('coverPreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Cover Preview" class="preview-image">
                        <p class="mt-2 mb-0 text-success">
                            <i class="bi bi-check-circle me-1"></i>Cover baru siap diupload
                        </p>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Form submission with loading state (disederhanakan untuk form edit)
        document.getElementById('comicForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const form = this;
            
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Menyimpan...';
            submitBtn.disabled = true;
            form.classList.add('loading');
            
            const cover = document.getElementById('cover').files[0];
            if (cover && cover.size > 5 * 1024 * 1024) { // 5MB
                e.preventDefault();
                alert('Ukuran cover terlalu besar! Maksimal 5MB.');
                submitBtn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Perubahan';
                submitBtn.disabled = false;
                form.classList.remove('loading');
            }
        });
    </script>
</x-app-layout>