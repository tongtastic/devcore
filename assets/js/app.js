jQuery(document).ready(function() {
	
	// load fit vids jquery plugin
	jQuery('body').fitVids();

	jQuery('body table').wrap('<div class="table-responsive"></div>');
	
	//primary nav scripts
	
	jQuery('.primary-nav > ul > li').hoverIntent(show_subnav_level_1, hide_subnav_level_1);
	
	jQuery('.primary-nav > ul > li > ul > li').hoverIntent(show_subnav_level_2, hide_subnav_level_2);
	
	// add inview class to trigger CSS3 animations
	
	
	jQuery('.search-btn').click(function() {
		
		jQuery(this).toggleClass('active').parent().children('.search-form-wrapper').fadeToggle();
		
		return false;
				
	});

	jQuery('.login-btn').click(function() {
		
		jQuery(this).toggleClass('active').parent().children('.login-form-wrapper').fadeToggle();
		
		return false;
				
	});
	
	jQuery('select').addClass('form-control');
	
	
	jQuery('.toggle-chevron.open').addClass('openu');
	
	jQuery('.toggle-chevron').click(function() {
		
		jQuery(this).toggleClass('openu');		
		
	});

	var mobilenav = jQuery.jPanelMenu({
	    menu: '#primary-nav',
	    trigger: '.primary-nav-trigger',
	    duration: 300,
	    excludedPanelContent: 'style, script, .modal'
	});

	mobilenav.on();
	
	jQuery('#jPanelMenu-menu div').removeClass('col-md-12');
	jQuery('#jPanelMenu-menu li').removeClass('col-md-6');

	jQuery('.panel-group .panel:first-child').addClass('active');

	jQuery('.panel-title a').click(function() {

		jQuery(this).parents('.panel-group').children('.panel').removeClass('active');

		jQuery(this).parents('.panel').addClass('active');

	});

	jQuery('.panel-heading').prepend('<span class="tab-c top left"></span><span class="tab-c top right"></span>');
	jQuery('.panel-heading').append('<span class="glyphicon glyphicon-chevron-down"></span><span class="tab-c bottom left"></span><span class="tab-c bottom right"></span>');
		
});


// shows 1st level sub nav items

function show_subnav_level_1() {
	
	var thischild = jQuery(this).children('ul.sub-nav-1');
	
	// adds bg color to top nav
	
	jQuery('.top-nav-wrapper').addClass('showbg');
	
	jQuery(thischild).fadeIn('fast').css('overflow','visible');
	
	find_min_height(thischild);
	
}

// hides 1st level sub nav items

function hide_subnav_level_1() {
	
	var thischild = jQuery(this).children('ul.sub-nav-1');
	
	// removes bg color from top nav
	
	jQuery('.top-nav-wrapper').removeClass('showbg');
	
	jQuery(thischild).fadeOut('fast').css('overflow','visible');
	
}

// shows 2nd level sub nav items with sliding out box

function show_subnav_level_2() {
	
	var thischild = jQuery(this).children('div.sub-item-1-wrapper');
	
	var target_width = (jQuery(thischild).children('div.sub-item-1-container').width() + parseInt(1));
		
	jQuery(thischild).animate({width: target_width}, 'fast');
	
}

// hides 2nd level sub nav items with sliding out box

function hide_subnav_level_2() {
	
	var thischild = jQuery(this).children('div.sub-item-1-wrapper');
		
	jQuery(thischild).animate({width: 0}, 'fast');
	
}

// finds min height value from current selected drop down

function find_min_height(menu) {
	
	var min_height = jQuery(menu).height();
			
	jQuery(menu).each(function() {
	
		jQuery('div.sub-item-1-container').css('min-height', min_height);
		
	});
	
}