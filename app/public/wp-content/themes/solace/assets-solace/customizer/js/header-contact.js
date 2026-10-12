jQuery(document).ready(function ($) {
	"use strict";

	// Sanitize text input.
	function solaceSanitizeInput(input) {
		return input.replace(/[^a-zA-Z0-9]/g, '');
	}

	// Check each sortable repeater initialization input field
	$('.header_contact_sortable_control').each(function () {

		// If there is an existing customizer value, populate our rows
		const valueHidden = $(this).find('.getDataHidden').val().split('solcomma');
		const repeatItems = valueHidden.length / 4;

		const firstData = valueHidden[0]
		if (firstData) {
			$('.container-dropdown-header-contact .box-dropdown ul li#solace' + solaceSanitizeInput(firstData)).css('display', 'none');
			$('.container-dropdown-header-contact .box-dropdown ul li#solace' + solaceSanitizeInput(firstData)).attr('status', 'hidden');
		}

		// ----------------------------------------------
		// getDataHidden = (3) ['https://google.com', 'https://youtube.com', 'https://facebook.com']
		// repeatItems = 3

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
				for (i = 1; i < repeatItems; ++i) {
					solaceAppendRow($(this), valueHidden[i], valueHidden[i + repeatItems], valueHidden[i + repeatItems + repeatItems], valueHidden[i + repeatItems + repeatItems + repeatItems]);

					const dataActive = valueHidden[i + repeatItems + repeatItems + repeatItems].replace(/\s/g, '');
					$('.container-dropdown-header-contact .box-dropdown ul li#solace' + solaceSanitizeInput(dataActive)).css('display', 'none');
					$('.container-dropdown-header-contact .box-dropdown ul li#solace' + solaceSanitizeInput(dataActive)).attr('status', 'hidden');
				}
			}

			let checked = true;
			var i;
			const lengthList = $('.container-dropdown-header-contact .box-dropdown ul li').length - 1;
			let total = []; 
			for (i = 0; i <= lengthList; ++i) {
				const dataStatus = $('.container-dropdown-header-contact .box-dropdown ul li:eq(' + i + ')').attr('status');
				const dataText = $('.container-dropdown-header-contact .box-dropdown ul li:eq(' + i + ')').text().replace(/\s/g, '');
				const dataActive = valueHidden[i + repeatItems + repeatItems + repeatItems];

				if (dataActive) {
					total.push(dataActive);
				}

				if (checked) {
					if (dataStatus !== 'hidden') {
						const mytext = 'Select item';
						// $('.container-dropdown-header-contact .box-dropdown .title-active').text(dataText);
						$('.container-dropdown-header-contact .box-dropdown .title-active').text(mytext);
						checked = false;
					}
				}
			}

			if (total.length === 7) {
				$('.container-dropdown-header-contact').css('display', 'none');
				$('.header_contact_sortable_control .add-new-label').css('display', 'none');
			}
		}
	});

	// Make our Repeater fields sortable (Drag and Drop)
	$(this).find('.sortable_repeater_header_contact.sortable').sortable({
		update: function (event, ui) {
			solaceGetAllInputs($(this).parent());
		}
	});

	// Open toggle slide
	$('.sortable_repeater_header_contact.sortable').on('click', '.repeater .box-info .toggle', function (event) {
		$(this).parent().toggleClass('active');
	});

	// Add new item
	$('.sortable_repeater_header_contact.sortable').on('click', '.repeater .box-info .close', function (event) {

		const infoSosmed = $(this).parent().parent().find('.box-input-sosmed .sosmed').val().replace(/\s/g, '');
		const activeList = $('.container-dropdown-header-contact .box-dropdown ul li[status="show"]').length;

		if (infoSosmed) {
			event.preventDefault();

			// Add dropdown
			$('.container-dropdown-header-contact .box-dropdown ul li#solace' + solaceSanitizeInput(infoSosmed)).attr('status', 'show');
			$('.container-dropdown-header-contact .box-dropdown ul li#solace' + solaceSanitizeInput(infoSosmed)).css('display', 'block');

			// Show dropdown
			if (activeList === 0) {
				const mytext = 'Select item';
				// $('.container-dropdown-header-contact .box-dropdown .title-active').text(infoSosmed);
				$('.container-dropdown-header-contact .box-dropdown .title-active').text(mytext);
				$('.container-dropdown-header-contact').css('display', 'flex');
				$('.header_contact_sortable_control .add-new-label').css('display', 'block');

			} else if (activeList >=1 ) {
				let checked = true;
				var i;
				const lengthList = $('.container-dropdown-header-contact .box-dropdown ul li').length - 1;
				for (i = 0; i <= lengthList; ++i) {
					if (checked) {
						const dataStatus = $('.container-dropdown-header-contact .box-dropdown ul li:eq(' + i + ')').attr('status');
						if (dataStatus === 'show') {
							const dataText = $('.container-dropdown-header-contact .box-dropdown ul li:eq(' + i + ')').text().replace(/\s/g, '');

							const mytext = 'Select item';
							// $('.container-dropdown-header-contact .box-dropdown .title-active').text(dataText);
							$('.container-dropdown-header-contact .box-dropdown .title-active').text(mytext);
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
	$('.sortable_repeater_header_contact.sortable').change(function () {
		solaceGetAllInputs($(this).parent());
	})

	// Trigger Change with input add new
	$('.sortable_repeater_header_contact.sortable').keyup(function () {
		const url = $(this);
		const val = url.val();

		// Trigger
		url.val(val).trigger('change');
	});

	// Append a new row to our list of elements
	function solaceAppendRow($element, defaultValueTitle = '', defaultValueContent = '', defaultValueLink = '', defaultValueSosmed = '') {
		const newRow = '<div class="repeater"> <div class="box-info"> <div class="drag"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"> <path d="M56 472a56 56 0 1 1 0-112 56 56 0 1 1 0 112zm0-160a56 56 0 1 1 0-112 56 56 0 1 1 0 112zM0 96a56 56 0 1 1 112 0A56 56 0 1 1 0 96z"></path> </svg> </div><div class="text"> ' + defaultValueSosmed + ' </div><div id="toggle-slide" class="toggle"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg></div><div class="close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"> <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/> </svg> </div></div><div class="box-input-title"> <label><input type="text" value="' + defaultValueTitle + '" class="title" placeholder="Title"/> </label> </div><div class="box-input-content"> <label><input type="text" value="' + defaultValueContent + '" class="content" placeholder="Content"/> </label> </div><div class="box-input-link"> <label><input type="text" value="' + defaultValueLink + '" class="link" placeholder="Link"/> </label> </div><div class="box-input-sosmed"><label>Sosmed<input type="text" value="' + defaultValueSosmed + '" class="sosmed" placeholder=""/></label></div></div>';

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

		// Merge all the values with "solcomma" separator and convert to string
		const mergedString = [inputValues, inputContent, inputLink, inputSosmed].flat().join('solcomma');

		$element.find('.getDataHidden').val(mergedString);
		// Important! Make sure to trigger change event so Customizer knows it has to save the field
		$element.find('.getDataHidden').trigger('change');
	}

	// -------------------------- Dropdown --------------------------
	$(function () {
		var dd1 = new dropDown($('.container-dropdown-header-contact #box-dropdown'));

		$(document).click(function () {
			$('.container-dropdown-header-contact .box-dropdown').removeClass('active');
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
	$('.container-dropdown-header-contact .box-add-dropdown button').click(function (event) {
		const getDataActive = $('.container-dropdown-header-contact .box-dropdown .title-active').text();
		const lengthList = $('.container-dropdown-header-contact .box-dropdown ul li').length - 1;

		// console.log(getDataActive);
		// console.log(lengthList);

		// ------ Remove dropdown on click ------
		var i;
		for (i = 0; i <= lengthList; ++i) {
			const dataList = $('.container-dropdown-header-contact .box-dropdown ul li:eq(' + i + ')').attr('data');
			const dataStatus = $('.container-dropdown-header-contact .box-dropdown ul li:eq(' + i + ')').attr('status');

			const labelActive = getDataActive.replace(/\s/g, '');
			if (labelActive) {
				$('.container-dropdown-header-contact .box-dropdown ul li#solace' + solaceSanitizeInput(labelActive)).css('display', 'none');
				$('.container-dropdown-header-contact .box-dropdown ul li#solace' + solaceSanitizeInput(labelActive)).attr('status', 'hidden');
			}

			// console.log(dataStatus);
		}

		// ------ Add new button inject ------
		const label = $('.container-dropdown-header-contact .box-dropdown .title-active').text();

		if ('Select item' === label) {
			alert('Please select an item!');
			return;
		}

		// Box info all closed
		$('.sortable_repeater_header_contact .repeater .box-info').removeClass('active');
		function solaceAppendRow2($element, defaultValueTitle = label, defaultValueContent = '', defaultValueLink = '', defaultValueSosmed = label) {
			const newRow = '<div class="repeater"> <div class="box-info active"> <div class="drag"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512"> <path d="M56 472a56 56 0 1 1 0-112 56 56 0 1 1 0 112zm0-160a56 56 0 1 1 0-112 56 56 0 1 1 0 112zM0 96a56 56 0 1 1 112 0A56 56 0 1 1 0 96z"></path> </svg> </div><div class="text"> ' + label + ' </div><div id="toggle-slide" class="toggle"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path d="M201.4 342.6c12.5 12.5 32.8 12.5 45.3 0l160-160c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L224 274.7 86.6 137.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l160 160z"/></svg></div><div class="close"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"> <path d="M310.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L160 210.7 54.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L114.7 256 9.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L160 301.3 265.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L205.3 256 310.6 150.6z"/> </svg> </div></div><div class="box-input-title"> <label><input type="text" value="' + defaultValueTitle + '" class="title" placeholder="Title"/> </label> </div><div class="box-input-content"> <label><input type="text" value="' + defaultValueContent + '" class="content" placeholder="Content"/> </label> </div><div class="box-input-link"> <label><input type="text" value="' + defaultValueLink + '" class="link" placeholder="Link"/> </label> </div><div class="box-input-sosmed"><label>Sosmed<input type="text" value="' + defaultValueSosmed + '" class="sosmed" placeholder=""/></label></div></div>';

			$element.find('.sortable').append(newRow);
			$element.find('.sortable').find('.repeater:last').slideDown('fast', function () {
				$(this).find('input').focus();
			});
		}

		// ------ Change text title active dropdown ------
		event.preventDefault();
		solaceAppendRow2($('.control-sortable-repeater-header-contact-add').parent());
		solaceGetAllInputs($('.control-sortable-repeater-header-contact-add').parent());

		let checked = true;
		for (i = 0; i <= lengthList; ++i) {
			const dataStatus = $('.container-dropdown-header-contact .box-dropdown ul li:eq(' + i + ')').attr('status');
			const dataText = $('.container-dropdown-header-contact .box-dropdown ul li:eq(' + i + ')').text().replace(/\s/g, '');
			if (checked) {
				if (dataStatus !== 'hidden') {
					const mytext = 'Select item';
					// $('.container-dropdown-header-contact .box-dropdown .title-active').text(dataText);
					$('.container-dropdown-header-contact .box-dropdown .title-active').text(mytext);
					checked = false;
				}
			}
		}

		// If the dropdown list has been used all then hide dropdown
		const activeList = $('.container-dropdown-header-contact .box-dropdown ul li[status="show"]').length;
		if (activeList === 0) {
			$('.container-dropdown-header-contact').css('display', 'none');
			$('.header_contact_sortable_control .add-new-label').css('display', 'none');
		}

	});

});