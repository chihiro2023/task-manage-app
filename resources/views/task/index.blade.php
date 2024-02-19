<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>タスク管理アプリ</title>
    <link rel="stylesheet" type="text/css" href="{{ secure_asset('css/style.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/ress/dist/ress.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> 
    <script src="../js/script.js"></script>
</head>
<body>
    <header id="header" class="wrapper">

        <h1 id="site-logo">
            <a href="/task"><img src="{{ asset('img/logo.png') }}" alt="ToDoList"></a>
        </h1>
        <ul id="header-list">
        @guest
            <li><a href="{{ route('login') }}">ログイン</a></li>
            <li><a href="{{ route('register') }}">登録</a></li>
        @endguest
        @auth
            <li>
                <form method="post" name="logout" action="{{ route('logout') }}">
                    @csrf
                    <a href="javascript:logout.submit()">ログアウト</a>
                </form>
            </li>
        @endauth
        </ul>
        @auth<span id="user-name">{{ Auth::user()->name }} さん</span>@endauth
        @if (session('feedback.success'))
            <p id ="feedback">{{ session('feedback.success') }}</p>
        @endif
    </header>


    <main id="main">
    @guest
        <section id="introduction">
            <div class="introduction-item"><img src="{{ asset('img/introduction.png') }}" alt=""></div>
            <div class="introduction-item">
                <h1 id="site-title">シンプルなタスク管理アプリ</h1>
                <p id="site-description">シンプルな設計と直感的な操作で生活をもっと快適に<br>タスクの設定、タスクの確認、進捗状況の整理をいつでもどこでも</p>
                <a id="register-button" class="btn" href="{{ route('register') }}">始める</a>
                <a id ="login-button" class="btn" href="{{ route('login') }}">ログイン</a>
            </div>
        </section>
    @endguest
    @auth
        <section id="task" class="wrapper">
            <div class="task-items">
            @foreach ($tasks as $task)
                <div class="task-item">
                    <div class="task-content">
                        <p>{{$task->content}}</p>
                    </div>
                    <div class="task-deadline">
                        <p>{{$task->deadline}}</p>
                    </div>
                    <div class="task-completed">
                        <form method='POST' action="{{ route('task.delete', ['taskId' => $task->id]) }}">
                            @method('DELETE')
                            @csrf
                            <button type='submit'  name="id" value="{{ $task->id }}">✓</button>
                        </form>
                    </div>
                </div>
                @if ($loop->iteration == $overdueCount)
                    <div class="line">
                        <span style="color: red">遅延</span><hr>
                    </div>
                @elseif ($loop->iteration == $untilTodayCount)
                    <div class="line">
                        <span>今日</span><hr>
                    </div>
                @elseif ($loop->iteration == $untilTomorrowCount)
                    <div  class="line">
                        <span>明日</span><hr>
                    </div>
                @endif
            @endforeach
            </div>

            <div class="task-add">
                <form method="POST" action="{{ route('task.create') }}">
                    @csrf
                    <div class="task-item">
                        <div class="task-content">
                            <input type="text" maxlength=25 placeholder="タスクを追加 (最大25文字)" name="content" required>
                        </div>
                        <div class="task-deadline">
                            <input type="date"  min="@php echo date('Y-m-d'); @endphp" name="deadline" value="@php echo date('Y-m-d'); @endphp" required timezone="Asia/Tokyo">
                        </div>
                        <div class="task-submit">
                            <button type="submit">＋</button>
                            
                        </div>
                    </div>
                </form>
            </div>
        </section>
    @endauth
    </main>
</body>
</html>
