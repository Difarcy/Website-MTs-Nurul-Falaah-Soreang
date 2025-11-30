@csrf

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Judul *</label>
            <input type="text" name="title" value="{{ old('title', $post->title) }}" required placeholder="Masukkan judul berita atau artikel" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
            @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Slug (opsional)</label>
            <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" placeholder="Kosongkan untuk generate otomatis dari judul" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
            @error('slug') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Ringkasan <span class="text-xs font-normal text-slate-400">(opsional)</span></label>
            <textarea name="excerpt" rows="3" placeholder="Masukkan ringkasan singkat artikel (akan muncul di halaman daftar)" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('excerpt', $post->excerpt) }}</textarea>
            @error('excerpt') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Isi Konten *</label>
            <textarea name="body" rows="10" required placeholder="Masukkan isi konten berita atau artikel lengkap" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('body', $post->body) }}</textarea>
            @error('body') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Tipe Konten</label>
                <select name="type" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    <option value="berita" @selected(old('type', $post->type) === 'berita')>Berita</option>
                    <option value="artikel" @selected(old('type', $post->type) === 'artikel')>Artikel</option>
                </select>
                @error('type') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Status</label>
                <select name="status" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    <option value="published" @selected(old('status', $post->status) === 'published')>Publikasi</option>
                    <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option>
                </select>
                @error('status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-slate-500 mt-1">Pilih "Publikasi" untuk langsung tampil di website</p>
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Tanggal Publikasi</label>
                <input type="date" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d')) }}" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                @error('published_at') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" class="rounded border-gray-300 text-green-700 focus:ring-green-600" @checked(old('is_featured', $post->is_featured))>
                <label for="is_featured" class="text-sm text-slate-700">Tampilkan sebagai highlight</label>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200 rounded-xl p-4 space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-600 uppercase mb-1">Thumbnail</label>
                <input type="file" name="thumbnail" accept="image/*" class="w-full text-sm">
                @error('thumbnail') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>
            @if($post->thumbnail_path)
                <div class="rounded-lg overflow-hidden border border-gray-200">
                    <img src="{{ asset('storage/' . $post->thumbnail_path) }}" alt="Thumbnail" class="w-full h-40 object-cover">
                </div>
            @endif
        </div>

        <div>
            <label class="block text-sm font-semibold text-slate-700 mb-1">Meta Description <span class="text-xs font-normal text-slate-400">(opsional)</span></label>
            <textarea name="meta_description" rows="3" placeholder="Deskripsi singkat untuk mesin pencari (maks 255 karakter)" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('meta_description', $post->meta_description) }}</textarea>
            <p class="text-xs text-slate-500 mt-1">Deskripsi ini akan muncul di hasil pencarian Google. Jika dikosongkan, akan menggunakan ringkasan artikel.</p>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.posts.index') }}" class="px-3 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors">Batal</a>
            <button type="submit" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800">
                {{ $post->id ? 'Simpan' : 'Publish' }}
            </button>
        </div>
    </div>
</div>

