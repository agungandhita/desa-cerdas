<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Froala Editor JS -->
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/froala-editor@latest/js/froala_editor.pkgd.min.js">
</script>
<script>
    // Inisialisasi Froala Editor
    new FroalaEditor('.froala-editor', {
        // Konfigurasi editor
        toolbarButtons: ['bold', 'italic', 'underline', 'strikeThrough', 'paragraphFormat',
            'align', 'formatOL', 'formatUL', 'indent', 'outdent',
            'insertImage', 'insertLink', 'insertTable', 'undo', 'redo'
        ],
        placeholderText: 'Tulis konten di sini...',
        language: 'id'
    });

    // Toggle Profile Dropdown
    (function () {
        const toggleBtn = document.getElementById('profile-toggle');
        const dropdown = document.getElementById('profile-dropdown');

        if (!toggleBtn || !dropdown) return;

        const closeDropdown = () => {
            dropdown.classList.add('hidden');
            toggleBtn.setAttribute('aria-expanded', 'false');
        };

        const openDropdown = () => {
            dropdown.classList.remove('hidden');
            toggleBtn.setAttribute('aria-expanded', 'true');
        };

        toggleBtn.setAttribute('aria-haspopup', 'true');
        toggleBtn.setAttribute('aria-expanded', 'false');

        toggleBtn.addEventListener('click', function (e) {
            e.stopPropagation();
            if (dropdown.classList.contains('hidden')) {
                openDropdown();
            } else {
                closeDropdown();
            }
        });

        document.addEventListener('click', function (e) {
            if (!dropdown.classList.contains('hidden')) {
                const clickInside = dropdown.contains(e.target) || toggleBtn.contains(e.target);
                if (!clickInside) {
                    closeDropdown();
                }
            }
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                closeDropdown();
            }
        });
    })();
</script>
@stack('scripts')
