<?php

/*_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/ 各種ファイル名
/
_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/*/

$file_names = [
    'top' => 'index.php',
    'confirm' => 'confirm.php',
    'thanks' => 'thanks.php',
];


/*_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/ formのname属性ひも付け及びバリデーションタイプ
/
/ バリデーションの項目は現状以下
/
/ 入力必須　=> required
/ メールアドレス形式チェック => mail
/ 数値のみ => int
/ 電話番号形式チェック => tel
/  最大文字長 => max
/  最小文字長 => min
/
_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/*/

$forms = [
    'last_name' => [
        'label' => '姓',
        'validation' => ['required']
    ],
    'first_name' => [
        'label' => '名',
        'validation' => ['required']
    ],
    'kana_last_name' => [
        'label' => 'セイ',
        'validation' => ['required']
    ],
    'kana_first_name' => [
        'label' => 'メイ',
        'validation' => ['required']
    ],
    'mail' => [
        'label' => 'メールアドレス',
        'validation' => ['required', 'mail']
    ],
    'tel' => [
        'label' => '電話番号',
        'validation' => ['required', 'int']
    ],
    'sex' => [
        'label' => '性別',
        'validation' => ['required'],
        'parts' => [
            1 => '男性',
            2 => '女性'
        ]
    ],
    'content' => [
        'label' => 'お問い合わせ内容',
        'validation' => [
            'required',
            'min' => 100,
            'max' => 1000,
        ],
    ],
    'prefecture' => [
        'label' => '都道府県',
        'validation' => ['required'],
        'parts' => [
            1 => '北海道',
            2 => '青森',
            3 => '宮城'
        ]
    ]
];


/*_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/ バリデーションエラーメッセージ
/
/ {label}には上記labelの項目が入ります
/ メッセージは適宜変更可能
/
_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/*/

$validation_errors = [
    // 必須項目
    'required' => '{label}は必須です',
    // メールアドレス
    'mail' => 'メールアドレスの形式が間違っております',
    // 数値のみ
    'int' => '{label}は数字のみ入力可能です',
    // 最小文字数
    'min' => '{label}は{value}文字以上で記入してください',
    // 最大文字数
    'max' => '{label}は{value}文字以内で記入してください',
];


/*_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/
/ メール関連
/
_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/_/*/

// 送信元メールアドレス
$mail_self_from_address = 'h.yanagisawa@leihauoli.com';
// 送信元者名
$mail_self_name = '';
// メール件名
$mail_self_subject = 'お問い合わせ';
// 送信元メールアドレス
$mail_self_to_address = 'h.yanagisawa@leihauoli.com';


// 送信元メールアドレス
$mail_contact_address = 'h.yanagisawa@leihauoli.com';
// 送信元者名
$mail_contact_name = '';
// メール件名
$mail_contact_subject = 'お問い合わせ';


$mail_self_body =<<<EOF
{last_name}{first_name}様

この度はお問い合わせ頂きありがとうございます。

【お問い合わせ内容】
{$forms['last_name']['label']}:{last_name}
{$forms['first_name']['label']}:{first_name}
{$forms['kana_last_name']['label']}:{kana_last_name}
{$forms['kana_first_name']['label']}:{kana_first_name}
{$forms['sex']['label']}:{'sex'}
EOF;


$mail_contact_body =<<<EOF
{last_name}{first_name}様

この度はお問い合わせ頂きありがとうございます。

【お問い合わせ内容】
{$forms['last_name']['label']}:{last_name}
{$forms['first_name']['label']}:{first_name}
{$forms['kana_last_name']['label']}:{kana_last_name}
{$forms['kana_first_name']['label']}:{kana_first_name}
{$forms['sex']['label']}:{'sex'}
EOF;



$mail = [
    'self' =>
        compact('mail_self_from_address', 'mail_self_name', 'mail_self_subject', 'mail_self_to_address'),
    'contact' =>
        compact('mail_contact_address', 'mail_contact_name', 'mail_contact_subject', 'mail_contact_body')
];