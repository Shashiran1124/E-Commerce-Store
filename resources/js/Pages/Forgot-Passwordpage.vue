<template>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/CSS/Forgot-Passwordpage.css" />

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

  <!-- Forgot Password Form -->
  <div class="forgot-password-page">
    <h1>Forgot Password</h1>
    <p>Enter your email to receive a verification code.</p>
    <form @submit.prevent="sendResetCode">
      <!-- Email Field -->
      <div class="form-group">
        <label for="email">Email</label>
        <input 
          type="email" 
          id="email" 
          v-model="email" 
          placeholder="Enter your email"
          :class="{ 'is-invalid': error }"
          required
        />
        <small v-if="error" class="error-text">{{ error }}</small>
      </div>

      <!-- Submit Button -->
      <button 
        @click="GoToVerification" 
        type="submit" 
        :disabled="loading" 
        class="submit-button">
        Submit
      </button>
    </form>
    <div v-if="message" class="success-text">{{ message }}</div>
  </div>

  
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      email: '',
      error: null,
      message: null,
      loading: false,
    };
  },
  methods: {
    async sendResetCode() {
      this.error = null;
      this.message = null;
      this.loading = true;

      try {
        const response = await axios.post('/forgotpassword', { email: this.email });
        this.message = response.data.message;
        Swal.fire({
          title: 'Check your email',
          text: response.data.message,
          icon: 'success',
          position:'top',
          confirmButtonText: 'OK',
        });
      } catch (err) {
        this.error = err.response.data.errors.email || 'An error occurred.';
      } finally {
        this.loading = false;
      }
    },
    GoToVerification() {
      this.$inertia.visit('/verification');
    }
  },
};
</script>




