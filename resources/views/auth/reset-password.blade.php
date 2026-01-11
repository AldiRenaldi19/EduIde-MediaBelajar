<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi - EduIde</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050508; color: #ffffff; overflow: hidden; }
        .glass-auth { background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(30px); border: 1px solid rgba(255, 255, 255, 0.08); }
        .input-glass { background: rgba(255, 255, 255, 0.03); border: 1px solid rgba(255, 255, 255, 0.08); transition: all 0.3s; }
        .input-glass:focus { border-color: rgba(99, 102, 241, 0.5); background: rgba(99, 102, 241, 0.03); outline: none; box-shadow: 0 0 20px rgba(99, 102, 241, 0.1); }
        .glow { position: fixed; width: 500px; height: 500px; filter: blur(120px); border-radius: 50%; z-index: -1; opacity: 0.15; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-6 relative">
    <div class="glow top-[-10%] left-[-10%] bg-indigo-600"></div>
    <div class="glow bottom-[-10%] right-[-10%] bg-purple-500"></div>

    <div class="w-full max-w-md relative">
        <div class="glass-auth rounded-[48px] p-10 md:p-12 shadow-2xl">
            <h2 class="text-2xl font-bold mb-2 tracking-tight">Kata Sandi Baru</h2>
            <p class="text-gray-500 text-[11px] mb-8 leading-relaxed italic uppercase tracking-wider">Silakan masukkan kata sandi baru untuk akun Anda.</p>

            <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
                @csrf
                
                <input type="hidden" name="token" value="{{ $token }}">

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ request()->email }}" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white/50 cursor-not-allowed" placeholder="nama@email.com" required readonly>
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Kata Sandi Baru</label>
                    <input type="password" name="password" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" placeholder="••••••••" required autofocus>
                    @error('password') 
                        <p class="text-rose-500 text-[10px] mt-2 ml-1 font-bold italic uppercase">{{ $message }}</p> 
                    @enderror
                </div>

                <div>
                    <label class="block text-[10px] font-black text-gray-500 uppercase tracking-[0.2em] mb-2 ml-1">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="input-glass w-full px-6 py-4 rounded-2xl text-sm text-white placeholder-white/20" placeholder="••••••••" required>
                </div>

                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 py-5 rounded-2xl font-black text-[10px] transition-all active:scale-[0.98] shadow-xl shadow-indigo-600/20 text-white uppercase tracking-[0.2em]">
                    Simpan Perubahan
                </button>
            </form>
        </div>
    </div>
</body>
</html>