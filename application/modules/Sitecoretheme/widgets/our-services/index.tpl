<?php 
 /**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Sitecoretheme
 * @copyright  Copyright 2019-2020 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: index.tpl 2019-07-09 15:11:20Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
$this->headScript()
  ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seaocore/externals/scripts/jquery.min.js');
$this->headScript()
  ->appendFile($this->layout()->staticBaseUrl . 'application/modules/Seaocore/externals/scripts/wow.js');
$this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Seaocore/externals/styles/animate.css');
?>

<script>
  new WOW().init();
</script>

<div class="sitecoretheme_icons_container">
  <div class="sitecoretheme_icons_wrapper <?php echo $this->viewType?>">
    <?php $count = 0; ?>
    <?php foreach( $this->services as $service ): ?>
      <?php
      $iconUrl = $defaultIcon = $this->layout()->staticBaseUrl . 'application/modules/Sitecoretheme/externals/images/services/service_' . $service->service_id . '.png';
      if( $service->file_id ) {
        $icon = Engine_Api::_()->storage()->get($service->file_id);
        $iconUrl = ( $icon ) ? $icon->getPhotoUrl() : $defaultIcon;
      }
      ?>
      <?php if( !($count % 3) || $count == 0 ): ?>
        <div class="sitecoretheme_icons_inner">
        <?php endif; ?>

        <div class="sitecoretheme_icons_content_4 wow animated fadeInUp">
          <div class="sitecoretheme_icons_content_4_inner">
            <div class="_image_icon">
              <span>
                <img src="<?php echo $iconUrl; ?>">
              </span>
            </div>
            <h4><a href="#"><?php echo $this->translate($service->title) ?></a></h4>
            <p><?php echo $this->translate($service->description) ?></p>
          </div>
        </div>

        <?php $count++; ?>
        <?php if( !($count % 3) || $count === count($this->services) ) : ?>
        </div>
      <?php endif; ?>

    <?php endforeach; ?>
  </div>
</div>
<style type="text/css">
	<?php if($this->backgroundImage): ?>
	div.layout_sitecoretheme_our_services{
		background-image: url(<?php echo $this->backgroundImage ?>);
	}
	<?php endif; ?>
	</style>