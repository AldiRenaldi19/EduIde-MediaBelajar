<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($course) ? 'Edit' : 'Tambah' }} Kursus — EduIde</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;600;700;800&display=swap');
        body { font-family: 'Plus Jakarta Sans', sans-serif; background-color: #050508; color: #ffffff; }
        .glass-card { background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(20px); border: 1px solid rgba(255, 255, 255, 0.05); }
        input, textarea, select { background: rgba(255, 255, 255, 0.03) !important; border: 1px solid rgba(255, 255, 255, 0.1) !important; color: white !important; }
        input:focus, textarea:focus, select:focus { border-color: #6366f1 !important; box-shadow: 0 0 15px rgba(99, 102, 241, 0.1) !important; outline: none; }
        option { background-color: #111118; color: white; }
        input[type="file"]::file-selector-button {
            background: #6366f1; border: none; padding: 8px 20px; border-radius: 12px; color: white;
            font-size: 10px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.1em;
            margin-right: 20px; cursor: pointer; transition: all 0.3s;
        }
        input[type="file"]::file-selector-button:hover { background: #4f46e5; }
    </style>
</head>
<body class="min-h-screen p-6 md:p-12 relative">
    {{-- Background Glow --}}
    <div class="fixed top-0 left-0 w-[400px] h-[400px] bg-indigo-600/5 blur-[100px] rounded-full -z-10"></div>

    <div class="max-w-4xl mx-auto">
        {{-- Back Button --}}
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:text-indigo-400 transition-colors mb-8 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Dashboard
        </a>
        
        <div class="glass-card rounded-[40px] p-8 md:p-12 shadow-2xl border border-white/5">
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">
                    {{ isset($course) ? 'Perbarui' : 'Konfigurasi' }} <span class="text-indigo-500">Kursus</span>
                </h1>
                <p class="text-gray-500 text-sm italic">"Rancang kurikulum terbaik untuk masa depan teknologi."</p>
            </div>

            {{-- Alert Error --}}
            @if ($errors->any())
                <div class="mb-8 p-4 bg-rose-500/10 border border-rose-500/20 text-rose-500 rounded-2xl text-[10px] font-bold uppercase tracking-widest">
                    <ul class="space-y-1">
                        @foreach ($errors->all() as $error)
                            <li class="flex items-center">
                                <span class="w-1 h-1 bg-rose-500 rounded-full mr-2"></span>
                                {{ $error }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ isset($course) ? route('admin.courses.update', $course->id) : route('admin.courses.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  autocomplete="off">
                @csrf
                @if(isset($course)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    {{-- Judul --}}
                    <div class="space-y-3 md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-400/80">Judul Utama Kursus</label>
                        <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}" required
                            class="w-full px-6 py-4 rounded-2xl text-sm transition-all" 
                            placeholder="Contoh: Manajemen Database Cloud">
                    </div>

                    {{-- Kategori --}}
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Kategori Program</label>
                        <select name="category_id" required class="w-full px-6 py-4 rounded-2xl text-sm appearance-none cursor-pointer">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ (old('category_id', $course->category_id ?? '') == $category->id) ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Level --}}
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Tingkat Kesulitan</label>
                        <select name="level" required class="w-full px-6 py-4 rounded-2xl text-sm appearance-none cursor-pointer">
                            @foreach(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $val => $label)
                                <option value="{{ $val }}" {{ (old('level', $course->level ?? '') == $val) ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Harga --}}
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Harga Kursus (IDR)</label>
                        <div class="relative">
                            <span class="absolute left-6 top-1/2 -translate-y-1/2 text-gray-500 text-xs font-bold">Rp</span>
                            <input type="number" name="price" value="{{ old('price', $course->price ?? 0) }}" required min="0"
                                class="w-full pl-14 pr-6 py-4 rounded-2xl text-sm transition-all">
                        </div>
                    </div>

                    {{-- Thumbnail --}}
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Thumbnail Kursus</label>
                        <input type="file" name="thumbnail" id="imageInput" accept="image/png, image/jpeg, image/webp" {{ isset($course) ? '' : 'required' }}
                            class="w-full px-4 py-3 rounded-2xl text-[10px] transition-all border border-white/10 bg-white/5 file:mr-4">
                        
                        <div class="mt-4 flex items-center gap-4 p-4 bg-white/[0.02] rounded-2xl border border-white/5">
                            <img id="imagePreview" 
                                 src="{{ (isset($course) && $course->thumbnail) ? $course->thumbnail : 'https://placehold.co/600x400/1a1a2e/6366f1?text=Preview' }}" 
                                 class="w-20 h-20 rounded-xl object-cover border border-white/10 shadow-lg"
                                 onerror="this.src='https://placehold.co/600x400/1a1a2e/6366f1?text=Error+Load'">
                            <div>
                                <p class="text-[9px] font-bold text-gray-500 uppercase tracking-widest">Visual Preview</p>
                                <p class="text-[10px] text-indigo-400/60 italic">Cloud Storage Sync Enabled</p>
                            </div>
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div class="space-y-3 md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Ringkasan Materi</label>
                        <textarea name="description" rows="5" required
                            class="w-full px-6 py-4 rounded-2xl text-sm transition-all resize-none"
                            placeholder="Tuliskan deskripsi lengkap materi yang akan dipelajari...">{{ old('description', $course->description ?? '') }}</textarea>
                    </div>

                    {{-- Is Published --}}
                    <div class="md:col-span-2 flex items-center gap-3 p-4 bg-white/5 rounded-2xl border border-white/5 group hover:border-indigo-500/30 transition-all">
                        <input type="hidden" name="is_published" value="0">
                        <input type="checkbox" name="is_published" id="is_published" value="1" 
                            {{ old('is_published', $course->is_published ?? false) ? 'checked' : '' }}
                            class="w-5 h-5 rounded-lg border-white/10 text-indigo-600 bg-white/5 cursor-pointer focus:ring-0">
                        <label for="is_published" class="text-xs font-bold text-gray-400 cursor-pointer select-none">
                            Terbitkan kursus ini segera setelah penyimpanan.
                        </label>
                    </div>
                </div>

                <div class="mt-12 flex flex-col md:flex-row gap-4">
                    <button type="submit" id="submitBtn" class="flex-1 py-5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-[20px] text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-indigo-600/20 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                        {{ isset($course) ? 'Simpan Perubahan' : 'Terbitkan Kursus' }}
                    </button>
                    <a href="{{ route('admin.dashboard') }}" class="px-8 py-5 border border-white/10 text-gray-500 hover:text-white hover:bg-white/5 rounded-[20px] text-[10px] font-black uppercase tracking-[0.2em] transition-all text-center">
                        Batal
                    </a>
                </div>
            </form>

            {{-- Module Thumbnails Management (only when editing an existing course) --}}
            @if(isset($course) && $course->modules->isNotEmpty())
                <div class="mt-12">
                    <h2 class="text-sm font-bold text-gray-200 mb-4">Gambar Modul</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($course->modules as $mod)
                            <div class="p-4 bg-white/[0.02] rounded-2xl border border-white/5 flex items-center gap-4">
                                <img src="{{ $mod->thumbnail ?? 'https://placehold.co/300x200/1a1a2e/6366f1?text=No+Image' }}" class="w-24 h-16 object-cover rounded-md border border-white/5" onerror="this.src='https://placehold.co/300x200/1a1a2e/6366f1?text=Error'">
                                <div class="flex-1">
                                    <div class="text-xs font-bold text-gray-400">{{ $mod->title }}</div>
                                    <form action="{{ route('admin.modules.thumbnail.update', $mod->id) }}" method="POST" enctype="multipart/form-data" class="mt-2 flex items-center gap-2">
                                        @csrf
                                        <input type="file" name="thumbnail" accept="image/*" class="text-sm file:rounded file:px-3 file:py-2 file:bg-indigo-600 file:text-white" required>
                                        <button class="px-3 py-2 bg-indigo-600 text-white rounded text-xs font-bold">Unggah</button>
                                    </form>
                                    @if($errors->has('thumbnail'))
                                        <div class="text-rose-400 text-xs mt-2">{{ $errors->first('thumbnail') }}</div>
                                    @endif

                                    {{-- Content attach/upload form --}}
                                    <form action="{{ route('admin.modules.content.update', $mod->id) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                                        @csrf
                                        <div class="flex items-center gap-2">
                                            <select name="content_option" class="px-3 py-2 rounded bg-white/5 text-sm">
                                                <option value="file">Unggah File</option>
                                                <option value="url">Tautkan URL</option>
                                            </select>
                                            <input type="file" name="file" accept="video/*,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="text-sm file:rounded file:px-3 file:py-2 file:bg-green-600 file:text-white">
                                            <input type="url" name="url" placeholder="https://" class="px-3 py-2 rounded bg-white/5 text-sm w-64">
                                            <button class="px-3 py-2 bg-green-600 text-white rounded text-xs font-bold">Simpan Konten</button>
                                        </div>
                                        @if($mod->content_url)
                                            <div class="mt-2 text-xs text-gray-300">Konten saat ini: <a href="{{ $mod->content_url }}" class="text-indigo-400 underline" target="_blank">Lihat</a> ({{ $mod->content_type }})</div>
                                        @endif
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Preview gambar & Proteksi Button
        const imageInput = document.getElementById('imageInput');
        const imagePreview = document.getElementById('imagePreview');
        const submitBtn = document.getElementById('submitBtn');
        const mainForm = document.querySelector('form');

        imageInput.onchange = evt => {
            const [file] = imageInput.files;
            if (file) {
                // Validasi ukuran file di sisi client (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    imageInput.value = '';
                    return;
                }
                imagePreview.src = URL.createObjectURL(file);
            }
        }

        // Efek loading saat submit (mencegah double click)
        mainForm.onsubmit = () => {
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Sedang Memproses...';
        }
    </script>
</body>
</html>