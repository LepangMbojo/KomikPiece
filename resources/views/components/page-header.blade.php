{{-- File: resources/views/components/page-header.blade.php --}}

<div class="d-flex justify-content-between align-items-center">
    {{-- Menampilkan judul yang dikirim dari properti $title --}}
    <h2 class="h4 mb-0">{{ $title }}</h2>

    {{-- Tampilkan breadcrumb hanya jika array $breadcrumbs tidak kosong --}}
    @if(!empty($breadcrumbs))
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                {{-- Lakukan perulangan untuk setiap item breadcrumb --}}
                @foreach ($breadcrumbs as $breadcrumb)
                    {{-- Jika ini adalah item terakhir, buat tidak bisa diklik (active) --}}
                    @if ($loop->last)
                        <li class="breadcrumb-item active" aria-current="page">{{ $breadcrumb['name'] }}</li>
                    @else
                        <li class="breadcrumb-item"><a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['name'] }}</a></li>
                    @endif
                @endforeach
            </ol>
        </nav>
    @endif
</div>