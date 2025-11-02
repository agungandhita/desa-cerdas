@extends('auth.layouts.main')

@section('container')
<div class="bg-gradient-to-br from-blue-50 to-indigo-100 font-[sans-serif]">
    <div class="min-h-screen flex flex-col items-center justify-center py-6">
        <div class="max-w-md w-full">
            <div class="text-center mb-8">
                <img src="{{ asset('img/logo.jpeg') }}" alt="logo" class='w-24 h-24 mx-auto mb-4 rounded-full shadow-lg object-cover' />
                <h1 class="text-slate-800 text-3xl font-bold">
                    Konveksi Surabaya
                </h1>
                <p class="text-slate-600 mt-2">Masuk ke akun Anda</p>
            </div>

            <div class="p-8 rounded-2xl bg-white shadow-xl border border-slate-200">


                <form class="space-y-4" action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Email</label>
                        <div class="relative flex items-center">
                            <input name="email" type="email" required value="{{ old('email') }}"
                                   class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600 focus:border-blue-500"
                                   placeholder="Masukkan Email" />
                            <svg xmlns="http://www.w3.org/2000/svg" fill="#bbb" stroke="#bbb" class="w-4 h-4 absolute right-4" viewBox="0 0 24 24">
                                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                            </svg>
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="text-gray-800 text-sm mb-2 block">Password</label>
                        <div class="relative flex items-center">
                            <input id="password" name="password" type="password" required
                                   class="w-full text-slate-800 text-sm border border-slate-300 px-4 py-3 rounded-md outline-blue-600 focus:border-blue-500 pr-10"
                                   placeholder="Masukkan Password" />
                            <button type="button" id="togglePassword" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700">
                                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 11-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="!mt-8">
                        <button type="submit" class="w-full py-3 px-4 text-sm tracking-wide rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition-colors shadow-lg">
                            Masuk
                        </button>
                    </div>
                </form>

                <p class="text-gray-800 text-sm !mt-8 text-center">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline ml-1 whitespace-nowrap font-semibold">
                        Daftar disini
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
