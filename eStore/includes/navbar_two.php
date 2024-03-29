<header class="nav-menu-two">
	<div class="container">
		<div class="row v-center">

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
                                   <a href="home.php"><?php echo $language['home'] ?></a>
                              </li>
                              <li class="menu-item-has-children">
                                   <a href="javascript:void(0);"><?php echo $language['categories'] ?> <i class="fa fa-angle-down"></i></a>
                                   <div class="sub-menu mega-menu mega-menu-column-4">
                                        <?php  
                                        // Visualiza categorias disponiveis com pelomenos um produto activo e relacionado a categoria
                                        $sql = "SELECT c.categories_id, c.categories_name FROM categories AS c INNER JOIN product AS p ON p.categories_id = c.categories_id AND p.active = 1 AND c.categories_status = 1  GROUP BY c.categories_id";
                                        $query = $connect->query($sql);

                                        while ($row = $query->fetch_array()) { 
                                             $categories_id = $row['categories_id'];

                                             ?>
                                             <div class="list-item">
                                                  <h4 class="title"><a href="productFilters.php?category_id=<?php echo $categories_id; ?>"><?php echo $row['categories_name']; ?></a></h4>
                                                  <ul>
                                                       <?php  
                                                       // Visualiza as subcategorias
                                                       $sql1 = "SELECT sub_category_id, sub_category_name FROM sub_categories WHERE categories_id = {$categories_id} AND active = 1";
                                                       $query1 = $connect->query($sql1);

                                                       
                                                       while ($data = $query1->fetch_array()) { ?>
                                                            <li><a href="productFilters.php?category_id=<?php echo $categories_id; ?>"><?php echo $data['sub_category_name']; ?></a></li>
                                                       <?php } ?>

                                                  </ul>
                                             </div>
                                             <?php 
                                        } ?>
                                   </div>
                              </li>
                              <li class="menu-item-has-children">
                                   <a href="javascript:void(0);"><?php echo $language['pages'] ?> <i class="fas fa-angle-down"></i></a>
                                   <div class="sub-menu single-column-menu">
                                        <ul>
                                             <?php if (isset($_SESSION['userId'])){ ?>
                                                  <li><a href="cart.php?c=carts">Carts</a></li>
                                             <?php }else{ ?>
                                                  <li><a href="../sign-in.php">Login</a></li>
                                                  <li><a href="../sign-up.php">Register</a></li>
                                             <?php } ?>
                                             <li><a href="locations.php"><?php echo $language['store-location'] ?></a></li>
                                             <li><a href="locations.php#delivery_location"><?php echo $language['delivery-locations'] ?></a></li>
                                        </ul>
                                   </div>
                              </li>
                              <li>
                                   <a href="#"><?php echo $language['contact'] ?></a>
                              </li>
                         </ul>
                    </nav>
               </div>
               <!-- menu end here -->
               <div class="header-item item-right">
                    <!-- mobile menu trigger -->
                    <div class="mobile-menu-trigger"><i class="fas fa-align-justify"></i></div>
                    <a href="#"><i class="fas fa-search"></i></a>
                    <a href="#"><i class="far fa-heart"></i></a>
                    <?php if (isset($_SESSION['userId'])){ ?>
                         <a href="cart.php?c=cartItems&i=<?php echo $_SESSION['cartId']; ?>"><i class="fas fa-shopping-cart"></i></a>
                    <?php } ?>
               </div>
          </div>
     </div>
</header>
<!-- header end -->

<!-- banner start -->
 <!-- <section class="banner-section">
 	
 </section> -->
 <!-- banner end -->

 <script type="text/javascript">
     const menu = document.querySelector(".menu");
     const menuMain = menu.querySelector(".menu-main");
     const goBack = menu.querySelector(".go-back");
     const menuTrigger = document.querySelector(".mobile-menu-trigger");
     const closeMenu = menu.querySelector(".mobile-menu-close");
     let subMenu;
     menuMain.addEventListener("click", (e) =>{
          if(!menu.classList.contains("active")){
               return;
          }
          if(e.target.closest(".menu-item-has-children")){
               const hasChildren = e.target.closest(".menu-item-has-children");
               showSubMenu(hasChildren);
          }
     });
     goBack.addEventListener("click",() =>{
          hideSubMenu();
     })
     menuTrigger.addEventListener("click",() =>{
          toggleMenu();
     })
     closeMenu.addEventListener("click",() =>{
          toggleMenu();
     })
     document.querySelector(".menu-overlay").addEventListener("click",() =>{
          toggleMenu();
     })
     function toggleMenu(){
          menu.classList.toggle("active");
          document.querySelector(".menu-overlay").classList.toggle("active");
     }
     function showSubMenu(hasChildren){
          subMenu = hasChildren.querySelector(".sub-menu");
          subMenu.classList.add("active");
          subMenu.style.animation = "slideLeft 0.5s ease forwards";
          const menuTitle = hasChildren.querySelector("i").parentNode.childNodes[0].textContent;
          menu.querySelector(".current-menu-title").innerHTML=menuTitle;
          menu.querySelector(".mobile-menu-head").classList.add("active");
     }
     function  hideSubMenu(){  
          subMenu.style.animation = "slideRight 0.5s ease forwards";
          setTimeout(() =>{
               subMenu.classList.remove("active");  
          },500); 
          menu.querySelector(".current-menu-title").innerHTML="";
          menu.querySelector(".mobile-menu-head").classList.remove("active");
     }

     window.onresize = function(){
          if(this.innerWidth >991){
               if(menu.classList.contains("active")){
                    toggleMenu();
               }

          }
     }

</script>