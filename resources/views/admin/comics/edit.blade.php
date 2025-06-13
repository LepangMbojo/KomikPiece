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
                                        {{-- Added text-white to label --}}
                                        <label for="judul" class="form-label text-white">Judul Komik *</label>
                                        {{-- Added bg-white and text-black to input --}}
                                        <input type="text" class="form-control bg-white text-black" id="judul" name="judul" 
                                                    value="{{ old('judul', $komik->judul) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        {{-- Added text-white to label --}}
                                        <label for="author" class="form-label text-white">Author *</label>
                                        {{-- Added bg-white and text-black to input --}}
                                        <input type="text" class="form-control bg-white text-black" id="author" name="author" 
                                                    value="{{ old('author', $komik->author) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        {{-- Added text-white to label --}}
                                        <label for="release_year" class="form-label text-white">Tahun Rilis *</label>
                                        {{-- Added bg-white and text-black to input --}}
                                        <input type="number" class="form-control bg-white text-black" id="release_year" name="release_year" 
                                                    min="1900" max="{{ date('Y') }}" value="{{ old('release_year', $komik->release_year) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        {{-- Added text-white to label --}}
                                        <label for="status" class="form-label text-white">Status *</label>
                                        {{-- Added bg-white and text-black to select --}}
                                        <select class="form-control bg-white text-black" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="ongoing" {{ old('status', $komik->status) == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                            <option value="completed" {{ old('status', $komik->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="hiatus" {{ old('status', $komik->status) == 'hiatus' ? 'selected' : '' }}>Hiatus</option>
                                        </select>
                                    </div>

                                    <div class="col-md-6">
                                        {{-- Added text-white to label --}}
                                        <label for="rating" class="form-label text-white">Rating</label>
                                        {{-- Added bg-white and text-black to input --}}
                                        <input type="number" class="form-control bg-white text-black" id="rating" name="rating" 
                                                    step="0.1" min="0" max="10" value="{{ old('rating', $komik->rating) }}">
                                    </div>
                                    
                                    <div class="col-md-6">
                                        {{-- Added text-white to label --}}
                                        <label for="language" class="form-label text-white">Bahasa *</label>
                                        {{-- Added bg-white and text-black to select --}}
                                        <select class="form-control bg-white text-black" id="language" name="language" required>
                                            <option value="">Pilih Bahasa</option>
                                            @foreach($languages as $language)
                                                <option value="{{ $language }}" {{ old('language', $komik->language) == $language ? 'selected' : '' }}>
                                                    {{ $language }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-12">
                                        {{-- Added text-white to label --}}
                                        <label class="form-label text-white">Genres</label>
                                        {{-- Wadah agar bisa di-scroll jika genrenya banyak --}}
                                        <div class="p-3 border rounded" style="background-color: var(--card-bg); max-height: 200px; overflow-y: auto;">
                                            <div class="row">
                                                {{-- Loop semua genre yang ada dari database --}}
                                                @foreach($genres as $genre)
                                                    <div class="col-md-4 col-sm-6">
                                                        <div class="form-check">
                                                            <input 
                                                                class="form-check-input" 
                                                                type="checkbox"
                                                                name="genres[]"  {{-- Tanda [] ini SANGAT PENTING agar data dikirim sebagai array --}}
                                                                value="{{ $genre->id }}" {{-- Nilai yang dikirim adalah ID genre --}}
                                                                id="genre-{{ $genre->id }}"
                                                                {{-- Logika untuk memberi centang pada genre yang sudah dimiliki komik ini --}}
                                                                @if(is_array(old('genres')) ? in_array($genre->id, old('genres')) : $komik->genres->contains($genre->id))
                                                                    checked 
                                                                @endif
                                                            >
                                                            {{-- Added text-white to label --}}
                                                            <label class="form-check-label text-white" for="genre-{{ $genre->id }}">
                                                                {{ $genre->name }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        @error('genres')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    
                                    <div class="col-12">
                                        {{-- Added text-white to label --}}
                                        <label for="description" class="form-label text-white">Deskripsi *</label>
                                        {{-- Added bg-white and text-black to textarea --}}
                                        <textarea class="form-control bg-white text-black" id="description" name="description" rows="5" 
                                                    placeholder="Tulis sinopsis komik..." required>{{ old('description', $komik->description ?? '') }}</textarea>
                                        <div class="form-text">Minimal 10 karakter</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Bagian "Chapter Pertama" dihapus dari form edit (sudah benar) --}}
                    </div>
                    
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-image me-2"></i>Ganti Cover</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    {{-- Added text-white to label --}}
                                    <label for="cover" class="form-label text-white">Upload Cover Baru (Opsional)</label>
                                    {{-- Added bg-white and text-black to input --}}
                                    <input type="file" class="form-control bg-white text-black" id="cover" name="cover" 
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