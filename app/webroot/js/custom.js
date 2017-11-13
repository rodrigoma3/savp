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

    if ($('#ReportStartDate').length && $('#ReportEndDate').length) {
        $('#ReportStartDate').datetimepicker({
            format: 'YYYY-MM-DD',
            locale: moment.locale(lang),
        });
        $('#ReportEndDate').datetimepicker({
            useCurrent: false,
            format: 'YYYY-MM-DD',
            locale: moment.locale(lang),
        });
        $("#ReportStartDate").on("dp.change", function (e) {
            $('#ReportEndDate').data("DateTimePicker").minDate(e.date);
        });
        $("#ReportEndDate").on("dp.change", function (e) {
            $('#ReportStartDate').data("DateTimePicker").maxDate(e.date);
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

    if ($('[data-mask]').length) {
        $('[data-mask]').inputmask();
    }

    if ($('#ReportCityId').length && $('#ReportCityId').prop('tagName') == 'SELECT') {
        $('#ReportCityId').select2({
            language: lang,
        });
    }

    if ($('#ReportDestinationId').length && $('#ReportDestinationId').prop('tagName') == 'SELECT') {
        $('#ReportDestinationId').select2({
            language: lang,
        });
    }

    if ($('#ReportEstablishmentId').length && $('#ReportEstablishmentId').prop('tagName') == 'SELECT') {
        $('#ReportEstablishmentId').select2({
            language: lang,
        });
    }

    if ($('#ReportCarId').length && $('#ReportCarId').prop('tagName') == 'SELECT') {
        $('#ReportCarId').select2({
            language: lang,
        });
    }

    if ($('.knob').length) {
        $(function() {
            /* jQueryKnob */

            $(".knob").knob({
                /*change : function (value) {
                 //console.log("change : " + value);
                 },
                 release : function (value) {
                 console.log("release : " + value);
                 },
                 cancel : function () {
                 console.log("cancel : " + this.value);
                 },*/
                // draw: function() {
                //
                //     // "tron" case
                //     if (this.$.data('skin') == 'tron') {
                //
                //         var a = this.angle(this.cv)  // Angle
                //                 , sa = this.startAngle          // Previous start angle
                //                 , sat = this.startAngle         // Start angle
                //                 , ea                            // Previous end angle
                //                 , eat = sat + a                 // End angle
                //                 , r = true;
                //
                //         this.g.lineWidth = this.lineWidth;
                //
                //         this.o.cursor
                //                 && (sat = eat - 0.3)
                //                 && (eat = eat + 0.3);
                //
                //         if (this.o.displayPrevious) {
                //             ea = this.startAngle + this.angle(this.value);
                //             this.o.cursor
                //                     && (sa = ea - 0.3)
                //                     && (ea = ea + 0.3);
                //             this.g.beginPath();
                //             this.g.strokeStyle = this.previousColor;
                //             this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sa, ea, false);
                //             this.g.stroke();
                //         }
                //
                //         this.g.beginPath();
                //         this.g.strokeStyle = r ? this.o.fgColor : this.fgColor;
                //         this.g.arc(this.xy, this.xy, this.radius - this.lineWidth, sat, eat, false);
                //         this.g.stroke();
                //
                //         this.g.lineWidth = 2;
                //         this.g.beginPath();
                //         this.g.strokeStyle = this.o.fgColor;
                //         this.g.arc(this.xy, this.xy, this.radius - this.lineWidth + 1 + this.lineWidth * 2 / 3, 0, 2 * Math.PI, false);
                //         this.g.stroke();
                //
                //         return false;
                //     }
                // }
            });
            /* END JQUERY KNOB */
        });
    }

    if ($('#ReportPatientsByDayChart').length) {
        try {
            var reportPatientsByDayChartData = $.parseJSON($('#ReportPatientsByDayChart').attr('data-content'));
            // var reportPatientsByDayChartData = $('#ReportPatientsByDayChart').attr('data-content');

            if (!$.isEmptyObject(reportPatientsByDayChartData)) {
                console.log(reportPatientsByDayChartData);
                var reportPatientsByDayChart = new Morris.Line({
                    element: 'ReportPatientsByDayChart',
                    resize: true,
                    data: reportPatientsByDayChartData,
                    xkey: 'name',
                    ykeys: ['quantity'],
                    labels: ['Quantity'],
                    lineColors: ['#3c8dbc'],
                    hideHover: 'auto'
                });
            }
        } catch (e) {

        }
    }

    if ($('#ReportPatientsByMonthChart').length) {
        try {
            var reportPatientsByMonthChartData = $.parseJSON($('#ReportPatientsByMonthChart').attr('data-content'));
            // var reportPatientsByMonthChartData = $('#ReportPatientsByMonthChart').attr('data-content');

            if (!$.isEmptyObject(reportPatientsByMonthChartData)) {
                console.log(reportPatientsByMonthChartData);
                var reportPatientsByMonthChart = new Morris.Line({
                    element: 'ReportPatientsByMonthChart',
                    resize: true,
                    data: reportPatientsByMonthChartData,
                    xkey: 'name',
                    ykeys: ['quantity'],
                    labels: ['Quantity'],
                    lineColors: ['rgb(175, 20, 20)'],
                    hideHover: 'auto'
                });
            }
        } catch (e) {

        }
    }

});

var ajaxLoadingCenter = '<div class="ajax-loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>';
var ajaxErrorCenter = '<div class="ajax-error"><i class="fa fa-exclamation-triangle fa-3x" aria-hidden="true"></i></div>';
