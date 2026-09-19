/**
 * Image Preview Handler
 * Admin Dashboard - PPID Kaltara
 * 
 * Auto-detects file inputs and shows image preview before upload.
 * Also shows file name and size info for non-image files.
 */

(function() {
    'use strict';

    document.addEventListener('DOMContentLoaded', function() {
        // Auto-bind to all file inputs with data-preview attribute
        const fileInputs = document.querySelectorAll('input[type="file"][data-preview]');
        fileInputs.forEach(function(input) {
            initPreview(input, input.getAttribute('data-preview'));
        });

        // Auto-bind to all file inputs with accept="image/*"
        const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
        imageInputs.forEach(function(input) {
            if (!input.hasAttribute('data-preview')) {
                // Create preview container after the input
                const previewId = 'preview_' + (input.id || input.name || Math.random().toString(36).substr(2, 9));
                let previewContainer = document.getElementById(previewId);
                
                if (!previewContainer) {
                    previewContainer = document.createElement('div');
                    previewContainer.id = previewId;
                    previewContainer.className = 'mt-2';
                    
                    // Insert after the input or after its parent .input-group
                    const insertAfter = input.closest('.input-group') || input;
                    insertAfter.parentNode.insertBefore(previewContainer, insertAfter.nextSibling);
                }
                
                initPreview(input, previewId);
            }
        });
    });

    /**
     * Initialize preview functionality for a file input
     * 
     * @param {HTMLInputElement} input File input element
     * @param {string} previewId ID of preview container element
     */
    function initPreview(input, previewId) {
        input.addEventListener('change', function() {
            const previewEl = document.getElementById(previewId);
            if (!previewEl) return;

            if (this.files.length === 0) {
                previewEl.innerHTML = '';
                return;
            }

            const file = this.files[0];
            const fileSizeMB = (file.size / 1024 / 1024).toFixed(2);
            const fileSizeKB = (file.size / 1024).toFixed(1);
            const sizeLabel = file.size >= 1048576 ? fileSizeMB + ' MB' : fileSizeKB + ' KB';

            if (file.type.startsWith('image/')) {
                // Image preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewEl.innerHTML = `
                        <div class="border rounded p-2 bg-light d-inline-block">
                            <img src="${e.target.result}" class="img-thumbnail border-0 bg-transparent" 
                                 style="max-height: 180px; max-width: 100%;" alt="Preview">
                            <div class="mt-1 small text-muted">
                                <i class="bi bi-image me-1"></i>${escapeHtml(file.name)} (${sizeLabel})
                            </div>
                        </div>
                    `;
                };
                reader.readAsDataURL(file);
            } else {
                // Non-image file info
                const iconClass = getFileIcon(file.name);
                previewEl.innerHTML = `
                    <div class="alert alert-info py-2 mb-0 small">
                        <i class="bi ${iconClass} me-2"></i>
                        <strong>${escapeHtml(file.name)}</strong> (${sizeLabel})
                    </div>
                `;
            }
        });
    }

    /**
     * Get Bootstrap icon class based on file extension
     * 
     * @param {string} filename File name
     * @return {string} Bootstrap icon class
     */
    function getFileIcon(filename) {
        const ext = filename.split('.').pop().toLowerCase();
        const icons = {
            'pdf': 'bi-file-earmark-pdf-fill text-danger',
            'doc': 'bi-file-earmark-word-fill text-primary',
            'docx': 'bi-file-earmark-word-fill text-primary',
            'xls': 'bi-file-earmark-excel-fill text-success',
            'xlsx': 'bi-file-earmark-excel-fill text-success',
            'ppt': 'bi-file-earmark-ppt-fill text-warning',
            'pptx': 'bi-file-earmark-ppt-fill text-warning',
            'zip': 'bi-file-earmark-zip-fill text-secondary',
            'rar': 'bi-file-earmark-zip-fill text-secondary',
        };
        return icons[ext] || 'bi-file-earmark-fill';
    }

    /**
     * Escape HTML special characters
     * 
     * @param {string} text Text to escape
     * @return {string} Escaped text
     */
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }

    // Expose initPreview globally for manual use
    window.initImagePreview = initPreview;

})();
