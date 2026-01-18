<?php
// Запускаем деплой
exec('/bin/bash /home/landgrou/deploy.sh 2>&1', $output, $return_var);

// Логируем вывод
file_put_contents('/home/landgrou/deploy.log', implode("\n", $output) . "\n", FILE_APPEND);

echo "OK";
