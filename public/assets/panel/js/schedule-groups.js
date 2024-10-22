let isEdit = false;
let groupId = null;
function openGroupModal(isEdit, groupIndex = null, groupId = null, dataUrl = null) {
    const translations = JSON.parse($("button[data-translations]").attr("data-translations"));
    const selectSessionsElement = $('#select_sessions');


    selectSessionsElement.find('option').prop('disabled', false);
    $("#groupModalLabel").text(isEdit ? translations['edit'] : translations['add_group']);
    $("#group_title").val('');
    $("#price").val('');

    if (isEdit && groupId !== null) {

        const groupUrl = $("button[data-group-url]").attr("data-group-url");


        $("#saveGroupBtn").attr('data-url', dataUrl);
        $("#saveGroupBtn").attr('data-group', groupId);
        $("#saveGroupBtn").attr('data-method', 'PUT');

        $.ajax({
            url: groupUrl,
            method: 'POST',
            data: {
                groupId: groupId,
            },
            success: function (response) {

                const group = response.group;
                const groupSessions = response.sessions.map(session => session.id);

                $("#group_title").val(group.title);
                $("#price").val(group.price);

                const sessionsUrl = $("button[data-sessions]").attr("data-sessions");
                $.ajax({
                    url: sessionsUrl,
                    method: 'GET',
                    success: function (response) {
                        const usedSessions = response.used_sessions;
                        selectSessionsElement.find('option').each(function () {
                            const sessionId = parseInt($(this).val());
                            if (usedSessions.includes(sessionId) && !groupSessions.includes(sessionId)) {
                                $(this).prop('disabled', true);
                            } else {
                                $(this).prop('disabled', false);
                            }
                        });

                        selectSessionsElement.val(groupSessions).trigger('change');
                    },
                    error: function () {
                        console.error('Error fetching used sessions');
                    }
                });
            },
            error: function () {
                console.error('Error fetching group with sessions');
            }
        });
    } else {
        const sessionsUrl = $("button[data-sessions]").attr("data-sessions");
        $.ajax({
            url: sessionsUrl,
            method: 'GET',
            success: function (response) {
                const usedSessions = response.used_sessions;

                selectSessionsElement.find('option').each(function () {
                    const sessionId = parseInt($(this).val());
                    if (usedSessions.includes(sessionId)) {
                        $(this).prop('disabled', true);

                    } else {
                        $(this).prop('disabled', false);

                    }
                });
                selectSessionsElement.trigger('change');

                $("#saveGroupBtn").attr('data-url', $("button[onclick='openGroupModal(false)']").attr('data-url'));
                $("#saveGroupBtn").attr('data-method', 'POST');
            },
            error: function () {
                console.error('Error fetching used sessions');
            }
        });
    }

    $("#groupModal").modal('show');
}

$("#saveGroupBtn").click(function () {
    const translations = JSON.parse($("button[data-translations]").attr("data-translations"));

    const groupTitle = $("#group_title").val().trim();
    const price = $("#price").val().trim();
    const selectedSessions = $("#select_sessions").val();
    const url = $(this).attr('data-url');
    const method = $(this).attr('data-method');
    console.log(url);
    if (!price) {
        $("#priceError").show();
        return;
    } else {
        $("#priceError").hide();
    }
    if (!groupTitle) {
        $("#groupTitleError").show();
        return;
    } else {
        $("#groupTitleError").hide();
    }

    if (!selectedSessions || selectedSessions.length === 0) {
        $("#selectSessionsError").show();
        return;
    } else {
        $("#selectSessionsError").hide();
    }

    const data = {
        title: groupTitle,
        sessions: selectedSessions,
        price:price,
    };
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: url,
        method: method,
        data: data,
        success: function (response) {

            if (response.success) {
                customSweetAlert('success', translations['group_saved'], '');
                $("#groupModal").modal('hide');
                location.reload();

            } else {
                customSweetAlert('error', translations['error_saving_group'], '');

            }
        },
        error: function () {
            customSweetAlert('error', translations['error_saving_group'], '');
        }
    });
});

function removeGroup(groupId) {
    const translations = JSON.parse($("button[data-translations]").attr("data-translations"));

    const url = $("#remove_group_" + groupId).attr('data-url');
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    Swal.fire({
        title: translations['delete_group_confirmation'],
        text: translations['This action cannot be undone'],
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#D9214E',
        cancelButtonColor: '#E27626',
        confirmButtonText: translations['confirm_delete'],
        cancelButtonText: translations['cancel']
    }).then((result) => {
        console.log(result);
        if (result.value) {
            $.ajax({
                url: url,
                method: 'DELETE',
                success: function (response) {
                    console.log(response);
                    if (response.success) {
                        Swal.fire({
                            title:  translations['group_deleted'],
                            text:  translations['group_has_been_deleted'],
                            icon: 'success',
                            timer: 1500,
                            showConfirmButton: false
                        }).then(() => {
                            location.reload();
                        });
                    }
                },
                error: function () {
                    Swal.fire({
                        title: translations['error'],
                        text: translations['error_deleting_group'],
                        icon: 'error',
                        confirmButtonText: translations['ok']
                    });
                }
            });
        }
    });
}



$(document).ready(function () {
    $('#select_sessions').select2({
        dropdownParent: $('#groupModal')
    });
    $('.close, #closeModalBtn').on('click', function () {
        $('#groupModal').modal('hide');
    });

    $('#groupModal').on('hidden.bs.modal', function () {
        $('#group_title').val('');
        $('#price').val('');
        $('#select_sessions').val([]).trigger('change');
        $('#groupTitleError').hide();
        $('#priceError').hide();
        $('#selectSessionsError').hide();
    });
});

