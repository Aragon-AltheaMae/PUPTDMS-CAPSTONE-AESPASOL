export function swapSkeletonContent(targetId, html, options = {}) {
    const el = document.getElementById(targetId);
    if (!el) return;

    const leaveDuration = options.leaveDuration ?? 140;
    const revealClass = options.revealClass ?? 'content-reveal';

    el.classList.add('skeleton-fade-leave');
    el.style.pointerEvents = 'none';

    setTimeout(() => {
        el.innerHTML = html;
        el.classList.remove('skeleton-fade-leave');

        void el.offsetWidth;

        el.classList.add(revealClass);
        el.style.pointerEvents = '';

        setTimeout(() => {
            el.classList.remove(revealClass);
        }, 460);
    }, leaveDuration);
}

export function renderWithStagger(tasks, initialDelay = 500, step = 120) {
    setTimeout(() => {
        tasks.forEach((task, index) => {
            setTimeout(() => {
                if (typeof task === 'function') task();
            }, index * step);
        });
    }, initialDelay);
}

export function runEnterpriseLoading(phases = [], options = {}) {
    const initialDelay = options.initialDelay ?? 450;
    const phaseGap = options.phaseGap ?? 260;
    const taskGap = options.taskGap ?? 120;

    let cursor = initialDelay;

    phases.forEach((phase) => {
        setTimeout(() => {
            if (phase.label && typeof window.setDashboardLoadingStatus === 'function') {
                window.setDashboardLoadingStatus(phase.label);
            }

            (phase.tasks || []).forEach((task, index) => {
                setTimeout(() => {
                    if (typeof task === 'function') task();
                }, index * taskGap);
            });
        }, cursor);

        cursor += ((phase.tasks || []).length * taskGap) + phaseGap;
    });

    setTimeout(() => {
        if (typeof window.finishDashboardLoading === 'function') {
            window.finishDashboardLoading();
        }
    }, cursor + 260);
}