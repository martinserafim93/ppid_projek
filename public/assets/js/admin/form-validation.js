/**
 * Form Validation & Submit Handling
 * Admin Dashboard - PPID Kaltara
 */

(function() {
    'use strict';
    
    /**
     * Initialize form validation on page load
     */
    document.addEventListener('DOMContentLoaded', function() {
        // Get all forms that need validation
        const forms = document.querySelectorAll('.needs-validation');
        
        // Loop over them and prevent submission if invalid
        Array.from(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                
                form.classList.add('was-validated');
            }, false);
        });
        
        // Handle form submit loading state
        const submitForms = document.querySelectorAll('form[data-loading="true"]');
        Array.from(submitForms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity()) {
                    showFormLoading(form);
                }
            });
        });
    });
    
    /**
     * Show loading state on form submit
     * 
     * @param {HTMLFormElement} form Form element
     */
    function showFormLoading(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        
        if (submitBtn) {
            // Store original content
            submitBtn.dataset.originalHtml = submitBtn.innerHTML;
            
            // Disable button and show loading
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Menyimpan...';
        }
        
        // Disable all inputs
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.disabled = true;
        });
    }
    
    /**
     * Reset form loading state
     * 
     * @param {HTMLFormElement} form Form element
     */
    window.resetFormLoading = function(form) {
        const submitBtn = form.querySelector('button[type="submit"]');
        
        if (submitBtn && submitBtn.dataset.originalHtml) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = submitBtn.dataset.originalHtml;
        }
        
        // Enable all inputs
        const inputs = form.querySelectorAll('input, select, textarea');
        inputs.forEach(input => {
            input.disabled = false;
        });
    };
    
    /**
     * Validate file size
     * 
     * @param {HTMLInputElement} input File input element
     * @param {number} maxSizeMB Maximum size in MB
     * @return {boolean} True if valid
     */
    window.validateFileSize = function(input, maxSizeMB) {
        if (input.files.length === 0) {
            return true;
        }
        
        const file = input.files[0];
        const fileSizeMB = file.size / 1024 / 1024;
        
        if (fileSizeMB > maxSizeMB) {
            showErrorMessage(`Ukuran file maksimal ${maxSizeMB} MB. File Anda: ${fileSizeMB.toFixed(2)} MB`);
            input.value = '';
            return false;
        }
        
        return true;
    };
    
    /**
     * Validate file type
     * 
     * @param {HTMLInputElement} input File input element
     * @param {Array} allowedTypes Array of allowed MIME types
     * @return {boolean} True if valid
     */
    window.validateFileType = function(input, allowedTypes) {
        if (input.files.length === 0) {
            return true;
        }
        
        const file = input.files[0];
        
        if (!allowedTypes.includes(file.type)) {
            showErrorMessage(`Tipe file tidak diizinkan. Tipe file Anda: ${file.type}`);
            input.value = '';
            return false;
        }
        
        return true;
    };
    
    /**
     * Show validation error for specific field
     * 
     * @param {HTMLInputElement} input Input element
     * @param {string} message Error message
     */
    window.showFieldError = function(input, message) {
        input.classList.add('is-invalid');
        
        // Create or update error message
        let feedback = input.nextElementSibling;
        if (!feedback || !feedback.classList.contains('invalid-feedback')) {
            feedback = document.createElement('div');
            feedback.classList.add('invalid-feedback');
            input.parentNode.insertBefore(feedback, input.nextSibling);
        }
        
        feedback.textContent = message;
    };
    
    /**
     * Clear validation error for specific field
     * 
     * @param {HTMLInputElement} input Input element
     */
    window.clearFieldError = function(input) {
        input.classList.remove('is-invalid');
        
        const feedback = input.nextElementSibling;
        if (feedback && feedback.classList.contains('invalid-feedback')) {
            feedback.remove();
        }
    };
    
})();
