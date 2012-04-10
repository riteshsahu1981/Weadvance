/**
 * THIS SOFTWARE IS PROVIDED "AS IS" AND THE AUTHOR DISCLAIMS ALL WARRANTIES
 * WITH REGARD TO THIS SOFTWARE INCLUDING ALL IMPLIED WARRANTIES OF
 * MERCHANTABILITY AND FITNESS. IN NO EVENT SHALL THE AUTHOR BE LIABLE FOR
 * ANY SPECIAL, DIRECT, INDIRECT, OR CONSEQUENTIAL DAMAGES OR ANY DAMAGES
 * WHATSOEVER RESULTING FROM LOSS OF USE, DATA OR PROFITS, WHETHER IN AN
 * ACTION OF CONTRACT, NEGLIGENCE OR OTHER TORTIOUS ACTION, ARISING OUT OF
 * OR IN CONNECTION WITH THE USE OR PERFORMANCE OF THIS SOFTWARE.
 */


$(function() {
	
	
	// Set every column segment with h5 element as a sortable widget
	$('.column:has(h5)').each(function() {
			
			var s = $(this);
			//var p = s.parentsUntil('.section').parent();
			var h = s.children('h5:first').eq(0);
			
			//if(!p.hasClass('ui-widget'))
				//p.addClass(sortClasses);
			
			// Function icons
			h.addClass('ui-widget-header')
				.prepend('<span class="ui-icon ui-icon-minus" title="Toggle"></span>')
				.prepend('<span class="ui-icon ui-icon-close" title="Close"></span>');
	
			// Need this to drag not highlight
			h.disableSelection();
			
			// Interaction cues
			h.css('cursor', 'move');
			$('.ui-icon').css('cursor', 'pointer');
	
			// Wrap control stuff (like icons and headers) in a widget-header div
			// and the rest in a widget-content div
			s.children().not('img[alt="icon"], .ui-widget-header, .ui-icon')
				.wrapAll('<div class="widget-content" />');
			
			s.children().not('widget-content').wrapAll('<div class="widget-header" />');
		});
//	initDialogs();
	setControls();
	
	
	
	
	function initDialogs() {
		// Close widget dialog
		$('.movable_div').append('<div id="dialog-confirm-close-widget" title="Close widget" style="display:none;">' + 
			'<span class="ui-icon ui-icon-alert" style="float:left;"></span>' +
			'You are about to delete this widget. Are you sure?</div>');
		
	
		// Create and destroy these dialogs to hide them
		$('#dialog-confirm-close-widget').dialog("destroy");

	}
	
	
	
	
	/**********************************
		Widget controls
	***********************************/
	
	// Control icons
	function setControls(ui) {
		ui = (ui)? ui : $('.ui-icon');
		ui.click(function() {
			var b = $(this);
			var p = b.parentsUntil('.column').parent();
			
			var h = p.children('.ui-widget-header h5:first').eq(0);
		
			// Control functionality
			switch(b.attr('title').toLowerCase()) {
				
				case 'toggle':
					widgetToggle(b, p);
					break;
				
				case 'close':
					widgetClose(p);
					break;
			}
		});
	}
	
	// Toggle widget
	function widgetToggle(b, p) {
		// Change the + into - and visa versa
		b.toggleClass('ui-icon-minus').toggleClass('ui-icon-plus');
		
		// Show/Hide widget content
		p.children('.widget-content').eq(0).toggle(300);
	}
	
	
	// Close widget with dialog
	function widgetClose(p) {
		$("#dialog-confirm-close-widget").dialog({
			resizable: false,
			modal: true,
			buttons: {
				"Close widget": function() {
					p.toggle('slide', {}, 500, function() {
						p.remove();
					});
					$(this).dialog("close");
				},
				"Cancel": function() {
					$(this).dialog("close");
				}
			}
		});
	}
	
	
	
	
	
	
		
	$(".section").sortable({
		opacity: 0.6,
		helper: 'clone',
		dropOnEmpty: true
	});
	
	
	
	
	
});

/*

WTF is juice?!
	- Dave Chappelle

*/