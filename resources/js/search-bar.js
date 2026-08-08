function resolveSearchCallback(name) {
    if (!name) {
        return null;
    }

    const callback =
        String(name)
            .split('.')
            .reduce(
                (value, key) =>
                    value?.[key],
                window
            );

    return typeof callback ===
        'function'
        ? callback
        : null;
}

function escapeSearchHtml(value) {
    return String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');
}

function resolveSearchElement(
    target
) {
    if (!target) {
        return null;
    }

    if (
        target instanceof
        HTMLElement
    ) {
        return target;
    }

    if (
        typeof target ===
        'string'
    ) {
        return document.querySelector(
            target
        );
    }

    return null;
}

function renderGlobalSearchEmptyState({
    host,
    input,
    query = '',
    title = null,
    message =
    'Try a different search term.',
    icon =
    'fa-magnifying-glass',
    className = '',
} = {}) {
    const hostElement =
        resolveSearchElement(host);

    const inputElement =
        resolveSearchElement(input);

    if (!hostElement) {
        return;
    }

    const normalizedQuery =
        String(
            query ||
            inputElement?.value ||
            ''
        ).trim();

    const resolvedTitle =
        title ||
        (
            normalizedQuery
                ? `No results for “${normalizedQuery}”`
                : 'No results found'
        );

    const inputSelector =
        inputElement?.id
            ? `#${CSS.escape(
                inputElement.id
            )}`
            : '';

    hostElement.className =
        [
            'empty-state-host',
            'show',
            className,
        ]
            .filter(Boolean)
            .join(' ');

    hostElement.innerHTML = `
        <div class="empty-state empty-search">
            <div class="empty-state-icon">
                <i
                    class="
                        fa-solid
                        ${escapeSearchHtml(
        icon
    )}
                    "
                    aria-hidden="true"
                ></i>
            </div>

            <p class="empty-state-title">
                ${escapeSearchHtml(
        resolvedTitle
    )}
            </p>

            <p class="empty-state-sub">
                ${escapeSearchHtml(
        message
    )}
            </p>

            ${inputSelector
            ? `
                        <button
                            type="button"
                            class="empty-state-btn"
                            data-clear-search
                            data-search-target="${escapeSearchHtml(
                inputSelector
            )}"
                        >
                            <i
                                class="
                                    fa-solid
                                    fa-xmark
                                "
                            ></i>

                            Clear search
                        </button>
                    `
            : ''
        }
        </div>
    `;
}

function hideGlobalSearchEmptyState(
    host
) {
    const hostElement =
        resolveSearchElement(host);

    if (!hostElement) {
        return;
    }

    hostElement.className =
        'empty-state-host';

    hostElement.replaceChildren();
}

function initGlobalSearchBars(
    root = document
) {
    const scope =
        root &&
            typeof root.querySelectorAll ===
            'function'
            ? root
            : document;

    scope
        .querySelectorAll(
            '[data-global-search-bar]'
        )
        .forEach(wrapper => {
            if (
                wrapper.dataset
                    .globalSearchInitialized ===
                'true'
            ) {
                return;
            }

            const input =
                wrapper.querySelector(
                    '[data-search-input]'
                );

            if (!input) {
                return;
            }

            wrapper.dataset
                .globalSearchInitialized =
                'true';

            const delay =
                Math.max(
                    0,
                    Number(
                        wrapper.dataset
                            .searchDebounce
                    ) || 300
                );

            let timer = null;

            const run = () => {
                window.clearTimeout(
                    timer
                );

                const callback =
                    resolveSearchCallback(
                        wrapper.dataset
                            .searchCallback
                    );

                callback?.(
                    input.value.trim(),
                    input,
                    wrapper
                );
            };

            input.addEventListener(
                'input',
                () => {
                    window.clearTimeout(
                        timer
                    );

                    timer =
                        window.setTimeout(
                            run,
                            delay
                        );
                }
            );

            input.addEventListener(
                'keydown',
                event => {
                    if (
                        event.key !==
                        'Enter'
                    ) {
                        return;
                    }

                    event.preventDefault();

                    run();
                }
            );
        });
}

document.addEventListener(
    'DOMContentLoaded',
    () => {
        initGlobalSearchBars();
    }
);

document.addEventListener(
    'ui-modal:opened',
    event => {
        initGlobalSearchBars(
            event.detail?.modal ||
            document
        );
    }
);

window.initGlobalSearchBars =
    initGlobalSearchBars;

window.renderGlobalSearchEmptyState =
    renderGlobalSearchEmptyState;

window.hideGlobalSearchEmptyState =
    hideGlobalSearchEmptyState;