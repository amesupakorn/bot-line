<?php 


    $header = "Testing Line Notify";
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    $message = $header.
                "\n". "ชื่อจริง: " . $firstname .
                "\n". "นามสกุล: " . $lastname .
                "\n". "เบอร์โทรศัพท์: " . $phone .
                "\n". "อีเมล์: " . $email;

    if (isset($_POST["submit"])) {
        if ( $firstname <> "" ||  $lastname <> "" ||  $phone <> "" ||  $email <> "" ) {
            sendlinemesg();
            header('Content-Type: text/html; charset=utf8');
            $res = notify_message($message);
            echo "<script>alert('สมัครสมาชิกเรียบร้อย');</script>";
            
        } else {
            echo "<script>alert('กรุณากรอกข้อมูลให้ครบถ้วน');</script>";
            
    }

    function sendlinemesg() {
        define('LINE_API',"https://notify-api.line.me/api/notify");
        define('LINE_TOKEN',"kxcOgWo5RyviSSNpF5YtoIgyDUwErumNd9h8ns6VDHU");

        function notify_message($message) {
            $queryData = array('message' => $message);
            $queryData = http_build_query($queryData,'','&');
            $headerOptions = array(
                'http' => array(
                    'method' => 'POST',
                    'header' => "Content-Type: application/x-www-form-urlencoded\r\n"
                                ."Authorization: Bearer ".LINE_TOKEN."\r\n"
                                ."Content-Length: ".strlen($queryData)."\r\n",
                    'content' => $queryData
                )
            );
            $context = stream_context_create($headerOptions);
            $result = file_get_contents(LINE_API, FALSE, $context);
            $res = json_decode($result);
            return $res;
        }
    }


?>