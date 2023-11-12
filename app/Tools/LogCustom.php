<?php

namespace App\Tools;

use Illuminate\Support\Str;

class LogCustom
{
    private static function getRouteLogs(string $fileName): string
    {
        $fileName = Str::replace('.log', '', $fileName);

        return  __DIR__."/../../storage/logs/$fileName.log";
    }

    /**
     * Method searchFilesLogs
     *
     * @return array<string>
     */
    private static function searchFilesLogs(): array
    {
        $route = Str::replace('/void.log', '', self::getRouteLogs('void'));
        $files = [];
        if ($handler = opendir($route)) {
            while (false !== ($file = readdir($handler))) {
                if (! in_array($file, ['.', '..', '.gitignore'])) {
                    $files[] = $file;
                }
            }
            closedir($handler);
        }

        return $files;
    }

    public static function main(\Throwable $e, string $tittle, $filename = '', $level = 'ERROR'): void
    {
        $fileName = $filename ?? 'logErros';
        $date = now();
        $env = env('APP_ENV').".$level:";
        $msj = $e->getMessage();
        $code = $e->getCode();

        if ($level == 'INFO') {
            try {
                $msj = json_decode($msj, true);
            } catch (\Throwable $th) {}
        }

        $message = json_encode([ "message" => $msj ]);
        $save = "[$date] $env $tittle $message \n";
        if ($code > 0) {
            $messageYcodeError = json_encode(["message" => $msj, "code" => $code ]);
            $save = "[$date] $env $tittle $messageYcodeError \n";
        }
        else if (in_array($level, ['WARNING', 'ERROR'])) {
            $messageYorigin = json_encode(["message" => $msj, 'origin' => $e->getFile().', Line: '.$e->getLine() ]);
            $save = "[$date] $env $tittle $messageYorigin \n";
        }
        $route = self::getRouteLogs($fileName);
        if ($fp = fopen($route, 'a')) {
            fwrite($fp, $save);
            fclose($fp);
        }
    }

    private static function getLog(string $fileName): string
    {
        $route = self::getRouteLogs($fileName);

        return (string)file_get_contents($route);
    }

    /**
     * Method getAllApiLogs
     *
     * @return array<array<string, string>>
     */
    public static function getAllApiLogs(): array
    {
        $allLogs = self::searchFilesLogs();
        $dataLogs = [];
        foreach ($allLogs as $log) {
            if ($value = self::getLog($log)) {
                $data = [
                    'value' => $value,
                    'fileName' => $log,
                ];
                $dataLogs[] = $data;
            }
        }

        return $dataLogs;
    }
}
