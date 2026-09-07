@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => '案例實績 | 泰權興貿易'])

@section('header')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261546490000001.jpg', 'heading' => '案例實績', 'en' => 'CASE'])
@endsection

@section('content')
    <section class="n_bg">
        <div class="container-md">
            <div class="row gx-5">
                <div class="col-lg-12">
                    <div class="news_list">
                        <ul>
                            <li class="active"><a href="{{ route('case') }}">全部</a></li>
                            <li><a href="{{ route('case') }}">MFE 鋁合金系統模板</a></li>
                            <li><a href="{{ route('case') }}">易塗｜斷熱稀土材料</a></li>
                            <li><a href="{{ route('case') }}">地工科技｜支盤樁</a></li>
                        </ul>
                    </div>
                </div>
                @foreach ([
                    ['2501082001580000001.jpg', '地工科技｜支盤樁', '邊坡錨固及搶險工程'],
                    ['2501082001410000001.jpg', '地工科技｜支盤樁', '瀋陽至海口國家高速公路茂湛段改擴建工程'],
                    ['2501082001220000001.jpg', '地工科技｜支盤樁', '擠擴錨桿監測'],
                    ['2408081438400000001.jpg', 'MFE 鋁合金系統模板', '根基營造 泰山貴和安居 | RC | 台灣新北市'],
                    ['2501071807320000001.jpg', 'MFE 鋁合金系統模板', '8 Conlay | RC | 馬來西亞 Kuala Lumpur'],
                    ['2501082022490000001.JPG', 'MFE 鋁合金系統模板', 'Cayan Tower | RC | Dubai杜拜'],
                ] as $item)
                    <div class="col-lg-6">
                        <div class="case_items">
                            <img src="{{ $a }}/upload/product/{{ $item[0] }}" class="img-fluid" alt="{{ $item[2] }}">
                            <div class="case_box">
                                <span>{{ $item[1] }}</span>
                                <h3>{{ $item[2] }}</h3>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
