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
<?php $enablePopUp = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz_popupsign', 1);  ?>
<?php $showPopup = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.popup.enable', 1);?>
<?php $baseUrl = $this->layout()->staticBaseUrl; ?>
<?php if($this->viewer->getIdentity() == 0) : ?>
  <script type="text/javascript" src="<?php echo $baseUrl; ?>application/modules/Sesatoz/externals/scripts/jquery-latest.min.js"></script>
  <script>var ses = $.noConflict();</script>
  <script src="<?php echo $baseUrl; ?>application/modules/Sesatoz/externals/scripts/jquery.magnific-popup.js"></script>
  <link href="<?php echo $baseUrl; ?>application/modules/Sesatoz/externals/styles/magnific-popup.css" rel="stylesheet" />
<?php endif;?>
  
<?php $request = Zend_Controller_Front::getInstance()->getRequest();?>
<?php $controllerName = $request->getControllerName();?>
<?php $actionName = $request->getActionName();?>
  
<?php $showSeparator = 0;?> 
<?php $settings = Engine_Api::_()->getApi('settings', 'core');?>
<?php $facebook = Engine_Api::_()->getDbtable('facebook', 'user')->getApi();?>
<?php if ('none' != $settings->getSetting('core_facebook_enable', 'none') && $settings->core_facebook_secret && $facebook):?>
  <?php $showSeparator = 1;?>
<?php elseif ('none' != $settings->getSetting('core_twitter_enable', 'none') && $settings->core_twitter_secret):?>
  <?php $showSeparator = 1;?>
<?php endif;?>
  
<?php $siteTitle = Engine_Api::_()->getApi('settings', 'core')->getSetting('core.general.site.title','1');?>
<?php if($this->viewer->getIdentity() == 0):?>
    <?php if(!empty($showSeparator)) { ?>
  	<div id="small-dialog" class="zoom-anim-dialog mfp-hide sesatoz_quick_popup sesatoz_quick_login_popup sesbasic_bxs">
    <?php } else { ?>
      <div id="small-dialog" class="zoom-anim-dialog mfp-hide sesatoz_quick_popup sesatoz_quick_login_popup sesbasic_bxs _nosbtns">
    <?php } ?>
    <div class="sesatoz_popup_header clearfix">
      <div class="sesatoz_popup_header_title"><?php echo $this->translate("Sign In");?></div>  
    </div>
    
    <div class="sesatoz_popup_content clearfix">
      <div class="sesatoz_popup_social">
          <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
          <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle(); ?>
          <div class="sesatoz_social_login_btns <?php if($numberOfLogin < 3):?>social_login_btns_label<?php endif;?>">
            <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
          </div>
        <?php endif; ?>
        </div>
    	<div class="sesatoz_quick_popup_form sesatoz_popup_login">
        <?php echo $this->content()->renderWidget("sesatoz.login-or-signup")?>
      </div>
    </div>
    <div class="sesatoz_popup_footer clearfix">
			<?php if($controllerName != 'signup'){ ?>
      	<span>
            <?php echo $this->translate("No account yet?");?> <a class="popup-with-move-anim tab-link" href="#user_signup_form"><?php echo $this->translate("Sign Up Now!");?></a>
        </span>
      <?php } ?>
    </div>
  </div>

  <?php if($controllerName != 'signup'){ ?>
  	<?php if(!empty($showSeparator)){?>
    	<div id="user_signup_form" class="zoom-anim-dialog mfp-hide sesatoz_quick_popup sesbasic_bxs sesatoz_quick_signup_popup">
    <?php } else { ?>
      <div id="user_signup_form" class="zoom-anim-dialog mfp-hide sesatoz_quick_popup sesbasic_bxs sesatoz_quick_signup_popup _nosbtns">
    <?php }; ?>
      <div class="sesatoz_popup_header clearfix">
        <div class="sesatoz_popup_header_title"><?php echo $this->translate("Sign In");?></div>
      </div>
    	<div class="sesatoz_popup_content clearfix">
       <div class="sesatoz_popup_social">
           <?php if(Engine_Api::_()->getDbTable('modules','core')->isModuleEnabled('sessociallogin')):?>
          <?php $numberOfLogin = Engine_Api::_()->sessociallogin()->iconStyle(); ?>
          <div class="sesatoz_social_login_btns <?php if($numberOfLogin < 3):?>social_login_btns_label<?php endif;?>">
            <?php  echo $this->partial('_socialLoginIcons.tpl','sessociallogin',array()); ?>
          </div>
        <?php endif; ?>
            </div>
      	<div class="sesatoz_quick_popup_form sesatoz_popup_signup">
          <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>
          <?php echo $this->action("index", "signup", defined('sesquicksignup') ? "quicksignup" : 'sesatoz', array('disableContent'=>true)) ?>
          <?php } ?>
          <div class="sesatoz_popup_footer clearfix">
        <span>Already a member? <a class="popup-with-move-anim tab-link" href="#small-dialog"><?php echo $this->translate("Sign In");?></a></span>
      </div>
        </div>
      </div>
    </div>
  <?php } ?>
<?php endif;?>
<div id='core_menu_mini_menu'>
  <?php
    // Reverse the navigation order (they are floating right)
    $count = count($this->navigation);
    foreach( $this->navigation->getPages() as $item ) $item->setOrder(--$count);
  ?>
    <ul class="sesatoz_minimenu_links">
    <?php foreach( $this->navigation as $item ):
      $className = explode(' ', $item->class);
    ?>
      <?php if(end($className) == 'core_mini_signup'):?>
        <li class="sesatoz_minimenu_link sesatoz_minimenu_signup">
          <?php if($controllerName != 'signup') { ?>
            <a id="popup-signup" <?php if($this->poupup){ ?> <?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?> class="popup-with-move-anim" <?php } ?> <?php } ?> href="<?php if($this->poupup && $controllerName != 'auth' && $actionName != 'login'){ ?>#user_signup_form<?php }else{ echo 'signup'; } ?>">
            	<i class="fa fa-plus"></i>
              <span><?php echo $this->translate($item->getLabel());?></span>
            </a>
          <?php } ?>
        </li>
      <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() == 0): ?>
        <?php if($controllerName != 'auth'  && $actionName != 'login'){ ?>
          <li class="sesatoz_minimenu_link sesatoz_minimenu_login">
            <a id="popup-login" <?php if($this->poupup){ ?> class="popup-with-move-anim" <?php } ?> href="<?php if($this->poupup){ ?>#small-dialog <?php }else{ echo 'login'; } ?>">
              <i class="fa fa-user"></i>
              <span><?php echo $this->translate($item->getLabel());?></span>
            </a>
          </li>
        <?php } ?>
      <?php elseif(end($className) == 'core_mini_auth' && $this->viewer->getIdentity() != 0):?>
          <?php continue;?>
      <?php elseif(end($className) == 'core_mini_friends'):?>
           <?php $friendRequestIcon = Engine_Api::_()->sesatoz()->getMenuIcon('core_mini_friends');?>
          <?php if($this->viewer->getIdentity()):?>
             <li class="sesatoz_minimenu_request sesatoz_minimenu_icon">
            <?php if($this->requestCount):?>
              <span id="request_count_new" class="sesatoz_minimenu_count"><?php echo $this->requestCount ?></span>
            <?php else:?>
              <span id="request_count_new"></span>
            <?php endif;?>
          <span onclick="toggleUpdatesPulldown(event, this, '4', 'friendrequest');" style="display:block;" class="friends_pulldown">
            <div id="friend_request" class="sesatoz_pulldown_contents_wrapper">
              <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
              <div class="sesatoz_pulldown_header">
                <?php echo $this->translate('Requests'); ?>
              </div>
              <div id="sesatoz_friend_request_content" class="sesatoz_pulldown_contents clearfix">
                <div class="pulldown_loading" id="friend_request_loading">
                  <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                </div>
              </div>
            </div>
            <?php
              $minimenu_frrequest_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.normal', 0); 
              $minimenu_frrequest_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.mouseover', 0);
            ?>
            <?php if(empty($minimenu_frrequest_normal) && empty($minimenu_frrequest_mouseover)):?>
              <a href="javascript:void(0);" id="show_request" class="fa fa-user-plus" title="<?php echo $this->translate("Friend Requests");?>">
                <span><?php echo $this->translate('Friends Invitation');?></span>
              </a>
            <?php else:?>
              <a href="javascript:void(0);" class="sesatoz_mini_menu_friendrequest" id="show_request" title="<?php echo $this->translate("Friend Requests");?>"><i id="show_request"></i>
                <span><?php echo $this->translate('Friends Invitation');?></span>
              </a>
            <?php endif;?>
          </span>
        </li>
        <?php endif;?>
        <?php elseif(end($className) == 'core_mini_notification'):?>
        
        <?php if($this->viewer->getIdentity()):?>
          <li id='core_menu_mini_menu_update' class="sesatoz_minimenu_updates sesatoz_minimenu_icon">
              <?php if($this->notificationCount):?>
                <span id="notification_count_new" class="sesatoz_minimenu_count">
                  <?php echo $this->notificationCount ?>
                </span>
              <?php else:?>
                <span id="notification_count_new"></span>
              <?php endif;?>
            <span onclick="toggleUpdatesPulldown(event, this, '4', 'notifications');" style="display:block;" class="updates_pulldown">
              <div class="sesatoz_pulldown_contents_wrapper">
                <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
                <div class="sesatoz_pulldown_header">
                  <?php echo $this->translate('Notifications'); ?>
                </div>
                <div class="sesatoz_pulldown_contents pulldown_content_list">
                  <ul class="notifications_menu" id="notifications_menu">
                    <div class="pulldown_loading" id="notifications_loading">
                      <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                    </div>
                  </ul>
                </div>
                <div class="pulldown_options">
                  <?php echo $this->htmlLink(array('route' => 'default', 'module' => 'activity', 'controller' => 'notifications'),
                     $this->translate('View All Updates'),
                     array('id' => 'notifications_viewall_link')) ?>
                  <?php echo $this->htmlLink('javascript:void(0);', $this->translate('Mark All Read'), array(
                    'id' => 'notifications_markread_link',
                  )) ?>
                </div>
              </div>
              <?php 
                $minimenu_notification_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.notification.normal', ''); 
                $minimenu_notification_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.notification.mouseover', 0);
              ?>
              <?php if(empty($minimenu_notification_normal) && empty($minimenu_notification_mouseover)):?>
                <a href="javascript:void(0);"  id="show_update" class="fa fa-bell" title="<?php echo $this->translate("Notificatons");?>">
                	<span id="updates_toggle"><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span>
                </a>
              <?php else:?>
                <a href="javascript:void(0);" id="show_update" class="<?php if( $this->notificationCount ):?>new_updates<?php endif;?> sesatoz_mini_menu_notification" title="<?php echo $this->translate("Notificatons");?>"><i id="show_update"></i>
                <span id="updates_toggle"><?php echo $this->translate($this->locale()->toNumber($this->notificationCount)) ?></span></a>
              <?php endif;?>
            </span>
          </li>
        <?php endif;?>
      <?php elseif(end($className) == 'core_mini_settings'):?>
        <?php $minimenu_user_photo = Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.miniuserphotoround',1); ?>
        <?php $settingIcon = Engine_Api::_()->sesatoz()->getMenuIcon('core_mini_settings');?>
        <li class="sesatoz_minimenu_setting sesatoz_minimenu_icon <?php if($minimenu_user_photo): ?> _isrounded <?php endif; ?>">
          <span style="display:block;" class="settings_pulldown" onclick="toggleUpdatesPulldown(event, this, '4', 'settings');">
            <div id="user_settings" class="sesatoz_pulldown_contents_wrapper atoz-mini-menu-settings-pulldown">
              <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
              <div class="sesatoz_pulldown_header">
                <?php echo $this->translate('Account & Settings');?>
              </div>
              <div id="sesatoz_user_settings_content" class="sesatoz_pulldown_contents clearfix">
                <?php $viewer = Engine_Api::_()->user()->getViewer();?>
                <ul>
                  
                  <li><a href="<?php echo $viewer->getHref(); ?>"><?php echo $this->translate("My Profile");?></a></li>
                </ul>
                <?php echo $this->navigation()->menu()->setContainer($this->settingNavigation)->render();?>
                <ul>
                  <?php if($viewer->level_id == 1 || $viewer->level_id == 2):?>
                    <li>
                      <a href="<?php echo $this->url(array(), 'admin_default', true)?>"><?php echo $this->translate('Administrator');?></a>
                    </li>
                  <?php endif;?>
                  <li>
                    <a href="<?php echo $this->url(array(), 'user_logout', true)?>"><?php echo $this->translate('Logout');?></a>
                  </li>
                </ul>
              </div>
            </div>
            <a href="javascript:void(0);" id="show_settings" title="<?php echo $this->translate('Account & Settings');?>">
              <?php echo $this->itemPhoto($this->viewer(), 'thumb.icon','',array('id'=>'show_settings_img')) ?>
            </a>
          </span>
        </li>
      <?php elseif(end($className) == 'core_mini_messages'):?>
        <?php $messageIcon = Engine_Api::_()->sesatoz()->getMenuIcon('core_mini_messages');?>
        <li class="sesatoz_minimenu_message sesatoz_minimenu_icon">
          <?php if($this->messageCount):?>
            <span id="message_count_new" class="sesatoz_minimenu_count"><?php echo $this->messageCount ?></span>
          <?php else:?>
            <span id="message_count_new"></span>
          <?php endif;?>
          <span onclick="toggleUpdatesPulldown(event, this, '4', 'message');" style="display:block;" class="messages_pulldown">
            <div id="sesatoz_user_messages" class="sesatoz_pulldown_contents_wrapper atoz-mini-menu-messages-pulldown">
              <div class="dropdown_caret"><span class="caret_outer"></span><span class="caret_inner"></span></div>
              <div class="sesatoz_pulldown_header">
                <?php echo $this->translate('Messages'); ?>
                <a class="icon_message_new righticon fa fa-plus" title="<?php echo $this->translate('Compose New Message'); ?>" href="<?php echo $this->url(array('action' => 'compose'), 'messages_general') ?>"></a>
              </div>
              <div id="sesatoz_user_messages_content" class="sesatoz_pulldown_contents clearfix">
                <div class="pulldown_loading">
                  <img src='<?php echo $this->layout()->staticBaseUrl ?>application/modules/Core/externals/images/loading.gif' alt="<?php echo $this->translate('Loading'); ?>" />
                </div>
              </div>
            </div>
            <?php
              $minimenu_message_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.message.normal', 0); 
              $minimenu_message_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.message.mouseover', 0);
            ?>
            <?php if(empty($minimenu_message_normal) && empty($minimenu_message_mouseover)):?>
              <a href="javascript:void(0);" id="show_message" class="fa fa-comments" title="<?php echo $this->translate("Messages");?>">
              	<span><?php echo $this->translate($item->getLabel());?></span>
              </a>
            <?php else:?>
              <a href="javascript:void(0);" class="sesatoz_mini_menu_message" id="show_message" title="<?php echo $this->translate("Messages");?>"><i id="show_message"></i>
              	<span><?php echo $this->translate($item->getLabel());?></span>
              </a>
            <?php endif;?>
          </span>
        </li>
      <?php elseif(end($className) == 'core_mini_admin'):?>
        <?php continue;?>
      <?php else:?>
        <li class="sesatoz_minimenu_link">
          <?php echo $this->htmlLink($item->getHref(), $this->translate($item->getLabel()), array_filter(array(
          'class' => ( !empty($item->class) ? $item->class : null ),
          'alt' => ( !empty($item->alt) ? $item->alt : null ),
          'target' => ( !empty($item->target) ? $item->target : null ),
          ))) ?>
        </li>
      <?php endif;?>
    <?php endforeach; ?>
  </ul>
</div>
<style>
<?php 
$minimenu_notification_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.notification.normal', ''); 
$minimenu_notification_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.notification.mouseover', 0);
?>
<?php if($minimenu_notification_normal): ?>
<?php
$img_path = Engine_Api::_()->storage()->get($minimenu_notification_normal, '')->getPhotoUrl();
$path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
?>
<?php endif; ?>

<?php if($minimenu_notification_mouseover): ?>
<?php
$img_path = Engine_Api::_()->storage()->get($minimenu_notification_mouseover, '')->getPhotoUrl();
$path_1 = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
?>
<?php endif; ?>

<?php if($minimenu_notification_normal): ?>
  .sesatoz_mini_menu_notification i {
    background-image:url('<?php echo $path; ?>');
  }
<?php endif; ?>

<?php if($minimenu_notification_mouseover): ?>
  .sesatoz_mini_menu_notification:hover i,
	.updates_pulldown_selected .sesatoz_mini_menu_notification i  {
    background-image:url('<?php echo $path_1; ?>');
  }
<?php endif; ?>
<?php
$minimenu_message_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.message.normal', 0); 
$minimenu_message_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.message.mouseover', 0);
?>
<?php if($minimenu_message_normal): ?>
<?php
$img_path = Engine_Api::_()->storage()->get($minimenu_message_normal, '')->getPhotoUrl();
$path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
?>
<?php endif; ?>

<?php if($minimenu_message_mouseover): ?>
<?php
$img_path = Engine_Api::_()->storage()->get($minimenu_message_mouseover, '')->getPhotoUrl();
$path_1 = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
?>
<?php endif; ?>
<?php if($minimenu_message_normal): ?>
  .sesatoz_mini_menu_message i {
    background-image:url('<?php echo $path; ?>');
  }
<?php endif; ?>
<?php if($minimenu_message_mouseover): ?>
  .sesatoz_mini_menu_message:hover i,
	.messages_pulldown_selected .sesatoz_mini_menu_message i {
    background-image:url('<?php echo $path_1; ?>');
  }
<?php endif; ?>
<?php
$minimenu_frrequest_normal = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.normal', 0); 
$minimenu_frrequest_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.mouseover', 0);
?>
<?php if($minimenu_frrequest_normal): ?>
<?php
$img_path = Engine_Api::_()->storage()->get($minimenu_frrequest_normal, '')->getPhotoUrl();
$path = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
?>
<?php endif; ?>
<?php $minimenu_frrequest_mouseover = Engine_Api::_()->getApi('settings', 'core')->getSetting('minimenu.frrequest.mouseover', 0); ?>
<?php if($minimenu_frrequest_mouseover): ?>
<?php
$img_path = Engine_Api::_()->storage()->get($minimenu_frrequest_mouseover, '')->getPhotoUrl();
$path_1 = 'http://' . $_SERVER['HTTP_HOST'] . $img_path;
?>
<?php endif; ?>
<?php if($minimenu_frrequest_normal): ?>
  .sesatoz_mini_menu_friendrequest i {
    background-image:url('<?php echo $path; ?>');
  }
<?php endif; ?>
<?php if($minimenu_frrequest_mouseover): ?>
  .sesatoz_mini_menu_friendrequest:hover i,
	.friends_pulldown_selected .sesatoz_mini_menu_friendrequest i {
    background-image:url('<?php echo $path_1; ?>');
  }
<?php endif; ?>

</style>
<script type='text/javascript'>
  var notificationUpdater;
  en4.core.runonce.add(function(){
  
    if($('notifications_markread_link')){
      $('notifications_markread_link').addEvent('click', function() {
        //$('notifications_markread').setStyle('display', 'none');
        $('notification_count_new').setStyle('display', 'none');
        en4.activity.hideNotifications('<?php echo $this->string()->escapeJavascript($this->translate("0 Updates"));?>');
      });
    }

    <?php if ($this->updateSettings && $this->viewer->getIdentity()): ?>
    notificationUpdater = new NotificationUpdateHandler({
              'delay' : <?php echo $this->updateSettings;?>
            });
    notificationUpdater.start();
    window._notificationUpdater = notificationUpdater;
    <?php endif;?>
  });
  
  var previousMenu;
  var abortRequest;
  var toggleUpdatesPulldown = function(event, element, user_id, menu) {
    if (typeof(abortRequest) != 'undefined') {
      abortRequest.cancel();
    }

    if(event.target.className == 'sesatoz_pulldown_header')
    return;
   
    var hideNotification = 0;
    var hideMessage = 0;
    var hideSettings = 0;
    var hideFriendRequests = 0;
    if($$(".updates_pulldown_selected").length > 0) {
      $$('.updates_pulldown_selected').set('class', 'updates_pulldown');
      var hideNotification = 1;
    }

    if($$(".messages_pulldown_selected").length > 0) {
      $$('.messages_pulldown_selected').set('class', 'messages_pulldown');
      hideMessage = 1;
    }
    
    if($$(".settings_pulldown_selected").length > 0) {
      $$('.settings_pulldown_selected').set('class', 'settings_pulldown');
      hideSettings = 1;
    }
    
    if($$(".friends_pulldown_selected").length > 0) {
      $$('.friends_pulldown_selected').set('class', 'friends_pulldown');
      hideFriendRequests = 1;
    }
  

    if(menu == 'notifications' && hideNotification == 0) {
      
      if( element.className=='updates_pulldown') {
        element.className= 'updates_pulldown_selected';
        showNotifications();
      } 
      else
        element.className='updates_pulldown';
    }
    else if(menu == 'message' && hideMessage == 0) {
      if( element.className=='messages_pulldown' ) {
        element.className= 'messages_pulldown_selected';
        showMessages();
      } 
      else {
        element.className='messages_pulldown';
      }
    }
    else if(menu == 'settings' && hideSettings == 0) {
      if( element.className=='settings_pulldown' ) {
        element.className= 'settings_pulldown_selected';
      } 
      else {
        element.className='settings_pulldown';
      }
    }
    else if(menu == 'friendrequest' && hideFriendRequests == 0) {
      if( element.className=='friends_pulldown' ) {
        element.className= 'friends_pulldown_selected';
        showFriendRequests();
      } 
      else {
        element.className='friends_pulldown';
      }
    }
    previousMenu = menu;
  }
  var showNotifications = function() {

    en4.activity.updateNotifications();
    abortRequest = new Request.HTML({
      'url' : en4.core.baseUrl + 'sesatoz/notifications/pulldown',
      'data' : {
        'format' : 'html',
        'page' : 1
      },
      'onComplete' : function(responseTree, responseElements, responseHTML, responseJavaScript) {
        if( responseHTML ) {
          // hide loading iconsignup
          if($('notifications_loading')) $('notifications_loading').setStyle('display', 'none');

          $('notifications_menu').innerHTML = responseHTML;
          $('notifications_menu').addEvent('click', function(event){
            event.stop(); //Prevents the browser from following the link.

            var current_link = event.target;
            var notification_li = $(current_link).getParent('li');

            // if this is true, then the user clicked on the li element itself
            if( notification_li.id == 'core_menu_mini_menu_update' ) {
              notification_li = current_link;
            }

            var forward_link;
            if( current_link.get('href') ) {
              forward_link = current_link.get('href');
            } else{
              forward_link = $(current_link).getElements('a:last-child').get('href');
            }

            if( notification_li.get('class') == 'notifications_unread' ){
              notification_li.removeClass('notifications_unread');
              en4.core.request.send(new Request.JSON({
                url : en4.core.baseUrl + 'activity/notifications/markread',
                data : {
                  format     : 'json',
                  'actionid' : notification_li.get('value')
                },
                onSuccess : function() {
                  window.location = forward_link;
                }
              }));
            } else {
              window.location = forward_link;
            }
          });
        } else {
          $('notifications_loading').innerHTML = '<?php echo $this->string()->escapeJavascript($this->translate("You have no new updates."));?>';
        }
        document.getElementById('notification_count_new').innerHTML = '';
        document.getElementById('notification_count_new').removeClass('sesatoz_minimenu_count');
      }
    });  en4.core.request.send(abortRequest, {
    'force': true
  });
  };

  function showMessages() {

    abortRequest = new Request.HTML({
      url : en4.core.baseUrl + 'sesatoz/index/inbox',
      data : {
        format : 'html'
      },
      onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
      {
       document.getElementById('sesatoz_user_messages_content').innerHTML = responseHTML;
       document.getElementById('message_count_new').innerHTML = '';
       document.getElementById('message_count_new').removeClass('sesatoz_minimenu_count');
      }
    }); 
    en4.core.request.send(abortRequest, {
    'force': true
  });
  }
  var popUp;
  function showFriendRequests() {

    abortRequest = new Request.HTML({
      url : en4.core.baseUrl + 'sesatoz/index/friendship-requests',
      data : {
        format : 'html'
      },
      onSuccess : function(responseTree, responseElements, responseHTML, responseJavaScript)
      {
       if(responseHTML) {
         document.getElementById('sesatoz_friend_request_content').innerHTML = responseHTML;
         document.getElementById('request_count_new').innerHTML = '';
         document.getElementById('request_count_new').removeClass('sesatoz_minimenu_count');
       }
       else {
        $('friend_request_loading').innerHTML = '<?php echo $this->string()->escapeJavascript($this->translate("You have no new friend request."));?>';
       }
      }
    }); 
    en4.core.request.send(abortRequest, {
    'force': true
  });
  }
  
  if('<?php echo $this->viewer->getIdentity();?>' == 0) {
    ses(document).ready(function() {
		<?php $forcehide =  Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.popupfixed', false);    ?>
   	popUp=ses('.popup-with-move-anim').magnificPopup({
        type: 'inline',
        fixedContentPos: true,
        fixedBgPos: true,
        overflowY: 'auto',
				enableEscapeKey:<?php echo $forcehide ? "false" : "true" ; ?>,
				showCloseBtn:<?php echo $forcehide ? "false" : "true"; ?>,
				closeOnBgClick: <?php echo $forcehide ? "false" : "true"; ?>, // allow opening popup on middle mouse click. Always set it to true if you don\'t provide alternative source.
        closeBtnInside: true,
        preloader: true,
        midClick: true,
        removalDelay: 300,
        mainClass: 'my-mfp-slide-bottom'
      });
      if(ses(".payment_form_signup"))
      ses(".payment_form_signup").attr('action',en4.core.baseUrl + 'signup');
    });    
		
		ses.magnificPopup.instance.close = function () {
   var day = '<?php echo Engine_Api::_()->getApi('settings', 'core')->getSetting('sesatoz.popup.day', 5);?>';
   if(day != 0)
			setCookie("is_popup",'popo',day);
			sesJqueryObject(document.body).removeClass('login-signup-popup-open');
			ses.magnificPopup.proto.close.call(this);	
		}
		
		jqueryObjectOfSes(document).ready(function(e){
			jqueryObjectOfSes('#signup_account_form input,#signup_account_form input[type=email]').each(
						function(index){
								var input = jqueryObjectOfSes(this);
								if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().length && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements'){	
									if(jqueryObjectOfSes(this).prop('type') == 'email' || jqueryObjectOfSes(this).prop('type') == 'text' || jqueryObjectOfSes(this).prop('type') == 'password'){
										jqueryObjectOfSes(this).attr('placeholder',jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').html());
									}
								}
						}
					)	
		});

		jqueryObjectOfSes(document).ready(function(e){
			jqueryObjectOfSes('#sesabasic_form_login input,#sesabasic_form_login input[type=email]').each(
						function(index){
								var input = jqueryObjectOfSes(this);
								if(jqueryObjectOfSes(this).closest('div').parent().css('display') != 'none' && jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').first().length && jqueryObjectOfSes(this).prop('type') != 'hidden' && jqueryObjectOfSes(this).closest('div').parent().attr('class') != 'form-elements'){	
									if(jqueryObjectOfSes(this).prop('type') == 'email' || jqueryObjectOfSes(this).prop('type') == 'text' || jqueryObjectOfSes(this).prop('type') == 'password'){
										jqueryObjectOfSes(this).attr('placeholder',jqueryObjectOfSes(this).closest('div').parent().find('.form-label').find('label').html());
									}
								}
						}
					)	
		});
		
  }
</script>
<script type="text/javascript">
// cookie get and set function
function setCookie(cname, cvalue, exdays) {
	var d = new Date();
	d.setTime(d.getTime() + (exdays*24*60*60*1000));
	var atozires = "atozires="+d.toGMTString();
	document.cookie = cname + "=" + cvalue + "; " + atozires;
} 
function getCookie(cname) {
	var name = cname + "=";
	var ca = document.cookie.split(';');
	for(var i=0; i<ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1);
			if (c.indexOf(name) != -1) return c.substring(name.length,c.length);
	}
	return "";
}
// end cookie get and set function.
var popUpShow=getCookie('is_popup');
if('<?php echo $this->viewer->getIdentity();?>' == 0 && popUpShow == '' && '<?php echo $actionName != 'login' ;?>' && '<?php echo $controllerName != 'signup' ;?>') {
	ses(document).ready(function() {
    if('<?php echo $showPopup;?>' == '1' && '<?php echo $enablePopUp ?>' == 1) 
		document.getElementById("popup-login").click(); 
	});
}
sesJqueryObject(document).on('click','.pull_down_img',function(){
	//sesJqueryObject('.settings_pulldown').trigger('click');
})
window.addEvent('domready', function() {
	  $(document.body).addEvent('click', function(event){
      if(event.target.id != 'show_message' && event.target.id != 'show_request' && event.target.id != 'show_update' &&  event.target.id != 'show_settings_img' && event.target.className != 'sesatoz_pulldown_header' && event.target.className != 'pulldown_loading') {
        if($$(".updates_pulldown_selected").length > 0)
        $$('.updates_pulldown_selected').set('class', 'updates_pulldown');

        if($$(".messages_pulldown_selected").length > 0)
        $$('.messages_pulldown_selected').set('class', 'messages_pulldown');

        if($$(".settings_pulldown_selected").length > 0)
        $$('.settings_pulldown_selected').set('class', 'settings_pulldown');
      
        if($$(".friends_pulldown_selected").length > 0)
        $$('.friends_pulldown_selected').set('class', 'friends_pulldown');  
      }
    });
  <?php if($this->viewer->getIdentity() != 0) : ?>
    setInterval(function() {
      newUpdates();
    },20000);
  
    window.setInterval(function() {
      newMessages();
    },30000);
  
    window.setInterval(function() {
      newFriendRequests();
    },10000);
  <?php endif; ?>
});

	
  function newFriendRequests() {

    en4.core.request.send(new Request.JSON({
      url : en4.core.baseUrl + 'sesatoz/index/new-friend-requests',
      method : 'POST',
      data : {
        format : 'json'
      },
      onSuccess : function(responseJSON) 
      {
        if( responseJSON.requestCount && $("request_count_new") ) {
          $('updates_toggle').addClass('new_updates');
          $("request_count_new").style.display = 'block';
					if(responseJSON.requestCount > 0 && responseJSON.requestCount != '')
         		$("request_count_new").addClass('sesatoz_minimenu_count');
          $("request_count_new").innerHTML = responseJSON.requestCount;
					
        }
      }
    }));
  }
  
  function newUpdates() {
    en4.core.request.send(new Request.JSON({
      url : en4.core.baseUrl + 'sesatoz/index/new-updates',
      method : 'POST',
      data : {
        format : 'json'
      },
      onSuccess : function(responseJSON) 
      {
        if( responseJSON.notificationCount && $("notification_count_new") ) {
          $('updates_toggle').addClass('new_updates');
          $("notification_count_new").style.display = 'block';
          $("notification_count_new").innerHTML = responseJSON.notificationCount;
          if(responseJSON.notificationCount > 0 && responseJSON.notificationCount != '')
            $("notification_count_new").addClass('sesatoz_minimenu_count');
        }
      }
    }));
  }
  
  function newMessages() {
    en4.core.request.send(new Request.JSON({
      url : en4.core.baseUrl + 'sesatoz/index/new-messages',
      method : 'POST',
      data : {
        format : 'json'
      },
      onSuccess : function(responseJSON) 
      {
        if( responseJSON.messageCount && $("message_count_new") ) {
          $('updates_toggle').addClass('new_updates');
          $("message_count_new").style.display = 'block';
					if(responseJSON.messageCount > 0 && responseJSON.messageCount != '')
        	$("message_count_new").addClass('sesatoz_minimenu_count');
          $("message_count_new").innerHTML = responseJSON.messageCount;
        }
      }
    }));
  }
</script>
