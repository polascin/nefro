(function () {
    'use strict';

    const timeoutSeconds = Number(window.npsSessionTimeoutSeconds || 0);
    if (!Number.isFinite(timeoutSeconds) || timeoutSeconds <= 0) {
        return;
    }

    const warningLeadSeconds = Math.min(300, Math.max(60, Math.floor(timeoutSeconds / 2)));
    let expiresAt = Date.now() + timeoutSeconds * 1000;
    let warningTimer = null;
    let countdownTimer = null;
    let lastAnnouncedMinutes = null;

    function init() {
        const panel = document.createElement('section');
        panel.id = 'sessionTimeoutWarning';
        panel.className = 'session-timeout-warning no-print';
        panel.hidden = true;
        panel.setAttribute('role', 'alertdialog');
        panel.setAttribute('aria-modal', 'false');
        panel.setAttribute('aria-labelledby', 'sessionTimeoutTitle');
        panel.setAttribute('aria-describedby', 'sessionTimeoutMessage');
        panel.innerHTML = `
            <h2 id="sessionTimeoutTitle">Relácia čoskoro vyprší</h2>
            <p id="sessionTimeoutMessage">Z bezpečnostných dôvodov sa neaktívna relácia automaticky ukončí.</p>
            <div class="session-timeout-warning__actions">
                <button type="button" class="btn-primary" id="sessionTimeoutExtend">Predĺžiť reláciu</button>
                <form action="logout.php" method="post" class="session-timeout-warning__logout-form">
                    <input type="hidden" name="csrf_token" id="sessionTimeoutLogoutToken">
                    <button type="submit" class="btn-secondary">Odhlásiť sa</button>
                </form>
            </div>
        `;
        document.body.appendChild(panel);

        const message = document.getElementById('sessionTimeoutMessage');
        const extendButton = document.getElementById('sessionTimeoutExtend');
        const logoutToken = document.getElementById('sessionTimeoutLogoutToken');
        if (logoutToken) {
            logoutToken.value = String(window.npsLogoutCsrfToken || '');
        }

        function updateCountdown() {
            const remainingSeconds = Math.max(0, Math.ceil((expiresAt - Date.now()) / 1000));
            if (remainingSeconds === 0) {
                clearInterval(countdownTimer);
                countdownTimer = null;
                extendButton.hidden = true;
                message.textContent = 'Relácia vypršala. Rozpracované údaje si pred prihlásením uložte mimo formulára.';
                return;
            }

            const remainingMinutes = Math.ceil(remainingSeconds / 60);
            if (remainingMinutes !== lastAnnouncedMinutes) {
                lastAnnouncedMinutes = remainingMinutes;
                const minuteLabel = remainingMinutes >= 2 && remainingMinutes <= 4 ? 'minúty' : 'minút';
                message.textContent = remainingMinutes > 1
                    ? `Relácia vyprší približne o ${remainingMinutes} ${minuteLabel}.`
                    : 'Relácia vyprší o menej ako minútu.';
            }
        }

        function showWarning() {
            lastAnnouncedMinutes = null;
            panel.hidden = false;
            extendButton.hidden = false;
            updateCountdown();
            countdownTimer = window.setInterval(updateCountdown, 1000);
            extendButton.focus();
        }

        function scheduleWarning() {
            if (warningTimer !== null) {
                clearTimeout(warningTimer);
            }
            if (countdownTimer !== null) {
                clearInterval(countdownTimer);
                countdownTimer = null;
            }
            panel.hidden = true;
            warningTimer = window.setTimeout(
                showWarning,
                Math.max(0, timeoutSeconds - warningLeadSeconds) * 1000
            );
        }

        extendButton.addEventListener('click', async () => {
            extendButton.disabled = true;
            extendButton.textContent = 'Predlžujem…';

            try {
                const response = await fetch('session_keepalive.php', {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'X-NPS-Keepalive': '1',
                        'X-NPS-Keepalive-Token': String(window.npsSessionKeepaliveToken || '')
                    }
                });
                const data = await response.json().catch(() => ({}));
                if (!response.ok || data.ok !== true) {
                    throw new Error('session-expired');
                }

                const renewedTimeout = Number(data.timeout_seconds || timeoutSeconds);
                expiresAt = Date.now() + renewedTimeout * 1000;
                scheduleWarning();
            } catch (_) {
                clearInterval(countdownTimer);
                countdownTimer = null;
                extendButton.hidden = true;
                message.textContent = 'Reláciu sa nepodarilo predĺžiť. Rozpracované údaje si pred prihlásením uložte mimo formulára.';
            } finally {
                extendButton.disabled = false;
                extendButton.textContent = 'Predĺžiť reláciu';
            }
        });

        scheduleWarning();
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init, { once: true });
    } else {
        init();
    }
})();
