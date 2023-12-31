<?php
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/


get_header(); 

$service_finder_options = get_option('service_finder_options');
$wpdb = service_finder_plugin_global_vars('wpdb');
?>
<?php 
/*Provider Search start*/
 
$getProviders = new SERVICE_FINDER_searchProviders();
$keyword = (isset($_GET['keyword'])) ? esc_html($_GET['keyword']) : '';
$address = (isset($_GET['searchAddress'])) ? esc_html($_GET['searchAddress']) : '';
$city = (isset($_GET['city'])) ? esc_html($_GET['city']) : '';
$catid = (isset($_GET['catid'])) ? esc_html($_GET['catid']) : '';
$country = (isset($_GET['country'])) ? esc_html($_GET['country']) : '';

$price = (isset($_GET['price'])) ? esc_html($_GET['price']) : '';

$minprice = '';
$maxprice = '';
if($price != ""){
$price = explode(',',$price);
if(!empty($price)){
$minprice = $price[0];
$maxprice = $price[1];
}
}
$distance = (isset($_GET['distance'])) ? esc_html($_GET['distance']) : '';

$zoomlevel = 2;
$lat = '28.6430536';
$lng = '77.2223442';

$srhbybooking = (isset($_GET['srhbybooking'])) ? esc_html($_GET['srhbybooking']) : '';
$srhdate = (isset($_GET['srhdate'])) ? esc_html($_GET['srhdate']) : '';
$srhperiod = (isset($_GET['srhperiod'])) ? esc_html($_GET['srhperiod']) : '';
$srhtime = (isset($_GET['srhtime'])) ? esc_html($_GET['srhtime']) : '';
$state = (isset($_GET['state'])) ? $_GET['state'] : '';
$zipcode = (isset($_GET['zipcode'])) ? $_GET['zipcode'] : '';
$srhgender = service_finder_get_data($_GET,'srhgender');

$searchdata = array(
	'srhbybooking' => $srhbybooking,
	'srhdate' => $srhdate,
	'srhperiod' => $srhperiod,
	'srhtime' => $srhtime,
	'state' => $state,
	'zipcode' => $zipcode,
	'srhgender' => $srhgender
);

$providersInfo = $getProviders->service_finder_getSearchedProviders($searchdata,esc_attr($distance),esc_attr($minprice),esc_attr($maxprice),esc_attr($keyword),esc_attr($address),esc_attr($city),esc_attr($catid),esc_attr($country));
$totalresult = $providersInfo['count'];
?>
<!-- Search Style 1 Start -->
<?php if($service_finder_options['search-template'] == 'style-1'): ?>

<div class="page-content clearfix">
  <!-- If map is on in search page -->
  <?php if($service_finder_options['search-header-style'] == 'map'){
		?>
  <div class="sf-map-row"> <?php echo do_shortcode('[service_finder_map_search general_latitude="'.$lat.'" general_longitude="'.$lng.'"]'); ?>
    <div class="sf-find-bar wow fadeInDown default-hidden" id="no-result">
      <div class="container">
        <!-- No results found -->
        <div class="no-result-bx">
          <?php esc_html_e('No Result Found', 'service-finder'); ?>
        </div>
      </div>
    </div>
    <!-- inner page banner END -->
    <!-- Search form start -->
    <?php if(!$service_finder_options['srhresult-search-bar']){ 
	$classes = (service_finder_themestyle() == 'style-2') ? 'sf-search-result' : '';
	 $srhposition = (!empty($service_finder_options['search-bar-position-searchpage'])) ? $service_finder_options['search-bar-position-searchpage'] : 'bottom';
	if($srhposition == 'middle'){
		$positionclass = 'pos-v-center';
	}else{
		$positionclass = 'pos-v-bottom';
    }
	?>
    <div class="sf-find-bar-inr <?php echo $classes; ?> <?php echo sanitize_html_class($positionclass); ?>">
      <div class="container">
        <?php if(service_finder_themestyle() == 'style-2'){ ?>
      <ul class="sf-search-title clearfix">
            <li><?php echo esc_html__('Search Provider', 'service-finder'); ?></li>
        </ul>
       <?php } ?>
       <?php $advanceclass = (service_finder_check_advance_search()) ? '' : 'sf-empty-radius'; ?>
	    <div class="search-form <?php echo sanitize_html_class($advanceclass); ?>">
          <?php echo do_shortcode('[service_finder_search_form]'); ?>
        </div>
      </div>
    </div>
    <?php } ?>
    <!-- Search form end -->
  </div>
  <?php
		}else{
		?>
  <?php 
  $subheader = service_finder_sub_header_pl();
  $innersubheaderbgimage = service_finder_innerpage_banner_pl();
  if($subheader && $innersubheaderbgimage){ 
 $bannerimg = service_finder_innerpage_banner_pl();
  $class = '';
  }else{
  $bannerimg = '';  
  $class = 'provider-banner-off';
  }
  
  $bgcolor = (!empty($service_finder_options['inner-banner-bg-color'])) ? $service_finder_options['inner-banner-bg-color'] : '';
  $bgopacity = (!empty($service_finder_options['inner-banner-opacity'])) ? $service_finder_options['inner-banner-opacity'] : '';
  ?>
  <!-- If banner is on in search page -->
  <?php if(!$service_finder_options['srhresult-search-bar'] || $bannerimg != ""){ ?>
  <div class="sf-search-benner sf-overlay-wrapper">
  <div class="banner-inner-row <?php echo sanitize_html_class($class); ?>" style="background-image:url(<?php echo esc_url($bannerimg) ?>);">
  <div class="sf-overlay-main" style="opacity:<?php echo $bgopacity ?>; background-color:<?php echo $bgcolor ?>;"></div>
  </div>
  
  <!-- Search form start -->
  <?php if(!$service_finder_options['srhresult-search-bar']){ 
  $classes = (service_finder_themestyle() == 'style-2') ? 'sf-search-result' : '';
  $srhposition = (!empty($service_finder_options['search-bar-position-searchpage'])) ? $service_finder_options['search-bar-position-searchpage'] : 'bottom';
	if($srhposition == 'middle'){
		$positionclass = 'pos-v-center';
	}else{
		$positionclass = 'pos-v-bottom';
    }
  ?>
  <div class="sf-find-bar-inr <?php echo $classes; ?> <?php echo sanitize_html_class($positionclass); ?>">
      <div class="container">
      <?php if(service_finder_themestyle() == 'style-2'){ ?>
      <ul class="sf-search-title clearfix">
            <li><?php echo esc_html__('Search Provider', 'service-finder'); ?></li>
        </ul>
       <?php } ?>
       <?php $advanceclass = (service_finder_check_advance_search()) ? '' : 'sf-empty-radius'; ?>
	    <div class="search-form <?php echo sanitize_html_class($advanceclass); ?>">
          <?php echo do_shortcode('[service_finder_search_form]'); ?>
        </div>
      </div>
    </div>
  <?php } ?>  
  <!-- Search form end -->
  </div> 
  <?php } ?>   
  <!-- inner page banner END -->
  <?php
		} ?>

  <?php require SERVICE_FINDER_BOOKING_FRONTEND_DIR . '/breadcrumb.php'; //Breadcrumb ?>
  <!-- Search result start for providers -->
  <!-- Left & right section start -->
  <div class="container">
    <?php require SERVICE_FINDER_BOOKING_FRONTEND_MODULE_DIR . '/search/templates/search-providers.php';?>
  </div>
  <!-- Search result end for providers -->
</div>
<!-- Search Style 1 End -->
<?php get_footer(); ?>
<!-- Search Style 2 Start -->
<!-- Left & right section  END -->
<?php elseif($service_finder_options['search-template'] == 'style-2'):?>
<div class="page-content clearfix sf-map-serach-page">
  <!-- Google map on left side -->
  <div class="google-map-fixed"> <?php echo do_shortcode('[service_finder_map_search general_latitude="'.$lat.'" general_longitude="'.$lng.'"]'); ?> </div>
  <div class="sf-find-bar wow fadeInDown default-hidden" id="no-result">
    <div class="container">
      <!-- No results found -->
      <div class="no-result-bx">
        <?php esc_html_e('No Result Found', 'service-finder'); ?>
      </div>
    </div>
  </div>
  <!-- Search provider results start -->
  <?php require SERVICE_FINDER_BOOKING_FRONTEND_MODULE_DIR . '/search/templates/search-providers-v2.php';?>
  <!-- Search provider results end -->
</div>
<?php wp_footer(); ?>
<!-- Loading area start for 2 search style -->
<div class="loading-area default-hidden">
  <div class="loading-box"></div>
  <div class="loading-pic"></div>
</div>
<!-- Loading area end for 2 search style -->
</body>
</html>
<?php endif; ?>
