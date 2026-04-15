<script>
    document.addEventListener('DOMContentLoaded', () => {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

        if (!SpeechRecognition) {
            console.warn("Your browser does not support Voice Recognition.");
            return;
        }

        let activeRecognition = null;
        let activeButton = null;
        let activeInput = null;
        let activeStatus = null;

        const inputs = document.querySelectorAll(
            'input:not([type]):not([readonly]):not([type="hidden"]), input[type="text"]:not([readonly]), input[type="email"]:not([readonly]), input[type="tel"]:not([readonly]), textarea:not([readonly])'
        );

        inputs.forEach(input => {
            if (input.classList.contains('no-voice')) return;
            if (input.id === 'relation_other' || input.id === 'emergency_relation') return;
            if (input.dataset.voiceReady === 'true') return;

            const isTextarea = input.tagName.toLowerCase() === 'textarea';
            const parent = input.parentNode;
            const isInsideSearchWrap = parent && parent.classList && parent.classList.contains(
                'search-wrap');

            let wrapper = null;
            let statusLabel = null;
            let micBtn = null;

            if (isInsideSearchWrap) {
                parent.classList.add('voice-search-wrap');
                input.dataset.voiceReady = 'true';

                if (!input.classList.contains('voice-search-input')) {
                    input.classList.add('voice-search-input');
                }

                statusLabel = document.createElement('span');
                statusLabel.className =
                    'hidden absolute right-0 -top-6 text-xs font-semibold px-2 py-0.5 rounded pointer-events-none z-20';
                parent.appendChild(statusLabel);

                micBtn = document.createElement('button');
                micBtn.type = 'button';
                micBtn.setAttribute('aria-label', 'Toggle voice input');
                micBtn.className =
                    'voice-mic-btn voice-search-mic absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#8B0000] transition-colors z-10';
                micBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                parent.appendChild(micBtn);
            } else {
                wrapper = document.createElement('div');
                wrapper.className = 'voice-input-wrap';

                if (input.classList.contains('voice-full')) {
                    wrapper.classList.add('is-full');
                } else if (input.classList.contains('voice-small')) {
                    wrapper.classList.add('is-small');
                } else {
                    wrapper.classList.add('is-medium');
                }

                const computedDisplay = window.getComputedStyle(input).display;
                if (computedDisplay === 'inline' || computedDisplay === 'inline-block') {
                    wrapper.style.display = 'inline-block';
                } else {
                    wrapper.style.display = 'block';
                    wrapper.style.width = '100%';
                }

                parent.insertBefore(wrapper, input);
                wrapper.appendChild(input);

                if (input.tagName.toLowerCase() !== 'select') {
                    input.classList.add('pr-12');
                }

                input.dataset.voiceReady = 'true';

                statusLabel = document.createElement('span');
                statusLabel.className =
                    'hidden absolute right-0 -top-6 text-xs font-semibold px-2 py-0.5 rounded pointer-events-none z-20';
                wrapper.appendChild(statusLabel);

                micBtn = document.createElement('button');
                micBtn.type = 'button';
                micBtn.setAttribute('aria-label', 'Toggle voice input');
                micBtn.className = isTextarea ?
                    'voice-mic-btn absolute right-3 top-3 text-gray-400 hover:text-[#8B0000] transition-colors z-10' :
                    'voice-mic-btn absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#8B0000] transition-colors z-10';
                micBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                wrapper.appendChild(micBtn);
            }

            const recognition = new SpeechRecognition();
            recognition.lang = 'en-US';
            recognition.continuous = false;
            recognition.interimResults = false;

            function resetVisualState() {
                micBtn.classList.remove('text-[#8B0000]');
                micBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            }

            function showStatus(message, state = 'default') {
                statusLabel.textContent = message;
                statusLabel.className =
                    'absolute right-0 -top-6 text-xs font-semibold px-2 py-0.5 rounded pointer-events-none z-20 block';

                if (state === 'listening') {
                    statusLabel.classList.add('text-blue-600', 'animate-pulse');
                } else if (state === 'error') {
                    statusLabel.classList.add('text-red-600');
                } else if (state === 'success') {
                    statusLabel.classList.add('text-green-600');
                } else {
                    statusLabel.classList.add('text-gray-500');
                }
            }

            function hideStatus(delay = 0) {
                setTimeout(() => statusLabel.classList.add('hidden'), delay);
            }

            micBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();

                const isSameActive = activeRecognition === recognition;

                if (isSameActive) {
                    recognition.stop();
                    return;
                }

                if (activeRecognition) {
                    try {
                        activeRecognition.stop();
                    } catch (err) {}
                }

                activeRecognition = recognition;
                activeButton = micBtn;
                activeInput = input;
                activeStatus = statusLabel;

                try {
                    recognition.start();
                    micBtn.classList.add('text-[#8B0000]');
                    micBtn.innerHTML = '<i class="fas fa-stop"></i>';
                    showStatus('Listening...', 'listening');
                } catch (err) {
                    showStatus('Unable to start voice input.', 'error');
                    hideStatus(2500);
                    resetVisualState();
                    activeRecognition = null;
                    activeButton = null;
                    activeInput = null;
                    activeStatus = null;
                }
            });

            recognition.onresult = (event) => {
                const transcript = event.results[0][0].transcript?.trim() || '';

                if (transcript) {
                    if (isTextarea && input.value.trim()) {
                        input.value = `${input.value.trim()} ${transcript}`.trim();
                    } else {
                        input.value = transcript;
                    }

                    input.dispatchEvent(new Event('input', {
                        bubbles: true
                    }));
                    input.dispatchEvent(new Event('change', {
                        bubbles: true
                    }));

                    showStatus('Voice captured.', 'success');
                    hideStatus(1500);
                }
            };

            recognition.onerror = (event) => {
                if (event.error === 'no-speech') {
                    showStatus("Didn't catch that. Try again.", 'error');
                } else if (event.error === 'not-allowed') {
                    showStatus('Microphone permission denied.', 'error');
                } else if (event.error === 'aborted') {
                    statusLabel.classList.add('hidden');
                } else {
                    showStatus('Voice input stopped.', 'error');
                }
                hideStatus(2200);
            };

            recognition.onend = () => {
                resetVisualState();

                if (activeRecognition === recognition) {
                    activeRecognition = null;
                    activeButton = null;
                    activeInput = null;
                    activeStatus = null;
                }

                if (statusLabel.textContent === 'Listening...') {
                    statusLabel.classList.add('hidden');
                }
            };
        });
    });
</script>
