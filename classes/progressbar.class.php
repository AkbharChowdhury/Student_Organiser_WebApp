<?php
require_once '../enums/status.enum.php';

class ProgressBar
{

    public static function getPercentageData($percentageCompleted): array
    {

        $progressBarData = ProgressBar::getProgressData();
        if ($percentageCompleted == 100) return $progressBarData[Status::COMPLETE->name];
        if ($percentageCompleted >= 50) return $progressBarData[Status::IN_PROGRESS->name];
        return $progressBarData[Status::IN_COMPLETE->name];

    }

    private static function getProgressData(): array
    {
        $width = 40;
        $height = 40;
        $success = Status::COMPLETE->value;
        $warning = Status::IN_PROGRESS->value;
        $danger =  Status::IN_COMPLETE->value;

        return [
            Status::COMPLETE->name => [
                'class' => $success,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" fill="currentColor" class="bi bi-emoji-smile" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M4.285 9.567a.5.5 0 0 1 .683.183A3.498 3.498 0 0 0 8 11.5a3.498 3.498 0 0 0 3.032-1.75.5.5 0 1 1 .866.5A4.498 4.498 0 0 1 8 12.5a4.498 4.498 0 0 1-3.898-2.25.5.5 0 0 1 .183-.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
          </svg>',
                'text' => '<p class="text-' . $success  . '"><strong>Hurray, you have completed all your coursework</strong> <br>
                Tip:try proofreading your coursework using <a href="https://www.grammarly.com" class="link-success">Grammarly</a>
            </p>'
            ],

            Status::IN_PROGRESS->name => [
                'class' => $warning,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" fill="currentColor" class="bi bi-emoji-neutral" viewBox="0 0 16 16">
            <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
            <path d="M4 10.5a.5.5 0 0 0 .5.5h7a.5.5 0 0 0 0-1h-7a.5.5 0 0 0-.5.5zm3-4C7 5.672 6.552 5 6 5s-1 .672-1 1.5S5.448 8 6 8s1-.672 1-1.5zm4 0c0-.828-.448-1.5-1-1.5s-1 .672-1 1.5S9.448 8 10 8s1-.672 1-1.5z"/>
          </svg>',
                'text' => '<p class="text-' . $warning . '"><strong>You are on task, Keep going! you are almost done!</strong></p>'
            ],

            Status::IN_COMPLETE->name => [
                'class' => $danger,
                'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="' . $width . '" height="' . $height . '" fill="currentColor" class="bi bi-emoji-frown" viewBox="0 0 16 16">
        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
        <path d="M4.285 12.433a.5.5 0 0 0 .683-.183A3.498 3.498 0 0 1 8 10.5c1.295 0 2.426.703 3.032 1.75a.5.5 0 0 0 .866-.5A4.498 4.498 0 0 0 8 9.5a4.5 4.5 0 0 0-3.898 2.25.5.5 0 0 0 .183.683zM7 6.5C7 7.328 6.552 8 6 8s-1-.672-1-1.5S5.448 5 6 5s1 .672 1 1.5zm4 0c0 .828-.448 1.5-1 1.5s-1-.672-1-1.5S9.448 5 10 5s1 .672 1 1.5z"/>
      </svg>',
                'text' => '<p class="text-' . $danger . '"><strong>you need to make more effort</p>'


            ],


        ];


    }


    public static function calcPercentage($num, $total): float
    {
        return round(($num / $total) * 100);

    }


}