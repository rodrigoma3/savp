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

    if ($('[data-mask]').length) {
        $('[data-mask]').inputmask();
    }

    jQuery(function($){
        if ($('.duallistbox').length) {
            var duallist = $('.duallistbox').bootstrapDualListbox({
                filterOnValues: true,
            });
            // $.getJSON( lang, function( data ) {
            //     $('#duallist').bootstrapDualListbox('setNonSelectedListLabel', data.oLocale['nonSelectedListLabel']);
            //     $('#duallist').bootstrapDualListbox('setSelectedListLabel', data.oLocale['selectedListLabel']);
            //     $('#duallist').bootstrapDualListbox('setFilterTextClear', data.oLocale['filterTextClear']);
            //     $('#duallist').bootstrapDualListbox('setFilterPlaceHolder', data.oLocale['filterPlaceHolder']);
            //     $('#duallist').bootstrapDualListbox('setMoveAllLabel', data.oLocale['moveAllLabel']);
            //     $('#duallist').bootstrapDualListbox('setRemoveAllLabel', data.oLocale['removeAllLabel']);
            //     $('#duallist').bootstrapDualListbox('setInfoText', data.oLocale['infoText']);
            //     $('#duallist').bootstrapDualListbox('setInfoTextFiltered', data.oLocale['infoTextFiltered']);
            //     $('#duallist').bootstrapDualListbox('setInfoTextEmpty', data.oLocale['infoTextEmpty']);
            //     $('#duallist').bootstrapDualListbox('refresh');
            // });

            // $('.box1').removeClass('col-md-6').addClass('span5');
            // $('.box2').removeClass('col-md-6').addClass('span5');
            // $('button.move').html('<i class="fa fa-arrow-right"></i>');
            // $('button.moveall').html('<i class="fa fa-arrow-right"></i>&nbsp;<i class="fa fa-arrow-right"></i>');
            // $('button.remove').html('<i class="fa fa-arrow-left"></i>');
            // $('button.removeall').html('<i class="fa fa-arrow-left"></i>&nbsp;<i class="fa fa-arrow-left"></i>');

            //in ajax mode, remove remaining elements before leaving page
            $(document).one('ajaxloadstart.page', function(e) {
                $('#duallist').bootstrapDualListbox('destroy');
            });
        }
    });

    if ($('#ReportOrder').length) {
        $('#ReportOrder').select2({
            tags: true,
            language: 'pt-BR'
        });
    }

    if ($('#ReportConditions').length) {
        $('#ReportConditions').select2({
            tags: true,
            language: 'pt-BR'
        });
    }

    if ($('#ReportOrderField').length) {
        $('#ReportOrderField').select2({
            language: 'pt-BR'
        });
    }

    if ($('#ReportConditionFieldList').length) {
        $('#ReportConditionFieldList').select2({
            language: 'pt-BR'
        });
    }

    if ($('#ReportConditionField').length) {
        $('#ReportConditionField').select2({
            language: 'pt-BR'
        });
    }

    if ($('#btnAddOrderField').length) {
        $('#btnAddOrderField').on('click', function() {
            var option = $('#ReportOrderField').val() + ' ' + $('#ReportOrderDirection').val();
            if ($('#ReportOrder').find("option[value='" + option + "']").length) {
                var selected = $('#ReportOrder').val();
                selected.push(option)
                $('#ReportOrder').val(selected).trigger('change');
            } else {
                var newOption = new Option(option, option, true, true);
                $('#ReportOrder').append(newOption).trigger('change');
            }
        });
    }

    if ($('#btnAddConditionField').length) {
        $('#btnAddConditionField').on('click', function() {
            var option = '(' + $('#ReportConditionFieldList').val() + ' ';
            var what = '';
            if ($('#ReportWhatOrFieldWhat').is(':checked')) {
                what = '"' + $('#ReportConditionWhat').val() + '"';
            } else {
                what = $('#ReportConditionField').val();
            }
            var operator = $('#ReportConditionOperator').val().split('_');
            if (operator.length > 1) {
                switch (operator[1]) {
                    case 'IN':
                        option = option + operator[0] + ' CONCAT("%",' + what + ',"%")';
                        break;
                    case 'INI':
                        option = option + operator[0] + ' CONCAT("%",' + what + ')';
                        break;
                    case 'END':
                        option = option + operator[0] + ' CONCAT('+ what + ',"%")';
                        break;
                    default:
                        option = option + operator[0] + what;
                        break;

                }
            } else {
                option = option + $('#ReportConditionOperator').val() + ' ' + what;
            }
            option = option + ')';
            if ($('#ReportConditions').find("option[value='" + option + "']").length) {
                var selected = $('#ReportConditions').val();
                selected.push(option)
                $('#ReportConditions').val(selected).trigger('change');
            } else {
                var newOption = new Option(option, option, true, true);
                $('#ReportConditions').append(newOption).trigger('change');
            }
        });
    }

    if ($('#btnAddConditionFieldAnd').length) {
        $('#btnAddConditionFieldAnd').on('click', function() {
            var newOption = new Option('AND', 'AND', true, true);
            $('#ReportConditions').append(newOption).trigger('change');
        });
    }

    if ($('#btnAddConditionFieldOr').length) {
        $('#btnAddConditionFieldOr').on('click', function() {
            var newOption = new Option('OR', 'OR', true, true);
            $('#ReportConditions').append(newOption).trigger('change');
        });
    }

    if ($('#btnAddConditionFieldPL').length) {
        $('#btnAddConditionFieldPL').on('click', function() {
            var newOption = new Option('(', '(', true, true);
            $('#ReportConditions').append(newOption).trigger('change');
        });
    }

    if ($('#btnAddConditionFieldPR').length) {
        $('#btnAddConditionFieldPR').on('click', function() {
            var newOption = new Option(')', ')', true, true);
            $('#ReportConditions').append(newOption).trigger('change');
        });
    }

    if ($('#btnClearOrderField').length) {
        $('#btnClearOrderField').on('click', function() {
            $('#ReportOrder').val(null).trigger('change');
        });
    }

    if ($('#btnClearConditionField').length) {
        $('#btnClearConditionField').on('click', function() {
            $('#ReportConditions').val(null).trigger('change');
        });
    }
});

var ajaxLoadingCenter = '<div class="ajax-loading"><i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i></div>';
var ajaxErrorCenter = '<div class="ajax-error"><i class="fa fa-exclamation-triangle fa-3x" aria-hidden="true"></i></div>';
