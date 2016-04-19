<?php
session_start();

require_once('./config.php');
require_once('./validation.php');
require_once('./PHPMailer/PHPMailerAutoload.php');

$inquiry = new Inquiry($forms, $validation_errors, $file_names, $mail);
if(IS_SHOW_CONFIRM === false) {
    $inquiry->thanks();
}

if(isset($_POST['is_thanks'])) {
    $inquiry->thanks();
} else {
    $inquiry->confirm();
}


class Inquiry
{
    public function __construct($forms, $validation_errors, $file_names, $mail) {
        $this->forms = $forms;
        $this->validation_errors = $validation_errors;
        $this->file_name = $file_names;
        $this->mail = $mail;
    }

    /**
     *  確認ページ
     */
    public function confirm() {
        if(! isset($_POST['is_return'])) {
            $_SESSION['post'] = $_POST;
        }
        if(isset($_POST['is_return']) || ! $this->validation()) {
            header("Location: ./{$this->file_name['top']}");
            exit;
        }

        $_SESSION['is_confirm'] = true;
        header("Location: ./{$this->file_name['confirm']}");
        exit;
    }

    /**
     * thankyouページ
     */
    public function thanks() {
        if(count($_POST) < 1 ) {
            header("Location: ./{$this->file_name['top']}");
            exit;
        }

        $_SESSION['post'] = $_POST;

        if(! $this->validation()) {
            header("Location: ./{$this->file_name['top']}");
            exit;
        }

        $this->sendMail();
        $_POST = [];
        $_SESSION = [];
        session_destroy();

        header("Location: ./{$this->file_name['thanks']}");
        exit;
    }


    /**
    ** validationチェック
    **/
    protected function validation() {
        $validation = new Validation($this->forms, $this->validation_errors);

        $is_error = false;

        if(! $validation->isset_post()) {
            $is_error = true;
        }


        foreach($_POST as $name => $post) {
            if(! isset($this->forms[$name]['validation'])) {
                continue;
            }

            // 設定されているバリデーションを先頭よりチェック。エラーの場合は次のpostに移動
            foreach($this->forms[$name]['validation'] as $key => $value) {
                // minとmaxの場合はkeyがvalidationのrule
                if(! is_int($key)) {
                    $validation_rule = $key;
                }else{
                    $validation_rule = $value;
                }

                if(! $validation_rule) {
                    continue;
                }

                if(! $validation->$validation_rule($post, $name, $value)) {
                    $is_error = true;
                    break;
                }
            }
        }

        if(!$is_error) {
            $_SESSION['validation_error'] = '';
            unset($_SESSION['validation_error']);
            return true;
        }

        return false;
    }


    /**
     *  メール送信
     */
    protected function sendMail() {
        mb_language('japanese');
        mb_internal_encoding('utf-8');

        foreach($this->mail as $key => $mail) {
            // var_dump($mail);
            // exit;
            $mail_body = $this->buildMailBody($mail['body']);
            mb_send_mail($mail['from_address'], $mail['subject'], $mail_body);
        }
        return true;
    }


    protected function buildMailBody($mail_body) {

        // radio select checkbox用値からテキスト変換関数
        $getTextForValue = function($key) {
            if(! is_array($_SESSION['post'][$key]) && isset($_SESSION['post'][$key])) {
                return $this->forms[$key]['parts'][$_SESSION['post'][$key]];
            }elseif(! is_array($_SESSION['post'][$key]) && ! isset($_SESSION['post'][$key])) {
                return;
            }

            $text = [];
            foreach($_SESSION['post'][$key] as $value) {
                if(isset($this->forms[$key]['parts'][$value])) {
                    $text[] = $this->forms[$key]['parts'][$value];
                }
            }
            return implode('/', $text);
        };


        preg_match_all('/{(.+?)}/', $mail_body, $matches);

        foreach( $matches[1] as $key ) {
            if(! isset($_SESSION['post'][$key])) {
                continue;
            }
            $value = $_SESSION['post'][$key];
            if(isset($this->forms[$key]['parts'])) {
                $value = $getTextForValue($key);
            }
            $search = '{' . $key . '}';
            $mail_body = preg_replace("/$search/", $value, $mail_body);
        }
        return $mail_body;
    }

}



