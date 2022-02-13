$( document ).ready(function() {
    $( "#approve" ).click(function() {
        $('.modal-title').html('');
        $('.modal-title').html('Are you sure to give admin rights?')
        $("#action_u").val('approve');
    });
    $( "#notApprove" ).click(function() {
        $('.modal-title').html('');
        $('.modal-title').html('Are you sure to remove admin rights?')
        $("#action_u").val('notApprove');
    });
    $('#editUserModal').on("show.bs.modal", function (e) {

        $('#user_id').val($(e.relatedTarget).data('user_id'))
        console.log($('#user_id').val());
        $('#email').val($(e.relatedTarget).data('user_email'))

    });
});
