<template>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"><!--For png's-->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/CSS/Shoppingpage.css" />
    <title>Pick & Pay</title>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">Pick & Pay</div>
        <ul class="nav-links">
          <li><a href="/">Home</a></li>
          <li><a href="#">Shop</a></li>
          <li><a href="#">Categories</a></li>
          <li><a href="#">Deals</a></li>
          <li><a href="/">About Us</a></li>
          <li><a href="#" class="cart-icon"><i class="fas fa-shopping-cart"></i></a></li>
          <li><a href="#" class="profile-icon"><i class="fas fa-user"></i></a></li>
        </ul>
      </nav>






    <!-- Main Content -->
<div class="main-content">
  <!-- Filter Panel -->
  <aside class="filter-panel">
    <h4 style="font-size:larger;">Filter By:</h4>
    <br>
    
    
    <!-- Price Range Filter -->
    <div class="filter-section">
      <h4>Category</h4>
      <div class="category">
        <ul>
          <li>
            <input type="checkbox" id="fashion" v-model="selectedCategories" value="Fashion" />
          <label for="Fashion"> Fashion</label>
          </li>
          <li>
            <input type="checkbox" id="electronics" v-model="selectedCategories" value="Electronics" />
          <label for="brand1"> Electronics</label>
          </li>
          <li>
            <input type="checkbox" id="homeApplicants" v-model="selectedCategories" value="Home Applicants" />
          <label for="brand1"> Home Applicants</label>
          </li>
        </ul>
      </div>
      <br>
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
          <input type="checkbox" id="nike" v-model="selectedBrands" value="Nike" />
          <label for="brand1"> Nike</label>
        </li>
        <li>
          <input type="checkbox" id="apple" v-model="selectedBrands" value="Apple"  />
          <label for="brand2"> Apple</label>
        </li>
        <li>
          <input type="checkbox" id="samsung" v-model="selectedBrands" value="Samsung" />
          <label for="brand3"> Samsung</label>
        </li>
        <li>
          <input type="checkbox" id="lg" v-model="selectedBrands" value="LG" />
          <label for="brand4"> LG</label>
        </li>
        <li>
          <input type="checkbox" id="adidas" v-model="selectedBrands" value="Adidas" />
          <label for="brand5"> Adidas</label>
        </li>
        <li>
          <input type="checkbox" id="sony" v-model="selectedBrands" value="Sony" />
          <label for="brand6"> Sony</label>
        </li>
      </ul>
    </div>

    <!-- Rating Filter -->
    <div class="filter-section">
      <h4>Rating</h4>
      <ul>
        <li>
          <input type="radio" name="rating" id="rating4" value="4" v-model="selectedRating" />
          <label for="rating4"> 4+ Stars</label>
        </li>
        <li>
          <input type="radio" name="rating" id="rating3" value="3" v-model="selectedRating" />
          <label for="rating3"> 3+ Stars</label>
        </li>
    <li>
         <input type="radio" name="rating" id="ratingAll" value="" v-model="selectedRating" />
         <label for="ratingAll"> All Ratings</label>
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
                <p class="product-brand">Brand: {{ product.brand }}</p>
                <p class="product-price">Price: ${{ product.price }}</p>
                <p class="product-category">Category: {{ product.category }}</p>
                <p class="product-rating">Rating:
                     <span>
                        <i class="fas fa-star" v-for="i in product.rating" :key="i" style="color: gold;"></i>
                        <i class="far fa-star" v-for="i in (5 - product.rating)" :key="5 - i" style="color: grey;"></i>
                    </span>
                    {{ product.rating }} Stars
                </p>
                <!-- Add to Cart Button -->
                <button class="add-to-cart" @click="openModal(product)">Add to Cart</button>
            </div>
  </section>
   <!-- Modal -->
   <div v-if="showModal" class="modal">
      <div class="modal-content">
        <span class="close" @click="closeModal">&times;</span>

        <!-- Product Details -->
        <h2 class="name-of-product">{{ selectedProduct.name }}</h2>
        <p> Brand: {{ selectedProduct.brand }}</p>
        <p>Price: ${{ selectedProduct.price }}</p>
        <p>Rating:
                     <span>
                        <i class="fas fa-star" v-for="i in selectedProduct.rating" :key="i" style="color: gold;"></i>
                        <i class="far fa-star" v-for="i in (5 - selectedProduct.rating)" :key="5 - i" style="color: grey;"></i>
                    </span>
                    
                </p>
        
        <p>Description:</p>       
        <p  class="description">{{ selectedProduct.description }}</p>
        

        <!-- Slideshow -->
        <div class="slideshow-container">
          <div
            v-for="(slideImages, index) in selectedProduct.slideImages"
            :key="index"
            class="slide"
            :class="{ active: index === currentSlideIndex }"
          >
            <img :src="slideImages" class="slideshow-image" />
          </div>
          
          <button class="prev" @click="changeSlide(-1)">&#10094;</button>
          <button class="next" @click="changeSlide(1)">&#10095;</button>
          <button class="slideButton" @click="GoToPayment">Add</button>
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
      selectedCategories: [],

      showModal: false,
      selectedProduct: {},
      currentSlideIndex: 0, // For slideshow navigation

      products: [
        {
          id: 1,
          name: 'Nike Cap',
          brand: 'Nike',
          price: 40,
          rating: 4,
          category: 'Fashion',
          image: '/images/nike1.3.webp',
          slideImages: ['/images/nike1.jpg', '/images/nike1.3.webp'], // Add images array
          description: "Stay stylish and comfortable with this premium Nike cap. Crafted from durable, breathable materials, it features an adjustable strap for a perfect fit and the iconic Nike swoosh for a sleek, sporty look. Ideal for workouts, outdoor adventures, or everyday wear.",
        },
        {
          id: 2,
          name: 'Apple iphone 15',
          brand: 'Apple',
          price: 999,
          rating: 3,
          category: 'Electronics',
          image: '/images/apple iphone15.jpg',
          slideImages:['/images/apple iphone15.jpg'],
          description:'Experience innovation like never before with the Apple iPhone 15. Featuring a stunning 6.1-inch Super Retina XDR display, lightning-fast A16 Bionic chip, and cutting-edge camera technology, it captures every moment in unparalleled detail. Designed with sleek aluminum and glass, this iPhone is not just a device; it’s a statement. Upgrade your lifestyle today!'
        },
        {
          id: 3,
          name: 'LG Air Conditioner',
          brand: 'LG',
          price: 799,
          rating: 2,
          category: 'Home Applicants',
          image: '/images/LG-air-conditioner1.jpeg',
          description:'Keep your home cool and comfortable with the LG Air Conditioner. Equipped with Dual Inverter technology, it ensures energy-efficient cooling with whisper-quiet operation. Its stylish design blends seamlessly with modern interiors, while features like auto-clean and smart connectivity make it the perfect addition to your home. Breathe fresh, live cool!'
        },
        {
          id: 1,
          name: 'Adidas Shoes',
          brand: 'Adidas',
          price: 79,
          rating: 2,
          category: 'Fashion',
          image: '/images/adidas2.1.jpg',
          slideImages:['/images/adidas2.webp'],
          description:'Take your performance to the next level with Adidas Sports Shoes. Engineered with lightweight materials and responsive cushioning, these shoes deliver unmatched comfort and support for every stride. Whether on the track, trail, or gym, Adidas keeps you moving with style and confidence. Push limits, conquer goals.'

        },{
          id: 3,
          name: 'Samsung-Oven',
          brand: 'Samsung',
          price: 499,
          category: 'Home Applicants',
          rating: 4,
          image: '/images/Samsung-Oven.jpg',
          description:'Cook smarter with the Samsung Oven, your ultimate kitchen companion. Featuring advanced convection technology, it ensures perfectly even cooking every time. The intuitive controls and sleek design make it easy to bake, roast, and grill your favorite dishes. Turn ordinary meals into culinary masterpieces with Samsung.'
        },{
          id: 2,
          name: 'SAMSUNG-GALAXY-S8',
          brand: 'Samsung',
          price: 800,
          category: 'Electronics',
          rating: 5,
          image: '/images/SAMSUNG-GALAXY-S8.jpeg',
          description:'Discover elegance and power with the Samsung Galaxy S8. Featuring an Infinity Display that redefines boundaries, a high-performance Exynos processor, and an exceptional camera, this smartphone is a marvel of innovation. Perfect for multitaskers and creatives, the Galaxy S8 is your gateway to endless possibilities.'
          
        },{
          id: 2,
          name: 'Sony Playstation-4',
          brand: 'Sony',
          price: 899,
          category: 'Electronics',
          rating: 2,
          image: '/images/Sony Playstation4 pro.jpg',
          slideImages:['/images/Sony Playstation4 pro.jpg'],
          description:'Dive into a world of immersive gaming with the Sony PlayStation 4. Featuring a vast library of games, stunning graphics, and a DualShock controller for seamless gameplay, the PS4 is the ultimate entertainment hub. Whether battling foes or exploring new worlds, every adventure feels real with PlayStation.'

        },{
          id: 1,
          name: 'Nike Sports Backpack',
          brand: 'Brand 3',
          price: 99,
          category:'Fashion',
          rating: 4,
          image: '/images/nike3.1.jpeg',
          slideImages:['/images/nike3.jpg','/images/nike3.2.jpg','/images/nike3.3.jpg'],
          description:'Carry your essentials in style with the Nike Sports Backpack. Designed for athletes and adventurers, it features multiple compartments, durable fabric, and ergonomic straps for all-day comfort. Perfect for the gym, school, or travel—wherever you go, Nike has your back.'

        },{
          id: 1,
          name: 'Nike Sports Shoes',
          brand: 'Nike',
          price: 55,
          category:'Fashion',
          rating: 5,
          image: '/images/nike2.1.webp',
          slideImages:['/images/nike2.webp','/images/nike2.2.jpg','/images/nike2.3.jpg'],
          description:'Carry your essentials in style with the Nike Sports Backpack. Designed for athletes and adventurers, it features multiple compartments, durable fabric, and ergonomic straps for all-day comfort. Perfect for the gym, school, or travel—wherever you go, Nike has your back.'
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
        rating: null,
        categories: []
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

        // Filter by selected categories
        const isCategoryValid = this.appliedFilters.categories.length === 0 || this.appliedFilters.categories.includes(product.category);

        return isPriceValid && isBrandValid && isRatingValid && isCategoryValid;
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
        rating: this.selectedRating,
        categories: this.selectedCategories,// Store selected categories in appliedFilters
      };

      console.log("Filters applied:", this.appliedFilters);
    },

    syncPriceRange() {
      this.priceRange.min = this.priceRange.slider;
      console.log(`Price range is now: $${this.priceRange.slider}`);
    },

    updatePriceRangeSlider() {
      this.priceRange.slider = this.priceRange.min;
    },
    openModal(product) {
      this.selectedProduct = { ...product }; // Populate the modal with product details
      this.showModal = true;
      this.currentSlideIndex = 0; // Reset slideshow index
    },
    closeModal() {
      this.showModal = false;
    },
    changeSlide(direction) {
    const slides = document.getElementsByClassName("slide"); // Updated to match the correct class
    const totalSlides = slides.length;

    // Remove active class from current slide
    slides[this.currentSlideIndex].classList.remove("active");

    // Calculate next slide index
    this.currentSlideIndex =
        (this.currentSlideIndex + direction + totalSlides) % totalSlides;

    // Add active class to the new current slide
    slides[this.currentSlideIndex].classList.add("active");
  },
  GoToPayment(){
    this.$inertia.visit('/payment');
  },
    
  },
  mounted() {
    // Initialize slideshow visibility
    const slides = document.getElementsByClassName("slide");
    if (slides.length > 0) slides[0].classList.add("active");
  },
  
};
</script>
  
 
  
