@extends('layouts.home')
<link href="{{asset(HOME_CSS.'news.css') }}" rel="stylesheet" type="text/css">
@section('content')
    <article class="wrap clear_both">
        <aside class="sidebar left">
            <ul>
                @foreach($cat_data as $k=>$v)
                <li class="@if($data['cat_id']==$v['id']) current @endif"><a href="{{url('/news?cat='.$v['id'])}}" class="benzhan">{{$v['cat_name']}}</a></li>
                @endforeach
            </ul>
        </aside>
        <section>

            <div class="connect left">
                <div class="connect-ner">
                    <div class="" style=" text-align:center; font-size:24px; margin:12px 0px;">
                        {{$data['title']}} <br>
                        <span style=" font-size:14px; line-height:24px; color:#999999;">{{$data['created_at']}}</span>
                    </div>
                    <div class="text">
                        {!! $data['content'] !!}
                    </div>
                </div>
            </div>

        </section>
    </article>
@endsection