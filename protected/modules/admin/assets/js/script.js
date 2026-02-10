$(function () {
    $('body').on('click', 'a[data-scroll]', function (e) {
        e.preventDefault();
        var el = $(this),
            sel = el.data('scroll');
        $('html, body').animate({
            'scrollTop': $(sel).offset().top - $(".header").outerHeight() - 30
        }, 1000);
    });
    /**********************
     SEARCH BAR
     **********************/
    $('body').on('click', 'a', function (e) {
        e.stopPropagation();
    });
    $('body').on('click', '.options a.fa-search, .search-bar a.fa-arrow-left', function () {
        $('html').toggleClass('has-search');
    });
    $('body').on('click', '.search-bar a.fa-search', function () {
        $('.search-form form').submit();
    });
    $('body').on('click', '.search-bar a.fa-refresh', function () {
        $('.search-form input[type="text"], .search-form select').val('');
    });

    /**********************
     SORTING
     **********************/
    $('body').on('click', '.options a.fa-reorder', function (e) {
        e.preventDefault();
        sort.init('.table tbody');
        $('html').addClass('has-sort');
    });

    $('body').on('click', '.sort-bar a.fa-save', function (e) {
        e.preventDefault();
        sort.save($('a.fa-reorder')[0], '.table tbody');
    });
    $('body').on('click', '.sort-bar a.fa-arrow-left', function (e) {
        e.preventDefault();
        sort.reset('.table tbody');
        $('html').removeClass('has-sort');
    });
    /**********************
     REPEATER
     **********************/
    repeater.sortable();
    $('body').on('click', 'a.repeater-next-add', function (e) {
        e.preventDefault();
        var list = $(this).closest('.repeater');
        var target = $(this).closest('li');
        var rel = list.data('rel');
        var template = $('.templates [data-for="' + rel + '"]').html();
        var typeArr = ["slider", "grid", "small_icon", "feature-grid"];

        if (typeArr.indexOf(rel) >= 0) {
            template = flexibleContent.replaceImageUniqueId(template);
        }

        $(template).css('display', 'none').insertAfter(target).slideDown(function () {
            repeater.order(this);
        });
    });
    $('body').on('click', 'a.repeater-del', function (e) {
        e.preventDefault();
        var block = $(this).closest('li');
        rep = $(this).closest('.repeater');
        block.slideUp(function () {
            $(this).remove();
            repeater.order(rep);
        });
    });
    $('body').on('click', 'a.repeat-add', function (e) {
        e.preventDefault();
        var list = $(this).prev('.repeater');
        console.log(list);
        var rel = list.data('rel');
        var template = $('.templates [data-for="' + rel + '"]').html();
        var typeArr = ["slider", "grid", "small_icon", "feature-grid"];
        if (typeArr.indexOf(rel) >= 0) {
            template = flexibleContent.replaceImageUniqueId(template);
        }

        $(template).css('display', 'none').appendTo(list).slideDown(function () {
            repeater.order(this);
        });
    });

    $('body').on('click', 'a.repeater-up', function (e) {
        e.preventDefault();
        var block = $(this).closest('li'),
            prev = block.prev('li');
        if (prev.length) {
            block.insertBefore(prev);
            repeater.order(this);
        }
    });

    $('body').on('click', 'a.repeater-down', function (e) {
        e.preventDefault();
        var block = $(this).closest('li'),
            next = block.next('li');
        if (next.length) {
            block.insertAfter(next);
            repeater.order(this);
        }
    });

    $('body').on('click', 'a.import_model', function (e) {
        e.preventDefault();
        var el = $(this), title = el.attr('data-title');
        $('body').toggleClass('show_popup');
        $('.import_popup_header span').html(title);
    });

    $('body').on('click', '.import_popup_header .fa.fa-close', function (e) {
        $('body').toggleClass('show_popup');
    });

    $('body').on('blur', '.repeater input, .flexible-content input', function () {
        $(this).attr('value', $(this).val());
    });
    $('body').on('blur', '.repeater textarea, .flexible-content textarea', function () {
        $(this).html($(this).val());
    });
    $('body').on('change', '.repeater input[type="checkbox"], .flexible-content input[type="checkbox"]', function () {
        $(this).attr('checked', $(this).is(":checked"));
    });
    $('body').on('blur', '.repeater select, .flexible-content select', function () {
        $(this).find('option').removeAttr('selected');
        $(this).find(":selected").attr('selected', $(this).val());
    });

    /******************************************
     DISPAYING FIELD BASED ON DROP DOWN RESULT
     *******************************************/
    $('body').on('change', 'select.block-change', function (e) {
        var blockgroup = $(this).data('group'),
            groupel = $('.' + blockgroup);
        sel = '.' + blockgroup + '.' + this.value,
            el = $(sel);
        groupel.fadeOut(0);
        if (this.value !== '')
            el.fadeIn(0);
    });

    /**********************
     MULTI SELECT
     **********************/
    $('.multiselector select').each(function () {
        page.dropdowns[this.id + '_ref'] = $(this).dropdown({
            multiSelect: true,
            onChange: function (option, element) {
                var id = element.id,
                    value = $.trim($(element).val()),
                    hid = $(element).data('hidden'),
                    box = $(element).closest('.multiselector'),
                    dropDown = page.dropdowns[element.id + '_ref'];
                if (value != '') {
                    $('#' + element.id + '_wrapper').before('<div class="tag" id="' + id + value + '">' + $('#' + id + ' option:selected').text() + '<input type="hidden" name="' + hid + '" value="' + value + '" /><a data-id="' + value + '" class="remove fa fa-times-circle"></a></div>');
                    dropDown.disableOption(value);
                    dropDown.selectOption('');
                }
            }
        });
    });



    page.load();
    page.table();
    page.fileDragDorp();
    
    if ($('#lineChart').length) {
        page.customLineChart();
    }


    $('body').on('submit', '.import_form', function (e) {
        e.preventDefault();
        var el = $(this), fileInput = el.find('#fileInput'), action = el.attr('action');

        if (!fileInput[0].files.length) {
            alert('Please select an Excel file');
            return;
        }

        const formData = new FormData(this);

        $.ajax({
            url: action,
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            beforeSend: function () {
                $('.import_submit').text('Uploading...');
            },
            success: function (res) {
                if (res.status) {
                    alert('Imported successfully\nSuccess: ' + res.success + '\nFailed: ' + res.failed);
                    $('body').toggleClass('show_popup');
                    location.reload();
                } else {
                    alert(res.message);
                }
            },
            error: function () {
                alert('Upload failed');
            },
            complete: function () {
                $('.btn-submit').text('Upload & Import');
            }
        });
    });


});

//Repeater
var repeater = {
    order: function (el) {
        var isChild = false;
        if (!$(el).hasClass('repeater')) {
            el = $(el).closest('.repeater');
        }

        if (el.closest('.repeater-item').length)
            isChild = el.closest('.repeater-item').attr('data-key');
        if (el.closest('.flexible-item').length)
            isChild = el.closest('.flexible-item').attr('data-key');
        $(el).find('> li').each(function (i) {
            repeater.destroyEditor(this);
            flexibleContent.destroySelect2($(this).find(".select2-dropdown-links"));
            flexibleContent.destroySelect2($(this).find('.select2-multi-list'));
            flexibleContent.destroySelect2($(this).find('.select2-single-list'));
            var item = $(this).find('> .repeater-item'),
                oldid = item.attr('data-key'),
                html = item.html(),
                regex,
                id = i;
            var nth = 0;
            html = html.replace(/-\d+-/g, function (match, i, original) {
                nth++;
                var div = isChild === false ? 1 : 2;
                return '-' + ((nth % div == 0) ? id : isChild) + '-';
            });
            nth = 0;
            html = html.replace(/\[(\d)+\]/g, function (match, i, original) {
                nth++;
                var div = isChild === false ? 1 : 2;
                return '[' + ((nth % div == 0) ? id : isChild) + ']';
            });
            //Replace HTML
            $(this).find('> .repeater-item').attr('data-key', i).html(html);
            repeater.subRepeatOrder($(this));
            flexibleContent.makeImageUploadable(this);
            repeater.datePickerInit(this);
            //add editors
            repeater.initEditor(this);
            flexibleContent.select2Links($(this).find(".select2-dropdown-links"));

            flexibleContent.makeMultiSelect($(this).find('.select2-multi-list'));
            flexibleContent.makeSingleSelect($(this).find('.select2-single-list'));
        });
        //Make textarea autoresize
        $(el).find('textarea').autosize();
        //Make it sortable
        this.sortable();
    },
    sortable: function () {
        $('.repeater').each(function () {
            $(this).sortable({
                handle: $(this).find('.drag'),
                helper: 'clone',
                update: function (event, ui) {
                    repeater.order(ui.item);
                }
            });
        });
    },
    subRepeatOrder: function (el) {
        var rep = el.find('.repeater');
        if (rep.length) {
            rep.each(function () {
                repeater.order($(this));
            });
        }
    },
    datePickerInit: function (el) {
        var inpDates = $(el).find('.hasDatepicker');
        if (inpDates.length) {
            $(inpDates).each(function () {
                $(this).removeClass('hasDatepicker').datepicker({
                    onSelect: function (selectedDate) {
                        // custom callback logic here
                        $(this).attr('value', selectedDate);
                    }
                });
            });
        }
    },
    destroyEditor: function (el) {
        var txtArea = $(el).find('.repeater-widget-editor');
        if ($(txtArea).length) {
            $(txtArea).attr('data-html', $R(txtArea[0], 'source.getCode'));
            $(txtArea).attr('data-name', $(txtArea).attr("name"));
            $R(txtArea[0], 'destroy');
        }
    },
    initEditor: function (el) {
        var txtArea = $(el).find('.repeater-widget-editor');
        if ($(txtArea).length) {
            //$('.model-form textarea.repeater-widget-editor').each(function (e) {
            $(txtArea).attr("name", $(txtArea).attr("data-name"));
            $(txtArea).removeAttr("data-name");

            if ($(txtArea).attr('data-html')) {
                $(txtArea).val($(txtArea).attr('data-html'));
            }

            $R(txtArea[0], {
                plugins: ['source', 'table', 'alignment'],
                focus: false,
                formatting: ['p', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote'],
                buttons: ['format', 'bold', 'italic', 'underline', 'link', 'lists', 'html'],
                linkEmail: true, toolbarFixed: true, toolbarFixedTopOffset: 56
            });
            //});
        }
    },
    destroyFullEditor: function () {
        $('.model-form textarea.repeater-widget-editor').each(function (e) {
            $(this).attr('data-html', $R(this, 'source.getCode'));
            $(this).attr('data-name', $(this).attr("name"));
            $R(this, 'destroy');
        });
    },
    initFullEditor: function () {
        if ($('.model-form textarea.repeater-widget-editor').length) {
            $('.model-form textarea.repeater-widget-editor').each(function (e) {
                $(this).attr("name", $(this).attr("data-name"));
                $(this).removeAttr("data-name");

                if ($(this).attr('data-html')) {
                    $(this).val($(this).attr('data-html'));
                }

                $R(this, {
                    plugins: ['source', 'table', 'alignment'],
                    focus: false,
                    formatting: ['p', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote'],
                    buttons: ['format', 'bold', 'italic', 'underline', 'link', 'lists', 'html'],
                    linkEmail: true, toolbarFixed: true, toolbarFixedTopOffset: 56
                });
            });
        }
    },
};
//Page functions
var page = {
    upload_object: {}, dropdowns: {}, timer: 0,
    saveTimer: 0,
    check: function () {
        if (!Modernizr.history)
            window.location = '/upgrade/browser';
    },
    get: function (key, default_) {
        //Function to get the value of url parameters         if (default_ == null)
        default_ = "";
        key = key.replace(/[\[]/, "\\\[").replace(/[\]]/, "\\\]");
        var regex = new RegExp("[\\?&]" + key + "=([^&#]*)");
        var qs = regex.exec(window.location.href);
        if (qs == null)
            return default_;
        else
            return qs[1];
    },
    load: function () {
        //Display alerts
        if ($('.header .alert').length) {
            $('.header .alert').slideDown().delay(5000).slideUp(function () {
                $(this).remove();
            });
        }
        //Scroll to Nav
        if ($('ul.nav .active').length) {
            if ($('ul.nav .active').offset().top > ($(window).height() - 150))
                $('.panel.left').scrollTop($('ul.nav .active').offset().top - 200);
        }
        //Initialize sorting
        sort.init();
        //Setup blocks
        $('select.block-change').change();
        $('input.block-change').change();
        //Autogrow textarea
        $('textarea').not('.html').autosize();
        //Enable HTML editor
        if ($('textarea.html').length) {
            $('textarea.html').each(function (e) {
                if ($(this).hasClass('special')) {
                    $(this).redactor({
                        plugins: ['source'],
                        focus: false,
                        formatting: ['p', 'h2', 'h3', 'h4', 'h5', 'h6', 'blockquote'],
                        buttons: ['format', 'bold', 'italic', 'link', 'lists', 'html'],
                        linkEmail: true, toolbarFixed: true, toolbarFixedTopOffset: 56
                    });
                } else {
                    $(this).redactor({
                        plugins: ['source', 'table', 'alignment'],
                        focus: false,
                        buttons: ['bold', 'underline', 'link', 'html'],
                        linkEmail: true, toolbarFixed: true, toolbarFixedTopOffset: 56
                    });
                }
            });
        }
        //Render custom dropdowns
        $('.richdropdown').each(function () {
            page.dropdowns[this.id + '_ref'] = $(this).dropdown();
        });
        flexibleContent.adjustLayoutGrid();
        page.resize();
        $('.related-sidebar-type').each(function () {
            relatedWidget.init(this);
        });
    },
    resize: function () {
        //GridView
        if ($('.grid-view').length) {
            $('.full-row-edit').css('width', ($('.content').width() - 20) + 'px');
            $('.full-row-click').each(function () {
                var hei = $(this).closest('td').outerHeight();
                $(this).css('height', hei);
            });
        }

        if ($(".image-cropper").length) {
            cropper.objectFit();
        }

        flexibleContent.adjustLayoutGrid();
    },
    table: function () {
        $('.table.table-striped.table-bordered th').each(function () {
            var text = $(this).find('a').html(),
                a = $(this).find('a'),
                span = '<span>' + text + '</span>';
            a.html('');
            a.append(span);
        })

    },
    urlvars: function (href) {
        var vars = [], hash;
        var hashes = href.slice(href.indexOf('?') + 1).split('&');
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push(hash[0]);
            vars[hash[0]] = hash[1];
        }
        return vars;
    },
    fileDragDorp: function () {
        const $dropArea = $('#drop-area');
        const $fileInput = $('#fileInput');
        const $browseBtn = $('#browseBtn');
        const $fileName = $('#fileName');

        // Browse button
        $browseBtn.on('click', function (e) {
            e.preventDefault(); // important inside form
            $fileInput.trigger('click');
        });

        // File select
        $fileInput.on('change', function () {
            if (!this.files.length) return;
            validateFile(this.files[0]);
        });

        // Drag over
        $dropArea.on('dragover', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).addClass('dragover');
        });

        // Drag leave
        $dropArea.on('dragleave dragend', function () {
            $(this).removeClass('dragover');
        });

        // Drop
        $dropArea.on('drop', function (e) {
            e.preventDefault();
            e.stopPropagation();
            $(this).removeClass('dragover');

            const files = e.originalEvent.dataTransfer.files;
            if (!files.length) return;

            $fileInput[0].files = files;
            validateFile(files[0]);
        });

        function validateFile(file) {
            const allowedTypes = [
                'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
            ];

            if (!allowedTypes.includes(file.type)) {
                alert('Only .xlsx files are allowed');
                $fileInput.val('');
                $fileName.text('');
                return;
            }

            $fileName.text(file.name);
        }
    },
    customLineChart: function () {
        var options = {
            series: [{
                name: 'Sales',
                data: [44, 55, 57, 56, 61, 58, 63, 60, 66]
            }, {
                name: 'Order',
                data: [76, 85, 101, 98, 87, 105, 91, 114, 94]
            }],
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct'],
            },
            yaxis: {
                title: {
                    text: '$ (thousands)'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return "$ " + val + " thousands"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#lineChart"), options);
        chart.render();
    }
};
//Sorting plugin
var sort = {
    cache: '', init: function (selector) {
        this.cache = $(selector).html();
        $(selector).each(function () {
            $(this).sortable({
                placeholder: "drop-placeholder",
                revert: true, start: function (e, ui) {
                    ui.placeholder.width(ui.helper.width());
                }
            });
        });
    },
    reset: function (selector) {
        $(selector).html(this.cache);
        this.cache = '';
    },
    destroy: function (selector) {
        $(selector).sortable("destroy");
    },
    save: function (el, selector) {
        serial = $(selector).sortable("serialize", {
            key: "items[]",
            attribute: "data-sort"
        });
        $.ajax({
            url: el.href,
            type: "post",
            data: serial,
            success: function () {
                sort.destroy(selector);
                $('html').removeClass('has-sort');
                alertify.success("The order was saved successfully.");
            },
            error: function () {
                sort.destroy(selector);
                alertify.error("We are unable to set the sort order at this time.  Please try again in a few minutes.");
            }
        });
    }
};