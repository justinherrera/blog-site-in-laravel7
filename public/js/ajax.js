
let post_id = 0;
let status = "";
$(document).on('click', '.delete', function () { 
    
    post_id = $(this).parents('.site-section').attr('id').substr(5)
    // confirm("Are You sure want to delete !");
    $.ajax({
        method: "POST",
        url: "/post/"+post_id,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: {
            _method: "DELETE"
        },
        success: function (data) {
            $('.post-section').remove();
            window.location.href = window.location.origin+"/post"
        },
        error: function (data) {
            console.log('Error:', data);
        }
    });
});
// for like and unlike
$('.like').on('click', function(e){
    e.preventDefault();
    let _this = this
    let post_id = $(this).attr('id')
    let user_id = $('.user_id').attr('id')
    let countLike = $(_this).find('#countLike').text()
    let totalCountLike = Number(countLike.slice(1,countLike.length-1))
    let countDislike = $('#post-'+post_id).find('#countDislike').text()
    let totalcountDislike = Number(countDislike.slice(1,countDislike.length-1))
    let status = ""
    let data = {}
    console.log(post_id)
    if($(this).find('#checkLike').text() == "  Like"){
        if($('#post-'+post_id).find('#checkDislike').text() ==   "  Disliked"){
            if(totalcountDislike != 0) totalcountDislike -= 1
            $('#post-'+post_id).find('#countDislike').text('('+totalcountDislike+')')
            $('#post-'+post_id).find('#checkDislike').text('  Dislike')
            $.ajax({
                method: 'GET',
                url : '/undislike/'+post_id,
            }).done(function(){})
        }
        totalCountLike += 1
        $(_this).find('#checkLike').text('  Liked') 
        $(_this).find('#countLike').text('('+totalCountLike+')')
        console.log('true')
        data = {
            post_id: post_id,
            user_id: user_id,
        }
        $.ajax({
            method: 'GET',
            url : '/like/'+post_id,
            data : data
        }).done(function(){})
        var header = {}
    }
    else{
        if(totalCountLike != 0) totalCountLike -= 1
        $(_this).find('#checkLike').text('  Like') 
        $(_this).find('#countLike').text('('+totalCountLike+')')
        $.ajax({
            method: 'GET',
            url : '/unlike/'+post_id,
        }).done(function(){})
    }
})

$('.dislike').on('click', function(e){
    e.preventDefault();
    let _this = this
    let post_id = $(this).attr('id')
    let user_id = $('.user_id').attr('id')
    let countDislike = $(_this).find('#countDislike').text()
    let totalcountDislike = Number(countDislike.slice(1,countDislike.length-1))
    let countLike = $('#post-'+post_id).find('#checkLike').find('#countLike').text()
    let totalCountLike = Number(countLike.slice(1,countLike.length-1))
    let status = ""
    let data = {}
    console.log(post_id)
    if($(this).find('#checkDislike').text() == "  Dislike"){
        if($('#post-'+post_id).find('#checkLike').text() == "  Liked"){
            $('#post-'+post_id).find('#countLike').text('('+totalCountLike+')')
            $('#post-'+post_id).find('#checkLike').text('  Like') 
            $.ajax({
                method: 'GET',
                url : '/unlike/'+post_id,
            }).done(function(){})
        }
        $(_this).find('#checkDislike').text('  Disliked') 
        totalcountDislike += 1
        $(_this).find('#countDislike').text('('+totalcountDislike+')')
        console.log('true')
        status = 'Disliked'
        data = {
            post_id: post_id,
            user_id: user_id,
        }
        $.ajax({
            method: 'GET',
            url : '/dislike/'+post_id,
            data : data
        })
        var header = {}
    }
    else{
        if(totalcountDislike != 0) totalcountDislike -= 1
        $(_this).find('#checkDislike').text('  Dislike') 
        $(_this).find('#countDislike').text('('+totalcountDislike+')')
        status = 'Dislike'
        $.ajax({
            method: 'GET',
            url : '/undislike/'+post_id,
        }).done(function(){})
    }
})
//open post modal
$('.openModal').on('click',function(e){
    $('#createPost').modal('show');

})

//open edit modal
$('.editModal').on('click',function(e){
    $('#editPost').modal('show');

})
// post
let latest_id = 0;
$('#createPost').on('submit', '#addPost', function(e){
    e.preventDefault();
    let form = $('#addPost')[0]; 
    let formData = new FormData(form);
    let _this = this;
    let title = $('.title').val()
    let category = $('.category-select option:selected').text()
    $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
    $.ajax({
        type: "POST",
        url: "/post",
        cache: false,
        processData: false,
        contentType: false,
        data: formData,
        beforeSend: function(){
            $('.save').text('Posting...');
        },
        success: function(response){
            latest_id = response.last_insert_id
            if(response.image === null){
                response.image = "default_post_resized.jpg"
            }
            var new_post =  `
            <div class="col-md-6">
                <a href="/post/`+latest_id+`" class="blog-entry element-animate fadeIn element-animated" data-animate-effect="fadeIn">
                <img src="/storage/images/resized/post/`+response.image+`" alt="Image placeholder"> 
                                <div class="blog-content-body">
                    <div class="post-meta">
                    <span class="category">`+category+`</span>
                    <span class="mr-2">seconds ago</span>
                    <span class="ml-2"><span class="fa fa-comments" aria-hidden="true"></span> 0</span>
                    </div>
                    <h2>`+title+`</h2>
                    <small>Posted by: `+$('.bio-body').find('h2').text()+`</small>
                </div>
                </a>
            </div>`;
            console.log(new_post)
            $('.postSection').prepend(new_post);
            $('#createPost').modal('hide');
            $('.modal-backdrop').remove();
            $('input').val('') // empty title area
            $('.category-select').val('Choose Category').change()
            // $('textarea').val('')
            $('.save').text('Posted');
            var tinymce_editor_id = 'body'; 
            tinymce.get(tinymce_editor_id).setContent('');
            if($('.save').text() == "Posted"){
                $('.save').text('Post')
            }
        },
        error: function(error){
            console.log(error.responseJSON)
            $('.save').text('Post');
            $('.title-error').text(error.responseJSON.errors.title)
            $('.body-error').text(error.responseJSON.errors.body)
            $('.category-error').text(error.responseJSON.errors.category)
            $('.image-error').text(error.responseJSON.errors.image)
        }
    })
  });

  // update post
  $('#editPost').on('submit', '#updatePost', function(e){
        e.preventDefault();
        let post_id = $('#updatePost').attr('class');
        let body = tinymce.get('exampleFormControlTextarea1').getContent();
        let form = $('#updatePost')[0]; 
        let formData = new FormData(form);
        // formData.append('_method', 'patch');
        //formData.append('_method', 'PATCH');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/post/"+post_id,
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            cache: false,
            dataType: 'json',
            success: function(response){
                console.log(response)
                $("#editPost").modal("hide");
                $('.title').text(response.title)
                $('.body').eq(0).html(body)
                $('.post-image').attr('src','/storage/images/resized/show_post/'+response.image)
                $('.category').eq(0).text(response.category)
                $('.modal-backdrop').remove();
                //window.location.reload();
            },
            error: function(error){
                console.log(error)
                $('.title-error').text(error.responseJSON.errors.title)
                $('.body-error').text(error.responseJSON.errors.body)
                $('.category-error').text(error.responseJSON.errors.category)
                $('.image-error').text(error.responseJSON.errors.image)
            }
        })
  })

// comment
$(document).on('submit', '#addComment', function(e){
    e.preventDefault();
    let commentBody = $('.body').val()
    let commentName = $('.user_name').attr('id');
    let totalComment = $('#totalComment').text();
    let totalComments = $('.totalComments').text();
    let avatar = $('.avatar').attr('src')
    console.log(commentName)
    console.log(commentBody)
    $.ajax({
        type: "POST",
        url: "/comments",
        data: $("#addComment").serialize(),
        success: function(response){
            console.log(avatar)
            var commentText =  `<li class="comment">
            <div class="vcard">
            <img src=/storage/images/resized/user/`+response.avatar+` alt="Image placeholder">
            </div>
            <div class="comment-body">
            <h3>`+commentName+`</h3>
            <div class="meta">`+new Date().toDateString()+`</div>
              <p>`+commentBody+`</p>
            </div>
            </li>`;
            $('.comment-list').append(commentText);
            $('.body').val('');
            let result = Number(totalComment) + 1
            $('#totalComment').text(result)
            $('.totalComments').text(result);
        },
        error: function(error){
            console.log(error)
        }
    })
  });

