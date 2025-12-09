@csrf
@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div>
            <label for="title-input" class="block text-sm font-semibold text-slate-700 mb-1">Judul <span class="text-red-600 dark:text-red-500">*</span></label>
            <div class="relative">
                <input type="text" name="title" id="title-input" value="{{ old('title', $post->title) }}" required maxlength="160" placeholder="Masukkan judul berita atau artikel" autocomplete="off" class="w-full border border-gray-200 rounded-lg px-3 py-2 pr-20 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCountDirect('title-input', 'title-char-count', 160)">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                    <span id="title-char-count" class="text-slate-400">{{ mb_strlen(old('title', $post->title ?? '')) }}</span><span class="text-slate-400">/160</span>
                </span>
            </div>
            @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="slug-input" class="block text-sm font-semibold text-slate-700 mb-1">Slug <span class="text-xs font-normal text-slate-400">(opsional)</span></label>
            <div class="relative">
                <input type="text" name="slug" id="slug-input" value="{{ old('slug', $post->slug) }}" maxlength="160" placeholder="Kosongkan untuk dibuat otomatis dari judul" autocomplete="off" class="w-full border border-gray-200 rounded-lg px-3 py-2 pr-20 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCountDirect('slug-input', 'slug-char-count', 160)">
                <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                    <span id="slug-char-count" class="text-slate-400">{{ mb_strlen(old('slug', $post->slug ?? '')) }}</span><span class="text-slate-400">/160</span>
                </span>
            </div>
            @error('slug') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="excerpt-input" class="block text-sm font-semibold text-slate-700 mb-1">Excerpt <span class="text-xs font-normal text-slate-400">(opsional)</span></label>
            <div class="relative">
                <textarea name="excerpt" id="excerpt-input" rows="3" maxlength="500" placeholder="Ringkasan singkat artikel/berita (kosongkan untuk dibuat otomatis dari konten)" class="w-full border border-gray-200 rounded-lg px-3 py-2 pb-8 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCountDirect('excerpt-input', 'excerpt-char-count', 500)">{{ old('excerpt', $post->excerpt) }}</textarea>
                <span class="absolute bottom-2 right-3 text-xs pointer-events-none">
                    <span id="excerpt-char-count" class="text-slate-400">{{ mb_strlen(old('excerpt', $post->excerpt ?? '')) }}</span><span class="text-slate-400">/500</span>
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Ringkasan yang akan ditampilkan di halaman beranda dan daftar berita/artikel. Jika kosong, akan dibuat otomatis dari awal konten.</p>
            @error('excerpt') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="images-input" class="block text-sm font-semibold text-slate-700 mb-1">Gambar Konten <span class="text-xs font-normal text-slate-400">(opsional)</span></label>
            <p class="text-xs text-slate-500 mb-3">Tambahkan gambar untuk memperkaya konten. Maksimal 6 gambar. <strong class="text-red-600 dark:text-red-400">Jumlah harus 1, 2, 4, atau 6 gambar</strong> (jumlah ganjil selain 1 tidak dapat disimpan).</p>
            <div id="images-warning" class="hidden mb-3 p-3 bg-amber-50 dark:bg-amber-900/20 border border-amber-200 dark:border-amber-800 rounded-lg">
                <p class="text-sm text-amber-800 dark:text-amber-200 font-medium" id="images-warning-text"></p>
            </div>

            <!-- Drag & Drop Card dengan Tombol Upload -->
            <div class="relative">
                <input type="file" name="images[]" id="images-input" accept="image/*" multiple class="hidden" onchange="handleImagesSelect(event)">
                <div id="images-upload-card" class="border-2 border-dashed border-gray-300 dark:border-slate-600 p-6 text-center cursor-pointer hover:border-green-500 dark:hover:border-green-600 transition-colors" style="border-radius: 0;" ondrop="handleImagesDrop(event)" ondragover="handleImagesDragOver(event)" ondragleave="handleImagesDragLeave(event)" onclick="if(!event.target.closest('#images-preview-container') && !event.target.closest('button')) document.getElementById('images-input').click()">
                    <svg class="w-12 h-12 text-gray-400 dark:text-slate-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <button type="button" onclick="event.stopPropagation(); document.getElementById('images-input').click();" class="px-4 py-2.5 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors flex items-center justify-center gap-2 mx-auto mb-2" style="border-radius: 0;">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Upload File Gambar
                    </button>
                    <p class="text-sm text-slate-500 dark:text-slate-400 mb-1 text-center">Atau seret dan lepas gambar ke area ini</p>
                    <p class="text-xs text-slate-400 dark:text-slate-500 text-center">Format yang didukung: JPG, PNG (Maks. 5MB per gambar)</p>
                </div>
            </div>

            <!-- Preview Images (2 kolom grid) -->
            <div id="images-preview-container" class="mt-4 {{ !empty($existingImages) || old('images') ? '' : 'hidden' }}">
                <p class="text-xs text-slate-500 mb-2">Gambar baru yang dipilih: <span class="text-slate-400">(Drag gambar untuk mengatur posisi)</span></p>
                <div id="images-preview-list" class="grid grid-cols-2 gap-4">
                    <!-- Images will be inserted here -->
                </div>
            </div>

            <!-- Existing Images (from database) -->
            @php
                $existingImages = old('existing_images', $post->images ?? []);
                if (is_string($existingImages)) {
                    $existingImages = json_decode($existingImages, true) ?? [];
                }
                // Pastikan existingImages selalu array, bukan integer atau tipe lain
                if (!is_array($existingImages)) {
                    $existingImages = [];
                }
            @endphp
            @if(!empty($existingImages) && is_array($existingImages))
                <div id="existing-images-container" class="mt-4">
                    <p class="text-xs text-slate-500 mb-2">Gambar yang sudah diupload: <span class="text-slate-400">(Drag gambar untuk mengatur posisi)</span></p>
                    <div id="existing-images-list" class="grid grid-cols-2 gap-4">
                        @foreach($existingImages as $index => $image)
                            <div class="image-item relative group draggable-image" draggable="true" data-image="{{ $image }}" data-index="{{ $index }}">
                                <div class="overflow-hidden border border-gray-200 dark:border-slate-700 cursor-move" onclick="if(!event.target.closest('button')) openImageZoom('{{ asset('storage/' . $image) }}')" style="border-radius: 0;">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Gambar {{ $index + 1 }}" class="w-full aspect-video object-cover hover:opacity-90 transition-opacity pointer-events-none">
                                </div>
                                <button type="button" onclick="event.stopPropagation(); removeExistingImage(this, '{{ $image }}');" class="absolute top-0 -right-1 text-red-600 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                                <div class="absolute top-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded pointer-events-none">
                                    <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                </div>
                                <input type="hidden" name="existing_images[]" value="{{ $image }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <div>
            <label for="body-editor" class="block text-sm font-semibold text-slate-700 mb-1">Isi Konten <span class="text-red-600 dark:text-red-500">*</span></label>
            <textarea name="body" id="body-editor" rows="10" required placeholder="Masukkan isi konten berita atau artikel lengkap" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">{{ old('body', $post->body) }}</textarea>
            @error('body') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div class="space-y-6">
        <div class="bg-slate-50 border border-slate-200 p-4 space-y-4" style="border-radius: 0;">
            <!-- Type hidden field - determined by route -->
            <input type="hidden" name="type" id="type" value="{{ $type ?? $post->type }}">

            <div>
                <label for="status-select" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Status</label>
                <select name="status" id="status-select" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                    <option value="published" @selected(old('status', $post->status ?? 'published') === 'published')>Publikasi</option>
                    <option value="draft" @selected(old('status', $post->status ?? 'published') === 'draft')>Draft</option>
                    @if($post->id)
                    <option value="unpublished" @selected(old('status', $post->status) === 'unpublished')>Nonaktif</option>
                    @endif
                </select>
                @error('status') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-slate-500 mt-1">Publikasi: tampil di website. Draft: simpan sementara.@if($post->id) Nonaktif: sembunyikan dari website.@endif</p>
            </div>

            <div>
                <label for="author-name-input" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Nama Penulis <span class="text-red-600 dark:text-red-500">*</span></label>
                <div class="relative">
                    <input type="text" name="author_name" id="author-name-input" value="{{ old('author_name', $post->author_name ?? 'Admin') }}" required maxlength="100" autocomplete="name" class="w-full border border-gray-200 rounded-lg px-3 py-2 pr-20 focus:ring-2 focus:ring-green-600 focus:border-green-600" placeholder="Masukkan nama penulis" oninput="updateCharCountDirect('author-name-input', 'author-name-char-count', 100)">
                    <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs pointer-events-none">
                        <span id="author-name-char-count" class="text-slate-400">{{ mb_strlen(old('author_name', $post->author_name ?? 'Admin')) }}</span><span class="text-slate-400">/100</span>
                    </span>
                </div>
                @error('author_name') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-slate-500 mt-1">Nama penulis yang akan ditampilkan di website.</p>
            </div>

            <div>
                <label for="published-at-date" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Tanggal Publikasi</label>
                @php
                    $publishedAtDate = old('published_at_date');
                    if (!$publishedAtDate && $post->published_at) {
                        $publishedAtDate = $post->published_at->format('Y-m-d');
                    } elseif (!$publishedAtDate && !$post->published_at && $post->status === 'published') {
                        $publishedAtDate = now()->format('Y-m-d');
                    }
                @endphp
                <input type="date" name="published_at_date" id="published-at-date" value="{{ $publishedAtDate }}" autocomplete="off" class="w-full border border-gray-200 rounded-lg px-3 py-2 focus:ring-2 focus:ring-green-600 focus:border-green-600">
                @error('published_at_date') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-slate-500 mt-1">Pilih tanggal publikasi. Waktu otomatis menggunakan waktu saat ini.</p>
            </div>

            <div>
                <label for="tag-input" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Tag <span class="text-xs font-normal text-slate-400 normal-case">(opsional)</span></label>
                <div class="relative">
                    <div id="tags-wrapper" class="border border-gray-200 dark:border-slate-600 rounded-lg px-3 py-2 min-h-[42px] flex flex-wrap gap-2 items-center focus-within:ring-2 focus-within:ring-green-600 focus-within:border-green-600 bg-white dark:bg-slate-800">
                        <div id="tags-container" class="flex flex-wrap gap-2">
                            @php
                                $tags = old('tags', $post->tags ?? []);
                                if (is_string($tags)) {
                                    $tags = json_decode($tags, true) ?? [];
                                }
                                // Pastikan tags selalu array, bukan integer atau tipe lain
                                if (!is_array($tags)) {
                                    $tags = [];
                                }
                            @endphp
                            @if(!empty($tags) && is_array($tags))
                                @foreach($tags as $index => $tag)
                                    <div class="tag-item inline-flex items-center bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-white pl-2 pr-0.5 py-0.5 rounded-md text-xs font-medium border border-green-200 dark:border-green-700">
                                        <span class="mr-1">{{ $tag }}</span>
                                        <button type="button" onclick="removeTag(this)" class="text-green-600 dark:text-white hover:text-green-800 dark:hover:text-white p-0.5 rounded-r-md hover:bg-green-100 dark:hover:bg-green-800/50 flex items-center justify-center">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                        <input type="hidden" name="tags[]" value="{{ $tag }}">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <input type="text" id="tag-input" name="tag-input" placeholder="Masukkan tag dan tekan Enter" maxlength="50" autocomplete="off" class="flex-1 min-w-[120px] border-0 outline-none bg-transparent text-sm text-slate-700 dark:text-slate-300 placeholder-slate-400 dark:placeholder-slate-500">
                    </div>
                    <div id="tag-suggestions" class="absolute z-50 w-full mt-1 bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-600 rounded-lg shadow-lg max-h-60 overflow-y-auto hidden">
                        <div id="suggestions-list" class="py-1"></div>
                    </div>
                </div>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Masukkan tag satu per satu. <strong>Maksimal 10 tag.</strong> Sistem akan menampilkan suggestions dari tag yang sudah digunakan.</p>
                @error('tags') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                @error('tags.*') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_featured" name="is_featured" value="1" class="rounded border-gray-300 text-green-700 focus:ring-green-600" @checked(old('is_featured', $post->is_featured))>
                <label for="is_featured" class="text-sm text-slate-700">Tampilkan sebagai highlight</label>
            </div>
        </div>

        <div class="bg-slate-50 border border-slate-200 p-4 space-y-4" style="border-radius: 0;">
            <div>
                <label for="thumbnail-input" class="block text-xs font-semibold text-slate-600 uppercase mb-1">Thumbnail <span class="text-red-600 dark:text-red-500">*</span></label>
                <p class="text-xs text-slate-500 mb-2">Upload file thumbnail.</p>
                <div class="relative">
                    <input type="file" name="thumbnail" id="thumbnail-input" accept="image/*" class="hidden" onchange="updateThumbnailPreview(this)">
                    <div id="thumbnail-upload-card" class="border-2 border-dashed border-gray-300 dark:border-slate-600 p-4 text-center cursor-pointer hover:border-green-500 dark:hover:border-green-600 transition-colors" style="border-radius: 0;" ondrop="handleThumbnailDrop(event)" ondragover="handleThumbnailDragOver(event)" ondragleave="handleThumbnailDragLeave(event)" onclick="if(!event.target.closest('#thumbnail-preview') && !event.target.closest('button')) document.getElementById('thumbnail-input').click()">
                        <svg class="w-10 h-10 text-gray-400 dark:text-slate-500 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                        </svg>
                        <button type="button" onclick="event.stopPropagation(); document.getElementById('thumbnail-input').click();" class="px-4 py-2 text-sm font-semibold text-white bg-green-700 hover:bg-green-800 transition-colors flex items-center justify-center gap-2 mx-auto mb-1" style="border-radius: 0;">
                            @if(!$post->thumbnail_path)
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            @endif
                            {{ $post->thumbnail_path ? 'Ubah Thumbnail' : 'Upload Thumbnail' }}
                        </button>
                        <p class="text-xs text-slate-400 dark:text-slate-500 text-center">Atau seret dan lepas gambar ke area ini</p>
                    </div>
                </div>
                @error('thumbnail') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                <div id="thumbnail-preview" class="mt-3 hidden">
                    <p class="text-xs text-slate-500 mb-2">Pratinjau thumbnail baru:</p>
                    <div class="relative group">
                        <div class="overflow-hidden border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity" style="border-radius: 0;" onclick="openImageZoom(document.getElementById('thumbnail-preview-img').src)">
                            <img id="thumbnail-preview-img" src="" alt="Pratinjau Thumbnail" class="w-full aspect-video object-cover">
                        </div>
                        <button type="button" onclick="event.stopPropagation(); removeThumbnailPreview();" class="absolute top-0 -right-1 text-red-600 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
            @if($post->thumbnail_path)
                <div class="mt-3" id="current-thumbnail-container">
                    <p class="text-xs text-slate-500 mb-2">Thumbnail Saat Ini:</p>
                    <div class="overflow-hidden border border-gray-200 cursor-pointer hover:opacity-90 transition-opacity" style="border-radius: 0;" onclick="openImageZoom('{{ asset('storage/' . $post->thumbnail_path) }}')">
                        <img src="{{ asset('storage/' . $post->thumbnail_path) }}" alt="Thumbnail" class="w-full aspect-video object-cover">
                    </div>
                </div>
            @endif
        </div>

        <div>
            <label for="meta-description-input" class="block text-sm font-semibold text-slate-700 mb-1">Deskripsi Meta <span class="text-xs font-normal text-slate-400">(opsional)</span></label>
            <div class="relative">
                <textarea name="meta_description" id="meta-description-input" rows="3" maxlength="255" placeholder="Deskripsi singkat untuk mesin pencari" class="w-full border border-gray-200 rounded-lg px-3 py-2 pb-8 focus:ring-2 focus:ring-green-600 focus:border-green-600" oninput="updateCharCountDirect('meta-description-input', 'meta-description-char-count', 255)">{{ old('meta_description', $post->meta_description) }}</textarea>
                <span class="absolute bottom-2 right-3 text-xs pointer-events-none">
                    <span id="meta-description-char-count" class="text-slate-400">{{ mb_strlen(old('meta_description', $post->meta_description ?? '')) }}</span><span class="text-slate-400">/255</span>
                </span>
            </div>
            <p class="text-xs text-slate-500 mt-1">Akan muncul di hasil pencarian Google. Jika kosong, menggunakan bagian awal konten.</p>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route(($type ?? $post->type ?? 'berita') === 'artikel' ? 'admin.artikel.index' : 'admin.berita.index') }}" id="cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px] text-center">Batal</a>
            <button type="submit" id="submit-btn" @if(!$post->id) disabled @endif class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors min-w-[100px] disabled:opacity-50 disabled:cursor-not-allowed">
                <span id="submit-btn-text">{{ $post->id ? 'Simpan' : 'Publish' }}</span>
            </button>
        </div>
    </div>
</div>

<script>
    // Simpan data awal untuk edit mode (untuk deteksi perubahan)
    let initialData = {
        title: '',
        body: '', // Text content untuk validasi
        bodyHtml: '', // HTML content untuk deteksi perubahan format
        authorName: '',
        status: '',
        hasThumbnail: false,
        slug: '',
        excerpt: '',
        metaDescription: '',
        publishedAt: '',
        isFeatured: false,
        existingImagesCount: 0,
        tags: []
    };

    // Fungsi untuk mendapatkan body content dari Summernote atau textarea (text only)
    function getBodyContent() {
        let bodyContent = '';
        const bodyInput = document.querySelector('textarea[name="body"]');
        if (bodyInput) {
            if ($(bodyInput).summernote('code')) {
                const htmlContent = $(bodyInput).summernote('code');
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = htmlContent;
            bodyContent = tempDiv.textContent || tempDiv.innerText || '';
        } else {
                bodyContent = bodyInput.value;
            }
        }
        return bodyContent;
    }

    // Fungsi untuk mendapatkan HTML content dari Summernote
    function getBodyHtmlContent() {
            const bodyInput = document.querySelector('textarea[name="body"]');
        if (bodyInput && $(bodyInput).summernote('code')) {
            return $(bodyInput).summernote('code');
        } else if (bodyInput) {
            return bodyInput.value;
        }
        return '';
    }

    // Fungsi untuk cek apakah ada perubahan dari data awal
    function hasChanges() {
        const isEditMode = {{ $post->id ? 'true' : 'false' }};
        if (!isEditMode) {
            // Create mode: selalu ada perubahan (karena data baru)
            return true;
        }

        const titleInput = document.querySelector('input[name="title"]');
        const authorNameInput = document.querySelector('input[name="author_name"]');
        const statusSelect = document.getElementById('status-select');
        const thumbnailInput = document.getElementById('thumbnail-input');
        const thumbnailPreview = document.getElementById('thumbnail-preview');
        const currentThumbnail = document.getElementById('current-thumbnail-container');
        // Cek perubahan title
        const currentTitle = titleInput ? titleInput.value.trim() : '';
        if (currentTitle !== initialData.title) {
            return true;
        }

        // Cek perubahan body (cek HTML content untuk deteksi perubahan format)
        const currentBodyHtml = getBodyHtmlContent();
        if (currentBodyHtml !== initialData.bodyHtml) {
            return true;
        }

        // Cek perubahan author name
        const currentAuthorName = authorNameInput ? authorNameInput.value.trim() : '';
        if (currentAuthorName !== initialData.authorName) {
            return true;
        }

        // Cek perubahan status
        const currentStatus = statusSelect ? statusSelect.value : '';
        if (currentStatus !== initialData.status) {
            return true;
        }

        // Cek perubahan thumbnail
        const hasThumbnailFile = thumbnailInput && thumbnailInput.files && thumbnailInput.files.length > 0;
        const hasThumbnailPreview = thumbnailPreview && !thumbnailPreview.classList.contains('hidden');
        const hasExistingThumbnail = currentThumbnail !== null;
        const currentHasThumbnail = hasThumbnailFile || hasThumbnailPreview || hasExistingThumbnail;

        // Jika ada file baru dipilih atau preview baru muncul, berarti ada perubahan
        if (hasThumbnailFile || hasThumbnailPreview) {
            return true;
        }

        // Jika status thumbnail berubah (ada menjadi tidak ada atau sebaliknya)
        if (currentHasThumbnail !== initialData.hasThumbnail) {
            return true;
        }

        // Cek perubahan gambar konten (images)
        try {
            // Cek apakah ada gambar baru yang dipilih
            if (typeof selectedImages !== 'undefined' && Array.isArray(selectedImages) && selectedImages.length > 0) {
                return true;
            }

            // Cek apakah ada perubahan pada existing images (jumlah atau urutan)
            const existingInputs = document.querySelectorAll('input[name="existing_images[]"]');
            if (typeof initialData.existingImagesCount !== 'undefined') {
                if (existingInputs.length !== initialData.existingImagesCount) {
                    return true;
                }
            }
        } catch (e) {
            // Jika ada error, abaikan
        }

        // Cek perubahan field opsional lainnya
        const slugInput = document.getElementById('slug-input');
        const excerptInput = document.getElementById('excerpt-input');
        const metaDescriptionInput = document.getElementById('meta-description-input');
        const publishedAtInput = document.querySelector('input[name="published_at_date"]');
        const isFeaturedInput = document.getElementById('is_featured');

        if (slugInput && initialData.slug !== undefined) {
            const currentSlug = slugInput.value.trim();
            if (currentSlug !== initialData.slug) {
                return true;
            }
        }

        if (excerptInput && initialData.excerpt !== undefined) {
            const currentExcerpt = excerptInput.value.trim();
            if (currentExcerpt !== initialData.excerpt) {
                return true;
            }
        }

        if (metaDescriptionInput && initialData.metaDescription !== undefined) {
            const currentMetaDescription = metaDescriptionInput.value.trim();
            if (currentMetaDescription !== initialData.metaDescription) {
                return true;
            }
        }

        if (publishedAtInput && initialData.publishedAt !== undefined) {
            const currentPublishedAt = publishedAtInput.value;
            if (currentPublishedAt !== initialData.publishedAt) {
                return true;
            }
        }

        if (isFeaturedInput && initialData.isFeatured !== undefined) {
            const currentIsFeatured = isFeaturedInput.checked;
            if (currentIsFeatured !== initialData.isFeatured) {
                return true;
            }
        }

        // Cek perubahan tags
        const currentTags = Array.from(document.querySelectorAll('input[name="tags[]"]')).map(input => input.value);
        if (initialData.tags !== undefined && JSON.stringify(currentTags.sort()) !== JSON.stringify(initialData.tags.sort())) {
            return true;
        }

        return false; // Tidak ada perubahan
    }

    // Validasi semua field wajib dan update tombol submit
    function validateThumbnailAndUpdateButton() {
        const submitBtn = document.getElementById('submit-btn');
        const submitBtnText = document.getElementById('submit-btn-text');
        const statusSelect = document.getElementById('status-select');
        const thumbnailInput = document.getElementById('thumbnail-input');
        const thumbnailPreview = document.getElementById('thumbnail-preview');
        const currentThumbnail = document.getElementById('current-thumbnail-container');

        if (!submitBtn || !statusSelect) return;

        // Pastikan submitBtnText ada
        if (!submitBtnText) return;

        const isEditMode = {{ $post->id ? 'true' : 'false' }};
        const isBerita = {{ ($type ?? $post->type ?? 'berita') === 'berita' ? 'true' : 'false' }};
        const status = statusSelect.value;

        // Update teks tombol berdasarkan status (DILAKUKAN SEBELUM VALIDASI)
        if (!isEditMode) {
            // Create mode
            if (status === 'draft') {
                submitBtnText.textContent = 'Simpan';
            } else {
                submitBtnText.textContent = 'Publish';
            }
        } else {
            // Edit mode
            submitBtnText.textContent = 'Simpan';
        }

        // Validasi semua field wajib
        const titleInput = document.querySelector('input[name="title"]');
        const bodyInput = document.querySelector('textarea[name="body"]');
        const authorNameInput = document.querySelector('input[name="author_name"]');

        // Get body content
        const bodyContent = getBodyContent();
        // Juga cek HTML content untuk memastikan ada konten (termasuk formatting)
        const bodyHtmlContent = getBodyHtmlContent();
        const hasBody = (bodyContent && bodyContent.trim() !== '') || (bodyHtmlContent && bodyHtmlContent.trim() !== '' && bodyHtmlContent.trim() !== '<p></p>' && bodyHtmlContent.trim() !== '<p><br></p>');

        // Cek field wajib dengan lebih ketat (harus ada value yang tidak kosong)
        const hasTitle = titleInput && titleInput.value && titleInput.value.trim() !== '';
        // Cek author name - untuk published status, "Admin" (default) dihitung sebagai field terisi
        let hasAuthorName = false;
        if (authorNameInput && authorNameInput.value && authorNameInput.value.trim() !== '') {
            if (isEditMode) {
                // Edit mode: semua value dihitung
                hasAuthorName = true;
            } else {
                // Create mode: untuk published/nonaktif, "Admin" (default) dihitung sebagai field terisi
                // Untuk draft, "Admin" tidak dihitung (harus ada input manual)
                if (status === 'draft') {
                    hasAuthorName = authorNameInput.value.trim() !== 'Admin';
                } else {
                    // Published/Nonaktif: "Admin" dihitung sebagai field terisi
                    hasAuthorName = true;
                }
            }
        }

        // Cek thumbnail dari file upload
        const hasThumbnailFile = thumbnailInput && thumbnailInput.files && thumbnailInput.files.length > 0;

        // Cek thumbnail dari preview (baik dari file atau URL)
        const hasThumbnailPreview = thumbnailPreview && thumbnailPreview.classList && !thumbnailPreview.classList.contains('hidden');

        // Cek thumbnail existing
        const hasExistingThumbnail = currentThumbnail !== null;

        const hasThumbnail = hasThumbnailFile || hasThumbnailPreview || hasExistingThumbnail;

        // Cek gambar konten (untuk draft mode)
        let hasContentImages = false;
        try {
            // Cek selectedImages (file upload)
            if (typeof selectedImages !== 'undefined' && Array.isArray(selectedImages) && selectedImages.length > 0) {
                hasContentImages = true;
            }
            // Cek existingImages (gambar yang sudah ada)
            if (!hasContentImages && typeof existingImages !== 'undefined' && Array.isArray(existingImages) && existingImages.length > 0) {
                hasContentImages = true;
            }
            // Cek hidden inputs untuk existing images
            if (!hasContentImages) {
                const existingInputs = document.querySelectorAll('input[name="existing_images[]"]');
                if (existingInputs && existingInputs.length > 0) {
                    hasContentImages = true;
                }
            }
        } catch (e) {
            // Jika ada error, anggap tidak ada gambar konten
            hasContentImages = false;
        }

        // Cek field opsional (untuk draft mode)
        const metaDescriptionInput = document.getElementById('meta-description-input');
        const excerptInput = document.getElementById('excerpt-input');
        const slugInput = document.getElementById('slug-input');

        const hasMetaDescription = metaDescriptionInput && metaDescriptionInput.value && metaDescriptionInput.value.trim() !== '';
        const hasExcerpt = excerptInput && excerptInput.value && excerptInput.value.trim() !== '';
        const hasSlug = slugInput && slugInput.value && slugInput.value.trim() !== '';

        // Validasi semua field wajib
        let isValid = true;

        // LOGIKA UNTUK CREATE MODE
        if (!isEditMode) {
            if (status === 'draft') {
                // Draft: Minimal ada 1 field yang terisi (bisa field wajib atau opsional)
                // Field wajib: judul, body, author, thumbnail, gambar konten
                // Field opsional: meta_description, excerpt, slug
                // Reset isValid ke false terlebih dahulu, baru cek apakah ada field terisi
                isValid = false;
                if (hasTitle || hasBody || hasAuthorName || hasThumbnail || hasContentImages ||
                    hasMetaDescription || hasExcerpt || hasSlug) {
                    isValid = true;
                }
            } else {
                // Published/Nonaktif: Semua field wajib harus terisi
                // Reset isValid ke false terlebih dahulu
                isValid = false;

                // Cek satu per satu, semua harus terisi
                if (hasTitle && hasBody && hasAuthorName && hasThumbnail) {
                    isValid = true;
                }
            }
        }
        // LOGIKA UNTUK EDIT MODE
        else {
            // Cek apakah ada perubahan dari data awal
            const hasFormChanges = hasChanges();

            if (!hasFormChanges) {
                // Tidak ada perubahan → tombol DISABLED
                isValid = false;
            } else {
                // Ada perubahan → cek berdasarkan status
                if (status === 'draft') {
                    // Draft: Bisa disimpan walaupun field wajib dihapus
                    isValid = true;
                } else {
                    // Published/Nonaktif: Semua field wajib harus terisi
                    if (!hasTitle) isValid = false;
                    if (!hasBody) isValid = false;
                    if (!hasAuthorName) isValid = false;
                    if (!hasThumbnail) isValid = false;
                }
            }
        }

        // Update tombol submit
        // Pastikan logika enable/disable benar
        if (isValid) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            submitBtn.removeAttribute('disabled'); // Pastikan attribute disabled dihapus
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            submitBtn.setAttribute('disabled', 'disabled'); // Pastikan attribute disabled ditambahkan
        }
    }

    // Validasi segera setelah fungsi didefinisikan (jika DOM sudah ready)
    if (document.readyState !== 'loading') {
        // DOM sudah ready, validasi langsung
        setTimeout(() => {
            validateThumbnailAndUpdateButton();
        }, 10);
    }

    function addTag(tagValue) {
        if (!tagValue || tagValue.trim() === '') return;

        const tag = tagValue.trim();

        // Check if tag already exists
        const existingTags = Array.from(document.querySelectorAll('input[name="tags[]"]')).map(el => el.value.toLowerCase());
        if (existingTags.includes(tag.toLowerCase())) {
            return; // Tag sudah ada, skip
        }

        // Check max tags (10)
        const currentTagsCount = document.querySelectorAll('input[name="tags[]"]').length;
        if (currentTagsCount >= 10) {
            showTagLimitModal();
            return;
        }

        // Create tag element (GitHub style)
        const tagItem = document.createElement('div');
        tagItem.className = 'tag-item inline-flex items-center bg-green-50 dark:bg-green-900/30 text-green-700 dark:text-white pl-2 pr-0.5 py-0.5 rounded-md text-xs font-medium border border-green-200 dark:border-green-700';
        tagItem.innerHTML = `
            <span class="mr-1">${tag}</span>
            <button type="button" onclick="removeTag(this)" class="text-green-600 dark:text-white hover:text-green-800 dark:hover:text-white p-0.5 rounded-r-md hover:bg-green-100 dark:hover:bg-green-800/50 flex items-center justify-center">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <input type="hidden" name="tags[]" value="${tag}">
        `;

        document.getElementById('tags-container').appendChild(tagItem);

        // Validasi tombol setelah menambah tag
        if (typeof validateThumbnailAndUpdateButton === 'function') {
            validateThumbnailAndUpdateButton();
        }
    }

    function removeTag(button) {
        button.closest('.tag-item').remove();

        // Validasi tombol setelah menghapus tag
        if (typeof validateThumbnailAndUpdateButton === 'function') {
            validateThumbnailAndUpdateButton();
        }
    }

    let selectedSuggestionIndex = -1;
    let suggestions = [];

    function processTag() {
        const input = document.getElementById('tag-input');
        const value = input.value.trim();

        if (value === '') return;

        // Add single tag (one at a time like GitHub)
        addTag(value);

        // Clear input and hide suggestions after processing
        input.value = '';
        hideSuggestions();
        input.focus();
    }

    function showSuggestions(tagSuggestions) {
        const suggestionsDiv = document.getElementById('tag-suggestions');
        const suggestionsList = document.getElementById('suggestions-list');

        if (!tagSuggestions || tagSuggestions.length === 0) {
            hideSuggestions();
            return;
        }

        suggestions = tagSuggestions;
        selectedSuggestionIndex = -1;

        suggestionsList.innerHTML = '';
        tagSuggestions.forEach((tag, index) => {
            const item = document.createElement('div');
            item.className = 'suggestion-item px-3 py-2 text-sm text-slate-700 dark:text-slate-200 cursor-pointer hover:bg-green-100 dark:hover:bg-green-800 hover:text-green-900 dark:hover:text-green-100 transition-colors';
            item.textContent = tag;
            item.dataset.index = index;
            item.addEventListener('click', function() {
                addTag(tag);
                document.getElementById('tag-input').value = '';
                hideSuggestions();
                document.getElementById('tag-input').focus();
            });
            item.addEventListener('mouseenter', function() {
                selectedSuggestionIndex = parseInt(this.dataset.index);
                updateSuggestionHighlight();
            });
            suggestionsList.appendChild(item);
        });

        suggestionsDiv.classList.remove('hidden');
    }

    function hideSuggestions() {
        document.getElementById('tag-suggestions').classList.add('hidden');
        selectedSuggestionIndex = -1;
    }

    function fetchSuggestions(query) {
        if (!query || query.trim() === '') {
            // Show all suggestions if query is empty
            fetch('{{ route("api.tags.suggestions") }}')
                .then(response => response.json())
                .then(data => {
                    // Filter out tags that are already added
                    const existingTags = Array.from(document.querySelectorAll('input[name="tags[]"]')).map(el => el.value.toLowerCase());
                    const filtered = data.filter(tag => !existingTags.includes(tag.toLowerCase()));
                    showSuggestions(filtered);
                })
                .catch(() => hideSuggestions());
        } else {
            fetch(`{{ route("api.tags.suggestions") }}?q=${encodeURIComponent(query)}`)
                .then(response => response.json())
                .then(data => {
                    // Filter out tags that are already added
                    const existingTags = Array.from(document.querySelectorAll('input[name="tags[]"]')).map(el => el.value.toLowerCase());
                    const filtered = data.filter(tag => !existingTags.includes(tag.toLowerCase()));
                    showSuggestions(filtered);
                })
                .catch(() => hideSuggestions());
        }
    }

    // Add tag on Enter key
    const tagInput = document.getElementById('tag-input');
    if (tagInput) {
    tagInput.addEventListener('keydown', function(e) {
        const suggestionsDiv = document.getElementById('tag-suggestions');
            const isSuggestionsVisible = suggestionsDiv && suggestionsDiv.classList && !suggestionsDiv.classList.contains('hidden');

        if (e.key === 'Enter') {
            e.preventDefault();
            if (isSuggestionsVisible && selectedSuggestionIndex >= 0 && suggestions[selectedSuggestionIndex]) {
                // Select suggestion
                addTag(suggestions[selectedSuggestionIndex]);
                this.value = '';
                hideSuggestions();
                this.focus();
            } else {
                // Add new tag
                processTag();
            }
        } else if (e.key === 'ArrowDown') {
            e.preventDefault();
            if (suggestions.length > 0) {
                // Pastikan suggestions terlihat
                if (!isSuggestionsVisible) {
                    fetchSuggestions(this.value);
                    return;
                }
                selectedSuggestionIndex = Math.min(selectedSuggestionIndex + 1, suggestions.length - 1);
                updateSuggestionHighlight();
            } else {
                // Jika belum ada suggestions, fetch dulu
                fetchSuggestions(this.value);
            }
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            if (suggestions.length > 0) {
                // Pastikan suggestions terlihat
                if (!isSuggestionsVisible) {
                    fetchSuggestions(this.value);
                    return;
                }
                selectedSuggestionIndex = Math.max(selectedSuggestionIndex - 1, -1);
                if (selectedSuggestionIndex === -1) {
                    // Jika sudah di atas, hilangkan highlight tapi tetap tampilkan suggestions
                    updateSuggestionHighlight();
                } else {
                    updateSuggestionHighlight();
                }
            } else {
                // Jika belum ada suggestions, fetch dulu
                fetchSuggestions(this.value);
            }
        } else if (e.key === 'Escape') {
            hideSuggestions();
        } else if (e.key === 'Backspace' && this.value === '') {
            // Delete last tag when backspace on empty input
            const tags = document.querySelectorAll('.tag-item');
            if (tags.length > 0) {
                const lastTag = tags[tags.length - 1];
                removeTag(lastTag.querySelector('button'));
            }
        }
    });
    }

    function updateSuggestionHighlight() {
        const suggestionsList = document.getElementById('suggestions-list');
        const suggestionItems = document.querySelectorAll('.suggestion-item');

        suggestionItems.forEach((el, index) => {
            el.classList.remove('bg-green-100', 'dark:bg-green-800', 'text-green-900', 'dark:text-green-100', 'bg-slate-50', 'dark:bg-slate-700');
            if (index === selectedSuggestionIndex) {
                el.classList.add('bg-green-100', 'dark:bg-green-800', 'text-green-900', 'dark:text-green-100');
                // Scroll ke item yang dipilih agar terlihat
                el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            }
        });

        // Pastikan suggestions div terlihat
        const suggestionsDiv = document.getElementById('tag-suggestions');
        if (selectedSuggestionIndex >= 0 && suggestions.length > 0) {
            suggestionsDiv.classList.remove('hidden');
        }
    }

    // Fetch suggestions on input (muncul saat mengetik)
    let debounceTimer;
    tagInput.addEventListener('input', function() {
        clearTimeout(debounceTimer);
        const query = this.value.trim();

        // Jika input kosong, tetap tampilkan suggestions (semua tag)
        debounceTimer = setTimeout(() => {
            fetchSuggestions(query);
        }, 150); // Kurangi delay untuk lebih responsif
    });

    // Show suggestions on focus
    tagInput.addEventListener('focus', function() {
        if (this.value.trim() === '') {
            fetchSuggestions('');
        } else {
            fetchSuggestions(this.value);
        }
    });

    // Hide suggestions when clicking outside
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('tags-wrapper');
        const suggestions = document.getElementById('tag-suggestions');
        if (wrapper && suggestions && !wrapper.contains(e.target) && !suggestions.contains(e.target)) {
            hideSuggestions();
        }
    });

    // Auto-process tag saat input blur (jika ada isi)
    tagInput.addEventListener('blur', function() {
        // Delay to allow click on suggestions
        setTimeout(() => {
            if (this.value.trim()) {
                processTag();
            }
            hideSuggestions();
        }, 200);
    });

    // Images Upload Handler
    let selectedImages = [];
    let existingImages = @json($existingImages ?? []);

    function handleImagesSelect(event) {
        const files = Array.from(event.target.files);
        processImageFiles(files);
        // Reset input file agar bisa upload file yang sama lagi
        event.target.value = '';
    }

    function processImageFiles(files) {
        files.forEach(file => {
            if (file.type.startsWith('image/')) {
                const maxSize = 5 * 1024 * 1024; // 5MB
                if (file.size > maxSize) {
                    alert(`File ${file.name} terlalu besar! Maksimal: 5MB`);
                    return;
                }
                // Cek apakah file sudah ada (untuk menghindari duplikasi)
                const isDuplicate = selectedImages.some(existingFile =>
                    existingFile && existingFile.name === file.name && existingFile.size === file.size
                );
                if (!isDuplicate) {
                    selectedImages.push(file);
                }
            }
        });
        // Sync ke input dan update preview
        syncImagesToInput();
        updateImagesPreview();
        // Validasi tombol untuk draft mode
        if (typeof validateThumbnailAndUpdateButton === 'function') {
            validateThumbnailAndUpdateButton();
        }
    }

    function handleImagesDrop(event) {
        event.preventDefault();
        event.stopPropagation();
        const uploadCard = document.getElementById('images-upload-card');
        if (uploadCard) {
            uploadCard.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }

        const files = Array.from(event.dataTransfer.files).filter(f => f.type.startsWith('image/'));
        if (files.length === 0) {
            alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
            return;
        }

        // Update input files
        const input = document.getElementById('images-input');
        const dataTransfer = new DataTransfer();
        files.forEach(file => dataTransfer.items.add(file));
        input.files = dataTransfer.files;

        processImageFiles(files);
    }

    function handleImagesDragOver(event) {
        event.preventDefault();
        event.stopPropagation();
        const uploadCard = document.getElementById('images-upload-card');
        if (uploadCard) {
            uploadCard.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }
    }

    function handleImagesDragLeave(event) {
        event.preventDefault();
        event.stopPropagation();
        const uploadCard = document.getElementById('images-upload-card');
        if (uploadCard) {
            uploadCard.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }
    }


    // Fungsi untuk validasi jumlah gambar (dipanggil dari berbagai tempat)
    function validateImageCount() {
        const warningDiv = document.getElementById('images-warning');
        const warningText = document.getElementById('images-warning-text');
        const submitBtn = document.getElementById('submit-btn');

        // Hitung total gambar (selected + existing)
        // Pastikan menghitung dari hidden inputs yang benar-benar ada di DOM
        const existingInputs = document.querySelectorAll('input[name="existing_images[]"]');
        const totalExisting = Array.from(existingInputs).filter(input => {
            // Pastikan input masih ada di DOM dan memiliki value yang valid
            return input && input.value && input.value.trim() !== '';
        }).length;

        // Pastikan selectedImages hanya berisi File objects yang valid
        const validSelectedImages = selectedImages.filter(file => file && file instanceof File);
        const totalImages = validSelectedImages.length + totalExisting;

        // Validasi jumlah gambar
        if (totalImages > 6) {
            if (warningDiv) {
                warningDiv.classList.remove('hidden');
                warningText.textContent = `⚠️ Maksimal 6 gambar! Saat ini: ${totalImages} gambar. Hapus ${totalImages - 6} gambar untuk melanjutkan.`;
                warningDiv.className = 'mb-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg';
            }
            // Disable submit button
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            return false;
        } else if (totalImages > 1 && totalImages % 2 !== 0) {
            if (warningDiv) {
                warningDiv.classList.remove('hidden');
                warningText.textContent = `Jumlah gambar ganjil (${totalImages} gambar) tidak dapat disimpan! Harus 1, 2, 4, atau 6 gambar.`;
                warningDiv.className = 'mb-3 p-3 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg';
            }
            // Disable submit button
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
            return false;
        } else {
            if (warningDiv) {
                warningDiv.classList.add('hidden');
            }
            // Enable submit button
            if (submitBtn) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            }
            return true;
        }
    }

    function updateImagesPreview() {
        const previewContainer = document.getElementById('images-preview-container');
        const previewList = document.getElementById('images-preview-list');

        // Validasi jumlah gambar
        validateImageCount();

        // Clear preview list
        previewList.innerHTML = '';

        if (selectedImages.length === 0) {
            // Hide preview container jika tidak ada gambar
            previewContainer.classList.add('hidden');
            return;
        }

        // Show preview container jika ada gambar
        previewContainer.classList.remove('hidden');

        selectedImages.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'image-item relative group draggable-image';
                div.draggable = true;
                div.dataset.index = index;
                div.innerHTML = `
                    <div class="overflow-hidden border border-gray-200 dark:border-slate-700 cursor-move" onclick="if(!event.target.closest('button')) openImageZoom('${e.target.result}')" style="border-radius: 0;">
                        <img src="${e.target.result}" alt="Pratinjau ${index + 1}" class="w-full aspect-video object-cover hover:opacity-90 transition-opacity pointer-events-none">
                    </div>
                    <button type="button" onclick="event.stopPropagation(); removeImage(${index});" class="absolute top-0 -right-1 text-red-600 hover:text-red-700 opacity-0 group-hover:opacity-100 transition-opacity z-10">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                    <div class="absolute top-2 left-2 bg-black bg-opacity-50 text-white text-xs px-2 py-1 rounded pointer-events-none">
                        <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                    </div>
                `;
                previewList.appendChild(div);
                setupDragAndDrop(div);
            };
            reader.readAsDataURL(file);
        });

        // Setup drag and drop untuk semua gambar
        setupDragAndDropForAll();

        // Validasi ulang setelah semua preview selesai di-render
        setTimeout(() => {
            validateImageCount();
            // Validasi tombol untuk draft mode
            if (typeof validateThumbnailAndUpdateButton === 'function') {
                validateThumbnailAndUpdateButton();
            }
        }, 100);
    }

    function removeImage(index) {
        showDeleteImageModal('new', index, null, null);
    }

    function executeRemoveImage(index) {
        // Pastikan index valid
        if (index < 0 || index >= selectedImages.length) {
            console.warn('Invalid index for removeImage:', index, 'Selected images length:', selectedImages.length);
            return;
        }
        selectedImages.splice(index, 1);
        const input = document.getElementById('images-input');
        if (input) {
            const dataTransfer = new DataTransfer();
            selectedImages.forEach(file => {
                if (file && file instanceof File) {
                    dataTransfer.items.add(file);
                }
            });
            input.files = dataTransfer.files;
        }
        updateImagesPreview();
        // Validasi tombol untuk draft mode setelah hapus gambar
        if (typeof validateThumbnailAndUpdateButton === 'function') {
            validateThumbnailAndUpdateButton();
        }
    }

    // Drag and Drop Functions
    let draggedElement = null;
    let draggedIndex = null;
    let isDragging = false;

    function setupDragAndDrop(element) {
        if (!element) return;

        element.addEventListener('dragstart', function(e) {
            draggedElement = this;
            draggedIndex = parseInt(this.dataset.index);
            isDragging = true;
            this.style.opacity = '0.5';
            e.dataTransfer.effectAllowed = 'move';
            e.dataTransfer.setData('text/html', this.innerHTML);
        });

        element.addEventListener('dragend', function(e) {
            this.style.opacity = '1';
            isDragging = false;
            // Remove all drag-over classes
            document.querySelectorAll('.draggable-image').forEach(el => {
                el.classList.remove('drag-over');
            });
        });

        element.addEventListener('dragover', function(e) {
            if (e.preventDefault) {
                e.preventDefault();
            }
            e.dataTransfer.dropEffect = 'move';

            if (this !== draggedElement) {
                this.classList.add('drag-over');
            }
            return false;
        });

        element.addEventListener('dragenter', function(e) {
            if (this !== draggedElement) {
                this.classList.add('drag-over');
            }
        });

        element.addEventListener('dragleave', function(e) {
            this.classList.remove('drag-over');
        });

        element.addEventListener('drop', function(e) {
            if (e.stopPropagation) {
                e.stopPropagation();
            }

            this.classList.remove('drag-over');

            if (draggedElement && draggedElement !== this) {
                const targetIndex = parseInt(this.dataset.index) || 0;
                const isNewImage = draggedElement.closest('#images-preview-list');
                const isExistingImage = draggedElement.closest('#existing-images-list');

                if (isNewImage && this.closest('#images-preview-list')) {
                    // Drag within new images
                    swapNewImages(draggedIndex, targetIndex);
                } else if (isExistingImage && this.closest('#existing-images-list')) {
                    // Drag within existing images
                    swapExistingImages(draggedElement, this);
                }
            }

            draggedElement = null;
            draggedIndex = null;
            return false;
        });
    }

    function setupDragAndDropForAll() {
        // Setup untuk gambar baru
        document.querySelectorAll('#images-preview-list .draggable-image').forEach((el, index) => {
            el.dataset.index = index;
            setupDragAndDrop(el);
        });

        // Setup untuk gambar existing
        document.querySelectorAll('#existing-images-list .draggable-image').forEach((el, index) => {
            el.dataset.index = index;
            setupDragAndDrop(el);
        });
    }

    function swapNewImages(fromIndex, toIndex) {
        // Swap dalam array selectedImages
        if (fromIndex !== toIndex && fromIndex >= 0 && toIndex >= 0 &&
            fromIndex < selectedImages.length && toIndex < selectedImages.length) {
            const temp = selectedImages[fromIndex];
            selectedImages[fromIndex] = selectedImages[toIndex];
            selectedImages[toIndex] = temp;

            // Update file input
            const input = document.getElementById('images-input');
            const dataTransfer = new DataTransfer();
            selectedImages.forEach(file => dataTransfer.items.add(file));
            input.files = dataTransfer.files;

            // Refresh preview
            updateImagesPreview();
        }
    }

    function swapExistingImages(fromElement, toElement) {
        const container = fromElement.parentElement;

        // Get all existing images
        const allImages = Array.from(container.querySelectorAll('.image-item'));
        const fromIndex = allImages.indexOf(fromElement);
        const toIndex = allImages.indexOf(toElement);

        if (fromIndex < toIndex) {
            container.insertBefore(fromElement, toElement.nextSibling);
        } else {
            container.insertBefore(fromElement, toElement);
        }

        // Update hidden inputs order
        updateExistingImagesOrder();
    }

    function updateExistingImagesOrder() {
        const container = document.getElementById('existing-images-list');
        const images = container.querySelectorAll('.image-item');
        const hiddenInputs = container.querySelectorAll('input[name="existing_images[]"]');

        // Remove all hidden inputs
        hiddenInputs.forEach(input => input.remove());

        // Re-add hidden inputs in new order
        images.forEach((item, index) => {
            const imagePath = item.dataset.image;
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'existing_images[]';
            input.value = imagePath;
            item.appendChild(input);
            item.dataset.index = index;
        });

        // Validasi ulang setelah update order
        setTimeout(() => validateImageCount(), 10);
    }

    // Variabel untuk menyimpan data gambar yang akan dihapus
    let pendingDeleteImage = {
        type: null, // 'existing' atau 'new'
        index: null,
        imagePath: null,
        button: null
    };

    function showDeleteImageModal(type, index, imagePath, button) {
        pendingDeleteImage = { type, index, imagePath, button };
        const modal = document.getElementById('delete-image-modal');
        const modalTitle = document.getElementById('delete-image-modal-title');
        const modalMessage = document.getElementById('delete-image-modal-message');

        if (modal) {
            // Update teks modal berdasarkan tipe
            if (type === 'thumbnail') {
                if (modalTitle) modalTitle.textContent = 'Konfirmasi Hapus Thumbnail';
                if (modalMessage) modalMessage.textContent = 'Apakah Anda yakin ingin menghapus thumbnail ini? Tindakan ini tidak dapat dibatalkan.';
            } else {
                if (modalTitle) modalTitle.textContent = 'Konfirmasi Hapus Gambar';
                if (modalMessage) modalMessage.textContent = 'Apakah Anda yakin ingin menghapus gambar ini? Tindakan ini tidak dapat dibatalkan.';
            }
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function hideDeleteImageModal() {
        const modal = document.getElementById('delete-image-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
        pendingDeleteImage = { type: null, index: null, imagePath: null, button: null };
    }

    function confirmDeleteImage() {
        if (pendingDeleteImage.type === 'existing') {
            // Hapus gambar existing
            const beforeCount = existingImages.length;
            existingImages = existingImages.filter(img => img !== pendingDeleteImage.imagePath);
            const afterCount = existingImages.length;

            if (pendingDeleteImage.button) {
                pendingDeleteImage.button.closest('.image-item').remove();
            }

            // Update hidden inputs - pastikan semua input dengan value yang sama dihapus
            const hiddenInputs = document.querySelectorAll('input[name="existing_images[]"]');
            let removedCount = 0;
            hiddenInputs.forEach(input => {
                if (input && input.value === pendingDeleteImage.imagePath) {
                    input.remove();
                    removedCount++;
                }
            });

            // Pastikan existingImages array sinkron dengan hidden inputs
            const remainingInputs = Array.from(document.querySelectorAll('input[name="existing_images[]"]')).map(inp => inp.value);
            existingImages = existingImages.filter(img => remainingInputs.includes(img));

            // Update warning setelah hapus dan validasi ulang
            validateImageCount();

            // Jika tidak ada existing images lagi, sembunyikan container
            const existingContainer = document.getElementById('existing-images-container');
            if (existingContainer && document.querySelectorAll('input[name="existing_images[]"]').length === 0) {
                existingContainer.classList.add('hidden');
            }

            // Validasi tombol untuk draft mode setelah hapus gambar
            if (typeof validateThumbnailAndUpdateButton === 'function') {
                validateThumbnailAndUpdateButton();
            }
        } else if (pendingDeleteImage.type === 'new') {
            // Hapus gambar baru
            executeRemoveImage(pendingDeleteImage.index);
        }
        hideDeleteImageModal();
    }

    function removeExistingImage(button, imagePath) {
        showDeleteImageModal('existing', null, imagePath, button);
    }



    function openImageZoom(imageSrc) {
        const modal = document.getElementById('imagePreviewModal');
        const img = document.getElementById('previewImage');
        img.src = imageSrc;
        img.alt = 'Pratinjau';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }

    function closeImagePreview(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
        const modal = document.getElementById('imagePreviewModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }
        return false;
    }

    // Update karakter counter
    function updateCharCount(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        if (input && counter) {
            // Hapus event listener yang sudah ada jika ada
            const newInput = input.cloneNode(true);
            input.parentNode.replaceChild(newInput, input);
            const freshInput = document.getElementById(inputId);

            // Tambahkan event listener baru
            freshInput.addEventListener('input', function() {
                const length = this.value.length;
                counter.textContent = length;
            });

            // Update initial count
            const initialLength = freshInput.value.length;
            counter.textContent = initialLength;
        }
    }

    // Fungsi untuk update counter langsung tanpa menambahkan event listener
    function updateCharCountDirect(inputId, counterId, maxLength) {
        const input = document.getElementById(inputId);
        const counter = document.getElementById(counterId);
        if (input && counter) {
            const length = input.value.length;
            counter.textContent = length;
        }
    }

    // Setup event listeners untuk modal setelah DOM ready
    document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi counter untuk semua input (langsung update tanpa menambahkan event listener karena sudah ada oninput)
        updateCharCountDirect('title-input', 'title-char-count', 160);
        updateCharCountDirect('slug-input', 'slug-char-count', 160);
        updateCharCountDirect('excerpt-input', 'excerpt-char-count', 500);
        updateCharCountDirect('author-name-input', 'author-name-char-count', 100);
        updateCharCountDirect('meta-description-input', 'meta-description-char-count', 255);

        // Validasi semua field wajib dan update tombol saat load
        // Untuk create mode, disable tombol terlebih dahulu
        // Untuk edit mode, disable tombol terlebih dahulu sampai data awal tersimpan dan validasi selesai
        const isEditMode = {{ $post->id ? 'true' : 'false' }};
        const submitBtn = document.getElementById('submit-btn');

        if (submitBtn) {
            // Baik create maupun edit mode: disable tombol terlebih dahulu
            // Untuk edit mode, akan di-enable jika ada perubahan
            // Untuk create mode, akan di-enable jika field wajib terisi (kecuali draft)
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
        }

        // Simpan data awal untuk edit mode (setelah semua elemen ter-render)
        if (isEditMode) {
            setTimeout(() => {
                const titleInput = document.querySelector('input[name="title"]');
                const authorNameInput = document.querySelector('input[name="author_name"]');
                const statusSelect = document.getElementById('status-select');
                const thumbnailInput = document.getElementById('thumbnail-input');
                const thumbnailPreview = document.getElementById('thumbnail-preview');
                const currentThumbnail = document.getElementById('current-thumbnail-container');
                const slugInput = document.getElementById('slug-input');
                const excerptInput = document.getElementById('excerpt-input');
                const metaDescriptionInput = document.getElementById('meta-description-input');
                const publishedAtInput = document.querySelector('input[name="published_at_date"]');
                const isFeaturedInput = document.getElementById('is_featured');
                const existingImagesInputs = document.querySelectorAll('input[name="existing_images[]"]');
                const tagsInputs = document.querySelectorAll('input[name="tags[]"]');

                // Simpan data awal
                initialData.title = titleInput ? titleInput.value.trim() : '';
                initialData.body = getBodyContent(); // Text content untuk validasi
                initialData.bodyHtml = getBodyHtmlContent(); // HTML content untuk deteksi perubahan
                initialData.authorName = authorNameInput ? authorNameInput.value.trim() : '';
                initialData.status = statusSelect ? statusSelect.value : '';
                initialData.slug = slugInput ? slugInput.value.trim() : '';
                initialData.excerpt = excerptInput ? excerptInput.value.trim() : '';
                initialData.metaDescription = metaDescriptionInput ? metaDescriptionInput.value.trim() : '';
                initialData.publishedAt = publishedAtInput ? publishedAtInput.value : '';
                initialData.isFeatured = isFeaturedInput ? isFeaturedInput.checked : false;
                initialData.existingImagesCount = existingImagesInputs ? existingImagesInputs.length : 0;
                initialData.tags = Array.from(tagsInputs).map(input => input.value);

                // Simpan status thumbnail awal
                const hasThumbnailFile = thumbnailInput && thumbnailInput.files && thumbnailInput.files.length > 0;
                const hasThumbnailPreview = thumbnailPreview && thumbnailPreview.classList && !thumbnailPreview.classList.contains('hidden');
                const hasExistingThumbnail = currentThumbnail !== null;
                initialData.hasThumbnail = hasThumbnailFile || hasThumbnailPreview || hasExistingThumbnail;

                // Validasi setelah data awal disimpan
                validateThumbnailAndUpdateButton();
            }, 800); // Delay lebih lama untuk memastikan Summernote sudah ter-load dan data tersimpan
        } else {
            // Create mode: validasi setelah semua elemen ter-render (termasuk Summernote)
            setTimeout(() => {
                validateThumbnailAndUpdateButton();
            }, 500);
        }

        // Update tombol saat status berubah
        const statusSelect = document.getElementById('status-select');
        const submitBtnTextForStatus = document.getElementById('submit-btn-text');
        const isEditModeForStatus = {{ $post->id ? 'true' : 'false' }};

        // Fungsi untuk update attribute required berdasarkan status
        function updateRequiredFields(status) {
            const titleInput = document.getElementById('title-input');
            const bodyInput = document.querySelector('textarea[name="body"]');
            const authorNameInput = document.getElementById('author-name-input');

            if (status === 'draft') {
                // Draft: Hapus required dari semua field wajib
                if (titleInput) {
                    titleInput.removeAttribute('required');
                }
                if (bodyInput) {
                    bodyInput.removeAttribute('required');
                }
                if (authorNameInput) {
                    authorNameInput.removeAttribute('required');
                }
            } else {
                // Published/Nonaktif: Tambahkan required ke semua field wajib
                if (titleInput) {
                    titleInput.setAttribute('required', 'required');
                }
                if (bodyInput) {
                    bodyInput.setAttribute('required', 'required');
                }
                if (authorNameInput) {
                    authorNameInput.setAttribute('required', 'required');
                }
            }
        }

        if (statusSelect && submitBtnTextForStatus) {
            statusSelect.addEventListener('change', function() {
                // Saat status berubah, langsung update teks tombol dan validasi
                const currentStatus = this.value;
                const submitBtn = document.getElementById('submit-btn');

                // Update attribute required berdasarkan status
                updateRequiredFields(currentStatus);

                // Update teks tombol langsung saat status berubah
                if (!isEditModeForStatus) {
                    // Create mode
                    if (currentStatus === 'draft') {
                        submitBtnTextForStatus.textContent = 'Simpan';
                        // Pastikan tombol disabled dulu saat status berubah ke draft
                        // Akan di-enable oleh validateThumbnailAndUpdateButton jika ada field terisi
                        if (submitBtn) {
                            submitBtn.disabled = true;
                            submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
                            submitBtn.setAttribute('disabled', 'disabled');
                        }
                    } else {
                        submitBtnTextForStatus.textContent = 'Publish';
                    }
                } else {
                    // Edit mode
                    submitBtnTextForStatus.textContent = 'Simpan';
                }

                // Kemudian validasi untuk enable/disable tombol
                // Delay sedikit untuk memastikan semua perubahan sudah ter-apply
                setTimeout(() => {
                    validateThumbnailAndUpdateButton();
                }, 50);
            });
        }

        // Set required fields saat halaman load berdasarkan status awal
        const initialStatus = statusSelect ? statusSelect.value : 'published';
        updateRequiredFields(initialStatus);

        // Update tombol saat field wajib berubah
        const titleInput = document.getElementById('title-input');
        const bodyInput = document.querySelector('textarea[name="body"]');
        const authorNameInput = document.getElementById('author-name-input');
        const thumbnailInput = document.getElementById('thumbnail-input');

        if (titleInput) {
            titleInput.addEventListener('input', validateThumbnailAndUpdateButton);
            titleInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        if (bodyInput) {
            bodyInput.addEventListener('input', validateThumbnailAndUpdateButton);
            bodyInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        if (authorNameInput) {
            authorNameInput.addEventListener('input', validateThumbnailAndUpdateButton);
            authorNameInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        if (thumbnailInput) {
            thumbnailInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        // Update tombol saat field opsional berubah (untuk draft mode)
        const metaDescriptionInput = document.getElementById('meta-description-input');
        const excerptInput = document.getElementById('excerpt-input');
        const slugInput = document.getElementById('slug-input');

        if (metaDescriptionInput) {
            metaDescriptionInput.addEventListener('input', validateThumbnailAndUpdateButton);
            metaDescriptionInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        if (excerptInput) {
            excerptInput.addEventListener('input', validateThumbnailAndUpdateButton);
            excerptInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        if (slugInput) {
            slugInput.addEventListener('input', validateThumbnailAndUpdateButton);
            slugInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        // Update tombol saat published date berubah
        const publishedAtInput = document.querySelector('input[name="published_at_date"]');
        if (publishedAtInput) {
            publishedAtInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        // Update tombol saat is_featured berubah
        const isFeaturedInput = document.getElementById('is_featured');
        if (isFeaturedInput) {
            isFeaturedInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        // Initialize Summernote editor with image upload
        (function initSummernote() {
            const editorEl = document.querySelector('#body-editor');
            if (!editorEl) return;

            function createEditor() {
                if (typeof $ !== 'undefined' && $.fn.summernote) {
                    $(editorEl).summernote({
                        height: 400,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                            ['fontname', ['fontname']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video']],
                            ['view', ['fullscreen', 'codeview', 'help']],
                            ['history', ['undo', 'redo']]
                        ],
                        callbacks: {
                            onImageUpload: function(files) {
                                uploadImageToServer(files[0], editorEl);
                            },
                            onChange: function(contents) {
                                if (typeof validateThumbnailAndUpdateButton === 'function') {
                                    validateThumbnailAndUpdateButton();
                                }
                            }
                        }
                            });

                    // Initial validation after editor ready
                    setTimeout(() => {
                        if (typeof validateThumbnailAndUpdateButton === 'function') {
                            validateThumbnailAndUpdateButton();
                        }
                    }, 200);
                } else {
                    console.error('Summernote not loaded');
                                            }
            }

            function uploadImageToServer(file, editorEl) {
                const formData = new FormData();
                formData.append('upload', file);

                fetch('{{ route("admin.uploads.images") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.url) {
                        $(editorEl).summernote('insertImage', data.url);
                } else {
                        alert('Gagal mengupload gambar');
                    }
                })
                .catch(error => {
                    console.error('Upload error:', error);
                    alert('Gagal mengupload gambar');
                });
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', createEditor);
            } else {
                setTimeout(createEditor, 50);
            }
        })();

        if (authorNameInput) {
            authorNameInput.addEventListener('input', validateThumbnailAndUpdateButton);
            authorNameInput.addEventListener('change', validateThumbnailAndUpdateButton);
        }

        const modal = document.getElementById('imagePreviewModal');
        const closeBtn = modal?.querySelector('.close-modal-btn');

        if (closeBtn) {
            closeBtn.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();
                closeImagePreview(e);
                return false;
            }, true); // Use capture phase untuk memastikan event di-handle lebih dulu
        }

        // Background click handler
        if (modal) {
            modal.addEventListener('click', function(e) {
                if (e.target === modal) {
                    e.preventDefault();
                    e.stopPropagation();
                    closeImagePreview(e);
                    return false;
                }
            }, true);
        }

        // Setup event listeners untuk modal hapus gambar
        const deleteImageModal = document.getElementById('delete-image-modal');
        const deleteImageModalCancelBtn = document.getElementById('delete-image-modal-cancel-btn');
        const deleteImageModalConfirmBtn = document.getElementById('delete-image-modal-confirm-btn');

        if (deleteImageModalCancelBtn) {
            deleteImageModalCancelBtn.addEventListener('click', () => {
                hideDeleteImageModal();
            });
        }

        if (deleteImageModalConfirmBtn) {
            deleteImageModalConfirmBtn.addEventListener('click', () => {
                confirmDeleteImage();
            });
        }

        if (deleteImageModal) {
            deleteImageModal.addEventListener('click', (e) => {
                if (e.target === deleteImageModal) {
                    hideDeleteImageModal();
                }
            });
        }

        // Setup event listeners untuk modal tag limit
        const tagLimitModal = document.getElementById('tag-limit-modal');
        const tagLimitModalOkBtn = document.getElementById('tag-limit-modal-ok-btn');

        if (tagLimitModalOkBtn) {
            tagLimitModalOkBtn.addEventListener('click', () => {
                hideTagLimitModal();
            });
        }

        if (tagLimitModal) {
            tagLimitModal.addEventListener('click', (e) => {
                if (e.target === tagLimitModal) {
                    hideTagLimitModal();
                }
            });
        }
    });

    // Tutup modal dengan tombol ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('imagePreviewModal');
            if (modal && modal.classList && !modal.classList.contains('hidden')) {
                closeImagePreview(e);
            }
        }
    });

    // Check for existing images on load
    window.addEventListener('load', function() {
        // Show preview container if there are selected images
        if (selectedImages.length > 0) {
            document.getElementById('images-preview-container').classList.remove('hidden');
        }
        // Check images count on load
        updateImagesPreview();
        // Setup drag and drop untuk existing images
        setTimeout(() => {
            setupDragAndDropForAll();
        }, 100);
    });

    // Setup drag and drop saat DOM ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(() => {
                setupDragAndDropForAll();
            }, 100);
        });
    } else {
        setTimeout(() => {
            setupDragAndDropForAll();
        }, 100);
    }

    // Thumbnail Preview
    function updateThumbnailPreview(input) {
        if (input.files && input.files[0]) {
            processThumbnailFile(input.files[0]);
        }
    }

    function processThumbnailFile(file) {
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
            return;
        }

        const maxSize = 5 * 1024 * 1024; // 5MB
        if (file.size > maxSize) {
            const fileSizeMB = (file.size / (1024 * 1024)).toFixed(2);
            alert(`Ukuran file terlalu besar! File Anda: ${fileSizeMB}MB. Maksimal: 5MB.\n\nSilakan kompres atau pilih file lain.`);
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const previewDiv = document.getElementById('thumbnail-preview');
            const previewImg = document.getElementById('thumbnail-preview-img');
            previewImg.src = e.target.result;
            previewDiv.classList.remove('hidden');
            // Update validasi tombol setelah thumbnail diupload
            validateThumbnailAndUpdateButton();
        };
        reader.readAsDataURL(file);
    }

    function handleThumbnailDrop(event) {
        event.preventDefault();
        event.stopPropagation();
        const uploadCard = document.getElementById('thumbnail-upload-card');
        if (uploadCard) {
            uploadCard.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }

        const file = Array.from(event.dataTransfer.files).find(f => f.type.startsWith('image/'));
        if (!file) {
            alert('File harus berupa gambar (JPG, PNG, atau WEBP)');
            return;
        }

        // Update input files
        const input = document.getElementById('thumbnail-input');
        const dataTransfer = new DataTransfer();
        dataTransfer.items.add(file);
        input.files = dataTransfer.files;

        processThumbnailFile(file);
    }

    function handleThumbnailDragOver(event) {
        event.preventDefault();
        event.stopPropagation();
        const uploadCard = document.getElementById('thumbnail-upload-card');
        if (uploadCard) {
            uploadCard.classList.add('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }
    }

    function handleThumbnailDragLeave(event) {
        event.preventDefault();
        event.stopPropagation();
        const uploadCard = document.getElementById('thumbnail-upload-card');
        if (uploadCard) {
            uploadCard.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-green-900');
        }
    }

    function removeThumbnailPreview() {
        const previewDiv = document.getElementById('thumbnail-preview');
        const thumbnailInput = document.getElementById('thumbnail-input');

        if (previewDiv) {
            previewDiv.classList.add('hidden');
        }

        if (thumbnailInput) {
            thumbnailInput.value = '';
        }

        if (typeof validateThumbnailAndUpdateButton === 'function') {
            validateThumbnailAndUpdateButton();
        }
    }

    // Array untuk menyimpan URL gambar dan metadata

    function showTagLimitModal() {
        const modal = document.getElementById('tag-limit-modal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    function hideTagLimitModal() {
        const modal = document.getElementById('tag-limit-modal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }


    // Sync selectedImages dengan input file sebelum submit
    function syncImagesToInput() {
        const input = document.getElementById('images-input');
        if (!input) return;

        try {
            const dataTransfer = new DataTransfer();
            selectedImages.forEach(file => {
                if (file && file instanceof File) {
                    dataTransfer.items.add(file);
                }
            });
            input.files = dataTransfer.files;
        } catch (error) {
            console.error('Error syncing images to input:', error);
        }
    }

    // Validasi saat submit form
    const formEl = document.querySelector('form');
    if (formEl) {
        formEl.addEventListener('submit', function(e) {
        // Sync Summernote content ke textarea sebelum submit
        const bodyEditor = document.querySelector('#body-editor');
        if (bodyEditor && typeof $ !== 'undefined' && $(bodyEditor).summernote('code')) {
            bodyEditor.value = $(bodyEditor).summernote('code');
        }

        // Sync selectedImages dengan input file sebelum validasi
        syncImagesToInput();

        // (Sinkronisasi URL gambar ke hidden input dihapus - sekarang hanya upload file yang digunakan)

        // Verifikasi input file ter-update
        const input = document.getElementById('images-input');
        const inputFileCount = input && input.files ? input.files.length : 0;

        // Hitung existing images dari hidden inputs yang valid
        const existingInputs = document.querySelectorAll('input[name="existing_images[]"]');
        const totalExisting = Array.from(existingInputs).filter(input => {
            return input && input.value && input.value.trim() !== '';
        }).length;

        // Pastikan selectedImages hanya berisi File objects yang valid
        const validSelectedImages = selectedImages.filter(file => file && file instanceof File);
        const totalImages = validSelectedImages.length + totalExisting;

        // Debug: pastikan input file ter-update dengan benar
        if (inputFileCount !== selectedImages.length && selectedImages.length > 0) {
            console.warn('Input file count mismatch! Selected:', selectedImages.length, 'Input:', inputFileCount);
            // Force sync lagi
            syncImagesToInput();
        }

        // Panggil validasi terlebih dahulu untuk update UI
        const isValid = validateImageCount();

        if (!isValid) {
            e.preventDefault();

            if (totalImages > 6) {
                alert(`Tidak dapat menyimpan! Maksimal 6 gambar. Saat ini: ${totalImages} gambar. Hapus ${totalImages - 6} gambar untuk melanjutkan.`);
            } else if (totalImages > 1 && totalImages % 2 !== 0) {
                alert(`Tidak dapat menyimpan! Jumlah gambar konten harus 1, 2, 4, atau 6 gambar untuk layout yang rapi.\n\nSaat ini: ${totalImages} gambar (ganjil).\n\nSilakan tambah atau hapus 1 gambar agar jumlahnya menjadi 1, 2, 4, atau 6 gambar.`);
            }
            return false;
        }

        // Pastikan sync lagi sebelum submit (untuk memastikan)
        syncImagesToInput();
    });
    }
</script>

<!-- Modal Peringatan Tag Maksimal -->
<div id="tag-limit-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 items-center justify-center">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Maksimal Tag</h3>
            <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Maksimal 10 tag. Silakan hapus tag yang ada terlebih dahulu.</p>
            <div class="flex items-center justify-end gap-3">
                <button type="button" id="tag-limit-modal-ok-btn" class="px-6 py-2 text-sm font-semibold text-white bg-green-700 rounded-lg hover:bg-green-800 transition-colors min-w-[100px]">Oke</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Konfirmasi Hapus Gambar -->
<div id="delete-image-modal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 items-center justify-center">
    <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
        <div class="p-6">
            <h3 id="delete-image-modal-title" class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Konfirmasi Hapus Gambar</h3>
            <p id="delete-image-modal-message" class="text-sm text-slate-600 dark:text-slate-400 mb-6">Apakah Anda yakin ingin menghapus gambar ini? Tindakan ini tidak dapat dibatalkan.</p>
            <div class="flex items-center justify-end gap-3">
                <button type="button" id="delete-image-modal-cancel-btn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">Batal</button>
                <button type="button" id="delete-image-modal-confirm-btn" class="px-6 py-2 text-sm font-semibold text-white bg-red-700 rounded-lg hover:bg-red-800 transition-colors min-w-[100px]">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- Image Preview Modal (Full Screen seperti Banner) -->
<div id="imagePreviewModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/30 dark:bg-black/50 backdrop-blur-md">
    <div class="relative w-full h-full flex items-center justify-center p-4" onclick="event.stopPropagation(); return false;">
        <img id="previewImage" src="" alt="Preview" class="max-w-full max-h-full object-contain pointer-events-none">
        <button type="button" class="close-modal-btn fixed top-4 right-4 w-10 h-10 bg-red-600 rounded-full flex items-center justify-center hover:bg-red-700 transition-colors z-10 shadow-lg">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>
</div>

