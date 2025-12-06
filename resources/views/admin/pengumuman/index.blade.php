@extends('layouts.admin')

@section('title', 'Pengumuman')

@section('content')
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Pengumuman</h1>
                <p class="text-sm text-slate-500 mt-1">Kelola pengumuman yang ditampilkan di website</p>
            </div>
            @if($pengumuman->count() > 0)
                <a href="{{ route('admin.pengumuman.create') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 text-base font-bold text-white bg-green-700 rounded-lg hover:bg-green-800 shadow-lg">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pengumuman Baru
                </a>
            @endif
        </div>

        @if($pengumuman->count() > 0)
            <div class="space-y-3">
                @foreach($pengumuman as $item)
                    <div class="bg-white border-2 border-gray-200 rounded-xl p-5 hover:border-green-500 hover:shadow-lg transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h3 class="font-bold text-slate-900 text-lg mb-2">{{ $item->judul }}</h3>
                                <p class="text-sm text-slate-600 line-clamp-2 mb-3">{{ strip_tags($item->isi) }}</p>
                                <div class="flex items-center gap-4 text-xs text-slate-500">
                                    <span>{{ $item->tanggal ? $item->tanggal->format('d M Y') : '-' }}</span>
                                    <span>Urutan: {{ $item->urutan }}</span>
                                    @if(!$item->is_active)
                                        <span class="text-red-600 font-semibold">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.pengumuman.edit', $item) }}" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700">
                                    Edit
                                </a>
                                <button type="button" onclick="showDeleteModal('{{ route('admin.pengumuman.destroy', $item) }}', '{{ addslashes($item->judul) }}')" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg hover:bg-red-700">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $pengumuman->links() }}
            </div>
        @else
            <div class="bg-white border-2 border-dashed border-gray-300 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                </svg>
                <h3 class="text-lg font-semibold text-slate-700 mb-2">Belum Ada Pengumuman</h3>
                <p class="text-sm text-slate-500 mb-6 text-center">Mulai dengan menambahkan pengumuman pertama</p>
                <a href="{{ route('admin.pengumuman.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-green-700 text-white font-bold rounded-lg hover:bg-green-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Pengumuman Pertama
                </a>
            </div>
        @endif
    </div>

    <!-- Modal Konfirmasi Hapus Pengumuman -->
    <div id="deletePengumumanModal" class="hidden fixed inset-0 bg-black/30 dark:bg-black/50 z-50 flex items-center justify-center">
        <div class="bg-white dark:bg-slate-800 rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-slate-900 dark:text-slate-100 mb-2">Konfirmasi Hapus Pengumuman</h3>
                <p class="text-sm text-slate-600 dark:text-slate-400 mb-6">Yakin ingin menghapus pengumuman "<strong id="delete-pengumuman-title"></strong>"? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex items-center justify-end gap-3">
                    <button type="button" id="deletePengumumanCancelBtn" class="px-6 py-2 text-sm font-semibold text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-600 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors min-w-[100px]">
                        Batal
                    </button>
                    <form id="deletePengumumanForm" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="px-6 py-2 text-sm font-semibold text-white bg-red-700 rounded-lg hover:bg-red-800 transition-colors min-w-[100px]">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal Hapus Pengumuman
        function showDeleteModal(actionUrl, judul) {
            const modal = document.getElementById('deletePengumumanModal');
            const form = document.getElementById('deletePengumumanForm');
            const titleElement = document.getElementById('delete-pengumuman-title');
            
            form.action = actionUrl;
            if (titleElement) {
                titleElement.textContent = judul;
            }
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function hideDeleteModal() {
            const modal = document.getElementById('deletePengumumanModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.style.overflow = '';
        }

        // Setup event listeners untuk modal
        document.addEventListener('DOMContentLoaded', function() {
            const deleteModal = document.getElementById('deletePengumumanModal');
            const cancelBtn = document.getElementById('deletePengumumanCancelBtn');
            
            if (cancelBtn) {
                cancelBtn.addEventListener('click', hideDeleteModal);
            }
            
            if (deleteModal) {
                deleteModal.addEventListener('click', function(e) {
                    if (e.target === deleteModal) {
                        hideDeleteModal();
                    }
                });
            }
        });
    </script>
@endsection

