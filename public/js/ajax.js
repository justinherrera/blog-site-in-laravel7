
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



$('.like').on('click',function(event){
    let dislike = $('.dislike').first().text()
    if( dislike == "Disliked"){
        dislike = $('.dislike').first().text("Dislike")
        $(this).text('Liked')
    }else{
        if($(this).text() == "Like"){
            $(this).text('Liked')
        }else{
            $(this).text('Like')
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