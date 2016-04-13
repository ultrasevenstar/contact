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
        foreach($this->forms as $key => $form) {
            if(! in_array('required', $form['validation'])) {
                continue;
            }

            if(! isset($_POST[$key]) || !$_POST[$key]) {
                $this->setErrorMessage('required', $form['label']);
                return false;
            }
        }
        return true;
    }

    /**
     * 必須項目チェック
     * @return bool
     */
    public function required($value, $label) {
        $value = trim($value);
        if(! $value) {
            $this->setErrorMessage('required', $label);
            return false;
        }
        return true;
    }


    /**
     * メールアドレス
     * @return bool
     */
    public function mail($value, $label) {
        $value = trim($value);

        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->setErrorMessage('mail', $label);
            return false;
        }
        return true;
    }

    /**
     * 数字
     * @return bool
     */
    public function int($value, $label) {
        $value = trim($value);
        if(! preg_match('/\d/', $value)) {
            $this->setErrorMessage('int', $label);
            return false;
        }
        return true;
    }

    /**
     * 最小文字長
     * @return bool
     */
    public function min($value, $label, $limit) {
        if(mb_strlen($value) < $limit) {
            $message = str_replace('{label}', $label, $this->validation_errors['min']);
            $message = str_replace('{value}', $limit, $message);
            $_SESSION['validation_error'] = $message;
            return false;
        }
        return true;
    }

    /**
     * 最大文字長
     * @return bool
     */
    public function max($value, $label, $limit) {
        if(mb_strlen($value) > $limit) {
            $message = str_replace('{label}', $label, $this->validation_errors['max']);
            $message = str_replace('{value}', $limit, $message);
            $_SESSION['validation_error'] = $message;
            return false;
        }
        return true;
    }


    protected function setErrorMessage($type, $label) {
        $message = str_replace('{label}', $label, $this->validation_errors[$type]);

        $_SESSION['validation_error'] = $message;
    }
}



