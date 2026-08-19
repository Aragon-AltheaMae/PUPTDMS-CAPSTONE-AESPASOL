@props([
    'id' => 'startProcedureModal',
    'title' => 'Start Procedure',
    'subtitle' => 'Open the odontogram to begin this appointment.',
    'patient' => '—',
    'schedule' => '—',
    'service' => '—',
    'startUrl' => '',
])

<div id="{{ $id }}" class="ui-modal modal-theme-success" data-start-procedure-modal
    data-start-url="{{ $startUrl }}" aria-hidden="true" role="dialog" aria-modal="true"
    aria-labelledby="{{ $id }}Title">
    <div class="ui-modal-card modal-md">

        <div class="modal-hd">
            <div class="modal-heading">
                <div class="modal-icon">
                    <i class="fa-solid fa-play"></i>
                </div>

                <div class="modal-copy">
                    <h2 id="{{ $id }}Title" class="modal-title">
                        {{ $title }}
                    </h2>

                    <p class="modal-subtitle">
                        {{ $subtitle }}
                    </p>
                </div>
            </div>

            <button type="button" class="modal-x" data-modal-close="{{ $id }}"
                aria-label="Close start procedure modal">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="modal-bd">

            <div class="global-confirm-alert">
                <i class="fa-solid fa-circle-play"></i>

                <div>
                    <strong data-start-modal-heading>
                        Ready to start this appointment?
                    </strong>

                    <span data-start-modal-message>
                        You will be redirected to the odontogram page
                        for the selected patient.
                    </span>
                </div>
            </div>

            <div class="confirmed-modal-details mt-4">

                <div class="confirmed-modal-details-header">
                    <div class="confirmed-modal-details-icon">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div>
                        <span class="confirmed-modal-details-eyebrow">
                            Appointment
                        </span>

                        <strong class="confirmed-modal-details-title">
                            Selected appointment details
                        </strong>
                    </div>
                </div>

                <div class="confirmed-modal-schedule-grid">

                    <div class="confirmed-modal-schedule-item">
                        <span class="confirmed-modal-schedule-icon">
                            <i class="fa-solid fa-user"></i>
                        </span>

                        <div>
                            <span class="confirmed-modal-schedule-label">
                                Patient
                            </span>

                            <strong class="confirmed-modal-schedule-value" data-start-modal-patient>
                                {{ $patient }}
                            </strong>
                        </div>
                    </div>


                    <div class="confirmed-modal-schedule-item">
                        <span class="confirmed-modal-schedule-icon">
                            <i class="fa-regular fa-calendar"></i>
                        </span>

                        <div>
                            <span class="confirmed-modal-schedule-label">
                                Schedule
                            </span>

                            <strong class="confirmed-modal-schedule-value" data-start-modal-schedule>
                                {{ $schedule }}
                            </strong>
                        </div>
                    </div>


                    <div class="confirmed-modal-schedule-item">
                        <span class="confirmed-modal-schedule-icon">
                            <i class="fa-solid fa-tooth"></i>
                        </span>

                        <div>
                            <span class="confirmed-modal-schedule-label">
                                Service Type
                            </span>

                            <strong class="confirmed-modal-schedule-value" data-start-modal-service>
                                {{ $service }}
                            </strong>
                        </div>
                    </div>

                </div>
            </div>

        </div>

        <div class="modal-ft">

            <button type="button" class="ui-btn ui-btn-secondary" data-modal-close="{{ $id }}">
                Cancel
            </button>

            <button type="button" class="ui-btn ui-btn-success" data-start-modal-confirm>
                <i class="fa-solid fa-play"></i>
                Start Procedure
            </button>

        </div>

    </div>
</div>
