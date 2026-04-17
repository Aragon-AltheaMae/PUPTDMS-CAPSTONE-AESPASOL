function escapeHtml(value) {
    const div = document.createElement('div');
    div.textContent = value ?? '';
    return div.innerHTML;
}

function getNotifButton() {
    return document.querySelector('#notifBtn');
}

function getBadge() {
    return document.querySelector('[data-notif-badge]');
}

function syncBellBadge(unreadCount) {
    const notifBtn = getNotifButton();
    if (!notifBtn) return;

    let badge = getBadge();

    if (unreadCount > 0) {
        if (!badge) {
            badge = document.createElement('span');
            badge.className = 'notif-badge';
            badge.setAttribute('data-notif-badge', '');
            notifBtn.appendChild(badge);
        }

       badge.textContent = unreadCount > 9 ? '9+' : unreadCount;
        badge.style.display = 'inline-flex';
    } else if (badge) {
        badge.textContent = '0';
        badge.style.display = 'none';
    }
}

function updateNotificationCounts(unreadDelta = 0, totalDelta = 0) {
    const unreadPill = document.querySelector('[data-notif-unread-pill]');
    const totalPill = document.querySelector('[data-notif-total-pill]');
    const allTab = document.querySelector('[data-notif-tab-count="all"]');
    const unreadTab = document.querySelector('[data-notif-tab-count="unread"]');
    const readTab = document.querySelector('[data-notif-tab-count="read"]');

    let currentUnread = parseInt(unreadTab?.textContent?.trim() || '0', 10);
    let currentTotal = parseInt(allTab?.textContent?.trim() || '0', 10);

    currentUnread += unreadDelta;
    currentTotal += totalDelta;

    if (currentUnread < 0) currentUnread = 0;
    if (currentTotal < 0) currentTotal = 0;

    const currentRead = Math.max(currentTotal - currentUnread, 0);

    if (unreadPill) unreadPill.textContent = `${currentUnread} unread`;
    if (totalPill) totalPill.textContent = `${currentTotal} total`;
    if (allTab) allTab.textContent = currentTotal;
    if (unreadTab) unreadTab.textContent = currentUnread;
    if (readTab) readTab.textContent = currentRead;

    syncBellBadge(currentUnread);
}

function removeEmptyState() {
    const emptyState = document.querySelector('.header-notif-empty');
    if (emptyState) {
        emptyState.remove();
    }
}

function prependNotificationItem(notification) {
    const notifBody = document.querySelector('.header-notif-body');
    if (!notifBody) return;

    removeEmptyState();

    const title = notification.title ?? 'Notification';
    const message = notification.message ?? '';
    const url = notification.url ?? '#';
    const icon = notification.icon ?? 'fa-bell';
    const createdAtLabel = notification.created_at_label ?? 'Just now';

    const item = document.createElement('div');
    item.className = 'header-notif-item is-unread';
    item.setAttribute('data-notif-state', 'unread');
    item.setAttribute('data-notif-item', '');

    item.innerHTML = `
        <div class="header-notif-item-icon">
            <i class="fa-solid ${escapeHtml(icon)}"></i>
        </div>

        <div class="header-notif-item-content">
            <div class="header-notif-item-top">
                ${
                    url && url !== '#'
                        ? `<a href="${escapeHtml(url)}" class="header-notif-item-title">${escapeHtml(title)}</a>`
                        : `<span class="header-notif-item-title">${escapeHtml(title)}</span>`
                }
                <span class="header-notif-item-time">${escapeHtml(createdAtLabel)}</span>
            </div>

            ${message ? `<div class="header-notif-item-message">${escapeHtml(message)}</div>` : ''}

            <div class="header-notif-item-actions">
                ${
                    url && url !== '#'
                        ? `<a href="${escapeHtml(url)}" class="header-notif-link-action">Open</a>`
                        : ''
                }
            </div>
        </div>

        <span class="header-notif-unread-dot" aria-hidden="true"></span>
    `;

    const filterEmpty = notifBody.querySelector('.header-notif-filter-empty');

    if (filterEmpty) {
        notifBody.insertBefore(item, filterEmpty);
    } else {
        notifBody.prepend(item);
    }

    updateNotificationCounts(1, 1);
}

document.addEventListener('DOMContentLoaded', () => {
    const userIdMeta = document.querySelector('meta[name="auth-user-id"]');

    if (!userIdMeta || !window.Echo) return;

    const userId = userIdMeta.getAttribute('content');
    if (!userId) return;

    window.Echo.private(`App.Models.User.${userId}`)
        .notification((notification) => {
            prependNotificationItem(notification);
        });
});