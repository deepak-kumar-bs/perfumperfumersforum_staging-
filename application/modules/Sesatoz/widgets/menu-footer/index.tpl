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
<?php $settings = Engine_Api::_()->getApi('settings', 'core'); ?>
<div class="sesatoz_footer_main sesbasic_bxs clearfix">
 <div class="sesatoz_footer_container">
   <div class="sesatoz_footer_inner">
      <ul>
        <?php if(!empty($this->leftcolumnenable)) { ?>
          <li class="footer_about">
            <h4><?php echo $this->translate($this->leftcolhdingtext); ?></h4>
            <p><?php echo $this->translate($this->leftcolhdingdes); ?></p>
            <ul class="footer_contact_info">
              <li><i class="fa fa-map-marker"></i><?php echo $this->translate($this->leftcolhdinglocation); ?></li>
              <li><i class="fa fa-envelope-o"></i><?php echo $this->translate($this->leftcolhdingemail); ?></li>
              <li><i class="fa fa-phone"></i><?php echo $this->translate($this->leftcolhdingphone); ?></li>
              <li>
               <?php if( 1 !== count($this->languageNameList) ): ?>
                 <div class="footer_lang">
                   <form method="post" action="<?php echo $this->url(array('controller' => 'utility', 'action' => 'locale'), 'default', true) ?>" style="display:inline-block">
                   <?php $selectedLanguage = $this->translate()->getLocale() ?>
                   <?php echo $this->formSelect('language', $selectedLanguage, array('onchange' => '$(this).getParent(\'form\').submit();'), $this->languageNameList) ?>
                   <?php echo $this->formHidden('return', $this->url()) ?>
                  </form>
                </div>
               <?php endif; ?>
              </li>
            </ul>
          </li>
        <?php } ?>
        
        <?php  if($this->quicklinksenable) { ?>
        <li class="footer_menu_links">
         <h4><?php echo $this->translate("Explore"); ?></h4>
          <div class="footer_main_links clearfix">
            <ul class="sesbasic_clearfix">
              <?php foreach( $this->quickLinksMenu as $link ): 
              $attribs = array_diff_key(array_filter($link->toArray()), array_flip(array(
                'reset_params', 'route', 'module', 'controller', 'action', 'type',
                'visible', 'label', 'href'
              )));
              ?>
                <li>
                  <a href='<?php echo $link->getHref() ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"
                    <?php if( $link->get('target') ): ?> target='<?php echo $link->get('target') ?>' <?php endif; ?> >
                    <?php if($link->get('icon')) { ?>
                      <i class="fa <?php echo $link->get('icon') ? $link->get('icon') : 'fa-star' ?>"></i>
                    <?php } ?>
                    <?php echo $this->htmlLink($link->getHref(), $this->translate($link->getLabel()), $attribs) ?>
                  </a>
                </li>
              <?php endforeach; ?>
            </ul>
          </div>
        </li>
        <?php } ?>
        <li class="footer_social_links">
        <?php if($settings->getSetting('sesatoz.rightcolumnenable', '1')) { ?>
         <h4><?php echo $this->translate($settings->getSetting('sesatoz.rightcolhdingtext', 'MOBILE APPS')); ?></h4>
         <p><?php echo $this->translate($settings->getSetting('sesatoz.rightcolhdingdes', 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s.')); ?></p>
        <?php } ?>
        <div class="footer-newsletter">
            <?php if(Engine_Api::_()->getDbTable('modules', 'core')->isModuleEnabled('sesnewsletter')) { ?>
              <?php echo $this->content()->renderWidget("sesnewsletter.newsletter"); ?>
            <?php } else { ?>
              <input name="email" id="sesatoz_newsletteremail" type="email" placeholder="<?php echo $this->translate('Enter Your Email Address'); ?>"/>
              <button id="sesatoz_newsletterbutton" type="submit"><?php echo $this->translate("Subscribe"); ?></button>
            <?php } ?>
         </div>
        <div style="display:none;" class="sesatoz_newsletter_tip" id='sesatoz_newsletter_successmsg'><span><?php echo $this->translate("Thank you for subscribing."); ?></span></div>
        <div style="display:none;" class="sesatoz_newsletter_tip" id='sesatoz_newsletter_erromsg'><span><?php echo $this->translate("You have already subscribed."); ?></span></div>
        <?php if($this->socialenable && count($this->core_social_sites) > 0) { ?>
          <div class="footer_social sesbasic_clearfix">
            <?php foreach( $this->core_social_sites as $link ): ?>
              <a href='<?php echo $link->getHref() ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"
                <?php if( $link->get('target') ): ?> target='<?php echo $link->get('target') ?>' <?php endif; ?> >
                <i class="fa <?php echo $link->get('icon') ? $link->get('icon') : 'fa-star' ?>"></i>
              </a>
            <?php endforeach; ?>
          </div>
        <?php } ?>
        <div class="sesatoz-app-box">
          <?php if($this->rightcolhdingbtn1) { ?>
           <div class="app-item applestore">
             <a href="<?php echo $this->rightcolhdingbtn1; ?>" title="" target="_blank">
               <i class="fa fa-apple" aria-hidden="true"></i>
             </a>
           </div>
           <?php } ?>
           <?php if($this->rightcolhdingbtn2) { ?>
            <div class="app-item playstorestore">
             <a href="<?php echo $this->rightcolhdingbtn2; ?>" title="" target="_blank">
               <i class="fa fa-play" aria-hidden="true"></i>
             </a>
           </div>
           <?php } ?>
          </div>
        </li>
           <?php if($this->sesatoz_twitterembed) { ?>
          <li class="footer_post_col">
            <div class="footer_posts">
              <?php echo $this->sesatoz_twitterembed; ?>
            </div>
          </li>
        <?php } ?>
      </ul>
  </div>
	<div class="footer_links">
    <div class="footer_help_links clearfix">
       <?php  if($this->helpenable) { ?>
        <ul class="sesbasic_clearfix">
          <?php foreach( $this->navigation as $link ): 
          $attribs = array_diff_key(array_filter($link->toArray()), array_flip(array(
            'reset_params', 'route', 'module', 'controller', 'action', 'type',
            'visible', 'label', 'href'
          )));
          ?>
            <li>
              <a href='<?php echo $link->getHref() ?>' class="<?php echo $link->getClass() ? ' ' . $link->getClass() : ''  ?>"
                <?php if( $link->get('target') ): ?> target='<?php echo $link->get('target') ?>' <?php endif; ?> >
                <?php if($link->get('icon')) { ?>
                  <i class="fa <?php echo $link->get('icon') ? $link->get('icon') : 'fa-star' ?>"></i>
                <?php } ?>
                <?php echo $this->htmlLink($link->getHref(), $this->translate($link->getLabel()), $attribs) ?>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
        <?php } ?>
        <div class="footer_copy sesbasic_bxs">
          <?php echo $this->translate('Copyright &copy;%s', date('Y')) ?>
        </div>
      </div>
  </div>
  <?php  if($this->quicklinksenable) { ?>
    <div class="clearfix footer_column" style="display:none;">
      <div class="footer_column_heading">
        <?php echo $this->translate($this->quicklinksheading);?>
      </div>
    </div>
    <?php } ?>
    <?php  if($this->helpenable) { ?>
    <div class="clearfix footer_column" style="display:none;">
      <div class="footer_column_heading">
        <?php echo $this->translate($this->helpheading);?>
      </div>
    </div>
  <?php } ?>
</div>
<?php if	( !empty($this->affiliateCode) ): ?>
  <div class="footer_affiliate_banner">
    <?php 
      echo $this->translate('Powered by %1$s', 
        $this->htmlLink('http://www.socialengine.com/?source=v4&aff=' . urlencode($this->affiliateCode), 
        $this->translate('SocialEngine Community Software'),
        array('target' => '_blank')))
    ?>
  </div>
<?php endif; ?>
</div>
<script>
  sesJqueryObject(document).ready(function() {
    sesJqueryObject("#sesatoz_newsletterbutton").click(function(e) {
      e.preventDefault();
      var sesatoz_newsletteremail = sesJqueryObject('#sesatoz_newsletteremail').val();
      if(sesatoz_newsletteremail)
        sendNewsletter();
    });
    
    sesJqueryObject('#sesatoz_newsletteremail').keydown(function(e) {
      if (e.which === 13) {
        sendNewsletter();
      }
    });
  });
  
  function sendNewsletter() {
  
    var newsletter_email = sesJqueryObject('#sesatoz_newsletteremail').val();
    if(newsletter_email == '')
      return;
    sesJqueryObject('#sesatoz_newsletteremail').val('');
    en4.core.request.send(new Request.JSON({
      url: en4.core.baseUrl + 'sesatoz/index/newsletter',
      data: {
        format: 'json',
        'email': newsletter_email,
      },
      onSuccess: function(responseJSON) {
        if(responseJSON.newsletteremail_id) {
          sesJqueryObject('#sesatoz_newsletter_successmsg').show();
          sesJqueryObject('#sesatoz_newsletter_successmsg').fadeOut("slow", function(){
            setTimeout(function() {
              sesJqueryObject('#sesatoz_newsletter_successmsg').hide();
            }, 1000);
          });
        } else {
          sesJqueryObject('#sesatoz_newsletter_erromsg').show();
          sesJqueryObject('#sesatoz_newsletter_erromsg').fadeOut("slow", function(){
            setTimeout(function() {
              sesJqueryObject('#sesatoz_newsletter_erromsg').hide();
            }, 1000);
          });

        }
      }
    }));
  }
</script>
