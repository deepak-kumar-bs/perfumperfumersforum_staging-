<div id="seao_layout_spacer_block_<?php echo $this->identity ?>"> </div>

<script type="text/javascript">
	setSpaceBetweenWidget("seao_layout_spacer_block_<?php echo $this->identity ?>")
	function setSpaceBetweenWidget(elementId){
	
        let layoutColumn = $(elementId).getParent();
        if(layoutColumn){
	        layoutColumn.className = "";
	        if(layoutColumn.previousElementSibling)
	        	layoutColumn.style.marginBottom = "<?php echo $this->layoutWidth ?>px";
		}
		$(elementId).destroy();
    }
    
</script>