<template>
  <div class="reset-code-page">
    <!-- Page Heading -->
    <h1>Enter Reset Code</h1>
    <p>Please enter the reset code sent to your email.</p>

    <!-- Form for Reset Code -->
    <form @submit.prevent="verifyResetCode">
      <div class="form-group">
        <label for="reset_code">Reset Code</label>
        <input 
          type="text" 
          id="reset_code" 
          v-model="resetCode" 
          placeholder="Enter the reset code"
          :class="{ 'is-invalid': error }"
          required
        />
        <!-- Display error message if validation fails -->
        <small v-if="error" class="error-text">{{ error }}</small>
      </div>

      <!-- Submit Button with Loading State -->
      <button type="submit" :disabled="loading" class="submit-btn">
        <!-- Show loading spinner when submitting -->
        <span v-if="loading" class="spinner"></span>
        Submit
      </button>
    </form>

    <!-- Success Message -->
    <div v-if="message" class="success-text">{{ message }}</div>
  </div>
</template>

<script>
import axios from 'axios';
import { Inertia } from '@inertiajs/inertia';

export default {
  data() {
    return {
      resetCode: '',
      error: null,
      message: null,
      loading: false,
    };
  },
  methods: {
    async verifyResetCode() {
      this.error = null;
      this.message = null;
      this.loading = true;

      try {
        const response = await axios.post('/verification', { code: this.resetCode });
        this.message = response.data.message;

        // Navigate to the reset password page if the response is successful
        if (response.status === 200) {
          setTimeout(()=> {this.$inertia.visit('/resetpassword');},2000);
        }
      } catch (err) {
        this.error = err.response?.data?.message || 'An error occurred. Please try again.';
      } finally {
        this.loading = false;
      }
    },
  },
};
</script>

<style scoped>
.reset-code-page {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  text-align: center;
  font-family: 'Poppins', sans-serif;
}

h1 {
  font-size: 24px;
  margin-bottom: 10px;
}

p {
  font-size: 16px;
  color: #555;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 20px;
}

label {
  display: block;
  font-weight: 600;
  margin-bottom: 5px;
}

input {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border-radius: 4px;
  border: 1px solid #ddd;
  transition: border-color 0.3s ease;
}

input:focus {
  border-color: #007bff;
  outline: none;
}

input.is-invalid {
  border-color: red;
}

small.error-text {
  color: red;
  font-size: 14px;
}

button.submit-btn {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  font-size: 16px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  width: 100%;
  transition: background-color 0.3s ease;
}

button.submit-btn:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

button.submit-btn .spinner {
  margin-right: 10px;
  border: 2px solid #fff;
  border-top: 2px solid transparent;
  border-radius: 50%;
  width: 16px;
  height: 16px;
  animation: spin 1s linear infinite;
}

.success-text {
  margin-top: 20px;
  color: green;
  font-size: 16px;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
</style>
