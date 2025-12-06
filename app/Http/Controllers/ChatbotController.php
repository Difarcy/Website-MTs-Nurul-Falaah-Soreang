<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Post;
use App\Models\Pengumuman;
use App\Models\Agenda;
use App\Models\InfoSekolah;

class ChatbotController extends Controller
{
    /**
     * Handle chatbot query
     */
    public function query(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500'
        ]);

        $message = $request->input('message');
        
        try {
            // Try to get response from Python backend
            $pythonBackendUrl = env('CHATBOT_PYTHON_URL', 'http://localhost:5000/api/chat');
            
            $response = Http::timeout(5)->post($pythonBackendUrl, [
                'message' => $message,
                'context' => $this->getWebsiteContext()
            ]);

            if ($response->successful()) {
                return response()->json([
                    'response' => $response->json()['response'] ?? 'Maaf, saya tidak dapat memproses pertanyaan Anda saat ini.',
                    'confidence' => $response->json()['confidence'] ?? 0
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot Python backend error: ' . $e->getMessage());
        }

        // Fallback to simple rule-based response
        return response()->json([
            'response' => $this->getFallbackResponse($message),
            'confidence' => 0.5
        ]);
    }

    /**
     * Get website context for chatbot
     */
    private function getWebsiteContext()
    {
        return [
            'recent_news' => Post::published()
                ->ofType('berita')
                ->latest('published_at')
                ->take(5)
                ->get()
                ->map(fn($post) => [
                    'title' => $post->title,
                    'excerpt' => $post->excerpt,
                    'slug' => $post->slug
                ]),
            'recent_announcements' => Pengumuman::active()
                ->latest('tanggal')
                ->take(5)
                ->get()
                ->map(fn($p) => [
                    'title' => $p->judul,
                    'content' => $p->isi,
                    'date' => $p->tanggal
                ]),
            'upcoming_events' => Agenda::active()
                ->where('tanggal_mulai', '>=', now())
                ->orderBy('tanggal_mulai')
                ->take(5)
                ->get()
                ->map(fn($a) => [
                    'title' => $a->judul,
                    'description' => $a->deskripsi,
                    'date' => $a->tanggal_mulai
                ]),
            'school_info' => InfoSekolah::ordered()->get()
                ->map(fn($info) => [
                    'key' => $info->key,
                    'label' => $info->label,
                    'value' => $info->value
                ])
        ];
    }

    /**
     * Simple fallback response using rule-based matching
     */
    private function getFallbackResponse($message)
    {
        $message = strtolower($message);
        
        // PPDB related
        if (preg_match('/ppdb|pendaftaran|daftar|registrasi/i', $message)) {
            $info = InfoSekolah::where('key', 'like', '%ppdb%')
                ->orWhere('label', 'like', '%ppdb%')
                ->orWhere('label', 'like', '%pendaftaran%')
                ->first();
            
            if ($info) {
                return "Informasi PPDB: " . $info->label . " - " . $info->value . ". Untuk informasi lebih lengkap, silakan kunjungi halaman kontak atau hubungi admin madrasah.";
            }
            return "Untuk informasi PPDB (Penerimaan Peserta Didik Baru), silakan hubungi admin madrasah melalui halaman kontak atau datang langsung ke MTs Nurul Falaah Soreang.";
        }
        
        // Alamat/Lokasi
        if (preg_match('/alamat|lokasi|dimana|dimana|address|location/i', $message)) {
            $alamat = InfoSekolah::where('key', 'alamat')->orWhere('label', 'like', '%alamat%')->first();
            if ($alamat) {
                return "Alamat MTs Nurul Falaah Soreang: " . $alamat->value;
            }
            return "MTs Nurul Falaah Soreang berlokasi di Soreang. Untuk informasi alamat lengkap, silakan kunjungi halaman kontak.";
        }
        
        // Kontak/Telepon
        if (preg_match('/kontak|telepon|telp|hp|whatsapp|wa|no\s*\.?\s*telepon/i', $message)) {
            $kontak = InfoSekolah::where('key', 'telepon')->orWhere('label', 'like', '%telepon%')->first();
            if ($kontak) {
                return "Kontak MTs Nurul Falaah Soreang: " . $kontak->value . ". Anda juga dapat mengunjungi halaman kontak untuk informasi lebih lengkap.";
            }
            return "Untuk informasi kontak, silakan kunjungi halaman kontak di website ini.";
        }
        
        // Berita/Artikel
        if (preg_match('/berita|artikel|informasi\s*terbaru|kabar/i', $message)) {
            $latestNews = Post::published()->latest('published_at')->take(3)->get();
            if ($latestNews->count() > 0) {
                $response = "Berikut beberapa berita terbaru:\n";
                foreach ($latestNews as $news) {
                    $response .= "• " . $news->title . "\n";
                }
                $response .= "\nUntuk membaca berita lengkap, silakan kunjungi halaman berita di website.";
                return $response;
            }
            return "Silakan kunjungi halaman berita untuk melihat informasi terbaru dari MTs Nurul Falaah Soreang.";
        }
        
        // Pengumuman
        if (preg_match('/pengumuman|announcement/i', $message)) {
            $pengumuman = Pengumuman::active()->latest('tanggal')->take(3)->get();
            if ($pengumuman->count() > 0) {
                $response = "Berikut beberapa pengumuman terbaru:\n";
                foreach ($pengumuman as $p) {
                    $response .= "• " . $p->judul . "\n";
                }
                return $response;
            }
            return "Silakan kunjungi halaman pengumuman untuk melihat pengumuman terbaru.";
        }
        
        // Default response
        return "Terima kasih atas pertanyaan Anda. Saya dapat membantu menjawab pertanyaan tentang:\n• Informasi PPDB\n• Alamat dan lokasi\n• Kontak madrasah\n• Berita dan artikel terbaru\n• Pengumuman\n\nSilakan tanyakan dengan lebih spesifik, atau kunjungi halaman yang relevan di website untuk informasi lebih lengkap.";
    }
}
