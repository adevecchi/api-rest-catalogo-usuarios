var App = (function(){

	var $main,
		$modal,
		$table,
		pathname,
		id;

	var page = {

		index: function(){
			
			$main = $('#main');
			$modal = $('#modal-delete');

			$table = $main.find('#table-list').DataTable({
				pageLength: 5,
				lengthChange: false,
				searching: false,
				ordering: false,
				serverSide: true,
				processing: true,
				ajax: {
					url: '/api/users/list/',
					type: 'POST'
				},
				columns: [
					{ data: 'id' },
					{ data: 'name' },
					{ data: 'username' },
					{ data: 'email' },
					{ data: 'phone' },
					{ data: 'website' },
					{ data: 'actions' },
				]
			});

			$main
				.on('click', '.btn-edit', function(evt){
					evt.preventDefault();
					evt.stopPropagation();

					location.href = 'edit/user/' + $(this).data('id');
				})
				.on('click', '.btn-delete', function(evt){
					evt.preventDefault();
					evt.stopPropagation();

					$modal
						.modal('show')
						.data('id', $(this).data('id'));
				})
				.on('click', '.btn-details', function(evt){
					evt.preventDefault();
					evt.stopPropagation();
					
					location.href = 'details/user/' + $(this).data('id');
				});

			$modal.
				on('click', '.btn-yes', function(){
					$.ajax({
						type: 'DELETE',
						contentType: 'application/json',
						url: '/api/users/' + $modal.data('id'),
						dataType: 'json',
						success: function(result) {
							$modal.modal('hide');
							$table.draw();
						},
						error: function(xhr, resp, text) {
							console.log(text);
						}
					});
				});
		},
		add: function(){

			$main = $('#main');

			$main
				.on('click', '.btn-save', function(){
					$.ajax({
						type: 'POST',
						contentType: 'application/json',
						url: '/api/users/',
						dataType: 'json',
						data: JSON.stringify(formToJson($main.find('#frm-user').serializeArray())),
						success: function(result) {
							location.href = '/';
						},
						error: function(xhr, resp, text) {
							console.log(text);
						}
					});
				});
		},
		edit: function(){

			pathname = location.pathname.split('/');
			id = parseInt(pathname[pathname.length - 1]);
			$main = $('#main');

			$.ajax({
				type: 'GET',
				contentType: 'application/json',
				url: '/api/users/' + id,
				dataType: 'json',
				success: function(result) {
					result = result[0];

					$main.find('#name').val(result.name);
					$main.find('#username').val(result.username);
					$main.find('#email').val(result.email);
					$main.find('#addr_street').val(result.address.street);
					$main.find('#addr_suite').val(result.address.suite);
					$main.find('#addr_city').val(result.address.city);
					$main.find('#addr_zipcode').val(result.address.zipcode);
					$main.find('#addr_geo_lat').val(result.address.geo.lat);
					$main.find('#addr_geo_lng').val(result.address.geo.lng);
					$main.find('#phone').val(result.phone);
					$main.find('#website').val(result.website);
					$main.find('#co_name').val(result.company.name);
					$main.find('#co_catchPhrase').val(result.company.catchPhrase);
					$main.find('#co_bs').val(result.company.bs);
				},
				error: function(xhr, resp, text) {
					console.log(text);
				}
			});

			$main
				.on('click', '.btn-save', function(){
					$.ajax({
						type: 'PUT',
						contentType: 'application/json',
						url: '/api/users/' + id,
						dataType: 'json',
						data: JSON.stringify(formToJson($main.find('#frm-user').serializeArray())),
						success: function(result) {
							location.href = '/';
						},
						error: function(xhr, resp, text) {
							console.log(text);
						}
					});
				});
		},
		details: function(){

			pathname = location.pathname.split('/');
			id = parseInt(pathname[pathname.length - 1]);
			$main = $('#main');

			$.ajax({
				type: 'GET',
				contentType: 'application/json',
				url: '/api/users/' + id,
				dataType: 'json',
				success: function(result) {
					result = result[0];

					$main.find('#id').text(result.id);
					$main.find('#name').text(result.name);
					$main.find('#username').text(result.username);
					$main.find('#email').text(result.email);
					$main.find('#addr_street').text(result.address.street);
					$main.find('#addr_suite').text(result.address.suite);
					$main.find('#addr_city').text(result.address.city);
					$main.find('#addr_zipcode').text(result.address.zipcode);
					$main.find('#addr_geo_lat').text(result.address.geo.lat);
					$main.find('#addr_geo_lng').text(result.address.geo.lng);
					$main.find('#phone').text(result.phone);
					$main.find('#website').text(result.website);
					$main.find('#co_name').text(result.company.name);
					$main.find('#co_catchPhrase').text(result.company.catchPhrase);
					$main.find('#co_bs').text(result.company.bs);
				},
				error: function(xhr, resp, text) {
					console.log(text);
				}
			});

			$table = $main.find('#table-list').DataTable({
				pageLength: 5,
				lengthChange: false,
				searching: false,
				ordering: false,
				serverSide: true,
				processing: true,
				ajax: {
					url: '/api/users/list/' + id + '/posts/',
					type: 'POST'
				},
				columns: [
					{ data: 'id' },
					{ data: 'title' },
					{ data: 'body' },
				]
			});
		}
	};

	function formToJson(datas) {
		var json = {},
			objs = JSON.parse(JSON.stringify(datas));

		for (var i = 0; i < objs.length; i++) {
			for (var prop in objs[i]) {
				json[objs[i].name] = objs[i].value;
			}
		}

		return json;
	}

	return {
		page: page
	}

})();