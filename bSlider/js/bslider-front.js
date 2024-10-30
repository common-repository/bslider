var bSlider = {
	steps: function(){
		jQuery('#bslider .steps').html('');
		for(var i=0;i<jQuery('#bslider .slide').size();i++){
			jQuery('#bslider .steps').append('<span class="step"></span>');
			jQuery('#bslider .steps .step:last').attr('step', i);
		}
	},
	loop: function(settings){
		var curStep = parseInt(jQuery('#bslider .steps .step.active').attr('step')||-1);
		var nexStep = (curStep+1 < jQuery('#bslider .steps .step').size())?curStep+1:0;
		(settings.debug)?console.log('curStep', curStep, 'nextStep', nexStep):'';
		jQuery('#bslider .steps .step:eq('+curStep+')').addClass('active');
		jQuery('#bslider .steps .step').removeClass('active');
		jQuery('#bslider .steps .step:eq('+nexStep+')').addClass('active');
		
		jQuery('#bslider .slide').removeClass('active');
		jQuery('#bslider .slide:eq('+nexStep+')').addClass('active');	
		
		jQuery('#bslider .slide:eq('+nexStep+') .caption')
		.css({opacity: 0, bottom: '10px'})
		.animate({opacity: 1, bottom: '60px'}, 1000);
		jQuery('#bslider .slide:eq('+nexStep+') .title')
		.css({opacity: 0, bottom: '160px'})
		.animate({opacity: 1, bottom: '120px', }, 1000);
		
		(settings.ltr == 'rtl')?jQuery('#bslider .slide:eq('+nexStep+') .caption, #bslider .slide:eq('+nexStep+') .title').addClass('rtl'):''; 
	},
	play: function(settings){
		bSlider.steps();
		bSlider.loop(settings);
		if(settings.autoplay){
			var bSliderInterval = setInterval(function(){
				bSlider.loop(settings);		
			}, 1000*settings.delay)
		}
	},
	init: function(settings){
		jQuery('body').addClass('js');			
		if(jQuery('body').hasClass('js'))
			bSlider.play(settings);
	}
};