<x-guest-layout>
    <div x-data="{ isRegister: new URLSearchParams(window.location.search).get('action') === 'register' }" 
         class="flex flex-col md:flex-row w-full max-w-4xl rounded-[24px] shadow-2xl overflow-hidden min-h-[600px] border border-pink-200 relative bg-[#FFF0F3]">
        
        <div class="w-full md:w-1/2 p-10 md:p-14 flex flex-col justify-center transition-all duration-500"
             :class="isRegister ? 'opacity-0 pointer-events-none' : 'opacity-100'">
            <h2 class="text-4xl font-bold text-gray-800 mb-8 tracking-tight">LOGIN</h2>

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">📧</span>
                        <input type="email" name="email" value="{{ old('email') }}" required autofocus class="w-full pl-12 pr-4 py-2.5 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all shadow-sm shadow-pink-50" placeholder="Masukkan email Anda">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 ml-2" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">🔒</span>
                        <input type="password" name="password" required class="w-full pl-12 pr-4 py-2.5 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all shadow-sm shadow-pink-50" placeholder="Masukkan password Anda">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 ml-2" />
                </div>

                <div class="flex items-center ml-1">
                    <input type="checkbox" name="remember" id="remember" class="rounded border-gray-300 text-pink-500 focus:ring-pink-500">
                    <label for="remember" class="ml-2 text-sm text-gray-500 font-medium">Remember me</label>
                </div>

                <button type="submit" class="w-full bg-[#F875AA] hover:bg-[#E91E8C] text-white font-bold py-4 rounded-[18px] shadow-lg shadow-pink-200 uppercase tracking-widest mt-4 transition-all duration-300 transform hover:-translate-y-0.5">
                    LOG IN
                </button>

                <p class="text-center text-sm text-gray-400 mt-4 font-medium">
                    Don't have an account? <button type="button" @click="isRegister = true; window.history.pushState({}, '', '?action=register')" class="text-pink-500 font-bold hover:underline">Register here</button>
                </p>
            </form>
        </div>

        <div class="w-full md:w-1/2 p-10 md:p-14 flex flex-col justify-center transition-all duration-500 absolute top-0 right-0 h-full"
             :class="isRegister ? 'opacity-100 pointer-events-auto' : 'opacity-0 pointer-events-none'">
            <h2 class="text-4xl font-bold text-gray-800 mb-6 tracking-tight">REGISTER</h2>

            <form method="POST" action="{{ route('register') }}" x-data="{ role: 'Ibu Hamil' }" class="space-y-3">
                @csrf
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Name</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">👤</span>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full pl-12 pr-4 py-2 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all" placeholder="Masukkan nama Anda">
                    </div>
                    <x-input-error :messages="$errors->get('name')" class="mt-1 ml-2" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Email</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">📧</span>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full pl-12 pr-4 py-2 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all" placeholder="Masukkan email Anda">
                    </div>
                    <x-input-error :messages="$errors->get('email')" class="mt-1 ml-2" />
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">🔒</span>
                        <input type="password" name="password" required class="w-full pl-12 pr-4 py-2 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all" placeholder="Masukkan password Anda">
                    </div>
                    <p class="text-[9px] text-gray-400 mt-1 ml-2 font-medium leading-tight">
                        *Wajib berisi huruf KAPITAL, angka, karakter khusus (@$!%*?&), min 8 karakter.
                    </p>
                    <x-input-error :messages="$errors->get('password')" class="mt-1 ml-2" />
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Confirm Password</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">✅</span>
                        <input type="password" name="password_confirmation" required 
                        class="w-full pl-12 pr-4 py-2 border border-pink-200 bg-white rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none transition-all shadow-sm shadow-pink-50" 
                        placeholder="Ulangi password Anda">
                    </div>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-gray-400 mb-1 ml-1 uppercase">Role</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">👥</span>
                        <select id="role" name="role" x-model="role" class="w-full pl-12 pr-4 py-2 border border-pink-200 rounded-[18px] focus:border-pink-400 focus:ring-0 outline-none bg-white text-sm font-medium text-gray-700">
                            <option value="Ibu Hamil">Ibu Hamil</option>
                            <option value="Bidan">Bidan</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>

                <div x-show="role === 'Bidan' || role === 'Admin'" x-transition class="mt-1 bg-pink-50 p-3 rounded-[18px] border border-pink-200">
                    <label class="text-[10px] font-bold text-pink-700 uppercase ml-1">Kode Otorisasi</label>
                    <input type="password" name="secret_key" class="w-full mt-1 px-4 py-1.5 border border-pink-300 rounded-xl outline-none bg-white" placeholder="Masukkan kode rahasia">
                    <x-input-error :messages="$errors->get('secret_key')" class="mt-1- petugas" />
                </div>

                <button type="submit" class="w-full bg-[#F875AA] hover:bg-[#E91E8C] text-white font-bold py-3.5 rounded-[18px] shadow-lg shadow-pink-200 uppercase tracking-widest mt-2 transition-all">
                    REGISTER
                </button>

                <p class="text-center text-sm text-gray-400 mt-3 font-medium">
                    Already registered? <button type="button" @click="isRegister = false; window.history.pushState({}, '', '?action=login')" class="text-pink-500 font-bold hover:underline">LOG IN</button>
                </p>
            </form>
        </div>

        <div class="hidden md:flex absolute top-0 w-1/2 h-full z-20 transition-all duration-700 ease-in-out overflow-hidden"
             :class="isRegister ? 'left-0 rounded-r-[60px] rounded-l-none' : 'left-1/2 rounded-l-[60px] rounded-r-none'"
             style="background-color: #FF93BF; background-image: url('{{ asset('images/background.jpeg') }}'); background-size: cover; background-position: center;">
            
            <div class="absolute inset-0 bg-pink-900/10 pointer-events-none"></div>

            <div class="relative z-30 flex flex-col items-center justify-center space-y-8 w-full h-full text-white px-10 text-center">
                <div class="transition-all duration-500 transform" :class="isRegister ? 'scale-100' : 'scale-95'">
                    <h3 class="text-3xl font-extrabold mb-3 tracking-wide" x-text="isRegister ? 'Sudah Punya Akun?' : 'Halo Ibu Hebat!'"></h3>
                    <p class="text-sm opacity-90 px-2 mb-8 leading-relaxed" x-text="isRegister ? 'Yuk masuk kembali ke sistem untuk melanjutkan pemantauan kesehatan bersama Bumiloo.' : 'Mulai perjalanan kehamilan yang aman dan terpantau bersama aplikasi Bumiloo.'"></p>
                    
                    <button type="button" @click="isRegister = !isRegister; window.history.pushState({}, '', isRegister ? '?action=login' : '?action=register')" 
                            class="px-10 py-3.5 border-2 border-white rounded-full font-bold text-sm tracking-widest uppercase hover:bg-white hover:text-pink-500 transition-all duration-300 shadow-xl transform active:scale-95">
                        <span x-text="isRegister ? 'LOG IN' : 'REGISTER'"></span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>