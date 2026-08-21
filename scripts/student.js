    // =========================================================
    // MOBILE SIDEBAR TOGGLE
    // =========================================================
    document.addEventListener('DOMContentLoaded', () => {
        const sidebar = document.getElementById('dashboardSidebar');
        const overlay = document.getElementById('sidebarOverlay');
        const toggleBtn = document.getElementById('mobileToggle');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        if (toggleBtn) {
            toggleBtn.addEventListener('click', (e) => {
                e.stopPropagation();
                if (sidebar.classList.contains('open')) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });
        }

        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                if (sidebar.classList.contains('open')) closeSidebar();
                closeModal('addModal');
                closeModal('editModal');
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth > 820 && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });
    });

    // =========================================================
    // MODAL FUNCTIONS
    // =========================================================

    function openModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.add('active');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeModal(id) {
        const modal = document.getElementById(id);
        if (modal) {
            modal.classList.remove('active');
            document.body.style.overflow = '';
        }
    }

    // Close modal when clicking overlay
    document.querySelectorAll('.modal-overlay').forEach(overlay => {
        overlay.addEventListener('click', (e) => {
            if (e.target === overlay) {
                overlay.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
    });

    // =========================================================
    // EDIT MODAL - Load Student Data via AJAX
    // =========================================================

    function openEditModal(event, studentId) {
        event.preventDefault();

        // Try AJAX first
        fetch('get_student.php?id=' + studentId)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('edit_id').value = data.id;
                    document.getElementById('edit_name').value = data.name;
                    document.getElementById('edit_department').value = data.department;
                    document.getElementById('edit_student_id').value = data.student_id;
                    document.getElementById('edit_email').value = data.email || '';
                    document.getElementById('edit_phone').value = data.phone || '';
                    document.getElementById('edit_enrollment_date').value = data.enrollment_date;
                    document.getElementById('edit_status').value = data.status;
                    openModal('editModal');
                } else {
                    // Fallback: load via URL
                    window.location.href = 'students.php?edit=' + studentId;
                }
            })
            .catch(() => {
                // Fallback on network error
                window.location.href = 'students.php?edit=' + studentId;
            });
    }

    // =========================================================
    // PHP FALLBACK: If edit parameter is in URL, open modal with data
    // =========================================================

    <?php if ($edit_student && !empty($edit_student)): ?>
        document.addEventListener('DOMContentLoaded', () => {
            // Remove the edit parameter from URL without reload
            const url = new URL(window.location);
            url.searchParams.delete('edit');
            window.history.replaceState({}, document.title, url);

            // Populate and open modal
            document.getElementById('edit_id').value = <?php echo (int)$edit_student['id']; ?>;
            document.getElementById('edit_name').value = <?php echo json_encode($edit_student['name']); ?>;
            document.getElementById('edit_department').value = <?php echo json_encode($edit_student['department']); ?>;
            document.getElementById('edit_student_id').value = <?php echo json_encode($edit_student['student_id']); ?>;
            document.getElementById('edit_email').value = <?php echo json_encode($edit_student['email'] ?? ''); ?>;
            document.getElementById('edit_phone').value = <?php echo json_encode($edit_student['phone'] ?? ''); ?>;
            document.getElementById('edit_enrollment_date').value = <?php echo json_encode($edit_student['enrollment_date']); ?>;
            document.getElementById('edit_status').value = <?php echo json_encode($edit_student['status']); ?>;
            openModal('editModal');
        });
    <?php endif; ?>

    // =========================================================
    // DELETE CONFIRMATION
    // =========================================================

    function confirmDelete(event, studentName) {
        event.preventDefault();
        if (confirm('Are you sure you want to delete "' + studentName + '"? This action cannot be undone.')) {
            window.location.href = event.currentTarget.href;
        }
        return false;
    }

    // =========================================================
    // BULK DELETE FUNCTIONS
    // =========================================================

    function toggleAllCheckboxes() {
        const selectAll = document.getElementById('selectAll');
        const checkboxes = document.querySelectorAll('.student-checkbox');
        checkboxes.forEach(cb => {
            cb.checked = selectAll.checked;
        });
        updateBulkDeleteButton();
    }

    function updateBulkDeleteButton() {
        const checkboxes = document.querySelectorAll('.student-checkbox:checked');
        const btn = document.getElementById('bulkDeleteBtn');
        const selectedIdsInput = document.getElementById('selectedIdsInput');

        if (checkboxes.length > 0) {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-trash"></i> Delete Selected (' + checkboxes.length + ')';
            // Collect selected IDs
            const ids = [];
            checkboxes.forEach(cb => {
                ids.push(cb.dataset.id);
            });
            selectedIdsInput.value = ids.join(',');
        } else {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-trash"></i> Delete Selected';
            selectedIdsInput.value = '';
        }
    }

    function confirmBulkDelete() {
        const checkboxes = document.querySelectorAll('.student-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one student to delete.');
            return false;
        }
        return confirm('Are you sure you want to delete ' + checkboxes.length + ' selected students? This action cannot be undone.');
    }

    // =========================================================
    // AUTO-CLOSE MESSAGE BANNER
    // =========================================================

    document.addEventListener('DOMContentLoaded', () => {
        const banners = document.querySelectorAll('.message-banner');
        banners.forEach(banner => {
            setTimeout(() => {
                banner.style.opacity = '0';
                setTimeout(() => {
                    banner.style.display = 'none';
                }, 300);
            }, 5000);
        });
    });