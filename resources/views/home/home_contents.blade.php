<main class="container">
    <div class="jumbotron p-4 p-md-5 text-blue rounded bg-blue">
        <div>
            <a class="title-text">
                个人信息:
            </a>
            <br><br>
            @include('home.home_profile')
        </div>
    </div>
    <div class="jumbotron p-4 p-md-5 text-blue rounded bg-blue">
        <div>
            <a class="title-text">
                已注册服务:
            </a>
            <br><br>
            @include('home.home_servers')
        </div>
    </div>
</main>