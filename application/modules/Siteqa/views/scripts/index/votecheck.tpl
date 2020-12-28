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

<style type="text/css">
	table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(odd) {
  background-color: #dddddd;
}
.siteqa_vote_users{padding: 15px;}
.siteqa_vote_users button{margin-top: 20px;}
</style>
<ul class="siteqa_vote_users">
	<?php if(count($this->votes) <= 0): ?>
      <div class="tip">
        <span>
          <?php echo $this->translate('No user voted yet.');?>
        </span>
      </div>
    <?php endif; ?>

	<?php if(count($this->votes) > 0) : ?>
		<table style="width:100%" class="table-bordered">
		  <tr>
		    <th>Username</th>
		    <th>Vote</th>
		  </tr>
		<?php foreach ($this->votes as $value) : ?>
			<tr>
				<td>
					<?php echo $this->user($value['owner_id'])->displayname ?>
				</td>
				<td>
					<?php echo $value['vote']; ?>
				</td>
			</tr>
		<?php endforeach; ?>
		<tr>
			<td>Total Votes : <?php echo ($this->vote_count)??0; ?></td>
			<td></td>
		</tr>
		</table>
		<button onclick="parent.Smoothbox.close();">Close</button>
	<?php endif?>
</ul>