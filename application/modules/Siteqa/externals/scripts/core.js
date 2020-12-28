/* $Id: core.js 6590 2014-01-02 00:00:00Z SocialEngineAddOns Copyright 2013-2014 BigStep Technologies Pvt. Ltd. $ */
var tagCloudAction = function(tag, tag_id){
  if($('filter_form')) {
     var form = document.getElementById('filter_form');
    }else if($('filter_form_tag')){
      var form = document.getElementById('filter_form_tag');
  }
  
  form.elements['tag'].value = tag;
  form.elements['tag_id'].value = tag_id;
  form.submit();
}

var tab_content_id_siteqa = 0;
en4.siteqa = {};
en4.siteqa.ajaxTab = {
  click_elment_id: '',
  attachEvent: function(widget_id, params) {
    params.requestParams.content_id = widget_id;
    var element;

    $$('.tab_' + widget_id).each(function(el) {
      if (el.get('tag') == 'li') {
        element = el;
        return;
      }
    });
    var onloadAdd = true;
    if (element) {
      if (element.retrieve('addClickEvent', false))
        return;
      element.addEvent('click', function() {
        if (en4.siteqa.ajaxTab.click_elment_id == widget_id)
          return;
        en4.siteqa.ajaxTab.click_elment_id = widget_id;
        en4.siteqa.ajaxTab.sendReq(params);
      });
      element.store('addClickEvent', true);
      var attachOnLoadEvent = false;
      if (tab_content_id_siteqa == widget_id) {
        attachOnLoadEvent = true;
      } else {
        $$('.tabs_parent').each(function(element) {
          var addActiveTab = true;
          element.getElements('ul > li').each(function(el) {
            if (el.hasClass('active')) {
              addActiveTab = false;
              return;
            }
          });
          element.getElementById('main_tabs').getElements('li:first-child').each(function(el) { 
            if(el.getParent('div') && el.getParent('div').hasClass('tab_pulldown_contents')) 
              return;
            el.get('class').split(' ').each(function(className) {
              className = className.trim();
              if (className.match(/^tab_[0-9]+$/) && className == "tab_" + widget_id) {
                attachOnLoadEvent = true;
                if (addActiveTab || tab_content_id_siteqa == widget_id) {
                  element.getElementById('main_tabs').getElements('ul > li').removeClass('active');
                  el.addClass('active');
                  element.getParent().getChildren('div.' + className).setStyle('display', null);
                }
                return;
              }
            });
          });
        });
      }
      if (!attachOnLoadEvent)
        return;
      onloadAdd = false;

    }

    en4.core.runonce.add(function() {
      if (onloadAdd)
        params.requestParams.onloadAdd = true;
      en4.siteqa.ajaxTab.click_elment_id = widget_id;
      en4.siteqa.ajaxTab.sendReq(params);
    });
  },
  sendReq: function(params) {
    params.responseContainer.each(function(element) {   
      if((typeof params.loading) == 'undefined' || params.loading==true){
       element.empty();
      new Element('div', {
        'class': 'document_profile_loading_image'
      }).inject(element);
      }
    });
    var url = en4.core.baseUrl + 'widget';

    if (params.requestUrl)
      url = params.requestUrl;

    var request = new Request.HTML({
      url: url,
      data: $merge(params.requestParams, {
        format: 'html',
        subject: en4.core.subject.guid,
        is_ajax_load: true
      }),
      evalScripts: true,
      onSuccess: function(responseTree, responseElements, responseHTML, responseJavaScript) {
        params.responseContainer.each(function(container) {
          container.empty();
          Elements.from(responseHTML).inject(container);
          en4.core.runonce.trigger();
          Smoothbox.bind(container);
        });

      }
    });
    request.send();
  }
};