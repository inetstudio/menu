<li class="dd-item dd3-item" data-id="{{ $item['data']['menuItem']['id'] }}" data-modal="{{ json_encode($item['data']) }}">
    <div class="dd-handle dd3-handle">Drag</div>
    <div class="dd3-content">
        {{ $item['data']['menuItem']['content'] }}
        <div class="btn-group pull-right">
            <a href="#" class="btn btn-xs btn-default m-r-xs add-subitem" style="{{ ($item['data']['fields']['type'] == 'separator') ? 'display:none' : '' }}"><i class="fa fa-plus-square"></i></a>
            <a class="btn btn-xs btn-default m-r-xs view-menu-item" href="{{ $item['data']['menuItem']['path'] }}" target="_blank" style="{{ ($item['data']['fields']['type'] == 'separator') ? 'display:none' : '' }}"><i class="fa fa-eye"></i></a>
            <a href="#" class="btn btn-xs btn-default m-r-xs edit-menu-item"><i class="fa fa-pencil-alt"></i></a>
            <a href="#" class="btn btn-xs btn-danger delete-menu-item"><i class="fa fa-times"></i></a>
        </div>
    </div>
    @if (count($item['items']) > 0)
        <ol class="dd-list">
            @foreach($item['items'] as $item)
                @include('admin.module.menu::back.partials.tree.menu', $item)
            @endforeach
        </ol>
    @endif
</li>
