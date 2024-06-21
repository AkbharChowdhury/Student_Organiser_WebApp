<?php

readonly class Breadcrumb
{
    public function __construct(private string|null $title = null)
    {
    }

    private function createText($text): void
    {
        ?>
        <li class="breadcrumb-item active" aria-current="page">
            <?= Helper::titleCase($text) ?>
        </li>
        <?php

    }


    private function createLink(string $url, string $text, bool $isActive = false): void
    {

        ?>

        <?php if ($isActive): ?>
        <li class="breadcrumb-item active" aria-current="page"><a href="<?= $url ?>"><?= Helper::titleCase($text) ?></a>
        </li>
    <?php else: ?>
        <li class="breadcrumb-item"><a href="<?= $url ?>"><?= Helper::titleCase($text) ?></a></li>
    <?php endif; ?>
        <?php

    }


    public function createBreadcrumb(string $url, string $text): void
    {
        ?>




        <div class="container">
            <div class="pt-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">

                        <?php $this->createLink(url: FILE_PATH['dashboard'], text: 'home'); ?>
                        <?php $this->createLink(url: $url, text: $text, isActive: !isset($this->title)); ?>
                        <?php if (isset($this->title)): ?>
                            <?php $this->createText($this->title); ?>
                        <?php endif; ?>

                    </ol>
                </nav>
            </div>
        </div>

        <?php

    }


}