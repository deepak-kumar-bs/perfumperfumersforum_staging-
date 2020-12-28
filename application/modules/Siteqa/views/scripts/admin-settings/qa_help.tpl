<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: faq.tpl 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */
?>
<script type="text/javascript">
	function qa_show(id) {
		if($(id).style.display == 'block') {
			$(id).style.display = 'none';
		} else {
			$(id).style.display = 'block';
		}
	}
</script>

<div class="admin_seaocore_files_wrapper">
	<ul class="admin_seaocore_files seaocore_faq">	

		<li>
			<a href="javascript:void(0);" onClick="qa_show('qa_1');"><?php echo $this->translate("I want to configure the various widgets of this plugin according to my requirements? How can I do it ?");?></a>
			<div class='faq' style='display: none;' id='qa_1'>
				<?php echo $this->translate(" To configure the various widgets of this plugin according to your requirements, please place those widgets at the desired locations from the Layout Editor section > select the Pages from the Editing dropdown in the Admin Panel and click on 'edit' option against the desired widgets.");?></a>
			</div>
		</li>

		<li>
			<a href="javascript:void(0);" onClick="qa_show('qa_2');"><?php echo $this->translate("Is it possible to make a Question, a ‘Question of the Day’?");?></a>
			<div class='faq' style='display: none;' id='qa_2'>
				<?php echo $this->translate("Yes, Admin can make any of the Questions as the ‘Question of the Day’ from Admin Panel. He can also mark multiple questions and they will be visible randomly on Browse Questions Page.");?></a>
			</div>
		</li>

		<li>
			<a href="javascript:void(0);" onClick="qa_show('qa_3');"><?php echo $this->translate("How many answers can be marked as best answer?");?></a>
			<div class='faq' style='display: none;' id='qa_3'>
				<?php echo $this->translate("Only one Answer can be marked by either Admin or Question Owner as “Best Answer.”");?></a>
			</div>
		</li>

		<li>
			<a href="javascript:void(0);" onClick="qa_show('qa_4');"><?php echo $this->translate("How can I stop other users from Deleting or Editing the Questions or Answers?");?></a>
			<div class='faq' style='display: none;' id='qa_4'>
				<?php echo $this->translate("There is a Setting on the Admin Panel under Member Level Settings where the User can restrict the Members from Editing and Deleting the Questions and Answers.");?></a>
			</div>
		</li>

		<li>
			<a href="javascript:void(0);" onClick="qa_show('qa_5');"><?php echo $this->translate("Does this plugin have a reCAPTCHA option?");?></a>
			<div class='faq' style='display: none;' id='qa_5'>
				<?php echo $this->translate("No. It does not have the reCAPTCHA option.");?></a>
			</div>
		</li>

		<li>
			<a href="javascript:void(0);" onClick="qa_show('qa_6');"><?php echo $this->translate("Can images or files be uploaded with questions?");?></a>
			<div class='faq' style='display: none;' id='qa_6'>
				<?php echo $this->translate("Yes, User can add images to the questions and answers via option provided and using TinyMce Editor.");?></a>
			</div>
		</li>

		<li>
			<a href="javascript:void(0);" onClick="qa_show('qa_7');"><?php echo $this->translate(" The CSS of this plugin is not coming on my site. What should I do ?");?></a>
			<div class='faq' style='display: none;' id='qa_7'>
				<?php echo $this->translate("Please enable the 'Development Mode' system mode for your site from the Admin homepage and then check the page which was not coming fine. It should now seem fine. Now you can again change the system mode to 'Production Mode.");?></a>
			</div>
		</li>

		<li>
			<a href="javascript:void(0);" onClick="qa_show('qa_8');"><?php echo $this->translate("Can Users Share Questions to Social Sites?");?></a>
			<div class='faq' style='display: none;' id='qa_8'>
				<?php echo $this->translate("Yes, Users can share the Questions to the Social Sites as via a button on Question Profile Page.");?></a>
			</div>
		</li>

	</ul>
</div>