<!-- Chatbot Widget - Hanya muncul di homepage -->
@if(request()->routeIs('home'))
<div id="chatbot-widget" class="fixed bottom-6 right-6 z-50">
    <!-- Text Label (muncul saat hover) -->
    <div id="chatbot-label" class="absolute right-20 top-1/2 -translate-y-1/2 bg-gray-900 dark:bg-gray-700 text-white text-sm font-medium px-4 py-2.5 rounded-lg shadow-lg whitespace-nowrap opacity-0 pointer-events-none transition-all duration-300 transform -translate-x-4">
        Tanya Informasi dengan Asisten Virtual
        <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1 w-2 h-2 bg-gray-900 dark:bg-gray-700 rotate-45"></div>
    </div>

    <!-- Chatbot Button -->
    <button id="chatbot-toggle" class="w-16 h-16 bg-green-700 hover:bg-green-800 text-white rounded-full shadow-lg flex items-center justify-center transition-all duration-300 hover:scale-110 relative" onmouseenter="showChatbotLabel()" onmouseleave="hideChatbotLabel()">
        <svg id="chatbot-icon" class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
        </svg>
        <svg id="chatbot-close-icon" class="w-10 h-10 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>

    <!-- Chatbot Window -->
    <div id="chatbot-window" class="hidden absolute bottom-20 right-0 w-96 h-96 bg-white dark:bg-slate-800 rounded-lg shadow-2xl flex flex-col border border-gray-200 dark:border-slate-700">
        <!-- Header -->
        <div class="bg-green-700 text-white p-4 rounded-t-lg flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
                <h3 class="font-semibold">Asisten Virtual</h3>
            </div>
            <button id="chatbot-minimize" class="text-white hover:text-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                </svg>
            </button>
        </div>

        <!-- Messages Container -->
        <div id="chatbot-messages" class="flex-1 overflow-y-auto p-4 space-y-3 chatbot-messages-container">
            <!-- Welcome Message -->
            <div class="flex items-start gap-2">
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-700 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="bg-gray-100 dark:bg-slate-700 rounded-lg p-3">
                        <p class="text-sm text-gray-800 dark:text-slate-200">
                            Halo! Saya asisten virtual MTs Nurul Falaah Soreang. Saya siap membantu menjawab pertanyaan Anda tentang informasi madrasah, PPDB, kegiatan, dan lainnya. Silakan tanyakan apa yang ingin Anda ketahui!
                        </p>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-slate-400 mt-1">Sekarang</p>
                </div>
            </div>
        </div>

        <!-- Typing Indicator -->
        <div id="chatbot-typing" class="hidden px-4 pb-2">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-green-700 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <div class="flex gap-1">
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                    <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                </div>
            </div>
        </div>

        <!-- Input Area -->
        <div class="border-t border-gray-200 dark:border-slate-700 p-4">
            <form id="chatbot-form" class="flex gap-2">
                <input
                    type="text"
                    id="chatbot-input"
                    placeholder="Ketik pertanyaan Anda..."
                    class="flex-1 bg-gray-50 dark:bg-slate-700 border border-gray-300 dark:border-slate-600 rounded-lg px-4 py-2 text-sm text-gray-900 dark:text-slate-100 focus:ring-2 focus:ring-green-600 focus:border-green-600 outline-none"
                    autocomplete="off"
                >
                <button
                    type="submit"
                    id="chatbot-send"
                    class="bg-green-700 hover:bg-green-800 text-white rounded-lg px-4 py-2 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const chatbotToggle = document.getElementById('chatbot-toggle');
    const chatbotWindow = document.getElementById('chatbot-window');
    const chatbotIcon = document.getElementById('chatbot-icon');
    const chatbotCloseIcon = document.getElementById('chatbot-close-icon');
    const chatbotMinimize = document.getElementById('chatbot-minimize');
    const chatbotForm = document.getElementById('chatbot-form');
    const chatbotInput = document.getElementById('chatbot-input');
    const chatbotMessages = document.getElementById('chatbot-messages');
    const chatbotTyping = document.getElementById('chatbot-typing');
    const chatbotSend = document.getElementById('chatbot-send');

    let isOpen = false;

    // Toggle chatbot window
    chatbotToggle.addEventListener('click', function() {
        isOpen = !isOpen;
        if (isOpen) {
            chatbotWindow.classList.remove('hidden');
            chatbotIcon.classList.add('hidden');
            chatbotCloseIcon.classList.remove('hidden');
        } else {
            chatbotWindow.classList.add('hidden');
            chatbotIcon.classList.remove('hidden');
            chatbotCloseIcon.classList.add('hidden');
        }
    });

    // Minimize chatbot
    chatbotMinimize.addEventListener('click', function() {
        isOpen = false;
        chatbotWindow.classList.add('hidden');
        chatbotIcon.classList.remove('hidden');
        chatbotCloseIcon.classList.add('hidden');
    });

    // Store active chatbot controller
    let activeChatbotController = null;

    // Send message
    chatbotForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        const message = chatbotInput.value.trim();
        if (!message) return;

        // Cancel previous request if still active
        if (activeChatbotController) {
            try {
                activeChatbotController.abort();
            } catch (e) {
                // Ignore errors
            }
        }

        // Add user message
        addMessage(message, 'user');
        chatbotInput.value = '';
        chatbotSend.disabled = true;

        // Show typing indicator
        chatbotTyping.classList.remove('hidden');
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;

        // Create AbortController untuk cancel request jika perlu
        const controller = new AbortController();
        activeChatbotController = controller;
        const timeoutId = setTimeout(() => {
            controller.abort();
            activeChatbotController = null;
        }, 30000); // Timeout 30 detik

        try {
            // Send to backend
            const response = await fetch('{{ route("chatbot.query") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message }),
                signal: controller.signal
            });

            clearTimeout(timeoutId);
            activeChatbotController = null;

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();

            // Hide typing indicator
            chatbotTyping.classList.add('hidden');

            // Add bot response
            addMessage(data.response || 'Maaf, terjadi kesalahan. Silakan coba lagi.', 'bot');
        } catch (error) {
            clearTimeout(timeoutId);
            activeChatbotController = null;
            chatbotTyping.classList.add('hidden');

            // Ignore abort errors dan network errors (biasanya dari extension)
            if (error.name !== 'AbortError' && error.name !== 'TypeError') {
                console.error('Chatbot error:', error);
            }

            addMessage('Maaf, terjadi kesalahan saat menghubungi server. Silakan coba lagi nanti.', 'bot');
        } finally {
            chatbotSend.disabled = false;
            if (chatbotInput) chatbotInput.focus();
        }
    });

    // Cleanup saat halaman tidak aktif
    document.addEventListener('visibilitychange', function() {
        if (document.hidden && activeChatbotController) {
            try {
                activeChatbotController.abort();
                activeChatbotController = null;
            } catch (e) {
                // Ignore errors
            }
        }
    });

    window.addEventListener('pagehide', function() {
        if (activeChatbotController) {
            try {
                activeChatbotController.abort();
                activeChatbotController = null;
            } catch (e) {
                // Ignore errors
            }
        }
    });

    function addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `flex items-start gap-2 ${sender === 'user' ? 'flex-row-reverse' : ''}`;

        const avatar = document.createElement('div');
        avatar.className = `w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0 ${
            sender === 'user'
                ? 'bg-green-700'
                : 'bg-green-100 dark:bg-green-900'
        }`;

        if (sender === 'user') {
            avatar.innerHTML = `
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            `;
        } else {
            avatar.innerHTML = `
                <svg class="w-5 h-5 text-green-700 dark:text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                </svg>
            `;
        }

        const content = document.createElement('div');
        content.className = 'flex-1';

        const bubble = document.createElement('div');
        bubble.className = `rounded-lg p-3 ${
            sender === 'user'
                ? 'bg-green-700 text-white'
                : 'bg-gray-100 dark:bg-slate-700 text-gray-800 dark:text-slate-200'
        }`;
        bubble.innerHTML = `<p class="text-sm whitespace-pre-wrap">${escapeHtml(text)}</p>`;

        const time = document.createElement('p');
        time.className = `text-xs mt-1 ${sender === 'user' ? 'text-right' : ''} text-gray-500 dark:text-slate-400`;
        time.textContent = 'Sekarang';

        content.appendChild(bubble);
        content.appendChild(time);
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(content);

        chatbotMessages.appendChild(messageDiv);
        chatbotMessages.scrollTop = chatbotMessages.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Label functions
    window.showChatbotLabel = function() {
        const label = document.getElementById('chatbot-label');
        if (label && !isOpen) {
            label.classList.remove('opacity-0', '-translate-x-4', 'pointer-events-none');
            label.classList.add('opacity-100', 'translate-x-0');
        }
    };

    window.hideChatbotLabel = function() {
        const label = document.getElementById('chatbot-label');
        if (label) {
            label.classList.add('opacity-0', '-translate-x-4', 'pointer-events-none');
            label.classList.remove('opacity-100', 'translate-x-0');
        }
    };

    // Hide label when chatbot is opened
    chatbotToggle.addEventListener('click', function() {
        hideChatbotLabel();
    });

    // Keep chatbot visible on scroll
    window.addEventListener('scroll', function() {
        // Chatbot widget tetap mengikuti scroll
    });
});
</script>
@endif
