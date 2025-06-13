<x-guest-layout>
    {{-- Mengganti div penjelasan dengan paragraf yang lebih ringkas --}}
    <p class="mb-4 text-white-50 text-center">
        Lupa kata sandi? Cukup masukkan alamat email Anda. Kami akan mengirimkan tautan untuk mengatur ulang kata sandi.
    </p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3"> {{-- Menggunakan mb-3 untuk margin bawah --}}
            {{-- Mengganti x-input-label dengan label Bootstrap --}}
            <label for="email" class="form-label text-white">Email</label>
            {{-- Mengganti x-text-input dengan input Bootstrap --}}
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                   class="form-control bg-dark text-white border-secondary @error('email') is-invalid @enderror" {{-- Menambahkan kelas dark theme --}}
                   placeholder="Masukkan email Anda"> {{-- Menambahkan placeholder --}}
            {{-- Mengganti x-input-error dengan div untuk pesan error Bootstrap --}}
            @error('email')
                <div class="text-danger small mt-2">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-grid mt-4"> {{-- Menggunakan d-grid dan mt-4 untuk tombol penuh lebar dan margin atas --}}
            {{-- Mengganti x-primary-button dengan tombol Bootstrap --}}
            <button type="submit" class="btn btn-primary btn-lg"> {{-- Menggunakan btn-lg agar tombol lebih besar --}}
                Kirim Tautan Atur Ulang Kata Sandi
            </button>
        </div>
    </form>
</x-guest-layout>