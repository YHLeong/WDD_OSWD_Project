<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="CSS/Sign_up.css">
</head>
<body>
    <?php include 'Navbar.php';?>
    <div class="signup-container">
        <div class="signup-form-section">
            <div class="signup-title">Sign Up Now</div>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                </div>
            <?php endif; ?>
            
            <form class="signup-form" method="POST" action="signup_process.php">
                <label for="userid">User ID</label>
                <input type="text" id="userid" name="userid" required>
                <span class="error-message" id="userid-error"></span>
                
                <label for="name">Name</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
                <span class="error-message" id="email-error"></span>
                
                <label for="password">Password (8-16 characters)</label>
                <input type="password" id="password" name="password" required>
                <span class="error-message" id="password-error"></span>
                
                <label for="confirm-password">Confirm Password</label>
                <input type="password" id="confirm-password" name="confirm-password" required>
                <span class="error-message" id="confirm-password-error"></span>
                
                <label for="phone">Phone Number</label>
                <div class="phone-row">
                    <input type="text" id="country-code" name="country-code" value="+65" readonly style="width:90px;">
                    <input type="text" id="phone" name="phone" required style="flex:1;" placeholder="8 or 9 followed by 7 digits">
                </div>
                <span class="error-message" id="phone-error"></span>
                <div class="checkbox-row">
                    <input type="checkbox" id="privacy" name="privacy" required>
                    <label for="privacy">I agree to the <a href="#" id="privacy-link">Privacy Policy</a> and <a href="#" id="terms-link">Terms of Service</a></label>
                </div>
                <span class="error-message" id="privacy-error"></span>
                <div class="checkbox-row">
                    <input type="checkbox" id="marketing" name="marketing">
                    <label for="marketing">I agree to receive marketing notifications with offers and news</label>
                </div>
                <button class="signup-btn" type="submit">Sign Up</button>
            </form>
        </div>
        <div class="signup-image-section">
            <img src="image/Creative Design Workshop.avif" alt="Sign Up" class="signup-image-placeholder">
        </div>
    </div>
    
    <!-- Privacy Policy Modal -->
    <div id="privacy-modal" class="modal">
        <div class="modal-content">
            <span class="close" data-modal="privacy-modal">&times;</span>
            <h2>Privacy Policy</h2>
            <div class="modal-text">
                <p><strong>Last updated: July 18, 2025</strong></p>
                
                <h3>1. Information We Collect</h3>
                <p>We collect information you provide directly to us, such as when you create an account, book an event, or contact us. This includes your name, email address, phone number, and any other information you choose to provide.</p>
                
                <h3>2. How We Use Your Information</h3>
                <p>We use the information we collect to:</p>
                <ul>
                    <li>Provide, maintain, and improve our services</li>
                    <li>Process event bookings and manage your account</li>
                    <li>Send you confirmations, updates, and administrative messages</li>
                    <li>Respond to your comments and questions</li>
                </ul>
                
                <h3>3. Information Sharing</h3>
                <p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>
                
                <h3>4. Data Security</h3>
                <p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>
                
                <h3>5. Contact Us</h3>
                <p>If you have any questions about this Privacy Policy, please contact us through our contact form.</p>
            </div>
        </div>
    </div>
    
    <!-- Terms of Service Modal -->
    <div id="terms-modal" class="modal">
        <div class="modal-content">
            <span class="close" data-modal="terms-modal">&times;</span>
            <h2>Terms of Service</h2>
            <div class="modal-text">
                <p><strong>Last updated: July 18, 2025</strong></p>
                
                <h3>1. Acceptance of Terms</h3>
                <p>By accessing and using QuickSlot, you accept and agree to be bound by the terms and provision of this agreement.</p>
                
                <h3>2. Use License</h3>
                <p>Permission is granted to temporarily use QuickSlot for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title.</p>
                
                <h3>3. Event Bookings</h3>
                <p>All event bookings are subject to availability. We reserve the right to cancel or reschedule events with appropriate notice.</p>
                
                <h3>4. User Account</h3>
                <p>You are responsible for maintaining the confidentiality of your account and password. You agree to accept responsibility for all activities that occur under your account.</p>
                
                <h3>5. Cancellation Policy</h3>
                <p>Event cancellations must be made at least 24 hours in advance. Refunds will be processed according to our refund policy.</p>
                
                <h3>6. Limitation of Liability</h3>
                <p>QuickSlot shall not be liable for any indirect, incidental, special, consequential, or punitive damages resulting from your use of the service.</p>
                
                <h3>7. Changes to Terms</h3>
                <p>We reserve the right to modify these terms at any time. Changes will be effective immediately upon posting.</p>
            </div>
        </div>
    </div>
    
    <script>
        // Validation functions
        function validateEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }
        
        function validatePassword(password) {
            return password.length >= 8 && password.length <= 16;
        }
        
        function validatePhone(phone) {
            const phoneRegex = /^[89]\d{7}$/;
            return phoneRegex.test(phone);
        }
        
        function showError(fieldId, message) {
            const errorElement = document.getElementById(fieldId + '-error');
            const inputElement = document.getElementById(fieldId);
            errorElement.textContent = message;
            inputElement.classList.add('input-error');
            inputElement.classList.remove('input-success');
        }
        
        function showSuccess(fieldId) {
            const errorElement = document.getElementById(fieldId + '-error');
            const inputElement = document.getElementById(fieldId);
            errorElement.textContent = '';
            inputElement.classList.add('input-success');
            inputElement.classList.remove('input-error');
        }
        
        // Real-time validation
        document.getElementById('email').addEventListener('blur', function() {
            const email = this.value;
            if (email && !validateEmail(email)) {
                showError('email', 'Please enter a valid email address');
            } else if (email) {
                showSuccess('email');
            }
        });
        
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            if (password && !validatePassword(password)) {
                showError('password', 'Password must be 8-16 characters long');
            } else if (password) {
                showSuccess('password');
            }
            
            // Check confirm password if it has a value
            const confirmPassword = document.getElementById('confirm-password').value;
            if (confirmPassword) {
                if (password !== confirmPassword) {
                    showError('confirm-password', 'Passwords do not match');
                } else {
                    showSuccess('confirm-password');
                }
            }
        });
        
        document.getElementById('confirm-password').addEventListener('input', function() {
            const confirmPassword = this.value;
            const password = document.getElementById('password').value;
            
            if (confirmPassword && password !== confirmPassword) {
                showError('confirm-password', 'Passwords do not match');
            } else if (confirmPassword) {
                showSuccess('confirm-password');
            }
        });
        
        document.getElementById('phone').addEventListener('input', function() {
            const phone = this.value;
            if (phone && !validatePhone(phone)) {
                showError('phone', 'Phone must be 8 digits starting with 8 or 9');
            } else if (phone) {
                showSuccess('phone');
            }
        });
        
        // Privacy policy checkbox validation
        document.getElementById('privacy').addEventListener('change', function() {
            const privacyError = document.getElementById('privacy-error');
            if (this.checked) {
                privacyError.textContent = '';
                privacyError.style.display = 'none';
            } else {
                privacyError.textContent = 'You must agree to the Privacy Policy and Terms of Service to continue';
                privacyError.style.display = 'block';
            }
        });
        
        // Form submission validation
        document.querySelector('.signup-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const userid = document.getElementById('userid').value;
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('confirm-password').value;
            const phone = document.getElementById('phone').value;
            const privacyChecked = document.getElementById('privacy').checked;
            
            let isValid = true;
            
            // Clear previous errors
            document.querySelectorAll('.error-message').forEach(error => {
                error.textContent = '';
                error.style.display = 'none';
            });
            document.querySelectorAll('input').forEach(input => {
                input.classList.remove('input-error', 'input-success');
            });
            
            // Validate User ID
            if (!userid || userid.length < 3) {
                showError('userid', 'User ID must be at least 3 characters long');
                isValid = false;
            }
            
            // Validate Email
            if (!validateEmail(email)) {
                showError('email', 'Please enter a valid email address');
                isValid = false;
            }
            
            // Validate Password
            if (!validatePassword(password)) {
                showError('password', 'Password must be 8-16 characters long');
                isValid = false;
            }
            
            // Validate Confirm Password
            if (password !== confirmPassword) {
                showError('confirm-password', 'Passwords do not match');
                isValid = false;
            }
            
            // Validate Phone
            if (!validatePhone(phone)) {
                showError('phone', 'Phone must be 8 digits starting with 8 or 9');
                isValid = false;
            }
            
            // Validate Privacy Policy - Enhanced validation
            if (!privacyChecked) {
                const privacyError = document.getElementById('privacy-error');
                privacyError.textContent = 'You must agree to the Privacy Policy and Terms of Service to create an account';
                privacyError.style.display = 'block';
                
                // Scroll to the checkbox if it's not visible
                document.getElementById('privacy').scrollIntoView({ behavior: 'smooth', block: 'center' });
                
                // Show alert as well for immediate attention
                alert('Please read and agree to our Privacy Policy and Terms of Service before proceeding.');
                isValid = false;
            }
            
            // Prevent form submission if validation fails
            if (!isValid) {
                return false;
            }
            
            if (isValid) {
                // Submit form
                this.submit();
            }
        });
        
        // Modal functionality
        // Get modal elements
        const privacyModal = document.getElementById('privacy-modal');
        const termsModal = document.getElementById('terms-modal');
        const privacyLink = document.getElementById('privacy-link');
        const termsLink = document.getElementById('terms-link');
        const closeButtons = document.querySelectorAll('.close');
        
        // Open modals
        privacyLink.onclick = function(e) {
            e.preventDefault();
            privacyModal.style.display = 'block';
        }
        
        termsLink.onclick = function(e) {
            e.preventDefault();
            termsModal.style.display = 'block';
        }
        
        // Close modals
        closeButtons.forEach(button => {
            button.onclick = function() {
                const modalId = this.getAttribute('data-modal');
                document.getElementById(modalId).style.display = 'none';
            }
        });
        
        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target === privacyModal) {
                privacyModal.style.display = 'none';
            }
            if (event.target === termsModal) {
                termsModal.style.display = 'none';
            }
        }
    </script>
    
    <?php include 'footer.php'; ?>
</body>
</html>
