function loadUserInfo(uid, token){
	$.ajax({ 
		url: "ajax-userinfo", 
		type: "POST",
		data: {uid: uid, token: token},
		success: function(response){
					var r = $.parseJSON(response);
					$('#user_'+r.data.uid+'_loading').hide();
					$('#userInfoTpl').tmpl(r.data).appendTo('#user_'+r.data.uid)
	      }});
}

function showToken(token)
{
	$('#view_token_p').html(token);
	$("#view_token").data().overlay.load();
	
}

function addFriend(origin_id, access_token)
{
	renderFriendList(origin_id, access_token);
	loadFriendDropDown();
	$('#origin_user').val(origin_id);
	$('#origin_user_token').val(access_token);
	$("#add_friend").data().overlay.load();
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
	$("#loading").data().overlay.load();
}

function closeLoading()
{
	$("#loading").data().overlay.close();
}

function openSuccess(msg)
{
		$('#success > .message').html(msg);
		$("#success").data().overlay.load();
}

function openError(msg)
{
		$('#error_modal > .message').html(msg);
		$("#error_modal").data().overlay.load();
}

function initListOverlays()
{
	$("#view_token").overlay({

		mask: {
			color: '#000',
			loadSpeed: 200,
			opacity: 0.7
		},
		closeOnClick: false,
	});
	
	$("#loading").overlay({

		mask: {
			color: '#000',
			loadSpeed: 200,
			opacity: 0.7
		},
		closeOnClick: false,
	});
	
	$("#success").overlay({

		mask: {
			color: '#000',
			loadSpeed: 200,
			opacity: 0.7
		},
	});
	
	$("#error_modal").overlay({

		mask: {
			color: '#000',
			loadSpeed: 200,
			opacity: 0.7
		},
	});
	
	$('#add_friend').overlay({

		mask: {
			color: '#000',
			loadSpeed: 200,
			opacity: 0.7
		},
		closeOnClick: false,
	});
	
}

function initTooltips()
{
	$(".cmds img[alt]").tooltip();
}

function loadFriendDropDown()
{
	$('#target_user').empty();
	$('.user_list ul').children('li').each(function(index) {
	    var id = $(this).find('.id').first().html();
		  var token = $(this).find('.token').first().html();
			var name = $('#user_'+id).find('.name').html();
			
			$('#target_user').append('<option value="'+id+" "+token+'">'+name+'</option>');
	  });
}

function submitAddFriend()
{	

	var data = {
							origin_user: $('#origin_user').val(), 
							origin_user_token: $('#origin_user_token').val(),
							target_user: $('#target_user').val()
						 }
	$("#add_friend").data().overlay.close();
	openLoading();
	
	$.ajax({ 
		url: "ajax-add-friend", 
		type: "POST",
		data: data,
		success: function(response){
					var r = $.parseJSON(response);
					openSuccess(r.message);
	      },
		error: function(response){
					var r = $.parseJSON(response.responseText);
					openError(r.message);
	      }
			});
	      
}

function renderFriendList(uid, token)
{
	$('#friend-list').empty();
	$('#friend-list').append('<li class="loading"><img src="images/loading-small.gif" alt=""></li>');
	
	$.ajax({ 
		url: "ajax-user-friends", 
		type: "POST",
		data: {uid: uid, token: token},
		success: function(response){
					var r = $.parseJSON(response);
					$('#friend-list').empty();
					
					$.each(r.data, function(index, value){
						$('#friend-list').append('<li>'+value.name+'</li>');
					});
						
		}});
}