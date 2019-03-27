@pushonce('modals:edit_image')
    <div id="add_item_modal" tabindex="-1" role="dialog" aria-hidden="true" class="modal inmodal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Закрыть</span></button>
                    <h1 class="modal-title">Пункт меню</h1>
                </div>

                <div class="modal-body">
                    {!! Form::dropdown('menu_item', [], [
                        'label' => [
                            'title' => 'Тип пункта',
                        ],
                        'field' => [
                            'class' => 'select2 form-control',
                            'data-placeholder' => 'Выберите тип',
                            'style' => 'width: 100%',
                            'v-model' => 'fields.type',
                        ],
                        'options' => [
                            'values' => array_merge([null => ''], (config('menu.menuable')) ? collect(config('menu.menuable'))->mapWithKeys(function ($item) {
                                return [$item['type'] => $item['title']];
                            })->toArray() : [],[
                                'link' => 'Ссылка',
                                'separator' => 'Разделитель',
                            ]),
                            'attributes' => (config('menu.menuable')) ? collect(config('menu.menuable'))->mapWithKeys(function ($item) {
                                return [
                                    $item['type'] => [
                                        'data-suggestions' => $item['suggestions'],
                                    ]
                                ];
                            })->toArray() : [],
                        ],
                    ]) !!}

                    <div class="suggestions has-warning">
                        {!! Form::string('suggestion', '', [
                            'label' => [
                                'title' => '',
                            ],
                            'field' => [
                                'data-search' => '',
                                'placeholder' => 'Введите название страницы',
                                'id' => 'suggestion',
                                'v-model' => 'fields.suggestion',
                            ],
                        ]) !!}
                    </div>

                    <div class="menu-item-data">
                        <div class="menu-item-additional">
                            {!! Form::string('menu_item_title', '', [
                                'label' => [
                                    'title' => 'Заголовок',
                                ],
                                'field' => [
                                    'v-model' => 'fields.title',
                                ],
                            ]) !!}

                            {!! Form::string('menu_item_path', '', [
                                'label' => [
                                    'title' => 'Ссылка',
                                ],
                                'field' => [
                                    'v-model' => 'fields.path',
                                ],
                            ]) !!}
                        </div>

                        {!! Form::string('menu_item_css_class', '', [
                            'label' => [
                                'title' => 'CSS класс',
                            ],
                            'field' => [
                                'v-model' => 'fields.cssClass',
                            ],
                        ]) !!}
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Закрыть</button>
                    <a href="#" class="btn btn-primary" @click.prevent="save">Сохранить</a>
                </div>
            </div>
        </div>
    </div>
@endpushonce
