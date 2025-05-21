// Simple estimator logic
const multipliers = {
    "18k": 1800,
    "22k": 2200,
    "24k": 2500
};

function updateEstimate() {
    const grams = parseFloat(document.getElementById('grams').value) || 0;
    const model = document.getElementById('model').value;
    let estimate = 0;
    if (grams > 0 && multipliers[model]) {
        estimate = grams * multipliers[model];
    }
    document.getElementById('estimateResult').textContent = "Estimated Value: ₱" + estimate.toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});
}

// Popup functionality
function openEstimatorPopup() {
    const popup = document.querySelector('.estimator-popup');
    popup.classList.add('active');
    document.body.style.overflow = 'hidden'; // Prevent background scrolling
}

function closeEstimatorPopup() {
    const popup = document.querySelector('.estimator-popup');
    popup.classList.remove('active');
    document.body.style.overflow = ''; // Restore background scrolling
}

// Initialize event listeners when the DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Estimator form event listeners
    const gramsInput = document.getElementById('grams');
    const modelSelect = document.getElementById('model');
    
    if (gramsInput) gramsInput.addEventListener('input', updateEstimate);
    if (modelSelect) modelSelect.addEventListener('change', updateEstimate);

    // Popup close button
    const closeButton = document.querySelector('.estimator-popup-close');
    if (closeButton) {
        closeButton.addEventListener('click', closeEstimatorPopup);
    }

    // Close popup when clicking outside
    const popup = document.querySelector('.estimator-popup');
    if (popup) {
        popup.addEventListener('click', (e) => {
            if (e.target === popup) {
                closeEstimatorPopup();
            }
        });
    }

    // Close popup with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && popup.classList.contains('active')) {
            closeEstimatorPopup();
        }
    });
}); 