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
$baseURL = $this->baseUrl();
?>

<script type="text/javascript">
  $$('.layout_sitecoretheme_banner_images').each(function (el) {
    el.inject($('global_header'), 'after');
  });
  en4.core.runonce.add(function () {
    var durationOfRotateImage = <?php echo!empty($this->defaultDuration) ? $this->defaultDuration : 500; ?>;
    var slideshowDivObj = $('slide-images');
    var imagesObj = slideshowDivObj.getElements('img');
    var indexOfRotation = 0;

    imagesObj.each(function (img, i) {
      if (i > 0) {
        img.set('opacity', 0);
      }
    });

    var show = function () {
      imagesObj[indexOfRotation].fade('out');
      indexOfRotation = indexOfRotation < imagesObj.length - 1 ? indexOfRotation + 1 : 0;
      imagesObj[indexOfRotation].fade('in');
    };
    show.periodical(durationOfRotateImage);
  });
</script>

<style type="text/css">
  .layout_sitecoretheme_banner_images #slide-images {
    width: <?php echo!empty($this->slideWidth) ? $this->slideWidth . 'px;' : '100%'; ?>;
    height: <?php echo $this->slideHeight . 'px'; ?>;
  }
</style>

<div id="slide-images" class="sitecoretheme_slideblock">
  <?php
  foreach( $this->list as $imagePath ):
    if( !is_array($imagePath) ):
      $iconSrc = "application/modules/Sitecoretheme/externals/images/" . $imagePath;
    else:
      $iconSrc = Engine_Api::_()->sitecoretheme()->displayPhoto($imagePath['file_id'], 'thumb.icon');
    endif;
    if( !empty($iconSrc) ):
      ?>
      <div class="slideblok_image">
        <img src="<?php echo $iconSrc; ?>" />
      </div>
      <?php
    endif;
  endforeach;
  ?>
  <section class="bannerimage-text">
    <div>
      <?php if( $this->verticalHtmlTitle ): ?>
        <h1><?php echo $this->translate($this->verticalHtmlTitle); ?></h1>
      <?php endif; ?>
      <?php if( $this->verticalHtmlDescription ): ?>
        <article><?php echo $this->translate($this->verticalHtmlDescription); ?></article>
      <?php endif; ?>
    </div>
  </section>
</div>