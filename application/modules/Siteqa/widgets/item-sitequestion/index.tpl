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
<?php include_once APPLICATION_PATH . '/application/modules/Siteqa/views/scripts/common_style_css.tpl';
?>
<ul class="siteqa_browse_siteqa_day siteqa_browse_siteqa_day">
	<li>
		<div class="que-img"><?php echo $this->htmlLink($this->dayitem->getHref(), $this->itemBackgroundPhoto($this->dayitem, 'thumb.normal')) ?></div>
		<div class="_of_the_day">
			<h3><?php echo $this->htmlLink($this->dayitem->getHref(), Engine_Api::_()->siteqa()->truncateText($this->dayitem->getTitle(),20)) ?></h3>
			<p><span class="tille-info asked">Asked In :</span> 
			<span><?php echo (Engine_Api::_()->getItem('siteqa_category', 
			$this->dayitem->category_id))->category_name; ?></span>
		</p>

		<div class="qa-profile-tag">
			<?php $questionTags = $this->dayitem->tags()->getTagMaps();
			if (count($questionTags)):?>
				<?php foreach ($questionTags as $tag): ?>
					<span><a href="#">#<?php echo $tag->getTag()->text?></a></span>
				<?php endforeach; ?>
			<?php endif; ?>
		</div>

	</div>
	<div class="_info">
		<span title="Likes">
			<i class="fas fa-thumbs-up"></i><?php echo $this->locale()->toNumber($this->siteqa->like_count) ?></span>
			<span  title="Comments">
				<i class="fas fa-comment"></i>
				<?php echo $this->locale()->toNumber($this->siteqa->comment_count) ?>
			</span>
			<span title="Views">
				<i class="fas fa-eye"></i> <?php echo $this->locale()->toNumber($this->siteqa->view_count) ?>
			</span>
			<span title="Votes">
				<i class="fas fa-vote-yea"></i> <?php echo $this->locale()->toNumber($this->siteqa->vote_count) ?>
			</span>
		</div>
	</li>
</ul>