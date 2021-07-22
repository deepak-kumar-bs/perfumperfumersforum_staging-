(function () { // START NAMESPACE
  var $ = 'id' in document ? document.id : window.$;



  Composer.Plugin.Sell = new Class({

    Extends: Composer.Plugin.Interface,

    name: 'sell',
    options: {
      title: 'Sell Something',
      lang: {},
      requestOptions: false,
      fancyUploadEnabled: true,
      fancyUploadOptions: {}
    },
    initialize: function (options) {
      this.elements = new Hash(this.elements);
      this.params = new Hash(this.params);
      this.parent(options);
      this.scrollbar = false;
    },

    attach: function () {
      this.parent();
      this.makeActivator();
      var self = this;
      this.elements.activator.addEvent('click', function () {
        resetAAFTextarea();
        self.activate();
        composeInstance.getActivatorContent().addClass('dnone');
      });
      return this;
    },

    detach: function () {
      this.parent();
      return this;
    },

    activate: function () {
      if (this.active)
        return;
      this.parent();

      this.makeMenu();
      this.makeBody();
      $('compose-submit').style.display = 'none';
      $$('.adv_post_container_box') ? $$('.adv_post_container_box').addClass('dnone') : null;
      new Element('div', {
        'id': 'compose-sell-form',
        'class': 'compose-form',
        'html': $('advancedactivity_post_buysell_options').innerHTML
      }).inject(this.elements.body);
      new google.maps.places.Autocomplete($('compose-sell-form').getElementById('place'));
      if ($$('.compose-container')[0].getElement('.overTxtLabel'))
        $$('.compose-container')[0].getElement('.overTxtLabel').innerHTML = en4.core.language.translate('Say something about this photo...');
      // Generate form
      var fullUrl = this.options.requestOptions.url;

      // Try to init fancyupload
      if (this.options.fancyUploadEnabled && this.options.fancyUploadOptions) {
        this.elements.formFancyContainer = new Element('div', {
          'styles': {
            'display': 'none',
            'visibility': 'hidden'
          },
          'id': 'compose-photo-body'
        }).inject(this.elements.body);

        this.elements.scrollbarBefore = new Element('div', {
          'id': 'scrollbar_before',
          'class': 'scrollbarArea'
        }).inject(this.elements.formFancyContainer);

        this.elements.scrollmain = new Element('div', {
          'id': 'aaf-scroll-main'
        }).inject(this.elements.formFancyContainer);

        this.elements.scrollarea = new Element('div', {
          'id': 'aaf-scroll-area',
          'styles': {
            'overflow': 'hidden',
            'width': '400px'
          }
        }).inject(this.elements.scrollmain);
        this.elements.scrollcontent = new Element('div', {
          'id': 'aaf-scroll-content'
        }).inject(this.elements.scrollarea);

        // This is the browse button
        this.elements.formFancyUl = new Element('ul', {
          'id': 'aaf-demo-list',
          'class': 'demo-list',
          'styles': {
            'float': 'left',
            'height': '102px',
          }
        }).inject(this.elements.scrollcontent);

        this.elements.formFancyUl1 = new Element('ul', {
          'id': 'add-more',
          'styles': {
            'float': 'left'
          }
        }).inject(this.elements.scrollcontent);

        this.elements.scrollbarAfter = new Element('div', {
          'id': 'scrollbar_after_1',
          'class': 'scrollbarArea',
          'styles': {
            'width': $('compose-tray').clientWidth - 10
          }
        }).inject(this.elements.formFancyContainer);

        this.elements.formFancyliInner = new Element('li', {
          'class': 'advancedactivity_addphotos_btn',
          'id': 'advancedactivity_addphotos_btn'
        }).inject(this.elements.formFancyUl1);

        this.elements.formFancyFile = new Element('a', {
          'href': 'javascript:void(0);',
          'id': 'demo-browse-advancedactivity',
          'class': 'buttonlink',
          'html': en4.core.language.translate('Add Photos')
        }).inject(this.elements.formFancyliInner);

        // This is the list
        this.elements.formFancyList = new Element('div', {
          'styles': {
            'display': 'none'
          }
        }).inject(this.elements.formFancyContainer);
        $('aaf-scroll-area').setStyle('width', this.elements.body.clientWidth);
        $('aaf-scroll-content').setStyle('width', (parseInt($('aaf-scroll-content').getElements('li').length)) * 102 + 2);
        var self = this;
        (function () {
          self.scrollbar = new SEAOMooHorizontalScrollBar('aaf-scroll-main', 'aaf-scroll-area', {
            'arrows': false,
            'horizontalScroll': true,
            'horizontalScrollElement': 'scrollbar_after_1',
            'horizontalScrollBefore': false,
            'horizontalScrollBeforeElement': 'scrollbar_before'
          });
          self.scrollbar.update();
        }).delay(500);
        var opts = $merge({
          ui_button: self.elements.formFancyFile.get('id'),
          ui_list: self.elements.formFancyUl.get('id'),
          ui_drop_area: self.elements.body.get('id'),
          name: self.getName(),
          block_size: 502000,
          url: fullUrl,
          deleteUrl: en4.core.baseUrl + 'album/photo/delete',
          multiple: true,
          accept: 'image/*',
          view: 'grid',
          // Events
          onActivate: function () {
            this.uiButton.addEvents({
              click: function () {return false; },
              mouseenter: function () { this.addClass('hover'); },
              mouseleave: function () { this.removeClass('hover'); this.blur(); },
              mousedown: function () { this.focus(); }
            });
            this.debug = this.options.debugMode || en4.core.environment == 'development';
            self.elements.formFancyContainer.setStyle('display', '');
            self.elements.formFancyContainer.setStyle('visibility', 'visible');
            self.makeFormInputs();
            this.setErrorMessages();
            this.submitWrapper = self.elements.formSubmit;
            this.fileIdsElement = document.getElementsByName('attachment[photo_id]')[0];
            this.fileIdsElement.set('value', '');
            self.elements.body.addClass('seao-fancy-uploader-wrapper');
            this._log('onActivate');
          },
          onItemCancel: function(el) {
            file_id = el.get('data-file_id');
            el.destroy();
            $('aaf-scroll-content').setStyle('width', (parseInt($('aaf-scroll-content').getElements('li').length)) * 102 + 2);
            if (self.scrollbar)
              self.scrollbar.update();

            if (!file_id) return;
            if (this.fileIdsElement) {
              value = this.fileIdsElement.get('value').replace(file_id, '');
              this.fileIdsElement.set('value', value);
            }

            if (this.uiList.getElements('li').length == 0) {
              this.uiList.hide();
            } else if (this.uiList.getLast('li').hasClass('scroll-content-item')) {
              self.elements.formSubmit.removeClass('dnone');
            }

            if (this.options.deleteUrl) {
              request = new Request.JSON({
                'format': 'json',
                'url': this.options.deleteUrl,
                'data': { isajax : 1, photo_id : file_id, },
                'onSuccess': function (responseJSON) {
                  return false;
                }
              });
              request.send();
            }
            this._log('onItemCancel');
          },
          onAddFiles: function (num) {
            if (!num) return;
            this.submitWrapper && this.submitWrapper.addClass('dnone');

            // self.allowToSetInInput = false;
            // this.uiList.setStyle('display', 'inline-block');
            // self.getComposer().getMenu().setStyle('display', 'none');
          },
          onItemAdded: function(el, file, imagedata){
            uploader = this;
            el.addClass('file scroll-content-item')
            .adopt(new Element('span', {'class': 'file-size', 'html': this._convertSize(file.size) }))
            .adopt(new Element('a', {'href': 'javascript:void(0);', 'class': 'file-remove', 'title': self._lang('Click to remove this entry.')})
              .addEvent('click', function(e){e.stop(); uploader.cancel(file.id, el)})
              )
            .adopt(new Element('span', {'class': 'file-name', 'html': file.name}))
            .adopt(new Element('span', {'class': 'file-info'}))
            .adopt(new Element('div', {'class': 'file-progress'}).setStyle('opacity', 0.1));
            // .adopt(new Element('div', {'class': 'file-progress'}).set('tween', {duration: 200}));

            if(file.type && file.type.match('image') && imagedata){
              el.addClass('image');
              preview = el.getElement('.file-info');
              preview.adopt(new Element('img', {src: imagedata, style: 'width: 100%'}))
            }

            $('aaf-scroll-content').setStyle('width', (parseInt($('aaf-scroll-content').getElements('li').length)) * 102 + 2);
            if (self.scrollbar)
              self.scrollbar.update();

            // UPDATE SCROLLBAR
            this._log('onItemAdded - ' + file.name);
          },
          onItemComplete: function(el, file, response) {
            el.removeClass('file-uploading').addClass('file-success scroll-content-item');
            el.getElement('.file-progress').setStyle('opacity', 1);
            // el.getElement('.file-progress').set('html', '100%').tween('width', 140);
            self.SortablesInstance();
            var photo_id = response.photo_id;

            el.set('data-file_id', photo_id);
            // el.setStyle('width', '100px');
            el.set('id', 'thumbs-photo-' + photo_id );
            el.getElement('.file-size').destroy();
            el.getElement('.file-name').destroy();
            el.getElement('.file-remove').set('html', '');
            var mediaPhotoDetails = "<img id='media_photo_" + photo_id + "' style=''src=" + response.src + " />";
            el.getElement('.file-info').set('html', mediaPhotoDetails);
            this.fileIdsElement.set('value', this.fileIdsElement.value + photo_id + ' ');

            $('aaf-scroll-content').setStyle('width', (parseInt($('aaf-scroll-content').getElements('li').length)) * 102 + 2);
            if (self.scrollbar)
              self.scrollbar.update();

            // on item error
            // el.addClass('file-failed');
            // file.info.set('html', (response.error ? (response.error) : response));
            this._log('onItemComplete - ' + file.name);
          },
          onUploadStart: function() {
            if (this.submitWrapper) this.submitWrapper.addClass('dnone');
          },
          onItemProgress: function(el, perc) {
            el.getElement('.file-progress').setStyle('opacity', perc / 100);
          },
          onUploadProgress: function (perc) {
            this._log('onUploadProgress - ' + Math.floor(perc) + '%' );
          },
          onUploadComplete: function (num) {
            if (this.submitWrapper) this.submitWrapper.removeClass('dnone');
            self.allowToSetInInput = true;
            this._log('onUploadComplete: Uploaded Files - ' + num);
          },
        }, this.options.fancyUploadOptions);

        try {
          this.elements.formFancyUpload = en4.seaocore.initSeaoFancyUploader(opts);
        } catch (e) {
          if( $type(console) ) console.log(e);
        }

      }
      this.elements.formSubmit = new Element('button', {
        'id': 'compose-photo-form-submit',
        'html': this._lang('Continue'),
        'events': {
          'click': function (e) {
            e.stop();
            this.doAttach();
          }.bind(this)
        }
      }).inject(this.elements.body);
    },

    deactivate: function () {
      if (!this.active)
        return;
      $$('.adv_post_container_box') ? $$('.adv_post_container_box').removeClass('dnone') : null;
      if (document.getElementsByName('attachment[photo_id]')[0]) {
        var fileids = document.getElementsByName('attachment[photo_id]')[0];
        if (fileids.value.trim()) {
          request = new Request.JSON({
            'format': 'json',
            'url': en4.core.baseUrl + 'album/index/cancel-photos',
            'data': {
              'photo_ids': fileids.value,
              'isAjax': 1
            },
            'onSuccess': function (responseJSON) {
            }
          });
          // request.send();
        }
      }
      var elements = document.getElementsByClassName('composer_sell_hidden');
      while (elements.length > 0) {
        elements[0].parentNode.removeChild(elements[0]);
      }
      $('compose-submit').style.display = 'inline-block';
      this.parent();
      composeInstance.getActivatorContent().removeClass('dnone');
    },
    doAttach: function () {
      if (!$('compose-sell-form').getElementById('title').value || !$('compose-sell-form').getElementById('price').value || !$('compose-sell-form').getElementById('place').value) {
        if ($('compose-sell-error'))
          $('compose-sell-error').destroy();
        this.makeError('Product name, price and selling place is required', 'empty');
        //var content = "<div class='aaf_show_popup'><h3>" + "Advertising" + "</h3><div class='tip'>" + "Name and place is required." + "</div>" + "<button type='submit' onclick='javascript:Smoothbox.close()'>" + "Close" + "</button>"  + "</div>"
        //Smoothbox.open(content);
        return;
      }
      var formValues = new Object();
      var details = "";
      var labels = this.options.requestOptions.customLabels;
      var currency = this.options.requestOptions.currency;
      formValues['format'] = 'json';
      var divElement = $('compose-sell-body');
      var inputElements = divElement.querySelectorAll("input, select, checkbox, textarea");
      for (i = 0; i < inputElements.length; i++) {
        if (inputElements[i].type.toLowerCase() == 'text' || inputElements[i].type.toLowerCase() == 'textarea') {
          formValues[inputElements[i].id] = inputElements[i].value;
          this.setFormInputValue(inputElements[i].id, inputElements[i].value);
          //For Custom Fields
//          if(inputElements[i].id != 'place' && inputElements[i].id != 'title'){ console.log(inputElements[i].id);
//            details = (details) ? details+"<br />"+labels[inputElements[i].id]+" "+inputElements[i].value :labels[inputElements[i].id]+" "+inputElements[i].value;
//          } 
        } else {
          this.setFormInputValue(inputElements[i].id, inputElements[i].value);
          if (inputElements[i].id == 'currency') {
            currency = inputElements[i].value;
          }
        }
      }

      details = details.replace("undefined", "");
      this.setFormInputValue('owner_id', en4.user.viewer.id);
      this.elements.previewBody = new Element('div', {
        'id': 'preview-body'
      }).inject($('compose-tray'));
      this.elements.body.hide();
      this.elements.formSubmit.addClass('dnone');
      if(this.elements.formFancyUl1)
      this.elements.formFancyUl1.hide();
      this.makeMenu();
      new Element('a', {
        'class': 'compose-product-title-preview',
        'href': 'javascript:void(0)',
        'events': {
          'click': function (e) {
            e.stop();
            this.doEditSell();
          }.bind(this)
        },
        'html': "<br /><strong>" + $('compose-sell-form').getElementById('title').value + "</strong><div class='aaf_sell_product_price'>" + currency + " " + $('compose-sell-form').getElementById('price').value + "</div><div class='aaf_sell_product_place'>" + $('compose-sell-form').getElementById('place').value + "</div>"
      }).inject(this.elements.previewBody);
      if ($('compose-sell-form').getElementById('description').value) {
        new Element('i', {
          'class': 'compose-product-detail-preview',
          'html': $('compose-sell-form').getElementById('description').value
        }).inject(this.elements.previewBody);
      }
      //compose-photo-preview-image
      this.elements.imagePreview = new Element('span', {
        'class': 'compose-product-image-preview',
        'id': 'compose-product-image-preview',
      }).inject(this.elements.previewBody);
      if($('compose-photo-body')){
          this.elements.imagePreview.innerHTML = $('compose-photo-body').innerHTML;
      }else if($('compose-photo-preview-image')){
          cloneImage = $('compose-photo-preview-image').cloneNode(true);
          this.elements.imagePreview.appendChild(cloneImage);
      }
      $('compose-submit').style.display = 'inline-block';

      var elm = this.elements.previewBody.getElementsByClassName('file-remove');
      while (elm.length) {
        elm[0].removeClass('file-remove');
      }

    },
    makeMenu: function () {
      if (!this.elements.menu) {
        var tray = this.getComposer().getTray();
        this.elements.menu = new Element('div', {
          'id': 'compose-' + this.getName() + '-menu',
          'class': 'compose-menu'
        }).inject(tray);
        this.elements.menuTitle = new Element('span', {
          'html': this._lang(this.options.title) + ' '
        }).inject(this.elements.menu);
        this.elements.menuClose = new Element('a', {
          'href': 'javascript:void(0);',
          'class': 'aaf-composer-cancel-menu',
          'html': this._lang('Cancel'),
          'events': {
            'click': function (e) {
              e.stop();
              this.getComposer().deactivate();
            }.bind(this)
          }
        }).inject(this.elements.menuTitle);

      } else if (!this.elements.menuEdit) {
        this.elements.menuEdit = new Element('a', {
          'href': 'javascript:void(0);',
          'html': this._lang('Edit'),
          'class': 'aaf-composer-edit-menu',
          'events': {
            'click': function (e) {
              e.stop();
              this.doEditSell();
            }.bind(this)
          }
        }).inject(this.elements.menuTitle);
        this.elements.menuTitle.appendText('');
      }

    },
    doEditSell: function () {
      $('compose-submit').style.display = 'none';
      this.elements.body.show();
      this.elements.formSubmit.removeClass('dnone');
      if(this.elements.formFancyUl1)
      this.elements.formFancyUl1.show();
      this.elements.previewBody.destroy();
    },
    // make chekin hidden input and set value into composer form
    setFormInputValue: function (key, value) {
      var elName = 'aafComposerForm' + key.capitalize();

      var composerObj = this.getComposer();
      if (composerObj.elements.has(elName))
        composerObj.elements.get(elName).destroy();
      if (key != 'images' && key != 'format') {
        composerObj.elements.set(elName, new Element('input', {
          'type': 'hidden',
          'class': 'composer_sell_hidden',
          'name': 'attachment[' + key + ']',
          'value': value || ''
        }).inject(composerObj.getInputArea()));

        composerObj.elements.get(elName).value = value;
      }

    },
    SortablesInstance: function () {
      var SortablesInstance;
      $$('demo-list > li').addClass('sortable');
      SortablesInstance = new Sortables($$('demo-list'), {
        clone: true,
        constrain: true,
        //handle: 'span',
        onComplete: function (e) {
          var ids = [];
          $$('demo-list > li').each(function (el) {
            ids.push(el.get('id').match(/\d+/)[0]);
          });
          var vArray = ids;
          var photo_ids = '';
          for (i = 0; i < (vArray.length); i++) {
            photo_ids = photo_ids + vArray[i] + " ";
          }
          fileids = document.getElementsByName('attachment[photo_id]')[0];
          fileids.value = photo_ids;
        }
      });
    },
    makeFormInputs: function () {
      this.ready();
      this.parent({
        'photo_id': this.params.photo_id
      });
    },
    makeError: function (message, action) {
      if (!$type(action))
        action = 'empty';
      message = message || 'An error has occurred';
      message = this._lang(message);
      this.elements.error = new Element('div', {
        'id': 'compose-' + this.getName() + '-error',
        'class': 'compose-error',
        'html': message
      }).inject(this.elements.body, 'top');
    }
  });

})(); // END NAMESPACE
