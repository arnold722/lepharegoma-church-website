jQuery(document).ready(function ($) {
	"use strict";

	// Check each sortable repeater initialization input field
	$('.footer_social_sortable_control').each(function () {

		// If there is an existing customizer value, populate our rows
		const valueHidden = $(this).find('.getDataHidden').val().split(',');
		const repeatItems = valueHidden.length / 4;

		const firstData = valueHidden[0]
		if (firstData) {
			$('.container-dropdown-footer-social .box-dropdown ul li#' + firstData).css('display', 'none');
			$('.container-dropdown-footer-social .box-dropdown ul li#' + firstData).attr('status', 'hidden');
		}

		// ----------------------------------------------
		// getDataHidden = (3) ['https://google.com', 'https://youtube.com', 'https://facebook.com']
		// repeatItems = 3

		// Save color custom
		jQuery(window).on("load", function(){
			if (repeatItems >= 0) {
				var i;
				for (i = 0; i < repeatItems; ++i) {
					// const testing = $('.sortable_repeater_footer_social').find('.repeater:eq('+index+')');
					// testing.css('background', 'blue');

					// Add color custom
					let mylabel = valueHidden[i + repeatItems + repeatItems + repeatItems];

					let colorOri = '';
					if (mylabel === 'facebook') {
						colorOri = '#3b5998';
					} else if (mylabel === 'youtube') {
						colorOri = '#ff0000';
					} else if (mylabel === 'twitter') {
						colorOri = '#000000';
					} else if (mylabel === 'tiktok') {
						colorOri = '#010101';
					} else if (mylabel === 'telegram') {
						colorOri = '#0088cc';
					} else if (mylabel === 'pinterest') {
						colorOri = '#bd081c';
					} else if (mylabel === 'linkedin') {
						colorOri = '#0a66c2';
					} else if (mylabel === 'instagram') {
						colorOri = '#c13584';
					} else if (mylabel === 'threads') {
						colorOri = '#000000';
					} else if (mylabel === 'whatsapp') {
						colorOri = '#25d366';
					}

					const sosmed = $.trim($('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').text());

					if ('facebook' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('facebook' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color)
							}
						}

						if ('facebook' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					} else if ('youtube' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('youtube' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('youtube' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					} else if ('twitter' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('twitter' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('twitter' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					} else if ('tiktok' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('tiktok' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('tiktok' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					} else if ('telegram' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('telegram' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('telegram' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					} else if ('pinterest' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('pinterest' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('pinterest' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					} else if ('linkedin' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('linkedin' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('linkedin' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}
					} else if ('instagram' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('instagram' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('instagram' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					} else if ('threads' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('threads' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('threads' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					} else if ('whatsapp' === mylabel) {

						let getcolor = $('li#customize-control-footer_social_icon_color_'+mylabel+'_setting .components-dropdown:eq(1) button');

						let color = '';
						color = getcolor.find('.color').attr('style');

						if (color) {
							color = color.replace('background: ', '');
							color = color.replace(';', '');

							if ('whatsapp' === sosmed) {
								$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().find('.gradient').css('background', color);
							}
						}

						if ('whatsapp' === sosmed) {
							$('.sortable_repeater_footer_social').find('.repeater.'+mylabel+' .box-info .text').next().next().find('.gradient').css('background', colorOri);
						}

					}
				}
			}
		});

		// Check all items
		if (repeatItems > 0) {

			// If the first field or is empty
			$(this).find('.title').val(valueHidden[0]);
			$(this).find('.content').val(valueHidden[repeatItems]);
			$(this).find('.link').val(valueHidden[repeatItems + repeatItems]);
			$(this).find('.sosmed').val(valueHidden[repeatItems + repeatItems + repeatItems]);

			// Create a new row for each new value
			if (repeatItems > 1) {

				var i;
				var index = 1;
				for (i = 1; i < repeatItems; ++i) {
					solaceAppendRow($(this), valueHidden[i], valueHidden[i + repeatItems], valueHidden[i + repeatItems + repeatItems], valueHidden[i + repeatItems + repeatItems + repeatItems]);

					const dataActive = valueHidden[i + repeatItems + repeatItems + repeatItems].replace(/\s/g, '');
					$('.container-dropdown-footer-social .box-dropdown ul li#' + dataActive).css('display', 'none');
					$('.container-dropdown-footer-social .box-dropdown ul li#' + dataActive).attr('status', 'hidden');
				}
			}

			let checked = true;
			var i;
			const lengthList = $('.container-dropdown-footer-social .box-dropdown ul li').length - 1;
			let total = []; 
			for (i = 0; i <= lengthList; ++i) {
				const dataStatus = $('.container-dropdown-footer-social .box-dropdown ul li:eq(' + i + ')').attr('status');
				const dataText = $('.container-dropdown-footer-social .box-dropdown ul li:eq(' + i + ')').text().replace(/\s/g, '');
				const dataActive = valueHidden[i + repeatItems + repeatItems + repeatItems];

				if (dataActive) {
					total.push(dataActive);
				}

				// display text select an item at the time it is relod (Save)
				if (checked) {
					if (dataStatus !== 'hidden') {
						const mytext = 'Select item';
						// $('.container-dropdown-footer-social .box-dropdown .title-active').text(dataText);
						$('.container-dropdown-footer-social .box-dropdown .title-active').text(mytext);
						checked = false;
					}
				}
			}

			// remove the dropdown if all the lists are already in use
			if (total.length === 7) {
				$('.container-dropdown-footer-social').css('display', 'none');
				$('.footer_social_sortable_control .add-new-label').css('display', 'none');
			}
		}
	});

	// Make our Repeater fields sortable (Drag and Drop)
	$(this).find('.sortable_repeater_footer_social.sortable').sortable({
		update: function (event, ui) {
			solaceGetAllInputs($(this).parent());
		}
	});

	// Open toggle slide
	$('.sortable_repeater_footer_social.sortable').on('click', '.repeater .box-info .toggle', function (event) {
		$(this).parent().toggleClass('active');
	});

	// Add new item
	$('.sortable_repeater_footer_social.sortable').on('click', '.repeater .box-info .close', function (event) {

		const infoSosmed = $(this).parent().parent().find('.box-input-sosmed .sosmed').val().replace(/\s/g, '');
		const activeList = $('.container-dropdown-footer-social .box-dropdown ul li[status="show"]').length;

		if (infoSosmed) {
			event.preventDefault();

			// Add dropdown
			$('.container-dropdown-footer-social .box-dropdown ul li#' + infoSosmed).attr('status', 'show');
			$('.container-dropdown-footer-social .box-dropdown ul li#' + infoSosmed).css('display', 'block');

			// Show dropdown
			if (activeList === 0) {
				const mytext = 'Select item';
				// $('.container-dropdown-footer-social .box-dropdown .title-active').text(infoSosmed);
				$('.container-dropdown-footer-social .box-dropdown .title-active').text(mytext);
				$('.container-dropdown-footer-social').css('display', 'flex');
				$('.footer_social_sortable_control .add-new-label').css('display', 'block');

			} else if (activeList >=1 ) {
				let checked = true;
				var i;
				const lengthList = $('.container-dropdown-footer-social .box-dropdown ul li').length - 1;
				for (i = 0; i <= lengthList; ++i) {
					if (checked) {
						const dataStatus = $('.container-dropdown-footer-social .box-dropdown ul li:eq(' + i + ')').attr('status');
						if (dataStatus === 'show') {
							const dataText = $('.container-dropdown-footer-social .box-dropdown ul li:eq(' + i + ')').text().replace(/\s/g, '');

							const mytext = 'Select item';
							// $('.container-dropdown-footer-social .box-dropdown .title-active').text(dataText);
							$('.container-dropdown-footer-social .box-dropdown .title-active').text(mytext);
							checked = false;
						}
					}
				}
			}

			$(this).parent().parent().slideUp('fast', function () {
				const parentContainer = $(this).parent().parent().parent();
				$(this).remove();
				solaceGetAllInputs(parentContainer);
			})
		}
	});

	// Refresh our hidden field if any fields change
	$('.sortable_repeater_footer_social.sortable').change(function () {
		solaceGetAllInputs($(this).parent());
	})

	// Trigger Change with input add new
	$('.sortable_repeater_footer_social.sortable').keyup(function () {
		const url = $(this);
		const val = url.val();

		// Trigger
		url.val(val).trigger('change');
	});

	// Append a new row to our list of elements
	function solaceAppendRow($element, defaultValueTitle = '', defaultValueContent = '', defaultValueLink = '', defaultValueSosmed = '') {
		let textDiv = '<div class="text">' + defaultValueSosmed + '</div>';

		if (defaultValueTitle === 'twitter') {
			textDiv = '<div class="text-code">X (Twitter)</div><div class="text">' + defaultValueSosmed + '</div>';
		}		
		const newRow = '<div row="appendRow1" class="repeater ' + defaultValueSosmed + '"> <div class="box-info"> <div class="drag"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"> <path d="M56 472a56 56 0 1 1 0-112 56 56 0 1 1 0 112zm0-160a56 56 0 1 1 0-112 56 56 0 1 1 0 112zM0 96a56 56 0 1 1 112 0A56 56 0 1 1 0 96z"></path> </svg> </div>' + textDiv + '<div class="box-color-custom"><button type="button"><span class="color"></span><span class="gradient"></span></button></div><div class="box-color-ori"><button type="button"><span class="color"></span><span class="gradient"></span></button></div><div id="toggle-slide" class="toggle"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg></div><div class="close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"> <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/> </svg> </div></div><div class="box-input-title"> <label> Title <input type="text" value="' + defaultValueTitle + '" class="title" placeholder=""/> </label> </div><div class="box-input-content" style="display:none;"> <label> Content <input type="text" value="' + defaultValueContent + '" class="content" placeholder=""/> </label> </div><div class="box-input-link"> <label> Link <input type="text" value="' + defaultValueLink + '" class="link" placeholder="Link '+defaultValueSosmed+'"/> </label> </div><div class="box-input-sosmed"><label>Sosmed<input type="text" value="' + defaultValueSosmed + '" class="sosmed" placeholder=""/></label></div></div>';

		$element.find('.sortable').append(newRow);
		$element.find('.sortable').find('.repeater:last').slideDown('fast', function () {
			$(this).find('input').focus();
		});
	}

	// Get the values from the repeater input fields and add to our hidden field
	function solaceGetAllInputs($element) {
		const inputValues = $element.find('.title').map(function () {
			return $(this).val();
		}).toArray();

		const inputContent = $element.find('.content').map(function () {
			return $(this).val();
		}).toArray();

		const inputLink = $element.find('.link').map(function () {
			return $(this).val();
		}).toArray();

		const inputSosmed = $element.find('.sosmed').map(function () {
			return $(this).val();
		}).toArray();

		// Add all the values from our repeater fields to the hidden field (which is the one that actually gets saved)
		const merge = inputValues.concat(inputContent);
		const merge2 = merge.concat(inputLink);
		const merge3 = merge2.concat(inputSosmed);

		$element.find('.getDataHidden').val(merge3);
		// Important! Make sure to trigger change event so Customizer knows it has to save the field
		$element.find('.getDataHidden').trigger('change');
	}

	// -------------------------- Dropdown --------------------------
	$(function () {
		var dd1 = new dropDown($('.container-dropdown-footer-social #box-dropdown'));

		$(document).click(function () {
			$('.container-dropdown-footer-social .box-dropdown').removeClass('active');
		});
	});

	function dropDown(el) {
		this.dd = el;
		this.placeholder = this.dd.children('span');
		this.opts = this.dd.find('ul > li');
		this.val = '';
		this.index = -1;
		this.initEvents();
	}
	dropDown.prototype = {
		initEvents: function () {
			var obj = this;

			obj.dd.on('click', function () {
				$(this).toggleClass('active');
				return false;
			});

			obj.opts.on('click', function () {
				var opt = $(this);
				obj.val = opt.text();
				obj.index = opt.index();
				obj.placeholder.text(obj.val);
			});
		}
	}

	// -------------------------- Dropdown --------------------------
	$('.container-dropdown-footer-social .box-add-dropdown button').click(function (event) {
		let getDataActive = $('.container-dropdown-footer-social .box-dropdown .title-active').text();
		const lengthList = $('.container-dropdown-footer-social .box-dropdown ul li').length - 1;

		if ( 'x (twitter)' === getDataActive ) {
			getDataActive = 'twitter';
		}

		// ------ Remove dropdown on click ------
		var i;
		for (i = 0; i <= lengthList; ++i) {
			const dataList = $('.container-dropdown-footer-social .box-dropdown ul li:eq(' + i + ')').attr('data');
			const dataStatus = $('.container-dropdown-footer-social .box-dropdown ul li:eq(' + i + ')').attr('status');

			const labelActive = getDataActive.replace(/\s/g, '');
			if (labelActive) {
				$('.container-dropdown-footer-social .box-dropdown ul li#' + labelActive).css('display', 'none');
				$('.container-dropdown-footer-social .box-dropdown ul li#' + labelActive).attr('status', 'hidden');
			}

			// console.log(dataStatus);
		}

		// ------ Add new button inject ------
		let label = $('.container-dropdown-footer-social .box-dropdown .title-active').text();
		if ( 'x (twitter)' === label ) {
			label = 'twitter';
		}		

		if ('Select item' === label) {
			alert('Please select an item!');
			return;
		}

		// Box info all closed
		$('.sortable_repeater_footer_social .repeater .box-info').removeClass('active');
		function solaceAppendRow2($element, defaultValueTitle = label, defaultValueContent = '', defaultValueLink = '', defaultValueSosmed = label) {
			let mycolor = $('li#customize-control-footer_social_icon_color_'+label+'_setting .components-dropdown:eq(1) button');

			let color = mycolor.find('.color').attr('style');
			if (color) {
				color = color.replace('background: ', '');
				color = color.replace(';', '');
			}

			let colorOri = '';
			if (label === 'facebook') {
				colorOri = '#3b5998';
			} else if (label === 'youtube') {
				colorOri = '#ff0000';
			} else if (label === 'twitter') {
				colorOri = '#000000';
			} else if (label === 'tiktok') {
				colorOri = '#010101';
			} else if (label === 'telegram') {
				colorOri = '#0088cc';
			} else if (label === 'pinterest') {
				colorOri = '#bd081c';
			} else if (label === 'linkedin') {
				colorOri = '#0a66c2';
			} else if (label === 'instagram') {
				colorOri = '#c13584';
			} else if (label === 'threads') {
				colorOri = '#000000';
			} else if (label === 'whatsapp') {
				colorOri = '#25d366';
			}

			const label_text = label === 'twitter' ? 'x (twitter)' : label;

			const newRow = '<div row="appendRow2" class="repeater ' + label + '"> <div class="box-info active"> <div class="drag"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"> <path d="M56 472a56 56 0 1 1 0-112 56 56 0 1 1 0 112zm0-160a56 56 0 1 1 0-112 56 56 0 1 1 0 112zM0 96a56 56 0 1 1 112 0A56 56 0 1 1 0 96z"></path> </svg> </div><div class="text"> ' + label_text + ' </div><div class="box-color-custom"><button type="button"><span class="color"></span><span style="background:'+color+';" class="gradient"></span></button></div><div class="box-color-ori"><button type="button"><span class="color"></span><span style="background:'+colorOri+';" class="gradient"></span></button></div><div id="toggle-slide" class="toggle"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg></div><div class="close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"> <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/> </svg> </div></div><div class="box-input-title"> <label> Title <input type="text" value="' + defaultValueTitle + '" class="title" placeholder=""/> </label> </div><div class="box-input-content" style="display: none;"> <label> Content <input type="text" value="' + defaultValueContent + '" class="content" placeholder=""/> </label> </div><div class="box-input-link"> <label> Link <input type="text" value="' + defaultValueLink + '" class="link" placeholder="Link '+label_text+'"/> </label> </div><div class="box-input-sosmed"><label>Sosmed<input type="text" value="' + defaultValueSosmed + '" class="sosmed" placeholder=""/></label></div></div>';

			$element.find('.sortable').append(newRow);
			$element.find('.sortable').find('.repeater:last').slideDown('fast', function () {
				$(this).find('input').focus();
			});
		}

		// ------ Change text title active dropdown ------
		event.preventDefault();
		solaceAppendRow2($('.control-sortable-repeater-footer-social-add').parent());
		solaceGetAllInputs($('.control-sortable-repeater-footer-social-add').parent());

		let checked = true;
		for (i = 0; i <= lengthList; ++i) {
			const dataStatus = $('.container-dropdown-footer-social .box-dropdown ul li:eq(' + i + ')').attr('status');
			const dataText = $('.container-dropdown-footer-social .box-dropdown ul li:eq(' + i + ')').text().replace(/\s/g, '');
			if (checked) {
				if (dataStatus !== 'hidden') {
					const mytext = 'Select item';
					// $('.container-dropdown-footer-social .box-dropdown .title-active').text(dataText);
					$('.container-dropdown-footer-social .box-dropdown .title-active').text(mytext);
					checked = false;
				}
			}
		}

		// If the dropdown list has been used all then hide dropdown
		const activeList = $('.container-dropdown-footer-social .box-dropdown ul li[status="show"]').length;
		if (activeList === 0) {
			$('.container-dropdown-footer-social').css('display', 'none');
			$('.footer_social_sortable_control .add-new-label').css('display', 'none');
		}

	});

	// Box color custom open
	$('.sortable_repeater_footer_social').on('click', '.box-color-custom button', function() {
		let getInfoSosmed = $(this).parent().parent().parent().find('.box-input-sosmed .sosmed').val();

		// Trigger color
		if (getInfoSosmed === 'facebook') {
			let btn = $('li#customize-control-footer_social_icon_color_facebook_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'youtube') {
			let btn = $('li#customize-control-footer_social_icon_color_youtube_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'twitter') {
			let btn = $('li#customize-control-footer_social_icon_color_twitter_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'tiktok') {
			let btn = $('li#customize-control-footer_social_icon_color_tiktok_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'telegram') {
			let btn = $('li#customize-control-footer_social_icon_color_telegram_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'pinterest') {
			let btn = $('li#customize-control-footer_social_icon_color_pinterest_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'linkedin') {
			let btn = $('li#customize-control-footer_social_icon_color_linkedin_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'instagram') {
			let btn = $('li#customize-control-footer_social_icon_color_instagram_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'threads') {
			let btn = $('li#customize-control-footer_social_icon_color_threads_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		} else if (getInfoSosmed === 'whatsapp') {
			let btn = $('li#customize-control-footer_social_icon_color_whatsapp_setting .components-dropdown:eq(1) button');
			btn.trigger('click');
		}
	});

	// Toggle save
	jQuery(window).on("load", function(){
		if ($('li#customize-control-footer_social_toggle_icon input').is(":checked")) {
			// ON
			$('.sortable_repeater_footer_social .repeater .box-info .box-color-custom').css('display', 'none');
			$('.sortable_repeater_footer_social .repeater .box-info .box-color-ori').css('display', 'block');
		} else {
			// OFF
			$('.sortable_repeater_footer_social .repeater .box-info .box-color-custom').css('display', 'block');
			$('.sortable_repeater_footer_social .repeater .box-info .box-color-ori').css('display', 'none');
		}
	});

	// Toggle click
	$('li#customize-control-footer_social_toggle_icon label').click(function(){
		if ($('li#customize-control-footer_social_toggle_icon input').is(":checked")) {
			// OFF
			$('.sortable_repeater_footer_social .repeater .box-info .box-color-custom').css('display', 'block');
			$('.sortable_repeater_footer_social .repeater .box-info .box-color-ori').css('display', 'none');
		} else {
			// ON
			$('.sortable_repeater_footer_social .repeater .box-info .box-color-custom').css('display', 'none');
			$('.sortable_repeater_footer_social .repeater .box-info .box-color-ori').css('display', 'block');
		}
	});

});