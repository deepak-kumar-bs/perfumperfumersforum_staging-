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
<div class="sesatoz_purcahse_main sesbasic_bxs clearfix">
  <div class="sesatoz_purcahse_inner">
    <div class="_text"><?php echo $this->translate($allParams['description']); ?></div>
    <div class="_link"><a href="<?php echo $allParams['buttonlink']; ?>" target="_blank"><?php echo $this->translate($allParams['buttontext']); ?></a></div>
  </div>
</div>

