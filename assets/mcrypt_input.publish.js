jQuery(function() {
	jQuery('.field-mcrypt_input').each(function() {		
		// masquerade as a file upload for styling purposes
		var field = jQuery(this).addClass('file');
		var frame = jQuery(this).find('.frame');
		var action = jQuery('<em>Change</em>').appendTo(frame);
		action.bind('click', function(e) {
			e.preventDefault();
			// clone the hidden field that contains the hashed value
			var input = field.find('input').clone().remove();
			frame.remove();
			// append a new input field ready for new value
			field.removeClass('file').find('label').append(input.attr('type', 'text').val(''));
		});
	});
});