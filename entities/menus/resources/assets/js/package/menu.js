import Swal from 'sweetalert2';
import { v4 as uuidv4 } from 'uuid';

export let menu = {
    init: () => {
        let $ = window.$;

        $(document).ready(function () {
            if ($('#menu_list').length > 0) {
                window.Admin.modals.menuItemModal = new window.Vue({
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
                                $('#menu_list').nestable('add', this.menuItem);
                            } else {
                                $('#menu_list').nestable('modify', this.menuItem);
                            }

                            let $item = $('.dd-item[data-id='+this.menuItem.id+']');

                            $item.data('modal', $.extend({}, this.$data));
                            $item.attr('data-modal', modalDataJSON);

                            if (this.fields.type === 'separator') {
                                $item.find('.add-subitem').hide();
                                $item.find('.view-menu-item').hide();
                            } else {
                                $item.find('.add-subitem').show();
                                $item.find('.view-menu-item').show();
                            }

                            $('#menu_data').val(JSON.stringify($('#menu_list').nestable('serialize')));

                            $('#menu_list .dd3-empty').hide();
                            $('#add_item_modal').modal('hide');
                        }
                    }
                });

                $('#add_menu_item').on('click', function (event) {
                    event.preventDefault();

                    addItem(undefined);
                });

                var listContainer = $('#menu_list');

                listContainer.nestable({
                    'dragClass': 'menu-package dd-dragel',
                    group: 1,
                    itemRenderer: function(item_attrs, content, children, options, item) {
                        var item_attrs_string = $.map(item_attrs, function(value, key) {
                            return ' ' + key + '="' + value + '"';
                        }).join(' ');

                        var html = '<li class="dd-item dd3-item" '+item_attrs_string+'>';
                        html += '    <div class="dd-handle dd3-handle"></div>';
                        html += '    <div class="dd3-content">';
                        html += content;
                        html += '        <div class="float-right">';
                        html += '            <a href="#" class="btn btn-xs btn-default m-r-xs add-subitem"><i class="fa fa-plus-square"></i></a>';
                        html += '            <a class="btn btn-xs btn-default m-r-xs view-menu-item" href="'+item.path+'" target="_blank"><i class="fa fa-eye"></i></a>';
                        html += '            <a href="#" class="btn btn-xs btn-default m-r-xs edit-menu-item"><i class="fa fa-pencil-alt"></i></a>';
                        html += '            <a href="#" class="btn btn-xs btn-danger delete-menu-item"><i class="fa fa-times"></i></a>';
                        html += '        </div>';
                        html += '    </div>';
                        html += children;
                        html += '</li>';

                        return html;
                    },
                    callback: function(l, e) {
                        $('#menu_data').val(JSON.stringify($('#menu_list').nestable('serialize')));
                    }
                });

                listContainer.nestable('collapseAll');

                $('#menu_list').data("nestable").__proto__.modify = function (item) {
                    var listItem = this._getItemById(item.id),
                        content = listItem.children('.dd3-content');

                    content.contents().eq(0).get()[0].nodeValue = item.content;
                    content.find('.view-menu-item').attr('href', item.path);
                };

                $('#menu_data').val(JSON.stringify($('#menu_list').nestable('serialize')));

                listContainer.on('click', 'a.delete-menu-item', function (event) {
                    event.preventDefault();

                    var itemId = $(this).closest('.dd-item').attr('data-id');

                    Swal.fire({
                        title: "Вы уверены?",
                        icon: "warning",
                        showCancelButton: true,
                        cancelButtonText: "Отмена",
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "Да, удалить",
                        closeOnConfirm: true
                    }).then((result) => {
                        if (result.value) {
                            listContainer.nestable('remove', itemId);

                            $('#menu_data').val(JSON.stringify($('#menu_list').nestable('serialize')));

                            if ($('#menu_list .dd-list li').length === 0) {
                                $('#menu_list .dd3-empty').show();
                            }
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

                    Object.assign(window.Admin.modals.menuItemModal.$data, itemData);
                    window.Admin.modals.menuItemModal.action = 'edit';

                    $('#menu_item').val(itemData.fields.type).trigger('change');
                    modalFieldsControl('option[value='+itemData.fields.type+']');

                    $('#add_item_modal').modal();
                });

                $('#suggestion').autocomplete({
                    type: 'POST',
                    paramName: 'q',
                    params: {
                        type: 'autocomplete'
                    },
                    minChars: 2,
                    onSelect: function (suggestion) {
                        var val = suggestion.data;

                        window.Admin.modals.menuItemModal.fields.suggestion = (val.title) ? val.title : '';
                        window.Admin.modals.menuItemModal.fields.title = window.Admin.modals.menuItemModal.fields.suggestion;
                        window.Admin.modals.menuItemModal.fields.path = (val.path) ? val.path : '';
                        window.Admin.modals.menuItemModal.fields.cssClass = '';

                        window.Admin.modals.menuItemModal.item.id = (val.id) ? val.id : '';
                        window.Admin.modals.menuItemModal.item.type = (val.type) ? val.type : '';
                    }
                });

                $('#menu_item').on('select2:select', function (e) {
                    $.each(window.Admin.modals.menuItemModal.fields, function (key) {
                        window.Admin.modals.menuItemModal.fields[key] = '';
                    });

                    window.Admin.modals.menuItemModal.fields.type = e.params.data.id;

                    modalFieldsControl(e.params.data.element);
                });
            }

            function addItem(parentId) {
                resetModal();

                window.Admin.modals.menuItemModal.action = 'create';
                window.Admin.modals.menuItemModal.menuItem.id = uuidv4();
                window.Admin.modals.menuItemModal.menuItem.parent_id = parentId;

                $('#add_item_modal').modal();
            }

            function resetModal() {
                Object.assign(window.Admin.modals.menuItemModal.$data, getDefaultModalData());

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
                    window.Admin.modals.menuItemModal.fields.title = String('---');
                } else {
                    $('.menu-item-additional').slideDown();
                }

                if (menuItemType !== 'separator' && menuItemType !== 'link') {
                    $('#menu_item_path').attr('disabled', true);
                } else {
                    $('#menu_item_path').attr('disabled', false);
                }

                if (typeof suggestionsRoute !== 'undefined') {
                    $('#suggestion').autocomplete('setOptions', {
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
        });
    }
};
