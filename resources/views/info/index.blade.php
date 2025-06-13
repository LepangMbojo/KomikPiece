{{-- resources/views/info/about.blade.php --}}

<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 mb-0 text-white">{{ __('TENTANG KAMI') }}</h2>
    </x-slot>

    <div class="container py-4">
        <div class="section-container">
            <h3 class="text-primary mb-3">Selamat Datang di KomikPiece!</h3>
            <p>
                KomikPiece adalah platform online untuk kalian menikmati berbagai jenis komik. Kami menyajikan beragam genre dan cerita, dirancang agar kalian bisa membaca dengan nyaman kapan saja dan di mana saja. Di sini, kalian bebas menjelajahi koleksi komik kami yang terus bertambah, mencari seri favorit, membaca chapter terbaru, atau bergabung dengan komunitas pembaca lain untuk berbagi pemikiran melalui komentar dan menyimpan komik favorit kalian.
            </p>
            <p>
                Tujuan kami sederhana: membuat pengalaman membaca komik jadi lebih mudah dan menyenangkan. Kami berkomitmen untuk terus menghadirkan konten berkualitas dan menjadi tempat nyaman bagi semua pecinta komik.
            </p>
            <p>
                Website ini merupakan hasil proyek Pemrograman Web dari mahasiswa Teknik Informatika Universitas Mataram, yang dikerjakan oleh tim:
            </p>
            <ul class="list-unstyled text-white-50 ms-3">
                <li><i class="bi bi-person-fill me-2"></i>M. Khalid Al Rejeki</li>
                <li><i class="bi bi-person-fill me-2"></i>Kanda Rifqi Alfaz</li>
                <li><i class="bi bi-person-fill me-2"></i>Yurian Fathur Fajar</li>
                <li><i class="bi bi-person-fill me-2"></i>Nanang Alfian Riski</li>
            </ul>
            <p class="mt-4">
                Selamat menikmati petualangan membaca komik di KomikPiece!
            </p>
        </div>
    </div>
</x-app-layout>