<!DOCTYPE html>
<head>
    <meta charset="cfu-8">
    <title>mission5-1</title>
</head>
<body>
    <form action="" method="POST">
        <input type="text" name="name" placeholder="名前">
        <input type="text" name="comment" placeholder="コメント">
        <input type="text" name="cpass" placeholder="パスワード">
        <input type="submit" name="submit" value="送信">
        <br>
        <input type="text" name="delete" placeholder="削除番号">
        <input type="text" name="dpass" placeholder="パスワード">
        <input type="submit" name="submit" value="削除">
        <br>
        <input type="text" name="edit" placeholder="編集番号">
        <input type="text" name="ename" placeholder="名前">
        <input type="text" name="ecomment" placeholder="コメント">
        <input type="text" name="epass" placeholder="パスワード">
        <input type="submit" name="submit" value="編集">
        <br>
    </form>

    <?php
        $dsn=("mysql:host=localhost;dbname=データベース名");
        $user="ユーザー名";
        $password="パスワード";
        $pdo=new PDO($dsn,$user,$password,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));

        if(!empty($_POST["name"])){
            if(!empty($_POST["comment"])){
                if(!empty($_POST["cpass"])){
                    $name=$_POST["name"];
                    $comment=$_POST["comment"];
                    $cpass=$_POST["cpass"];

                    $sql="CREATE TABLE IF NOT EXISTS tbboard
                    (id INT AUTO_INCREMENT PRIMARY KEY,name char(32),comment TEXT,password TEXT);";
                    $stmt=$pdo->query($sql);

                    $sql=$pdo->prepare("INSERT INTO tbboard(name,comment,password) VALUE(:name,:comment,:password)");
                    $sql->bindParam(":name",$name);
                    $sql->bindParam(":comment",$comment);
                    $sql->bindParam(":password",$cpass);
                    $sql->execute();

                    $sql="SELECT * FROM tbboard";
                    $stmt=$pdo->query($sql);
                    $lines=$stmt->fetchAll();
                    foreach ($lines as $line){
                        echo $line["id"].",";
                        echo $line["name"].",";
                        echo $line["comment"]."<br>";
                        echo "<hr>";
                    }
                }
            }
        }elseif(!empty($_POST["comment"])){
            echo "名前を入力してください。<br>";
        }elseif(!empty($_POST["delete"])){
            $delete=$_POST["delete"];
            $dpass=$_POST["dpass"];

            $sql="DELETE FROM tbboard WHERE id=:id AND password=:password";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":id",$delete,PDO::PARAM_INT);
            $stmt->bindParam(":password",$dpass,PDO::PARAM_STR);
            $stmt->execute();
        
            $sql="SELECT * FROM tbboard";
            $stmt=$pdo->query($sql);
            $lines=$stmt->fetchAll();
            foreach ($lines as $line){
                echo $line["id"].",";
                echo $line["name"].",";
                echo $line["comment"]."<br>";
            echo "<hr>";
            }
        }elseif(!empty($_POST["edit"])){
            $edit=$_POST["edit"];
            $ename=$_POST["ename"];
            $ecomment=$_POST["ecomment"];
            $epass=$_POST["epass"];

            $sql="UPDATE tbboard SET name=:name,comment=:comment WHERE id=:id AND password=:password";
            $stmt=$pdo->prepare($sql);
            $stmt->bindParam(":id",$edit,PDO::PARAM_INT);
            $stmt->bindParam(":name",$ename,PDO::PARAM_STR);
            $stmt->bindParam(":comment",$ecomment,PDO::PARAM_STR);
            $stmt->bindParam(":password",$epass,PDO::PARAM_STR);
            $stmt->execute();
        
            $sql="SELECT * FROM tbboard";
            $stmt=$pdo->query($sql);
            $lines=$stmt->fetchAll();
            foreach ($lines as $line){
                echo $line["id"].",";
                echo $line["name"].",";
                echo $line["comment"]."<br>";
            echo "<hr>";
            }
        }else{
            echo "～使い方～<br>
            投稿する：「名前」「コメント」「パスワード」を入力して「送信」押してください。<br>
            削除する：「削除したい投稿の番号」「パスワード」を入力して「削除」を押してください。<br>
            編集する：「編集したい投稿の番号」「パスワード」を入力して「編集」を押してください。<br>";
        }
    ?>
</body>