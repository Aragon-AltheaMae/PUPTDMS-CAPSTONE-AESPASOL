import './bootstrap';
import Chart from 'chart.js/auto';

window.Chart = Chart;

function getAccessibilityCandidates() {
    return [
        ...document.querySelectorAll(
            [
                '[id*="sienna"]',
                '[class*="sienna"]',
                'iframe[src*="sienna"]',
                '[id*="accessibility"]',
                '[class*="accessibility"]',
                '[aria-label*="Accessibility"]',
                '[title*="Accessibility"]'
            ].join(',')
        )
    ];
}

function positionAccessibilityWidget() {
    const isMobileLike = window.innerWidth < 1200;
    const candidates = getAccessibilityCandidates();

    candidates.forEach((el) => {
        const computed = window.getComputedStyle(el);

        if (computed.position !== 'fixed') return;

        const text = ((el.className || '') + ' ' + (el.id || '')).toLowerCase();
        const role = (el.getAttribute('role') || '').toLowerCase();
        const title = (el.getAttribute('title') || '').toLowerCase();
        const aria = (el.getAttribute('aria-label') || '').toLowerCase();

        const isLauncher =
            text.includes('btn') ||
            text.includes('button') ||
            text.includes('menu-btn') ||
            title.includes('open accessibility menu') ||
            aria.includes('open accessibility menu');

        const looksLikePanel =
            role === 'dialog' ||
            text.includes('panel') ||
            text.includes('drawer') ||
            text.includes('popup');

        el.style.left = 'auto';
        el.style.top = 'auto';
        el.style.zIndex = '9999';

        if (isMobileLike) {
            el.style.right = '16px';
            el.style.bottom = '110px';
        } else {
            el.style.right = '18px';
            el.style.bottom = '18px';
        }

        if (isLauncher) {
            el.style.width = '52px';
            el.style.height = '52px';
            el.style.minWidth = '52px';
            el.style.minHeight = '52px';
            el.style.maxWidth = '52px';
            el.style.maxHeight = '52px';
            el.style.borderRadius = '9999px';
            el.style.overflow = 'hidden';
            el.style.boxShadow = '0 10px 24px rgba(0, 0, 0, 0.18)';
            return;
        }

        if (looksLikePanel) {
            el.style.width = isMobileLike ? 'min(340px, calc(100vw - 32px))' : '360px';
            el.style.maxWidth = isMobileLike ? 'min(340px, calc(100vw - 32px))' : '360px';
            el.style.height = 'auto';
            el.style.maxHeight = isMobileLike ? 'min(70vh, 560px)' : '75vh';
            el.style.borderRadius = '18px';
            el.style.overflow = 'hidden';
        }
    });
}

function observeAccessibilityWidget() {
    const observer = new MutationObserver(() => {
        positionAccessibilityWidget();
    });

    observer.observe(document.body, {
        childList: true,
        subtree: true,
        attributes: true
    });
}

document.addEventListener('DOMContentLoaded', () => {
    positionAccessibilityWidget();
    observeAccessibilityWidget();

    window.addEventListener('load', positionAccessibilityWidget);
    window.addEventListener('resize', positionAccessibilityWidget);

    setTimeout(positionAccessibilityWidget, 800);
    setTimeout(positionAccessibilityWidget, 1500);
    setTimeout(positionAccessibilityWidget, 2500);
});