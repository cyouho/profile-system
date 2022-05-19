<main class="container">
    <div class="jumbotron p-4 p-md-5 text-blue rounded bg-blue">
        <div>
            <a class="title-text">
                修改用户名:
            </a><br><br>
            <form method="post" action="/resetUserName">
                @csrf
                <input type="hidden" id="userId" name="userId" value="{{ $page_data['setting_data']['user_id'] }}" />
                <div class="form-group">
                    <input type="text" class="form-control mb-2 mr-sm-2" placeholder="新用户名" id="newUserName" name="newUserName">
                </div>
                @error('newUserName')
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ $message }}
                </div>
                @enderror
                <button type="submit" class="btn btn-blue mb-2">提交修改</button>
            </form>
        </div>
    </div>
</main>