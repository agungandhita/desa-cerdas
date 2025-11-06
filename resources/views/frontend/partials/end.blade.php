{{-- <script src="{{ asset('adminBumbu/sidebar.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

{{-- Loading Overlay --}}
<div id="loading-overlay" class="fixed inset-0 bg-white/90 backdrop-blur-sm z-50 flex items-center justify-center transition-opacity duration-300">
    <div class="text-center">
        <div class="loading-spinner w-12 h-12 border-4 border-blue-200 border-t-blue-600 rounded-full animate-spin mx-auto mb-4"></div>
        <p class="text-gray-600 text-sm font-medium">Memuat halaman...</p>
    </div>
</div>

{{-- Back to Top Button --}}
<button id="back-to-top" class="fixed bottom-6 right-6 w-12 h-12 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg hover:shadow-xl transition-all duration-300 opacity-0 invisible z-40 group" aria-label="Kembali ke atas">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mx-auto transform group-hover:-translate-y-0.5 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18" />
    </svg>
</button>

{{-- Scripts --}}
{{-- jQuery (if needed for legacy components) --}}
@if(config('app.jquery_enabled', false))
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" 
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" 
            crossorigin="anonymous" defer></script>
@endif

{{-- Alpine.js for interactive components --}}
<script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

{{-- Custom Scripts Stack --}}
@stack('scripts')

{{-- Global JavaScript --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hide loading overlay
    const loadingOverlay = document.getElementById('loading-overlay');
    const loadingIndicator = document.getElementById('loading-indicator');
    if (loadingOverlay) {
        setTimeout(() => {
            loadingOverlay.style.opacity = '0';
            setTimeout(() => {
                loadingOverlay.style.display = 'none';
            }, 300);
        }, 500);
    }

    // Hide initial loading indicator from start partial (if present)
    if (loadingIndicator) {
        setTimeout(() => {
            loadingIndicator.style.opacity = '0';
            setTimeout(() => {
                loadingIndicator.style.display = 'none';
            }, 300);
        }, 500);
    }

    // Back to top functionality
    const backToTopBtn = document.getElementById('back-to-top');
    if (backToTopBtn) {
        // Show/hide button based on scroll position
        function toggleBackToTop() {
            if (window.pageYOffset > 300) {
                backToTopBtn.classList.remove('opacity-0', 'invisible');
                backToTopBtn.classList.add('opacity-100', 'visible');
            } else {
                backToTopBtn.classList.add('opacity-0', 'invisible');
                backToTopBtn.classList.remove('opacity-100', 'visible');
            }
        }

        // Smooth scroll to top
        backToTopBtn.addEventListener('click', function() {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Throttled scroll event
        let ticking = false;
        function handleScroll() {
            if (!ticking) {
                requestAnimationFrame(() => {
                    toggleBackToTop();
                    ticking = false;
                });
                ticking = true;
            }
        }

        window.addEventListener('scroll', handleScroll, { passive: true });
    }

    // Lazy loading for images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.classList.remove('lazy');
                        observer.unobserve(img);
                    }
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // External links security
    document.querySelectorAll('a[href^="http"]:not([href*="' + window.location.hostname + '"])').forEach(link => {
        link.setAttribute('rel', 'noopener noreferrer');
        link.setAttribute('target', '_blank');
    });

    // Form validation enhancement
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            const submitBtn = form.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                submitBtn.disabled = true;
                const originalText = submitBtn.textContent;
                submitBtn.innerHTML = '<svg class="animate-spin -ml-1 mr-3 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>Memproses...';
                
                // Re-enable after 5 seconds as fallback
                setTimeout(() => {
                    submitBtn.disabled = false;
                    submitBtn.textContent = originalText;
                }, 5000);
            }
        });
    });

    // Notification auto-hide
    document.querySelectorAll('.alert, .notification').forEach(notification => {
        if (notification.dataset.autoHide !== 'false') {
            setTimeout(() => {
                notification.style.opacity = '0';
                notification.style.transform = 'translateY(-20px)';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }, 5000);
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Performance monitoring (optional)
    if ('performance' in window && 'getEntriesByType' in performance) {
        window.addEventListener('load', () => {
            setTimeout(() => {
                const perfData = performance.getEntriesByType('navigation')[0];
                if (perfData && perfData.loadEventEnd > 3000) {
                    console.warn('Page load time is slow:', perfData.loadEventEnd + 'ms');
                }
            }, 0);
        });
    }
});

// Service Worker registration (if available)
if ('serviceWorker' in navigator && '{{ config("app.env") }}' === 'production') {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('SW registered: ', registration);
            })
            .catch(registrationError => {
                console.log('SW registration failed: ', registrationError);
            });
    });
}

// Global error handling
window.addEventListener('error', function(e) {
    console.error('Global error:', e.error);
    // You can send error reports to your logging service here
});

// Unhandled promise rejection handling
window.addEventListener('unhandledrejection', function(e) {
    console.error('Unhandled promise rejection:', e.reason);
    // You can send error reports to your logging service here
});
</script>

{{-- Additional Styles for Enhanced UX --}}
<style>
/* Loading spinner animation */
@keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-spinner {
    animation: spin 1s linear infinite;
}

/* Lazy loading placeholder */
img.lazy {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}

/* Smooth transitions for better UX */
* {
    scroll-behavior: smooth;
}

/* Focus styles for accessibility */
button:focus,
a:focus,
input:focus,
textarea:focus,
select:focus {
    outline: 2px solid #3B82F6;
    outline-offset: 2px;
}

/* Print styles */
@media print {
    .no-print,
    #back-to-top,
    #loading-overlay,
    nav,
    footer {
        display: none !important;
    }
    
    body {
        font-size: 12pt;
        line-height: 1.4;
    }
    
    h1, h2, h3, h4, h5, h6 {
        page-break-after: avoid;
    }
    
    img {
        max-width: 100% !important;
        height: auto !important;
    }
}

/* Reduced motion for accessibility */
@media (prefers-reduced-motion: reduce) {
    *,
    *::before,
    *::after {
        animation-duration: 0.01ms !important;
        animation-iteration-count: 1 !important;
        transition-duration: 0.01ms !important;
        scroll-behavior: auto !important;
    }
}
</style>

</body>
</html>
