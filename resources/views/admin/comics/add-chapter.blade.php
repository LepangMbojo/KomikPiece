<x-app-layout>
    {{-- Header Halaman Tambah Chapter --}}
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h2 class="h4 mb-0">Tambah Chapter Baru</h2>
                <small class="text-muted">Untuk Komik: {{ $komik->judul }}</small>
            </div>
            <a href="{{ route('admin.comics.show', $komik->id) }}" class="btn btn-outline-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i>Kembali ke Detail Komik
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

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            {{-- Form mengarah ke route 'chapters.store' dengan method 'POST' --}}
            <form action="{{ route('admin.comics.chapters.store', $komik->id) }}" method="POST" enctype="multipart/form-data" id="chapterForm">
                @csrf
                
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-file-earmark-plus me-2"></i>Detail Chapter Baru</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="chapter_number" class="form-label">Nomor Chapter *</label>
                                {{-- Controller sebaiknya mengirimkan $nextChapterNumber untuk kemudahan pengguna --}}
                                <input type="number" class="form-control" id="chapter_number" name="chapter_number" 
                                       min="0.1" step="0.1" value="{{ old('chapter_number', $nextChapterNumber ?? 1) }}" required>
                                <div class="form-text">Bisa menggunakan desimal, contoh: 1, 2, 3.5, 4</div>
                            </div>
                            
                            <div class="col-md-6">
                                <label for="title" class="form-label">Judul Chapter</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="{{ old('title') }}" placeholder="Opsional, misal: 'Awal Mula Petualangan'">
                            </div>
                            
                            <div class="col-12">
                                <label for="chapter_pages" class="form-label">Halaman Chapter *</label>
                                {{-- Nama input adalah 'chapter_pages[]' untuk multiple file upload --}}
                                <input type="file" class="form-control" id="chapter_pages" name="chapter_pages[]" 
                                       multiple accept="image/*" required>
                                <div class="form-text">
                                    Upload semua gambar untuk chapter ini. Format: JPG, PNG, GIF, WEBP. Max 10MB per file.
                                    <br>Tip: Urutkan nama file sesuai urutan halaman sebelum di-upload (misal: 01.jpg, 02.jpg, ...).
                                </div>
                                
                                <div id="pagesPreview" class="mt-3 row g-2"></div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary btn-lg" id="submitBtn">
                        <i class="bi bi-save me-2"></i>Simpan Chapter
                    </button>
                    <a href="{{ route('admin.comics.show', $komik->id) }}" class="btn btn-secondary btn-lg ms-2">
                        <i class="bi bi-x-circle me-2"></i>Batal
                    </a>
                </div>
            </form>
        </div>
    </div>

    <style>
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
        // Script untuk preview halaman chapter (sama seperti di form create)
        document.getElementById('chapter_pages').addEventListener('change', function(e) {
            const files = Array.from(e.target.files);
            const preview = document.getElementById('pagesPreview');
            preview.innerHTML = '';
            
            if (files.length > 0) {
                // Urutkan file berdasarkan nama secara alfanumerik
                files.sort((a, b) => a.name.localeCompare(b.name, undefined, { numeric: true, sensitivity: 'base' }));

                files.forEach((file, index) => {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const col = document.createElement('div');
                        col.className = 'col-lg-2 col-md-3 col-sm-4 col-6'; // Dibuat lebih responsif
                        col.innerHTML = `
                            <div class="page-preview" title="${file.name}">
                                <img src="${e.target.result}" alt="Page ${index + 1}">
                                <div class="page-number">Hal. ${index + 1}</div>
                            </div>
                        `;
                        preview.appendChild(col);
                    };
                    reader.readAsDataURL(file);
                });
                
                const info = document.createElement('div');
                info.className = 'col-12 mt-2';
                info.innerHTML = `
                    <div class="alert alert-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Total ${files.length} halaman akan diupload (sudah diurutkan berdasarkan nama file).
                    </div>
                `;
                preview.appendChild(info);
            }
        });

        // Form submission dengan loading state
        document.getElementById('chapterForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            const form = this;
            const pages = document.getElementById('chapter_pages').files;

            if (pages.length === 0) {
                e.preventDefault(); // Hentikan submit jika tidak ada file
                alert('Anda harus mengupload setidaknya satu halaman chapter!');
                return;
            }

            // Validasi ukuran file
            for (let page of pages) {
                if (page.size > 10 * 1024 * 1024) { // 10MB
                    e.preventDefault();
                    alert(`Ukuran file "${page.name}" terlalu besar! Maksimal 10MB per halaman.`);
                    return;
                }
            }
            
            submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Mengupload...';
            submitBtn.disabled = true;
            form.classList.add('loading');
        });
    </script>
</x-app-layout>