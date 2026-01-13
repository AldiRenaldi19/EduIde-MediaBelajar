<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($course) ? 'Edit' : 'Tambah' }} Kursus — EduIde</title>
    
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen relative" style="background-color: var(--bg-page); color: var(--text-main);">
    <x-navbar />
    
    {{-- Background Glow --}}
    <div class="fixed top-0 left-0 w-[400px] h-[400px] bg-indigo-600/5 blur-[100px] rounded-full -z-10"></div>

    <div class="max-w-4xl mx-auto px-6 py-24 md:py-32">
        {{-- Back Button --}}
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:text-indigo-400 transition-colors mb-8 group">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Dashboard
        </a>
        
        <div class="glass-card rounded-[40px] p-8 md:p-12 shadow-2xl border border-white/5 relative overflow-hidden">
            <div class="mb-10 text-center md:text-left">
                <h1 class="text-3xl font-extrabold mb-2 tracking-tight">
                    {{ isset($course) ? 'Perbarui' : 'Konfigurasi' }} <span class="text-indigo-500">Kursus</span>
                </h1>
                <p class="text-gray-500 text-sm italic font-medium">"Rancang kurikulum terbaik untuk masa depan teknologi."</p>
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

                {{-- Alpine.js x-data context --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8" x-data="{ published: {{ old('is_published', $course->is_published ?? false) ? 'true' : 'false' }} }">
                    {{-- Judul --}}
                    <div class="space-y-3 md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-indigo-400/80">Judul Utama Kursus</label>
                        <input type="text" name="title" value="{{ old('title', $course->title ?? '') }}" required
                            class="input-glass w-full px-6 py-4 rounded-2xl text-sm transition-all" 
                            placeholder="Contoh: Manajemen Database Cloud">
                    </div>

                    {{-- Kategori --}}
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Kategori Program</label>
                        <select name="category_id" required class="input-glass w-full px-6 py-4 rounded-2xl text-sm appearance-none cursor-pointer">
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
                        <select name="level" required class="input-glass w-full px-6 py-4 rounded-2xl text-sm appearance-none cursor-pointer">
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
                                class="input-glass w-full pl-14 pr-6 py-4 rounded-2xl text-sm transition-all">
                        </div>
                    </div>

                    {{-- Thumbnail --}}
                    <div class="space-y-3">
                        <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400">Thumbnail Kursus</label>
                        <input type="file" name="thumbnail" id="imageInput" accept="image/png, image/jpeg, image/webp" {{ isset($course) ? '' : 'required' }}
                            class="input-glass w-full px-4 py-3 rounded-2xl text-[10px] transition-all border border-white/10 bg-white/5 file:mr-4">
                        
                        <div class="mt-4 flex items-center gap-4 p-4 bg-white/[0.02] rounded-2xl border border-white/5">
                            <img id="imagePreview" 
                                 src="{{ isset($course) ? $course->thumbnail_url : 'https://placehold.co/600x400/1a1a2e/6366f1?text=Preview' }}" 
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
                            class="input-glass w-full px-6 py-4 rounded-2xl text-sm transition-all resize-none"
                            placeholder="Tuliskan deskripsi lengkap materi yang akan dipelajari...">{{ old('description', $course->description ?? '') }}</textarea>
                    </div>

                    {{-- Is Published Checkbox with Alpine binding --}}
                    <div class="md:col-span-2">
                        {{-- Hidden input default value = 0 (Standard Form Handling) --}}
                        <input type="hidden" name="is_published" value="0">
                        
                        <label class="flex items-center gap-3 p-4 bg-white/5 rounded-2xl border border-white/5 group hover:border-indigo-500/30 transition-all cursor-pointer">
                            <div class="relative flex items-center">
                                <input type="checkbox" name="is_published" id="is_published" value="1" 
                                    x-model="published"
                                    class="w-5 h-5 rounded-lg border-white/10 text-indigo-600 bg-white/5 cursor-pointer focus:ring-0">
                            </div>
                            <span class="text-xs font-bold text-gray-400 cursor-pointer select-none group-hover:text-white transition-colors">
                                Terbitkan kursus ini segera setelah penyimpanan.
                            </span>
                        </label>
                    </div>
                
                    <div class="md:col-span-2 mt-4 flex flex-col md:flex-row gap-4">
                        <button type="submit" id="submitBtn" class="flex-1 py-5 btn-primary text-white rounded-[20px] text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-indigo-600/20 active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
                            <span x-text="published ? 'Terbitkan Kursus' : 'Simpan Draft Kursus'"></span>
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="px-8 py-5 border border-white/10 text-gray-500 hover:text-white hover:bg-white/5 rounded-[20px] text-[10px] font-black uppercase tracking-[0.2em] transition-all text-center">
                            Batal
                        </a>
                    </div>
                </div>
            </form>

            {{-- Module Management (only when editing an existing course) --}}
            @if(isset($course))
                <div class="mt-12 border-t border-white/10 pt-8">
                    <h2 class="text-xl font-bold text-white mb-6">Kurikulum & Materi</h2>
                    {{-- Add module form --}}
                    <div class="mb-6">
                        <form action="{{ route('admin.courses.modules.store', $course->id) }}" method="POST" class="flex items-center gap-2">
                            @csrf
                            <input name="title" placeholder="Judul modul baru" required class="input-glass px-4 py-3 rounded-xl text-sm w-1/2">
                            <input name="order" type="number" placeholder="Urutan" required value="{{ $course->modules->count() + 1 }}" class="input-glass px-4 py-3 rounded-xl text-sm w-24">
                            <button class="px-6 py-3 btn-primary text-white rounded-xl text-xs font-bold uppercase tracking-widest">Tambah Modul</button>
                        </form>
                        <p class="text-[10px] text-gray-500 mt-2 italic">* Video atau materi PDF dapat diunggah setelah modul berhasil dibuat di bawah ini.</p>
                    </div>
                    
                    {{-- Daftar Modul (Vertical Layout agar tidak berantakan) --}}
                    <div class="flex flex-col gap-6">
                        @foreach($course->modules as $mod)
                            <div class="p-6 glass-card rounded-2xl flex flex-col md:flex-row gap-8">
                                
                                {{-- Bagian Kiri: Thumbnail & Info Dasar --}}
                                <div class="w-full md:w-64 flex-shrink-0 flex flex-col gap-4">
                                    <div class="relative group aspect-video">
                                        <img src="{{ $mod->thumbnail_url }}" class="w-full h-full object-cover rounded-xl border border-white/10 shadow-lg" onerror="this.src='https://placehold.co/300x200/1a1a2e/6366f1?text=Error'">
                                        <div class="absolute inset-0 bg-black/50 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center rounded-xl">
                                            <span class="text-[10px] font-bold uppercase tracking-widest text-white">Ganti Gambar</span>
                                        </div>
                                    </div>
                                    
                                    <form action="{{ route('admin.modules.thumbnail.update', $mod->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-2">
                                        @csrf
                                        <input type="file" name="thumbnail" accept="image/*" class="text-[10px] file:rounded-lg file:px-3 file:py-1.5 file:bg-white/10 file:text-white file:border-0 file:mr-2 hover:file:bg-white/20 cursor-pointer text-gray-400" required>
                                        <button class="w-full py-2 bg-white/5 hover:bg-white/10 text-gray-300 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-colors">Update Thumbnail</button>
                                    </form>
                                </div>

                                {{-- Bagian Kanan: Konten & Materi --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex justify-between items-start mb-6 pb-4 border-b border-white/5">
                                        <div>
                                            <h3 class="text-lg font-bold text-white flex items-center gap-3">
                                                <span class="flex items-center justify-center w-6 h-6 rounded bg-indigo-500/20 text-indigo-400 text-xs font-black">{{ $mod->order }}</span>
                                                {{ $mod->title }}
                                            </h3>
                                        </div>
                                        <form action="{{ route('admin.modules.delete', $mod->id) }}" method="POST" onsubmit="return confirm('Yakin hapus modul ini? Data tidak bisa dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="px-3 py-1.5 bg-rose-500/10 hover:bg-rose-500/20 text-rose-500 rounded-lg text-[10px] font-bold uppercase tracking-widest transition-colors">Hapus Modul</button>
                                        </form>
                                    </div>

                                    {{-- Form Upload Materi --}}
                                    <form action="{{ route('admin.modules.content.update', $mod->id) }}" method="POST" enctype="multipart/form-data" class="glass-card p-5 rounded-xl">
                                        @csrf
                                        <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" /></svg>
                                            Upload Materi Pembelajaran
                                        </div>
                                        
                                        <div class="flex flex-col gap-4">
                                                <div class="flex flex-col md:flex-row gap-4">
                                                    <select name="content_option" onchange="toggleContentInput(this)" class="w-full md:w-48 px-4 py-3 rounded-xl admin-input focus:border-indigo-500 cursor-pointer text-sm">
                                                        <option value="file">📁 Upload File</option>
                                                        <option value="url">🔗 Link YouTube</option>
                                                        <option value="text">📝 Artikel / Teks</option>
                                                    </select>
                                                    
                                                    <div class="flex-1 content-input-group" data-type="file">
                                                        <input type="file" name="file" accept="video/*,application/pdf" class="w-full px-4 py-2.5 rounded-xl admin-input text-sm file:mr-4 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-600 file:text-white hover:file:bg-indigo-500 cursor-pointer">
                                                    </div>
                                                    
                                                    <div class="flex-1 content-input-group hidden" data-type="url">
                                                        <input type="url" name="url" placeholder="Paste link YouTube di sini..." class="w-full px-4 py-3 rounded-xl admin-input text-sm focus:border-indigo-500 placeholder-gray-500">
                                                    </div>
                                                </div>

                                                <div class="w-full content-input-group hidden" data-type="text">
                                                    <textarea name="text_content" rows="6" class="w-full px-4 py-3 rounded-xl admin-input text-sm focus:border-indigo-500 placeholder-gray-500 font-mono" placeholder="Tulis materi pembelajaran di sini (Markdown Supported)...">{{ $mod->content }}</textarea>
                                                </div>
                                            
                                            <button class="w-full py-3 bg-indigo-600 hover:bg-indigo-500 text-white rounded-xl text-xs font-bold uppercase tracking-widest transition-all shadow-lg shadow-indigo-600/20 flex items-center justify-center gap-2">
                                                <span>Simpan & Update Materi</span>
                                            </button>
                                        </div>

                                        @if($mod->content_url)
                                            <div class="mt-6 pt-6 border-t border-white/10">
                                                <div class="flex items-center justify-between text-xs mb-3">
                                                    <span class="text-gray-400 font-medium">Preview Materi Aktif: <span class="text-green-400 font-bold uppercase ml-1">{{ $mod->content_type }}</span></span>
                                                    <a href="{{ $mod->content_url }}" target="_blank" class="text-indigo-400 hover:text-indigo-300 flex items-center gap-1">Buka Tab Baru <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg></a>
                                                </div>
                                                
                                                {{-- Preview Player Langsung --}}
                                                @php
                                                    // Deteksi tipe konten secara visual untuk preview
                                                    $previewType = $mod->content_type;
                                                    if (str_contains($mod->content_url, 'youtube.com') || str_contains($mod->content_url, 'youtu.be') || str_ends_with($mod->content_url, '.mp4')) {
                                                        $previewType = 'video';
                                                    }
                                                @endphp

                                                @if($previewType === 'video')
                                                    <div class="relative w-full aspect-video bg-black rounded-lg overflow-hidden border border-white/10 shadow-lg">
                                                        @if(str_contains($mod->content_url, 'youtube.com') || str_contains($mod->content_url, 'youtu.be'))
                                                            @php
                                                                $displayUrl = $mod->content_url;
                                                                // Auto-fix: Paksa ubah link biasa ke Embed agar preview muncul
                                                                if (!str_contains($displayUrl, '/embed/')) {
                                                                    preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $displayUrl, $matches);
                                                                    if (isset($matches[1])) {
                                                                        $displayUrl = 'https://www.youtube.com/embed/' . $matches[1];
                                                                    }
                                                                }
                                                            @endphp
                                                            {{-- Player untuk YouTube (Embed) --}}
                                                            <iframe src="{{ $displayUrl }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                        @else
                                                            {{-- Player untuk File Upload (Langsung) --}}
                                                            <video src="{{ $mod->content_url }}" controls class="w-full h-full"></video>
                                                        @endif
                                                    </div>
                                                @elseif($previewType === 'document')
                                                    {{-- Preview untuk PDF --}}
                                                    <iframe src="{{ $mod->content_url }}" class="w-full h-64 rounded border border-white/10 bg-white"></iframe>
                                                @endif
                                            </div>
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
                // Validasi ukuran file di sisi client (4MB)
                if (file.size > 4 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 4MB.');
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

        // Toggle Content Input (File vs URL)
        function toggleContentInput(select) {
            const form = select.closest('form');
            const val = select.value;
            
            form.querySelector('[data-type="file"]')?.classList.toggle('hidden', val !== 'file');
            form.querySelector('[data-type="url"]')?.classList.toggle('hidden', val !== 'url');
            form.querySelector('[data-type="text"]')?.classList.toggle('hidden', val !== 'text');
        }
    </script>
    <script>
        // Intercept module upload forms to show progress using XHR
        document.addEventListener('DOMContentLoaded', function () {
            function handleForm(form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const submitBtn = form.querySelector('button[type="submit"]') || form.querySelector('button');
                    const fileInput = form.querySelector('input[type="file"]');

                    // create progress bar
                    let progress = form.querySelector('.upload-progress');
                    if (!progress) {
                        progress = document.createElement('div');
                        progress.className = 'upload-progress mt-2 w-full bg-white/5 rounded';
                        progress.innerHTML = '<div class="h-2 bg-indigo-600 rounded" style="width:0%"></div>';
                        form.appendChild(progress);
                    }

                    const bar = progress.firstElementChild;

                    const action = form.getAttribute('action');
                    const method = form.getAttribute('method') || 'POST';

                    const xhr = new XMLHttpRequest();
                    xhr.open(method, action);
                    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                    const token = document.querySelector('input[name="_token"]');
                    if (token) xhr.setRequestHeader('X-CSRF-TOKEN', token.value);

                    xhr.upload.addEventListener('progress', function (ev) {
                        if (ev.lengthComputable) {
                            const pct = Math.round((ev.loaded / ev.total) * 100);
                            bar.style.width = pct + '%';
                        }
                    });

                    xhr.addEventListener('load', function () {
                        if (xhr.status >= 200 && xhr.status < 300) {
                            // simple success: reload to show new content
                            window.location.reload();
                        } else {
                            alert('Upload gagal. Periksa pesan error.');
                            submitBtn.disabled = false;
                        }
                    });

                    xhr.addEventListener('error', function () {
                        alert('Terjadi kesalahan saat mengunggah.');
                        submitBtn.disabled = false;
                    });

                    const fd = new FormData(form);

                    submitBtn.disabled = true;
                    submitBtn.innerText = 'Mengunggah...';

                    xhr.send(fd);
                });
            }

            // Attach to all module forms under this page
            document.querySelectorAll('form[action*="modules"]').forEach(handleForm);
        });
    </script>
</body>
</html>