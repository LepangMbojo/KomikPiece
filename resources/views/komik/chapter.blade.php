<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $komik->judul }} - Chapter {{ $chapter->chapter_number }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('komik.show', $komik->id) }}">{{ $komik->judul }}</a></li>
                    <li class="breadcrumb-item active">Chapter {{ $chapter->chapter_number }}</li>
                </ol>
            </nav>
        </div>
    </x-slot>

    <div class="container py-4">
        <!-- Chapter Navigation -->
        <div class="chapter-navigation mb-4">
            <div class="row">
                <div class="col-md-4">
                    @php
                        $previousChapter = $komik->chapters()
                            ->where('chapter_number', '<', $chapter->chapter_number)
                            ->orderBy('chapter_number', 'desc')
                            ->first();
                    @endphp
                    @if($previousChapter)
                        <a href="{{ route('komik.chapter', [$komik->id, $previousChapter->chapter_number]) }}" 
                           class="btn btn-outline-light">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    @endif
                </div>
                <div class="col-md-4 text-center">
                    <select class="form-select" onchange="changeChapter(this.value)">
                        @if($komik->chapters && $komik->chapters->count() > 0)
                            @foreach($komik->chapters->sortBy('chapter_number') as $ch)
                                <option value="{{ $ch->chapter_number }}" 
                                        {{ $ch->chapter_number == $chapter->chapter_number ? 'selected' : '' }}>
                                    Chapter {{ $ch->chapter_number }}
                                    @if($ch->title)
                                        - {{ $ch->title }}
                                    @endif
                                </option>
                            @endforeach
                        @else
                            <option value="{{ $chapter->chapter_number }}" selected>
                                Chapter {{ $chapter->chapter_number }}
                            </option>
                        @endif
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    @php
                        $nextChapter = $komik->chapters()
                            ->where('chapter_number', '>', $chapter->chapter_number)
                            ->orderBy('chapter_number', 'asc')
                            ->first();
                    @endphp
                    @if($nextChapter)
                        <a href="{{ route('komik.chapter', [$komik->id, $nextChapter->chapter_number]) }}" 
                           class="btn btn-outline-light">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Chapter Content -->
        <div class="chapter-content">
            <div class="chapter-header text-center mb-4">
                <h1 class="chapter-title">Chapter {{ $chapter->chapter_number }}</h1>
                @if($chapter->title)
                    <h2 class="chapter-subtitle">{{ $chapter->title }}</h2>
                @endif
                <div class="chapter-meta mt-2">
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>{{ $chapter->created_at ? $chapter->created_at->format('M d, Y') : 'Unknown date' }}
                        <i class="bi bi-eye ms-3 me-1"></i>{{ number_format($chapter->views ?? 0) }} views
                    </small>
                </div>
            </div>

            <!-- Chapter Text Content (if any) -->
            @if($chapter->content)
                <div class="chapter-text mb-4">
                    <div class="content-wrapper">
                        {!! nl2br(e($chapter->content)) !!}
                    </div>
                </div>
            @endif

            <!-- Chapter Images -->
            <div class="chapter-images">
                {{-- Gunakan accessor pages_url dari model Chapter --}}
                @if($chapter->pages_url && count($chapter->pages_url) > 0)
                    @foreach($chapter->pages_url as $page_url)
                        <div class="chapter-image mb-3 text-center">
                            {{-- $page_url sudah berisi URL yang siap pakai atau URL placeholder dari accessor --}}
                            <img src="{{ $page_url }}"
                                 alt="Page {{ $loop->iteration }}"
                                 class="img-fluid chapter-page"
                                 loading="lazy"
                                 onerror="this.onerror=null; this.src='{{ asset('/placeholder.svg?height=800&width=600&text=Error+Loading+Page') }}'; this.nextElementSibling.style.display='block';">
                            <div class="image-error" style="display: none;">
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle"></i>
                                    Image failed to load: Page {{ $loop->iteration }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-image display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">No images available</h5>
                        <p class="text-muted">This chapter doesn't have any images yet.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Chapter Navigation Bottom -->
        <div class="chapter-navigation mt-4">
            <div class="row">
                <div class="col-md-6">
                    @if(isset($previousChapter))
                        <a href="{{ route('komik.chapter', [$komik->id, $previousChapter->chapter_number]) }}" 
                           class="btn btn-primary">
                            <i class="bi bi-chevron-left"></i> Previous Chapter
                        </a>
                    @else
                        <a href="{{ route('komik.show', $komik->id) }}" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left"></i> Back to Comic
                        </a>
                    @endif
                </div>
                <div class="col-md-6 text-end">
                    @if(isset($nextChapter))
                        <a href="{{ route('komik.chapter', [$komik->id, $nextChapter->chapter_number]) }}" 
                           class="btn btn-primary">
                            Next Chapter <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <a href="{{ route('komik.show', $komik->id) }}" class="btn btn-outline-light">
                            Back to Comic <i class="bi bi-arrow-left"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Reading Progress -->
        <div class="reading-progress mt-4">
            <div class="progress">
                @php
                    $totalChapters = $komik->chapters ? $komik->chapters->count() : 1;
                    $currentPosition = $komik->chapters ? $komik->chapters->where('chapter_number', '<=', $chapter->chapter_number)->count() : 1;
                    $progressPercentage = ($currentPosition / $totalChapters) * 100;
                @endphp
                <div class="progress-bar bg-primary" role="progressbar" 
                     style="width: {{ $progressPercentage }}%" 
                     aria-valuenow="{{ $progressPercentage }}" 
                     aria-valuemin="0" 
                     aria-valuemax="100">
                    {{ round($progressPercentage) }}%
                </div>
            </div>
            <small class="text-muted mt-1 d-block text-center">
                Chapter {{ $chapter->chapter_number }} of {{ $totalChapters }}
            </small>
        </div>
    </div>

    <style>
        .chapter-content {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #333;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        }

        .chapter-title {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 10px;
            font-weight: bold;
        }

        .chapter-subtitle {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: normal;
            margin-bottom: 0;
        }

        .chapter-meta {
            color: #aaa;
            font-size: 0.9rem;
        }

        .chapter-text {
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #444;
            color: #ffffff;
            line-height: 1.8;
        }

        .chapter-page {
        display: block; /* Pastikan gambar adalah elemen block */
        width: 100%;    /* Buat gambar selalu memenuhi lebar kontainer .chapter-image */
                       /* Jika Anda lebih suka gambar tidak meregang jika aslinya kecil, 
                          gunakan max-width: 100%; seperti yang sudah ada */
        height: auto;   /* Pertahankan rasio aspek gambar */
        margin-left: auto;  /* Tengahkan gambar jika display block */
        margin-right: auto; /* Tengahkan gambar jika display block */
        
        /* Gaya Anda yang sudah ada */
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s ease;
        cursor: pointer;
    }

        /* .chapter-page:hover {
            transform: scale(1.02);
        } */

        .chapter-navigation {
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #444;
        }

        .reading-progress {
            background-color: var(--card-bg);
            padding: 15px;
            border-radius: 8px;
            border: 1px solid #444;
        }

        .progress {
            height: 8px;
            background-color: #333;
            border-radius: 4px;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        .image-error {
            padding: 20px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .chapter-title {
                font-size: 1.5rem;
            }
            
            .chapter-subtitle {
                font-size: 1.2rem;
            }
            
            .chapter-content {
                padding: 20px;
            }
            
            .chapter-navigation {
                padding: 15px;
            }
        }

        /* Image zoom on click */
        .chapter-page.zoomed {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) scale(1.5);
            z-index: 9999;
            background: rgba(0, 0, 0, 0.9);
            padding: 20px;
            border-radius: 8px;
        }

        .zoom-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            z-index: 9998;
            display: none;
        }
    </style>

   <script>
    function changeChapter(chapterNumber) {
        if (chapterNumber && chapterNumber !== '{{ $chapter->chapter_number }}') {
            window.location.href = `/komik/{{ $komik->id }}/chapter/${chapterNumber}`;
        }
    }

        // Image zoom functionality
        document.addEventListener('DOMContentLoaded', function() {
            const images = document.querySelectorAll('.chapter-page');
            const body = document.body;
            
            images.forEach(img => {
                img.addEventListener('click', function() {
                    if (this.classList.contains('zoomed')) {
                        this.classList.remove('zoomed');
                        document.querySelector('.zoom-overlay')?.remove();
                    } else {
                        // Remove any existing zoom
                        document.querySelectorAll('.chapter-page.zoomed').forEach(zoomedImg => {
                            zoomedImg.classList.remove('zoomed');
                        });
                        document.querySelector('.zoom-overlay')?.remove();
                        
                        // Add overlay
                        const overlay = document.createElement('div');
                        overlay.className = 'zoom-overlay';
                        overlay.style.display = 'block';
                        overlay.addEventListener('click', () => {
                            this.classList.remove('zoomed');
                            overlay.remove();
                        });
                        body.appendChild(overlay);
                        
                        // Zoom image
                        this.classList.add('zoomed');
                    }
                });
            });

            // Keyboard navigation
            document.addEventListener('keydown', function(e) {
                if (e.key === 'ArrowLeft') {
                    const prevBtn = document.querySelector('a[href*="chapter"]:has(.bi-chevron-left)');
                    if (prevBtn) prevBtn.click();
                } else if (e.key === 'ArrowRight') {
                    const nextBtn = document.querySelector('a[href*="chapter"]:has(.bi-chevron-right)');
                    if (nextBtn) nextBtn.click();
                } else if (e.key === 'Escape') {
                    document.querySelectorAll('.chapter-page.zoomed').forEach(img => {
                        img.classList.remove('zoomed');
                    });
                    document.querySelector('.zoom-overlay')?.remove();
                }
            });
        });

        // Auto-scroll to next image when reaching bottom
        let isScrolling = false;
        window.addEventListener('scroll', function() {
            if (!isScrolling) {
                window.requestAnimationFrame(function() {
                    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                    const windowHeight = window.innerHeight;
                    const documentHeight = document.documentElement.scrollHeight;
                    
                    // If user scrolled to bottom, show next chapter hint
                    if (scrollTop + windowHeight >= documentHeight - 100) {
                        const nextBtn = document.querySelector('.btn-primary:has(.bi-chevron-right)');
                        if (nextBtn && !nextBtn.classList.contains('pulse')) {
                            nextBtn.classList.add('pulse');
                            setTimeout(() => nextBtn.classList.remove('pulse'), 2000);
                        }
                    }
                    
                    isScrolling = false;
                });
                isScrolling = true;
            }
        });
    </script>

    <style>
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .pulse {
            animation: pulse 0.5s ease-in-out 3;
        }
    </style>
</x-app-layout>