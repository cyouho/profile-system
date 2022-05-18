<div class="row">
    <div class="col text-center">
        <h5>用户名</h5>
        <h2>{{ $page_data['profile_data']['user_name'] }}</h2>
    </div>
    <div class="col text-center">
        <h5>注册时间</h5>
        <h2>{{ date('Y-m-d', strtotime($page_data['profile_data']['created_at'])) }}</h2>
    </div>
    <div class="col text-center">
        <h5>最后登录时间</h5>
        <h2>{{ date('Y-m-d', strtotime($page_data['profile_data']['last_login_at'])) }}</h2>
    </div>
</div>