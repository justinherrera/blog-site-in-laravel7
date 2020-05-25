
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
// let checkLike = document.querySelectorAll('#checkLike');
// for(let i = 0; i <checkLike.length; i++){
//     if(checkLike[i].textContent == "Like"){
//         $('.like-icon').addClass('far fa-thumbs-up');
//     }else{
//         console.log(checkLike[i].textContent)
//        $('.like-icon').addClass('fas fa-thumbs-up');
//     }
// }
$('.like').on('click',function(event){
    event.preventDefault();
    let post_id = $(this).attr('id')
    let user_id = $('.user_id').attr('id')
    let islike = $(this).val()
    let type = "";
    let likeCount = 0
    let str =  $(this).find('#countLike').text()
    let len =  $(this).find('#countLike').text().length-1
    likeCount = str.slice(1,len)
    if($(this).find('#checkLike').text() == "Like"){
        $(this).prev().val('1')
        islike = 1; // will be stored as true if post is not like yet
        let totalCount = Number(likeCount) + 1 // increment the total likes
        $(this).find('#countLike').text('(' + totalCount + ')') // next task, like unlike doesnt work, 
        $(this).find('#checkLike').text('Liked')
        type = "GET"; // store like
    }else{
        $(this).prev().val('0')
        islike = 0
        let totalCount = Number(likeCount) - 1
        $(this).find('#countLike').text('(' + totalCount + ')')
        $(this).find('#checkLike').text('Like')
        type = "PUT"; // update like
    }
    console.log(post_id)
    $.ajax({
        type: type,
        url: '/like/'+post_id,
        data: {
            post_id: post_id,
            user_id: user_id,
            islike: islike
        },
        success: function(data){
            
        },
      });    
})

$('.dislike').on('click',function(event){
    let like = $('.like').first().text()
    if( like == "Liked"){
        like = $('.like').first().text("Like")
        $(this).text('Disliked')
    }else{
        if($(this).text() == "Dislike"){
            $(this).text('Disliked')
        }else{
            $(this).text('Dislike')
        }
        
    }
    console.log(event)
    // event.preventDefault()
    // post_id = $(this).parents('.post-section').attr('id').substr(5)
    // let isLike = $(this).prev()
    // console.log(isLike)
    // $(this).text('Liked')
    // $.ajax({
    //     method: 'POST',
    //     url : urlLike,
    //     data : {
    //         isLike: isLike,
    //         postId: postId,
    //         _token: token
    //     }
    // }).done(function(){
    //     $(this).text('Liked')
    // })
})