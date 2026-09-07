@php $a = asset('assets/taigreat'); @endphp
@extends('layouts.site', ['title' => '服務項目 | 泰權興貿易'])

@section('header')
    @include('partials.page-banner', ['image' => 'upload/banner_page/2407261549360000001.jpg', 'heading' => '服務項目', 'en' => 'SERVICE'])
@endsection

@section('content')
    <section class="s_bg">
        <div class="container-md">
            <div class="row">
                <div class="col-lg-12">
                    <div class="service_title"><h3>服務項目</h3></div>
                </div>
                @foreach ([
                    ['1ca230dbe0248c640c36c5ea409365ef-Sxoq.jpg', '1.', 'MFE｜鋁合金系統模板', '買賣、承包、代工、租賃、設計、復新、倉儲、物流等一站式服務。 與世界知名模板龍頭【DOKA】、【MFE】代理合作。 在台灣自1991年起，至今工程經驗超過34年，擁有台灣及國際超過53+國家的工程實績。<br>2025年以ISO 14067：2018 及PCF(碳足跡)認證為目標。', [['https://www.mfeformwork.com/', 'MFE >'], ['https://www.youtube.com/watch?v=nSSPhGvtiI4', 'youtube >']]],
                    ['9d74f3ce016586d9c4ac30ec81e9b73c-I2ba.jpg', '2.', 'NIPPON PAINT X CMI｜水泥複合材料', '代理銷售施工世界知名品牌【NIPPON PAINT 立邦塗料】旗下合資公司 【NIPPON PAINT CMI】 之一流產品。<br>主要業務為防水系統、牆面系統、修護系統。', [['https://www.cmimalaysia.com.my/about-us/', '連結 >']]],
                    ['1065900e3c58b71d4cf1bfe2155be7f8-Jp97.jpg', '3.', '易塗｜斷熱稀土材料', '與【中國BRIRE稀土研究院】、【中稀易塗科技發展公司】代理合作。<br>針對建築物的被動節能技術，在玻璃、金屬、混凝土表面，透過不同規格產品皆能達到令人驚豔的效果，為減碳工作做出貢獻。<br>現已發展出可直接添加在各類樹脂塗料載體中的原料，將成為品質穩定、成本可控的添加材料。', [['http://easyto1098.com/', '連結 >']]],
                    ['e8739c5fdf508bb812ecfcf55bfdd863-NyYR.jpg', '4.', '石墨稀｜原料及應用材料生產及應用', '與具有領先世界的一流生產技術且無環境污染的台灣企業【安炬科技】合作。<br>共同研發、生產及應用推廣。<br>具有導熱、導電、強度等材料特性。在儲能電池、3C產業、水泥產業具優質特性。', [['https://www.graphene.com.tw/home.php', '連結 >']]],
                    ['365bd4467f92c7c59fd98dd9e11bdf97-6v2Y.jpg', '5.', 'UHPC水泥/混凝土材料｜生產及應用', '具有高抗壓、高抗彎、高耐候等特性', []],
                    ['0b4d1a5543fcfa7c4cdf5e78b1f603e6-yY2m.jpg', '6.', '地工科技｜支盤樁', '與【北京支盤地工】技術合作代理，支盤樁承載能力、控沉止沉能力勝過美規摩擦樁技術。', []],
                    ['cce4b0da87d888322a8bf01ef4f36acb-Ul6Y.png', '7.', '防水塗料｜建築防水', '與【西偉德悍能】技術合作代理，結合專業建築防水工法與高品質防水材料，為住宅、商業建築、工業廠房及大型工程提供完整的防水解決方案。<br><br>我們專注於建築防水系統規劃，從基礎結構、外牆、屋頂、浴室、地下室到各類特殊施工區域，皆能依據不同環境條件與工程需求，提供最適合的防水材料與施工建議。', [['https://www.hahne.cn/', '連結 >']]],
                    ['8c454ef39e213ac84d23c8b030c327bf-ZYRy.png', '8.', '室內設計材料｜建築室內應用', '與【德國TECE】技術合作代理，導入歐洲先進室內建築系統與牆體結構技術，為住宅、商業空間、飯店及大型建築工程提供高效且現代化的室內應用解決方案。<br><br>我們專注於建築室內牆體系統規劃，透過輕量化結構設計與模組化施工方式，有效提升施工效率、縮短工期，並降低現場施工複雜度。', [['https://www.tece.com/cn', '連結 >']]],
                ] as $svc)
                    <div class="col-lg-4 col-sm-6">
                        <div class="service_items">
                            <img src="{{ $a }}/upload/image/{{ $svc[0] }}" class="img-fluid" alt="{{ $svc[2] }}">
                            <i>{{ $svc[1] }}</i>
                            <h3>{{ $svc[2] }}</h3>
                            <p>{!! $svc[3] !!}</p>
                            @foreach ($svc[4] as $link)
                                <a href="{{ $link[0] }}" target="_blank" rel="noopener">{{ $link[1] }}</a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
