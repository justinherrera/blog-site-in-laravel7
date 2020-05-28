
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
    let status = ""
    let data = {}
    console.log(post_id)
    if($(this).find('#checkLike').text() == "Like"){
        totalCountLike += 1
        $(_this).find('#countLike').text('('+totalCountLike+')')
        console.log('true')
        status = 'Liked'
        data = {
            isLike: 1,
            post_id: post_id,
            user_id: user_id,
        }
        $.ajax({
            method: 'GET',
            url : '/like/'+post_id,
            data : data
        }).done(function(){
            $(_this).find('#checkLike').text(status) 
        })
        var header = {}
    }
    else{
        totalCountLike -= 1
        $(_this).find('#countLike').text('('+totalCountLike+')')
        status = 'Like'
        $.ajax({
            method: 'GET',
            url : '/unlike/'+post_id,
        }).done(function(){
            $(_this).find('#checkLike').text(status) 
        })
    }
})

$('.dislike').on('click', function(e){
    e.preventDefault();
    let _this = this
    let post_id = $(this).attr('id')
    let user_id = $('.user_id').attr('id')
    let countDislike = $(_this).find('#countDislike').text()
    let totalcountDislike = Number(countDislike.slice(1,countDislike.length-1))
    let status = ""
    let data = {}
    console.log(post_id)
    if($(this).find('#checkDislike').text() == "Dislike"){
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
        }).done(function(){
            $(_this).find('#checkDislike').text(status) 
        })
        var header = {}
    }
    else{
        totalcountDislike -= 1
        $(_this).find('#countDislike').text('('+totalcountDislike+')')
        status = 'Dislike'
        $.ajax({
            method: 'GET',
            url : '/undislike/'+post_id,
        }).done(function(){
            $(_this).find('#checkDislike').text(status) 
        })
    }
})

// comment
$(document).on('submit', '#addComment', function(e){
    e.preventDefault();
    let commentBody = $('.body').val()
    let commentName = $('.user_name').attr('id');
    console.log(commentName)
    console.log(commentBody)
    $.ajax({
        type: "POST",
        url: "/comments",
        data: $("#addComment").serialize(),
        success: function(response){
            var commentText =  `<div class="media mb-4">
            <img class="d-flex mr-3 rounded-circle" src="http://placehold.it/50x50" alt="">
            <div class="media-body">
              <h5 class="mt-0">`+commentName+`</h5>
              `+commentBody+`
            </div>
          </div>`;
            $('.comment-section').append(commentText);
            
        },
        error: function(error){
            console.log(error)
        }
    })
  });