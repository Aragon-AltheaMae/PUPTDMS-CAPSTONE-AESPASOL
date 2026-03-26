<script>
    document.addEventListener('DOMContentLoaded', () => {
        const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
        
        if (!SpeechRecognition) {
            console.warn("Your browser does not support Voice Recognition.");
            return;
        }

        // Find all text inputs, emails, and textareas that are NOT readonly
        const inputs = document.querySelectorAll('input[type="text"]:not([readonly]), input[type="email"], textarea:not([readonly])');

        inputs.forEach(input => {
            // Optional: Skip inputs if you add a "no-voice" class to them
            if (input.classList.contains('no-voice')) return;

            const isTextarea = input.tagName.toLowerCase() === 'textarea';

            // 1. Create a wrapper and place the input inside it
            const wrapper = document.createElement('div');
            wrapper.className = 'relative w-full';
            input.parentNode.insertBefore(wrapper, input);
            wrapper.appendChild(input);

            // Ensure the input has padding on the right so text doesn't hide behind the mic icon
            input.classList.add('pr-10');

            // 2. Create the Status Label
            const statusLabel = document.createElement('span');
            statusLabel.className = 'hidden absolute right-0 -top-6 text-xs font-semibold px-2 py-0.5 rounded pointer-events-none z-20';
            wrapper.appendChild(statusLabel);

            // 3. Create the Microphone Button
            const micBtn = document.createElement('button');
            micBtn.type = 'button';
            micBtn.className = isTextarea
                ? 'absolute right-3 top-3 text-gray-400 hover:text-[#8B0000] transition-colors'
                : 'absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-[#8B0000] transition-colors';
            micBtn.innerHTML = '<i class="fas fa-microphone"></i>';
            wrapper.appendChild(micBtn);

            // 4. Attach the Voice Logic to the new button
            const recognition = new SpeechRecognition();
            recognition.lang = 'en-US';

            micBtn.onclick = (e) => {
                e.preventDefault(); // Prevent accidental form submission
                recognition.start();
                statusLabel.innerText = "Speaking...";
                statusLabel.className = 'absolute right-0 -top-6 text-xs font-semibold px-2 py-0.5 rounded pointer-events-none z-20 block text-blue-600 animate-pulse';
                micBtn.classList.add('text-[#8B0000]');
            };

            recognition.onresult = (event) => {
                input.value = event.results[0][0].transcript;
                input.dispatchEvent(new Event('input')); // Triggers any other JS listening to this input
                statusLabel.classList.add('hidden');
            };

            recognition.onerror = () => {
                statusLabel.innerText = "Didn't catch that. Try again.";
                statusLabel.className = 'absolute right-0 -top-6 text-xs font-semibold px-2 py-0.5 rounded pointer-events-none z-20 block text-red-600';
                setTimeout(() => statusLabel.classList.add('hidden'), 3000);
            };

            recognition.onend = () => {
                micBtn.classList.remove('text-[#8B0000]');
                if (statusLabel.innerText === "Speaking...") statusLabel.classList.add('hidden');
            };
        });
    });
</script>