<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="h4 mb-0">{{ $komik->judul }} - Chapter {{ $chapter->chapter_number }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('comics.show', $komik->id) }}">{{ $komik->judul }}</a></li>
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
                    @if($chapter->previous_chapter)
                        <a href="{{ route('comics.chapter', [$komik->id, $chapter->previous_chapter]) }}" 
                           class="btn btn-outline-light">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    @endif
                </div>
                <div class="col-md-4 text-center">
                    <select class="form-select" onchange="changeChapter(this.value)">
                        @foreach($komik->chapters as $ch)
                            <option value="{{ $ch->chapter_number }}" 
                                    {{ $ch->chapter_number == $chapter->chapter_number ? 'selected' : '' }}>
                                Chapter {{ $ch->chapter_number }}
                                @if($ch->title)
                                    - {{ $ch->title }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 text-end">
                    @if($chapter->next_chapter)
                        <a href="{{ route('comics.chapter', [$komik->id, $chapter->next_chapter]) }}" 
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
            </div>

            <div class="chapter-images">
                @if($chapter->images)
                    @foreach(json_decode($chapter->images) as $image)
                        <div class="chapter-image mb-3 text-center">
                            <img src="{{ Storage::url($image) }}" 
                                 alt="Chapter {{ $chapter->chapter_number }} - Page {{ $loop->iteration }}" 
                                 class="img-fluid">
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-image display-1 text-muted"></i>
                        <h5 class="mt-3 text-muted">No images available</h5>
                    </div>
                @endif
            </div>
        </div>

        <!-- Chapter Navigation Bottom -->
        <div class="chapter-navigation mt-4">
            <div class="row">
                <div class="col-md-6">
                    @if($chapter->previous_chapter)
                        <a href="{{ route('comics.chapter', [$komik->id, $chapter->previous_chapter]) }}" 
                           class="btn btn-primary">
                            <i class="bi bi-chevron-left"></i> Previous Chapter
                        </a>
                    @endif
                </div>
                <div class="col-md-6 text-end">
                    @if($chapter->next_chapter)
                        <a href="{{ route('comics.chapter', [$komik->id, $chapter->next_chapter]) }}" 
                           class="btn btn-primary">
                            Next Chapter <i class="bi bi-chevron-right"></i>
                        </a>
                    @else
                        <a href="{{ route('comics.show', $komik->id) }}" class="btn btn-outline-light">
                            Back to Comic
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        .chapter-content {
            background-color: var(--section-bg);
            border-radius: 12px;
            padding: 30px;
            border: 1px solid #333;
        }

        .chapter-title {
            color: var(--primary-color);
            font-size: 2rem;
            margin-bottom: 10px;
        }

        .chapter-subtitle {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: normal;
        }

        .chapter-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
        }

        .chapter-navigation {
            background-color: var(--card-bg);
            padding: 20px;
            border-radius: 8px;
            border: 1px solid #444;
        }
    </style>

    <script>
        function changeChapter(chapterNumber) {
            if (chapterNumber) {
                window.location.href = "{{ route('comics.chapter', [$komik->id, '']) }}/" + chapterNumber;
            }
        }
    </script>
</x-app-layout>