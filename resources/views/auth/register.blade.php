<x-guest-layout>
    <div class="flex flex-col md:flex-row w-full max-w-4xl rounded-[24px] shadow-2xl overflow-hidden min-h-[600px] border border-pink-200" style="background-color: #FFF0F3;">
        
        <div class="w-full md:w-5/12 relative flex items-center justify-end overflow-hidden z-10 clip-splash-register" 
             style="background-color: #FF93BF; background-image: url('{{ asset('images/background.jpeg') }}'); background-size: cover; background-position: center;">
            
            <div class="relative z-20 flex flex-col items-center justify-center space-y-12 w-[160px] h-full pr-4">
                <div class="text-gray-900 w-[120px] py-3.5 rounded-l-full flex items-center justify-center font-bold text-xl translate-x-4 bg-[#FFF0F3] shadow-md shadow-pink-300/20">
                    Register
                </div>

                <a href="{{ route('login') }}" class="text-white font-bold text-lg opacity-80 hover:opacity-100 transform hover:scale-105 transition-all duration-300">
                    Login
                </a>
            </div>
        </div>

        <div class="w-full md:w-7/12 p-10 md:p-14 flex flex-col justify-center overflow-y-auto max-h-[750px] -ml-12 pl-20 relative z-0" style="background-color: #FFF0F3;">
            <h2 class="text-4xl font-bold text-gray-800 mb-8 tracking-tight">REGISTER</h2>

            <form method="POST" action="{{ route('register') }}" x-data="{ role: 'Ibu Hamil' }" class="space-y-4">
                @csrf

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">👤</span>
                        <input type="text" name="name" value="{{ old('name') }}" required autofocus class="w-full pl-12 pr-4 py-2.5 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all duration-300 shadow-sm shadow-pink-50" placeholder="Masukkan nama Anda">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 ml-2" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">📧</span>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full pl-12 pr-4 py-2.5 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all duration-300 shadow-sm shadow-pink-50" placeholder="Masukkan email Anda">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 ml-2" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">🔒</span>
                        <input type="password" name="password" required class="w-full pl-12 pr-4 py-2.5 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all duration-300 shadow-sm shadow-pink-50" placeholder="Masukkan password Anda">
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1 ml-2 font-medium leading-tight">
                        *Wajib mengandung huruf KAPITAL, angka, karakter khusus (@$!%*?&), max 16 karakter.
                    </p>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 ml-2" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">🔒</span>
                        <input type="password" name="password_confirmation" required class="w-full pl-12 pr-4 py-2.5 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all duration-300 shadow-sm shadow-pink-50" placeholder="Ketik ulang password Anda">
                    </div>
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 ml-2" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Role</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">👥</span>
                        <select id="role" name="role" x-model="role" class="w-full pl-12 pr-4 py-2.5 border border-pink-200 rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none bg-white text-sm font-medium text-gray-700 shadow-sm shadow-pink-50">
                            <option value="Ibu Hamil">Ibu Hamil</option>
                            <option value="Bidan">Bidan</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div x-show="role === 'Bidan' || role === 'Admin'" x-transition class="mt-2 bg-pink-50 p-4 rounded-[18px] border border-pink-200">
                    <label class="text-[10px] font-bold text-pink-700 uppercase ml-1">Kode Otorisasi Petugas</label>
                    <input type="password" name="secret_key" class="w-full mt-1 px-4 py-2 border border-pink-300 rounded-xl outline-none bg-white" placeholder="Masukkan kode rahasia">
                    <x-input-error :messages="$errors->get('secret_key')" class="mt-1" />
                </div>

                <button type="submit" class="w-full bg-[#F875AA] hover:bg-[#E91E8C] text-white font-bold py-4 rounded-[18px] shadow-lg shadow-pink-200 uppercase tracking-widest mt-4 transition-all duration-300 transform hover:-translate-y-0.5">
                    REGISTER
                </button>

                <p class="text-center text-sm text-gray-400 mt-4 font-medium">
                    Already registered? <a href="{{ route('login') }}" class="text-pink-500 font-bold hover:underline transition-all">LOG IN</a>
                </p>
            </form>
        </div>
    </div>

    <style>
        .clip-splash-register {
            clip-path: url(#splash-register-clip);
        }
    </style>

    <svg width="0" height="0" class="absolute">
        <defs>
            <clipPath id="splash-register-clip" clipPathUnits="objectBoundingBox">
                <path d="M 0,0 
                         L 0.85,0 
                         L 0.85,0.15 
                         C 0.85,0.23 1,0.26 1,0.35
                         C 1,0.44 0.85,0.47 0.85,0.55 
                         L 0.85,1 
                         L 0,1 Z" />
            </clipPath>
        </defs>
    </svg>
    @include('partials.alerts')
</x-guest-layout>