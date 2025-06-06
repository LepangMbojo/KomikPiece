<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">Tambah Komik Baru</h2>
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

            <form action="{{ route('admin.comics.store') }}" method="POST" enctype="multipart/form-data" id="comicForm">
                @csrf
                
                <!-- Comic Information -->
                <div class="row">
                    <div class="col-md-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-book me-2"></i>Informasi Komik</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="judul" class="form-label">Judul Komik *</label>
                                        <input type="text" class="form-control" id="judul" name="judul" 
                                               value="{{ old('judul') }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="author" class="form-label">Author *</label>
                                        <input type="text" class="form-control" id="author" name="author" 
                                               value="{{ old('author') }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="release_year" class="form-label">Tahun Rilis *</label>
                                        <input type="number" class="form-control" id="release_year" name="release_year" 
                                               min="1900" max="{{ date('Y') }}" value="{{ old('release_year', date('Y')) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="status" class="form-label">Status *</label>
                                        <select class="form-control" id="status" name="status" required>
                                            <option value="">Pilih Status</option>
                                            <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                            <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="hiatus" {{ old('status') == 'hiatus' ? 'selected' : '' }}>Hiatus</option>
                                        </select>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="language" class="form-label">Bahasa *</label>
                                        <select class="form-control" id="language" name="language" required>
                                            <option value="">Pilih Bahasa</option>
                                            @foreach($languages as $language)
                                                <option value="{{ $language }}" {{ old('language') == $language ? 'selected' : '' }}>
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
                                                <option value="{{ $genre }}" {{ old('genre') == $genre ? 'selected' : '' }}>
                                                    {{ $genre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="deskripsi" class="form-label">Deskripsi *</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="5" 
                                                  placeholder="Tulis sinopsis komik..." required>{{ old('deskripsi') }}</textarea>
                                        <div class="form-text">Minimal 10 karakter</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- First Chapter -->
                        <div class="card mb-4">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Chapter Pertama</h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="chapter_number" class="form-label">Nomor Chapter *</label>
                                        <input type="number" class="form-control" id="chapter_number" name="chapter_number" 
                                               min="1" value="{{ old('chapter_number', 1) }}" required>
                                    </div>
                                    
                                    <div class="col-md-6">
                                        <label for="chapter_title" class="form-label">Judul Chapter</label>
                                        <input type="text" class="form-control" id="chapter_title" name="chapter_title" 
                                               value="{{ old('chapter_title') }}" placeholder="Opsional">
                                    </div>
                                    
                                    <div class="col-12">
                                        <label for="chapter_pages" class="form-label">Halaman Chapter *</label>
                                        <input type="file" class="form-control" id="chapter_pages" name="chapter_pages[]" 
                                               multiple accept="image/*" required>
                                        <div class="form-text">
                                            Upload gambar halaman chapter. Format: JPG, PNG, GIF, WEBP. Max 10MB per file.
                                            <br>Tip: Urutkan file sesuai urutan halaman sebelum upload.
                                        </div>
                                        
                                        <!-- Preview area -->
                                        <div id="pagesPreview" class="mt-3 row g-2"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Cover Upload -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="mb-0"><i class="bi bi-image me-2"></i>Cover Komik</h5>
                            </div>
                            <div class="card-body text-center">
                                <div class="mb-3">
                                    <label for="cover" class="form-label">Upload Cover *</label>
                                    <input type="file" class="form-control" id="cover" name="cover" 
                                           accept="image/*" required>
                                    <div class="form-text">Format: JPG, PNG, GIF, WEBP. Max 5MB</div>
                                </div>
                                
                                <!-- Cover Preview -->
                                <div id="coverPreview" class="mt-3">
                                    <div class="border rounded p-4 text-muted">
                                        <i class="bi bi-image display-4"></i>
                                        <p class="mt-2 mb-0">Preview cover akan muncul di sini</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <i class="bi bi-save me-2"></i>Simpan Komik
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
            max-height: 300px;
            object-fit: cover;
            border-radius: 8px;
        }
        
        .page-preview {
            position: relative;
            border: 2px solid #444;
            border-radius: 8px;
            overflow: hidden;
        }
        
        .page-preview img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }
        
        .page-number {
            position: absolute;
            top: 5px;
            left: 5px;
            background: rgba(0,0,0,0.7);
            color: white;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 12px;
        }
        
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }
    </style>

    <script>
        // Cover preview
        document.getElementById('cover').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('coverPreview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Cover Preview" class="preview-image">
                        <p class="mt-2 mb-0 text-success">
                            <i class="bi bi-check-circle me-1"></i>Cover siap diupload
                        </p>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });

        // Chapter pages preview
        document.getElementById('chapter_pages').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const preview = document.getElementById('pagesPreview');
            preview.innerHTML = '';
            
            if (files.length > 0) {
                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-md-3 col-sm-4 col-6';
                        col.innerHTML = `
                            <div class="page-preview">
                                <img src="${e.target.result}" alt="Page ${index + 1}">
                                <div class="page-number">Page ${index + 1}</div>
                            </div>
                        `;
                        preview.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
                
                // Show total pages info
                const info = document.createElement('div');
                info.className = 'col-12 mt-2';
                info.innerHTML = `
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Total ${files.length} halaman akan diupload
                    </div>
                `;
                preview.appendChild(info);
            }
        });

        // Form submission with loading state
        document.getElementById('comicForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const form = this;
            
            // Show loading state
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengupload...';
            submitBtn.disabled = true;
            form.classList.add('loading');
            
            // Validate files
            const cover = document.getElementById('cover').files[0];
            const pages = document.getElementById('chapter_pages').files;
            
            if (!cover) {
                e.preventDefault();
                alert('Cover komik harus diupload!');
                submitBtn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Komik';
                submitBtn.disabled = false;
                form.classList.remove('loading');
                return;
            }
            
            if (pages.length === 0) {
                e.preventDefault();
                alert('Halaman chapter harus diupload!');
                submitBtn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Komik';
                submitBtn.disabled = false;
                form.classList.remove('loading');
                return;
            }
            
            // Check file sizes
            if (cover.size > 5 * 1024 * 1024) { // 5MB
                e.preventDefault();
                alert('Ukuran cover terlalu besar! Maksimal 5MB.');
                submitBtn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Komik';
                submitBtn.disabled = false;
                form.classList.remove('loading');
                return;
            }
            
            for (let page of pages) {
                if (page.size > 10 * 1024 * 1024) { // 10MB
                    e.preventDefault();
                    alert('Ukuran halaman terlalu besar! Maksimal 10MB per halaman.');
                    submitBtn.innerHTML = '<i class="bi bi-save me-2"></i>Simpan Komik';
                    submitBtn.disabled = false;
                    form.classList.remove('loading');
                    return;
                }
            }
        });

        // Auto-generate slug preview
        document.getElementById('judul').addEventListener('input', function(e) {
            const title = e.target.value;
            const slug = title.toLowerCase()
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            
            // You can show slug preview if needed
            console.log('Slug preview:', slug);
        });
    </script>
</x-app-layout>