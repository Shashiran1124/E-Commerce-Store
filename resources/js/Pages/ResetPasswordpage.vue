<template>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"><!--For png's-->

  <div class="reset-password-container">
    <h1>Reset Password</h1>
    <p>Please enter your new password below.</p>
    <form @submit.prevent="resetPassword">
      <!-- New Password Field -->
      <div class="form-group">
        <label for="password">New Password</label>
        <input
          :type="passwordVisible ? 'text' : 'password'"
          id="password"
          v-model="form.password"
          placeholder="Enter your new password"
          :class="{ 'is-invalid': errors.password }"
          required
        />
        <i class="fa" :class="passwordVisible ? 'fa-eye' : 'fa-eye-slash'" @click="togglePasswordVisibility"></i>
        <span v-if="errors.password" class="error-text">{{ errors.password }}</span>
      </div>

      <!-- Confirm Password Field -->
      <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input
          :type="confirmPasswordVisible ? 'text' : 'password'"
          id="password_confirmation"
          v-model="form.password_confirmation"
          placeholder="Re-enter your new password"
          :class="{ 'is-invalid': errors.password_confirmation }"
          required
        />
        <i class="fa" :class="confirmPasswordVisible ? 'fa-eye' : 'fa-eye-slash'" @click="toggleConfirmPasswordVisibility"></i>
        <span v-if="errors.password_confirmation" class="error-text">
          {{ errors.password_confirmation }}
        </span>
      </div>

      <!-- Submit Button -->
      <button type="submit" :disabled="loading">
        <!-- Show loading spinner when submitting -->
        <span v-if="loading" class="spinner"></span>
        Reset Password
      </button>
    </form>
  </div>
</template>

<script>
import { apiClient } from "@/axios";
import Swal from "sweetalert2";

export default {
  name: "ResetPasswordpage",
  data() {
    return {
      form: {
        password: "",
        password_confirmation: "",
      },
      errors: {},
      loading: false,
      passwordVisible: false,  // Controls visibility of the password field
      confirmPasswordVisible: false,  // Controls visibility of the confirm password field
    };
  },
  methods: {
    async resetPassword() {
      this.errors = {};

      // Validate if password and password confirmation match
      if (this.form.password !== this.form.password_confirmation) {
        this.errors.password_confirmation = "Password fields are not matching.";
        return; // Stop the form submission if passwords don't match
      }

      this.loading = true;

      this.loading = true;

      try {
        const response = await apiClient.post("/resetpassword", this.form, {
          withCredentials: true, // To include session cookies
        });

        // Show success message
        Swal.fire({
          title:"Success",
          position:"top",
          text: response.data.message,
          icon: 'success',
        });
        
        setTimeout(()=> {this.$inertia.visit('/login');},4000);
        
      } catch (error) {
        // Show validation or server errors
        this.errors = error.response?.data?.errors || {};
      
      } finally {
        this.loading = false;
      }
    },
    // Toggles password visibility
    togglePasswordVisibility() {
      this.passwordVisible = !this.passwordVisible;
    },

    // Toggles confirm password visibility
    toggleConfirmPasswordVisibility() {
      this.confirmPasswordVisible = !this.confirmPasswordVisible;
    },
  },
};
</script>

<style scoped>
.reset-password-container {
  max-width: 400px;
  margin: 0 auto;
  padding: 20px;
  text-align: center;
  font-family: 'Poppins', sans-serif;
}

h1 {
  font-size: 24px;
  margin-bottom: 15px;
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
  margin-bottom: 8px;
}

input {
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border-radius: 5px;
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

.error-text {
  color: red;
  font-size: 14px;
  margin-top: 5px;
}

button {
  padding: 12px 25px;
  background-color: #4caf50;
  color: white;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  width: 100%;
  transition: background-color 0.3s ease;
}

button:disabled {
  background-color: #ccc;
  cursor: not-allowed;
}

button .spinner {
  margin-right: 10px;
  border: 2px solid #fff;
  border-top: 2px solid transparent;
  border-radius: 50%;
  width: 16px;
  height: 16px;
  animation: spin 1s linear infinite;
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
