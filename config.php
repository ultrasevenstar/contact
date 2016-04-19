<?php
const IS_SHOW_CONFIRM = false;

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
        'validation' => ['required', 'tel']
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
    // 電話番号
    'tel' => '電話番号の形式が間違っております',
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
// // SMPTサーバー名
// $smtp_host = ''
// // SMTPポート番号
// $smtp_port = '587';
// // SMTP接続ユーザー名
// $smtp_user = 'hoge@hoge.com';
// // SMTP接続ユーザー名
// $smtp_password = '';

$mail_self_body =<<<EOF
{last_name}{first_name}様

この度はお問い合わせ頂きありがとうございます。

【お問い合わせ内容】
{$forms['last_name']['label']}:{last_name}
{$forms['first_name']['label']}:{first_name}
{$forms['kana_last_name']['label']}:{kana_last_name}
{$forms['kana_first_name']['label']}:{kana_first_name}
{$forms['sex']['label']}:{sex}
EOF;


$mail_contact_body =<<<EOF
{last_name}{first_name}様

この度はお問い合わせ頂きありがとうございます。

【お問い合わせ内容】
{$forms['last_name']['label']}:{last_name}
{$forms['first_name']['label']}:{first_name}
{$forms['kana_last_name']['label']}:{kana_last_name}
{$forms['kana_first_name']['label']}:{kana_first_name}
{$forms['sex']['label']}:{sex}
EOF;


$mail = [
    // 自社送信用メール設定
    'self' => [
        'from_address' => 'hoge@hoge.com',
        'from_name' => '名前',
        'to_address' => 'hoge@hoge.com',
        'subject'   => '件名',
        'cc' => ['hoge@hoge.hoge', 'hogehoge@hoge.hoge'],
        'bcc' => ['hoge@hoge.hoge', 'hogehoge@hoge.hoge'],
        'body' => $mail_self_body,
    ],
    'contact' => [
        'from_address' => 'hoge@hoge.com',
        'from_name' => '',
        'subject'   => '件名',
        'cc' => ['hoge@hoge.hoge', 'hogehoge@hoge.hoge'],
        'bcc' => ['hoge@hoge.hoge', 'hogehoge@hoge.hoge'],
        'body' => $mail_contact_body,
    ],
];
