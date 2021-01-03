<?php require_once 'includes/header.php'; ?>

<div class="d-flex" id="wrapper">
  <div class="container-fluid bg-white m-4">
    <div class="row">        	
      <div class="col-md-2 border-right p-4">                				
        <div class="list-group">
          <h3>Price</h3>
          <?php 

              $category_id = $_GET['category_id'];

              $sql = "SELECT Min(rate) as minPrice, Max(rate) as maxPrice FROM product WHERE categories_id = {$category_id}";
              $query = $connect->query($sql);
              $result = $query->fetch_assoc();

              $minPrice = $result['minPrice'];
              $maxPrice = $result['maxPrice'];
          ?>

          <input type="hidden" id="hidden_minimum_price" value="<?php $minPrice; ?>" />
          <input type="hidden" id="hidden_maximum_price" value="<?php $maxPrice; ?>" />
          <p id="price_show"><?php echo $minPrice ." - ". $maxPrice; ?></p>
          <div id="price_range"></div>
        </div>				
        <div class="list-group mt-4 border-top">
          <h3 class="mt-4">Brand</h3>
          <div style="height: 280px; overflow-y: auto; overflow-x: hidden;">
            <?php
              $category_id = $_GET['category_id'];
              $sql = "SELECT DISTINCT(brand_id) FROM product WHERE active = '1' AND categories_id = {$category_id} ORDER BY product_id DESC";
              $result = $connect->query($sql);

              foreach($result as $row) {
                $brandID = $row['brand_id'];
                $sql2 = "SELECT brand_name FROM brands WHERE brand_id = '$brandID' ";
                $query2 = $connect->query($sql2);
                $result2 = $query2->fetch_assoc();
            ?>
            <div class="list-group-item checkbox">
                <label><input type="checkbox" class="common_selector brand" value="<?php echo $row['brand_id']; ?>"  > <?php echo $result2['brand_name']; ?></label>
            </div>
            <?php } ?>
          </div>
        </div>
      </div>

      <div class="col-md-9">
        <h2 align="center">Product Filters</h2>
        <input type="hidden" name="" id="category_id" value="<?php echo $_GET['category_id']; ?>">
        <div class="row filter_data"></div>
      </div>
    </div>
  </div>
</div>
<style>
    #loading {
      text-align:center; 
      background: url('loader.gif') no-repeat center; 
      height: 150px;
   }
</style>

<script>
  $(document).ready(function(){

    filter_data();

    function filter_data(){
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';
        var category_id = $('#category_id').val();
        var minimum_price = $('#hidden_minimum_price').val();
        var maximum_price = $('#hidden_maximum_price').val();
        var brand = get_filter('brand');
        
        $.ajax({
            url:"php_action/filterData.php",
            method:"POST",
            data:{action:action, category_id:category_id, minimum_price:minimum_price, maximum_price:maximum_price, brand:brand},
            success:function(data){
                $('.filter_data').html(data);
            }
        });
    }

    function get_filter(class_name){
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    $('#price_range').slider({
        range:true,
        min:<?php echo $minPrice; ?>,
        max:<?php echo $maxPrice; ?>,
        values:[<?php echo $minPrice; ?>, <?php echo $maxPrice; ?>],
        step:500,
        stop:function(event, ui) {
            $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
            $('#hidden_minimum_price').val(ui.values[0]);
            $('#hidden_maximum_price').val(ui.values[1]);
            filter_data();
        }
    });

  });
</script>

<?php require_once 'includes/footer.php'; ?>