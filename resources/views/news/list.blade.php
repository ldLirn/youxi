@extends('layouts.home')
<link href="{{asset(HOME_CSS.'news.css') }}" rel="stylesheet" type="text/css">
@section('content')
    <article class="wrap clear_both">
        <aside class="sidebar left">
            <ul>
                @foreach($cat_data as $k=>$v)
                <li class="@if(FilterManager::isActive('cat', $v['id'])) current @endif"><a href="{{FilterManager::url('cat', $v['id'])}}" class="benzhan">{{$v['cat_name']}}</a></li>
                @endforeach
            </ul>
        </aside>
        <section>


            <div class="connect left">
                <div class="title">
                    {{$cat_name}}
                </div>
                <div class="connect-ner">
                    <ul class="list">
                        @foreach($data as $v)
                        <li>
                            <a href="{{url('/news/detail/'.Hashids::encode($v->id))}}">
                                {{$v->title}}
                            </a>
                        <span class="date">
                            {{$v->created_at}}
                        </span>
                        </li>
                        @endforeach
                    </ul>
                    <div class="page clear_both">
                        @if(isset($page_path))
                            {{$data->appends($page_path)->links()}}
                        @else
                            {{$data->links()}}
                        @endif
                    </div>
                </div>
            </div>

        </section>
    </article>
@endsection