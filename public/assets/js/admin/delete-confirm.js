/**
 * Delete Confirmation using SweetAlert2
 * Admin Dashboard - PPID Kaltara
 */

/**
 * Show delete confirmation dialog
 * 
 * @param {Event} event Click event
 * @param {string} itemName Name of item to delete
 * @param {string} itemType Type of item (default: 'item')
 * @return {boolean} false to prevent default link behavior
 */
function confirmDelete(event, itemName, itemType = 'item') {
    event.preventDefault();
    const url = event.currentTarget.href;
    
    Swal.fire({
        title: 'Konfirmasi Hapus',
        html: `Apakah Anda yakin ingin menghapus ${itemType}:<br><strong>"${itemName}"</strong>?<br><br><small class="text-muted">Data yang sudah dihapus tidak dapat dikembalikan.</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="bi bi-trash"></i> Ya, Hapus!',
        cancelButtonText: '<i class="bi bi-x-circle"></i> Batal',
        focusCancel: true,
        customClass: {
            confirmButton: 'btn btn-danger',
            cancelButton: 'btn btn-secondary'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            // Show loading
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
            
            // Redirect to delete URL
            window.location.href = url;
        }
    });
    
    return false;
}

/**
 * Show success message after action
 * 
 * @param {string} message Success message
 * @param {string} title Title (optional)
 */
function showSuccessMessage(message, title = 'Berhasil!') {
    Swal.fire({
        icon: 'success',
        title: title,
        text: message,
        confirmButtonColor: '#1B5E20',
        confirmButtonText: 'OK'
    });
}

/**
 * Show error message
 * 
 * @param {string} message Error message
 * @param {string} title Title (optional)
 */
function showErrorMessage(message, title = 'Terjadi Kesalahan') {
    Swal.fire({
        icon: 'error',
        title: title,
        text: message,
        confirmButtonColor: '#d33',
        confirmButtonText: 'OK'
    });
}

/**
 * Show toast notification
 * 
 * @param {string} message Message to show
 * @param {string} type Type: success, error, warning, info
 */
function showToast(message, type = 'success') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer);
            toast.addEventListener('mouseleave', Swal.resumeTimer);
        }
    });
    
    Toast.fire({
        icon: type,
        title: message
    });
}
