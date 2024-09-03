<?php
    require_once("News.php");

    function max_count()
    {
        require_once("MySqlReader.php");

        $r = new MySqlReader();
        return $r->countRows();
    }

    function printBanner(int $n)
    {
        $news = new News($n);

        $text = $news->getAnnounce();
        $img = $news->getImage();
        $title = $news->getTitle();

        print <<< _HTML_
            <div class = "banner">
                <img src = "images/$img">
                <text>
                    <h1>$title</h1>
                    $text
                </text>
            </div>
        _HTML_;
    }

    function printNewsList()
    {
        $page = 0;
        $maxNewsElems = 4;

        if (isset($_GET['page']))
        {
            $page = $_GET['page'] - 1;
        }

        print <<< _HTML_
            <div class = "news-block">
                <h2>Новости</h2>
                <div class = "news-list">
        _HTML_;

        for ($i = 0; $i < $maxNewsElems; $i++)
        {
            $num = $page * $maxNewsElems + $i;

            if ($num >= max_count())
            {
                break;
            }

            $news = new News($num);

            $date = $news->getDate();
            $date = date('d.m.Y', strtotime($date));
            $title = $news->getTitle();
            $announce = $news->getAnnounce();

            print <<< _HTML_
                <form action = "NewsPage.php" method = "GET">
                    <button class = "news" type = "submit" name = "num" value = "$num">
                        <div class = "date">$date</div>
                        <p class = "title">$title</p>
                        <p class = "announce-news">$announce</p>
                        <div class = "more">ПОДРОБНЕЕ →</div>
                    </button>
                </form>
            _HTML_;
        }
        
        print <<< _HTML_
                </div>
            </div>
        _HTML_;
    }

    function printHeader()
    {
        print <<< _HTML_
            <header class = "header">
                <img src = "images\logo.png" />
                <text>
                    ГАЛАКТИЧЕСКИЙ<br>
                    ВЕСТНИК
                </text>
            </header>
        _HTML_;
    }
    function printFooter()
    {
        print <<< _HTML_
        <footer class = "footer">
            © 2023-2412 «Галактический вестник»
        </footer>
        _HTML_;
    }

    function printPages()
    {
        $maxNewsElems = 4;
        $currentPage = 0; 
               
        if (isset($_GET['page']))
        {
            $currentPage = $_GET['page'];
        }

        print <<< _HTML_
            <div class = "page-num-block">
        _HTML_;

        for ($i = 1; $i < $maxNewsElems; $i++)
        {
            print <<< _HTML_
                <form action="index.php" method="GET">
                    <button class="page-num" type="submit" name = "page" value="$i">$i</button>
                </form>
            _HTML_;
        }
        if ($currentPage * $maxNewsElems < max_count())
        {
            $nextPage = $currentPage + 1;
            print <<< _HTML_
                <form action="index.php" method="GET">
                    <button class="page-num" type="submit" name = "page" value="$nextPage">→</button>
                </form>
            _HTML_;
        }
        print <<< _HTML_
            </div>
        _HTML_;
    }

    function printContent()
    {
        $num = $_GET['num'];
        $news = new News($num);

        $title = $news->getTitle();
        $date = date('d.m.Y', strtotime($news->getDate()));
        $announce = $news->getAnnounce();
        $content = $news->getContent();
        $img = $news->getImage();

        print <<< _HTML_
            <div> 
                Главная \ $title
            </div>
            <div class = "title">$title</div>
            <div class = "date">$date</div>
            <div>
                <div>$announce</div>
                <div>$content</div>
                <img src = "images/$img" />
            </div>
            <a href = index.php class = "more"> ← Назад к новостям </a>
        _HTML_;
    }
?>