/**
 * Logout Confirmation using SweetAlert2
 * Applies premium UI/UX for all logout actions across the project
 */

document.addEventListener('DOMContentLoaded', function() {
    // Select all links that contain 'logout' in their href
    const logoutLinks = document.querySelectorAll('a[href*="logout"]');
    
    logoutLinks.forEach(link => {
        // Remove any existing inline onclick attributes to prevent conflicts
        link.removeAttribute('onclick');
        
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const logoutUrl = this.href;
            
            Swal.fire({
                title: 'Konfirmasi Keluar',
                html: '<div style="font-size: 1.05rem; color: #333333;">Apakah Anda yakin ingin mengakhiri sesi ini?</div><div style="font-size: 0.9rem; margin-top: 8px;" class="text-muted">Anda harus masuk kembali untuk mengakses sistem.</div>',
                icon: 'question', // Using question icon for a softer, more professional look than warning
                iconColor: '#C9A84C', // Gold Accent
                showCancelButton: true,
                confirmButtonColor: '#1B5E20', // Institution Green
                cancelButtonColor: '#f4f6f9', // Background color for cancel button
                confirmButtonText: '<i class="bi bi-box-arrow-right me-2"></i>Ya, Keluar',
                cancelButtonText: '<span style="color: #333;">Batal</span>',
                reverseButtons: true, // Standard convention: primary action on the right
                padding: '2em',
                background: '#ffffff',
                backdrop: `
                    rgba(0,0,0,0.4)
                    backdrop-filter: blur(4px)
                `,
                customClass: {
                    popup: 'rounded-4 shadow-lg border-0',
                    confirmButton: 'btn btn-success px-4 py-2 rounded-3 shadow-sm',
                    cancelButton: 'btn btn-light px-4 py-2 rounded-3 border'
                },
                showClass: {
                    popup: 'swal2-show', // default swal animation, smooth and reliable
                    backdrop: 'swal2-backdrop-show'
                },
                hideClass: {
                    popup: 'swal2-hide',
                    backdrop: 'swal2-backdrop-hide'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show a polished loading state
                    Swal.fire({
                        title: 'Mengakhiri Sesi...',
                        html: '<span class="text-muted">Mengarahkan Anda keluar dengan aman.</span>',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        background: '#ffffff',
                        customClass: {
                            popup: 'rounded-4 shadow-lg border-0'
                        },
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Proceed to logout
                    window.location.href = logoutUrl;
                }
            });
        });
    });
});
