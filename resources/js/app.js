// Custom Global Confirm Dialog Implementation for PorosData
document.addEventListener('DOMContentLoaded', () => {
    let activeForm = null;

    // Listen to form submissions in the capture phase to track which form triggered the submit
    document.addEventListener('submit', (e) => {
        activeForm = e.target;
    }, true);

    // Dynamic message parser to extract title, description, confirm button text, and action type
    function parseConfirmMessage(message) {
        let title = "Konfirmasi Tindakan";
        let desc = message;
        let confirmBtnText = "Ya, Lanjutkan";
        let actionType = "info"; // delete, cancel, approve, reject, info
        
        const lowerMsg = message.toLowerCase();
        
        if (lowerMsg.includes("hapus")) {
            actionType = "delete";
            confirmBtnText = "Ya, Hapus";
            
            if (message.includes("?")) {
                const parts = message.split("?");
                let part1 = parts[0].trim();
                let part2 = parts.slice(1).join("?").trim();
                
                title = part1;
                if (part2) {
                    desc = part2;
                } else {
                    desc = "Apakah Anda yakin ingin menghapus data ini? Tindakan ini tidak dapat dibatalkan.";
                }
            } else {
                title = "Hapus Data";
                desc = message;
            }
            
            // Refine titles based on page context or keywords
            if (lowerMsg.includes("guru")) title = "Hapus Data Guru";
            else if (lowerMsg.includes("siswa")) title = "Hapus Data Siswa";
            else if (lowerMsg.includes("admin")) title = "Hapus Data Admin";
            else if (lowerMsg.includes("wali kelas")) title = "Hapus Wali Kelas";
            else if (lowerMsg.includes("kelas")) title = "Hapus Kelas";
            else if (lowerMsg.includes("mata pelajaran") || lowerMsg.includes("mapel")) title = "Hapus Mata Pelajaran";
            else if (lowerMsg.includes("kategori")) title = "Hapus Kategori";
            else if (lowerMsg.includes("mitra")) title = "Hapus Mitra Perusahaan";
            else if (lowerMsg.includes("pembimbing")) title = "Hapus Pembimbing";
            else if (lowerMsg.includes("presensi")) title = "Hapus Presensi Siswa";
            else if (lowerMsg.includes("penempatan")) {
                title = "Batalkan Penempatan PKL";
                confirmBtnText = "Ya, Batalkan";
                actionType = "cancel";
            }
        } else if (lowerMsg.includes("batal")) {
            actionType = "cancel";
            title = "Batalkan Pengajuan";
            confirmBtnText = "Ya, Batalkan";
            desc = message;
        } else if (lowerMsg.includes("setuju")) {
            actionType = "approve";
            title = "Setujui Pengajuan";
            confirmBtnText = "Ya, Setujui";
            desc = message;
        } else if (lowerMsg.includes("tolak")) {
            actionType = "reject";
            title = "Tolak Pengajuan";
            confirmBtnText = "Ya, Tolak";
            desc = message;
        }
        
        // Capitalize title nicely
        if (title) {
            title = title.charAt(0).toUpperCase() + title.slice(1);
        }
        
        return { title, desc, confirmBtnText, actionType };
    }

    // Modal elements templates
    function getOrCreateConfirmModal() {
        let modal = document.getElementById('custom-confirm-modal');
        if (!modal) {
            modal = document.createElement('div');
            modal.id = 'custom-confirm-modal';
            modal.className = 'fixed inset-0 z-[99999] hidden items-center justify-center p-4';
            modal.innerHTML = `
                <!-- Backdrop -->
                <div id="custom-confirm-backdrop" class="absolute inset-0 custom-backdrop"></div>
                
                <!-- Modal Card -->
                <div id="custom-confirm-card" class="relative z-10 w-full max-w-md bg-white dark:bg-slate-900 rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-800/80 p-6 text-center transform">
                    <!-- Icon Container -->
                    <div id="custom-confirm-icon-wrapper" class="mx-auto flex items-center justify-center h-12 w-12 rounded-full mb-4 transition-all">
                        <!-- Dynamic SVG here -->
                    </div>
                    
                    <!-- Title -->
                    <h3 id="custom-confirm-title" class="text-base font-bold text-slate-900 dark:text-white mb-2 leading-snug"></h3>
                    
                    <!-- Description -->
                    <p id="custom-confirm-desc" class="text-slate-500 dark:text-slate-400 text-xs leading-relaxed mb-6 px-2"></p>
                    
                    <!-- Actions -->
                    <div class="flex justify-center gap-3">
                        <button type="button" id="custom-confirm-cancel-btn" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors cursor-pointer">Batal</button>
                        <button type="button" id="custom-confirm-action-btn" class="px-6 py-2.5 rounded-xl font-semibold text-xs transition-colors cursor-pointer"></button>
                    </div>
                </div>
            `;
            document.body.appendChild(modal);
        }
        return modal;
    }

    const deleteIconSvg = `<svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>`;
    const warningIconSvg = `<svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>`;
    const checkIconSvg = `<svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>`;
    const infoIconSvg = `<svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>`;

    function showCustomConfirm(message, form) {
        const { title, desc, confirmBtnText, actionType } = parseConfirmMessage(message);
        const modal = getOrCreateConfirmModal();
        
        const backdrop = document.getElementById('custom-confirm-backdrop');
        const card = document.getElementById('custom-confirm-card');
        const iconWrapper = document.getElementById('custom-confirm-icon-wrapper');
        const titleEl = document.getElementById('custom-confirm-title');
        const descEl = document.getElementById('custom-confirm-desc');
        const cancelBtn = document.getElementById('custom-confirm-cancel-btn');
        const actionBtn = document.getElementById('custom-confirm-action-btn');

        // Reset classes
        iconWrapper.className = 'mx-auto flex items-center justify-center h-12 w-12 rounded-full mb-4 border';
        actionBtn.className = 'px-6 py-2.5 rounded-xl font-semibold text-xs transition-colors cursor-pointer active:scale-[0.98]';

        // Setup styles based on actionType
        if (actionType === 'delete') {
            iconWrapper.innerHTML = deleteIconSvg;
            iconWrapper.classList.add('bg-rose-500/10', 'text-rose-500', 'border-rose-500/20');
            actionBtn.innerHTML = confirmBtnText;
            actionBtn.classList.add('bg-rose-600', 'hover:bg-rose-700', 'text-white');
        } else if (actionType === 'cancel' || actionType === 'reject') {
            iconWrapper.innerHTML = warningIconSvg;
            iconWrapper.classList.add('bg-amber-500/10', 'text-amber-500', 'border-amber-500/20');
            actionBtn.innerHTML = confirmBtnText;
            actionBtn.classList.add('bg-amber-600', 'hover:bg-amber-700', 'text-white');
        } else if (actionType === 'approve') {
            iconWrapper.innerHTML = checkIconSvg;
            iconWrapper.classList.add('bg-emerald-500/10', 'text-emerald-500', 'border-emerald-500/20');
            actionBtn.innerHTML = confirmBtnText;
            actionBtn.classList.add('bg-emerald-600', 'hover:bg-emerald-700', 'text-white');
        } else {
            iconWrapper.innerHTML = infoIconSvg;
            iconWrapper.classList.add('bg-indigo-500/10', 'text-indigo-500', 'border-indigo-500/20');
            actionBtn.innerHTML = confirmBtnText;
            actionBtn.classList.add('bg-indigo-600', 'hover:bg-indigo-700', 'text-white');
        }

        // Set text content
        titleEl.textContent = title;
        descEl.textContent = desc;

        // Show Modal
        modal.classList.remove('hidden');
        modal.classList.add('flex');

        // Force browser layout repaint/reflow to ensure transitions trigger immediately
        void modal.offsetHeight;

        // Apply transition-in classes
        // (Animations are handled globally by app.blade.php CSS rules on .fixed.inset-0:not(.hidden))

        // Clean event listeners by cloning
        const newCancelBtn = cancelBtn.cloneNode(true);
        const newActionBtn = actionBtn.cloneNode(true);
        cancelBtn.parentNode.replaceChild(newCancelBtn, cancelBtn);
        actionBtn.parentNode.replaceChild(newActionBtn, actionBtn);

        function closeModal(onComplete) {
            modal.classList.add('modal-closing');
            
            setTimeout(() => {
                modal.classList.remove('modal-closing');
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                
                if (typeof onComplete === 'function') {
                    onComplete();
                }
            }, 180); // match transition duration (0.18s) in app.blade.php
        }

        // Handle Cancel Click
        newCancelBtn.addEventListener('click', () => {
            closeModal();
        });

        // Handle Click Outside Modal Card
        backdrop.addEventListener('click', () => {
            closeModal();
        });

        // Handle Confirm Action Click
        newActionBtn.addEventListener('click', () => {
            closeModal(() => {
                if (form) {
                    form.submit();
                }
            });
        });
    }

    // Override the native window.confirm function
    const nativeConfirm = window.confirm;
    window.confirm = function(message) {
        if (activeForm) {
            showCustomConfirm(message, activeForm);
            // Clear activeForm so it doesn't leak or trigger twice
            const currentForm = activeForm;
            activeForm = null;
            return false; // Cancel synchronous form submission
        }
        return nativeConfirm(message);
    };
});
