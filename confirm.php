<?php
ini_set('display_errors', true);
error_reporting(E_ALL);

$company = '';
$name = '';
$email = '';
$comment = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $company = $_POST["company"];
  $name = $_POST["name"];
  $email = $_POST["email"];
  $comment  = $_POST["comment"];
}

$pattern = '/\A([a-z0-9_\-\+\/\?]+)';
$pattern .= '@([a-z0-9\-]+\.)+[a-z]{2,6}\z/i';


if (!preg_match($pattern, $email)) {
  $err = '';
} else {
  $err = 'メールアドレスの形式が違います。';
}
if (!isset($err)) {
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");
  $user_name = $name;
  $to = $email;
  $subject = 'お問い合わせありがとうございます。';

  $comment = <<<EOM

  {$company}
  {$name}さん、
  お問い合わせ内容：
  {$comment}

EOM;

  $headers = 'From: xxx@xxx' . "\r\n";

  if (mb_send_mail($email, $subject, $comment, $headers) === FALSE) {
    $message = 'メール送信に失敗しました。';
  } else {
    $message = 'お問い合わせを受け付けました。確認メールを送信しております。';
  }
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>株式会社EARTH</title>
  <meta name="description" content="架空のコーポレートサイトです。" />
  <link rel="stylesheet" href="css/reset.css">
  <link rel="stylesheet" href="css/common.css">
  <link rel="stylesheet" href="css/confirm.css" />
  <link rel="icon" type="image/x-icon" href="atlas.ico">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
</head>

<body>
  <!-- header -->
  <header class="header">
    <h1 class="header-ttl">
      <a href="index.html">
        <i class="fas fa-atlas"> EARTH</i>
      </a>
    </h1>
    <nav class="header-nav">
      <ul class="header-nav-list">
        <li class="header-nav-item"><a href="index.html">ホーム</a></li>
        <li class="header-nav-item"><a href="service.html">事業内容</a></li>
        <li class="header-nav-item"><a href="blog.html">社員ブログ</a></li>
        <li class="header-nav-item"><a href="company.html">会社概要</a></li>
        <li class="header-nav-item"><a href="recruit.html">採用情報</a></li>
        <li class="header-nav-item"><a href="contact.html">お問い合わせ</a></li>
      </ul>
    </nav>
    <div class="menu" id="menu">
      <span class="menu-line-top"></span>
      <span class="menu-line-middle"></span>
      <span class="menu-line-bottom"></span>
    </div>
    <nav class="drawer-nav" id="drawer-nav">
      <ul class="drawer-nav-list">
        <li class="drawer-nav-item"><a href="index.html">ホーム</a></li>
        <li class="drawer-nav-item"><a href="service.html">事業内容</a></li>
        <li class="drawer-nav-item"><a href="blog.html">社員ブログ</a></li>
        <li class="drawer-nav-item"><a href="company.html">会社概要</a></li>
        <li class="drawer-nav-item"><a href="recruit.html">採用情報</a></li>
        <li class="drawer-nav-item"><a href="contact.html">お問い合わせ</a></li>
      </ul>
    </nav>
  </header>
  <!-- header end -->
  <div class="confirm-wrap">
    <div class="content-confirm">
      <h1 class="ttl">お問い合わせ内容確認</h1>
    </div>
    <div class="confirm">
      <ul>
        <!-- contact.htmlから受け取った値を表示 -->
        <li>
          <span>会社名</span>
          <?php echo $company; ?>
        </li>
        <li><span>名前</span>
          <?php echo $name; ?>
        </li>
        <li><span>メールアドレス</span>
          <?php echo $email; ?>
        </li>
        <li><span>お問い合わせ内容</span>
          <?php echo $comment; ?>
        </li>
      </ul>
    </div>

    <h3 class="center">上記の内容でお間違いがなければ、送信ボタンを押してください。</h3>
    <!-- 送信方法 -->
    <form action="thanks.php" method="POST">
      <div>
        <!-- 送り先に届けるために「見えないデータ」として、会社名、名前、メールアドレス、お問い合わせ内容を配置 -->
        <input type="hidden" name="company" value="<?php echo $company; ?>">
        <input type="hidden" name="name" value="<?php echo $name; ?>">
        <input type="hidden" name="email" value="<?php echo $email; ?>">
        <input type="hidden" name="comment" value="<?php echo $comment; ?>">
        <input type="button" class="back" onclick="history.back()" value="変更する">
        <input type="submit" class="submit" value="送信">
      </div>
    </form>
  </div>
  <script src="js/main.js"></script>
</body>

</html>