<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="stylesheet" href="style/payment.css">
	<link rel="icon" href="../../../assets/favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <h2>Payment</h2>
        <form action="process_payment.php" method="POST" enctype="multipart/form-data" id="paymentForm">
            <input type="hidden" name="orderId" value="<?php echo isset($_GET['orderId']) ? $_GET['orderId'] : ''; ?>">
            <!-- Add a hidden input for total amount -->
            <input type="hidden" name="totalAmount" value="<?php echo isset($totalAmount) ? $totalAmount : '0.00'; ?>">
            <label for="paymentMethod">Select Payment Method:</label>
            <select id="paymentMethod" name="paymentMethod" required>
                <option value="cash_on_delivery">Cash on Delivery (COD)</option>
                <option value="gcash">GCash</option>
            </select>
            <div id="gcashScreenshotField" style="display: none;">
                <label for="gcashScreenshot">Upload GCash Screenshot:</label>
                <input type="file" id="gcashScreenshot" name="gcashScreenshot" accept="image/*">
            </div>
            <!-- Add address field -->
            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>
            <!-- Add receiver field -->
            <label for="receiver">Receiver:</label>
            <input type="text" id="receiver" name="receiver" required>
            <!-- Add phone field -->
 <label for="phone">Phone:</label>
<input type="text" id="phone" name="phone" pattern="^[0-9]{10,11}$" required title="Phone number should be 10 or 11 digits long.">
<span id="phoneError" style="color: red; display: none;">Phone number should be 10 or 11 digits long.</span>
<input type="hidden" name="totalAmount" value="<?php echo isset($_GET['totalAmount']) ? $_GET['totalAmount'] : '0.00'; ?>">
<p>Total Amount: ₱<?php echo isset($_GET['totalAmount']) ? number_format($_GET['totalAmount'], 2) : '0.00'; ?></p>

    <script>
                document.getElementById('phone').addEventListener('input', function (e) {
                    var phoneInput = e.target.value;
                    var phoneError = document.getElementById('phoneError');
                    var isValid = /^[0-9]{10,11}$/.test(phoneInput);

                    if (!isValid) {
                        phoneError.style.display = 'inline';
                    } else {
                        phoneError.style.display = 'none';
                    }

                    e.target.setCustomValidity(isValid ? '' : 'Phone number should be 10 or 11 digits long.');
                });
            </script>

            <!-- Auto-generated reference field -->
            <?php
                // Generate auto reference
                $autoReference = uniqid('REF');
            ?>
            <input type="hidden" name="reference" value="<?php echo $autoReference; ?>">
            <p>Auto-generated Reference: <?php echo $autoReference; ?></p>
            <!-- End auto-generated reference field -->
            <input type="submit" value="Confirm Payment">
        </form>
    </div>

    <script>
        document.getElementById('paymentMethod').addEventListener('change', function() {
            var gcashScreenshotField = document.getElementById('gcashScreenshotField');
            if (this.value === 'gcash') {
                gcashScreenshotField.style.display = 'block';
                document.getElementById('gcashScreenshot').setAttribute('required', 'true');
            } else {
                gcashScreenshotField.style.display = 'none';
                document.getElementById('gcashScreenshot').removeAttribute('required');
            }
        });

        // JavaScript validation for phone input
        document.getElementById('phone').addEventListener('input', function() {
            // Remove non-numeric characters
            var phoneNumber = this.value.replace(/\D/g, '');
            // Ensure length is exactly 10 digits
            if (phoneNumber.length !== 10) {
                this.setCustomValidity('Phone number must be 10 digits');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>