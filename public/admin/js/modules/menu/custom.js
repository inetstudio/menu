Admin.modals.menuItemModal = new Vue({
    el: '#add_item_modal',
    data: getDefaultModalData(),
    watch: {
        'fields.title': function (newVal) {
            this.menuItem.content = newVal;
        },
        'fields.path': function (newVal) {
            this.menuItem.path = newVal;
        }
    },
    methods: {
        save: function () {
            if (this.fields.type.toString() !== 'separator' && (this.fields.title === '' || this.fields.path === '')) {
                $('#add_item_modal').modal('hide');
                return true;
            }

            var modalDataJSON = JSON.stringify(this.$data);

            if (this.action === 'create') {
                $('.nested-list#menu_list').nestable('add', this.menuItem);
            } else {
                $('.nested-list#menu_list').nestable('modify', this.menuItem, this.$data);
            }

            $('.dd-item[data-id='+this.menuItem.id+']').data('modal', this.$data);
            $('.dd-item[data-id='+this.menuItem.id+']').attr('data-modal', modalDataJSON);

            if (this.fields.type == 'separator') {
                $('.dd-item[data-id='+this.menuItem.id+']').find('.add-subitem').hide();
                $('.dd-item[data-id='+this.menuItem.id+']').find('.view-menu-item').hide();
            } else {
                $('.dd-item[data-id='+this.menuItem.id+']').find('.add-subitem').show();
                $('.dd-item[data-id='+this.menuItem.id+']').find('.view-menu-item').show();
            }

            $('#menu_data').val(JSON.stringify($('.nested-list#menu_list').nestable('serialize')));

            $('#menu_list .dd3-empty').hide();
            $('#add_item_modal').modal('hide');
        }
    }
});

$(document).ready(function () {
    $('#add_menu_item').on('click', function (event) {
        event.preventDefault();

        addItem(undefined);
    });

    var listContainer = $('.nested-list#menu_list');

    listContainer.nestable('destroy');
    listContainer.nestable({
        group: 1,
        itemRenderer: function(item_attrs, content, children, options, item) {
            var item_attrs_string = $.map(item_attrs, function(value, key) {
                return ' ' + key + '="' + value + '"';
            }).join(' ');

            var html = '<li class="dd-item dd3-item" '+item_attrs_string+'>';
            html += '    <div class="dd-handle dd3-handle">Drag</div>';
            html += '    <div class="dd3-content">';
            html += content;
            html += '        <div class="btn-group pull-right">';
            html += '            <a href="#" class="btn btn-xs btn-default m-r-xs add-subitem"><i class="fa fa-plus-square"></i></a>';
            html += '            <a class="btn btn-xs btn-default m-r-xs view-menu-item" href="'+item.path+'" target="_blank"><i class="fa fa-eye"></i></a>';
            html += '            <a href="#" class="btn btn-xs btn-default m-r-xs edit-menu-item"><i class="fa fa-pencil"></i></a>';
            html += '            <a href="#" class="btn btn-xs btn-danger delete-menu-item"><i class="fa fa-times"></i></a>';
            html += '        </div>';
            html += '    </div>';
            html += children;
            html += '</li>';

            return html;
        }
    });

    $('.nested-list#menu_list').data("nestable").__proto__.modify = function (item, modalData) {
        var listItem = this._getItemById(item.id),
            content = listItem.children('.dd3-content');

        content.contents().eq(0).get()[0].nodeValue = item.content;
        content.find('.view-menu-item').attr('href', item.path);
    };

    $('#menu_data').val(JSON.stringify($('.nested-list#menu_list').nestable('serialize')));

    listContainer.on('click', 'a.delete-menu-item', function (event) {
        event.preventDefault();

        var itemId = $(this).closest('.dd-item').attr('data-id');

        swal({
            title: "Вы уверены?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Отмена",
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Да, удалить",
            closeOnConfirm: true
        }, function () {
            listContainer.nestable('remove', itemId);

            $('#menu_data').val(JSON.stringify($('.nested-list#menu_list').nestable('serialize')));

            if ($('#menu_list .dd-list li').length === 0) {
                $('#menu_list .dd3-empty').show();
            }
        });
    });

    listContainer.on('click', 'a.add-subitem', function (event) {
        event.preventDefault();

        addItem($(this).closest('.dd-item').attr('data-id'));
    });

    listContainer.on('click', 'a.edit-menu-item', function (event) {
        event.preventDefault();

        var itemData = JSON.parse($(this).closest('.dd-item').attr('data-modal'));

        Object.assign(Admin.modals.menuItemModal.$data, itemData);
        Admin.modals.menuItemModal.action = 'edit';

        $('#menu_item').val(itemData.fields.type).trigger('change');
        modalFieldsControl('option[value='+itemData.fields.type+']');

        $('#add_item_modal').modal();
    });

    $('#suggestion').autocomplete('setOptions', {
        onSelect: function (suggestion) {
            var val = suggestion.data;

            Admin.modals.menuItemModal.fields.suggestion = (val.title) ? val.title : '';
            Admin.modals.menuItemModal.fields.title = Admin.modals.menuItemModal.fields.suggestion;
            Admin.modals.menuItemModal.fields.path = (val.path) ? val.path : '';
            Admin.modals.menuItemModal.fields.cssClass = '';

            Admin.modals.menuItemModal.item.id = (val.id) ? val.id : '';
            Admin.modals.menuItemModal.item.type = (val.type) ? val.type : '';
        }
    });

    $('#menu_item').on('select2:select', function (e) {
        $.each(Admin.modals.menuItemModal.fields, function (key) {
            Admin.modals.menuItemModal.fields[key] = '';
        });

        Admin.modals.menuItemModal.fields.type = e.params.data.id;

        modalFieldsControl(e.params.data.element);
    });
});

function addItem(parentId) {
    resetModal();

    Admin.modals.menuItemModal.action = 'create';
    Admin.modals.menuItemModal.menuItem.id = UUID.generate();
    Admin.modals.menuItemModal.menuItem.parent_id = parentId;

    $('#add_item_modal').modal();
}

function resetModal() {
    Object.assign(Admin.modals.menuItemModal.$data, getDefaultModalData());

    $('#menu_item').val(null).trigger('change');

    $('.menu-item-data').slideUp();
    $('.suggestions').slideUp();

    $('#add_item_modal').modal('hide');
}

function modalFieldsControl(element) {
    $('.menu-item-data').slideDown();

    var selectedOption = $(element),
        suggestionsRoute = selectedOption.attr('data-suggestions'),
        menuItemType = selectedOption.val(),
        suggestionField = $('#suggestion'),
        suggestionWrapper = suggestionField.closest('.suggestions');

    if (menuItemType === 'separator') {
        $('.menu-item-additional').slideUp();
        Admin.modals.menuItemModal.fields.title = String('---');
    } else {
        $('.menu-item-additional').slideDown();
    }

    if (menuItemType !== 'separator' && menuItemType !== 'link') {
        $('#menu_item_path').attr('disabled', true);
    } else {
        $('#menu_item_path').attr('disabled', false);
    }

    if (typeof suggestionsRoute !== 'undefined') {
        suggestionField.autocomplete('setOptions', {
            serviceUrl: route(suggestionsRoute)
        });
        suggestionWrapper.slideDown();
    } else {
        suggestionWrapper.slideUp();
    }
}

function getDefaultModalData() {
    var defaultData = {
        action: '',
        fields: {
            type: '',
            suggestion: '',
            title: '',
            path: '',
            cssClass: ''
        },
        item: {
            id: '',
            type: ''
        },
        menuItem: {
            id: '',
            parent_id: undefined,
            content: '',
            path: ''
        }
    };

    return JSON.parse(JSON.stringify(defaultData));
}
