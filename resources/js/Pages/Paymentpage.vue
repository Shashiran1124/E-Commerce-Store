<template>
    <div class="payment-container">
      <h2>Payment Page</h2>
      <form @submit.prevent="handlePayment">
        <label for="cardNumber">Card Number</label>
        <input type="text" id="cardNumber" v-model="paymentDetails.cardNumber" placeholder="1234 5678 9101 1121" required />
  
        <label for="expiryDate">Expiry Date</label>
        <input type="text" id="expiryDate" v-model="paymentDetails.expiryDate" placeholder="MM/YY" required />
  
        <label for="cvv">CVV</label>
        <input type="text" id="cvv" v-model="paymentDetails.cvv" placeholder="123" required />
  
        <button type="submit">Pay Now</button>
      </form>
    </div>
  </template>
  
  <script>
  export default {
    name: 'Paymentpage',

    data() {
      return {
        paymentDetails: {
          cardNumber: '',
          expiryDate: '',
          cvv: '',
        },
      };
    },
    methods: {
  async handlePayment() {
    try {
      const response = await axios.post('/api/payment', this.paymentDetails);
      alert(`Payment successful! Transaction ID: ${response.data.transactionId}`);
    } catch (error) {
      alert('Payment failed!');
    }
  },
},
  };
  </script>
  
  <style>
  .payment-container {
    max-width: 400px;
    margin: 50px auto;
    padding: 20px;
    border: 1px solid #ddd;
    border-radius: 5px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  }
  .payment-container input,
  .payment-container button {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
  }
  .payment-container button {
    background-color: #28a745;
    color: white;
    border: none;
    cursor: pointer;
  }
  .payment-container button:hover {
    background-color: #218838;
  }
  </style>
  