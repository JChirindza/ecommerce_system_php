<header class="nav-menu-two">
	<div class="container">
		<div class="row v-center">
                  <!-- <div class="header-item item-left">
                        <div class="logo">
                              <a href="#">MyStore</a>
                        </div>
                   </div> -->

                   <!-- menu start here -->
                   <div class="header-item item-center">

                    <div class="menu-overlay"></div>

                    <nav class="menu">
                         <div class="mobile-menu-head">
                              <div class="go-back"><i class="fa fa-angle-left"></i></div>
                              <div class="current-menu-title"></div>
                              <div class="mobile-menu-close">&times;</div>
                         </div>
                         <ul class="menu-main">
                              <li>
                                   <a href="#">Home</a>
                              </li>
                              <li class="menu-item-has-children">
                                   <a href="#">New <i class="fa fa-angle-down"></i></a>
                                   <div class="sub-menu mega-menu mega-menu-column-4">
                                        <div class="list-item text-center">
                                             <a href="#">
                                                  <img src="img/p1.jpg" alt="new Product">
                                                  <h4 class="title">Product 1</h4>
                                             </a>
                                        </div>
                                        <div class="list-item text-center">
                                             <a href="#">
                                                  <img src="img/p2.jpg" alt="new Product">
                                                  <h4 class="title">Product 2</h4>
                                             </a>
                                        </div>
                                        <div class="list-item text-center">
                                             <a href="#">
                                                  <img src="img/p3.jpg" alt="new Product">
                                                  <h4 class="title">Product 3</h4>
                                             </a>
                                        </div>
                                        <div class="list-item text-center">
                                             <a href="#">
                                                  <img src="img/p4.jpg" alt="new Product">
                                                  <h4 class="title">Product 4</h4>
                                             </a>
                                        </div>
                                   </div>
                              </li>
                              <li class="menu-item-has-children">
                                   <a href="#">Categories <i class="fa fa-angle-down"></i></a>
                                   <div class="sub-menu mega-menu mega-menu-column-4">
                                        <?php  
                                        $sql = "SELECT categories_id, categories_name FROM categories WHERE categories_active = 1";
                                        $query = $connect->query($sql);

                                        while ($row = $query->fetch_array()) { ?>
                                             <div class="list-item">
                                                  <h4 class="title"><?php echo $row['categories_name']; ?></h4>
                                                  <ul>
                                                       <?php  
                                                       $sql1 = "SELECT sub_category_id, sub_category_name FROM sub_categories WHERE categories_id = {$row['categories_id']} AND active = 1";
                                                       $query1 = $connect->query($sql1);

                                                       while ($data = $query1->fetch_array()) { ?>
                                                            <li><a href="#"><?php echo $data['sub_category_name']; ?></a></li>
                                                       <?php } ?>

                                                  </ul>
                                             </div>
                                             <?php 
                                        } ?>
                                   </div>
                              </li>
                              <li class="menu-item-has-children">
                                   <a href="#">Blog <i class="fas fa-angle-down"></i></a>
                                   <div class="sub-menu single-column-menu">
                                        <ul>
                                             <li><a href="#">Standard Layout</a></li>
                                             <li><a href="#">Grid Layout</a></li>
                                             <li><a href="#">single Post Layout</a></li>
                                        </ul>
                                   </div>
                              </li>
                              <li class="menu-item-has-children">
                                   <a href="#">Pages <i class="fas fa-angle-down"></i></a>
                                   <div class="sub-menu single-column-menu">
                                        <ul>
                                             <li><a href="#">Carts</a></li>
                                             <li><a href="#">Login</a></li>
                                             <li><a href="#">Register</a></li>
                                             <li><a href="#">Store Location</a></li>
                                        </ul>
                                   </div>
                              </li>
                              <li>
                                   <a href="#">Contact</a>
                              </li>
                         </ul>
                    </nav>
               </div>
               <!-- menu end here -->
               <div class="header-item item-right">
                    <!-- mobile menu trigger -->
                    <div class="mobile-menu-trigger"><span></span></div>
                    <a href="#"><i class="fas fa-search"></i></a>
                    <a href="#"><i class="far fa-heart"></i></a>
                    <a href="cart.php?c=cartList"><i class="fas fa-shopping-cart"></i></a>
               </div>
          </div>
     </div>
</header>
<!-- header end -->

<!-- banner start -->
 <!-- <section class="banner-section">
 	
 </section> -->
 <!-- banner end -->

 <script src="custom/js/script_navbar_two.js"></script>