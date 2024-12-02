<template>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/CSS/Regpage.css" />
  <title>Registration</title>
  <!-- Navigation Bar -->
  <nav class="navbar">
      <div class="logo">Pick & Pay</div>
      <ul class="nav-links">
        <li><a href="#">Home</a></li>
        <li><a href="#">Shop</a></li>
        <li><a href="#">Categories</a></li>
        <li><a href="#">Deals</a></li>
        <li><a href="#">Cart</a></li>
        <li><a href="#">About Us</a></li>
      </ul>
      
    </nav>


  <div class="registration-form">
    <h1>Create an Account</h1>
    <p>Sign up to access all features!</p>
    
    <form @submit.prevent="register">
      <!-- Name Fields (First Name and Last Name on the same line) -->
      <div class="form-group name-fields">
        <div class="name-field">
          <label for="first_name">First Name</label>
          <input 
            type="text" 
            id="first_name" 
            v-model="form.first_name" 
            placeholder="Enter your first name" 
            required 
            :class="{ 'is-invalid': errors.first_name }"
          />
          <small v-if="errors.first_name" class="error-text">{{ errors.first_name }}</small>
        </div>
        <div class="name-field">
          <label for="last_name">Last Name</label>
          <input 
            type="text" 
            id="last_name" 
            v-model="form.last_name" 
            placeholder="Enter your last name" 
            required 
            :class="{ 'is-invalid': errors.last_name }"
          />
          <small v-if="errors.last_name" class="error-text">{{ errors.last_name }}</small>
        </div>
      </div>

      <!-- Username -->
      <div class="form-group">
        <label for="username">Username</label>
        <input 
          type="text" 
          id="username" 
          v-model="form.username" 
          placeholder="Choose a username" 
          required 
          :class="{ 'is-invalid': errors.username }"
        />
        <small v-if="errors.username" class="error-text">{{ errors.username }}</small>
      </div>

      <!-- Email -->
      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email" 
          v-model="form.email" 
          placeholder="Enter your email" 
          required 
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
          placeholder="Create a password" 
          required 
          :class="{ 'is-invalid': errors.password }"
        />
        <small v-if="errors.password" class="error-text">{{ errors.password }}</small>
      </div>

      <!-- Confirm Password -->
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input 
          type="password" 
          id="password_confirmation" 
          v-model="form.password_confirmation" 
          placeholder="Confirm your password" 
          required 
          :class="{ 'is-invalid': errors.password_confirmation }"
        />
        <small v-if="errors.password_confirmation" class="error-text">{{ errors.password_confirmation }}</small>
      </div>

      <!-- Terms and Conditions -->
      <div class="form-group-terms">
        <label>
          <input 
            type="checkbox" 
            v-model="form.agree" 
            required
          />
          I agree to the <a href="#">Terms and Conditions</a>
        </label>
        <small v-if="!form.agree" class="error-text">You must agree to the terms and conditions to register</small>
      </div>

      <!-- Submit Button -->
      <button type="submit" :disabled="loading">Register</button>

      <!-- Loading Indicator -->
      <div v-if="loading" class="loading">Submitting...</div>
    </form>

    <div class="login-link">
      <p>Already have an account? <a href="/login">Login here</a></p>
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


</template>

<script>
import Swal from 'sweetalert2';

export default {
  name: 'Regpage',
  data() {
    return {
      form: {
        first_name: '',
        last_name: '',
        username: '',
        email: '',
        password: '',
        password_confirmation: '',
        agree: false,
      },
      errors: {}, // To store validation errors
      loading: false,
    };
  },

  methods: {
    validateForm() {
  const errors = {};

  // Trim inputs to avoid leading/trailing spaces
  this.form.first_name = this.form.first_name.trim();
  this.form.last_name = this.form.last_name.trim();
  this.form.username = this.form.username.trim();
  this.form.email = this.form.email.trim();
  this.form.password = this.form.password.trim();
  this.form.password_confirmation = this.form.password_confirmation.trim();

  // Validate first name
  if (!this.form.first_name) {
    errors.first_name = 'First Name is required.';
  } else if (!/^[a-zA-Z]+([-' ][a-zA-Z]+)*$/.test(this.form.first_name)) {
    errors.first_name = 'First Name should only contain letters, spaces, hyphens, or apostrophes.';
  }

  // Validate last name
  if (!this.form.last_name) {
    errors.last_name = 'Last Name is required.';
  } else if (!/^[a-zA-Z]+([-' ][a-zA-Z]+)*$/.test(this.form.last_name)) {
    errors.last_name = 'Last Name should only contain letters, spaces, hyphens, or apostrophes.';
  }

  // Validate username
  if (!this.form.username) {
    errors.username = 'Username is required.';
  } else if (!/^[a-zA-Z0-9_]+$/.test(this.form.username)) {
    errors.username = 'Username can only contain letters, numbers, and underscores.';
  } else if (this.form.username.length < 3 || this.form.username.length > 20) {
    errors.username = 'Username must be between 3 and 20 characters.';
  }

  // Validate email
  if (!this.form.email) {
    errors.email = 'Email is required.';
  } else if (!/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/.test(this.form.email)) {
    errors.email = 'Enter a valid email address.';
  }

  // Validate password
  if (!this.form.password) {
    errors.password = 'Password is required.';
  } else if (this.form.password.length < 6) {
    errors.password = 'Password must be at least 6 characters long.';
  } else if (!/(?=.*[A-Z])/.test(this.form.password)) {
    errors.password = 'Password must contain at least one uppercase letter.';
  } else if (!/(?=.*\d)/.test(this.form.password)) {
    errors.password = 'Password must contain at least one number.';
  } else if (!/(?=.*[!@#$%^&*])/.test(this.form.password)) {
    errors.password = 'Password must contain at least one special character.';
  }

  // Validate password confirmation
  if (!this.form.password_confirmation) {
    errors.password_confirmation = 'Password confirmation is required.';
  } else if (this.form.password !== this.form.password_confirmation) {
    errors.password_confirmation = 'Passwords do not match.';
  }

  // Validate terms and conditions
  if (!this.form.agree) {
    errors.agree = 'You must agree to the terms and conditions.';
  }

  this.errors = errors;
  return Object.keys(errors).length === 0;
},

  



    async register() {
      if (!this.validateForm()) {
        Swal.fire({
          title: 'Registration Failed',
          text: 'Please fix the errors before submitting.',
          icon: 'error',
          confirmButtonText: 'OK',
        });
        return;
      }

      this.loading = true;
      Swal.fire({
        title: 'Processing...',
        text: 'Please wait while we create your account.',
        icon: 'info',
        showConfirmButton: false,
        allowOutsideClick: false,
      });

      try {
        const response = await this.$inertia.post('/register', {
          first_name: this.form.first_name,
          last_name: this.form.last_name,
          username: this.form.username,
          email: this.form.email,
          password: this.form.password,
          password_confirmation: this.form.password_confirmation,
        });

        Swal.fire({
          title: 'Registration Successful!',
          text: 'Your account has been created successfully.',
          icon: 'success',
          confirmButtonText: 'Ok',
        }).then(() => {
          this.$inertia.visit('/login');
        });
      } catch (error) {
        console.error('Unexpected error:', error);
        Swal.fire({
          title: 'Error',
          text: 'Something went wrong. Please try again later.',
          icon: 'error',
          confirmButtonText: 'Ok',
        });
      } finally {
        this.loading = false;
      }
    },
  },
};

</script>


