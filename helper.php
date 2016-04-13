<?php
require_once('./config.php');

/**
 * labelタグ用テキスト表示
 * @param $name
 */
function set_label($name) {
    global $forms;
    if(! isset($forms[$name]['label'])) {
        return;
    }
    echo $forms[$name]['label'];
}

/**
 * input text / textarea 入力済み値表示
 * @param $name
 */
function set_value($name) {
    if(! isset($_SESSION['post'][$name])) {
        return;
    }
    echo htmlspecialchars($_SESSION['post'][$name]);
}

/**
 * input radio / input checkbox 選択済み値表示
 * @param $name
 * @param $value
 */
function set_checked($name, $value) {
    if(! isset($_SESSION['post'][$name]) || $_SESSION['post'][$name] != $value) {
        return;
    }
    echo 'checked';
}

/**
 * 確認ページテキスト表示
 * @param $name
 */
function set_text($name) {
    if(! isset($_SESSION['post'][$name])) {
        return;
    }

    echo nl2br(htmlspecialchars($_SESSION['post'][$name]));
}

/**
 * 確認ページ ラジオボタンの選択値からテキスト表示
 * @param $name
 */
function set_text_for_value($name) {
    global $forms;

    if(! isset($_SESSION['post'][$name]) ||
        ! isset($forms[$name]['parts'][$_SESSION['post'][$name]])) {
        return;
    }

    echo $forms[$name]['parts'][$_SESSION['post'][$name]];
}

/**
 * optionタグ作成
 * @param $name
 */
function buid_select_option($name) {
    global $forms;

    $options = '';

    foreach($forms[$name]['parts'] as $key => $value) {
        $options .= "<option value=\"{$key}\"" . is_selected($name, $key) . ">{$value}</option>";
    }
    echo $options;
}

/**
 * optionタグのselected判定
 * @param $name
 */
function is_selected($name, $value) {
    global $forms;

    if(! isset($_SESSION['post'][$name]) ||
        $_SESSION['post'][$name] != $value) {
        return;
    }
    return 'selected';
}

/**
 * optionタグのselected判定
 * @param $name
 */
function set_error_messages() {
    global $forms;

    if(! isset($_SESSION['post'][$name]) ||
        $_SESSION['post'][$name] != $value) {
        return;
    }
    return 'selected';
}
