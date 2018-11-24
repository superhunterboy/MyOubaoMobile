<div class="item-detail user-link-list">
    <table width="100%" class="table table-toggle" id="J-table">
        <thead>
            <tr>
                <th class="text-center">渠道</th>
                <th>连接</th>
                <th>注册人数</th>
                <th>开户类型</th>
                <th>状态</th>
                <th>生成时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($datas as $data)
            <tr class=" table-tr-item ">
                <td class="text-center">{{ $data->channel }} </td>
                <td><input type="text" class="input w-3" value="{{ $data->url }}" /></td>
                <td><a href="{{ route('user-link-users.index', ['register_link_id' => $data->id]) }}">{{ $data->created_count }}</a></td>
                <td>{{ $data->{$aListColumnMaps['is_agent']} }}</td>
                <td>{{ $data->{$aListColumnMaps['status']} }}</td>
                <td>{{ $data->created_at }}</td>
                <td>
                    <a class="ui-action-check" href="{{ route('user-links.view', $data->id) }}">详情</a>
                    @if($data->status == 0)
                    <a class="ui-action-delete confirmDelete" href="javascript:void(0);" url="{{ route('user-links.destroy', $data->id) }}">删除</a>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>