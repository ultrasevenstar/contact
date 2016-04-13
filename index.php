<?php
session_start();

require_once('./config.php');
require_once('./helper.php');
if(!isset($_POST['is_return']) || !isset($_SESSION['validation_error'])) {
    session_destroy();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<p>
<?php if(isset($_SESSION['validation_error'])): ?>
<?php echo $_SESSION['validation_error']; ?>
<?php endif; ?>
</p>

<form method="post" action="inquiry.php">
<ul>
    <li>
        <label><?php set_label("last_name"); ?></label>
        <input type="text" name="last_name" value="<?php set_value("last_name"); ?>">
    </li>

    <li>
        <label><?php set_label("first_name"); ?></label>
        <input type="text" name="first_name" value="<?php set_value("first_name"); ?>">
    </li>

    <li>
        <label><?php set_label("kana_last_name"); ?></label>
        <input type="text" name="kana_last_name" value="<?php set_value("kana_last_name"); ?>">
    </li>

    <li>
        <label><?php set_label("kana_first_name"); ?></label>
        <input type="text" name="kana_first_name" value="<?php set_value("kana_first_name"); ?>">
    </li>

    <li>
        <label><?php set_label("tel"); ?></label>
        <input type="text" name="tel" value="<?php set_value("tel"); ?>">
    </li>

    <li>
        <label><?php set_label("mail"); ?></label>
        <input type="mail" name="mail" value="<?php set_value("mail"); ?>">
    </li>

    <li>
        <label><?php set_label("sex"); ?></label>
        <?php foreach($forms['sex']['parts'] as $value => $text): ?>
            <input type="radio" name="sex" value="<?php echo $value; ?>" <?php set_checked('sex', $value); ?>>
            <?php echo $text; ?>
        <?php endforeach; ?>
    </li>

    <li>
        <label><?php set_label("content"); ?></label>
        <textarea name="content"><?php set_value("content"); ?></textarea>
    </li>

    <li>
        <label><?php set_label("prefecture"); ?></label>
        <select name="prefecture">
            <?php buid_select_option("prefecture"); ?>
        </select>
    </li>
</ul>
<button type="submit">登録</button>
</form>
</body>
</html>