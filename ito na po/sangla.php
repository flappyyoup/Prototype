<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Handle file upload if exists
        $photo_path = null;
        if (!empty($_FILES['photo']['name'])) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $photo_name = time() . '_' . basename($_FILES['photo']['name']);
            $targetFile = $uploadDir . $photo_name;
            move_uploaded_file($_FILES['photo']['tmp_name'], $targetFile);
            $photo_path = $targetFile;
        }

        // Prepare SQL
        $stmt = $conn->prepare("
            INSERT INTO appraisals 
            (item_type, brand, model, grams, remarks, photo, orig_price, last_name, first_name, contact, address, branch2) 
            VALUES 
            (:item_type, :brand, :model, :grams, :remarks, :photo, :orig_price, :last_name, :first_name, :contact, :address, :branch2)
        ");

        // Bind and execute
        $stmt->execute([
            ':item_type' => $_POST['item_type'],
            ':brand' => $_POST['brand'],
            ':model' => $_POST['model'],
            ':grams' => $_POST['grams'],
            ':remarks' => $_POST['remarks'],
            ':photo' => $photo_path,
            ':orig_price' => $_POST['orig_price'],
            ':last_name' => $_POST['last_name'],
            ':first_name' => $_POST['first_name'],
            ':contact' => $_POST['contact'],
            ':address' => $_POST['address'],
            ':branch2' => $_POST['branch2']
        ]);

        // Redirect or trigger modal
        echo "<script>document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('confirmationModal').style.display = 'flex';
        });</script>";

    } catch (Exception $e) {
        $error_message = "Submission failed: " . $e->getMessage();
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appraisal Form</title>
    <!-- Add Google Fonts Poppins -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', Arial, sans-serif;
            background: #f5f6fa;
            margin: 0;
            padding: 0;
        }
        .appraisal-container,
        .appraisal-container *,
        #confirmationModal,
        #confirmationModal *,
        .appraisal-form,
        .appraisal-form * {
            font-family: 'Poppins', Arial, sans-serif !important;
        }
        .appraisal-container {
            max-width: 440px;
            margin: 40px auto;
            background: #fffbe7;
            border-radius: 14px;
            box-shadow: 0 2px 12px rgba(29,75,11,0.10);
            padding: 2rem 2rem 1.5rem 2rem;
            transition: box-shadow 0.3s;
            position: relative;
        }
        .close-btn {
            position: absolute;
            top: 18px;
            right: 18px;
            background: #f5b60f;
            color: #1d4b0b;
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.2s;
            z-index: 10;
        }
        .close-btn:hover {
            background: #1d4b0b;
            color: #fff;
        }
        .appraisal-container:hover {
            box-shadow: 0 12px 32px 0 rgba(40,167,69,0.18), 0 4px 24px 0 rgba(40,167,69,0.10);
        }
        .appraisal-container h2 {
            text-align: center;
            color: #1d4b0b;
            margin-bottom: 1.5rem;
        }
        .appraisal-form label {
            display: block;
            margin-bottom: 0.3rem;
            font-weight: bold;
            color: #1d4b0b;
        }
        .appraisal-form input[type="text"],
        .appraisal-form input[type="number"],
        .appraisal-form input[type="file"],
        .appraisal-form textarea,
        .appraisal-form select {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 1rem;
            border: 1px solid #e0c97f;
            border-radius: 7px;
            font-size: 1rem;
            background: #fff;
            box-sizing: border-box;
            transition: box-shadow 0.2s, background 0.2s, border-color 0.2s;
        }
        .appraisal-form textarea {
            resize: vertical;
        }
        .appraisal-form input[type="text"]::placeholder {
            color: #1d4b0b;
            opacity: 0.3;
        }
        .appraisal-form input[type="text"]:hover,
        .appraisal-form input[type="number"]:hover,
        .appraisal-form input[type="file"]:hover,
        .appraisal-form textarea:hover,
        .appraisal-form select:hover {
            box-shadow: 0 2px 12px rgba(245,182,15,0.12);
            background: #fffde4;
            border-color: #f5b60f;
        }
        .appraisal-form input[type="text"]:focus,
        .appraisal-form input[type="number"]:focus,
        .appraisal-form input[type="file"]:focus,
        .appraisal-form textarea:focus,
        .appraisal-form select:focus {
            outline: none;
            border-color: #1d4b0b;
            background: #f6fff8;
        }
        .appraisal-form .button-row {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1.5rem;
        }
        .appraisal-form button {
            background: #1d4b0b;
            border: none;
            border-radius: 7px;
            padding: 10px 28px;
            font-size: 1.1rem;
            font-weight: bold;
            color: #fff;
            cursor: pointer;
            transition: box-shadow 0.2s, background 0.2s;
        }
        .appraisal-form button:hover,
        .appraisal-form button:focus {
            background: #f5b60f;
            color: #1d4b0b;
            box-shadow: 0 4px 16px rgba(245,182,15,0.18);
            outline: none;
        }
        .hidden {
            display: none;
        }
        /* Confirmation Modal Styles */
        #confirmationModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.25);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        #confirmationModal .modal-content {
            background: #fffbe7;
            border-radius: 12px;
            padding: 2rem 2.5rem;
            box-shadow: 0 4px 24px rgba(40, 167, 69, 0.15);
            text-align: center;
            max-width: 350px;
            margin: auto;
        }
        #confirmationModal .modal-content h3 {
            margin: 1rem 0 0.5rem 0;
            color: #1d4b0b;
        }
        #confirmationModal .modal-content p {
            color: #333;
        }
        #confirmationModal .modal-content button {
            margin-top: 1.2rem;
            padding: 10px 28px;
            font-weight: bold;
            cursor: pointer;
            border: none;
            border-radius: 6px;
        }
        #confirmationModal .modal-content button.ok-btn {
            background: #f5b60f;
            color: #1d4b0b;
            margin-left: 10px;
        }
    </style>
    <script>
       function showStep2() {
    // Validate required fields before going to step 2
    var itemType = document.getElementById('item_type').value.trim();
    var brand = document.getElementById('brand').value.trim();
    var model = document.getElementById('model').value.trim();
    var grams = document.getElementById('grams').value.trim();
    var remarks = document.getElementById('remarks').value.trim();
    var origPrice = document.getElementById('orig_price').value.trim();

    if (!itemType) {
        alert('Please select Item Type.');
        document.getElementById('item_type').focus();
        return;
    }
    if (!brand) {
        alert('Please select Brand.');
        document.getElementById('brand').focus();
        return;
    }
    if (!model) {
        alert('Please enter Model.');
        document.getElementById('model').focus();
        return;
    }
    if (!grams) {
        alert('Please enter Grams.');
        document.getElementById('grams').focus();
        return;
    }
    if (!remarks) {
        alert('Please enter Remarks/Attributes.');
        document.getElementById('remarks').focus();
        return;
    }
    if (!origPrice) {
        alert('Please enter Original Price.');
        document.getElementById('orig_price').focus();
        return;
    }

    document.getElementById('step1').classList.add('hidden');
    document.getElementById('step2').classList.remove('hidden');
}
function handleSubmit(e) {
    e.preventDefault();
    document.getElementById('confirmationModal').style.display = 'flex';
    // Optional: Auto-redirect after 2.5 seconds
    // setTimeout(goToMyAppraisals, 2500);
    return false;
}
function closeModal() {
    // Redirect to sanglarequests.php when OK is clicked
    window.location.href = 'sanglarequests.php';
}
function goToMyAppraisals() {
    // Change this to your actual "My Requests" or "Appraisal Status" page
    window.location.href = 'my_appraisals.php';
}
function backToStep1() {
    document.getElementById('step2').classList.add('hidden');
    document.getElementById('step1').classList.remove('hidden');
}
function closeForm() {
    window.location.href = 'home.php';
}
    </script>
</head>
<body>
    <div class="appraisal-container">
        <button class="close-btn" type="button" onclick="closeForm()" title="Close">&times;</button>
        <h2>Form for Appraisal</h2>
        <?php if (isset($error_message)): ?>
            <div style="color: #dc3545; background: #f8d7da; padding: 10px; border-radius: 5px; margin-bottom: 20px;">
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>
        <form class="appraisal-form" onsubmit="return handleSubmit(event)" method="POST" enctype="multipart/form-data">
            <!-- Step 1 -->
<div id="step1">
    <label for="item_type">Item Type:</label>
    <select id="item_type" name="item_type" required>
        <option value="">Select item type</option>
        <option value="Earrings">Earrings</option>
        <option value="Necklace">Necklace</option>
        <option value="Bracelet">Bracelet</option>
        <option value="Ring">Ring</option>
        <option value="Wristwatch">Wristwatch</option>
    </select>

    <label for="brand">Brand:</label>
    <input type="text" id="brand" name="brand" required placeholder="e.g. mikana, tala, michella" />

    <label for="model">Model:</label>
    <select id="model" name="model" required>
        <option value="">Select model</option>
        <option value="18k">18k</option>
        <option value="22k">22k</option>
        <option value="24k">24k</option>
    </select>

    <label for="grams">Grams:</label>
    <input type="number" id="grams" name="grams" step="0.01" required placeholder="Enter grams">

    <label for="remarks">Remarks/Attributes:</label>
    <textarea id="remarks" name="remarks" rows="3" required placeholder="Describe attributes, e.g. color, stones, etc."></textarea>

    <label for="photo">Photo (optional):</label>
    <input type="file" id="photo" name="photo" accept="image/*">

    <label for="orig_price">Orig Price:</label>
    <input type="number" id="orig_price" name="orig_price" step="0.01" required placeholder="Enter original price">

    <div class="button-row">
        <button type="button" onclick="showStep2()">Next</button>
    </div>
</div>
            <!-- Step 2 -->
            <div id="step2" class="hidden">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" required>

                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" required>

                <label for="contact">Contact:</label>
                <input type="text" id="contact" name="contact" required>

                <label for="address">Address:</label>
                <input type="text" id="address" name="address" required>

                <label for="branch2">Branch:</label>
                <select id="branch2" name="branch2" required>
                    <option value="">Select branch</option>
                    <option value="Ligao">Ligao</option>
                    <option value="Polangui">Polangui</option>
                    <option value="Libon">Libon</option>
                </select>

                <div class="button-row">
                    <button type="button" onclick="backToStep1()">Back</button>
                    <button type="submit">Submit Request</button>

                </div>
            </div>
        </form>
    </div>

    <!-- Place this just before </body> -->
<div id="confirmationModal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.25); z-index:9999; align-items:center; justify-content:center;">
  <div style="background:#fffbe7; border-radius:12px; padding:2rem 2.5rem; box-shadow:0 4px 24px rgba(40,167,69,0.15); text-align:center; max-width:350px; margin:auto;">
    <div style="font-size:2.5rem; color:#1d4b0b;">✅</div>
    <h3 style="margin:1rem 0 0.5rem 0; color:#1d4b0b;">Request Submitted!<br><span style="font-size:1rem; color:#888;">localhost says,</span></h3>
    <p style="color:#333;">Your appraisal request has been successfully sent.<br>We'll notify you once it's reviewed.</p>
    <button onclick="goToMyAppraisals()" style="margin-top:1.2rem; background:#1d4b0b; color:#fff; border:none; border-radius:6px; padding:10px 28px; font-weight:bold; cursor:pointer;">Go to My Appraisals</button>
    <button onclick="closeModal()" style="margin-top:1.2rem; margin-left:10px; background:#f5b60f; color:#1d4b0b; border:none; border-radius:6px; padding:10px 28px; font-weight:bold; cursor:pointer;">OK</button>
  </div>
</div>

<script>
function handleSubmit(e) {
    e.preventDefault();
    document.getElementById('confirmationModal').style.display = 'flex';
    // Optional: Auto-redirect after 2.5 seconds
    // setTimeout(goToMyAppraisals, 2500);
    return false;
}
function closeModal() {
    // Redirect to sanglarequests.php when OK is clicked
    window.location.href = 'sanglarequests.php';
}
function goToMyAppraisals() {
    // Change this to your actual "My Requests" or "Appraisal Status" page
    window.location.href = 'my_appraisals.php';
}
</script>
<div id="confirmationModal">
    <div class="modal-content">
        <h3>Request Submitted!</h3>
        <p>Your appraisal request has been submitted successfully.</p>
        <button class="ok-btn" onclick="closeModal()">OK</button>
    </div>
</div>
</body>
</html>