const globalRefreshWatchers = new Map();

function normalizeGlobalRefreshItems(payload, getItems) {
    const items = typeof getItems === 'function'
        ? getItems(payload)
        : Array.isArray(payload)
            ? payload
            : [];

    return Array.isArray(items) ? items : [];
}

function getGlobalRefreshNoticeId(key = 'global') {
    return `globalRefreshNotice-${String(key || 'global')}`;
}

function removeGlobalRefreshNotice(key = 'global') {
    document.getElementById(getGlobalRefreshNoticeId(key))?.remove();
}

function initGlobalRefreshWatcher(config = {}) {
    const key = config.key || 'global';

    if (globalRefreshWatchers.has(key)) {
        const existing = globalRefreshWatchers.get(key);
        existing.sync(config.initialItems || []);
        return existing;
    }

    const interval = Number(config.interval) || 15000;
    const getItems = config.getItems || ((payload) => Array.isArray(payload) ? payload : []);
    const getItemId = config.getItemId || ((item) => item?.id);
    const itemLabel = config.itemLabel || 'item';
    const anchorSelector = config.anchorSelector || '.table-card';
    const noticeId = getGlobalRefreshNoticeId(key);

    let pendingPayload = null;
    let timer = null;

    let knownIds = new Set(
        normalizeGlobalRefreshItems(config.initialItems || [], getItems)
            .map(getItemId)
            .filter((id) => id !== null && id !== undefined)
            .map(String)
    );

    const countLabel = (count) => `${itemLabel}${count === 1 ? '' : 's'}`;

    const showNotice = (count) => {
        let notice = document.getElementById(noticeId);

        if (!notice) {
            notice = document.createElement('div');
            notice.id = noticeId;
            notice.className = 'global-refresh-notice';

            const anchor = document.querySelector(anchorSelector);
            anchor?.parentNode?.insertBefore(notice, anchor);
        }

        const title = typeof config.title === 'function'
            ? config.title(count)
            : config.title || `${count} new ${countLabel(count)} available`;

        const subtitle = typeof config.subtitle === 'function'
            ? config.subtitle(count)
            : config.subtitle || `Refresh to see the latest ${countLabel(count)}.`;

        notice.innerHTML = `
            <div class="global-refresh-copy">
                <span class="global-refresh-icon">
                    <i class="fa-solid fa-rotate"></i>
                </span>

                <div>
                    <strong>${title}</strong>
                    <small>${subtitle}</small>
                </div>
            </div>

            <button type="button" class="global-refresh-btn">
                <i class="fa-solid fa-arrows-rotate"></i>
                Refresh
            </button>
        `;

        notice.querySelector('.global-refresh-btn')?.addEventListener('click', () => {
            controller.apply();
        });
    };

    const controller = {
        sync(source = []) {
            knownIds = new Set(
                normalizeGlobalRefreshItems(source, getItems)
                    .map(getItemId)
                    .filter((id) => id !== null && id !== undefined)
                    .map(String)
            );

            pendingPayload = null;
            removeGlobalRefreshNotice(key);
        },

        async check() {
            if (!config.url) return;

            try {
                const response = await fetch(config.url, {
                    cache: 'no-store',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) return;

                const payload = await response.json();
                const incoming = normalizeGlobalRefreshItems(payload, getItems);

                const newItems = incoming.filter((item) => {
                    const id = getItemId(item);
                    return id !== null && id !== undefined && !knownIds.has(String(id));
                });

                if (!newItems.length) return;

                pendingPayload = payload;
                showNotice(newItems.length);
            } catch (error) {
                console.warn(`${key} refresh check failed:`, error);
            }
        },

        async apply() {
            if (!pendingPayload) {
                return;
            }

            const payload =
                pendingPayload;

            try {
                if (
                    typeof config.onRefresh ===
                    'function'
                ) {
                    await config.onRefresh(
                        payload
                    );
                }

                this.sync(
                    payload
                );

                if (
                    config.toast !== false &&
                    typeof window.showToast ===
                    'function'
                ) {
                    window.showToast({
                        type:
                            config.toast?.type ||
                            'info',

                        title:
                            config.toast?.title ||
                            'Updated',

                        message:
                            config.toast?.message ||
                            'Latest records are now shown.',

                        duration:
                            config.toast?.duration ||
                            3500
                    });
                }

            } catch (error) {
                console.error(
                    `${key} refresh failed:`,
                    error
                );

                window.showToast?.({
                    type: 'error',
                    title: 'Refresh failed',
                    message:
                        'Unable to load the latest records.'
                });
            }
        },

        start() {
            if (timer) clearInterval(timer);
            timer = setInterval(() => this.check(), interval);
        },

        stop() {
            if (timer) clearInterval(timer);
            timer = null;
            removeGlobalRefreshNotice(key);
        }
    };

    globalRefreshWatchers.set(key, controller);

    if (config.autoStart !== false) {
        controller.start();
    }

    return controller;
}

function syncGlobalRefreshWatcher(key = 'global', source = []) {
    globalRefreshWatchers.get(key)?.sync(source);
}

window.initGlobalRefreshWatcher = initGlobalRefreshWatcher;
window.syncGlobalRefreshWatcher = syncGlobalRefreshWatcher;
window.removeGlobalRefreshNotice = removeGlobalRefreshNotice;