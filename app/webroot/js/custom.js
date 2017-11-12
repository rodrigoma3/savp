$(document).ready(function() {
    //jQuery UI sortable for the todo list
    if ($(".todo-list").length) {
        $(".todo-list").sortable({
            placeholder: "sort-highlight",
            handle: ".handle",
            forcePlaceholderSize: true,
            zIndex: 999999
        }).disableSelection();;

        /* The todo list plugin */
        $(".todo-list").todolist({
            onCheck: function(ele) {
                //console.log("The element has been checked")
            },
            onUncheck: function(ele) {
                //console.log("The element has been unchecked")
            }
        });
    }

    $('div.form-group.required').each(function(index) {
        $(this).children('label').append('<small class="is-required">&nbsp;*</small>');
    });

    if ($('.dataTables').length) {
        var table = $('.dataTables').DataTable();
    }

    if ($('#DiaryDate').length) {
        // $('#DiaryDate').daterangepicker({
        //     locale: {
        //         format: 'YYYY-MM-DD'
        //     },
        //     singleDatePicker: true
        // });
        $('#DiaryDate').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: moment.locale(lang),
        });
    }

    // if ($('#DiaryRangeDate').length) {
    //     // $('#DiaryRangeDate').daterangepicker({
    //     //     locale: {
    //     //         format: 'YYYY-MM-DD'
    //     //     }
    //     // });
    //     $('#DiaryRangeDate').datetimepicker();
    // }

    if ($('#DiaryStartDate').length && $('#DiaryEndDate').length) {
        $('#DiaryStartDate').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: moment.locale(lang),
        });
        $('#DiaryEndDate').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD',
            locale: moment.locale(lang),
        });
        $("#DiaryStartDate").on("dp.change", function (e) {
            $('#DiaryEndDate').data("DateTimePicker").minDate(e.date);
        });
        $("#DiaryEndDate").on("dp.change", function (e) {
            $('#DiaryStartDate').data("DateTimePicker").maxDate(e.date);
        });
    }
    if($('#CarYear').length) {
        $('#CarYear').datetimepicker({
            format: 'YYYY',
            locale: moment.locale(lang),
        });
    }

    if ($('#StopStartTime').length) {
        $('#StopStartTime').datetimepicker({
            format: 'HH:mm',
            locale: moment.locale(lang),
        });
    }

    if ($('#StopEndTime').length) {
        $('#StopEndTime').datetimepicker({
            format: 'HH:mm',
            locale: moment.locale(lang),
        });
    }

    if ($('#DestinationTime').length) {
        $('#DestinationTime').datetimepicker({
            format: 'HH:mm',
            locale: moment.locale(lang),
        });
    }

    if ($('#calendarDiaryView').length) {
        var calendarDiaryViewAjax;
        $('#calendarDiaryView').fullCalendar({
            dayClick: function(date, jsEvent, view, resourceObj) {
                dayClicked(date.format());
            },
            events: function(start, end, timezone, callback) {
                $.ajax({
                    url: $(location).attr('href'),
                    type: 'POST',
                    cache: false,
                    data: {"act": 'dates'},
                    success: function( data ) {
                        // console.log(data);
                        var events = [];
                        try {
                            var obj = jQuery.parseJSON(data);
                            if (obj.error == 0) {
                                $.each(obj.data, function(i,v) {
                                    events.push({
                                        title: v.title,
                                        start: v.date,
                                        end: v.date,
                                        allDay: true,
                                        editable: false,
                                        color: v.color,
                                        textColor: 'white'
                                    });
                                });
                            }
                        } catch (e) {
                        }
                        callback(events);
                    }
                });
            },
            eventClick: function(calEvent, jsEvent, view) {
                dayClicked(calEvent.start.format());
            }
        });
        dayClicked(moment().format().slice(0,10));
        function dayClicked(date) {
            $('#eventDiaryView .box-body div.ajax-loading').remove();
            $('#eventDiaryView .box-body div.ajax-error').remove();
            $('#eventDiaryView .box-header .box-title').html(date);
            $('#eventDiaryView .box-body .callout').each(function() {
                $(this).remove();
            });
            if(calendarDiaryViewAjax && calendarDiaryViewAjax.readyState != 4){
                calendarDiaryViewAjax.abort();
            }
            calendarDiaryViewAjax = $.ajax({
                url: $(location).attr('href'),
                type: 'POST',
                cache: false,
                data: {"date": date},
                beforeSend: function() {
                    $('#eventDiaryView .box-body p').hide();
                    $('#eventDiaryView .box-body').append(ajaxLoadingCenter);
                },
                success: function( data ) {
                    // console.log(data);
                    var obj = jQuery.parseJSON(data);
                    if (obj.error == 0) {
                        if (obj.data.length > 0) {
                            $.each(obj.data, function(i,v) {
                                var e = '<div class="callout callout-' + v.color + '"><h4>' + v.destination + ' - ' + v.car + '</h4>' + v.title_free + ': ' + v.free;
                                $.each(v.buttons, function(ii,b) {
                                    e += b;
                                });
                                e += '</div>';
                                $('#eventDiaryView .box-body').append(e);
                            });
                        } else {
                            $('#eventDiaryView .box-body p').show();
                        }
                    } else {
                        $('#eventDiaryView .box-body').append(ajaxErrorCenter);
                    }
                },
                error: function(){
                    $('#eventDiaryView .box-body').append(ajaxErrorCenter);
                }
            })
            .always(function() {
                $('#eventDiaryView .box-body div.ajax-loading').remove();
            });
        }
    }
    var establishmentSequenceCityId;
    if ($('#EstablishmentBtnSearch').length) {
        var establishmentSequenceCityAjax;
        function updateListSequenceEstablishment() {
            $('.todo-list li').each(function() {
                $(this).remove();
            });
            establishmentSequenceCityId = $('#EstablishmentCityId').val();
            if(establishmentSequenceCityAjax && establishmentSequenceCityAjax.readyState != 4){
                establishmentSequenceCityAjax.abort();
            }
            establishmentSequenceCityAjax = $.ajax({
                url: $(location).attr('href'),
                type: 'GET',
                data: {"city_id": establishmentSequenceCityId},
                beforeSend: function() {
                    $('.todo-list').append(ajaxLoadingCenter);
                    $('.todo-list div.ajax-error').remove();
                },
                success: function( data ) {
                    // console.log(data);
                    var obj = jQuery.parseJSON(data);
                    if (obj.error == 0) {
                        if (obj.data.length > 0) {
                            $('.todo-list p').hide();
                            $.each(obj.data, function(i,v) {
                                var e = $('.item-list-model').clone();
                                e.children('.text').html(v.text);
                                e.attr('data-establishment', v.id);
                                e.removeClass('item-list-model hide');
                                $('.todo-list').append(e);
                            });
                        } else {
                            $('.todo-list p').show();
                        }
                    } else {
                        $('.todo-list').append(ajaxErrorCenter);
                    }
                },
                error: function(){
                    $('.todo-list').append(ajaxErrorCenter);
                }
            })
            .always(function() {
                $('.todo-list div.ajax-loading').remove();
            });
        }

        $('#EstablishmentBtnSearch').on('click', function() {
            updateListSequenceEstablishment();
        });
    }
    if ($('#EstablishmentSequenceForm').length) {
        $(document).on('submit', '#EstablishmentSequenceForm', function() {
            var sequence = [];
            $('.todo-list li').each(function() {
                sequence.push($(this).attr('data-establishment'));
            });
            $('#EstablishmentSequence').val(sequence);
            $('#EstablishmentCityId').val(establishmentSequenceCityId);
        });
    }
    if ($('#StopIndexForm').length) {
        $(document).on('submit', '#StopIndexForm', function() {
            var sequence = [];
            $('.todo-list li').each(function() {
                sequence.push($(this).attr('data-stop'));
                var companionStopId = $(this).attr('data-stop-companion');
                if (companionStopId != '') {
                    sequence.push(companionStopId);
                }
            });
            $('#StopSequence').val(sequence);
        });
    }
    if ($('#DiaryBtnAdd').length) {
        $('#DiaryBtnAdd').on('click', function() {
            var d = $('#eventDiaryView .box-header .box-title').html();
            if (d != '') {
                $(this).attr('href', $(this).attr('href') + '/date:' + d);
            }
        });
    }
    if ($('#DiaryBtnCloseDiary').length) {
        $('#DiaryBtnCloseDiary').on('click', function() {
            if (confirm($('#DiaryBtnCloseDiary').attr('data-confirm'))) {
                $('#DiaryStatus').val('close');
                $('#StopCloseForm').submit();
            }
        });
    }

    $('[data-mask]').inputmask();
});

var ajaxLoadingCenter = '<div class="ajax-loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>';
var ajaxErrorCenter = '<div class="ajax-error"><i class="fa fa-exclamation-triangle fa-3x" aria-hidden="true"></i></div>';
