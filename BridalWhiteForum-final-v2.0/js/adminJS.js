$(document).ready(function(){
    $('.addCategory').on('click', function(){
        $(this).hide();
        $('.addCategoryForm').html("<input type='text' name='addCategoryField' class='addCategoryField' />");
    });
    $('#addCategoryForm').on('submit', function(event){
        $('.addCategoryField').hide();
        event.preventDefault();
        $.ajax({
            url: 'addCategory.php',
            type: 'GET',
            data: {
                categoryName: $('.addCategoryField').val()
            }
        });
        setTimeout(function(){
            $.ajax({
                url: 'questionsAndCategories.php',
                type: 'GET',
                data: {
                    categoriesPlease: 'categoriesPlease'
                },
                success: function(result){
                    $('.catList').html(result);
                }
            });
        }, 50);
    });
});