// Notification functionality
class NotificationSystem {
    constructor() {
        this.notificationBtn = document.getElementById('notificationBtn');
        this.notificationPanel = document.getElementById('notificationPanel');
        this.notificationOverlay = document.getElementById('notificationOverlay');
        this.notificationContent = document.getElementById('notificationContent');
        this.notificationBadge = document.getElementById('notificationBadge');
        
        // Sample notifications data (replace with your actual notifications)
        this.notifications = [
            {
                title: 'New Product Available',
                message: 'Check out our latest gold collection!',
                time: '2 hours ago'
            },
            {
                title: 'Special Offer',
                message: 'Get 10% off on all jewelry items this week!',
                time: '1 day ago'
            }
        ];

        this.initializeEventListeners();
        this.updateNotifications();
    }

    initializeEventListeners() {
        // Notification Button Click Event
        if (this.notificationBtn) {
            this.notificationBtn.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggleNotification();
            });
        }

        // Notification Overlay Click Event
        if (this.notificationOverlay) {
            this.notificationOverlay.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                this.toggleNotification();
            });
        }

        // Notification Escape Key Event
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.notificationPanel && this.notificationPanel.classList.contains('open')) {
                this.toggleNotification();
            }
        });

        // Notification Click Outside Event
        document.addEventListener('click', (event) => {
            if (this.notificationPanel && 
                this.notificationPanel.classList.contains('open') && 
                !this.notificationPanel.contains(event.target) && 
                !event.target.closest('#notificationBtn')) {
                this.toggleNotification();
            }
        });
    }

    toggleNotification() {
        if (!this.notificationPanel) return;
        
        const isOpen = this.notificationPanel.classList.contains('open');
        
        if (isOpen) {
            this.notificationPanel.classList.remove('open');
            if (this.notificationOverlay) this.notificationOverlay.classList.remove('active');
            document.body.classList.remove('panel-open');
        } else {
            this.notificationPanel.classList.add('open');
            if (this.notificationOverlay) this.notificationOverlay.classList.add('active');
            document.body.classList.add('panel-open');
            this.updateNotifications();
        }
    }

    updateNotifications() {
        if (!this.notificationContent || !this.notificationBadge) return;
        
        this.notificationContent.innerHTML = '';
        
        if (!this.notifications || this.notifications.length === 0) {
            this.notificationContent.innerHTML = '<p style="text-align: center; color: #D5AD50;">No new notifications</p>';
            this.notificationBadge.style.display = 'none';
            return;
        }

        this.notifications.forEach(notification => {
            const notificationElement = document.createElement('div');
            notificationElement.className = 'notification-item';
            notificationElement.innerHTML = `
                <h4>${notification.title}</h4>
                <p>${notification.message}</p>
                <div class="time">${notification.time}</div>
            `;
            this.notificationContent.appendChild(notificationElement);
        });

        this.notificationBadge.textContent = this.notifications.length;
        this.notificationBadge.style.display = this.notifications.length > 0 ? 'block' : 'none';
    }
}

// Initialize notification system when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    window.notificationSystem = new NotificationSystem();
}); 