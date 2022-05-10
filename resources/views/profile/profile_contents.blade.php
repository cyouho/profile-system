<main class="container">
    <div class="jumbotron p-4 p-md-5 text-blue rounded bg-blue">
        <div>
            <a class="title-text">
                个人信息:
            </a>
            <br><br>
            @include('profile.profile_data')
        </div>
    </div>
    <div class="jumbotron p-4 p-md-5 text-blue rounded bg-blue">
        <div>
            <a class="title-text">
                已注册服务:
            </a>
            <br><br>
            @include('profile.profile_servers')
        </div>
    </div>
</main>