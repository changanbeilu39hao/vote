<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="stylesheet" type="text/css" href="images/index.css"/>
    <script type="text/javascript" src="images/index.js" ></script>
    <!-- Fonts -->
    {{-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet"> --}}

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
		<div class="top"> 
			<p>四川森林草原防灭火安全教育手抄报征集活动初选平台&评分平台</p>
			<div class="top_r">
                @guest
                <span>未登录</span>
                @else    
                <span>
                    @switch(Auth::user()->group_id)
                    @case(1)
                    小学1-3年级组
                    @break
                    @case(2)
                    小学4-6年级组
                    @break

                    @case(3)
                    初中组
                    @break
                    
                    @default
                        
                @endswitch
            </span>
                <span>{{ Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" id="del">
                    {{ csrf_field() }}
                <a href="#" onclick="document.getElementById('del').submit();return false;">退出登录</a>
                </form>
                @endguest   

			</div>
		</div>
		

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
