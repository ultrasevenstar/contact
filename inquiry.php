<?php
session_start();

require_once('./config.php');
require_once('./validation.php');


$inquiry = new Inquiry($forms, $validation_errors, $file_names, $mail);
$inquiry->sendMail();
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
        if(! isset($_SESSION['is_confirm']) || ! $this->validation()) {
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

        if(! $validation->isset_post()) {
            return false;
        }

        foreach($_POST as $key => $post) {
            if(! isset($this->forms[$key]['validation'])) {
                continue;
            }

            foreach($this->forms[$key]['validation'] as $v_key => $value) {
                // minとmaxの場合はkeyがvalidationのrule
                if(! is_int($v_key)) {
                    $validation_rule = $v_key;
                }else{
                    $validation_rule = $value;
                }

                if(! $validation_rule) {
                    continue;
                }

                if(! $validation->$validation_rule($post, $this->forms[$key]['label'], $value)) {
                    return false;
                }
            }
        }

        $_SESSION['validation_error'] = '';
        unset($_SESSION['validation_error']);
        return true;
    }


    public function sendMail() {
        preg_match_all('/{(.+?)}/', $this->mail['contact']['mail_contact_body'], $matches);

        foreach( $matches[1] as $key ) {
            if(preg_match("/radio\['(.+?)'\]/", $key, $matche)) {
                var_dump($matche[]);
            }
            // $_SESSION['post'][$matche];
        }
        exit;
    }
}



