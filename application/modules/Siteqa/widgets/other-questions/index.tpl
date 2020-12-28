<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2010-2011 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: index.tpl 2011-05-05 9:40:21Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>
<ul class="sitepage_browse_sitepage_day siteqa_browse_siteqa_day siteqa_top_users">
	<?php if(count($this->paginator) > 0) : ?>
		<?php foreach ($this->paginator as $value) : ?>
			<li>
				<?php if(empty($value->photo_id)) : ?>
                	<div class="que-img"><img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Siteqa/externals/images/question_icon.png'/></div>
	            <?php else : ?>
	                <div class="que-img"><?php echo $this->htmlLink($value->getHref(), $this->itemBackgroundPhoto($value, 'thumb.profile')) ?></div>
	            <?php endif; ?>
				
				<div class="_of_the_day">
					<h3><?php echo $this->htmlLink($value->getHref(), Engine_Api::_()->siteqa()->truncateText($value->getTitle(),$this->truncateLimit)) ?></h3>
					<p><span class="tille-info asked"><?php echo $this->translate('Asked In');?> :</span> 
	              		<span><?php echo (Engine_Api::_()->getItem('siteqa_category', $value->category_id))->category_name; ?></span>
	          		</p>
					<div class="_info">
						<span title="Likes">
							<i class="fas fa-thumbs-up"></i><?php echo ($this->locale()->toNumber($value->like_count)) ?></span>
						<span title="Comments">
							<i class="fas fa-comment"></i>
							<?php echo $this->locale()->toNumber($value->comment_count) ?>
						</span>
					</div>
				</div>
			</li>
		<?php endforeach; ?>
	<?php endif?>
</ul>