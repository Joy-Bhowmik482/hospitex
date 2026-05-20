<div id="toast-container" aria-live="polite" class="fixed inset-x-0 top-0 z-[9999] flex flex-col items-center gap-3 px-3 pointer-events-none"></div>

<style>
    #toast-container {
        width: 100%;
        max-width: 100%;
        left: 50%;
        transform: translateX(-50%);
    }

    .toast-enter {
        transform: translateY(-16px);
        opacity: 0;
    }

    .toast-enter-active {
        transform: translateY(0);
        opacity: 1;
        transition: transform 280ms ease, opacity 280ms ease;
    }

    .toast-exit {
        opacity: 1;
    }

    .toast-exit-active {
        opacity: 0;
        transition: opacity 240ms ease;
    }
</style>

<script>
    (function() {
        const types = {
            success: {
                title: 'Success',
                bg: 'bg-emerald-600/95',
                border: 'border-emerald-300/40',
                icon: '✔️'
            },
            error: {
                title: 'Error',
                bg: 'bg-rose-600/95',
                border: 'border-rose-300/40',
                icon: '⚠️'
            },
            warning: {
                title: 'Warning',
                bg: 'bg-amber-500/95',
                border: 'border-amber-300/40',
                icon: '⚠️'
            },
            info: {
                title: 'Info',
                bg: 'bg-sky-600/95',
                border: 'border-sky-300/40',
                icon: 'ℹ️'
            }
        };

        const container = document.getElementById('toast-container');
        if (!container) {
            return;
        }

        function updateContainerTop() {
            const navbar = document.querySelector('nav.fixed.top-0, header.sticky.top-0');
            const spacing = 16;
            if (navbar) {
                const rect = navbar.getBoundingClientRect();
                container.style.top = `${rect.height + spacing}px`;
            } else {
                container.style.top = `${spacing}px`;
            }
        }

        function showToast(type, message, subtitle) {
            const config = types[type] || types.info;
            const toast = document.createElement('div');
            toast.className = `toast-enter pointer-events-auto w-full max-w-[600px] rounded-2xl shadow-2xl ${config.bg} ${config.border} border ring-1 ring-black/10 overflow-hidden`;
            toast.innerHTML = `
                <div class="flex items-start gap-3 p-4">
                    <div class="text-xl leading-none">${config.icon}</div>
                    <div class="min-w-0 flex-1">
                        <div class="flex items-start justify-between gap-3">
                            <p class="text-sm font-semibold text-white">${config.title}</p>
                            <button type="button" class="toast-close text-white/90 hover:text-white transition text-base leading-none">×</button>
                        </div>
                        <p class="mt-2 text-sm text-white/95 break-words">${message}</p>
                        ${subtitle ? `<p class="mt-1 text-xs text-white/80">${subtitle}</p>` : ''}
                    </div>
                </div>
            `;

            let timeout = setTimeout(() => removeToast(toast), 4500);

            toast.querySelector('.toast-close').addEventListener('click', () => {
                clearTimeout(timeout);
                removeToast(toast);
            });

            toast.addEventListener('mouseenter', () => clearTimeout(timeout));
            toast.addEventListener('mouseleave', () => {
                timeout = setTimeout(() => removeToast(toast), 2000);
            });

            container.appendChild(toast);
            requestAnimationFrame(() => {
                toast.classList.remove('toast-enter');
            });
        }

        function removeToast(toast) {
            toast.classList.add('toast-exit');
            toast.classList.add('toast-exit-active');
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.parentNode.removeChild(toast);
                }
            }, 240);
        }

        window.addEventListener('resize', updateContainerTop);
        updateContainerTop();

        const flash = {
            success: @json(session('success')),
            error: @json(session('error') ?? session('danger')),
            warning: @json(session('warning')),
            info: @json(session('info') ?? session('status') ?? session('message'))
        };

        Object.entries(flash).forEach(([type, message]) => {
            if (message) {
                showToast(type, message);
            }
        });

        @if ($errors->any())
            const validationMessages = @json($errors->all());
            if (validationMessages.length > 0) {
                const firstMessage = validationMessages[0];
                const subtitle = validationMessages.length > 1 ? `${validationMessages.length} validation errors occurred` : '';
                showToast('error', firstMessage, subtitle);
            }
        @endif

    })();
</script>
