{{-- File: resources/views/components/nav-link.blade.php --}}

@props(['active' => false])

@php
    // Tentukan class dasar untuk link
    $classes = 'nav-link';

    // Jika properti 'active' yang dikirim bernilai true, tambahkan class 'active'
    if ($active) {
        $classes .= ' active';
    }
@endphp

{{-- 
  Gunakan $attributes->merge untuk menggabungkan semua atribut lain (seperti href)
  dengan class dinamis yang sudah kita buat.
--}}
<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>