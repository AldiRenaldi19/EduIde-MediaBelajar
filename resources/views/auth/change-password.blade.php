<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - EduIde</title>
    
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

        .error-message {
            color: #f87171;
            font-size: 0.875rem;
            margin-top: 0.25rem;
        }

        .password-requirement {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #9ca3af;
            margin-top: 0.5rem;
        }

        .password-requirement.met {
            color: #86efac;
        }

        .password-requirement svg {
            width: 1rem;
            height: 1rem;
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
                <h1 class="text-4xl md:text-5xl font-black tracking-tight mb-4">Ubah Password</h1>
                <p class="text-gray-400 text-lg">Perbarui password Anda untuk menjaga keamanan akun</p>
            </div>

            {{-- Success Message --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 rounded-[16px] text-emerald-300 text-sm font-bold">
                    ✅ {{ session('success') }}
                </div>
            @endif

            {{-- Change Password Form --}}
            <form action="{{ route('password.store') }}" method="POST" class="glass-card rounded-[32px] p-8 md:p-12 border border-white/10 mb-8">
                @csrf
                @method('PUT')

                {{-- Current Password Field --}}
                <div class="mb-8">
                    <label for="current_password" class="block text-sm font-black uppercase tracking-widest text-gray-400 mb-3">Password Saat Ini</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password" 
                               class="w-full form-input @error('current_password') border-red-500 @enderror" 
                               placeholder="Masukkan password saat ini">
                        <button type="button" onclick="togglePasswordVisibility('current_password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    @error('current_password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- New Password Field --}}
                <div class="mb-8">
                    <label for="password" class="block text-sm font-black uppercase tracking-widest text-gray-400 mb-3">Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" 
                               class="w-full form-input @error('password') border-red-500 @enderror" 
                               placeholder="Masukkan password baru"
                               oninput="checkPasswordRequirements()">
                        <button type="button" onclick="togglePasswordVisibility('password')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>

                    {{-- Password Requirements --}}
                    <div class="mt-4 space-y-2">
                        <div id="requirement-length" class="password-requirement">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Minimal 8 karakter</span>
                        </div>
                        <div id="requirement-letter" class="password-requirement">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Mengandung huruf</span>
                        </div>
                        <div id="requirement-number" class="password-requirement">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            <span>Mengandung angka</span>
                        </div>
                    </div>

                    @error('password')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password Field --}}
                <div class="mb-10">
                    <label for="password_confirmation" class="block text-sm font-black uppercase tracking-widest text-gray-400 mb-3">Konfirmasi Password Baru</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation" 
                               class="w-full form-input @error('password_confirmation') border-red-500 @enderror" 
                               placeholder="Ulangi password baru"
                               oninput="checkPasswordMatch()">
                        <button type="button" onclick="togglePasswordVisibility('password_confirmation')" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-white transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                    <div id="password-match-feedback" class="mt-2 text-sm text-gray-500"></div>
                    @error('password_confirmation')
                        <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit Button --}}
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 py-4 bg-indigo-600 hover:bg-indigo-500 text-white rounded-[16px] font-bold uppercase tracking-wider transition-all active:scale-95 shadow-lg shadow-indigo-600/20">
                        🔒 Perbarui Password
                    </button>
                    <a href="{{ route('profile') }}" class="flex-1 py-4 bg-white/5 hover:bg-white/10 border border-white/10 text-white text-center rounded-[16px] font-bold uppercase tracking-wider transition-all">
                        Batal
                    </a>
                </div>
            </form>

            {{-- Security Tips --}}
            <div class="glass-card rounded-[24px] p-8 border border-white/10">
                <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-amber-500" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    Tips Keamanan
                </h3>
                <ul class="space-y-3 text-sm text-gray-400">
                    <li class="flex gap-2">
                        <span class="text-indigo-400">✓</span>
                        <span>Gunakan kombinasi huruf, angka, dan simbol untuk password yang kuat</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-indigo-400">✓</span>
                        <span>Jangan gunakan password yang sama dengan platform lain</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-indigo-400">✓</span>
                        <span>Ubah password secara berkala untuk menjaga keamanan akun</span>
                    </li>
                    <li class="flex gap-2">
                        <span class="text-indigo-400">✓</span>
                        <span>Jangan berikan password kepada siapapun termasuk tim support</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(fieldId) {
            const field = document.getElementById(fieldId);
            field.type = field.type === 'password' ? 'text' : 'password';
        }

        function checkPasswordRequirements() {
            const password = document.getElementById('password').value;
            
            // Check length (min 8)
            const lengthMet = password.length >= 8;
            updateRequirement('requirement-length', lengthMet);
            
            // Check for letters
            const letterMet = /[a-zA-Z]/.test(password);
            updateRequirement('requirement-letter', letterMet);
            
            // Check for numbers
            const numberMet = /[0-9]/.test(password);
            updateRequirement('requirement-number', numberMet);
        }

        function updateRequirement(elementId, isMet) {
            const element = document.getElementById(elementId);
            if (isMet) {
                element.classList.add('met');
            } else {
                element.classList.remove('met');
            }
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmation = document.getElementById('password_confirmation').value;
            const feedback = document.getElementById('password-match-feedback');
            
            if (confirmation.length === 0) {
                feedback.textContent = '';
                return;
            }
            
            if (password === confirmation) {
                feedback.textContent = '✓ Password cocok';
                feedback.className = 'mt-2 text-sm text-emerald-400';
            } else {
                feedback.textContent = '✗ Password tidak cocok';
                feedback.className = 'mt-2 text-sm text-red-400';
            }
        }
    </script>
</body>
</html>
