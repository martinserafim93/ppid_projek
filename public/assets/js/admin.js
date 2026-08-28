/**
 * Admin Dashboard JavaScript
 * PPID Kalimantan Utara
 */

(function() {
    'use strict';

    // ===========================
    // DOM Elements
    // ===========================
    const sidebar = document.getElementById('sidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarBackdrop = document.getElementById('sidebarBackdrop');
    const userMenuToggle = document.getElementById('userMenuToggle');
    const userDropdown = document.getElementById('userDropdown');

    // ===========================
    // Sidebar Toggle (Mobile)
    // ===========================
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            toggleSidebar();
        });
    }

    if (sidebarBackdrop) {
        sidebarBackdrop.addEventListener('click', function() {
            closeSidebar();
        });
    }

    function toggleSidebar() {
        if (sidebar && sidebarBackdrop) {
            sidebar.classList.toggle('show');
            sidebarBackdrop.classList.toggle('show');
            
            // Save state to localStorage
            const isOpen = sidebar.classList.contains('show');
            localStorage.setItem('sidebarState', isOpen ? 'open' : 'closed');
        }
    }

    function closeSidebar() {
        if (sidebar && sidebarBackdrop) {
            sidebar.classList.remove('show');
            sidebarBackdrop.classList.remove('show');
            localStorage.setItem('sidebarState', 'closed');
        }
    }

    // ===========================
    // User Dropdown Menu
    // ===========================
    if (userMenuToggle) {
        userMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleUserDropdown();
        });
    }

    function toggleUserDropdown() {
        if (userDropdown) {
            userDropdown.classList.toggle('show');
        }
    }

    function closeUserDropdown() {
        if (userDropdown) {
            userDropdown.classList.remove('show');
        }
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(e) {
        if (userDropdown && !userDropdown.contains(e.target) && !userMenuToggle.contains(e.target)) {
            closeUserDropdown();
        }
    });

    // ===========================
    // Close Sidebar on ESC Key
    // ===========================
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' || e.keyCode === 27) {
            closeSidebar();
            closeUserDropdown();
        }
    });

    // ===========================
    // Auto-close Dropdown on Scroll
    // ===========================
    let scrollTimeout;
    window.addEventListener('scroll', function() {
        closeUserDropdown();
        
        // Clear existing timeout
        clearTimeout(scrollTimeout);
        
        // Set new timeout
        scrollTimeout = setTimeout(function() {
            // Can add additional logic here if needed
        }, 100);
    });

    // ===========================
    // Restore Sidebar State (Mobile Only)
    // ===========================
    function restoreSidebarState() {
        // Only restore state on mobile
        if (window.innerWidth < 768) {
            const savedState = localStorage.getItem('sidebarState');
            if (savedState === 'open' && sidebar && sidebarBackdrop) {
                sidebar.classList.add('show');
                sidebarBackdrop.classList.add('show');
            }
        }
    }

    // ===========================
    // Handle Window Resize
    // ===========================
    let resizeTimeout;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimeout);
        resizeTimeout = setTimeout(function() {
            // Close sidebar on desktop
            if (window.innerWidth >= 768) {
                closeSidebar();
            }
        }, 250);
    });

    // ===========================
    // Smooth Scroll Behavior
    // ===========================
    document.documentElement.style.scrollBehavior = 'smooth';

    // ===========================
    // Active Menu Highlight
    // ===========================
    function highlightActiveMenu() {
        const currentPath = window.location.pathname;
        const navLinks = document.querySelectorAll('.sidebar .nav-link');
        
        navLinks.forEach(function(link) {
            const href = link.getAttribute('href');
            if (href && currentPath.includes(href.split('/').pop())) {
                link.classList.add('active');
            }
        });
    }

    // ===========================
    // Stat Cards Animation on Scroll
    // ===========================
    function animateStatCards() {
        const statCards = document.querySelectorAll('.stat-card');
        
        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '0';
                    entry.target.style.transform = 'translateY(20px)';
                    
                    setTimeout(function() {
                        entry.target.style.transition = 'all 0.5s ease';
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }, 100);
                    
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.1
        });
        
        statCards.forEach(function(card) {
            observer.observe(card);
        });
    }

    // ===========================
    // Format Numbers with Animation (Optional)
    // ===========================
    function animateNumbers() {
        const statNumbers = document.querySelectorAll('.stat-card h3');
        
        statNumbers.forEach(function(element) {
            const text = element.textContent.replace(/\./g, '');
            const targetNumber = parseInt(text) || 0;
            
            if (targetNumber === 0) return;
            
            let currentNumber = 0;
            const increment = Math.ceil(targetNumber / 30);
            const duration = 1000; // 1 second
            const stepTime = duration / 30;
            
            const timer = setInterval(function() {
                currentNumber += increment;
                
                if (currentNumber >= targetNumber) {
                    currentNumber = targetNumber;
                    clearInterval(timer);
                }
                
                // Format with thousand separator
                element.textContent = currentNumber.toLocaleString('id-ID');
            }, stepTime);
        });
    }

    // ===========================
    // Initialize on DOM Ready
    // ===========================
    document.addEventListener('DOMContentLoaded', function() {
        // Restore sidebar state (mobile only)
        restoreSidebarState();
        
        // Highlight active menu
        highlightActiveMenu();
        
        // Animate stat cards on scroll
        if (typeof IntersectionObserver !== 'undefined') {
            animateStatCards();
        }
        
        // Optional: Animate numbers (uncomment to enable)
        // animateNumbers();
    });

    // ===========================
    // Prevent Default on Placeholder Links
    // ===========================
    document.addEventListener('click', function(e) {
        const target = e.target.closest('a');
        if (target && target.getAttribute('href') === '#') {
            e.preventDefault();
        }
    });

    // ===========================
    // Console Welcome Message
    // ===========================
    console.log('%c PPID Kaltara Admin Dashboard ', 'background: #1B5E20; color: white; font-size: 14px; padding: 5px 10px; border-radius: 3px;');
    console.log('%c Dashboard loaded successfully! ', 'color: #4CAF50; font-size: 12px;');

})();
