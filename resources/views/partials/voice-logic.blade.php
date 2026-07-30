<script>
    (() => {
        if (window.__GLOBAL_VOICE_INPUTS_READY__) {
            document.dispatchEvent(
                new CustomEvent('voice:refresh', {
                    detail: {
                        root: document
                    }
                })
            );

            return;
        }

        window.__GLOBAL_VOICE_INPUTS_READY__ = true;

        const SpeechRecognition =
            window.SpeechRecognition ||
            window.webkitSpeechRecognition;

        const NO_SPEECH_TIMEOUT = 8000;
        const STATUS_HIDE_DELAY = 2200;
        const SUCCESS_HIDE_DELAY = 1400;

        let activeController = null;

        const WAVEFORM_BAR_COUNT = 7;

        function getWaveformContainer(button) {
            const existing = button.parentElement?.querySelector(
                '.global-voice-waveform'
            );

            if (existing) {
                return existing;
            }

            const waveform = document.createElement('span');

            waveform.className =
                'global-voice-waveform is-idle';

            waveform.setAttribute('aria-hidden', 'true');

            for (let index = 0; index < WAVEFORM_BAR_COUNT; index++) {
                waveform.appendChild(
                    document.createElement('span')
                );
            }

            button.insertAdjacentElement(
                'beforebegin',
                waveform
            );

            return waveform;
        }

        function resetWaveform(controller) {
            if (!controller) return;

            if (controller.waveformFrame) {
                cancelAnimationFrame(
                    controller.waveformFrame
                );

                controller.waveformFrame = null;
            }

            if (controller.audioContext) {
                controller.audioContext.close()
                    .catch(() => {});

                controller.audioContext = null;
            }

            if (controller.mediaStream) {
                controller.mediaStream
                    .getTracks()
                    .forEach((track) => track.stop());

                controller.mediaStream = null;
            }

            const waveform = controller.waveform;

            if (!waveform) return;

            waveform.classList.remove('is-active');
            waveform.classList.add('is-idle');

            waveform
                .querySelectorAll('span')
                .forEach((bar) => {
                    bar.style.height = '';
                });
        }

        function runFallbackWaveform(controller) {
            const waveform = controller.waveform;

            if (!waveform) return;

            const bars = waveform.querySelectorAll('span');

            waveform.classList.add('is-active');
            waveform.classList.remove('is-idle');

            const animate = () => {
                if (
                    controller.stoppedManually ||
                    controller.recognitionError ||
                    activeController !== controller
                ) {
                    return;
                }

                bars.forEach((bar, index) => {
                    const time = Date.now() / 150;
                    const wave =
                        Math.sin(time + index * 0.9);

                    const height =
                        6 + Math.abs(wave) * 15;

                    bar.style.height =
                        `${Math.round(height)}px`;
                });

                controller.waveformFrame =
                    requestAnimationFrame(animate);
            };

            animate();
        }

        async function startAudioWaveform(controller) {
            const waveform = controller.waveform;

            if (!waveform) return;

            waveform.classList.add('is-active');
            waveform.classList.remove('is-idle');

            /*
             * SpeechRecognition already requests mic permission,
             * but getUserMedia is needed to read live audio levels.
             */
            try {
                const stream =
                    await navigator.mediaDevices.getUserMedia({
                        audio: true
                    });

                if (
                    activeController !== controller ||
                    controller.stoppedManually
                ) {
                    stream
                        .getTracks()
                        .forEach((track) => track.stop());

                    return;
                }

                const AudioContextClass =
                    window.AudioContext ||
                    window.webkitAudioContext;

                if (!AudioContextClass) {
                    runFallbackWaveform(controller);
                    return;
                }

                const audioContext =
                    new AudioContextClass();

                const analyser =
                    audioContext.createAnalyser();

                const source =
                    audioContext.createMediaStreamSource(
                        stream
                    );

                analyser.fftSize = 256;
                analyser.smoothingTimeConstant = 0.72;

                source.connect(analyser);

                const data =
                    new Uint8Array(
                        analyser.frequencyBinCount
                    );

                const bars =
                    waveform.querySelectorAll('span');

                controller.mediaStream = stream;
                controller.audioContext = audioContext;
                controller.audioAnalyser = analyser;

                const animate = () => {
                    if (
                        controller.stoppedManually ||
                        controller.recognitionError ||
                        activeController !== controller
                    ) {
                        return;
                    }

                    analyser.getByteFrequencyData(data);

                    const segmentSize =
                        Math.max(
                            1,
                            Math.floor(
                                data.length / bars.length
                            )
                        );

                    bars.forEach((bar, index) => {
                        const start =
                            index * segmentSize;

                        const end =
                            Math.min(
                                start + segmentSize,
                                data.length
                            );

                        let total = 0;

                        for (
                            let dataIndex = start; dataIndex < end; dataIndex++
                        ) {
                            total += data[dataIndex];
                        }

                        const average =
                            total /
                            Math.max(1, end - start);

                        const height =
                            5 + (average / 255) * 20;

                        bar.style.height =
                            `${Math.max(
                        5,
                        Math.round(height)
                    )}px`;
                    });

                    controller.waveformFrame =
                        requestAnimationFrame(animate);
                };

                animate();
            } catch (error) {
                /*
                 * Recognition may still work even if analyser setup fails.
                 * Use a visual fallback instead.
                 */
                runFallbackWaveform(controller);
            }
        }

        function getTargetInput(button) {
            const targetSelector = button.dataset.voiceTarget;

            if (targetSelector) {
                try {
                    return document.querySelector(targetSelector);
                } catch (error) {
                    console.warn(
                        `Invalid voice target selector: ${targetSelector}`,
                        error
                    );

                    return null;
                }
            }

            const field = button.closest(
                '[data-voice-field], .voice-search-row, .st-voice-row, .voice-input-wrap'
            );

            return field?.querySelector(
                'input:not([type="hidden"]), textarea'
            ) || null;
        }

        function getStatusLabel(button) {
            const statusSelector = button.dataset.voiceStatus;

            if (statusSelector) {
                try {
                    return document.querySelector(statusSelector);
                } catch (error) {
                    console.warn(
                        `Invalid voice status selector: ${statusSelector}`,
                        error
                    );

                    return null;
                }
            }

            const field = button.closest(
                '[data-voice-field], .voice-search-row, .st-voice-row, .voice-input-wrap'
            );

            return field?.querySelector('[data-voice-status]') || null;
        }

        function setVoiceStatus(
            statusLabel,
            message = '',
            state = 'default'
        ) {
            if (!statusLabel) return;

            statusLabel.textContent = message;

            statusLabel.classList.remove(
                'hidden',
                'is-listening',
                'is-success',
                'is-error',
                'is-default'
            );

            if (!message) {
                statusLabel.classList.add('hidden');
                return;
            }

            statusLabel.classList.add(`is-${state}`);
        }

        function showTemporaryStatus(
            statusLabel,
            message,
            state,
            duration = STATUS_HIDE_DELAY
        ) {
            setVoiceStatus(statusLabel, message, state);

            window.setTimeout(() => {
                setVoiceStatus(statusLabel, '');
            }, duration);
        }

        function setMicPressed(button, value) {
            if (!button) return;

            button.setAttribute(
                'aria-pressed',
                value ? 'true' : 'false'
            );
        }

        function resetMic(button) {
            if (!button) return;

            button.classList.remove(
                'is-listening',
                'mic-active',
                'text-[#8B0000]'
            );

            button.innerHTML =
                '<i class="fa-solid fa-microphone"></i>';

            setMicPressed(button, false);
        }

        function clearNoSpeechTimer(controller) {
            if (!controller?.noSpeechTimer) return;

            window.clearTimeout(controller.noSpeechTimer);
            controller.noSpeechTimer = null;
        }

        function stopActiveController(options = {}) {
            if (!activeController) return;

            const current = activeController;

            activeController = null;
            current.stoppedManually = true;

            clearNoSpeechTimer(current);

            try {
                current.recognition.stop();
            } catch (error) {}

            resetMic(current.button);
            resetWaveform(current);

            if (!options.keepStatus) {
                setVoiceStatus(
                    current.statusLabel,
                    ''
                );
            }
        }

        function normalizeSpaces(value) {
            return String(value || '')
                .replace(/\s+/g, ' ')
                .trim();
        }

        function joinText(baseText, spokenText) {
            const base = normalizeSpaces(baseText);
            const spoken = normalizeSpaces(spokenText);

            if (!base) return spoken;
            if (!spoken) return base;

            return `${base} ${spoken}`.trim();
        }

        function applyMaxLength(input, value) {
            const max = Number(
                input.getAttribute('maxlength') ||
                input.dataset.wordLimit ||
                0
            );

            if (max > 0 && value.length > max) {
                return value.slice(0, max);
            }

            return value;
        }

        function writeTranscript(input, baseValue, spokenText) {
            const tag = input.tagName.toLowerCase();

            const shouldAppend =
                tag === 'textarea' ||
                input.dataset.voiceAppend === 'true';

            let nextValue = shouldAppend ?
                joinText(baseValue, spokenText) :
                normalizeSpaces(spokenText);

            nextValue = applyMaxLength(input, nextValue);
            input.value = nextValue;

            input.dispatchEvent(
                new Event('input', {
                    bubbles: true
                })
            );

            input.dispatchEvent(
                new Event('change', {
                    bubbles: true
                })
            );
        }

        function getRecognitionErrorMessage(error) {
            const messages = {
                'no-speech': 'No speech detected',
                'not-allowed': 'Microphone permission blocked',
                'service-not-allowed': 'Microphone access is not allowed',
                'audio-capture': 'No microphone detected',
                'network': 'Voice recognition connection failed',
                'language-not-supported': 'Selected language is not supported',
                'bad-grammar': 'Voice recognition failed',
                'aborted': ''
            };

            return messages[error] || 'Voice input failed';
        }

        function initializeVoiceInputs(root = document) {
            const scope =
                root &&
                typeof root.querySelectorAll === 'function' ?
                root :
                document;

            const buttons = scope.querySelectorAll(
                [
                    '.voice-search-mic.external[data-voice-trigger]',
                    '.voice-search-mic.external[data-global-voice-trigger]',
                    '[data-global-voice-trigger]'
                ].join(', ')
            );

            buttons.forEach((button) => {
                if (
                    button.dataset.voiceReady === 'true' ||
                    button.dataset.voiceInitialized === 'true'
                ) {
                    return;
                }

                button.dataset.voiceReady = 'true';
                button.dataset.voiceInitialized = 'true';

                button.addEventListener('click', function(event) {
                    event.preventDefault();
                    event.stopPropagation();

                    const input = getTargetInput(button);
                    const statusLabel = getStatusLabel(button);

                    if (!input) {
                        showTemporaryStatus(
                            statusLabel,
                            'No input found',
                            'error'
                        );

                        return;
                    }

                    if (!SpeechRecognition) {
                        showTemporaryStatus(
                            statusLabel,
                            'Voice input is not supported',
                            'error',
                            2800
                        );

                        return;
                    }

                    if (
                        activeController &&
                        activeController.button === button
                    ) {
                        stopActiveController();
                        return;
                    }

                    stopActiveController();

                    const recognition = new SpeechRecognition();

                    recognition.lang =
                        input.dataset.voiceLang ||
                        button.dataset.voiceLang ||
                        'en-US';

                    recognition.continuous = false;
                    recognition.interimResults = true;
                    recognition.maxAlternatives = 1;

                    const baseValue = input.value || '';
                    const finalParts = [];
                    const finalIndexes = new Set();

                    const controller = {
                        recognition,
                        button,
                        input,
                        statusLabel,

                        waveform: getWaveformContainer(button),
                        waveformFrame: null,
                        mediaStream: null,
                        audioContext: null,
                        audioAnalyser: null,

                        noSpeechTimer: null,

                        receivedSpeech: false,
                        receivedTranscript: false,
                        receivedFinalResult: false,

                        recognitionError: false,
                        stoppedManually: false,
                        timedOut: false
                    };

                    recognition.onstart = () => {
                        button.classList.add(
                            'is-listening',
                            'mic-active',
                            'text-[#8B0000]'
                        );

                        button.innerHTML =
                            '<i class="fa-solid fa-stop"></i>';

                        setMicPressed(button, true);

                        setVoiceStatus(
                            statusLabel,
                            'Listening...',
                            'listening'
                        );

                        controller.noSpeechTimer =
                            window.setTimeout(() => {
                                if (
                                    controller.receivedSpeech ||
                                    controller.recognitionError ||
                                    controller.stoppedManually
                                ) {
                                    return;
                                }

                                controller.timedOut = true;
                                controller.recognitionError = true;

                                resetMic(button);
                                resetWaveform(controller);

                                showTemporaryStatus(
                                    statusLabel,
                                    'No speech detected',
                                    'error'
                                );

                                try {
                                    recognition.stop();
                                } catch (error) {}
                            }, NO_SPEECH_TIMEOUT);
                    };

                    recognition.onspeechstart = () => {
                        controller.receivedSpeech = true;
                        clearNoSpeechTimer(controller);
                    };

                    recognition.onsoundstart = () => {
                        /*
                         * A sound was detected, but this does not yet mean
                         * that recognizable speech was captured.
                         */
                    };

                    recognition.onresult = (event) => {
                        const interimParts = [];

                        for (
                            let index = event.resultIndex; index < event.results.length; index++
                        ) {
                            const transcript =
                                event.results[index][0]
                                ?.transcript
                                ?.trim() || '';

                            if (!transcript) continue;

                            controller.receivedTranscript = true;
                            controller.receivedSpeech = true;
                            clearNoSpeechTimer(controller);

                            if (event.results[index].isFinal) {
                                controller.receivedFinalResult = true;

                                if (!finalIndexes.has(index)) {
                                    finalIndexes.add(index);
                                    finalParts.push(transcript);
                                }
                            } else {
                                interimParts.push(transcript);
                            }
                        }

                        const spokenText = normalizeSpaces(
                            [
                                ...finalParts,
                                ...interimParts
                            ].join(' ')
                        );

                        if (!spokenText) return;

                        /*
                         * Rebuild the visible value from the original
                         * value captured when recognition started.
                         * This prevents duplicate interim transcripts.
                         */
                        writeTranscript(
                            input,
                            baseValue,
                            spokenText
                        );
                    };

                    recognition.onerror = (event) => {
                        clearNoSpeechTimer(controller);
                        resetMic(button);
                        resetWaveform(controller);

                        const error =
                            event?.error || 'unknown';


                        if (
                            error === 'aborted' &&
                            controller.stoppedManually
                        ) {
                            return;
                        }

                        if (controller.timedOut) {
                            return;
                        }

                        controller.recognitionError = true;

                        const message =
                            getRecognitionErrorMessage(error);

                        if (message) {
                            showTemporaryStatus(
                                statusLabel,
                                message,
                                'error'
                            );
                        }

                        if (
                            activeController?.recognition === recognition
                        ) {
                            activeController = null;
                        }
                    };

                    recognition.onend = () => {
                        clearNoSpeechTimer(controller);

                        resetMic(button);
                        resetWaveform(controller);

                        if (
                            activeController?.recognition === recognition
                        ) {
                            activeController = null;
                        }

                        if (
                            controller.recognitionError ||
                            controller.timedOut
                        ) {
                            return;
                        }

                        if (controller.stoppedManually) {
                            setVoiceStatus(statusLabel, '');
                            return;
                        }

                        const capturedText =
                            normalizeSpaces(
                                finalParts.join(' ')
                            );

                        if (
                            controller.receivedSpeech &&
                            capturedText
                        ) {
                            showTemporaryStatus(
                                statusLabel,
                                'Captured',
                                'success',
                                SUCCESS_HIDE_DELAY
                            );

                            return;
                        }

                        showTemporaryStatus(
                            statusLabel,
                            'No speech detected',
                            'error'
                        );
                    };

                    activeController = controller;

                    try {
                        recognition.start();
                    } catch (error) {
                        clearNoSpeechTimer(controller);
                        resetMic(button);

                        controller.recognitionError = true;
                        activeController = null;

                        showTemporaryStatus(
                            statusLabel,
                            'Voice input failed',
                            'error'
                        );
                    }
                });
            });
        }

        window.initializeVoiceInputs = initializeVoiceInputs;
        window.initGlobalVoiceInputs = initializeVoiceInputs;
        window.stopGlobalVoiceInput = stopActiveController;

        document.addEventListener('DOMContentLoaded', () => {
            initializeVoiceInputs(document);
        });

        document.addEventListener('voice:refresh', (event) => {
            initializeVoiceInputs(
                event?.detail?.root || document
            );
        });

        document.addEventListener('modal:before-close', () => {
            stopActiveController();
        });

        document.addEventListener('visibilitychange', () => {
            if (document.hidden) {
                stopActiveController();
            }
        });
    })();
</script>
