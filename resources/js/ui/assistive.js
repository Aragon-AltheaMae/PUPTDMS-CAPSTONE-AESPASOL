function initAssistiveHelpPopover() {
    if (
        document.querySelector(
            '.assistive-help-popover'
        )
    ) {
        return;
    }

    const assistiveBtn =
        document.getElementById(
            'assistiveMainFab'
        );

    if (!assistiveBtn) {
        return;
    }

    const popover =
        document.createElement(
            'div'
        );

    popover.className =
        'assistive-help-popover';

    popover.innerHTML = `
        <strong>Need help?</strong>
        <span>
            Open assistance tools for chatbot
            and accessibility options.
        </span>
    `;

    document.body.appendChild(popover);

    const showPopover = () => {
        if (
            document
                .getElementById('assistiveFabGroup')
                ?.classList.contains('open')
        ) {
            return;
        }

        popover.classList.add('show');
    };

    const hidePopover = () => {
        popover.classList.remove('show');
    };

    assistiveBtn.addEventListener('mouseenter', showPopover);
    assistiveBtn.addEventListener('focus', showPopover);
    assistiveBtn.addEventListener('mouseleave', hidePopover);
    assistiveBtn.addEventListener('blur', hidePopover);
    assistiveBtn.addEventListener('click', hidePopover);
}

function initAccessibilitySheetGesture() {
    let startY = 0;
    let currentY = 0;
    let tracking = false;
    let dragging = false;

    document.addEventListener('touchstart', event => {
        const menu = event.target.closest('.asw-menu');

        if (!menu) return;

        const interactiveElement = event.target.closest(
            'button, a, input, select, textarea, label'
        );

        if (interactiveElement) {
            tracking = false;
            dragging = false;
            return;
        }

        startY = event.touches[0].clientY;
        currentY = startY;
        tracking = true;
        dragging = false;
    }, { passive: true });

    document.addEventListener('touchmove', event => {
        if (!tracking) return;

        const menu = document.querySelector('.asw-menu');

        if (!menu) {
            tracking = false;
            dragging = false;
            return;
        }

        currentY = event.touches[0].clientY;

        const difference = Math.max(
            0,
            currentY - startY
        );

        if (difference < 6) return;

        dragging = true;

        menu.classList.add('asw-dragging');

        menu.style.transform =
            `translateX(-50%) translateY(${difference}px)`;
    }, { passive: true });

    document.addEventListener('touchend', () => {
        if (!tracking) return;

        const menu = document.querySelector('.asw-menu');

        tracking = false;

        if (!menu || !dragging) {
            dragging = false;
            return;
        }

        const difference = Math.max(
            0,
            currentY - startY
        );

        menu.classList.remove('asw-dragging');

        if (difference > 90) {
            menu.querySelector('.asw-menu-close')?.click();
        } else {
            menu.style.transform =
                'translateX(-50%) translateY(0)';
        }

        dragging = false;
    });

    document.addEventListener('touchcancel', () => {
        const menu = document.querySelector('.asw-menu');

        tracking = false;
        dragging = false;

        if (!menu) return;

        menu.classList.remove('asw-dragging');
        menu.style.removeProperty('transform');
    });
}

function initAccessibilityCloseIsolation() {
    const bindCloseButtons = () => {
        document
            .querySelectorAll('.asw-menu-close')
            .forEach(closeButton => {
                if (
                    closeButton.dataset.closeIsolationInitialized ===
                    'true'
                ) {
                    return;
                }

                closeButton.dataset.closeIsolationInitialized =
                    'true';

                closeButton.addEventListener('click', event => {
                    const assistiveGroup =
                        document.getElementById(
                            'assistiveFabGroup'
                        );

                    const assistiveMainFab =
                        document.getElementById(
                            'assistiveMainFab'
                        );

                    const shouldKeepWandOpen =
                        assistiveGroup?.classList.contains(
                            'open'
                        );

                    event.stopPropagation();

                    if (!shouldKeepWandOpen) return;

                    setTimeout(() => {
                        assistiveGroup.classList.add('open');

                        document.body.classList.add(
                            'assistive-menu-open'
                        );

                        assistiveMainFab?.setAttribute(
                            'aria-expanded',
                            'true'
                        );
                    }, 0);
                });
            });
    };

    bindCloseButtons();

    const observer =
        new MutationObserver(
            mutations => {
                const hasAccessibilityChange =
                    mutations.some(
                        mutation =>
                            Array.from(
                                mutation.addedNodes
                            ).some(node => {
                                if (
                                    !(
                                        node instanceof
                                        Element
                                    )
                                ) {
                                    return false;
                                }

                                return (
                                    node.matches(
                                        '.asw-menu, .asw-menu-close'
                                    ) ||
                                    node.querySelector(
                                        '.asw-menu-close'
                                    )
                                );
                            })
                    );

                if (!hasAccessibilityChange) {
                    return;
                }

                bindCloseButtons();
            }
        );

    observer.observe(
        document.body,
        {
            childList: true,
            subtree: true
        }
    );
}

function fixSiennaPosition() {
    const isMobile = window.matchMedia('(max-width: 640px)').matches;
    const isPatient = document.body.classList.contains('role-patient');

    const navCandidates = Array.from(
        document.querySelectorAll(
            [
                '.patient-mobile-nav',
                '.mobile-bottom-nav',
                '.bottom-nav',
                '#mobileBottomNav',
                '[data-mobile-bottom-nav]'
            ].join(',')
        )
    );

    const visibleBottomNav = navCandidates
        .map(nav => {
            const rect = nav.getBoundingClientRect();
            const style = window.getComputedStyle(nav);

            return {
                rect,
                visible:
                    style.display !== 'none' &&
                    style.visibility !== 'hidden' &&
                    rect.width > 0 &&
                    rect.height > 0 &&
                    rect.bottom > window.innerHeight * 0.7
            };
        })
        .filter(item => item.visible)
        .sort((first, second) => second.rect.top - first.rect.top)[0];

    const right = isMobile ? 18 : 22;
    const fabSize = isMobile ? 48 : 46;
    const gap = 14;

    let navClearance = 0;

    if (isPatient && isMobile) {
        navClearance = visibleBottomNav
            ? Math.max(0, window.innerHeight - visibleBottomNav.rect.top)
            : 92;
    }

    const assistiveGroupBottom = isPatient && isMobile
        ? navClearance + 10
        : 24;

    const backTopBottom =
        assistiveGroupBottom + fabSize + gap;

    const root = document.documentElement;

    root.style.setProperty('--float-right', `${right}px`, 'important');
    root.style.setProperty('--float-right-final', `${right}px`, 'important');
    root.style.setProperty('--patient-nav-height', `${navClearance}px`, 'important');
    root.style.setProperty('--fab-final-size', `${fabSize}px`, 'important');
    root.style.setProperty('--accessibility-bottom', `${assistiveGroupBottom}px`, 'important');
    root.style.setProperty('--accessibility-bottom-final', `${assistiveGroupBottom}px`, 'important');
    root.style.setProperty('--chatbot-bottom-final', `${assistiveGroupBottom}px`, 'important');
    root.style.setProperty('--back-top-bottom', `${backTopBottom}px`, 'important');
    root.style.setProperty('--back-top-bottom-final', `${backTopBottom}px`, 'important');

    const assistiveGroup =
        document.getElementById('assistiveFabGroup');

    if (assistiveGroup) {
        assistiveGroup.style.setProperty(
            'right',
            `${right}px`,
            'important'
        );

        assistiveGroup.style.setProperty(
            'bottom',
            `${assistiveGroupBottom}px`,
            'important'
        );
    }

    document
        .querySelectorAll('.asw-widget, .asw-menu-btn')
        .forEach(element => {
            element.style.setProperty(
                '--asw-off-x',
                `${right}px`,
                'important'
            );

            element.style.setProperty(
                '--asw-off-y',
                `${assistiveGroupBottom}px`,
                'important'
            );

            element.style.setProperty(
                '--asw-right',
                `${right}px`,
                'important'
            );

            element.style.setProperty(
                '--asw-bottom',
                `${assistiveGroupBottom}px`,
                'important'
            );

            element.style.setProperty(
                'right',
                `${right}px`,
                'important'
            );

            element.style.setProperty(
                'bottom',
                `${assistiveGroupBottom}px`,
                'important'
            );
        });
}

let siennaPositionFrame = null;

function scheduleSiennaPosition() {
    cancelAnimationFrame(
        siennaPositionFrame
    );

    siennaPositionFrame =
        requestAnimationFrame(() => {
            fixSiennaPosition();
        });
}

window.addEventListener('load', scheduleSiennaPosition);
window.addEventListener('resize', scheduleSiennaPosition, { passive: true });
window.addEventListener('orientationchange', scheduleSiennaPosition, { passive: true });

function syncAssistiveFloatingState() {
    const group = document.getElementById('assistiveFabGroup');

    if (!group) return;

    const sync = () => {
        document.body.classList.toggle(
            'assistive-menu-open',
            group.classList.contains('open')
        );
    };

    sync();

    const observer = new MutationObserver(sync);

    observer.observe(group, {
        attributes: true,
        attributeFilter: ['class']
    });
}

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initAssistiveHelpPopover();
        initAccessibilitySheetGesture();
        initAccessibilityCloseIsolation();
        syncAssistiveFloatingState();
        scheduleSiennaPosition();
    }
);