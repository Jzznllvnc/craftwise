<!-- Modern AI Chat Interface -->
<div id="chat-messages" class="flex-grow overflow-y-auto p-6 space-y-4 bg-gradient-to-b from-gray-50 to-white">
    <!-- Initial Greeting -->
    <div id="initial-ai-greeting" class="flex flex-col items-center justify-center p-8 text-center animate-fade-in">
        <div class="relative mb-6 w-40 h-40 flex items-center justify-center">
            <div class="absolute inset-0 bg-gradient-to-r from-orange-400 to-orange-500 rounded-full blur-xl opacity-50 animate-pulse"></div>
            <img src="<?php echo BASE_URL; ?>/assets/images/CraftWiseAI.png" alt="Kraft-E AI Assistant" class="relative w-full h-full object-contain">
        </div>
        
        <div class="bg-gradient-to-br from-orange-500 to-orange-600 text-white p-6 rounded-2xl shadow-lg max-w-md transform hover:scale-105 transition-transform">
            <div class="flex items-center gap-2 mb-3">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="font-bold text-sm">Kraft-E AI Assistant</span>
            </div>
            <p class="text-lg font-semibold leading-relaxed">
                Hello! I'm Kraft-E, your PC Build Assistant. 👋
            </p>
            <p class="text-white/90 mt-2">
                Ask me anything about PC components, compatibility, or build advice!
            </p>
        </div>
        
        <!-- Suggested Questions -->
        <div class="mt-8 w-full max-w-md space-y-2">
            <p class="text-sm font-semibold text-gray-600 mb-3">Try asking:</p>
            <button onclick="document.getElementById('user-input').value='What CPU should I pair with an RTX 4080?'; document.getElementById('user-input').focus();" 
                    class="w-full text-left px-4 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-orange-400 hover:bg-orange-50 transition-all text-sm text-gray-700 hover:text-gray-900">
                💻 What CPU should I pair with an RTX 4080?
            </button>
            <button onclick="document.getElementById('user-input').value='What is the difference between DDR4 and DDR5?'; document.getElementById('user-input').focus();" 
                    class="w-full text-left px-4 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-orange-400 hover:bg-orange-50 transition-all text-sm text-gray-700 hover:text-gray-900">
                🎯 What's the difference between DDR4 and DDR5?
            </button>
            <button onclick="document.getElementById('user-input').value='How much RAM do I need for gaming?'; document.getElementById('user-input').focus();" 
                    class="w-full text-left px-4 py-3 bg-white border-2 border-gray-200 rounded-xl hover:border-orange-400 hover:bg-orange-50 transition-all text-sm text-gray-700 hover:text-gray-900">
                🎮 How much RAM do I need for gaming?
            </button>
        </div>
    </div>
</div>

<!-- Modern Input Form -->
<div class="flex-shrink-0 p-4 bg-white border-t-2 border-gray-100">
    <form id="chat-input-form" class="flex items-center gap-3">
        <div class="flex-grow relative">
            <textarea id="user-input" 
                   placeholder="Ask me anything about PC building..."
                   rows="1"
                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:outline-none focus:border-orange-500 transition-colors resize-none text-gray-800 placeholder-gray-400"
                   style="max-height: 120px; min-height: 48px; line-height: 24px;"></textarea>
        </div>
        <button type="submit" id="send-button"
                class="flex-shrink-0 w-12 h-12 bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 text-white mb-2 rounded-xl shadow-lg transition-all transform hover:scale-105 flex items-center justify-center">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
            </svg>
        </button>
    </form>
    
    <p class="text-xs text-gray-500 text-center mt-2">
        Kraft-E is powered by AI and may occasionally make mistakes.
    </p>
</div>

<style>
/* Message Bubbles Styling */
.user-message {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
    padding: 12px 16px;
    border-radius: 18px 18px 4px 18px;
    max-width: 80%;
    margin-left: auto;
    box-shadow: 0 2px 8px rgba(249, 115, 22, 0.3);
    animation: slideInRight 0.3s ease-out;
}

.ai-message {
    background: white;
    border: 2px solid #f3f4f6;
    color: #1f2937;
    padding: 12px 16px;
    border-radius: 18px 18px 18px 4px;
    max-width: 85%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    animation: slideInLeft 0.3s ease-out;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.ai-message .markdown-content {
    color: #1f2937;
}

.ai-message .markdown-content strong {
    color: #f97316;
    font-weight: 700;
}

.ai-message .markdown-content code {
    background: #f3f4f6;
    color: #f97316;
    padding: 2px 6px;
    border-radius: 4px;
    font-size: 0.9em;
}

.ai-message .markdown-content pre {
    background: #1f2937;
    color: #f3f4f6;
    padding: 12px;
    border-radius: 8px;
    overflow-x: auto;
    margin: 8px 0;
    max-width: 100%;
}

.ai-message .markdown-content table {
    display: block;
    max-width: 100%;
    overflow-x: auto;
    border-collapse: collapse;
}

.ai-message .markdown-content td,
.ai-message .markdown-content th {
    word-wrap: break-word;
    overflow-wrap: break-word;
    max-width: 200px;
}

.ai-message .markdown-content ul {
    padding-left: 20px;
    margin: 8px 0;
}

.ai-message .markdown-content li {
    margin: 4px 0;
}

/* Message Container */
.message-container {
    display: flex;
    align-items: flex-end;
    gap: 8px;
    animation: fadeIn 0.3s ease-out;
}

.message-container.user {
    flex-direction: row-reverse;
}

/* Avatar Styling */
.message-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-weight: bold;
    font-size: 14px;
}

.user-avatar {
    background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
    color: white;
}

.ai-avatar {
    background: linear-gradient(135deg, #fb923c 0%, #f97316 100%);
    color: white;
}

/* Animations */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes slideInRight {
    from { opacity: 0; transform: translateX(20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes slideInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}

@keyframes animate-fade-in {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
}

.animate-fade-in {
    animation: animate-fade-in 0.5s ease-out;
}

/* Typing Indicator */
.typing-indicator {
    display: flex;
    align-items: center;
    gap: 4px;
    padding: 12px 16px;
    background: white;
    border: 2px solid #f3f4f6;
    border-radius: 18px 18px 18px 4px;
    width: fit-content;
}

.typing-indicator span {
    width: 8px;
    height: 8px;
    background: #9ca3af;
    border-radius: 50%;
    animation: typing 1.4s infinite;
}

.typing-indicator span:nth-child(2) {
    animation-delay: 0.2s;
}

.typing-indicator span:nth-child(3) {
    animation-delay: 0.4s;
}

@keyframes typing {
    0%, 60%, 100% {
        transform: translateY(0);
        opacity: 0.5;
    }
    30% {
        transform: translateY(-10px);
        opacity: 1;
    }
}

/* Scrollbar Styling */
#chat-messages::-webkit-scrollbar {
    width: 6px;
}

#chat-messages::-webkit-scrollbar-track {
    background: #f3f4f6;
    border-radius: 10px;
}

#chat-messages::-webkit-scrollbar-thumb {
    background: linear-gradient(to bottom, #f97316, #ea580c);
    border-radius: 10px;
}

#chat-messages::-webkit-scrollbar-thumb:hover {
    background: linear-gradient(to bottom, #ea580c, #f97316);
}

/* Auto-resize textarea */
#user-input {
    min-height: 48px;
    max-height: 120px;
    overflow-y: auto;
}
</style>

<script>
// Auto-resize textarea
const textarea = document.getElementById('user-input');
if (textarea) {
    textarea.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = Math.min(this.scrollHeight, 120) + 'px';
    });
    
    // Handle Enter key (submit) and Shift+Enter (new line)
    textarea.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            document.getElementById('chat-input-form').dispatchEvent(new Event('submit'));
        }
    });
}

// Hide suggested questions when first message is sent
document.getElementById('chat-input-form')?.addEventListener('submit', function() {
    const greeting = document.getElementById('initial-ai-greeting');
    if (greeting && greeting.querySelector('.space-y-2')) {
        setTimeout(() => {
            greeting.style.display = 'none';
        }, 100);
    }
});
</script>
