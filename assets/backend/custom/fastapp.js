/**
 * FastApp Core Console Scripts (Modernized for AdminLTE 3 / Bootstrap 3)
 * Supports Add, Edit, View, Delete, Modal Popups, Validation, AJAX Tables & Charts
 */

var current_language = null;
var currentPostRequest = null;
var currentPageinationLink = '';
var widgetArray = [];

// Fallback cookie helper if jQuery cookie plugin is absent
if (typeof $.cookie !== 'function') {
    $.cookie = function(name, value, options) {
        if (typeof value !== 'undefined') {
            options = options || {};
            if (value === null) {
                value = '';
                options.expires = -1;
            }
            var expires = '';
            if (options.expires && (typeof options.expires === 'number' || options.expires.toUTCString)) {
                var date;
                if (typeof options.expires === 'number') {
                    date = new Date();
                    date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
                } else {
                    date = options.expires;
                }
                expires = '; expires=' + date.toUTCString();
            }
            var path = options.path ? '; path=' + (options.path) : '; path=/';
            var domain = options.domain ? '; domain=' + (options.domain) : '';
            var secure = options.secure ? '; secure' : '';
            document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
        } else {
            var cookieValue = null;
            if (document.cookie && document.cookie !== '') {
                var cookies = document.cookie.split(';');
                for (var i = 0; i < cookies.length; i++) {
                    var cookie = jQuery.trim(cookies[i]);
                    if (cookie.substring(0, name.length + 1) === (name + '=')) {
                        cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                        break;
                    }
                }
            }
            return cookieValue;
        }
    };
}

/*
|--------------------------------------------------------------------------
| Document Ready Handlers
|--------------------------------------------------------------------------
*/
$(document).ready(function () {
    // 1. Language Handling
    if (typeof $.cookie === 'function') {
        current_language = $.cookie('current_language') == null ? '1' : $.cookie('current_language');
    } else {
        current_language = '1';
    }

    $('#language a[data-value="' + current_language + '"]').find('i').addClass('fa fa-check');
    $('#language a').on('click', function (e) {
        e.preventDefault();
        current_language = $(this).attr('data-value');
        if (typeof $.cookie === 'function') {
            $.cookie('current_language', current_language, { expires: 365, path: '/' });
        }
        $('#language i').removeClass('fa-check icon-ok');
        $(this).find('i').addClass('fa-check');
        window.location.reload();
    });

    // 2. Foldable Nav / Accordion
    $(document).on('click', '.accordion > a', function (e) {
        e.preventDefault();
        var $ul = $(this).siblings('ul');
        var $li = $(this).parent();
        if ($ul.is(':visible')) {
            $li.removeClass('active').parent('ul').parent('li').find('i').removeClass('fa-chevron-down').addClass('fa-chevron-right');
        } else {
            $li.addClass('active').parent('ul').parent('li').find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');
        }
        $ul.slideToggle();
    });

    $('.accordion li.active:first').parents('ul').slideDown();
    $('.accordion li.active:first').parent('ul').parent('li').addClass('active');
    $('.accordion li.active:first').parent('ul').parent('li').find('i').removeClass('fa-chevron-right').addClass('fa-chevron-down');

    // 3. Table Select / Deselect All
    $(document).on('click', '.btn_select_all, #btn_select_all', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        form.find('.selectedItem').prop('checked', true).trigger('change');
        form.find('#selectAll').prop('checked', true);
    });

    $(document).on('click', '.btn_deselect_all, #btn_deselect_all', function (e) {
        e.preventDefault();
        var form = $(this).closest('form');
        form.find('.selectedItem').prop('checked', false).trigger('change');
        form.find('#selectAll').prop('checked', false);
    });

    // 4. Global Datepicker & Datetimepicker
    initDatePickers();

    // 5. Ordering / Sorting & Pagination
    if ($(".orderable").length) {
        reorderTable();
    }
    setSorting();
    ajaxPagination();

    // 6. Tree View if present
    if ($("#viewport").length && typeof initTree === 'function') {
        initTree($("#viewport"));
    }

    // 7. Initialize Widgets
    initWidgetLoad();
});

/*
|--------------------------------------------------------------------------
| Plugin Initializers
|--------------------------------------------------------------------------
*/
function initDatePickers(context) {
    var $ctx = context ? $(context) : $(document);
    if ($.fn.datepicker) {
        $ctx.find('.datepicker').each(function () {
            var dateVal = $(this).val();
            if (!$(this).data('datepicker-initialized')) {
                $(this).datepicker({ format: 'yyyy-mm-dd', autoclose: true });
                $(this).data('datepicker-initialized', true);
            }
            if (dateVal) $(this).val(dateVal);
        });
    }
    if ($.fn.datetimepicker) {
        $ctx.find('.datetimepicker').each(function () {
            if (!$(this).data('datetimepicker-initialized')) {
                $(this).datetimepicker({ format: 'YYYY-MM-DD HH:mm:ss' });
                $(this).data('datetimepicker-initialized', true);
            }
        });
    }
    if ($.fn.select2) {
        $ctx.find('[data-rel="chosen"], [rel="chosen"], .select2').not('.select2-hidden-accessible').select2({
            width: '100%'
        });
    }
}

/*
|--------------------------------------------------------------------------
| AJAX Pagination
|--------------------------------------------------------------------------
*/
var ajaxPagination = function () {
    $(document).off('click', '.pagination a, .pagination-wrapper a').on('click', '.pagination a, .pagination-wrapper a', function (e) {
        e.preventDefault();
        var targetUrl = $(this).attr('href');
        if (!targetUrl || targetUrl === '#' || targetUrl.indexOf('javascript') === 0) {
            return;
        }
        currentPageinationLink = targetUrl;
        var targetObj = $(this);
        var searchData = $('.search-table-form').length ? $('.search-table-form').serialize() : '';
        if (searchData === '') {
            searchData = { 'dummy': 'hammy' };
        }

        currentPostRequest = $.post(targetUrl, searchData, function (resData) {
            var $wrapper = targetObj.closest('.table_view_wrapper');
            if ($wrapper.length) {
                $wrapper.replaceWith(resData);
            } else if ($('.table_view_wrapper').length) {
                $('.table_view_wrapper').first().replaceWith(resData);
            } else {
                $('.index-wrapper').html(resData);
            }
            postTableGeneration();
        }, 'html');
    });
};

/*
|--------------------------------------------------------------------------
| Search Box
|--------------------------------------------------------------------------
*/
$(document).on('change', '.search_box input, .search_box select', function () {
    initSearch();
});

$(document).on('keydown', '.search_box input', function (e) {
    if (e.which === 13 || e.keyCode === 13) {
        e.preventDefault();
        initSearch();
    }
});

var initSearch = function () {
    var dataToPost = $('.search-table-form').length ? $('.search-table-form').serialize() : '';
    if (dataToPost === '') {
        dataToPost = { 'dummy': 'hammy' };
    }
    var formUrl = '';
    if (typeof $('.search-table-form').attr('action') !== 'undefined') {
        formUrl = $('.search-table-form').attr('action');
    }
    var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';

    currentPostRequest = $.post(baseUrl + formUrl, dataToPost, function (resData) {
        if ($('.table_view_wrapper').length) {
            $('.table_view_wrapper').first().replaceWith(resData);
        } else {
            $('.index-wrapper').html(resData);
        }
        postTableGeneration();
    }, 'html');
    currentPageinationLink = "";
};

function postTableGeneration() {
    initDatePickers();
    if (typeof docReady === 'function') docReady();
    if ($(".orderable").length) {
        reorderTable();
    }
    setSorting();
    ajaxPagination();
}

var postDetailLoad = function () {};

/*
|--------------------------------------------------------------------------
| Delete Operations (Single & Bulk)
|--------------------------------------------------------------------------
*/
var popupDeleteAll = function () {
    var selectedIDs = [];
    $('.selectedItem:checked').each(function () {
        selectedIDs.push($(this).val());
    });

    if (selectedIDs.length === 0) {
        if (typeof toastr !== 'undefined') {
            toastr.warning('Please select at least one record.');
        } else {
            alert('Please select at least one record.');
        }
        return;
    }

    if (confirm("Are you sure you want to delete the selected " + selectedIDs.length + " item(s)?")) {
        deleteAllOperation();
    }
};

var deleteAllOperation = function () {
    var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';
    var selectedData = $('.choose_entry_form').length ? $('.choose_entry_form').serialize() : '';
    if (!selectedData) {
        var ids = [];
        $('.selectedItem:checked').each(function () { ids.push($(this).val()); });
        selectedData = { selectedItem: ids };
    }

    currentPostRequest = $.post(baseUrl + 'delete_multiple', selectedData, function (respData) {
        if (respData && (respData.status === 'success' || respData.success)) {
            if (typeof toastr !== 'undefined') {
                toastr.success(respData.message || 'Selected records deleted successfully.');
            }
            $('#myModal, #formModal').modal('hide');
            initSearch();
        } else {
            var msg = (respData && respData.message) ? respData.message : 'Delete failed.';
            if (typeof toastr !== 'undefined') { toastr.error(msg); } else { alert(msg); }
        }
    }, 'json').fail(function () {
        // Fallback to delete endpoint
        $.post(baseUrl + 'delete', selectedData, function (respData) {
            if (typeof toastr !== 'undefined') toastr.success('Deleted successfully.');
            initSearch();
        }, 'json');
    });
};

var popupDeleteSingle = function (targetItem) {
    if (confirm("Are you sure you want to delete this entry?")) {
        deleteSingleOperation(targetItem);
    }
};

var popupDeleteSingle = function (e, targetItem) {
    if (e && typeof e.preventDefault === 'function') {
        e.preventDefault();
    } else if (typeof targetItem === 'undefined') {
        targetItem = e;
    }
    if (!targetItem || typeof targetItem === 'object') return;
    if (!confirm('Are you sure you want to delete this record?')) return;
    deleteSingleOperation(targetItem);
};

var deleteSingleOperation = function (targetItem) {
    if (!targetItem || typeof targetItem === 'object') return;
    var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';
    if (!baseUrl.endsWith('/')) baseUrl += '/';
    currentPostRequest = $.post(baseUrl + 'delete', { entry: targetItem }, function (respData) {
        if (respData && (respData.status === 'success' || respData.success)) {
            $('#row_' + targetItem).fadeOut(300, function () { $(this).remove(); });
            if (typeof toastr !== 'undefined') {
                toastr.success(respData.message || 'Record deleted successfully.');
            }
            $('#myModal, #formModal, #formAddEditModal, #viewDetailModal').modal('hide');
        } else {
            var msg = (respData && respData.message) ? respData.message : 'Delete failed.';
            if (typeof toastr !== 'undefined') { toastr.error(msg); } else { alert(msg); }
        }
    }, 'json').fail(function () {
        if (typeof toastr !== 'undefined') toastr.error('An error occurred during deletion.');
    });
};

/*
|--------------------------------------------------------------------------
| View Detail Operation
|--------------------------------------------------------------------------
*/
var popupViewSingle = function (e, targetItem) {
    if (e && typeof e.preventDefault === 'function') {
        e.preventDefault();
    } else if (typeof targetItem === 'undefined') {
        targetItem = e;
    }
    if (!targetItem || typeof targetItem === 'object') return;
    var modal = $('#viewDetailModal').length ? $('#viewDetailModal') : ($('#formModal').length ? $('#formModal') : $('#myModal'));
    modal.find('.modal-title, .modal-header h3').html('<i class="fa fa-info-circle"></i> Details');
    modal.find('.modal-body p, .modal-body').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading details...</p></div>');
    modal.modal('show');
    viewSingleOperation(targetItem);
};

var viewSingleOperation = function (targetItem) {
    if (!targetItem || typeof targetItem === 'object') return;
    var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';
    if (!baseUrl.endsWith('/')) baseUrl += '/';
    var modal = $('#viewDetailModal').length ? $('#viewDetailModal') : ($('#formModal').length ? $('#formModal') : $('#myModal'));

    currentPostRequest = $.post(baseUrl + 'view_detail', { entry: targetItem }, function (respData) {
        if (respData) {
            modal.find('.modal-body p, .modal-body').html(respData);
            if (typeof postDetailLoad === 'function') postDetailLoad();
        }
    }, 'html');
};

var generateDetailedView = function (targetItem) {
    popupViewSingle(targetItem);
};

/*
|--------------------------------------------------------------------------
| Edit Operation
|--------------------------------------------------------------------------
*/
var popupEditSingle = function (e, targetItem) {
    if (e && typeof e.preventDefault === 'function') {
        e.preventDefault();
    } else if (typeof targetItem === 'undefined') {
        targetItem = e;
    }
    if (!targetItem || typeof targetItem === 'object') return;
    var modal = $('#formAddEditModal').length ? $('#formAddEditModal') : $('#formModal');
    modal.find('.modal-title, .modal-header h3').html('<i class="fa fa-pencil-square-o"></i> Edit Record');
    modal.find('.modal-body p, .modal-body').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading form...</p></div>');
    modal.modal('show');
    loadEditForm(targetItem);
};

var loadEditForm = function (targetItem) {
    if (!targetItem || typeof targetItem === 'object') return;
    var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';
    if (!baseUrl.endsWith('/')) baseUrl += '/';
    var modal = $('#formAddEditModal').length ? $('#formAddEditModal') : $('#formModal');

    currentPostRequest = $.post(baseUrl + 'edit_detail', { 'load_edit_entry': targetItem }, function (respData) {
        if (respData) {
            modal.find('.modal-body p, .modal-body').html(respData);
            initDatePickers(modal);
            if ($.fn.select2) {
                modal.find('.select2, [data-rel="chosen"]').each(function() {
                    var opts = { width: '100%' };
                    if ($(this).attr('multiple')) {
                        opts.tags = true;
                    }
                    $(this).select2(opts);
                });
            }
            modal.find('input:visible:first').focus();
        }
    }, 'html');
};

var generateEditView = function (targetItem) {
    popupEditSingle(targetItem);
};

/*
|--------------------------------------------------------------------------
| Add Operation
|--------------------------------------------------------------------------
*/
var popupAddNew = function (e, targetItem) {
    if (e && typeof e.preventDefault === 'function') {
        e.preventDefault();
    }
    var modal = $('#formAddEditModal').length ? $('#formAddEditModal') : $('#formModal');
    modal.find('.modal-title, .modal-header h3').html('<i class="fa fa-plus-circle"></i> Add New Record');
    modal.find('.modal-body p, .modal-body').html('<div class="text-center p-4"><i class="fa fa-spinner fa-spin fa-2x"></i><p class="mt-2">Loading form...</p></div>');
    modal.modal('show');
    loadAddForm();
};

var loadAddForm = function () {
    var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';
    if (!baseUrl.endsWith('/')) baseUrl += '/';
    var modal = $('#formAddEditModal').length ? $('#formAddEditModal') : $('#formModal');

    currentPostRequest = $.post(baseUrl + 'add_detail', { 'load_add_entry': 'yes' }, function (respData) {
        if (respData) {
            modal.find('.modal-body p, .modal-body').html(respData);
            initDatePickers(modal);
            if ($.fn.select2) {
                modal.find('.select2, [data-rel="chosen"]').each(function() {
                    var opts = { width: '100%' };
                    if ($(this).attr('multiple')) {
                        opts.tags = true;
                    }
                    $(this).select2(opts);
                });
            }
            modal.find('input:visible:first').focus();
        }
    }, 'html');
};

var generateAddView = function (targetItem) {
    popupAddNew(targetItem);
};

/*
|--------------------------------------------------------------------------
| Save Operations
|--------------------------------------------------------------------------
*/
var saveSingleOperation = function () {
    var $form = $('#addEditForm');
    if (!$form.length) return;
    $form.trigger('submit');
};

var saveOperation = function (method) {
    var $form = $('#addEditForm');
    if (!$form.length) return;
    $form.trigger('submit');
};

$(document).on('submit', '#addEditForm', function (e) {
    e.preventDefault();
    var $form = $(this);
    if (typeof validate_form === 'function' && !validate_form($form, {
        beforeValidation: function (targetObject) {
            $(targetObject).closest('.form-group, .control-group').removeClass('has-error error');
            $(targetObject).closest('.form-group, .control-group').find('.help-block, .help-inline').html('');
        },
        onValidationError: function (targetObject, validationType) {
            $(targetObject).closest('.form-group, .control-group').addClass('has-error error');
            var msg = (validationType === 'required') ? 'This field is required.' : 'Please enter valid data.';
            $(targetObject).closest('.form-group, .control-group').find('.help-block, .help-inline').html(msg);
        }
    })) {
        return false;
    }

    var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';
    if (!baseUrl.endsWith('/')) baseUrl += '/';

    var pkField = $form.find('input[name$="_ID"], input[name$="_id"], input[name="id"]').first();
    var isEdit = (pkField.length && pkField.val() && pkField.val() !== '0' && pkField.val() !== '');
    var postUrl = isEdit ? baseUrl + 'edit_detail' : baseUrl + 'add_detail';

    var $submitBtn = $form.find('button[type="submit"]');
    var originalBtnHtml = $submitBtn.html();
    $submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin"></i> Saving...');

    $.post(postUrl, $form.serialize(), function (respData) {
        $submitBtn.prop('disabled', false).html(originalBtnHtml);
        if (typeof respData === 'string') {
            try { respData = JSON.parse(respData); } catch (ex) {}
        }
        if (respData && respData.status === 'success') {
            if (typeof toastr !== 'undefined') {
                toastr.success(respData.message || 'Saved successfully!');
            } else {
                alert(respData.message || 'Saved successfully!');
            }
            var modal = $('#formAddEditModal').length ? $('#formAddEditModal') : $('#formModal');
            modal.modal('hide');
            setTimeout(function () {
                window.location.reload();
            }, 800);
        } else {
            var err = (respData && respData.message) ? respData.message : 'Error saving record.';
            if (typeof toastr !== 'undefined') {
                toastr.error(err);
            } else {
                alert(err);
            }
        }
    }, 'json').fail(function (xhr) {
        $submitBtn.prop('disabled', false).html(originalBtnHtml);
        if (typeof toastr !== 'undefined') {
            toastr.error('Failed to save data. Status: ' + xhr.status);
        } else {
            alert('Failed to save data.');
        }
    });
});

/*
|--------------------------------------------------------------------------
| Form Validation
|--------------------------------------------------------------------------
*/
function validate_form(targetForm, settings) {
    settings = settings || {};
    var formInputs = $(targetForm).find('input, textarea, select');
    var passWords = {};
    var isValid = true;

    function beforeValidation(targetObject) {
        if (typeof settings.beforeValidation === 'function') {
            settings.beforeValidation(targetObject);
        } else {
            $(targetObject).closest('.form-group, .control-group').removeClass('has-error error');
            $(targetObject).closest('.form-group, .control-group').find('.help-block, .help-inline').html('');
        }
    }

    function onValidationError(targetObject, validationType) {
        if (typeof settings.onValidationError === 'function') {
            settings.onValidationError(targetObject, validationType);
        } else {
            $(targetObject).closest('.form-group, .control-group').addClass('has-error error');
            var message = (validationType === 'required') ? 'This field is required.' : 'Please enter valid data.';
            $(targetObject).closest('.form-group, .control-group').find('.help-block, .help-inline').html(message);
        }
    }

    $(formInputs).each(function () {
        beforeValidation($(this));
        var fromvalidation = $(this).attr('from-validation') || $(this).attr('data-validation');
        if (typeof fromvalidation !== "undefined" && fromvalidation) {
            var validationArray = fromvalidation.split('|');

            if ($.inArray('required', validationArray) !== -1) {
                if ($.trim($(this).val()) === '') {
                    onValidationError($(this), 'required');
                    isValid = false;
                }
            }

            if ($.inArray('email', validationArray) !== -1) {
                var emailRegex = /^([\w\.\-]+)@([\w\-]+)((\.(\w){2,3})+)$/i;
                if (!emailRegex.test($.trim($(this).val()))) {
                    onValidationError($(this), 'email');
                    isValid = false;
                }
            }

            if ($.inArray('password', validationArray) !== -1) {
                if ($.inArray('confirm', validationArray) !== -1) {
                    passWords[1] = $(this);
                    if ($(passWords[0]).val() !== $(passWords[1]).val()) {
                        onValidationError($(this), 'password');
                        isValid = false;
                    }
                } else {
                    passWords[0] = $(this);
                }
            }
        }
    });

    if (isValid && typeof settings.onValidationSuccess === 'function') {
        settings.onValidationSuccess();
    }

    return isValid;
}

/*
|--------------------------------------------------------------------------
| Quick Edit
|--------------------------------------------------------------------------
*/
var quickEdit = function (targetItem) {
    var $target = $(targetItem);
    if ($target.data('editing')) return;
    $target.data('editing', true);

    var oldValue = $.trim($target.text());
    var $input = $('<input>', {
        type: 'text',
        class: 'form-control form-control-sm d-inline-block',
        style: 'width: auto; min-width: 80px;'
    }).val(oldValue);

    $target.hide().after($input);
    $input.focus();

    var finished = false;
    function finishEdit(saveValue) {
        if (finished) return;
        finished = true;

        if (saveValue) {
            var newValue = $input.val();
            if (newValue === oldValue) {
                $input.remove();
                $target.show().removeData('editing');
                return;
            }

            var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';
            $.post(baseUrl + 'quick_edit', {
                targetItem: $target.attr('relfield') + '-' + $target.attr('relId'),
                targetValue: newValue
            }, function (respData) {
                if (respData && respData.status === 'error') {
                    if (typeof toastr !== 'undefined') toastr.error(respData.message || 'Update failed.');
                    $target.text(oldValue);
                } else {
                    $target.text(newValue);
                    if (typeof toastr !== 'undefined') toastr.success('Updated successfully.');
                }
            }, 'json').fail(function () {
                $target.text(oldValue);
            });
        } else {
            $target.text(oldValue);
        }

        $input.remove();
        $target.show().removeData('editing');
    }

    $input.on('blur', function () { finishEdit(true); });
    $input.on('keydown', function (e) {
        if (e.keyCode === 13) { e.preventDefault(); finishEdit(true); }
        if (e.keyCode === 27) { e.preventDefault(); finishEdit(false); }
    });
};

/*
|--------------------------------------------------------------------------
| Table Reordering & Sorting
|--------------------------------------------------------------------------
*/
var reorderTable = function () {
    if (typeof $.fn.sortable !== 'function') return;
    $(".orderable").sortable({
        handle: '.drag-handle',
        update: function (event, ui) {
            var orderElements = [];
            $(".orderable").children().each(function () {
                var id = $(this).attr('id');
                if (id && id.indexOf('row_') === 0) {
                    orderElements.push(id.substring(4));
                }
            });

            var baseUrl = (typeof page_url !== 'undefined') ? page_url : '';
            currentPostRequest = $.post(baseUrl + 'order_table', {
                orderElements: orderElements
            }, function (response) {
                if (typeof toastr !== 'undefined') toastr.success('Order updated.');
            }, 'json');
        }
    });
};

var setSorting = function () {
    // 1. Resolve current model/section name
    var resolveSection = function () {
        var sec = (typeof section !== 'undefined' && section) ? section : '';
        if (!sec) {
            var path = window.location.pathname;
            if (typeof page_url !== 'undefined' && page_url) path = page_url;
            var parts = path.split('/').filter(function(p) { return p && p !== 'index.php'; });
            var consoleIdx = parts.indexOf('console');
            if (consoleIdx !== -1 && parts[consoleIdx + 1]) {
                var ctrl = parts[consoleIdx + 1];
                if (ctrl.slice(-1) === 's') {
                    sec = ctrl + '_model';
                } else {
                    sec = ctrl + 's_model';
                }
            }
        }
        return sec;
    };

    var currentSection = resolveSection();

    // 2. Reflect current cookie sorting state on table headers
    if (typeof $.cookie === 'function' && currentSection) {
        var currentCookie = $.cookie('orderBy_' + currentSection);
        if (currentCookie) {
            var cookieParts = currentCookie.split(':');
            var sortField = cookieParts[0];
            var sortDir = cookieParts[1] ? cookieParts[1].toLowerCase() : 'asc';

            $('.shorter').each(function () {
                var field = $(this).attr('data-rel');
                if (field === sortField) {
                    if (sortDir === 'desc') {
                        $(this).removeClass('fa-sort fa-sort-asc fa-sort-up text-muted')
                               .addClass('fa-sort-desc text-primary');
                    } else {
                        $(this).removeClass('fa-sort fa-sort-desc fa-sort-down text-muted')
                               .addClass('fa-sort-asc text-primary');
                    }
                } else {
                    $(this).removeClass('fa-sort-asc fa-sort-desc fa-sort-up fa-sort-down text-primary')
                           .addClass('fa-sort text-muted');
                }
            });
        }
    }

    // 3. Click handler for sort headers & icons
    $(document).off('click', '.shorter, th.sortable_th, th:has(.shorter)').on('click', '.shorter, th.sortable_th, th:has(.shorter)', function (e) {
        if ($(e.target).is('input, select, a, button')) return;
        e.preventDefault();

        var $icon = $(this).is('.shorter') ? $(this) : $(this).find('.shorter');
        if (!$icon.length) return;

        var sortingField = $icon.attr('data-rel');
        if (!sortingField) return;

        var sortingOrder = 'asc';
        if ($icon.hasClass('fa-sort-asc') || $icon.hasClass('fa-sort-up')) {
            sortingOrder = 'desc';
        } else if ($icon.hasClass('fa-sort-desc') || $icon.hasClass('fa-sort-down')) {
            sortingOrder = 'asc';
        }

        var activeSec = resolveSection();
        if (typeof $.cookie === 'function' && activeSec) {
            $.cookie('orderBy_' + activeSec, sortingField + ':' + sortingOrder, { expires: 365, path: '/' });
        }

        if (typeof initSearch === 'function') {
            initSearch();
        }
    });
};

/*
|--------------------------------------------------------------------------
| Widgets Loader
|--------------------------------------------------------------------------
*/
var initWidgetLoad = function () {
    if (typeof widgetArray !== 'undefined' && widgetArray.length) {
        var baseUrl = (typeof console_url !== 'undefined') ? console_url : '';
        $(widgetArray).each(function (key, widgetElement) {
            $.post(baseUrl + widgetElement + '/widget', { bla: 'bla' }, function (respData) {
                $('.widget-area').append(respData);
                if (typeof docReady === 'function') docReady();
            }, 'html');
        });
    }
};

var loadWidget = function (targetFunction) {
    widgetArray.push(targetFunction);
};

// Global backward compatibility
window.popupAddNew = popupAddNew;
window.popupViewSingle = popupViewSingle;
window.popupEditSingle = popupEditSingle;
window.popupDeleteSingle = popupDeleteSingle;
window.popupDeleteAll = popupDeleteAll;
window.generateAddView = generateAddView;
window.generateDetailedView = generateDetailedView;
window.generateEditView = generateEditView;
window.quickEdit = quickEdit;
window.validate_form = validate_form;
window.saveOperation = saveOperation;
window.saveSingleOperation = saveSingleOperation;