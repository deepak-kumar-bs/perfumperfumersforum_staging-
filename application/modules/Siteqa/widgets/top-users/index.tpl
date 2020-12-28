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
			<div class="que-img"><?php echo $this->htmlLink($this->user($value->owner_id)->getHref(), $this->itemBackgroundPhoto($this->user($value->owner_id), 'thumb.icon')) ?></div>
			<div class="_of_the_day">
				<h3><?php echo $this->user($value->owner_id)->getTitle(); ?></h3>
				<div class="_info">
					<span title="Views">
						<i class="fas fa-eye"></i> <?php echo $this->locale()->toNumber($value->view_count) ?>
					</span>
					<span title="Votes">
						<i class="fas fa-vote-yea"></i> <?php echo $this->locale()->toNumber($value->vote_count) ?>
					</span>
				</div>
			</div>
		</li>
	<?php endforeach; ?>
<?php endif; ?>
</ul>