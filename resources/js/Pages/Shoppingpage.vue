<template>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"><!--For png's-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/CSS/Shoppingpage.css" />

    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">Pick & Pay</div>
        <ul class="nav-links">
          <li><a href="/">Home</a></li>
          <li><a href="#">Shop</a></li>
          <li><a href="#">Categories</a></li>
          <li><a href="#">Deals</a></li>
          <li><a href="#">About Us</a></li>
          <li><a href="#" class="cart-icon"><i class="fas fa-shopping-cart"></i></a></li>
          <li><a href="#" class="profile-icon"><i class="fas fa-user"></i></a></li>
        </ul>
      </nav>






    <!-- Main Content -->
<div class="main-content">
  <!-- Filter Panel -->
  <aside class="filter-panel">
    <h3>Filters</h3>
    
    <!-- Price Range Filter -->
    <div class="filter-section">
      <h4>Price Range</h4>
      <div class="price-range">
        <input
          type="number"
          min="0"
          max="1000"
          v-model="priceRange.min"
          class="price-input"
          placeholder="Min"
          @input="updatePriceRangeSlider"
        />
        <span>-</span>
        <input
          type="number"
          min="0"
          max="1000"
          v-model="priceRange.max"
          class="price-input"
          placeholder="Max"
        />
      </div>
      
      <input
        type="range"
        min="0"
        max="1000"
        step="10"
        v-model="priceRange.slider"
        class="price-slider"
        @input="syncPriceRange"
      />
      
      <p>Selected Range: ${{ priceRange.slider  }} - ${{ priceRange.max }}</p>
    </div>

    <!-- Brand Filter -->
    <div class="filter-section">
      <h4>Brand</h4>
      <ul>
        <li>
          <input type="checkbox" id="brand1" v-model="selectedBrands" value="Brand 1" />
          <label for="brand1">Brand 1</label>
        </li>
        <li>
          <input type="checkbox" id="brand2" v-model="selectedBrands" value="Brand 2" />
          <label for="brand2">Brand 2</label>
        </li>
        <li>
          <input type="checkbox" id="brand3" v-model="selectedBrands" value="Brand 3" />
          <label for="brand3">Brand 3</label>
        </li>
      </ul>
    </div>

    <!-- Rating Filter -->
    <div class="filter-section">
      <h4>Rating</h4>
      <ul>
        <li>
          <input type="radio" name="rating" id="rating4" value="4" v-model="selectedRating" />
          <label for="rating4">4+ Stars</label>
        </li>
        <li>
          <input type="radio" name="rating" id="rating3" value="3" v-model="selectedRating" />
          <label for="rating3">3+ Stars</label>
        </li>
    <li>
         <input type="radio" name="rating" id="ratingAll" value="" v-model="selectedRating" />
         <label for="ratingAll">All Ratings</label>
    </li>

      </ul>
    </div>

    <!-- Apply Filters Button -->
    <button class="apply-filters" @click="applyFilters">Apply Filters</button>
  </aside>

  <div class="head">
    <h2>Available Products</h2>
  </div>
  
<!-- Product List -->
<section class="product-list">
            
            <div class="product" v-for="product in filteredProducts" :key="product.id">
                <img :src="product.image" :alt="product.name" class="product-image" />
                <h3 class="product-name">{{ product.name }}</h3>
                <p class="product-brand">{{ product.brand }}</p>
                <p class="product-price">${{ product.price }}</p>
                <p class="product-rating">Rating:
                     <span>
                        <i class="fas fa-star" v-for="i in product.rating" :key="i" style="color: gold;"></i>
                        <i class="far fa-star" v-for="i in (5 - product.rating)" :key="5 - i" style="color: grey;"></i>
                    </span>
                    {{ product.rating }} Stars
                </p>
                <!-- Add to Cart Button -->
                <button class="add-to-cart" @click="showModal = true">Add to Cart</button>

            </div>
        </section>
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

export default {
  name: 'Shoppingpage',
  
  data() {
    return {
      priceRange: {
        min: 0,
        max: 1000,
        slider: 0, // Default value of the slider
      },
      selectedBrands: [],
      selectedRating: null,
      
      products: [
        {
          id: 1,
          name: 'Product A',
          brand: 'Brand 1',
          price: 100,
          rating: 4,
          image: '/images/electronics-1.jpeg',
        },
        {
          id: 2,
          name: 'Product B',
          brand: 'Brand 2',
          price: 200,
          rating: 3,
          image: '/images/Laptop1.jpg',
        },
        {
          id: 3,
          name: 'Product C',
          brand: 'Brand 3',
          price: 150,
          rating: 5,
          image: '/images/Headphone1.jpg',
        },
        // Add more product objects here
      ],
      
      // This object will hold the filters applied by the user
      appliedFilters: {
        priceRange: {
          min: 0,
          max: 1000
        },
        brands: [],
        rating: null
      },
    };
  },

  computed: {
    filteredProducts() {
      return this.products.filter(product => {
        // Filter by price range
        const isPriceValid = product.price >= this.appliedFilters.priceRange.min && product.price <= this.appliedFilters.priceRange.max;

        // Filter by selected brands
        const isBrandValid = this.appliedFilters.brands.length === 0 || this.appliedFilters.brands.includes(product.brand);

        // Filter by selected rating
        const isRatingValid = !this.appliedFilters.rating || product.rating >= Number(this.appliedFilters.rating);

        return isPriceValid && isBrandValid && isRatingValid;
      });
    },
  },

  methods: {
    applyFilters() {
      // This method will be called when the "Apply Filters" button is clicked
      // Set the applied filters based on the current state of the filter options
      this.appliedFilters = {
        priceRange: {
          min: this.priceRange.min,
          max: this.priceRange.max
        },
        brands: this.selectedBrands,
        rating: this.selectedRating
      };

      console.log("Filters applied:", this.appliedFilters);
    },

    syncPriceRange() {
      this.priceRange.min = this.priceRange.slider;
      console.log(`Price range is now: $${this.priceRange.slider}`);
    },

    updatePriceRangeSlider() {
      this.priceRange.slider = this.priceRange.min;
    }
  }
}


</script>
  
 
  
