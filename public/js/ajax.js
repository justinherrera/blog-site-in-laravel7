
let post_id = 0;
let status = "";
$(document).on('click', '.delete', function () { 
    
    post_id = $(this).parents('.post-section').attr('id').substr(5)
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
    if($(this).find('#checkLike').text() == "Like"){
        if($('#post-'+post_id).find('#checkDislike').text() == "Disliked"){
            totalcountDislike -= 1
            $('#post-'+post_id).find('#countDislike').text('('+totalcountDislike+')')
            $.ajax({
                method: 'GET',
                url : '/undislike/'+post_id,
            }).done(function(){
                $('#post-'+post_id).find('#checkDislike').text('Dislike')
            })
        }
        totalCountLike += 1
        $(_this).find('#checkLike').text('Liked') 
        $(_this).find('#countLike').text('('+totalCountLike+')')
        console.log('true')
        data = {
            isLike: 1,
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
        totalCountLike -= 1
        $(_this).find('#checkLike').text('Like') 
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
    if($(this).find('#checkDislike').text() == "Dislike"){
        if($('#post-'+post_id).find('#checkLike').text() == "Liked"){
            totalCountLike -= 1
            $('#post-'+post_id).find('#countLike').text('('+totalCountLike+')')
            $.ajax({
                method: 'GET',
                url : '/unlike/'+post_id,
            }).done(function(){
                $('#post-'+post_id).find('#checkLike').text('Like') 
            })
        }
        $(_this).find('#checkDislike').text('Disliked') 
        totalcountDislike += 1
        $(_this).find('#countDislike').text('('+totalcountDislike+')')
        console.log('true')
        status = 'Disliked'
        data = {
            isLike: 1,
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
        totalcountDislike -= 1
        $(_this).find('#checkDislike').text('Dislike') 
        $(_this).find('#countDislike').text('('+totalcountDislike+')')
        status = 'Dislike'
        $.ajax({
            method: 'GET',
            url : '/undislike/'+post_id,
        }).done(function(){})
    }
})

// comment
$(document).on('submit', '#addComment', function(e){
    e.preventDefault();
    let commentBody = $('.body').val()
    let commentName = $('.user_name').attr('id');
    let totalComment = $('#totalComment').text();
    console.log(commentName)
    console.log(commentBody)
    $.ajax({
        type: "POST",
        url: "/comments",
        data: $("#addComment").serialize(),
        success: function(response){
            var commentText =  `<li class="comment">
            <div class="vcard">
            <img src="images/person_1.jpg" alt="Image placeholder">
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
        },
        error: function(error){
            console.log(error)
        }
    })
  });