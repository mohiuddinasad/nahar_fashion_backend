@if (session('success') || session('error') || session('warning') || session('info'))

    <style>
        .toast-item {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border-radius: 8px;
            padding: 12px 14px;
            min-width: 260px;
            max-width: 320px;
            position: relative;
            overflow: hidden;
            opacity: 0;
            transform: translateX(30px);
            transition: opacity 0.35s ease, transform 0.35s ease;
        }

        .toast-item.show {
            opacity: 1;
            transform: translateX(0);
        }

        .toast-item.hide {
            opacity: 0;
            transform: translateX(30px);
        }

        .toast-icon {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
            margin-top: 1px;
        }

        .toast-body {
            flex: 1;
        }

        .toast-title {
            font-size: 12px;
            font-weight: 700;
            margin: 0 0 2px 0;
            letter-spacing: 0.3px;
        }

        .toast-msg {
            font-size: 11.5px;
            margin: 0;
            opacity: 0.85;
            line-height: 1.4;
        }

        .toast-close {
            background: none;
            border: none;
            font-size: 16px;
            cursor: pointer;
            line-height: 1;
            padding: 0;
            opacity: 0.5;
            margin-top: -1px;
            transition: opacity 0.2s;
        }

        .toast-close:hover {
            opacity: 1;
        }

        .toast-progress {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            width: 100%;
            transform-origin: left;
            animation: toast-shrink 4s linear forwards;
            border-radius: 0 0 8px 8px;
        }

        @keyframes toast-shrink {
            from {
                transform: scaleX(1);
            }

            to {
                transform: scaleX(0);
            }
        }

        /* success */
        .toast-success {
            background: #f0fdf4;
        }

        .toast-success .toast-title {
            color: #15803d;
        }

        .toast-success .toast-msg {
            color: #166534;
        }

        .toast-success .toast-close {
            color: #15803d;
        }

        .toast-success .toast-progress {
            background: #22c55e;
        }

        /* error */
        .toast-error {
            background: #fef2f2;
        }

        .toast-error .toast-title {
            color: #b91c1c;
        }

        .toast-error .toast-msg {
            color: #991b1b;
        }

        .toast-error .toast-close {
            color: #b91c1c;
        }

        .toast-error .toast-progress {
            background: #ef4444;
        }

        /* warning */
        .toast-warning {
            background: #fffbeb;
        }

        .toast-warning .toast-title {
            color: #b45309;
        }

        .toast-warning .toast-msg {
            color: #92400e;
        }

        .toast-warning .toast-close {
            color: #b45309;
        }

        .toast-warning .toast-progress {
            background: #f59e0b;
        }

        /* info */
        .toast-info {
            background: #eff6ff;
        }

        .toast-info .toast-title {
            color: #1d4ed8;
        }

        .toast-info .toast-msg {
            color: #1e40af;
        }

        .toast-info .toast-close {
            color: #1d4ed8;
        }

        .toast-info .toast-progress {
            background: #3b82f6;
        }
    </style>

    <div id="toast-container"
        style="position:fixed;top:20px;right:20px;z-index:9999;display:flex;flex-direction:column;gap:8px;">

        @if (session('success'))
            <div class="toast-item toast-success">
                <svg class="toast-icon" fill="none" stroke="#16a34a" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <div class="toast-body">
                    <p class="toast-title">Success</p>
                    <p class="toast-msg">{{ session('success') }}</p>
                </div>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
                <div class="toast-progress"></div>
            </div>
        @endif

        @if (session('error'))
            <div class="toast-item toast-error">
                <svg class="toast-icon" fill="none" stroke="#dc2626" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <div class="toast-body">
                    <p class="toast-title">Error</p>
                    <p class="toast-msg">{{ session('error') }}</p>
                </div>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
                <div class="toast-progress"></div>
            </div>
        @endif

        @if (session('warning'))
            <div class="toast-item toast-warning">
                <svg class="toast-icon" fill="none" stroke="#d97706" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z" />
                </svg>
                <div class="toast-body">
                    <p class="toast-title">Warning</p>
                    <p class="toast-msg">{{ session('warning') }}</p>
                </div>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
                <div class="toast-progress"></div>
            </div>
        @endif

        @if (session('info'))
            <div class="toast-item toast-info">
                <svg class="toast-icon" fill="none" stroke="#2563eb" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20A10 10 0 0012 2z" />
                </svg>
                <div class="toast-body">
                    <p class="toast-title">Info</p>
                    <p class="toast-msg">{{ session('info') }}</p>
                </div>
                <button class="toast-close" onclick="closeToast(this)">&times;</button>
                <div class="toast-progress"></div>
            </div>
        @endif

    </div>

    <script>
        function closeToast(btn) {
            const toast = btn.closest('.toast-item');
            toast.classList.add('hide');
            setTimeout(() => toast.remove(), 350);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toasts = document.querySelectorAll('.toast-item');
            toasts.forEach(function(toast) {
                // Slide in
                setTimeout(() => toast.classList.add('show'), 50);

                // Auto dismiss after 4s
                setTimeout(function() {
                    toast.classList.add('hide');
                    setTimeout(() => toast.remove(), 350);
                }, 4000);
            });
        });
    </script>

@endif
