<?php
declare(strict_types=1);

\think\Console::starting(function (\think\Console $console) {
    $console->addCommands([
        'sms:config' => '\\aliyun\\sms\\command\\SendConfig'
    ]);
});