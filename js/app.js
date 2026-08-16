import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Global JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips and popovers
    initializeTooltips();
    
    // Handle file uploads
    initializeFileUploads();
    
    // Handle form submissions
    initializeFormHandlers();
    
    // Initialize notifications
    // initializeNotifications();
    
    // Handle responsive tables
    initializeResponsiveTables();
    
    // Initialize floating elements
    initializeFloatingElements();
});

function initializeTooltips() {
    // Add tooltip functionality
    const tooltipElements = document.querySelectorAll('[data-tooltip]');
    tooltipElements.forEach(element => {
        element.addEventListener('mouseenter', showTooltip);
        element.addEventListener('mouseleave', hideTooltip);
    });
}

function showTooltip(event) {
    const tooltip = document.createElement('div');
    tooltip.className = 'absolute z-10 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm tooltip glass-effect';
    tooltip.textContent = event.target.getAttribute('data-tooltip');
    
    document.body.appendChild(tooltip);
    
    const rect = event.target.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 5 + 'px';
}

function hideTooltip() {
    const tooltip = document.querySelector('.tooltip');
    if (tooltip) {
        tooltip.remove();
    }
}

function initializeFileUploads() {
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', handleFileSelect);
        
        // Add drag and drop support
        const uploadZone = input.closest('.file-upload-zone');
        if (uploadZone) {
            uploadZone.addEventListener('dragover', handleDragOver);
            uploadZone.addEventListener('dragleave', handleDragLeave);
            uploadZone.addEventListener('drop', handleDrop);
        }
    });
}

function handleFileSelect(event) {
    const files = Array.from(event.target.files);
    displaySelectedFiles(files, event.target);
}

function handleDragOver(event) {
    event.preventDefault();
    event.currentTarget.classList.add('dragover');
}

function handleDragLeave(event) {
    event.preventDefault();
    event.currentTarget.classList.remove('dragover');
}

function handleDrop(event) {
    event.preventDefault();
    event.currentTarget.classList.remove('dragover');
    
    const files = Array.from(event.dataTransfer.files);
    const fileInput = event.currentTarget.querySelector('input[type="file"]');
    
    // Update file input
    const dt = new DataTransfer();
    files.forEach(file => dt.items.add(file));
    fileInput.files = dt.files;
    
    displaySelectedFiles(files, fileInput);
}

function displaySelectedFiles(files, input) {
    const previewContainer = document.getElementById('filePreview') || createFilePreviewContainer(input);
    const fileList = previewContainer.querySelector('#fileList');
    
    fileList.innerHTML = '';
    
    files.forEach((file, index) => {
        const fileItem = createFileItem(file, index, input);
        fileList.appendChild(fileItem);
    });
    
    previewContainer.classList.remove('hidden');
}

function createFilePreviewContainer(input) {
    const container = document.createElement('div');
    container.id = 'filePreview';
    container.className = 'mt-4 glass-effect rounded-xl p-4';
    container.innerHTML = `
        <h4 class="text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Selected Files:</h4>
        <div id="fileList" class="space-y-2"></div>
    `;
    input.parentNode.appendChild(container);
    return container;
}

function createFileItem(file, index, input) {
    const item = document.createElement('div');
    item.className = 'flex items-center justify-between bg-white/50 dark:bg-gray-700/50 p-3 rounded-lg';
    
    const fileInfo = document.createElement('div');
    fileInfo.className = 'flex items-center';
    
    const icon = getFileIcon(file.type);
    const size = formatFileSize(file.size);
    
    fileInfo.innerHTML = `
        <i class="${icon} mr-3 text-gray-500"></i>
        <div>
            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">${file.name}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">${size}</p>
        </div>
    `;
    
    const removeBtn = document.createElement('button');
    removeBtn.type = 'button';
    removeBtn.className = 'text-red-500 hover:text-red-700 p-1 rounded-full hover:bg-red-100 dark:hover:bg-red-900/30 transition-colors';
    removeBtn.innerHTML = '<i class="fas fa-times"></i>';
    removeBtn.onclick = () => removeFile(index, input);
    
    item.appendChild(fileInfo);
    item.appendChild(removeBtn);
    
    return item;
}

function removeFile(index, input) {
    const dt = new DataTransfer();
    const files = Array.from(input.files);
    
    files.forEach((file, i) => {
        if (i !== index) dt.items.add(file);
    });
    
    input.files = dt.files;
    displaySelectedFiles(Array.from(dt.files), input);
}

function getFileIcon(type) {
    if (type.startsWith('image/')) return 'fas fa-image text-blue-500';
    if (type.startsWith('video/')) return 'fas fa-video text-purple-500';
    if (type.includes('pdf')) return 'fas fa-file-pdf text-red-500';
    if (type.includes('doc')) return 'fas fa-file-word text-blue-600';
    if (type.includes('sheet')) return 'fas fa-file-excel text-green-600';
    if (type.includes('presentation')) return 'fas fa-file-powerpoint text-orange-500';
    return 'fas fa-file text-gray-500';
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

function initializeFormHandlers() {
    // Handle loading states for submit buttons (less aggressive)
    const submitButtons = document.querySelectorAll('button[type="submit"]');
    submitButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            // Only show loading state but don't interfere with form submission
            this.classList.add('loading');
            
            // Add loading spinner
            const originalContent = this.innerHTML;
            this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' + this.textContent;
            
            // Store original content to restore later
            this.setAttribute('data-original-content', originalContent);
            
            // Log for debugging
            console.log('Submit button clicked');
        });
    });
}

function initializeNotifications() {
    // Auto-hide flash messages
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            alert.style.opacity = '0';
            alert.style.transform = 'translateY(-10px)';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
    
    // Load notification count
    if (document.querySelector('#notificationCount')) {
        loadNotificationCount();
        setInterval(loadNotificationCount, 30000); // Check every 30 seconds
    }
}

function loadNotificationCount() {
    fetch('/api/notifications/unread-count')
        .then(response => response.json())
        .then(data => {
            const countElement = document.getElementById('notificationCount');
            if (countElement) {
                if (data.count > 0) {
                    countElement.textContent = data.count > 99 ? '99+' : data.count;
                    countElement.classList.remove('hidden');
                } else {
                    countElement.classList.add('hidden');
                }
            }
        })
        .catch(error => console.error('Error loading notification count:', error));
}

function initializeResponsiveTables() {
    const tables = document.querySelectorAll('.table-responsive table');
    
    tables.forEach(table => {
        // Add mobile-friendly classes
        if (window.innerWidth < 768) {
            table.classList.add('text-sm');
        }
    });
}

function initializeFloatingElements() {
    // Add floating animation to elements with animate-float class
    const floatingElements = document.querySelectorAll('.animate-float');
    floatingElements.forEach((element, index) => {
        element.style.animationDelay = `${index * 0.2}s`;
    });
}

// Export functions for use in other scripts
window.UniversityTalents = {
    showTooltip,
    hideTooltip,
    formatFileSize,
    getFileIcon,
    loadNotificationCount
};