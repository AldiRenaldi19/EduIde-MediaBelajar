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
        input:focus { border-color: #6366f1 !important; box-shadow: 0 0 15px rgba(99, 102, 241, 0.1) !important; outline: none; }
    </style>
</head>
<body class="min-h-screen p-6 md:p-12">
    <div class="max-w-3xl mx-auto">
        <a href="{{ route('admin.dashboard') }}" class="text-[10px] font-bold uppercase tracking-widest text-gray-500 hover:text-white transition-colors mb-8 inline-block">← Kembali ke Dashboard</a>
        
        <div class="glass-card rounded-[40px] p-8 md:p-12 shadow-2xl">
            <h1 class="text-2xl font-extrabold mb-2">{{ isset($course) ? 'Perbarui' : 'Buat' }} <span class="text-indigo-500">Kursus</span></h1>
            <p class="text-gray-500 text-xs mb-10">Isi detail instruksi untuk modul pembelajaran baru.</p>

            <form action="{{ isset($course) ? route('admin.courses.update', $course->id) : route('admin.courses.store') }}" method="POST">
                @csrf
                @if(isset($course)) @method('PUT') @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Judul Kursus</label>
                        <input type="text" name="title" value="{{ $course->title ?? '' }}" class="w-full px-5 py-4 rounded-2xl text-sm transition-all" placeholder="Contoh: Mastering Laravel 11">
                    </div>

                    <div class="space-y-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Kategori</label>
                        <select name="category" class="w-full px-5 py-4 rounded-2xl text-sm appearance-none">
                            <option value="Web Development">Web Development</option>
                            <option value="Mobile Design">Mobile Design</option>
                            <option value="Data Science">Data Science</option>
                        </select>
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Image URL (Thumbnail)</label>
                        <input type="url" name="image_url" value="{{ $course->image_url ?? '' }}" class="w-full px-5 py-4 rounded-2xl text-sm transition-all" placeholder="https://images.unsplash.com/...">
                    </div>

                    <div class="space-y-2 md:col-span-2">
                        <label class="text-[10px] font-black uppercase tracking-widest text-gray-400">Deskripsi Singkat</label>
                        <textarea name="description" rows="4" class="w-full px-5 py-4 rounded-2xl text-sm transition-all" placeholder="Jelaskan apa yang akan dipelajari..."></textarea>
                    </div>
                </div>

                <button type="submit" class="w-full mt-10 py-5 bg-indigo-600 hover:bg-indigo-500 text-white rounded-2xl text-[10px] font-black uppercase tracking-[0.2em] transition-all shadow-xl shadow-indigo-600/20">
                    {{ isset($course) ? 'Simpan Perubahan' : 'Terbitkan Kursus Sekarang' }}
                </button>
            </form>
        </div>
    </div>
</body>
</html>