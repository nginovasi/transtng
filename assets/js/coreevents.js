class CoreEvents {
	constructor() { }

	load(filter, orderCustom = [0, 'asc'], placeholder = "") {
		var thisClass = this;

		//Destroy the old Datatable
		$('#datatable').DataTable().clear().destroy();

		this.table = $('#datatable').DataTable({
			"serverSide": true,
			"processing": true,
			"ordering": true,
			"paging": true,
			"order": orderCustom,
			"searching": { "regex": true },
			"language": {
				"searchPlaceholder": placeholder
			},
			"lengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
			"pageLength": 10,
			"searchDelay": 2000,
			"ajax": {
				"type": "POST",
				"url": url + "_load",
				"dataType": "json",
				"data": function (data) {
					data.filter = filter
					// console.log(thisClass);
					// Grab form values containing user options
					dataStart = data.start;
					let form = {};
					Object.keys(data).forEach(function (key) {
						form[key] = data[key] || "";
					});

					// Add options used by Datatables
					let info = {
						"start": data.start || 0,
						"length": data.length,
						"draw": 1
					};

					$.extend(form, info);
					$.extend(form, thisClass.csrf);

					return form;
				},
				"complete": function (response) {
					// console.log(response);
					// feather.replace();
				}
			},
			"columns": thisClass.tableColumn
		}).on('init.dt', function () {
			$(this).css('width', '100%');
		});

		$(document).on('submit', '#form', function (e) {
			e.preventDefault();
			let $this = $(this);

			Swal.fire({
				title: "Simpan data ?",
				icon: "question",
				showCancelButton: true,
				confirmButtonText: "Simpan",
				cancelButtonText: "Batal",
				reverseButtons: true
			}).then(function (result) {
				if (result.value) {
					Swal.fire({
						title: "",
						icon: "info",
						text: "Proses menyimpan data, mohon ditunggu...",
						didOpen: function () {
							Swal.showLoading()
						}
					});

					$.ajax({
						url: thisClass.url + "_save",
						type: 'post',
						data: $this.serialize(),
						dataType: 'json',
						success: function (result) {
							Swal.close();
							if (result.success) {
								Swal.fire('Sukses', thisClass.insertHandler.placeholder, 'success');
								$('#form').trigger("reset");
								thisClass.table.ajax.reload();
								thisClass.insertHandler.afterAction(result);
							} else {
								Swal.fire('Error', result.message, 'error');
							}
						},
						error: function () {
							Swal.close();
							Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
						}
					});
				}
			});
		}).on('reset', '#form', function () {
			$('#id').val('');
			$(".sel2").val(null).trigger('change');
			$('.is-valid').removeClass('is-valid');
			$('.is-invalid').removeClass('is-invalid');
			thisClass.resetHandler.action();
		});

		$(document).on('click', '.edit', function () {
			let $this = $(this);
			let data = { id: $this.data('id') }
			$.extend(data, thisClass.csrf);

			Swal.fire({
				title: "",
				icon: "info",
				text: "Proses mengambil data, mohon ditunggu...",
				didOpen: function () {
					Swal.showLoading()
				}
			});

			$.ajax({
				url: thisClass.url + "_edit",
				type: 'post',
				data: data,
				dataType: 'json',
				success: function (result) {
					Swal.close();
					if (result.success) {
						for (var keyy in result.data) {
							$('#' + keyy).val(result.data[keyy]);
						}

						// console.log($('ul#tab li a').last());

						// $('ul#tab li a').first().trigger('click');
						$('ul#tab li a').last().trigger('click');

						thisClass.editHandler.afterAction(result);
					} else {
						Swal.fire('Error', result.message, 'error');
					}
				},
				error: function () {
					Swal.close();
					Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
				}
			});
		}).on('click', '.sync', function () {
			let $this = $(this);
			let data = { id: $this.data('id') }
			$.extend(data, thisClass.csrf);

			Swal.fire({
				title: "",
				icon: "info",
				text: "Proses mengambil data, mohon ditunggu...",
				didOpen: function () {
					Swal.showLoading()
				}
			});

			$.ajax({
				url: thisClass.url + "_sync",
				type: 'post',
				data: data,
				dataType: 'json',
				success: function (result) {
					Swal.close();
					if (result.success) {
						for (var keyy in result.data) {
							$('#' + keyy).val(result.data[keyy]);
						}

						// console.log($('ul#tab li a').last());

						// $('ul#tab li a').first().trigger('click');
						// $('ul#tab li a').last().trigger('click');

						thisClass.table.ajax.reload();

						thisClass.editHandler.afterAction(result);
					} else {
						Swal.fire('Error', result.message, 'error');
					}
				},
				error: function () {
					Swal.close();
					Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
				}
			});
		}).on('click', '.delete', function () {
			let $this = $(this);
			let data = { id: $this.data('id') }
			$.extend(data, thisClass.csrf);

			Swal.fire({
				title: "Hapus data ?",
				icon: "warning",
				showCancelButton: true,
				confirmButtonText: "Hapus",
				confirmButtonColor: '#d33',
				cancelButtonText: "Batal",
				reverseButtons: true
			}).then(function (result) {
				if (result.value) {
					$.ajax({
						url: thisClass.url + "_delete",
						type: 'post',
						data: data,
						dataType: 'json',
						success: function (result) {
							Swal.close();
							if (result.success) {
								Swal.fire('Sukses', thisClass.deleteHandler.placeholder, 'success');
								thisClass.table.ajax.reload();
								thisClass.deleteHandler.afterAction();
							} else {
								Swal.fire('Error', result.message, 'error');
							}
						},
						error: function () {
							Swal.close();
							Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
						}
					});
				}
			})
		});

		// detail modal
		$(document).on('click', '.detail', function () {
			let $this = $(this);
			let data = { id: $this.data('id') }
			$.extend(data, thisClass.csrf);

			Swal.fire({
				title: "",
				icon: "info",
				text: "Proses mengambil data, mohon ditunggu...",
				didOpen: function () {
					Swal.showLoading()
				}
			});

			$.ajax({
				url: thisClass.url + "_detail",
				type: 'POST',
				data: data,
				dataType: 'json',
				success: function (result) {
					Swal.close();
					if (result.success) {
						$('#' + result.atr.modal_body).html(result.data)
						$('#' + result.atr.modal).modal('toggle');
					}
				},
				error: function () {
					Swal.close();
					Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
				}
			});
		}).on('click', '.show-detail', function () {
			let $this = $(this);
			let data = { id: $this.data('id') }
			$.extend(data, thisClass.csrf);

			Swal.fire({
				title: "",
				icon: "info",
				text: "Proses mengambil data, mohon ditunggu...",
				didOpen: function () {
					Swal.showLoading()
				}
			});

			$.ajax({
				url: thisClass.url + "_show",
				type: 'POST',
				data: data,
				dataType: 'json',
				success: function (result) {
					Swal.close();
					if (result.success) {
						$('#' + result.atr.modal_body).html(result.data)
						$('#' + result.atr.modal).modal('toggle');
					}
				},
				error: function () {
					Swal.close();
					Swal.fire('Error', 'Terjadi kesalahan pada server', 'error');
				}
			});
		})
	}

	loadDatatable(element, url, tableColumn, order = null) {
		var thisClass = this;

		var table = $('#' + element).DataTable({
			"autoWidth": false,
			"serverSide": true,
			"processing": true,
			"ordering": true,
			"order": order == null ? [[0, 'asc']] : order,
			"paging": true,
			"searching": { "regex": true },
			"lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
			"pageLength": 10,
			"searchDelay": 500,
			"ajax": {
				"type": "POST",
				"url": url,
				"dataType": "json",
				"data": function (data) {
					// console.log(thisClass);
					// Grab form values containing user options
					dataStart = data.start;
					let form = {};
					Object.keys(data).forEach(function (key) {
						form[key] = data[key] || "";
					});

					// Add options used by Datatables
					let info = {
						"start": data.start || 0,
						"length": data.length,
						"draw": 1
					};

					$.extend(form, info);
					$.extend(form, thisClass.csrf);

					return form;
				},
				"complete": function (response) {
					// console.log(response);
					feather.replace();
				}
			},
			"columns": tableColumn
		}).on('init.dt', function () {
			$(this).css('width', '100%');
		});
		return table;
	}

	select2Init(id, url, placeholder, parameter) {
		var thisClass = this;

		$(id).select2({
			id: function (e) { return e.id },
			placeholder: '',
			multiple: false,
			ajax: {
				url: thisClass.ajax + url,
				dataType: 'json',
				quietMillis: 500,
				delay: 500,
				data: function (param) {
					var def_param = {
						keyword: param.term, //search term
						perpage: 5, // page size
						page: param.page || 0, // page number
					};

					return Object.assign({}, def_param, parameter);
				},
				processResults: function (data, params) {
					params.page = params.page || 0

					return {
						results: data.rows,
						pagination: {
							more: false
						}
					}
				}
			},
			templateResult: function (data) { return data.text; },
			templateSelection: function (data) {
				if (data.id === '') {
					return placeholder;
				}

				return data.text;
			},
			escapeMarkup: function (m) {
				return m;
			}
		});
	}

	datepicker(element, fdata = 'dd/mm/yyyy', forientation = 'bottom') {
		$(element).datepicker({
			format: fdata,
			orientation: forientation
		}).on('changeDate', function () {
			$(this).datepicker('hide');
		});
	}

	datetimepickerDate(element) {
		$(function () {
			$(element).datetimepicker({
				icons: {
					time: "fa fa-clock-o",
					date: "fa fa-calendar",
					up: "fa fa-chevron-up",
					down: "fa fa-chevron-down",
					previous: 'fa fa-chevron-left',
					next: 'fa fa-chevron-right',
					today: 'fa fa-screenshot',
					clear: 'fa fa-trash',
					close: 'fa fa-remove'
				},
				// inline: true,
				sideBySide: true,
				format: 'YYYY-MM-DD',
				useCurrent: false
			}).datetimepicker('hide');
		})
	}
}