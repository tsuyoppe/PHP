<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8" />
  <title>掲示板</title>
  <link rel="stylesheet" type="text/css" href="bulletin_board.css">
</head>
<body>
  <?php


  if($_SERVER['SERVER_NAME'] == "localhost") {
    //ローカルの接続設定
    $mysqli = new mysqli('localhost', 'root', '', 'datas');
  } else {
    //XREAサーバの接続設定
    $mysqli = new mysqli('localhost', 'tsuyoppe', 'password', 'tsuyoppe');
  }
    //プリペアドステートメントを作成　ユーザ入力を使用する箇所は?にしておく
  $stmt = $mysqli->prepare("INSERT INTO datas (name,email,title, message) VALUES (?, ?, ?, ?)");
    //$_POST["name"]に名前が、$_POST["email"]にメールアドレスが、$_POST["title"]にタイトルが、$_POST["message"]に本文が格納される。
    //?の位置に値を割り当てる
  $stmt->bind_param('ssss', $_POST["name"], $_POST["email"],$_POST["title"],$_POST["message"]);
    //実行     
  $stmt->execute();

    //datasテーブルから日付の降順でデータを取得
  $result = $mysqli->query("SELECT * FROM datas ORDER BY created DESC");
  

  if($result){
      //1行ずつ取り出し
    while($row = $result->fetch_object()){
      //エスケープして表示
     $name = htmlspecialchars($row->name);
     $email = htmlspecialchars($row->email);
     $title = htmlspecialchars($row->title);
     $message = htmlspecialchars($row->message);
     $created = htmlspecialchars($row->created);

     echo nl2br("<div id=\"sheet\">名前: $name | タイトル:$title | 時間:($created)<br>本文:$message<br><HR></div>");
   }
 }
 print("<HR>") ;

 $date = date("Y/m/d H:i:s");
 print($date);
      //nameがPOSTされているなら
 if(isset($_POST["name"])){
        //エスケープしてから表示
  $name = htmlspecialchars($_POST["name"]);
  print("あなたの名前は「 ${name} 」です。<br />");
  }

      //emailがPOSTされているなら
  if(isset($_POST["email"])){
        //エスケープしてから表示
    $email = htmlspecialchars($_POST["email"]);
    print("あなたのEmailは「 ${email} 」です。<br />");
  }

      //titleがPOSTされているなら
    if(isset($_POST["title"])){
        //エスケープしてから表示
      $title = htmlspecialchars($_POST["title"]);
      print("あなたのタイトルは「 ${title} 」です。<br />");
    } 

      //message(本文)がPOSTされているなら
      if(isset($_POST["message"])){
        //エスケープしてから表示
        $message = htmlspecialchars($_POST["message"]);
        print("あなたの本文は「 ${message} 」です。<br />");
      }


        ?>

        
        <form action="post.php" method="post">
         <dl>
          <dt><label for="name">名前：<span>Your Name</span></label></dt>
          <dd><input type="text" id="name" name="name" value="" required /><div></div></dd>
          <dt><label for="email">メールアドレス：<span>Email</span></label></dt>
          <dd><input type="email" id="email"name="email" value="" required /><div></div></dd>
          <dt><label for="title">タイトル:<span>Title</span></label></dt>
          <dd><input type="text" id="title" name="title" value="" required /><div></div></dd>
          <dt><label for="message">本文:<span>Write message</span></label></dt>
          <dd><textarea type="text" id="message" name="message" cols="40" rows="5" required /></textarea><div></div></dd>      
          <dd><input type="submit" name="submit_botton" value="送信" class="submit_button" />
            <input type="reset" name="reset_botton" value="リセット" class="reset_button" /></dd>
          </dl>
        </form>
      </body>
      </html>