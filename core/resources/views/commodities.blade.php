@extends('layouts.auth') @section('content')
@php
$type = null;
@endphp

<div class="page-content ">
  <div class="content content-commodities">
    @foreach($commodities as $commodity)
      @if($type != $commodity->commodity_type_id)
        <h2 class="commodity-title">{{ $comms[$commodity->commodity_type_id] }}</h2>
        @php
          $type = $commodity->commodity_type_id;
        @endphp
      @endif
      @php
        $data = json_decode($commodity->data, true);
      @endphp
      @if(isset($data['dataset']) && count($data['dataset']['data']) > 0)
      <div class="commodity">
        <h3 class="commodity-name" title="{{ $data['dataset']['name'] }}">{{ $commodity->name }}</h3>
        <ul class="commodity-data">
          @foreach(array_slice($data['dataset']['data'], 0, 6) as $d)
            @if(count($d[1]) > 0) <li><span class="commodity-date">{{ $d[0] }}</span> <span class="commodity-value">{{ round($d[1], 2) }}</span></li> @endif
          @endforeach
        </ul>
      </div>
      @endif
    @endforeach

    <!-- <div class="responsive-iframe">
      <iframe height="400" scrolling="no" src="https://www.dailyforex.com/forex-widget/widget/29617" style="width: 500px; height:400px; display: block;border:0px;overflow:hidden;" width="500"></iframe><span style="position:relative;display:block;text-align:center;color:#333333;width:500px;font-family:Tahoma,sans-serif;font-size:10px;">Live commodities widget is provided by <a style="color:#333333;" href="https://www.dailyforex.com" rel="nofollow" style="font-size: 10px;" target="_blank">DailyForex.com</a> - Forex Reviews and News</span>
    </div> -->

  </div>
</div>

@endsection
