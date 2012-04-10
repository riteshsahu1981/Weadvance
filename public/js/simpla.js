$(document).ready(function(){
	
	//Sidebar Accordion Menu:
		
		$("#main-nav li ul").hide(); // Hide all sub menus
		$("#main-nav li a.current").parent().find("ul").slideToggle("slow"); // Slide down the current menu item's sub menu
		
		$("#main-nav li a.nav-top-item").click( // When a top menu item is clicked...
			function () {
				$(this).parent().siblings().find("ul").slideUp("normal"); // Slide up all sub menus except the one clicked
				$(this).next().slideToggle("normal"); // Slide down the clicked sub menu
				return false;
			}
		);
		
		$("#main-nav li a.no-submenu").click( // When a menu item with no sub menu is clicked...
			function () {
				window.location.href=(this.href); // Just open the link instead of a sub menu
				return false;
			}
		); 

    // Sidebar Accordion Menu Hover Effect:
		
		$("#main-nav li .nav-top-item").hover(
			function () {
				$(this).stop().animate({ paddingRight: "25px" }, 200);
			}, 
			function () {
				$(this).stop().animate({ paddingRight: "15px" });
			}
		);

    
    
            $(".close").click(
			function () {
                            
                            $(this).parent().slideUp(500);
//				$(this).parent().fadeTo(400, 0, function () { // Links with the class "close" will close parent
//					$(this).slideUp(400);
//				});
				return false;
			}
		);
    




    // $('html, body').scrollTop() ;
  $('html, body').animate({scrollTop: 0}, 10);

});
  
function Flash_HideHandler( handlerID ){
	jQuery('#'+handlerID).slideUp(500);
        
        
//        jQuery('#'+handlerID).fadeTo(500, 0, function () { // Links with the class "close" will close parent
//                    jQuery('#'+handlerID).slideUp(500);
//            });
                                
                                
}

function Flash_DelayedHide( handlerID ){
    setTimeout( "Flash_HideHandler('"+handlerID+"')" , 3000 );
}
  