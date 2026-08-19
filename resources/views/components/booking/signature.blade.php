@props([
    'mode' => 'patient',
    'label' => "Patient's Signature",
    'drawTitle' => null,
    'drawHelp' => null,
    'hasExistingSignature' => false,
    'existingSignatureUrl' => null,
])

@php
    $isDrawOnly = $mode === 'draw-only';

    $resolvedDrawTitle =
        $drawTitle ?? ($isDrawOnly ? "Draw the patient's signature here" : 'Or draw your signature here');

    $resolvedDrawHelp =
        $drawHelp ??
        ($isDrawOnly ? 'Use the drawing tablet, mouse, touch, or stylus.' : 'Use mouse, touch, or stylus.');
@endphp


<div class="booking-section-card signature-booking-section-card" data-global-field data-booking-signature
    data-signature-mode="{{ $mode }}" data-has-existing-signature="{{ $hasExistingSignature ? 'true' : 'false' }}"
    data-signature-validation-url="{{ $mode === 'patient' ? route('book.appointment.validate-signature') : '' }}"
    data-signature-drawn-prefix="{{ $isDrawOnly ? 'walk-in-signature' : 'drawn-signature' }}">

    <div class="signature-full-row">

        @if ($hasExistingSignature)
            <div class="signature-existing-card">

                <div class="signature-existing-header">
                    <i class="fa-solid fa-circle-check"></i>

                    <div>
                        <p class="signature-existing-title">
                            Existing signature on file
                        </p>

                        <p class="signature-existing-help">
                            Your previously verified signature will be reused.
                        </p>
                    </div>
                </div>


                @if ($existingSignatureUrl)
                    <div class="signature-existing-preview">
                        <img src="{{ $existingSignatureUrl }}" alt="Existing signature">
                    </div>
                @endif


                <button type="button" class="ui-btn ui-btn-secondary ui-btn-sm" id="editExistingSignatureBtn">
                    <i class="fa-solid fa-pen"></i>
                    Edit Signature
                </button>

            </div>
        @endif

        <input type="hidden" name="reuse_existing_signature" id="reuse_existing_signature"
            value="{{ $hasExistingSignature ? '1' : '0' }}">

        <div id="signatureEditorWrapper" class="{{ $hasExistingSignature ? 'hidden' : '' }}">

            <label class="global-form-label" for="patient_signature">
                {{ $label }}
                <span class="required-mark">
                    *
                </span>
            </label>

            @if ($isDrawOnly)
                <input type="file" name="patient_signature" id="patient_signature" class="hidden"
                    accept=".png,image/png">
                <input type="hidden" name="signature_source" id="signature_source" value="drawn">

                <div class="signature-draw-card">

                    <p class="signature-draw-title">
                        {{ $resolvedDrawTitle }}
                    </p>

                    <div class="signature-pad-wrap">
                        <canvas id="signatureCanvas" class="signature-pad-canvas">
                        </canvas>
                    </div>

                    <div class="signature-pad-footer">

                        <span class="signature-pad-help">
                            {{ $resolvedDrawHelp }}
                            Click
                            <b>
                                Use Drawn Signature
                            </b>
                            after signing.
                        </span>

                        <div class="signature-pad-actions">

                            <button type="button" id="signatureUndoBtn" class="ui-btn ui-btn-secondary ui-btn-sm">
                                <i class="fa-solid fa-rotate-left"></i>
                                Undo
                            </button>


                            <button type="button" id="signatureClearBtn" class="ui-btn ui-btn-secondary ui-btn-sm">
                                <i class="fa-solid fa-eraser"></i>
                                Clear Signature
                            </button>

                            <button type="button" id="signatureUseDrawnBtn" class="ui-btn ui-btn-primary ui-btn-sm">
                                <i class="fa-solid fa-check"></i>
                                Use Drawn Signature
                            </button>

                        </div>
                    </div>
                </div>
            @else
                <div class="signature-methods-grid">

                    <div class="file-upload-zone signature-upload-card">

                        <p class="signature-method-title">
                            Upload your signature
                        </p>

                        <div class="signature-upload-content">

                            <span class="signature-upload-icon">
                                <i class="fa-regular fa-image"></i>
                            </span>

                            <p class="signature-upload-title" data-signature-upload-title
                                data-default-title="Select your file or drag and drop">
                                Select your file or drag and drop
                            </p>

                            <small class="signature-upload-help">
                                JPG, PNG, up to 25 MB
                            </small>

                            <label class="ui-btn ui-btn-primary ui-btn-sm cursor-pointer">
                                <i class="fa-solid fa-upload"></i>
                                Browse
                                <input type="file" name="patient_signature" id="patient_signature" class="hidden"
                                    accept=".jpg,.jpeg,.png">
                                <input type="hidden" name="signature_source" id="signature_source" value="">
                            </label>

                        </div>
                    </div>

                    <div class="signature-draw-card">

                        <p class="signature-draw-title">
                            {{ $resolvedDrawTitle }}
                        </p>

                        <div class="signature-pad-wrap">
                            <canvas id="signatureCanvas" class="signature-pad-canvas">
                            </canvas>
                        </div>

                        <div class="signature-pad-footer">

                            <span class="signature-pad-help">
                                {{ $resolvedDrawHelp }}
                            </span>

                            <div class="signature-pad-actions">

                                <button type="button" id="signatureUndoBtn" class="ui-btn ui-btn-secondary ui-btn-sm">
                                    <i class="fa-solid fa-rotate-left"></i>
                                    Undo
                                </button>

                                <button type="button" id="signatureClearBtn" class="ui-btn ui-btn-secondary ui-btn-sm">
                                    <i class="fa-solid fa-eraser"></i>
                                    Clear Signature
                                </button>

                                <button type="button" id="signatureUseDrawnBtn"
                                    class="ui-btn ui-btn-primary ui-btn-sm">
                                    <i class="fa-solid fa-check"></i>
                                    Use Drawn Signature
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div id="signature_result_box" class="signature-result-box hidden">
                <p id="signature_filename"></p>
                <div id="signature_error" class="signature-result-message hidden">
                </div>
            </div>

        </div>

        @error('patient_signature')
            <p class="global-field-error show">
                <i class="fa-solid fa-circle-exclamation"></i>
                {{ $message }}
            </p>
        @enderror
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {

        const editBtn = document.getElementById(
            "editExistingSignatureBtn"
        );

        const existingCard = document.querySelector(
            ".signature-existing-card"
        );

        const editorWrapper = document.getElementById(
            "signatureEditorWrapper"
        );

        const reuseInput = document.getElementById(
            "reuse_existing_signature"
        );


        editBtn?.addEventListener("click", () => {

            existingCard?.classList.add("hidden");

            editorWrapper?.classList.remove("hidden");


            if (reuseInput) {
                reuseInput.value = "0";
            }


            window.BookingSignature
                ?.get(document)
                ?.resize();

        });

    });
</script>
