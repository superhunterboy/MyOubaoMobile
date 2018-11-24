@extends('l.base')

@section('styles')
@parent
<style type="text/css">
    body{background:transparent;}
    .content{height:350px;overflow:auto;}
    .table{width:99%;margin:0 auto;/*border:1px solid #c8d0d6;*/}
    .table td{border:1px solid #d3d3d3;}
    .table td,.table th{text-align:center;}
    /*.table thead{position:fixed;}*/
    .table thead th:first-child,
    .table tbody th:first-child{border-left:1px solid #c8d0d6;}
    .table thead th:last-child,
    .table tbody th:last-child{border-right:1px solid #c8d0d6;}
</style>
@stop

@section('container')
<div class="content">
<table class="table table-rowspan">
    <thead>
        <tr>
            <th>玩法群</th>
            <th>玩法组</th>
            <th>玩法</th>
            <th>奖级</th>
            <th>奖金</th>
        </tr>
    </thead>
    <tbody>
    @if (isset($aLotteriesPrizeSetsTable))
        @foreach ( $aLotteriesPrizeSetsTable as $oWayGroup )
            @foreach ( $oWayGroup->children as $key1 => $oWay )
                @foreach ( $oWay->children as $key2 => $oMethod )
                <?php $aPrizes = explode(',', $oMethod->prize); rsort($aPrizes); ?>
                    @foreach ( $aPrizes as $key3 => $fPrizeLevel )
                    <tr>
                        @if ($key1 == 0 && $key2 == 0 && $key3 == 0)
                        <td rowspan="{{ $oWayGroup->count }}">{{ $oWayGroup->name_cn }}</td>
                        @endif
                        @if ($key2 == 0 && $key3 == 0)
                        <td rowspan="{{ $oWay->count }}">{{ $oWay->name_cn }}</td>
                        @endif
                        @if ($key3 == 0)
                        <td rowspan="{{ $oMethod->count }}">{{ $oMethod->name_cn }}</td>
                        @endif
                        <td>{{ $oMethod->count > 1 ? $aPrizeLevel[$key3] : '' }}</td>
                        <td>{{ number_format($fPrizeLevel, 2) }}</td>
                    </tr>
                    @endforeach
                @endforeach
            @endforeach
        @endforeach
    @endif
    </tbody>
</table>
</div>
@stop