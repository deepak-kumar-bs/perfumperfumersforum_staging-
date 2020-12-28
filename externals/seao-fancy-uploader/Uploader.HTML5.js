/*
---

name: SeaoFancyUploader.HTML5

description: A SeaoFancyUploader module. Handles uploading using the HTML5 method

requires: [SeaoFancyUploader]

provides: [SeaoFancyUploader.HTML5]

...
*/

SeaoFancyUploader.HTML5 = new Class({

	Extends: SeaoFancyUploader,

	initialize: function (options) {
		
		this.setOptions(options);
		
		this.method = 'HTML5'
		
		this.activate();
		
	},
	
	bound: {},
	
	activate: function (){
		
		this.parent();
		
		// If drop area is specified, 
		// and in HTML5 mode,
		// activate dropping
		
		if(this.uiDropArea){
			
			// Extend new events
			Object.append(Element.NativeEvents, {
				dragenter: 2,
				dragleave: 2,
				dragover: 2,
				drop: 2
			});
			
			this.uiDropArea.addEvents({
							
				'dragenter': function (e) {
					
					e.stop();
					this.uiDropArea.addClass('seao-fancy-uploader-drop-over');
					
				}.bind(this),
				
				'dragleave': function (e) {
					
					e.stop();
					
					if (e.target && e.target === this.uiDropArea) {
						this.uiDropArea.removeClass('seao-fancy-uploader-drop-over');
					}
					
				}.bind(this),
				
				'dragover': function (e) {
				
					e.stop();
					e.preventDefault();
					
				}.bind(this),
				
				'drop': function (e) {
				
					e.stop();
					
					if(e.event.dataTransfer) {
						
						this.addFiles(e.event.dataTransfer.files);
						
					}
					
					this.uiDropArea.removeClass('seao-fancy-uploader-drop-over');
					
				}.bind(this)
				
			});
			
			// prevent defaults on window
			
			this.bound = {
				stopEvent: this._stopEvent.bind(this)
			}
		
			$(document.body).addEvents({
				'dragenter': this.bound.stopEvent,
				'dragleave': this.bound.stopEvent,
				'dragover': this.bound.stopEvent,
				'drop': this.bound.stopEvent
			});
			
		}
		
		
		// Activate trigger for html file input
		
		this._activateHTMLButton();

		// Activate trigger for remote file input
		this._activateRemoteButton();

	},
	
	upload: function (){
		
		this.fileList.each(function(file, i){
	
			if (file.checked && !file.uploading && this.nCurrentUploads < this.options.max_queue) {
			// Upload only checked and new files

				file.uploading = true;
				this.nCurrentUploads++;
				
				this._html5Send(file, 0, false);
				this.fireEvent('itemUploadStart',[file.element, file]);
				
			}

		}, this);
		
		this.parent();
				
	},

	_html5Send: function (file, start, resume) {
		
		//if (this.uiList) item = this.uiList.getElement('#seao-fancy-uploader-item-' + (file.uniqueid));
		// now getting the item globally in case it was moved somewhere else in onItemAdded event
		// this way it can always remain controlled
		var item = file.element;
		
		var end = this.options.block_size,
			chunk,
			is_blob = true;

		var total = start + end;
		if (total > file.size) end = total - file.size;


		// Get slice method
		
		if (file.file.slice) { // Standard browsers
			chunk = file.file.slice(start, total);
		} else if (file.file.mozSlice) { // Mozilla based
			chunk = file.file.mozSlice(start, total);
		} else if (file.file.webkitSlice && !Browser.safari) {// Chrome 20- and webkit based // Safari slices the file badly
			chunk = file.file.webkitSlice(start, total);
		} else { // Safari 5-
			// send as form data instead of Blob
			chunk = new FormData();
			chunk.append('file', file.file);
			is_blob = false;
		}
		
		// Set headers
		
		var headers = {
			'Cache-Control': 'no-cache'
		}
		
		// Add call-specific vars
		
		var url = this.url + '&' + Object.toQueryString({
			'X-Requested-With': 'XMLHttpRequest',
			'X-File-Name': file.name,
			'X-File-Size': file.size,
			'X-File-Id': file.uniqueid,
			'X-File-Resume': resume,
			'is_url': file.is_url,
			'accept': this.options.accept && this.options.accept.replace('/*', ''),
		});
		
		// Send request
		
		var xhr = new Request.Blob({
			url: url,
			headers: headers,
			onProgress: function(e){
				if(!is_blob){
					
					// track xhr progress only if data isn't actually sent as a chunk (eg. in Safari)
					
					var perc = e.loaded / e.total * 100;
					this.fileList[file.id].progress = perc;
					this._itemProgress(item, perc);
					
				}
			}.bind(this),
			onSuccess: function (response) {
				
				try {
					response = JSON.decode(response, true);
				} catch(e){
					response = '';
				}
				
				if(typeof this.fileList[file.id] != 'undefined' && !this.fileList[file.id].cancelled){
				
					if (this._checkResponse(response)) {
						
						if (response.finish == true) { // || total >= file.size // sometimes the size is measured wrong and fires too early?
							
							// job done!
							
							this._itemComplete(item, file, response);
	
							if (this.nCurrentUploads != 0 && this.nCurrentUploads < this.options.max_queue && file.checked) this.upload();
	
						} else {
							
							// in progress..
							
							if(file.checked) {
								
								var perc = (total / file.size) * 100;
								
								// it's used to calculate global progress
								this.fileList[file.id].progress = perc;
								
								this._itemProgress(item, perc);
								
								this._html5Send(file, start + response.size.toInt(), true) // Recursive upload
								
							}
							
						}
						
					} else {
						
						// response errror!
						
						this._itemError(item, file, response);
						
					}
					
				} else {
					
					// item doesn't exist anymore, probably cancelled
					
				}

			}.bind(this),
			onFailure: function(){
				
				this._itemError(item, file);
				
			}.bind(this)
		});

		xhr.send(chunk);

	},

	cancel: function (id, item) {
		
		this.parent(id, item);
		
		//
		
	},
	
	kill: function(){
		
		this.parent();
		
		// remove events
		
		if(this.uiDropArea) $(document.body).removeEvents({
			'dragenter': this.bound.stopEvent,
			'dragleave': this.bound.stopEvent,
			'dragover': this.bound.stopEvent,
			'drop': this.bound.stopEvent
		});
		
	},
	
	
	/* Private methods */
	
	_newInput: function (){
		
		this.parent();
		
		// add interaction to input
		
		this.lastInput.addEvent('change', function (e) {
			
			e.stop();

			this.addFiles(this.lastInput.files);

		}.bind(this));
		
	},
	
	_itemError: function(item, file, response){
		
		this.parent(item, file, response);
				
		if(this.nCurrentUploads == 0)
			this._queueComplete();
		else if (this.nCurrentUploads != 0 && this.nCurrentUploads < this.options.max_queue)
			this.upload();
		
	},
	
	_stopEvent: function(e){
		e.stop();
	}

});