<?php
// Include this file in your home.php where you want the estimator popup to appear
?>
<div class="estimator-popup">
    <div class="estimator-popup-content">
        <span class="estimator-popup-close">&times;</span>
        <h2>Sangla Estimator</h2>
        <form id="sanglaForm" action="estimate_process.php" method="POST" enctype="multipart/form-data" class="estimator-form">
            <div class="form-row">
                <label for="item_type">Item Type</label>
                <select name="item_type" id="item_type" required>
                    <option value="">Select item type</option>
                    <option value="earrings">Earrings</option>
                    <option value="necklace">Necklace</option>
                    <option value="bracelet">Bracelet</option>
                    <option value="wristwatch">Wristwatch</option>
                    <option value="rings">Rings</option>
                </select>
            </div>
            <div class="form-row">
                <label for="branch">Branch</label>
                <select name="branch" id="branch" required>
                    <option value="">Select branch</option>
                    <option value="ligao">Ligao</option>
                    <option value="polangui">Polangui</option>
                    <option value="libon">Libon</option>
                </select>
            </div>
            <div class="form-row">
                <label for="brand">Brand</label>
                <input type="text" name="brand" id="brand" placeholder="e.g., Mitana, Tala" required>
            </div>
            <div class="form-row">
                <label for="model">Model</label>
                <select name="model" id="model" required>
                    <option value="">Select model</option>
                    <option value="18k">18K</option>
                    <option value="22k">22K</option>
                    <option value="24k">24K</option>
                </select>
            </div>
            <div class="form-row">
                <label for="grams">Grams</label>
                <input type="number" step="0.01" name="grams" id="grams" placeholder="Weight in grams" required>
            </div>
            <div class="form-row">
                <label for="remarks">Remarks / Description</label>
                <textarea name="remarks" id="remarks" placeholder="Provide a short description..." rows="3" required></textarea>
            </div>
            <div class="form-row">
                <label for="photo">Photo (optional)</label>
                <input type="file" name="photo" id="photo" accept="image/*">
            </div>
            <div class="form-row">
                <label>Estimated Value</label>
                <div id="estimateResult" style="padding: 8px 10px; background-color: #f8f9fa; border-radius: 5px;">Estimated Value: ₱0.00</div>
            </div>
            <div class="form-row buttons-row">
                <button type="button" class="button" onclick="closeEstimatorPopup()" style="background-color: #888; color: white; padding: 10px 28px; text-decoration: none; border-radius: 5px; font-weight:bold;">Close</button>
                <button type="submit" class="button" style="background-color: #1d4b0b; color: white; padding: 12px 32px; border: none; border-radius: 5px; font-size: 1.1rem; font-weight: bold;">Estimate Now</button>
            </div>
        </form>
    </div>
</div> 