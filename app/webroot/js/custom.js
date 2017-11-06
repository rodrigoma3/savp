$(document).ready(function() {
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
                    $('#eventDiaryView .box-body').append(ajaxLoadingCenter);
                },
                success: function( data ) {
                    // console.log(data);
                    var obj = jQuery.parseJSON(data);
                    if (obj.error == 0) {
                        $.each(obj.data, function(i,v) {
                            var e = '<div class="callout callout-' + v.color + '"><h4>' + v.destination + ' - ' + v.car + '</h4>' + v.title_free + ': ' + v.free;
                            $.each(v.buttons, function(ii,b) {
                                e += b;
                            });
                            e += '</div>';
                            $('#eventDiaryView .box-body').append(e);
                        });
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
});

var ajaxLoadingCenter = '<div class="ajax-loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>';
var ajaxErrorCenter = '<div class="ajax-error"><i class="fa fa-exclamation-triangle fa-3x" aria-hidden="true"></i></div>';
