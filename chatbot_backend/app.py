"""
Chatbot Backend untuk MTs Nurul Falaah Soreang
Menggunakan Flask dan NLP sederhana dengan pattern matching dan intent recognition
"""

from flask import Flask, request, jsonify
from flask_cors import CORS
import re
import json
from datetime import datetime
from typing import Dict, List, Tuple

app = Flask(__name__)
CORS(app)  # Enable CORS untuk komunikasi dengan Laravel

# Knowledge Base - Data statis tentang madrasah
KNOWLEDGE_BASE = {
    'ppdb': {
        'keywords': ['ppdb', 'pendaftaran', 'daftar', 'registrasi', 'penerimaan', 'siswa baru'],
        'responses': [
            "PPDB (Penerimaan Peserta Didik Baru) MTs Nurul Falaah Soreang biasanya dibuka pada awal tahun ajaran baru. Untuk informasi lengkap tentang syarat, jadwal, dan biaya pendaftaran, silakan hubungi admin madrasah atau kunjungi halaman kontak di website.",
            "Informasi PPDB dapat Anda dapatkan dengan menghubungi admin madrasah melalui kontak yang tersedia di website atau datang langsung ke MTs Nurul Falaah Soreang."
        ]
    },
    'alamat': {
        'keywords': ['alamat', 'lokasi', 'dimana', 'address', 'location', 'tempat'],
        'responses': [
            "MTs Nurul Falaah Soreang berlokasi di Soreang. Untuk alamat lengkap, silakan kunjungi halaman kontak di website atau hubungi admin madrasah.",
            "Lokasi MTs Nurul Falaah Soreang berada di Soreang. Informasi alamat lengkap dapat dilihat di halaman kontak website."
        ]
    },
    'kontak': {
        'keywords': ['kontak', 'telepon', 'telp', 'hp', 'whatsapp', 'wa', 'no telepon', 'nomor'],
        'responses': [
            "Untuk informasi kontak MTs Nurul Falaah Soreang, silakan kunjungi halaman kontak di website. Di sana Anda akan menemukan nomor telepon, email, dan media sosial madrasah.",
            "Kontak madrasah dapat dilihat di halaman kontak website. Anda juga dapat menghubungi admin melalui media sosial yang tertera."
        ]
    },
    'berita': {
        'keywords': ['berita', 'artikel', 'informasi terbaru', 'kabar', 'update'],
        'responses': [
            "Berita dan artikel terbaru dari MTs Nurul Falaah Soreang dapat dilihat di halaman berita dan artikel di website. Silakan kunjungi untuk informasi terkini.",
            "Untuk melihat berita dan artikel terbaru, silakan kunjungi halaman berita di website."
        ]
    },
    'pengumuman': {
        'keywords': ['pengumuman', 'announcement', 'info penting'],
        'responses': [
            "Pengumuman terbaru dapat dilihat di halaman pengumuman di website. Silakan kunjungi untuk informasi penting terbaru.",
            "Untuk melihat pengumuman, silakan kunjungi halaman pengumuman di website."
        ]
    },
    'agenda': {
        'keywords': ['agenda', 'kegiatan', 'event', 'acara', 'jadwal'],
        'responses': [
            "Agenda dan kegiatan terbaru dapat dilihat di halaman agenda di website. Silakan kunjungi untuk melihat jadwal kegiatan madrasah.",
            "Untuk melihat agenda dan kegiatan, silakan kunjungi halaman agenda di website."
        ]
    },
    'prestasi': {
        'keywords': ['prestasi', 'juara', 'penghargaan', 'achievement'],
        'responses': [
            "Informasi tentang prestasi siswa dan madrasah dapat dilihat di halaman prestasi dan galeri prestasi siswa di website.",
            "Untuk melihat prestasi madrasah, silakan kunjungi halaman prestasi di website."
        ]
    },
    'profil': {
        'keywords': ['profil', 'sejarah', 'tentang', 'visi misi', 'tujuan'],
        'responses': [
            "Profil lengkap MTs Nurul Falaah Soreang, termasuk sejarah, visi misi, dan struktur organisasi dapat dilihat di halaman profil di website.",
            "Untuk informasi profil madrasah, silakan kunjungi halaman profil di website."
        ]
    }
}

# Greeting patterns
GREETINGS = {
    'patterns': [
        r'\b(halo|hai|hi|hello|selamat\s+(pagi|siang|sore|malam))\b',
        r'\b(assalamu\'?alaikum|assalamualaikum)\b',
        r'\b(apa\s+kabar|kabar)\b'
    ],
    'responses': [
        "Halo! Selamat datang di MTs Nurul Falaah Soreang. Saya asisten virtual yang siap membantu menjawab pertanyaan Anda tentang madrasah. Ada yang bisa saya bantu?",
        "Assalamu'alaikum! Saya asisten virtual MTs Nurul Falaah Soreang. Silakan tanyakan apa yang ingin Anda ketahui tentang madrasah.",
        "Hai! Saya di sini untuk membantu. Silakan tanyakan tentang PPDB, alamat, kontak, berita, atau informasi lainnya tentang MTs Nurul Falaah Soreang."
    ]
}

# Thank you patterns
THANKS = {
    'patterns': [
        r'\b(terima\s+kasih|makasih|thanks|thank\s+you)\b',
        r'\b(sudah\s+jelas|oke|baik|sip)\b'
    ],
    'responses': [
        "Sama-sama! Jika ada pertanyaan lain, jangan ragu untuk bertanya. Semoga informasi yang saya berikan bermanfaat!",
        "Terima kasih! Jika masih ada yang ingin ditanyakan tentang MTs Nurul Falaah Soreang, silakan tanyakan saja."
    ]
}

def preprocess_text(text: str) -> str:
    """Preprocessing teks: lowercase, hapus karakter khusus"""
    text = text.lower()
    text = re.sub(r'[^\w\s]', ' ', text)  # Hapus tanda baca
    text = re.sub(r'\s+', ' ', text).strip()  # Normalisasi spasi
    return text

def calculate_similarity(text1: str, text2: str) -> float:
    """Menghitung similarity sederhana menggunakan Jaccard similarity"""
    words1 = set(text1.split())
    words2 = set(text2.split())
    
    if not words1 or not words2:
        return 0.0
    
    intersection = len(words1.intersection(words2))
    union = len(words1.union(words2))
    
    return intersection / union if union > 0 else 0.0

def find_intent(message: str) -> Tuple[str, float]:
    """
    Intent Recognition menggunakan pattern matching dan keyword matching
    Mengembalikan intent dan confidence score
    """
    processed_message = preprocess_text(message)
    
    # Cek greeting
    for pattern in GREETINGS['patterns']:
        if re.search(pattern, processed_message, re.IGNORECASE):
            return 'greeting', 0.9
    
    # Cek thank you
    for pattern in THANKS['patterns']:
        if re.search(pattern, processed_message, re.IGNORECASE):
            return 'thanks', 0.9
    
    # Cek knowledge base
    best_intent = None
    best_score = 0.0
    
    for intent, data in KNOWLEDGE_BASE.items():
        # Hitung similarity dengan keywords
        keyword_scores = []
        for keyword in data['keywords']:
            similarity = calculate_similarity(processed_message, keyword)
            keyword_scores.append(similarity)
        
        # Ambil score tertinggi
        max_score = max(keyword_scores) if keyword_scores else 0.0
        
        # Bonus jika keyword ditemukan langsung
        for keyword in data['keywords']:
            if keyword in processed_message:
                max_score = min(1.0, max_score + 0.3)
        
        if max_score > best_score:
            best_score = max_score
            best_intent = intent
    
    # Threshold minimum untuk intent recognition
    if best_score >= 0.3:
        return best_intent, best_score
    
    return 'unknown', 0.0

def generate_response(intent: str, message: str, context: dict = None) -> str:
    """
    Response Generation menggunakan template-based dan context-aware
    """
    processed_message = preprocess_text(message)
    
    # Handle greeting
    if intent == 'greeting':
        import random
        return random.choice(GREETINGS['responses'])
    
    # Handle thanks
    if intent == 'thanks':
        import random
        return random.choice(THANKS['responses'])
    
    # Handle known intents
    if intent in KNOWLEDGE_BASE:
        import random
        base_response = random.choice(KNOWLEDGE_BASE[intent]['responses'])
        
        # Enhance dengan context jika ada
        if context:
            if intent == 'berita' and 'recent_news' in context:
                news = context['recent_news']
                if news:
                    base_response += "\n\nBerita terbaru:\n"
                    for item in news[:3]:
                        base_response += f"• {item.get('title', '')}\n"
            
            if intent == 'pengumuman' and 'recent_announcements' in context:
                announcements = context['recent_announcements']
                if announcements:
                    base_response += "\n\nPengumuman terbaru:\n"
                    for item in announcements[:3]:
                        base_response += f"• {item.get('title', '')}\n"
        
        return base_response
    
    # Handle unknown intent
    return "Maaf, saya belum memahami pertanyaan Anda dengan baik. Saya dapat membantu menjawab pertanyaan tentang:\n• PPDB dan pendaftaran\n• Alamat dan lokasi madrasah\n• Kontak madrasah\n• Berita dan artikel terbaru\n• Pengumuman\n• Agenda dan kegiatan\n• Prestasi madrasah\n• Profil madrasah\n\nSilakan tanyakan dengan lebih spesifik."

@app.route('/api/chat', methods=['POST'])
def chat():
    """
    Endpoint utama untuk chatbot
    Menerima message dan context, mengembalikan response
    """
    try:
        data = request.get_json()
        message = data.get('message', '').strip()
        context = data.get('context', {})
        
        if not message:
            return jsonify({
                'response': 'Silakan masukkan pertanyaan Anda.',
                'confidence': 0.0
            }), 400
        
        # Intent Recognition
        intent, confidence = find_intent(message)
        
        # Response Generation
        response = generate_response(intent, message, context)
        
        return jsonify({
            'response': response,
            'intent': intent,
            'confidence': round(confidence, 2)
        }), 200
        
    except Exception as e:
        return jsonify({
            'response': 'Maaf, terjadi kesalahan saat memproses pertanyaan Anda. Silakan coba lagi.',
            'confidence': 0.0,
            'error': str(e)
        }), 500

@app.route('/api/health', methods=['GET'])
def health():
    """Health check endpoint"""
    return jsonify({
        'status': 'healthy',
        'service': 'Chatbot MTs Nurul Falaah Soreang',
        'timestamp': datetime.now().isoformat()
    }), 200

if __name__ == '__main__':
    # Run on port 5000
    app.run(host='0.0.0.0', port=5000, debug=True)

