<?php
/**
 * SocialEngine
 *
 * @category   Application_Extensions
 * @package    Siteqa
 * @copyright  Copyright 2011-2012 BigStep Technologies Pvt. Ltd.
 * @license    http://www.socialengineaddons.com/license/
 * @version    $Id: Level.php 6590 2012-18-05 00:00:00Z SocialEngineAddOns $
 * @author     SocialEngineAddOns
 */

class Siteqa_Form_Admin_Settings_Level extends Authorization_Form_Admin_Level_Abstract
{
	public function init()
	{
		parent::init();

		$this
		->setTitle('Member Level Settings')
		->setDescription("These settings are applied on a per member level basis. Start by selecting the member level you want to modify, then adjust the settings for that level below.");

		$this->addElement('Radio', 'view', array(
			'label' => 'Allow Viewing of Questions?',
			'description' => 'Do you want to let members view questions? If set to no, some other settings on this page may not apply.',
			'multiOptions' => array(
				1 => 'Yes, allow viewing of questions.',
				0 => 'No, do not allow questions to be viewed.',
			),
			'value' => ( $this->isModerator() ? 1 : 0 ),
		));
		if( !$this->isModerator() ) {
			unset($this->view->options[2]);
		}

		if( !$this->isPublic() ) {

			$this->addElement('Radio', 'create', array(
				'label' => 'Allow Creation of Questions',
				'description' => 'Do you want to let members create questions? If set to no, some other settings on this page may not apply. This is useful if you want members to be able to view questions, but only want certain levels to be able to create.',
				'multiOptions' => array(
					1 => 'Yes, allow creation of questions.',
					0 => 'No, do not allow questions to be created.'
				),
				'value' => ( $this->isModerator() ? 1 : 0 ),
			));

			$this->addElement('Radio', 'edit', array(
				'label' => 'Allow Editing of Questions?',
				'description' => 'Do you want to let members edit questions?',
				'multiOptions' => array(
					2 => 'Yes, allow members to edit everyone\'s questions.',
					1 => 'Yes, allow members to edit their own questions.',
					0 => 'No, do not allow members to edit their questions.',
				),
				'value' => ( $this->isModerator() ? 1 : 0 ),
			));
			if( !$this->isModerator() ) {
				unset($this->edit->options[2]);
			}
			
			$this->addElement('Radio', 'delete', array(
				'label' => 'Allow Deletion of Questions?',
				'description' => 'Do you want to let members delete questions?',
				'multiOptions' => array(
					2 => 'Yes, allow members to delete everyone\'s questions.',
					1 => 'Yes, allow members to delete their own questions.',
					0 => 'No, do not allow members to delete their questions.',
				),
				'value' => ( $this->isModerator() ? 1 : 0 ),
			));
			if( !$this->isModerator() ) {
				unset($this->delete->options[2]);
			}

			$this->addElement('Radio', 'comment', array(
				'label' => 'Allow Commenting on Questions',
				'description' => 'Do you want to let members of this level comment on questions?',
				'multiOptions' => array(
					1 => 'Yes, allow members to comment on questions.',
					0 => 'No, do not allow members to comment on questions.'
				),
				'value' => 1,
			));

			$this->addElement('Radio', 'posting', array(
				'label' => 'Posting of Answers',
				'description' => 'Do you want to let members of this level post answers on questions?',
				'multiOptions' => array(
					1 => 'Yes, allow posting of answers.',
					0 => 'No, do not allow posting of answers.'
				),
				'value' => ( $this->isModerator() ? 1 : 0 ),
			));

			$this->addElement('Radio', 'helpful', array(
				'label' => 'Allow Marking Answers Best answer',
				'description' => 'Do you want to let members of this level mark the best answer for their questions?',
				'multiOptions' => array(
					1 => 'Yes, allow members to mark best answers for their questions.',
					0 => 'No, do not allow members to mark best answers for their questions.'
				),
				'value' => 1,
			));

			$this->addElement('Radio', 'approved', array(
				'label' => ' Auto Approve of Questions',
				'description' => 'Do you want new question to be automatically approved?',
				'multiOptions' => array(
					1 => 'Yes, automatically approve questions.',
					0 => 'No, site admin approval will be required for all questions.'
				),
				'value' => ( $this->isModerator() ? 1 : 0 ),
			));

			$this->addElement('Text', 'max', array(
				'label' => 'Maximum Allowed Questions?',
				'description' => 'Enter the maximum number of allowed question entries. The field must contain an integer between 1 and 999, or 0 for unlimited.',
				'validators' => array(
					array('Int', true),
					new Engine_Validate_AtLeast(0),
				),
			));

		}

		

	}

}