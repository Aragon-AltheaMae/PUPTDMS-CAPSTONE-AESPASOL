<script>
document.addEventListener('DOMContentLoaded', () => {
    const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;

    if (!SpeechRecognition) {
        console.warn('Your browser does not support Voice Recognition.');
        return;
    }

    let activeController = null;

    const selector = [
        'input:not([type]):not([readonly]):not([type="hidden"])',
        'input[type="text"]:not([readonly])',
        'input[type="email"]:not([readonly])',
        'input[type="tel"]:not([readonly])',
        'textarea:not([readonly])'
    ].join(', ');

    const inputs = document.querySelectorAll(selector);

    inputs.forEach((input) => {
        if (input.classList.contains('no-voice')) return;
        if (input.id === 'relation_other' || input.id === 'emergency_relation') return;
        if (input.dataset.voiceReady === 'true') return;

        const isTextarea = input.tagName.toLowerCase() === 'textarea';
        const parent = input.parentNode;
        const isInsideSearchWrap = parent && parent.classList && parent.classList.contains('search-wrap');

        let wrapper = input.closest('[data-voice-field]');
        let micBtn = wrapper?.querySelector('[data-voice-trigger]') || null;
        let statusLabel = wrapper?.querySelector('[data-voice-status]') || null;

        if (isInsideSearchWrap) {
            parent.classList.add('voice-search-wrap');
            if (!input.classList.contains('voice-search-input')) {
                input.classList.add('voice-search-input');
            }

            if (!statusLabel) {
                statusLabel = document.createElement('span');
                statusLabel.className = 'voice-status hidden';
                statusLabel.setAttribute('data-voice-status', '');
                parent.appendChild(statusLabel);
            }

            if (!micBtn) {
                micBtn = document.createElement('button');
                micBtn.type = 'button';
                micBtn.setAttribute('aria-label', 'Toggle voice input');
                micBtn.setAttribute('data-voice-trigger', '');
                micBtn.className = 'voice-mic-btn voice-search-mic';
                micBtn.innerHTML = '<i class="fas fa-microphone"></i>';
                parent.appendChild(micBtn);
            }
        } else if (!wrapper) {
            wrapper = document.createElement('div');
            wrapper.className = 'voice-input-wrap';
            wrapper.setAttribute('data-voice-field', '');

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
                wrapper.style.maxWidth = '100%';
            }

            parent.insertBefore(wrapper, input);
            wrapper.appendChild(input);

            micBtn = document.createElement('button');
            micBtn.type = 'button';
            micBtn.setAttribute('aria-label', 'Toggle voice input');
            micBtn.setAttribute('data-voice-trigger', '');
            micBtn.className = 'voice-mic-btn';
            micBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            wrapper.appendChild(micBtn);

            statusLabel = document.createElement('span');
            statusLabel.className = 'voice-status hidden';
            statusLabel.setAttribute('data-voice-status', '');
            wrapper.appendChild(statusLabel);
        }

        input.style.width = '100%';
        input.style.maxWidth = '100%';
        input.style.boxSizing = 'border-box';

        if (input.tagName.toLowerCase() !== 'select') {
            input.classList.add('has-voice-padding');
        }

        if (isTextarea) {
            input.classList.add('is-voice-textarea');
        }

        input.dataset.voiceReady = 'true';

        const recognition = new SpeechRecognition();
        recognition.lang = 'en-US';
        recognition.continuous = false;
        recognition.interimResults = false;

        const controller = {
            input,
            micBtn,
            statusLabel,
            recognition
        };

        function resetVisualState() {
            micBtn.classList.remove('is-listening', 'text-[#8B0000]');
            micBtn.innerHTML = '<i class="fas fa-microphone"></i>';
        }

        function showStatus(message, state = 'default') {
            statusLabel.textContent = message;
            statusLabel.className = 'voice-status';

            if (state === 'listening') {
                statusLabel.classList.add('is-listening');
            } else if (state === 'error') {
                statusLabel.classList.add('is-error');
            } else if (state === 'success') {
                statusLabel.classList.add('is-success');
            } else {
                statusLabel.classList.add('is-default');
            }
        }

        function hideStatus(delay = 0) {
            setTimeout(() => statusLabel.classList.add('hidden'), delay);
        }

        micBtn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();

            const isSameActive = activeController === controller;

            if (isSameActive) {
                recognition.stop();
                return;
            }

            if (activeController) {
                try {
                    activeController.recognition.stop();
                } catch (err) {}
            }

            activeController = controller;

            try {
                recognition.start();
                micBtn.classList.add('is-listening', 'text-[#8B0000]');
                micBtn.innerHTML = '<i class="fas fa-stop"></i>';
                showStatus('Listening...', 'listening');
            } catch (err) {
                showStatus('Unable to start voice input.', 'error');
                hideStatus(2500);
                resetVisualState();
                activeController = null;
            }
        });

        recognition.onresult = (event) => {
            const transcript = event.results?.[0]?.[0]?.transcript?.trim() || '';

            if (transcript) {
                if (isTextarea && input.value.trim()) {
                    input.value = `${input.value.trim()} ${transcript}`.trim();
                } else {
                    input.value = transcript;
                }

                input.dispatchEvent(new Event('input', { bubbles: true }));
                input.dispatchEvent(new Event('change', { bubbles: true }));

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

            if (activeController === controller) {
                activeController = null;
            }

            if (statusLabel.textContent === 'Listening...') {
                statusLabel.classList.add('hidden');
            }
        };
    });
});
</script>