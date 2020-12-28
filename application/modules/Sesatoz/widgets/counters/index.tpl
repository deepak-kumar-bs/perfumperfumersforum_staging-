<?php

/**
 * SocialEngineSolutions
 *
 * @category   Application_Sesatoz
 * @package    Sesatoz
 * @copyright  Copyright 2018-2019 SocialEngineSolutions
 * @license    http://www.socialenginesolutions.com/license/
 * @version    $Id: index.tpl  2018-10-05 00:00:00 SocialEngineSolutions $
 * @author     SocialEngineSolutions
 */
 
 ?>
<?php $allParams = $this->allParams; ?>
<?php $this->headLink()->appendStylesheet($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/styles/styles.css'); ?>
<div class="sesatoz_counters_wrapper" style="background-image:url(<?php echo $this->backgroundimage; ?>);">
  <div class="sesatoz_counters_wrapper_inner">
    <?php if($allParams['counter1'] && $allParams['counter1text']) { ?>
      <div class="counter_item">
          <span class="icon"><i class="fa fa-smile-o" aria-hidden="true"></i></span>
          <span class="counter"><?php echo str_replace('+','',$allParams['counter1']); ?></span>
          <?php if(strpos($allParams['counter1'],'+') !== false ){ ?>
            <span class="counterplus">+</span>
          <?php } ?>
          <span class="name"><?php echo $allParams['counter1text']; ?></span>
      </div>
     <?php } ?>
    <?php if($allParams['counter2'] && $allParams['counter2text']) { ?>
      <div class="counter_item">
          <span class="icon"><i class="fa fa-folder-open-o" aria-hidden="true"></i></span>
          <span class="counter"><?php echo str_replace('+','',$allParams['counter2']); ?></span>
          <?php if(strpos($allParams['counter2'],'+') !== false ){ ?>
            <span class="counterplus">+</span>
          <?php } ?>
          <span class="name"><?php echo $allParams['counter2text']; ?></span>
      </div>
     <?php } ?>
    <?php if($allParams['counter3'] && $allParams['counter3text']) { ?>
      <div class="counter_item">
          <span class="icon"><i class="fa fa-laptop" aria-hidden="true"></i></span>
          <span class="counter"><?php echo str_replace('+','',$allParams['counter3']); ?></span>
          <?php if(strpos($allParams['counter3'],'+') !== false ){ ?>
            <span class="counterplus">+</span>
          <?php } ?>
          <span class="name"><?php echo $allParams['counter3text']; ?></span>
      </div>
     <?php } ?>
    <?php if($allParams['counter4'] && $allParams['counter4text']) { ?>
      <div class="counter_item">
          <span class="icon"><i class="fa fa-flag-o" aria-hidden="true"></i></span>
          <span class="counter"><?php echo str_replace('+','',$allParams['counter4']); ?></span>
          <?php if(strpos($allParams['counter4'],'+') !== false ){ ?>
            <span class="counterplus">+</span>
          <?php } ?>
          <span class="name"><?php echo $allParams['counter4text']; ?></span>
      </div>
     <?php } ?>
  </div>
</div>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/scripts/jquery.min.js'); ?>
<script type="text/javascript">
    counteratoz(document).ready(function($) {
        $('.counter').counterUp({
            delay: 10,
            time: 1000
        });
    });
</script>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/scripts/waypoints.min.js'); ?>
<?php  $this->headScript()->appendFile($this->layout()->staticBaseUrl . 'application/modules/Sesatoz/externals/scripts/jquery.counterup.min.js'); ?>


