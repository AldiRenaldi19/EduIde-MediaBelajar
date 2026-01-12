<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - EduIde</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background-color: #050508; 
            color: #ffffff;
        }

        .glass-nav {
            background: rgba(10, 10, 15, 0.7);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
        }

        .form-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: #ffffff;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-input:focus {
            outline: none;
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(79, 70, 229, 0.5);
            box-shadow: 0 0 20px rgba(79, 70, 229, 0.2);
        }

        .form-input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .avatar-preview {
            width: 120px;
            height: 120px;
            border-radius: 16px;
            object-fit: cover;
            border: 2px solid rgba(79, 70, 229, 0.3);
        }

        .error-message {
            color: #f87171;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .success-message {
            color: #86efac;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }
    </style>
</head>
<body class="min-h-screen">
    {{-- Navigation Top --}}
    <nav class="glass-nav sticky top-0 z-50">
        <div class="container mx-auto px-4 md:px-6 py-4">
            <div class="flex items-center justify-between">
                <a href="{{ route('profile') }}" class="flex items-center gap-2 group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-500 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="text-sm font-bold text-gray-400 group-hover:text-white transition-colors">Kembali ke Profil</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 md:px-6 py-12">
        <div class="max-w-2xl mx-auto">
            {{-- Page Header --}}
            <div class="mb-12">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-4">Edit Profil</h1>
                <p class="text-gray-400 text-lg">Perbarui informasi akun Anda</p>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-[16px] text-emerald-300 text-sm font-bold">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Edit Profile Form --}}
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="glass-card rounded-[32px] p-8 md:p-12 border border-white/10 mb-8">
                @csrf
                @method('PUT')

                {{-- Avatar Section --}}
                <div class="mb-10 pb-10 border-b border-white/10">
                    <label class="block text-sm font-black uppercase tracking-widest text-gray-400 mb-6">Foto Profil</label>
                    
                    <div class="flex items-end gap-8">
                        <div class="relative group">
                            @if(auth()->user()->avatar)
                                <img src="{{ auth()->user()->avatar }}" alt="Avatar" class="avatar-preview">
                            @else
                                <div class="w-[120px] h-[120px] rounded-[16px] bg-indigo-600/20 border-2 border-indigo-500/30 flex items-center justify-center text-4xl font-black text-indigo-400">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            @endif
                            <div class="absolute inset-0 rounded-[16px] bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>

                        <div class="flex-grow">
                            <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                            <label for="avatar" class="inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-[12px] text-sm font-bold uppercase tracking-wider cursor-pointer transition-all active:scale-95">
                                Ubah Foto
                            </label>
                            <p class="text-xs text-gray-500 mt-2">JPG, PNG, WEBP • Maks 2MB</p>
                        </div>
                    </div>
                </div>

                {{-- Name Field --}}
                <div class="mb-8">
                    <label for="name" class="block text-sm font-black uppercase tracking-widest text-gray-400 mb-3">Nama Lengkap</label>
                    <input type="text" name="name" id="name" value="{{ old('name', auth()->user()->name) }}" 
                           class="w-full form-input @error('name') border-red-500 @enderror" 
                           placeholder="Masukkan nama lengkap Anda">
                    @error('name')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email Field --}}
                <div class="mb-8">
                    <label for="email" class="block text-sm font-black uppercase tracking-widest text-gray-400 mb-3">Email</label>
                    <input type="email" name="email" id="email" value="{{ old('email', auth()->user()->email) }}" 
                           class="w-full form-input @error('email') border-red-500 @enderror" 
                           placeholder="Masukkan email Anda">
                    @error('email')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-[16px] font-bold uppercase tracking-wider transition-all active:scale-95 shadow-lg shadow-indigo-600/20">
                        💾 Simpan Perubahan
                    </button>
                    <a href="{{ route('profile') }}" class="flex-1 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-center rounded-[16px] font-bold uppercase tracking-wider transition-all">
                        Batal
                    </a>
                </div>
            </form>

            {{-- Change Password Link --}}
            <div class="glass-card rounded-[24px] p-8 border border-white/10">
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-lg font-bold text-white mb-1">Ubah Password</h3>
                        <p class="text-gray-400 text-sm">Perbarui password akun Anda secara berkala untuk keamanan maksimal</p>
                    </div>
                    <a href="{{ route('password.change') }}" class="px-6 py-3 bg-indigo-600/20 hover:bg-indigo-600/30 border border-indigo-500/30 text-indigo-300 rounded-[12px] font-bold uppercase tracking-wider text-sm transition-all">
                        Ubah Password
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewAvatar(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('.avatar-preview') || 
                               document.querySelector('[style*="background"]');
                    if (document.querySelector('.avatar-preview')) {
                        document.querySelector('.avatar-preview').src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        }
    </script>
</body>
</html>
