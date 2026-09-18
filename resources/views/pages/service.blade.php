@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => '產品與服務 | 泰權興貿易'])

@section('content')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261549360000001.jpg', 'heading' => '產品與服務', 'en' => 'SERVICE'])

    <section class="page-section">
        <div class="wrap service-grid">
            @foreach ([
                ['1ca230dbe0248c640c36c5ea409365ef-Sxoq.jpg', 'MFE｜鋁合金系統模板', '買賣、承包、代工、租賃、設計、復新、倉儲、物流等一站式服務。與世界知名模板龍頭【DOKA】、【MFE】代理合作。', [['https://www.mfeformwork.com/', 'MFE >'], ['https://www.youtube.com/watch?v=nSSPhGvtiI4', 'youtube >']]],
                ['9d74f3ce016586d9c4ac30ec81e9b73c-I2ba.jpg', 'NIPPON PAINT X CMI｜水泥複合材料', '代理銷售【NIPPON PAINT CMI】一流產品，主要業務為防水系統、牆面系統、修護系統。', [['https://www.cmimalaysia.com.my/about-us/', '連結 >']]],
                ['1065900e3c58b71d4cf1bfe2155be7f8-Jp97.jpg', '易塗｜斷熱稀土材料', '針對建築物的被動節能技術，在玻璃、金屬、混凝土表面達到減碳效果。', [['http://easyto1098.com/', '連結 >']]],
                ['e8739c5fdf508bb812ecfcf55bfdd863-NyYR.jpg', '石墨烯｜原料及應用材料', '與安炬科技合作，共同研發、生產及應用推廣。', [['https://www.graphene.com.tw/home.php', '連結 >']]],
                ['365bd4467f92c7c59fd98dd9e11bdf97-6v2Y.jpg', 'UHPC水泥／混凝土材料', '具有高抗壓、高抗彎、高耐候等特性。', []],
                ['0b4d1a5543fcfa7c4cdf5e78b1f603e6-yY2m.jpg', '地工科技｜支盤樁', '與北京支盤地工技術合作代理，承載與控沉能力優於美規摩擦樁技術。', []],
                ['cce4b0da87d888322a8bf01ef4f36acb-Ul6Y.png', '防水塗料｜建築防水', '與西偉德悍能技術合作，為住宅、商業建築與大型工程提供防水解決方案。', [['https://www.hahne.cn/', '連結 >']]],
                ['8c454ef39e213ac84d23c8b030c327bf-ZYRy.png', '室內設計材料｜建築室內應用', '與德國 TECE 技術合作，導入歐洲先進室內建築系統。', [['https://www.tece.com/cn', '連結 >']]],
            ] as $svc)
                <article class="service-card">
                    <img src="{{ $a }}/upload/image/{{ $svc[0] }}" alt="{{ $svc[1] }}">
                    <h3>{{ $svc[1] }}</h3>
                    <p>{!! $svc[2] !!}</p>
                    @foreach ($svc[3] as $link)
                        <a href="{{ $link[0] }}" target="_blank" rel="noopener">{{ $link[1] }}</a>
                    @endforeach
                </article>
            @endforeach
        </div>
    </section>
@endsection
