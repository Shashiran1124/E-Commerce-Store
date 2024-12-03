<template>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/CSS/Homepage.css" />
  <div class="homepage">

    
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
      <div class="user-actions">
        <button @click="goToLogin" class="login-btn">Login</button>
        <button @click="goToSignUp" class="signup-btn">Sign Up</button>
      </div>
    </nav>

  <!-- Welcome Section -->
  <section class="welcome-section">
      <h1><b>Welcome to Pick & Pay!</b></h1>
      <p>Your one-stop destination for everything you need – from everyday essentials to the latest trends. At Pick & Pay, we make shopping easy, affordable, and enjoyable.</p>
      <p>🛒 <strong>Shop with ease, pay with confidence, and discover the joy of effortless shopping.</strong></p>
      <ul>
        <li><strong>Wide Variety:</strong> Thousands of products across categories to choose from.</li>
        <li><strong>Great Deals:</strong> Unbeatable prices and exclusive offers just for you.</li>
        <li><strong>Fast Delivery:</strong> Your favorite items, delivered to your doorstep in no time.</li>
      </ul>
      <button class="explore-btn">Ready to Explore? Start Shopping Now!</button>
    </section>


      <!-- Content Section -->
      <div class="content">
       <!-- Slideshow -->
       <div class="slideshow-container">
        <!-- Left Arrow -->
    <div class="arrow left" @click="prevSlide">&#10094;</div>
    <div 
    v-for="(slide, index) in slides" 
  :key="index"
  :class="{
    'slide': true, 
    'slide-active': currentSlideIndex === index, 
    'slide-next': currentSlideIndex === (index + 1) % slides.length,  // Next slide
    'slide-prev': currentSlideIndex === (index - 1 + slides.length) % slides.length  // Previous slide
  }"
    >
      <img v-lazy="slide" alt="Slide Image" class="slide-image" />
    </div>
    <!-- Right Arrow -->
    <div class="arrow right" @click="nextSlide">&#10095;</div>
  </div>


        <!-- Featured Categories -->
        <div class="categories">
          <h2><b>Shop by Category</b></h2>
          <div class="category-list">
            <div class="category" v-for="category in categories" :key="category.id">
                <div class="category-image-container">
                  <img v-lazy="category.image" :alt="category.name" />
                </div>
                  <h3>{{ category.name }}</h3>
            </div>
        </div>
      </div>

        <!-- Featured Products -->
        <div class="products">
          <h2><b>Featured Products</b></h2>
          <div class="product-list">
            <div class="product" v-for="product in products" :key="product.id">
              <img v-lazy="product.image" :alt="product.name" />
              <h3>{{ product.name }}</h3>
              <p>{{ product.price }}</p>
              <button @click="addToCart(product.id)"class="add-to-cart-button">Add to Cart</button>
            </div>
          </div>
        </div>
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


export default {
  name: 'Homepage',
  
  data() {
    return {
      categories: [
        { id: 1, name: 'Electronics', image: '/images/electronics-1.jpeg' },
        { id: 2, name: 'Fashion', image: '/images/Fashion1.jpeg' },
        { id: 3, name: 'Home Appliances', image: '/images/Homestuff.jpg' },
      ],
      products: [
        { id: 1, name: 'Smartphone', price: '$299', image: '/images/smartPhones1.jpg' },
        { id: 2, name: 'Headphones', price: '$99', image: '/images/Headphone1.jpg' },
        { id: 3, name: 'Laptop', price: '$899', image: '/images/Laptop1.jpg' },
      ],
      priceRange: {
        min: 0,
        max: 1000,
        slider: 0, // Default value of the slider
      },
      selectedBrands: [],
      selectedRating: null,
      slideshowInterval: null,
      // Slideshow data
      currentSlideIndex: 0, // Keeps track of the current slide
      slides: [
        '/images/HomepageBackground.webp',
        '/images/Laptop1.jpg',
        '/images/Fashion1.jpeg',
        '/images/Homestuff.jpg',
        '/images/smartPhones1.jpg',
      ],
    };
  },
  computed: {
    filteredProducts() {
      return this.products.filter(product => {
        // Filter by price range
        const isPriceValid = product.price >= this.priceRange.min && product.price <= this.priceRange.max;

        // Filter by selected brands
        const isBrandValid = this.selectedBrands.length === 0 || this.selectedBrands.includes(product.brand);

        // Filter by selected rating
        const isRatingValid = !this.selectedRating || product.rating >= this.selectedRating;

        return isPriceValid && isBrandValid && isRatingValid;
      });
    },
  },
  methods: {
    

    addToCart(productId) {
      console.log(`Product ${productId} added to cart`);
    },
    syncPriceRange() {
      // This method will be called whenever the slider value changes.
      // Update min to match the slider value when the user changes the range slider
      this.priceRange.min = this.priceRange.slider;
      console.log(`Price range is now: $${this.priceRange.slider}`);
    },
    updatePriceRangeSlider() {
      // When the user manually inputs a value for the min price, update the slider
      this.priceRange.slider = this.priceRange.min;
    },
  },

  mounted() {
    this.startSlideshow();
  },
  beforeUnmount() {
    clearInterval(this.slideshowInterval);
  },
  methods: {

    startSlideshow() {
      this.slideshowInterval = setInterval(() => {
        this.nextSlide();
      }, 20000); // Auto-slide every 5 seconds
    },
    nextSlide() {
      
      this.currentSlideIndex = (this.currentSlideIndex - 1 + this.slides.length) % this.slides.length;
    },
    prevSlide() {
      this.currentSlideIndex = (this.currentSlideIndex + 1) % this.slides.length;
    },
    goToSlide(index) {
      this.currentSlideIndex = index;
    },
    //Buttons
    goToSignUp(){
      // Open the registration page in a new tab
      const newTab = window.open('/register', 'Registration');
      if (newTab) {
        newTab.document.title = 'Registration';  // Set the title dynamically
      }
    },
    goToLogin(){
      const newTab = window.open('/login', 'Login');
      if (newTab) {
        newTab.document.title = 'Log-in';  // Set the title dynamically
      }
    },

  },
};
</script>





