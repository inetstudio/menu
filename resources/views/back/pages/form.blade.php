@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Редактирование меню' : 'Создание меню';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.menu::back.partials.breadcrumbs.form')
    @endpush

    <div class="wrapper wrapper-content">
        <div class="ibox">
            <div class="ibox-title">
                <a class="btn btn-sm btn-white" href="{{ route('back.menu.index') }}">
                    <i class="fa fa-arrow-left"></i> Вернуться назад
                </a>
            </div>
        </div>

        {!! Form::info() !!}

        {!! Form::open(['url' => (!$item->id) ? route('back.menu.store') : route('back.menu.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data']) !!}

            @if ($item->id)
                {{ method_field('PUT') }}
            @endif

            {!! Form::hidden('menu_id', (! $item->id) ? '' : $item->id, ['id' => 'object-id']) !!}

            {!! Form::hidden('menu_type', get_class($item), ['id' => 'object-type']) !!}

            <div class="ibox">
                <div class="ibox-title">
                    {!! Form::buttons('', '', ['back' => 'back.menu.index']) !!}
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="panel-group float-e-margins" id="mainAccordion">

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain" aria-expanded="true">Основная информация</a>
                                        </h5>
                                    </div>
                                    <div id="collapseMain" class="collapse show" aria-expanded="true">
                                        <div class="panel-body">

                                            {!! Form::string('name', $item->name, [
                                                'label' => [
                                                    'title' => 'Название',
                                                ],
                                            ]) !!}

                                            {!! Form::string('alias', $item->alias, [
                                                'label' => [
                                                    'title' => 'Алиас',
                                                ],
                                            ]) !!}

                                        </div>
                                    </div>
                                </div>

                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h5 class="panel-title">
                                            <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMenu" aria-expanded="true">Пункты меню</a>
                                        </h5>
                                    </div>
                                    <div id="collapseMenu" class="collapse show" aria-expanded="true">
                                        <div class="panel-body">

                                            <div class="col-lg-12">
                                                <div class="ibox float-e-margins">
                                                    <div class="ibox-title">
                                                        <button class="btn btn-sm btn-primary" id="add_menu_item">Добавить</button>
                                                    </div>
                                                    <div class="ibox-content">

                                                        {!! Form::hidden('menu_data', '', [
                                                            'id' => 'menu_data',
                                                        ]) !!}

                                                        <div class="menu-package dd" id="menu_list" data-order-serialize="#menu_data">
                                                            @if (isset($tree) && count($tree) > 0)
                                                                <ol class="dd-list">
                                                                    @foreach ($tree as $item)
                                                                        @include('admin.module.menu::back.partials.tree.menu', $item)
                                                                    @endforeach
                                                                </ol>
                                                            @else
                                                                <ol class="dd-list">

                                                                </ol>
                                                                <div class="dd3-empty">
                                                                    <span><i class="fa fa-list-ul"></i> Список пуст</span>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="ibox-footer">
                    {!! Form::buttons('', '', ['back' => 'back.menu.index']) !!}
                </div>
            </div>

        {!! Form::close()!!}
    </div>

    @include('admin.module.menu::back.modals.add_menu_item')
@endsection
