<?php


/**
 * Class Validation
 */
class Validation
{
    public function __construct($forms, $validation_errors) {
        $this->forms = $forms;
        $this->validation_errors = $validation_errors;
    }

    /**
     * 必須項目チェック
     * @return bool
     */
    public function isset_post() {
        $is_error = false;
        foreach($this->forms as $key => $form) {
            if(! in_array('required', $form['validation'])) {
                continue;
            }

            if(! isset($_POST[$key]) || !$_POST[$key]) {
                $this->setErrorMessage('required', $key);
                $is_error = true;
            }
        }
        return $is_error === false;
    }


    /**
     * 必須項目チェック
     * チェックはisset_postにて対応
     * @return bool
     */
    public function required($value, $key) {
        return true;
    }


    /**
     * メールアドレス
     * @return bool
     */
    public function mail($value, $key) {
        $value = trim($value);

        if(! $value) {
            return true;
        }

        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->setErrorMessage('mail', $key);
            return false;
        }
        return true;
    }

    /**
     * 数字
     * @return bool
     */
    public function int($value, $key) {
        $value = trim($value);

        if(! $value) {
            return true;
        }

        if(! preg_match('/\d/', $value)) {
            $this->setErrorMessage('int', $key);
            return false;
        }
        return true;
    }

    /**
     * 最小文字長
     * @return bool
     */
    public function min($value, $key, $limit) {
        if(! $value) {
            return true;
        }

        if(mb_strlen($value) < $limit) {
            $this->setErrorMessage('min', $key, $limit);
            return false;
        }
        return true;
    }

    /**
     * 最大文字長
     * @return bool
     */
    public function max($value, $key, $limit) {
        if(! $value) {
            return true;
        }

        if(mb_strlen($value) > $limit) {
            $this->setErrorMessage('max', $key, $limit);
            return false;
        }
        return true;
    }


    /**
     * 電話番号
     * @return bool
     */
    public function tel($value, $label) {
        if(! $value) {
            return true;
        }

        $value = trim($value);

        if(! preg_match('/\d/', $value) && ! preg_match('/\A\d{2,4}+-\d{2,4}+-\d{4}\z/', $value)) {
            $this->setErrorMessage('tel', $label);
            return false;
        }
        return true;
    }

    protected function setErrorMessage($type, $key, $value = '') {
        $message = str_replace('{label}', $this->forms[$key]['label'], $this->validation_errors[$type]);

        if($value) {
            $message = str_replace('{value}', $value, $message);
        }

        if(! isset($_SESSION['validation_error']['tel'])) {
            $_SESSION['validation_error'][$key] = [];
        }

        $_SESSION['validation_error'][$key][] = $message;
    }
}



