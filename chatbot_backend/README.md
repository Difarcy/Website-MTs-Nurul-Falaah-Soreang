# Chatbot Backend - MTs Nurul Falaah Soreang

## Instalasi

1. Install Python 3.8 atau lebih baru
2. Install dependencies:

```bash
pip install -r requirements.txt
```

## Menjalankan

```bash
python app.py
```

Server akan berjalan di `http://localhost:5000`

## Environment Variables

Tambahkan di `.env` Laravel:

```
CHATBOT_PYTHON_URL=http://localhost:5000/api/chat
```

## API Endpoints

### POST /api/chat

Menerima query chatbot dan mengembalikan response.

Request:

```json
{
  "message": "Informasi tentang PPDB",
  "context": {
    "recent_news": [...],
    "recent_announcements": [...]
  }
}
```

Response:

```json
{
    "response": "Informasi PPDB...",
    "intent": "ppdb",
    "confidence": 0.85
}
```

### GET /api/health

Health check endpoint.
