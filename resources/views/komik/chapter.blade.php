<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $komik->judul }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('index') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('komik.show', $komik->id) }}">{{ $komik->judul }}</a></li>
                    <li class="breadcrumb-item">Chapter {{ $chapter->chapter_number }}</li>
                </ol>
            </nav>
        </div>
    </x-slot>

      <div class="container py-4">
        <div class="chapter-navigation mb-4">
            <div class="d-flex justify-content-between align-items-center">
                {{-- Tombol Previous --}}
                <div>
                    @if($previousChapter)
                        <a href="{{ route('komik.chapter', [$komik->id, $previousChapter->chapter_number]) }}" class="btn btn-outline-light">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    @else
                         <a href="{{ route('komik.show', $komik->id) }}" class="btn btn-outline-light">
                            <i class="bi bi-arrow-left"></i> Back to Comic
                        </a>
                    @endif
                </div>
                {{-- Dropdown Pilihan Chapter --}}
                <div class="text-center">
                   <select class="form-select" onchange="changeChapter(this.value)">
                        @foreach($komik->chapters->sortBy('chapter_number') as $ch)
                            <option 
                                value="{{   $ch->chapter_number }}"
                                {{ $ch->id === $chapter->id ? 'selected' : '' }}>
                                Chapter {{ $ch->chapter_number }}
                            </option>
                        @endforeach
                    </select>
                </div>
                {{-- Tombol Next --}}
                <div>
                     @if($nextChapter)
                        <a href="{{ route('komik.chapter', [$komik->id, $nextChapter->chapter_number]) }}" class="btn btn-outline-light">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <a href="{{ route('komik.show', $komik->id) }}" class="btn btn-outline-light">
                            Back to Comic <i class="bi bi-arrow-left"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>


        <!-- Chapter Content -->
            <!-- Chapter Text Content (if any) -->
             <div class="chapter-content">
            <div class="chapter-images">
                @forelse($chapter->pages_url as $page_url)
                    <img src="{{ $page_url }}"
                         alt="Page {{ $loop->iteration }}"
                         class="img-fluid chapter-page"
                         loading="lazy"
                         oncontextmenu="return false;"
                         ondragstart="return false;">
                @empty
                    <div class="text-center py-5">
                        <i class="bi bi-image-alt display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">No images available for this chapter.</h5>
                    </div>
                @endforelse
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
</div>

        <!-- Reading Progress -->

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