<template>
    <div class="login-page">
      <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="/CSS/Loginpage.css" />
      
  
      <!-- Navigation Bar -->
      <nav class="navbar">
        <div class="logo">Pick & Pay</div>
        <ul class="nav-links">
          <li><a href="/">Home</a></li>
          <li><a href="/shopping">Shop</a></li>
          <li><a href="#">Categories</a></li>
          <li><a href="#">Deals</a></li>
          <li><a href="#">Cart</a></li>
          <li><a href="/">About Us</a></li>
        </ul>
      </nav>

      <div class="login-form">
        <h1>Welcome Back</h1>
        <p>Please log in to your account.</p>
  <form @submit.prevent="validateAndLogin">
  <!-- Email/Username -->
  <div class="form-group">
    <label for="email">Email/Username</label>
    <input 
      type="text" 
      id="email" 
      v-model="form.email" 
      placeholder="Enter your email or username" 
      :class="{ 'is-invalid': errors.email }"
    />
    <small v-if="errors.email" class="error-text">{{ errors.email }}</small>
  </div>

  <!-- Password -->
  <div class="form-group">
    <label for="password">Password</label>
    <input 
      type="password" 
      id="password" 
      v-model="form.password" 
      placeholder="Enter your password" 
      :class="{ 'is-invalid': errors.password }"
    />
    <small v-if="errors.password" class="error-text">{{ errors.password }}</small>
  </div>
  <div class="forgot-password">
    <p><a href="/forgotpassword">forgot password?</a></p>
  </div>

  <!-- Submit Button -->
  <button type="submit" :disabled="loading">Login</button>
</form>

  
        <div class="signup-link">
          Don't have an account? <a href="/register">Sign up here</a>
        </div>
      </div>
  
      <!-- Footer -->
      <footer class="footer">
        <div class="footer-container">
          <div class="footer-section">
            <h4>Quick Links</h4>
            <ul>
              <li><a href="#">Home</a></li>
              <li><a href="#">Shop</a></li>
              <li><a href="#">About Us</a></li>
              <li><a href="#">Contact</a></li>
            </ul>
          </div>
          <div class="footer-section">
            <h4>Contact Us</h4>
            <p>Email: support@eshop.com</p>
            <p>Phone: +1 234 567 890</p>
            <p>Address: 123 E-Shop Lane, Market City</p>
          </div>
          <div class="footer-section">
            <h4>Follow Us</h4>
            <div class="social-icons">
              <a href="#"><i class="fab fa-facebook"></i></a>
              <a href="#"><i class="fab fa-twitter"></i></a>
              <a href="#"><i class="fab fa-instagram"></i></a>
              <a href="#"><i class="fab fa-linkedin"></i></a>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <p>&copy; 2024 E-Shop. All Rights Reserved.</p>
        </div>
      </footer>
    </div>
  </template>
  
  <script>
  import Swal from 'sweetalert2';
  
  export default {
  name: 'Loginpage',
  data() {
    return {
      form: {
        email: '',
        password: '',
        remember: false,
      },
      errors: {}, // To store validation errors
      loading: false,
    };
  },
  methods: {
    validateForm() {
      const errors = {};
      // Check if the email or username is provided
      if (!this.form.email) {
        errors.email = 'Email or Username is required.';
      } 
      // Check if it's a valid email format
      else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(this.form.email) && !/^[a-zA-Z0-9_]+$/.test(this.form.email)) {
        errors.email = 'Enter a valid email address or username.';
      }

      if (!this.form.password) {
        errors.password = 'Password is required.';
      } else if (this.form.password.length < 6) {
        errors.password = 'Password must be at least 6 characters long.';
      }

      this.errors = errors;
      return Object.keys(errors).length === 0;
    },

    async validateAndLogin() {
      if (!this.validateForm()) {
        // If validation fails, stop further execution
        Swal.fire({
          title: 'Login Failed',
          text: 'Invalid username or password',
          icon: 'error',
          position:'top',
          confirmButtonText: 'OK',
        });
        return;
      }

      this.loading = true;

      try {
        // Send both email/username and password to backend for validation
        const response = await axios.post('/validate-credentials', {
          emailOrUsername: this.form.email,
          password: this.form.password,
        });

        if (response.data.status === 'error') {
          Swal.fire({
            title: 'Login Failed',
            text: response.data.message, // Error message from backend
            icon: 'error',
            position:'top',
            confirmButtonText: 'OK',
          });
        } else {
          Swal.fire({
            title: 'Success',
            text: 'You have logged in successfully.',
            icon: 'success',
            position:'top',
            confirmButtonText: 'OK',
          }).then(() => {
            this.$inertia.visit('/shopping'); // Redirect to homepage or dashboard
          });
        }
      } catch (error) {
        Swal.fire({
          title: 'Login Failed',
          text: 'Invalid username or password',
          icon: 'error',
          position:'top',
          confirmButtonText: 'OK',
        });
      } finally {
        this.loading = false;
      }
    },
  },
};

  </script>
  