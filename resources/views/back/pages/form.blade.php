@extends('admin::back.layouts.app')

@php
    $title = ($item->id) ? 'Редактирование меню' : 'Добавление меню';
@endphp

@section('title', $title)

@section('content')

    @push('breadcrumbs')
        @include('admin.module.menu::back.partials.breadcrumbs.form')
    @endpush

    <div class="row m-sm">
        <a class="btn btn-white" href="{{ route('back.menu.index') }}">
            <i class="fa fa-arrow-left"></i> Вернуться назад
        </a>
    </div>

    <div class="wrapper wrapper-content">

        {!! Form::info() !!}

        {!! Form::open(['url' => (!$item->id) ? route('back.menu.store') : route('back.menu.update', [$item->id]), 'id' => 'mainForm', 'enctype' => 'multipart/form-data', 'class' => 'form-horizontal']) !!}

            @if ($item->id)
                {{ method_field('PUT') }}
            @endif

            {!! Form::hidden('menu_id', (!$item->id) ? '' : $item->id) !!}

            <div class="row">
                <div class="col-lg-12">
                    <div class="panel-group float-e-margins" id="mainAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#mainAccordion" href="#collapseMain" aria-expanded="true">Основная информация</a>
                                </h5>
                            </div>
                            <div id="collapseMain" class="panel-collapse collapse in" aria-expanded="true">
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
                    </div>
                    <div class="panel-group float-e-margins" id="menuAccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#menuAccordion" href="#collapseMenu" aria-expanded="true">Пункты меню</a>
                                </h5>
                            </div>
                            <div id="collapseMenu" class="panel-collapse collapse in" aria-expanded="true">
                                <div class="panel-body">

                                    <div class="col-lg-12">
                                        <div class="ibox float-e-margins">
                                            <div class="ibox-title">
                                                <button class="btn btn-sm btn-primary btn-lg" id="add_menu_item">Добавить</button>
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

            {!! Form::buttons('', '', ['back' => 'back.menu.index']) !!}

        {!! Form::close()!!}
    </div>

    @include('admin.module.menu::back.modals.add_menu_item')
@endsection
