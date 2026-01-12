<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduIde — Masa Depan Edukasi Digital</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #050508; 
            color: #ffffff;
            overflow-x: hidden;
        }

        .glass-main {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(30px);
            -webkit-backdrop-filter: blur(30px);
            border: 1px solid rgba(255, 255, 255, 0.1); 
            box-shadow: 0 25px 80px -12px rgba(79, 70, 229, 0.25);
        }

        .text-glow {
            text-shadow: 0 0 30px rgba(129, 140, 248, 0.4);
        }

        .glow-blob {
            position: fixed;
            width: 600px;
            height: 600px;
            filter: blur(100px);
            border-radius: 50%;
            z-index: 0;
            opacity: 0.4;
            animation: float 20s infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(-5%, -5%) scale(1); }
            100% { transform: translate(10%, 10%) scale(1.1); }
        }

        .feature-card {
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .feature-card:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        #reviewModal { transition: opacity 0.4s ease; }
        .modal-content { transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), opacity 0.4s ease; }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center p-6 relative py-20">
    
    {{-- Decorative Background --}}
    <div class="glow-blob top-[-10%] left-[-10%] bg-indigo-600/30"></div>
    <div class="glow-blob bottom-[-10%] right-[-10%] bg-cyan-500/20"></div>

    <div class="relative z-10 w-full max-w-5xl">
        {{-- Hero Section --}}
        <div class="glass-main rounded-[50px] p-8 md:p-16 lg:p-20 overflow-hidden mb-20">
            <div class="flex justify-center mb-10">
                <div class="px-6 py-2 border border-white/10 rounded-full bg-white/5 backdrop-blur-xl">
                    <span class="text-[10px] font-black tracking-[0.4em] text-indigo-400 uppercase">Evolusi Pembelajaran Digital</span>
                </div>
            </div>

            <div class="text-center mb-16">
                <h1 class="text-7xl md:text-9xl font-extrabold tracking-tighter mb-6 text-glow leading-none">
                    Edu<span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-cyan-400 to-indigo-400">Ide</span>
                </h1>
                <p class="text-gray-400 text-lg md:text-xl font-medium max-w-2xl mx-auto leading-relaxed">
                    Akses kursus teknologi eksklusif tanpa biaya. Bangun portofolio nyata dan <span class="text-white border-b-2 border-indigo-500">terkoneksi langsung</span> dengan standar industri.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
                @php
                    $features = [
                        ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'bg' => 'bg-indigo-500/20', 'text' => 'text-indigo-400', 'title' => 'Kurikulum Adaptif', 'desc' => 'Materi yang selalu diperbarui mengikuti tren teknologi.'],
                        ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'bg' => 'bg-cyan-500/20', 'text' => 'text-cyan-400', 'title' => 'Akses Instan', 'desc' => 'Daftar dalam hitungan detik dan langsung mulai belajar.'],
                        ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'bg' => 'bg-purple-500/20', 'text' => 'text-purple-400', 'title' => 'Sertifikat Valid', 'desc' => 'Dapatkan pengakuan resmi atas keahlian Anda.']
                    ];
                @endphp

                @foreach($features as $f)
                <div class="feature-card p-6 rounded-[32px] bg-white/[0.02]">
                    <div class="w-12 h-12 {{ $f['bg'] }} rounded-2xl flex items-center justify-center mb-4 {{ $f['text'] }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $f['icon'] }}" /></svg>
                    </div>
                    <h3 class="text-sm font-bold mb-2 uppercase tracking-wide">{{ $f['title'] }}</h3>
                    <p class="text-xs text-gray-500 leading-relaxed font-medium">{{ $f['desc'] }}</p>
                </div>
                @endforeach
            </div>

            {{-- CTA Buttons --}}
            <div class="flex flex-col md:flex-row items-center justify-center gap-6">
                {{-- Ke Katalog/Dashboard Utama --}}
                <a href="{{ route('user.dashboard') }}" class="group w-full md:w-auto px-12 py-6 bg-white text-black font-black rounded-[24px] hover:bg-indigo-400 hover:text-white transition-all duration-500 shadow-2xl flex items-center justify-center gap-3">
                    JELAJAHI KURSUS
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                </a>
                
                <div class="flex items-center gap-4 w-full md:w-auto">
                    @auth
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="flex-1 md:flex-none px-10 py-6 border border-white/10 rounded-[24px] bg-white/5 hover:bg-white/10 transition-all text-xs font-bold uppercase tracking-[0.2em] text-center">Admin Panel</a>
                        @else
                            <a href="{{ route('user.enrolled') }}" class="flex-1 md:flex-none px-10 py-6 border border-white/10 rounded-[24px] bg-white/5 hover:bg-white/10 transition-all text-xs font-bold uppercase tracking-[0.2em] text-center">My Learning</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="flex-1 md:flex-none px-10 py-6 border border-white/10 rounded-[24px] bg-white/5 hover:bg-white/10 transition-all text-xs font-bold uppercase tracking-[0.2em] text-center">Login</a>
                        <a href="{{ route('register') }}" class="flex-1 md:flex-none px-10 py-6 border border-white/10 rounded-[24px] bg-white/5 hover:bg-white/10 transition-all text-xs font-bold uppercase tracking-[0.2em] text-center text-indigo-400 border-indigo-500/20">Register</a>
                    @endauth
                </div>
            </div>
        </div>

        {{-- Showcase Section --}}
        <div class="w-full">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-6 mb-10">
                <div class="flex items-center gap-4 flex-grow">
                    <h2 class="text-xs font-black uppercase tracking-[0.4em] text-indigo-400 shrink-0">Showcase & Testimoni</h2>
                    <div class="h-[1px] w-full bg-white/10"></div>
                </div>
                <button onclick="toggleModal()" class="px-6 py-3 bg-indigo-500/10 border border-indigo-500/30 rounded-full text-[10px] font-bold uppercase tracking-widest hover:bg-indigo-500 hover:text-white transition-all">
                    + Tulis Ulasan
                </button>
            </div>

            <div class="flex overflow-x-auto gap-8 pb-10 no-scrollbar snap-x cursor-grab active:cursor-grabbing">
                <div class="min-w-[320px] md:min-w-[450px] snap-center">
                    <div class="glass-main rounded-[32px] overflow-hidden group border-white/5 h-64 relative">
                        <img src="https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=800&q=80" class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-110 transition-transform duration-700" alt="Course">
                        <div class="absolute inset-0 bg-gradient-to-t from-[#050508] to-transparent"></div>
                        <div class="absolute bottom-6 left-6">
                            <span class="px-3 py-1 bg-cyan-500/20 text-cyan-300 text-[10px] font-bold rounded-full border border-cyan-500/30 uppercase">Cybersecurity</span>
                            <h4 class="text-white font-bold mt-2">Ethical Hacking Masterclass</h4>
                        </div>
                    </div>
                </div>

                @forelse($reviews as $review)
                <div class="min-w-[300px] md:min-w-[350px] snap-center">
                    <div class="glass-main p-8 rounded-[32px] h-64 flex flex-col border-white/5 bg-white/[0.01]">
                        <div class="flex gap-1 mb-6 text-yellow-500">
                            @for($i = 0; $i < 5; $i++)
                                <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-400 text-sm italic leading-relaxed mb-6 line-clamp-3">"{{ e($review->message) }}"</p>
                        <div class="mt-auto flex items-center gap-4">
                            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-indigo-500/20 to-purple-500/20 border border-white/10 flex items-center justify-center text-[10px] font-bold text-indigo-300">
                                {{ strtoupper(substr($review->name, 0, 2)) }}
                            </div>
                            <div>
                                <h5 class="text-xs font-bold text-white">{{ e($review->name) }}</h5>
                                <p class="text-[10px] text-gray-600 uppercase tracking-widest">{{ e($review->job) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="min-w-[300px] flex items-center justify-center border-2 border-dashed border-white/10 rounded-[32px]">
                    <p class="text-gray-600 text-xs uppercase tracking-widest">Belum ada ulasan.</p>
                </div>
                @endforelse
            </div>
        </div>

        <div class="mt-16 text-center text-[9px] tracking-[0.4em] uppercase text-gray-800">
            © 2026 EduIde Ecosystem — Disrupting Traditional Education.
        </div>
    </div>

    {{-- Review Modal --}}
    <div id="reviewModal" class="fixed inset-0 z-[100] hidden items-center justify-center p-6 bg-[#050508]/90 backdrop-blur-md opacity-0 transition-opacity duration-300">
        <div class="modal-content glass-main w-full max-w-lg rounded-[40px] p-8 md:p-12 scale-90 opacity-0 border-white/20 shadow-2xl shadow-indigo-500/40">
            <div class="flex justify-between items-center mb-8">
                <h2 class="text-xl font-bold tracking-tight text-white">Kirim Ulasan Anda</h2>
                <button onclick="toggleModal()" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center text-gray-500 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            <form action="{{ route('reviews.store') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" required maxlength="50" placeholder="Alex J." class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-2">Pekerjaan / Status</label>
                    <input type="text" name="job" required maxlength="50" placeholder="Mahasiswa / Designer" class="w-full bg-white/5 border border-white/10 rounded-2xl px-5 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all">
                </div>
                <div>
                    <label class="block text-[10px] font-bold uppercase tracking-widest text-indigo-400 mb-2">Pesan Ulasan</label>
                    <textarea name="message" required maxlength="255" rows="4" placeholder="Bagikan pengalaman belajar Anda..." class="w-full bg-white/5 border border-white/10 rounded-3xl px-5 py-4 text-sm text-white focus:outline-none focus:border-indigo-500 transition-all resize-none"></textarea>
                </div>
                <button type="submit" class="w-full py-5 bg-gradient-to-r from-indigo-600 to-cyan-600 rounded-2xl font-bold text-white text-sm tracking-widest uppercase hover:brightness-125 active:scale-95 transition-all">
                    Kirim Ulasan Sekarang
                </button>
            </form>
        </div>
    </div>

    <script>
        function toggleModal() {
            const modal = document.getElementById('reviewModal');
            const content = modal.querySelector('.modal-content');
            
            if (modal.classList.contains('hidden')) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modal.classList.replace('opacity-0', 'opacity-100');
                    content.classList.replace('scale-90', 'scale-100');
                    content.classList.replace('opacity-0', 'opacity-100');
                }, 10);
            } else {
                modal.classList.replace('opacity-100', 'opacity-0');
                content.classList.replace('scale-100', 'scale-90');
                content.classList.replace('opacity-100', 'opacity-0');
                setTimeout(() => {
                    modal.classList.remove('flex');
                    modal.classList.add('hidden');
                }, 400);
            }
        }
        
        window.onclick = function(event) {
            const modal = document.getElementById('reviewModal');
            if (event.target == modal) toggleModal();
        }
    </script>
</body>
</html>