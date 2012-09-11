function loadUserInfo(uid, token) {
    $.ajax({
        url: "ajax-userinfo",
        type: "POST",
        data: {
            uid: uid,
            token: token
        },
        success: function(response) {
            var r = $.parseJSON(response);
            $('#user_' + r.data.uid + '_loading').hide();
            $('#userInfoTpl').tmpl(r.data).appendTo('#user_' + r.data.uid)
        },
        error: function(response) {
          var r = $.parseJSON(response.responseText);
          $('#user_' + uid + '_loading').hide();
          $('#user_' + uid).html('Error: ' + r.message)
        }
    });
}

function loadUsersInfo(objects) {
    
    var package = [],
        batchAmount = 10;
    for (var i = 0, ci = objects.length; i < ci; ++i) {
    
        package.push(objects[i]);    
        
        if (
            (i % batchAmount == 0 && i > 0) ||
            ((i + 1) == ci)
        ) {
            
            (function(clousurePackage) {
                
                return function() {
                    
                    $.ajax({
                        url: "ajax-userinfo-batch",
                        type: "POST",
                        data: {
                            package: package
                        },
                        success: function (response) {
                            
                            var r = $.parseJSON(response);
                            
                            if (r.data) {
                                
                                for (var i = 0, ci = r.data.length; i < ci; ++i) {
                                    
                                    var single = r.data[i]; 
                                    $('#user_' + single.uid + '_loading').hide();
                                    $('#userInfoTpl').tmpl(single).appendTo('#user_' + single.uid);
                                    
                                }
                                
                            }
                            
                        },
                        error: function (response) {
                            
                            var r = $.parseJSON(response.responseText);
                          
                            for (var i = 0, ci = clousurePackage.length; i < ci; ++i) {
                                
                                var single = clousurePackage[i];
                                
                                if (!r) {
                                    
                                    r = {
                                        message: "Request to server failed"
                                    };
                                    
                                }
                                
                                $('#user_' + single.id + '_loading').hide();
                                $('#user_' + single.id).html('Error: ' + r.message );
                                
                            }
                          
                        }
                    
                    });
                    
                };
           
            })(package)();
        
            package = [];
            
        }// /if
        
    }// /for
    
}// /loadUsersInfo

function showToken(token)
 {
    $('#view_token_p').html(token);
    $("#view_token").data().overlay.load();

}

function addFriend(origin_id, access_token)
 {
    renderFriendList(origin_id, access_token);
    loadFriendDropDown(origin_id);
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

function loadFriendDropDown(user_id)
 {
    $('#target_user').empty();
    $('.user_list ul').children('li').each(function(index) {
        
        var id      = $(this).find('.id').first().html(),
            token   = $(this).find('.token').first().html(),
            name    = $('#user_' + id).find('.name').html();

        if (user_id != id) {
            $('#target_user').append('<option value="' + id + " " + token + '">' + name + '</option>');
        }

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
        success: function(response) {
            var r = $.parseJSON(response);
            openSuccess(r.message);
        },
        error: function(response) {
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
        data: {
            uid: uid,
            token: token
        },
        success: function(response) {
            var r = $.parseJSON(response);
            $('#friend-list').empty();

            $.each(r.data,
            function(index, value) {
                $('#friend-list').append('<li>' + value.name + '</li>');
            });

        }
    });
}

function overrideAddNewUser() {
    
    $('#menu a[href="new"]').click(function(e) {
        
        $('.listNewuser').removeClass('hidden');
        e.preventDefault();
        
    });
    
}

function noName() {
    $('#facebook_app_name').removeClass('loading');
}

function getAndReplaceAppName(appid) {
    
    $.ajax({
        url: "ajax-app-name",
        dataType: "json",
        type: "GET",
        success: function(r) {

            if (r.data.name) {
                
                var tit = $('title');
                tit.text(r.data.name + ' - ' + tit.text());
                $('#facebook_app_name')
                    .removeClass('loading')
                    .text(r.data.name)
                    .css('background-image','url(' + r.data.icon_url + ')')
                
            } else {
                noName();
            }
            
        },
        error: function(response) {
            noName();
        }
    });
    
}

function changeNamePress(e, uid, nameElem, loadingElem) {
    
    e           = e || window.event;
    e.target    = e.target || e.srcElement;
    
    if (e.keyCode == 13) {
        
        loadingElem.style.display = 'inline';
        
        $.ajax({
            data:{
                uid: uid,
                name: e.target.value
            },
            url: "ajax-change-name",
            dataType: "json",
            type: "POST",
            success: function(r) {
                
                nameElem.innerHTML = e.target.value;
                nameElem.style.display = 'inline';
                e.target.parentNode.removeChild(e.target);
                loadingElem.parentNode.removeChild(loadingElem);
                
            },
            error: function(response) {

                nameElem.style.display = 'inline';
                e.target.parentNode.removeChild(e.target);
                loadingElem.parentNode.removeChild(loadingElem);
                
            }
            
        });
        
    }
    
}

function changeName(uid) {
    
    var userDiv = document.getElementById('user_' + uid),
        name;
    
    for (var i in userDiv.childNodes) {
        
        if (userDiv.childNodes[i].className &&
            userDiv.childNodes[i].className.indexOf('name') > -1
        ) {
            name = userDiv.childNodes[i];
            break;
        }
        
    }
    
    if (!name) {
        return;
    }
    
    name.style.display = 'none';
    var input = document.createElement('input'),
        img   = document.createElement('img');
    
    img.src = 'images/loading-small.gif';
    img.alt = '';
    img.style.display = 'none';
    
    input.className     = 'change_name';
    input.onkeypress    = function(e) {
        changeNamePress(e, uid, name, img);
    }
    
    name.parentNode.insertBefore(input, name);
    name.parentNode.insertBefore(img, name);
    
    input.focus();
    input.value         = name.innerHTML;

    
}

function filterUsers(name) {
    
    $('.user_list ul li').each(function(i, el) {
        
        var el = $(el);
        if (el.find('.name').html().toLowerCase().indexOf(name.toLowerCase()) > -1) {
            el.show();
        } else {
            el.hide();
        }
        
    });
    
}





