<?php
session_start();

require_once('./config.php');
require_once('./helper.php');

check_show_confirm();
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<ul>
    <li>
        <label><?php set_label("last_name"); ?></label>
        <span><?php set_value("last_name"); ?></span>
    </li>
    <li>
        <label><?php set_label("first_name"); ?></label>
        <span><?php set_value("first_name"); ?></span>
    </li>
    <li>
        <label><?php set_label("kana_last_name"); ?></label>
        <span><?php set_value("kana_last_name"); ?></span>
    </li>
    <li>
        <label><?php set_label("kana_first_name"); ?></label>
        <span><?php set_value("kana_first_name"); ?></span>
    </li>
    <li>
        <label><?php set_label("mail"); ?></label>
        <span><?php set_value("mail"); ?></span>
    </li>
    <li>
        <label><?php set_label("sex"); ?></label>
        <p><?php set_text_for_value("sex"); ?></p>
    </li>
    <li>
        <label><?php set_label("prefecture"); ?></label>
        <p><?php set_text_for_value("prefecture"); ?></p>
    </li>
</ul>

<form method="post" action="inquiry.php">
    <input type="hidden" name="is_return" value="1">
    <button type="submit">戻る</button>
</form>

<form method="post" action="inquiry.php">
    <input type="hidden" name="is_thanks" value="1">
<?php foreach($_SESSION['post'] as $key => $post): ?>
    <input type="hidden" name="<?php echo $key; ?>" value="<?php echo $post; ?>">
<?php endforeach; ?>
    <button type="submit">登録</button>
</form>

</body>
</html>