<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bumiloo - Konsultasi Pasien</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-black font-sans flex h-screen overflow-hidden">

    <aside class="w-64 bg-[#f472b6] text-white flex flex-col justify-between shadow-lg z-10 border-r border-pink-400">
        <div>
            <div class="p-6 flex flex-col items-center border-b border-pink-300">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center shadow-inner mb-2">
                    <i class="fa-solid fa-baby text-[#f472b6] text-3xl"></i>
                </div>
                <span class="text-sm font-bold tracking-wider">Bumil</span>
            </div>

            <nav class="p-4 space-y-2 text-sm font-medium">
                <a href="{{ route('bumil.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/20 transition">
                    <i class="fa-solid fa-house w-5"></i>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('bumil.konsultasi') }}" class="flex items-center space-x-3 p-3 rounded-xl bg-white/20 font-bold shadow-sm">
                    <i class="fa-solid fa-comment-medical w-5"></i>
                    <span>Konsultasi</span>
                </a>

                <a href="{{ route('bumil.riwayat') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/20 transition">
                    <i class="fa-solid fa-chart-line w-5"></i>
                    <span>Riwayat Perkembangan</span>
                </a>

                <a href="{{ route('bumil.hpl') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/20 transition">
                    <i class="fa-solid fa-calendar-check w-5"></i>
                    <span>HPL</span>
                </a>

                <a href="{{ route('bumil.reminder') }}" class="flex items-center space-x-3 p-3 rounded-xl hover:bg-white/20 transition">
                    <i class="fa-solid fa-clock w-5"></i>
                    <span>Reminder</span>
                </a>
            </nav>
        </div>
        
        <div class="p-4 text-center text-xs border-t border-pink-300 bg-pink-600/10">
            <span>Bumiloo Apps © 2026</span>
        </div>
    </aside>

    <div class="flex-1 flex flex-col h-full bg-[#1a1a1a]">
        
        <header class="bg-[#f472b6] text-white px-8 py-4 flex justify-between items-center shadow-md z-10">
            <h1 class="text-2xl font-bold tracking-wide">Bumiloo</h1>
            
            <div class="flex items-center space-x-6">
                <div class="relative">
                    <input type="text" placeholder="Cari..." class="pl-4 pr-10 py-1.5 bg-white rounded-lg text-sm border-none text-gray-700 focus:outline-none w-60 shadow-sm">
                    <i class="fa-solid fa-magnifying-glass absolute right-3 top-2.5 text-gray-400 text-sm"></i>
                </div>
                
                <button class="relative hover:text-pink-100 transition focus:outline-none" onclick="alert('Belum ada notifikasi baru')">
                    <i class="fa-solid fa-bell text-xl"></i>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold">1</span>
                </button>

                <div class="flex items-center space-x-3 border-l pl-4 border-pink-300">
                    <button class="hover:text-pink-100 transition" onclick="alert('Membuka Pengaturan Profil')">
                        <i class="fa-solid fa-circle-user text-2xl"></i>
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-xs bg-red-500 hover:bg-red-600 px-3 py-1.5 rounded-lg transition font-semibold text-white">Keluar</button>
                    </form>
                </div>
            </div>
        </header>

        <div class="flex-1 flex p-6 gap-6 overflow-hidden">
            
            <div class="w-80 bg-white rounded-2xl p-6 flex flex-col items-center shadow-lg border border-gray-100">
                <h3 class="text-gray-800 font-bold text-sm self-start mb-6">Bidan Praktik</h3>
                
                <div class="w-32 h-32 bg-gray-50 border-4 border-gray-200 rounded-full flex items-center justify-center mb-4 shadow-inner">
                    <i class="fa-solid fa-user-nurse text-gray-400 text-6xl"></i>
                </div>
                
                <h4 class="text-gray-800 font-bold text-base mb-1">Bidan Praktik</h4>
                
                <span class="bg-green-100 text-green-600 text-xs font-bold px-3 py-1 rounded-full mb-6 flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-green-500 rounded-full animate-pulse"></span>
                    Online
                </span>

                <div class="w-full bg-pink-50/50 border border-pink-100 rounded-xl p-4 mb-4">
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-calendar-days text-gray-700 mt-0.5"></i>
                        <div>
                            <h5 class="text-xs font-bold text-gray-800 mb-1">Jadwal Praktik</h5>
                            <p class="text-xs text-gray-600 leading-relaxed">Praktik setiap hari<br>08.00-16.00</p>
                        </div>
                    </div>
                </div>

                <div class="w-full bg-pink-100/60 border border-pink-200 rounded-xl p-4 flex-1 overflow-y-auto">
                    <div class="flex items-start space-x-3">
                        <i class="fa-solid fa-lightbulb text-pink-500 mt-0.5"></i>
                        <div>
                            <h5 class="text-xs font-bold text-pink-700 mb-1">Tips</h5>
                            <p class="text-xs text-pink-800 leading-relaxed">Diskusikan keluhan Anda dengan bidan secara terbuka agar mendapatkan saran yang tepat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex-1 bg-white rounded-2xl flex flex-col shadow-lg overflow-hidden border border-gray-100">
                
                <div class="p-4 bg-gray-50 border-b border-gray-100 flex justify-between items-center px-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center">
                            <i class="fa-solid fa-user-nurse text-gray-500"></i>
                        </div>
                        <div>
                            <h4 class="text-sm font-bold text-gray-800">Bidan Praktik</h4>
                            <span class="text-[11px] text-green-500 font-semibold flex items-center gap-1">
                                <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> Online
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('bumil.dashboard') }}" class="border-2 border-pink-400 text-pink-500 hover:bg-pink-50 text-xs font-bold px-4 py-2 rounded-xl transition flex items-center space-x-2 shadow-sm">
                        <i class="fa-solid fa-right-from-bracket"></i>
                        <span>Akhiri chat</span>
                    </a>
                </div>

                <div id="chat-messages" class="flex-1 p-6 overflow-y-auto bg-gradient-to-br from-[#4a3b45] to-[#201c24] space-y-4">
                    
                    <div class="flex justify-center my-2">
                        <span class="bg-white/10 text-white text-[11px] px-3 py-1 rounded-lg">Hari ini</span>
                    </div>

                    <div class="flex justify-end">
                        <div class="max-w-md bg-[#fbcfe8] text-gray-800 p-4 rounded-2xl rounded-tr-none shadow-md text-xs leading-relaxed">
                            <p>Selamat pagi Bu Bidan, saya mau tanya. Sudah 2 hari ini saya mual dan muntah, apakah itu normal ya?</p>
                            <span class="block text-[9px] text-gray-500 text-right mt-1.5">09.25</span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2.5">
                        <div class="w-7 h-7 bg-white rounded-full flex items-center justify-center text-xs shadow-sm mt-1">
                            <i class="fa-solid fa-user-nurse text-gray-600"></i>
                        </div>
                        <div class="max-w-md bg-white text-gray-800 p-4 rounded-2xl rounded-tl-none shadow-md text-xs leading-relaxed">
                            <p>Selamat pagi, Bunda. Mual dan muntah di trimester pertama itu hal yang wajar kok, Bun.</p>
                            <span class="block text-[9px] text-gray-400 mt-1.5">09.25</span>
                        </div>
                    </div>

                    <div class="flex items-start space-x-2.5">
                        <div class="w-7 h-7 bg-white rounded-full flex items-center justify-center text-xs shadow-sm mt-1">
                            <i class="fa-solid fa-user-nurse text-gray-600"></i>
                        </div>
                        <div class="max-w-md bg-white text-gray-800 p-4 rounded-2xl rounded-tl-none shadow-md text-xs leading-relaxed">
                            <p>Biasanya mual dan muntah akan berkurang di usia kehamilan 12-14 minggu. Coba Bunda:<br>- Makan sedikit tapi sering<br>- Hindari makanan berlemak<br>- Minum air putih yang cukup</p>
                            <p class="mt-2">Jika muntah berlebihan hingga lemas, segera periksa ya, Bun.</p>
                            <span class="block text-[9px] text-gray-400 mt-1.5">09.25</span>
                        </div>
                    </div>
                    
                </div>

                <div class="p-4 bg-white border-t border-gray-100 px-6">
                    <form onsubmit="sendMessage(event)" class="flex items-center space-x-3">
                        <div class="flex-1 bg-gray-50 border rounded-xl flex items-center px-4 py-1.5 focus-within:border-pink-400 transition">
                            <button type="button" class="text-gray-400 hover:text-gray-600 mr-2" onclick="alert('Fitur Upload File Terpilih')">
                                <i class="fa-solid fa-paperclip text-sm"></i>
                            </button>
                            <input type="text" id="input-message" placeholder="Ketik pesan....." required
                                class="w-full bg-transparent border-none text-xs text-gray-700 outline-none focus:ring-0 py-2">
                        </div>
                        
                        <button type="submit" class="bg-[#e04f8c] hover:bg-pink-600 text-white w-10 h-10 rounded-full flex items-center justify-center shadow-md transition transform active:scale-95">
                            <i class="fa-solid fa-paper-plane text-xs pl-0.5"></i>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <script>
        function sendMessage(event) {
            event.preventDefault();
            const input = document.getElementById('input-message');
            const container = document.getElementById('chat-messages');
            
            if (input.value.trim() === '') return;

            const timeNow = new Date().toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit' });

            // Menempelkan bubble chat baru buatan user ke layar secara langsung
            const dynamicChatHTML = `
                <div class="flex justify-end">
                    <div class="max-w-md bg-[#fbcfe8] text-gray-800 p-4 rounded-2xl rounded-tr-none shadow-md text-xs leading-relaxed">
                        <p>${input.value}</p>
                        <span class="block text-[9px] text-gray-500 text-right mt-1.5">${timeNow}</span>
                    </div>
                </div>
            `;

            container.insertAdjacentHTML('beforeend', dynamicChatHTML);
            input.value = '';
            
            // Auto Scroll otomatis ke bagian paling bawah
            container.scrollTop = container.scrollHeight;
        }
    </script>
</body>
</html>