function addFriend(origin_id, access_token)
{
	
	$('#origin_user').val(origin_id);
	$('#origin_user_token').val(access_token);
	$('#add_friend').overlay({

		mask: {
			color: '#000',
			loadSpeed: 200,
			opacity: 0.7
		},
		closeOnClick: false,
		load: true
	});
	
}

function deleteUser(uid, access_token)
{
	openLoading();
	$('#del_user').val(uid);
	$('#del_user_token').val(access_token);
	$('#delete_user_form').submit();
	
}

function openLoading()
{
	
	$("#loading").overlay({

		mask: {
			color: '#000',
			loadSpeed: 200,
			opacity: 0.7
		},
		closeOnClick: false,
		load: true
	});
	
}

function closeLoading()
{
	$("#loading").close();
}